<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Utility\Hash;

/**
 * Applications Controller
 *
 */

class ApplicationsController extends AppController
{


    public function getAll()
    {
        $all = $this->Applications->find('all');
        $searchForValue = ',';
        $stringValue = ',3,4,';

        if (strpos($stringValue, $searchForValue) !== false) {
            echo "Found";
        }
        foreach ($all as  $one) {
            if (strpos($one->application_group_id, ",") !== false) continue;
            $one->application_group_id = ',' . $one->application_group_id . ',';
            $this->Applications->save($one);
            //    dd($one);
        }
        dd('$one');
    }

    public function index()
    {

        $conditions = $this->_filter_params();
        // $conditions['Applications.is_office_admin !='] = 1;

        $applications = $this->paginate($this->Applications, ['conditions' => $conditions, 'contain' => ['Universities', 'Services', 'StudyLevels', 'Users']]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('applications', 'parameters'));


        $statuses = $this->Applications->statuses;
        $statusesBtns = [];
        foreach ($statuses as $key => $status) {
            $statusesBtns[$key] = '<span class="btn-status ' . $status . '">' . $status . '</span>';
        }
        $this->set('statusesBtns', $statusesBtns);
        $this->set('statuses', $statuses);
        $this->formCommon();
    }

    public function add()
    {
        $application = $this->Applications->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $application = $this->Applications->patchEntity($application, $data);
            if ($this->Applications->save($application)) {
                $this->Flash->success(__('The Application has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Application could not be saved. Please, try again.'));
        }

        // $this->_ajaxImageUpload('Applications_new', 'applications', false, false, ['image']);
        $this->set('id', false);

        $this->formCommon();

        $this->set(compact('application'));
    }

    public function edit($id = null, $action = 'index')
    {
        $application = $this->Applications->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $application = $this->Applications->patchEntity($application, $data);

            $application->status_time = date('Y-m-d h:m:s');
            if ($this->Applications->save($application)) {


                if ($action == 'view') {
                    $this->__saveAppLogs($application);

                    if ($application->user_id) {
                        $this->loadModel('Users');
                        $user = $this->Users->get($application->user_id);
                        if ($user) {

                            $to = $user['email'];

                            $from    = $this->g_configs['general']['txt.send_mail_from'];
                            $replace = array(
                                '{%name%}' => $user['first_name'],
                                '{%surname%}'  => $user['last_name'],
                                // // '{%username%}'  => $user['username'],
                                '{%email%}'  => $user['email'],
                                '{%mobile%}'  => $user['mobile'],

                                '{%status%}'  => $this->Applications->statuses[$application['status']],
                                '{%status_text%}'  => $application['status_text'],
                                '{%status_time%}'  => is_string($application->status_time) ? date('H:m:i d-m-Y', strtotime($application->status_time)) : '',
                                '{%view_link%}'  => '<a href="' . Router::url('/user/applications/view/' . $application['id'], true) . '" >View</a>'

                            );

                            $this->sendEmail($to, $from, 'user.notify_user_app_status', $replace);
                        }
                    }
                    $this->Flash->success(__('The Application status has been updated.'));
                    return $this->redirect(['action' => $action, $id]);
                }

                $this->Flash->success(__('The Application has been saved.'));
                return $this->redirect(['action' => $action]);
            }
            $this->Flash->error(__('The Application could not be saved. Please, try again.'));
        }

        if ($action == 'view')
            return $this->redirect(['action' => $action, $id]);
        $this->formCommon();
        $this->set(compact('id'));
        // $this->_ajaxImageUpload('Applications_' . $id, 'applications', $id, ['id' => $id], ['image']);
        $this->set(compact('application'));

        $this->render('add');
    }

    private function __saveAppLogs($app)
    {

        $this->loadModel('ApplicationLogs');
        $applicitionLog = $this->ApplicationLogs->newEmptyEntity();
        $applicitionLog->application_id = $app->id;
        $applicitionLog->study_level_id = $app->study_level_id;
        $applicitionLog->status = $app->status;
        $applicitionLog->status_text = $app->status_text;
        $applicitionLog->created = $app->status_time;
        $this->ApplicationLogs->save($applicitionLog);
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $application = $this->Applications->get($id);
        if ($this->Applications->delete($application)) {
            $this->Flash->success(__('The Application has been deleted.'));
        } else {
            $this->Flash->error(__('The Application could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Applications->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Applications has been deleted.'));
        } else {
            $this->Flash->error(__('The Applications could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $application = $this->Applications->find()->where(['Applications.id' => $id])->contain(['Universities', 'Services', 'StudyLevels', 'Users', 'ApplicationCourses'])->first();

        $this->set('application', $application);
        $this->set('appFields', $this->Applications->app_files_fields);

        $this->loadModel('UniversityCourses');
        $cIds = Hash::combine($application->application_courses, '{n}.university_course_id', '{n}.university_course_id');

        $courses = [];
        if (!empty($cIds))
            $courses = $this->UniversityCourses->find()->contain(
                [
                    'Countries' => ['fields' => ['country_name']],
                    'Universities' => ['fields' => ['title', 'rank']],
                    'Services' => ['fields' => ['title']],
                    'StudyLevels' => ['fields' => ['title']],
                    'SubjectAreas' => ['fields' => ['title']]
                ]
            )->where(['UniversityCourses.id IN' => $cIds])->order(['UniversityCourses.display_order' => 'asc'])->all()->toArray();

        // dd($courses);
        $this->set('courses', $courses);

        $statuses = $this->Applications->statuses;
        $statusesBtns = [];
        foreach ($statuses as $key => $status) {
            $statusesBtns[$key] = '<span class="btn-status ' . $status . '">' . $status . '</span>';
        }
        $this->set('statusesBtns', $statusesBtns);
        $this->set('statuses', $statuses);
    }

    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $applications = $this->Applications->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'Application ID' => 'Application ID',
            'user_id' => 'Name',
            'university_id' => 'Name',
            'service_id' => 'Name',
            // 'job_title' => 'Job Title',
            // 'email' => 'Email',
            // 'address' => 'Address',
            // 'barcode_number' => 'Barcode Number',
            // 'active' => 'Active',
        );

        foreach ($applications as $application) {
            $dataToExport[] = [
                $application->user_id,
                $application->university_id,
                $application->service_id,
                // $application->name,
                // $application->job_title,
                // $application->email,
                // $application->address,
                // $application->barcode_number,
                // '',
                // ($application->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'applications-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $application = $this->Applications->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $error = $data['file']->getError();
            if ($data['file']->getError() == UPLOAD_ERR_OK) {
                $this->loadComponent('Csv');
                $applicationsArray = $this->Csv->convertCsvToArray($data['file'], $this->Applications->schema_of_import);
                foreach ($applicationsArray as $applicationLine) {
                    if (empty($applicationLine['id'])) {
                        unset($applicationLine['id']);
                        $application = $this->Applications->newEmptyEntity();
                    } else {
                        $application = $this->Applications->get($applicationLine['id']);
                    }
                    // if (empty($applicationLine['password'])) {
                    //     unset($applicationLine['password']);
                    // }

                    // $applicationLine['active'] = (strtolower($applicationLine['active']) == 'yes') ? 1 : 0;
                    // fd($applicationLine);
                    $application = $this->Applications->patchEntity($application, $applicationLine);
                    // dd($application);
                    $this->Applications->save($application);
                }
            }

            $this->Flash->success(__('The Applications has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('application'));
    }

    public function formCommon()
    {

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination'=>1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);



        $this->loadModel('Courses');
        $courses = $this->Courses->find('list', [
            'keyField' => 'id', 'valueField' => 'course_name'
        ])->where(['active' => 1])->order(['course_name' => 'asc']);
        $this->set('courses', $courses->toArray());

        $this->set('studyLevels', $this->Courses->studyLevels);

        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('services', $services);
        $this->loadModel("Universities");
        $universities = $this->Universities->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('universities', $universities);


        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('all')->where(['active' => 1])
            ->order(['title' => 'asc'])->all()->toArray();
        $this->set('studyLevels', $studyLevels);
    }

    public function workTimes($id = null)
    {
        $application = $this->Applications->get($id);
        $this->loadModel('ApplicationWorkDayTimes');
        $applicationWorkDayTimes = $this->ApplicationWorkDayTimes->find('all', array('conditions' => ['ApplicationWorkDayTimes.application_id' => $id], 'order' => array('ApplicationWorkDayTimes.id' => 'desc'), 'contain' => []))->toArray();

        if (!empty($applicationWorkDayTimes)) {

            $applicationWorkDayTimes = Hash::combine($applicationWorkDayTimes, '{n}.day', '{n}');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            $formData = $this->request->getData();

            foreach ($formData['ApplicationWorkDayTimes'] as $time) {

                $time['application_id'] = $id;

                if (!empty($time['id'])) {
                    $emptyEntity = $this->ApplicationWorkDayTimes->get($time['id']);
                } else {
                    $emptyEntity = $this->ApplicationWorkDayTimes->newEmptyEntity();
                }

                $entity = $this->ApplicationWorkDayTimes->patchEntity($emptyEntity, $time);

                $this->ApplicationWorkDayTimes->save($entity);
            }

            $this->Flash->success(__('The Application Work Time has been saved.'));
            return $this->redirect(['action' => 'workTimes', $id]);
        }

        $days = daysList();
        $this->set(compact('application', 'days', 'id', 'applicationWorkDayTimes'));
    }
}
