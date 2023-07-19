<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Hash;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Applications Controller
 *
 */

class ApplicationsController extends AppController
{


    private $data = array();


    public function initialize(): void
    {
        parent::initialize();

        $this->data = $this->request->getData();
    }

    public function sendConfirmationEmail()
    {
        $seller = $this->Auth->user();
        $hashed_value = $seller['hash'] ? $seller['hash'] : md5($seller['id'] . uniqid() . md5($seller['email'] . $_SERVER['HTTP_USER_AGENT']));

        $url = '<a href="' . Router::url('/applications/confirm_email/' . $hashed_value, true) . '" >Click Here</a>';
        $un_replace = array(
            '{%first_name%}' => $seller['first_name'],
            '{%last_name%}' => $seller['last_name'],
            '{%confirmation_url%}' => $url
        );
        $seller['email'] = 'developerae@thesitefactory.com.au';
        $application = $this->Applications->find()->where(["id" => $seller['id']])->first();
        $application->hash = $hashed_value;
        $this->Applications->save($application);

        $this->sendEmail($seller['email'], false, 'seller.re-confirm-email-address', $un_replace, []);

        $this->Flash->success(__('The confirmation email has been sent.'));

        return $this->redirect(['action' => 'profile']);
    }

    public function confirmEmail($confirm_code = false)
    {

        if ($confirm_code) {

            $confirm_code = preg_replace('/\s+/', ' ', $confirm_code);
            $confirm_code = str_ireplace(' ', '', $confirm_code);
        }
        $application = $this->Applications->find()->where(["hash" => $confirm_code])->first();

        if (isset($_GET['test'])) {
            echo $confirm_code . '</br >';
            debug($application);
            die;
        }

        if (!$application) {
            $this->Flash->error('Invalid security code', 'Errormessage');
            $this->redirect('/');
        }
        $application->email_confirmed = true;
        $application->confirmed = true;
        $application->active = true;
        if ($this->Applications->save($application)) {

            // $this->Auth->setApplication($application->toArray());

            $this->Session->write('application', $application->toArray());
            $this->Flash->success('Email Confirmed', 'Sucmessage');
            // $this->admin_loginas($this->Applications->id);
            $this->redirect('/application');
        }
        $this->redirect('/');
    }


    public function index()
    {

        $conditions = $this->_filter_params();

        $applications = $this->paginate($this->Applications, ['conditions' => $conditions/*, 'contain' => ['Un']*/]);
        // foreach ($applications as $id => $application) {
        //     $application->application_group_name = $application->application_group->title;
        // }
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('applications', 'parameters'));
        $this->formCommon();
    }


    public function formCommon()
    {
        // $this->loadModel('ApplicationGroups');
        // $applicationGroups =  $this->ApplicationGroups->find('list', array('keyField' => 'id', 'valueField' => 'title'));
        // $this->set(compact('applicationGroups'));
    }

    public function saveApp()
    {

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
        }
        $this->set('bodyClass', '');




        $applicationData = $this->Auth->user();

        $return                          = [];

        $msg = $this->getSnippet('application_register_success');
        // dd($applicationData);
        if ($applicationData) {
            if ($this->request->is('ajax')) {
                $return['url']    = "/application";
                $return['status']  = 1;

                $return['message'] = $msg;
                $return['type']    = 'login';
                $return['title'] = 'Thank You';
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This application already exist!!'))));
            } else {

                $this->Flash->success(__('Welcome'));
                $this->redirect('/application');
            }
        }
        // Configure::write('debug', false);

        $applicationEntity = $this->Applications->newEmptyEntity();
        $validation                      = ['validate' => 'register'];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->data = $this->request->getData();
            $existed_application = $this->Applications->find()->where(["email" => $this->data['email']])->first();

            if ($existed_application) {
                if ($this->request->is('ajax')) {
                    die(json_encode(array('status' => 'failed', 'message' => __('This application already exist!!'))));
                } else {

                    $this->Flash->error(__('This application already exist!!'));
                }
            } else {
                $this->data['bd'] = implode('-', [$this->data['year'], $this->data['month'], $this->data['day']]);
                $applicationEntity = $this->Applications->patchEntity($applicationEntity, $this->data, $validation);

                if ($this->Applications->save($applicationEntity)) {
                    $id = $applicationEntity->id;

                    $application = $this->Applications->get($id);

                    $to = $application['email'];

                    $from    = $this->g_configs['basic']['txt.send_mail_from'];
                    $replace = array(
                        '{%first_name%}' => $application['first_name'],
                        '{%last_name%}'  => $application['last_name'],
                        '{%applicationname%}'  => $application['applicationname'],
                        '{%email%}'  => $application['email'],
                        '{%mobile%}'  => $application['mobile'],
                    );
                    $this->sendEmail($to, $from, 'application.notify_application_registration', $replace);
                    $url = '<a href="' . Router::url('/admin/applications/edit/' . $application['id'], true) . '" >View</a>';
                    $replace['{%view_link%}'] = $url;
                    $this->sendEmail($to, $from, 'admin.notify_application_registration', $replace);

                    $return['url']    = "/application";
                    $return['status']  = 1;
                    $return['message'] = $msg;
                    $return['type']    = 'register';
                    $return['title'] = 'Thank You';
                    $return['url_text'] = 'Continue';

                    $this->Auth->setApplication($application->toArray());
                    // die(json_encode($return));
                } else {

                    // dd($applicationEntity->getErrors());


                    $return['url']    = "/application";
                    $return['status']  = 0;
                    $return['validationErrors']  = $applicationEntity->getErrors();
                    $return['message'] = 'Invalid credentials, try again';

                    // $return['message'] = $this->getSnippet('application_register_error');
                    $return['type']    = 'register';
                    $return['title'] = 'Info';

                    // die(json_encode($return));
                }

                // dd($return);

                if ($this->request->is('ajax')) {
                    echo json_encode($return);
                    exit();
                } else {
                    if ($return['status']) {
                        $this->Flash->success(__($return['message']));
                        $this->redirect('/application');
                    } else {

                        $this->Flash->error(__($return['message']));
                    }
                }
            }
        }


        $this->set('application', $applicationEntity);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('countriesList', $countriesList);



        $this->loadModel('Courses');
        $courses = $this->Courses->find('list', [
            'keyField' => 'id', 'valueField' => 'course_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('courses', $courses->toArray());

        $this->set('studyLevels', $this->Courses->studyLevels);

        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1, 'show_in_search' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('services', $services);

        // $this->redirect('/');
    }

    public function profile()
    {


        $application = $this->Auth->user();
        $application = $this->Applications->get($application['id']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sent_data = $this->request->getData();
            $application = $this->Applications->patchEntity($application, $this->request->getData(), ['validate' => 'profile']);

            if (!empty($sent_data['password']) && !empty($sent_data['passwd']) && $sent_data['password'] == $sent_data['passwd']) {
                $application->password = $sent_data['password'];
            } else {
                $application->password = "";
                unset($application->password);
            }
            if (empty($application->applicationname))
                $application->applicationname = $application->email;

            if ($this->Applications->save($application)) {
                $this->Flash->success(__('The profile date has been saved.'));

                return $this->redirect(['action' => 'accountInfo']);
            }

            // dd($application->getErrors());
            $this->Flash->error(__('The profile data could not be saved. Please, try again.'));
        }
        $this->set(compact('application'));
        // $this->set('application', $applicationEntity);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('countriesList', $countriesList);



        $this->loadModel('Courses');
        $courses = $this->Courses->find('list', [
            'keyField' => 'id', 'valueField' => 'course_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('courses', $courses->toArray());

        $this->set('studyLevels', $this->Courses->studyLevels);

        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1, 'show_in_search' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('services', $services);
    }
}
