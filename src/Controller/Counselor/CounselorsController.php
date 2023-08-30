<?php

declare(strict_types=1);

namespace App\Controller\Counselor;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Exception;

/**
 * Counselors Controller
 *
 */

class CounselorsController extends AppController
{


    private $data = array();


    public function initialize(): void
    {
        parent::initialize();

        $this->data = $this->request->getData();
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null
     */
    public function login()
    {


        // $this->loadComponent('Auth');
        $counselorData = $this->Auth->user();
        // debug($_SESSION);

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
            $this->autoRender = false;
        }
        $msg = $this->getSnippet('counselor_login_success');
        // $popup_image = $this->getSnippet_image('counselor_login_success');
        if ($counselorData) {

            $return['url']    = "/counselor";
            $return['status']  = 1;
            // $return['message'] = 'Success';
            $return['message'] = $msg;
            // $return['popup_image'] = $popup_image;
            $return['type']    = 'login';
            $return['title'] = 'Thank You';

            if ($this->request->is('ajax')) {
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This counselor already exist!!'))));
            } else {

                // $this->Flash->success(__('Welcome'));
                $this->redirect('/counselor');
            }
        }


        $return = [];
        $return['message'] = 'Invalid credentials, try again';
        $return['type']    = 'login';
        $return['status']  = 0;
        $return['title'] = 'Error';
        // $return['url_text'] = 'Back';
        if ($this->request->is('post')) {

            $p_data = $this->request->getData();
            $uuu = $this->Counselors->find()->where(['email' => $p_data['email']])->first();
            // debug($uuu);
            // debug($p_data);
            // $p_data['password'] = (new \Cake\Auth\DefaultPasswordHasher())->hash($p_data['password']);


            $red_url = "/counselor/profile";
            if (!empty($p_data["from_url"])) {
                $red_url = $p_data["from_url"];
            }

            $counselor = $this->Auth->identify();

            // dd($counselor);
            if ($counselor) {


                $return['url']    = $red_url;
                $return['url_text'] = 'Continue';
                $return['status']  = 1;
                $return['title'] = 'Thank You';
                // $return['message'] = 'Success';
                $return['message'] = $msg;
                // $return['popup_image'] = $popup_image;
                $return['type']    = 'login';
                if (!$counselor['confirmed'] || !$counselor['active']) {

                    $return['status']  = 0;
                    $return['title'] = 'Email not Confirmed';
                    $return['message'] = 'Email not Confirmed';
                } else {
                    $this->Auth->setUser($counselor);
                }

                // $this->loadModel('Subscriptions');
                // $subscription = $this->Subscriptions->find()->where([
                //     'Subscriptions.counselor_id' => $counselor['id'],
                //     'end_date >=' => date('Y M d'),
                //     'expired' => 0,
                //     'status' => 1
                // ])->first();

                // if (!empty($subscription)) {
                //     $this->Session->write('is_subscribed', $subscription);
                //     $this->set('is_subscribed', $subscription);
                // } else {
                //     $this->Session->delete('is_subscribed');
                //     // debug($this->getSnippet('subscription_play_video_message'));
                //     // $this->set('subscriptionMsg', $this->getSnippet('subscription_play_video_message'));
                // }
                // echo $this->data['from_url'];die("-----------");
                // if (!empty($this->data['from_url']) && $this->data['from_url'] == "checkout") {
                //     $return['url']    = "/checkout";
                // }
            } else {

                $msg = $this->getSnippet('counselor_login_error');
                // $popup_image = $this->getSnippet_image('counselor_login_success');
                $return['message'] = $msg;

                $return['status']  = 0;
                // $return['popup_image'] = $popup_image;
            }


            if ($this->request->is('ajax')) {
                echo json_encode($return);
                exit();
            } else {
                if ($return['status']) {
                    $this->Flash->success(__($return['message']));
                    $this->redirect('/counselor');
                } else {

                    $this->Flash->error(__($return['message']));
                    $this->redirect('/counselor/login');
                }
            }
        }

        // $this->redirect('/counselor');
        // $this->redirect('/');
    }

    public function resetPassword($hash_data = false)
    {

        // $this->viewBuilder()->disableAutoLayout();

        // $this->layout = false;
        if (!$hash_data) {
            $this->Flash->error(__('Wrong Data', true));
            $this->redirect('/');
        }
        $counselor = $this->Counselors->find()->where(['hash' => $hash_data])->first();
        if (empty($counselor)) {
            $this->Flash->error(__('Wrong Data', true));
            $this->redirect('/');
        }

        if ($this->request->is('post')) {
            // $counselor = $this->Counselors->patchEntity($counselor, $this->request->getData());
            $data = $this->request->getData();
            $counselor->password = $data['password'];
            $this->Counselors->save($counselor);
            // dd($data);
            $this->redirect('/counselor');
        }
    }

    public function forgotPasswordSuccess()
    {
        // $this->viewBuilder()->disableAutoLayout();
    }
    public function forgotPassword()
    {
        // $this->viewBuilder()->disableAutoLayout();
        // Configure::write('debug', false);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $counselor = $this->Counselors->find()->where(['email' => $data['email']])->first();

            if (!empty($counselor)) {

                // $new_passowrd   = substr(md5(rand() . ''), 0, 6);

                // $counselor->password = $new_passowrd;
                $id = $counselor['id'];
                $hashed_value = $counselor['hash'];
                if (empty($hashed_value) || $hashed_value == null) {
                    $hashed_value = md5($id . uniqid() . md5($counselor['email'] . $_SERVER['HTTP_USER_AGENT']));
                }
                $counselor->hash = $hashed_value;
                $counselor->hash_created_date = date('Y-m-d H:i:s');
                // dd($counselor);
                if ($this->Counselors->save($counselor, ['validate' => false])) {
                    $to = $counselor['email'];
                    $from = '';

                    $url = Router::url('/counselor/reset-password/' . $hashed_value, true);
                    $replace = array(
                        '{%first_name%}' => $counselor['first_name'],
                        '{%last_name%}' => $counselor['last_name'],
                        '{%new_password%}' => '<a href="' . $url . '">Click Here</a>',
                    );

                    $this->sendEmail($to, false, 'counselor.notify_counselor_reset_password', $replace);
                    $this->Flash->success('Your new password reset link has been sent to your email');
                    $this->redirect('/counselor/forgot-password-success');
                } else {

                    $this->Flash->error('Could not reset your password..');
                    $this->redirect('/counselor/forgot-password');
                }
            } else {
                $this->Flash->error('This email is not exsist!');
                $this->redirect('/counselor/forgot-password');
            }
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response
     */
    public function logout()
    {

        // 

        // $this->Session->delete('Counselor');
        return $this->redirect($this->Auth->logout());
    }

    public function loginAs($id)
    {
        $this->autoRender = false;

        $counselor = $this->Counselors->get($id);
        $this->Auth->setUser($counselor->toArray());
        return $this->redirect('/counselor');
    }

    public function sendConfirmationEmail($counselor)
    {
        // $counselor = $this->Auth->user();
        $hashed_value = $counselor['hash'] ? $counselor['hash'] : md5($counselor['id'] . uniqid() . md5($counselor['email'] . $_SERVER['HTTP_USER_AGENT']));

        $un_replace = array(
            '{%first_name%}' => $counselor['first_name'],
            '{%last_name%}' => $counselor['last_name'],
            '{%email%}' => $counselor['email'],
            '{%mobile%}' => $counselor['mobile'],
            '{%confirmation_url%}' => Router::url(array('controller' => 'Counselors', 'action' => 'confirm_email', $hashed_value), true),
        );
        // $counselor['email'] = 'developerae@thesitefactory.com.au';
        $counselor = $this->Counselors->find()->where(["id" => $counselor['id']])->first();
        $counselor->hash = $hashed_value;
        $this->Counselors->save($counselor);

        $this->sendEmail($counselor['email'], false, 'counselor.re-confirm-email-address', $un_replace, []);

        $this->Flash->success(__('The confirmation email has been sent.'));

        return $this->redirect('/');
    }

    public function confirmEmail($confirm_code = false)
    {

        if ($confirm_code) {

            $confirm_code = preg_replace('/\s+/', ' ', $confirm_code);
            $confirm_code = str_ireplace(' ', '', $confirm_code);
        }
        $counselor = $this->Counselors->find()->where(["hash" => $confirm_code])->first();

        if (isset($_GET['test'])) {
            echo $confirm_code . '</br >';
            debug($counselor);
            die;
        }

        if (!$counselor) {
            $this->Flash->error('Invalid security code');
            $this->redirect('/');
        }
        $counselor->email_confirmed = true;
        $counselor->confirmed = true;
        $counselor->active = true;
        if ($this->Counselors->save($counselor)) {
            $this->Flash->success('Email Confirmed');
            // $this->admin_loginas($this->Counselors->id);
            $this->redirect('/');
        }
        $this->redirect('/');
    }


    // public function index()
    // {

    //     $conditions = $this->_filter_params();

    // $counselors = $this->paginate($this->Counselors, ['conditions' => $conditions/*, 'contain' => ['CounselorGroups']*/]);
    //     // foreach ($counselors as $id => $counselor) {
    //     //     $counselor->counselor_group_name = $counselor->counselor_group->title;
    //     // }
    //     $parameters = $this->request->getAttribute('params');
    //     $this->set(compact('counselors', 'parameters'));
    //     $this->formCommon();
    // }


    public function formCommon()
    {
        // $this->loadModel('CounselorGroups');
        // $counselorGroups =  $this->CounselorGroups->find('list', array('keyField' => 'id', 'valueField' => 'title'));
        // $this->set(compact('counselorGroups'));
    }



    public function index()
    {

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
        }
        $this->set('bodyClass', '');




        $counselorData = $this->Auth->user();

        $return                          = [];
        $school_counselors_portal = $this->getSnippet('school_counselors_portal');
        $this->set('school_counselors_portal', $school_counselors_portal);
        $msg = $this->getSnippet('counselor_register_success');
        // dd($counselorData);
        if ($counselorData) {
            if ($this->request->is('ajax')) {
                $return['url']    = "/counselor/dashboard";
                $return['status']  = 1;

                $return['message'] = $msg;
                $return['type']    = 'login';
                $return['title'] = 'Thank You';
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This counselor already exist!!'))));
            } else {

                $this->Flash->success(__('Welcome'));
                $this->redirect('/counselor/dashboard');
            }
        }
        // Configure::write('debug', false);

        $counselorEntity = $this->Counselors->newEmptyEntity();
        $validation                      = ['validate' => 'register'];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->data = $this->request->getData();
            $existed_counselor = $this->Counselors->find()->where(["email" => $this->data['email']])->first();

            if ($existed_counselor) {
                if ($this->request->is('ajax')) {
                    die(json_encode(array('status' => 'failed', 'message' => __('This counselor already exist!!'))));
                } else {

                    $this->Flash->error(__('This counselor already exist!!'));
                }
            } else {
                $counselorEntity = $this->Counselors->patchEntity($counselorEntity, $this->data, $validation);

                if ($this->Counselors->save($counselorEntity)) {
                    $id = $counselorEntity->id;

                    $counselor = $this->Counselors->get($id);

                    $to = $counselor['email'];

                    $from    = $this->g_configs['general']['txt.send_mail_from'];
                    $replace = array(
                        '{%first_name%}' => $counselor['first_name'],
                        '{%last_name%}'  => $counselor['last_name'],
                        // '{%counselorname%}'  => $counselor['counselorname'],
                        '{%email%}'  => $counselor['email'],
                        '{%mobile%}'  => $counselor['mobile'],
                    );
                    $this->sendEmail($to, $from, 'counselor.notify_counselor_registration', $replace);
                    $this->sendEmail(false, $from, 'admin.notify_counselor_registration', $replace);

                    $return['url']    = "/counselor/dashboard";
                    $return['status']  = 1;
                    $return['message'] = $msg;
                    $return['type']    = 'register';
                    $return['title'] = 'Thank You';
                    $return['url_text'] = 'Continue';

                    $this->sendConfirmationEmail($counselor);
                    // $this->Auth->setUser($counselor->toArray());
                    // die(json_encode($return));
                } else {

                    // dd($counselorEntity->getErrors());


                    $return['url']    = "/counselor/dashboard";
                    $return['status']  = 0;
                    $return['validationErrors']  = $counselorEntity->getErrors();
                    $return['message'] = 'Invalid credentials, try again';

                    // $return['message'] = $this->getSnippet('counselor_register_error');
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
                        $this->redirect('/counselor');
                    } else {

                        $this->Flash->error(__($return['message']));
                    }
                }
            }
        }


        $this->set('counselor', $counselorEntity);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);

        // $countriesCodesList = $this->Countries->find()->select([
        //     'code', 'phone_code'
        // ])->where(['active' => 1])->order(['phone_code' => 'asc']);

        // $countriesCodesList = Hash::combine(
        //     $countriesCodesList->toArray(),
        //     '{n}.phone_code',
        //     ['+%s', '{n}.phone_code']
        // );


        // $this->set('countriesCodesList', $countriesCodesList);
    }


    public function register()
    {

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
        }
        $this->set('bodyClass', '');

        $counselorData = $this->Auth->user();

        $return                          = [];

        $msg = $this->getSnippet('counselor_register_success');
        // dd($counselorData);
        if ($counselorData) {
            if ($this->request->is('ajax')) {
                $return['url']    = "/counselor/dashboard";
                $return['status']  = 1;

                $return['message'] = $msg;
                $return['type']    = 'login';
                $return['title'] = 'Thank You';
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This counselor already exist!!'))));
            } else {

                $this->Flash->success(__('Welcome'));
                $this->redirect('/counselor');
            }
        }
        // Configure::write('debug', false);

        $counselorEntity = $this->Counselors->newEmptyEntity();
        $validation                      = ['validate' => 'register'];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->data = $this->request->getData();
            // dd($this->data);
            $existed_counselor = $this->Counselors->find()->where(["email" => $this->data['email']])->first();
            // dd($existed_counselor);
            if ($existed_counselor) {
                if ($this->request->is('ajax')) {
                    die(json_encode(array('status' => 'failed', 'message' => __('This counselor already exist!!'))));
                } else {

                    $this->Flash->error(__('This counselor already exist!!'));
                }
            } else {
                $counselorEntity = $this->Counselors->patchEntity($counselorEntity, $this->data, $validation);

                if ($this->Session->check('search_url'))
                    $counselorEntity->last_url = $this->Session->read('search_url');
                if ($this->Counselors->save($counselorEntity)) {
                    $id = $counselorEntity->id;

                    $counselor = $this->Counselors->get($id);

                    $to = $counselor['email'];

                    $from    = $this->g_configs['general']['txt.send_mail_from'];
                    $replace = array(
                        '{%first_name%}' => $counselor['first_name'],
                        '{%last_name%}'  => $counselor['last_name'],
                        // '{%username%}'  => $counselor['username'],
                        '{%email%}'  => $counselor['email'],
                        '{%mobile%}'  => $counselor['mobile'],
                    );

                    $this->sendEmail($to, $from, 'counselor.notify_counselor_registration', $replace);
                    $url = '<a href="' . Router::url('/admin/counselors/edit/' . $counselor['id'], true) . '" >View</a>';
                    $replace['{%view_link%}'] = $url;
                    $this->sendEmail($to, $from, 'admin.notify_counselor_registration', $replace);

                    $return['url']    = "/counselor/dashboard";
                    $return['status']  = 1;
                    $return['message'] = $msg;
                    $return['type']    = 'register';
                    $return['title'] = 'Thank You';
                    $return['url_text'] = 'Continue';

                    $this->sendConfirmationEmail($counselor);
                    // $this->Auth->setUser($counselor->toArray());
                    // die(json_encode($return));
                } else {

                    dd($counselorEntity->getErrors());


                    $return['url']    = "/counselor/dashboard";
                    $return['status']  = 0;
                    $return['validationErrors']  = $counselorEntity->getErrors();
                    $return['message'] = 'Invalid credentials, try again';

                    // $return['message'] = $this->getSnippet('counselor_register_error');
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
                        $this->redirect('/counselor/dashboard');
                    } else {

                        $this->Flash->error(__($return['message']));
                    }
                }
            }
        }


        $this->set('counselor', $counselorEntity);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);


        $destinationsList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->order(['country_name' => 'asc']);
        $this->set('destinationsList', $destinationsList);

        // $countriesCodesList = $this->Countries->find()->select([
        //     'code', 'phone_code', 'country_name', 'flag'
        // ])->where(['active' => 1])->order(['phone_code' => 'asc']);

        // $countriesCodesList = Hash::combine(
        //     $countriesCodesList->toArray(),
        //     '{n}.phone_code',
        //     // ['<img src="%s" /> %s +%s', '{n}.flag_path', '{n}.country_name', '{n}.phone_code']
        //     ['+%s', '{n}.phone_code']
        // );
        // dd($countriesCodesList);
        // $this->set('countriesCodesList', $countriesCodesList);

        // $this->loadModel('StudyLevels');
        // $studyLevels = $this->StudyLevels->find('list', [
        //     'keyField' => 'id', 'valueField' => 'title'
        // ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        // $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
        // $this->set('studyLevels', $studyLevels);

        // $this->loadModel('SubjectAreas');
        // $subjectAreas = $this->SubjectAreas->find('list', [
        //     'keyField' => 'id', 'valueField' => 'title'
        // ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        // $this->set('subjectAreas', $subjectAreas);

        // $this->redirect('/');
    }

    /*
    public function register()
    {

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
        }
        $this->set('bodyClass', '');




        $counselorData = $this->Auth->user();

        $return                          = [];

        $msg = $this->getSnippet('counselor_register_success');
        // dd($counselorData);
        if ($counselorData) {
            if ($this->request->is('ajax')) {
                $return['url']    = "/counselor/dashboard";
                $return['status']  = 1;

                $return['message'] = $msg;
                $return['type']    = 'login';
                $return['title'] = 'Thank You';
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This counselor already exist!!'))));
            } else {

                $this->Flash->success(__('Welcome'));
                $this->redirect('/counselor/dashboard');
            }
        }
        // Configure::write('debug', false);

        $counselorEntity = $this->Counselors->newEmptyEntity();
        $validation                      = ['validate' => 'register'];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->data = $this->request->getData();
            $existed_counselor = $this->Counselors->find()->where(["email" => $this->data['email']])->first();

            if ($existed_counselor) {
                if ($this->request->is('ajax')) {
                    die(json_encode(array('status' => 'failed', 'message' => __('This counselor already exist!!'))));
                } else {

                    $this->Flash->error(__('This counselor already exist!!'));
                }
            } else {
                $counselorEntity = $this->Counselors->patchEntity($counselorEntity, $this->data, $validation);

                if ($this->Counselors->save($counselorEntity)) {
                    $id = $counselorEntity->id;

                    $counselor = $this->Counselors->get($id);

                    $to = $counselor['email'];

                    $from    = $this->g_configs['general']['txt.send_mail_from'];
                    $replace = array(
                        '{%first_name%}' => $counselor['first_name'],
                        '{%last_name%}'  => $counselor['last_name'],
                        // '{%counselorname%}'  => $counselor['counselorname'],
                        '{%email%}'  => $counselor['email'],
                        '{%mobile%}'  => $counselor['mobile'],
                    );
                    $this->sendEmail($to, $from, 'counselor.notify_counselor_registration', $replace);
                    $this->sendEmail(false, $from, 'admin.notify_counselor_registration', $replace);

                    $return['url']    = "/counselor/dashboard";
                    $return['status']  = 1;
                    $return['message'] = $msg;
                    $return['type']    = 'register';
                    $return['title'] = 'Thank You';
                    $return['url_text'] = 'Continue';

                    $this->sendConfirmationEmail($counselor);
                    // $this->Auth->setUser($counselor->toArray());
                    // die(json_encode($return));
                } else {

                    // dd($counselorEntity->getErrors());


                    $return['url']    = "/counselor/dashboard";
                    $return['status']  = 0;
                    $return['validationErrors']  = $counselorEntity->getErrors();
                    $return['message'] = 'Invalid credentials, try again';

                    // $return['message'] = $this->getSnippet('counselor_register_error');
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
                        $this->redirect('/counselor/dashboard');
                    } else {

                        $this->Flash->error(__($return['message']));
                    }
                }
            }
        }


        $this->set('counselor', $counselorEntity);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);
    }
    */
    public function profile()
    {


        $counselor = $this->Auth->user();
        try {
            $counselor = $this->Counselors->get($counselor['id']);

            if (!$counselor) {
                $this->Flash->error(__('Counselor not Found!!!'));
                $this->redirect('/counselor/logout');
            } else {
                
                $this->redirect('/counselor/dashboard');
            }
        } catch (Exception $ex) {

            $this->Flash->error(__('Counselor not Found!!!'));
            $this->redirect('/counselor/logout');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sent_data = $this->request->getData();
            $counselor = $this->Counselors->patchEntity($counselor, $this->request->getData()/*, ['validate' => 'profile']*/);

            if (!empty($sent_data['password']) && !empty($sent_data['passwd']) && $sent_data['password'] == $sent_data['passwd']) {
                $counselor->password = $sent_data['password'];
            } else {
                $counselor->password = "";
                unset($counselor->password);
            }
            if (empty($counselor->counselorname))
                $counselor->counselorname = $counselor->email;

            if ($this->Counselors->save($counselor)) {
                $this->Flash->success(__('The profile date has been saved.'));

                // return $this->redirect(['action' => 'accountInfo']);
            } else

                // dd($counselor->getErrors());
                $this->Flash->error(__('The profile data could not be saved. Please, try again.'));
        }
        $this->set(compact('counselor'));
        // $this->set('counselor', $counselorEntity);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);

        $id = $counselor['id'];
        $this->set(compact('id'));
        $this->_ajaxImageUpload('counselor_' . $counselor['id'], 'counselors', $counselor['id'], ['id' => $id], ['image']);
        $uploadSettings = $this->Counselors->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }


    public function accountInfo()
    {
        $counselor_session = $this->Auth->user();
        $counselor = $this->Counselors->get($counselor_session["id"]);
        $this->set(compact('counselor'));

        $advertising_questions_section = $this->getSnippet('advertising-questions-section');
        $this->set("advertising_questions_section", $advertising_questions_section);
    }

    public function dashboard()
    {


        $counselor = $this->Auth->user();
        // $this->set_dynamic_layout("dashboard");
        // $this->pageTitle = $h1 = __("Dashboard", true);
        $data  = array();
        // if (!empty($counselor)) {
        //     try {
        //code...

        $counselorEntity = $this->Counselors->newEmptyEntity();

        $data = $this->Counselors->patchEntity($counselorEntity, $counselor);
        // dd($counselor);
        // $data            = $this->Counselors->get($counselor);

        // dd($data);
        //     } catch (\Throwable $th) {
        //         //throw $th;

        //         // dd($counselor->getErrors());
        //         $this->redirect('/');
        //     }
        // } else {
        //     $this->redirect('/');
        // }
        $this->set('data', $data);
        // $this->set('edit', 1);
        // $this->loadModel('Ads');
        // $this->set('presenter_dashboard_ad', $this->Ads->get_ads('counselor-dashboard'));
        //$this->set('levels', $this->Counselors->PresenterSkill->levels);
        // $this->set('h1', $h1);
    }
    public function _profile()
    {
        $counselor = $this->is_counselor();
        if (!$this->is_counselor()) {
            $this->Flash->error('You must login first', "fail alert alert-error");
            $this->redirect('/counselor');
        }
        // $this->get_dynamic_layout("dashboard");
        if (!empty($this->data)) {
            $this->Counselors->id = $counselor['id'];
            if (!empty($this->data['password']) && !$counselor['confirmed']) {
                $this->data['confirmed'] = 1;
            }
            $need_verification = false;

            // if ($this->data['email'] != $counselor['email']) {
            //     $need_verification                       = true;
            //     $data['hash']                    = "";
            //     $data['confirm_email']           = 0;
            //     $data['verification_email_sent'] = 0;
            // }

            if ($this->Counselors->saveCounselor($this->data, $counselor['id'])) {
                $counselor = $this->Counselors->get($this->Counselors->id);
                // if ($need_verification) {
                //     $this->_send_verification_email($counselor);
                // }
                $this->Session->write('counselor', $counselor);
                $this->Flash->success(__("Your profile has been saved successfully.", true), "Sucmessage alert alert-Sucmessage");
                $this->redirect(array('controller' => 'counselors', 'action' => 'profile'));
            } else {
                $this->Flash->error(__("Your profile could not be saved.", true), "fail alert alert-error");
            }
        } else {

            unset($counselor['password']);
            $this->data = $counselor;
            unset($this->data["id"]);
        }
        $this->pageTitle = $h1 = __("My Profile", true);
        $this->set('h1', $h1);
    }
}
