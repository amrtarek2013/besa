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
            $statusesBtns[$key] = '<span class="btn-status ' . str_replace(' ', '-', $status) . '">' . $status . '</span>';
        }
        $this->set('statusesBtns', $statusesBtns);
        $this->set('statuses', $statuses);
        $this->set('saveLater', $this->Applications->saveLater);
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
                        $user = $this->Users->find()->where(['id' => $application->user_id])->first();

                        $this->__saveReward($application, $user);
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

    private function __saveReward($app, $user)
    {

        // Joined Successfuly only
        if ($app->status == 6 && !empty($user['counselor_id'])) {


            $this->loadModel('CounselorRewards');
            //Check if this app saved to rewards before
            $counselorReward = $this->CounselorRewards->find()->where([
                'user_id' => $user['id'], 'counselor_id' => $user['counselor_id'], 'application_id' => $app->id
            ])->first();

            // Check if paid before
            if (!empty($counselorReward) || $counselorReward['is_paid']) {
                return true;
            }

            $reward = $this->CounselorRewards->newEmptyEntity();
            $reward->application_id = $app->id;
            $reward->counselor_id = $user['counselor_id'];
            $reward->user_id = $user['id'];
            $reward->status = $app->status;
            //Calculate Points
            // First count all joined successfuly studnets for this counselor
            $noOfJoinedStudents = $this->CounselorRewards->find()->where(['counselor_id' => $user['counselor_id'], 'application_id !=' => $app->id])->count();
            $noOfJoinedStudents = ($noOfJoinedStudents > 0) ? $noOfJoinedStudents : 1;
            // Then check the reward_points to find the points based on the number of students
            $this->loadModel('RewardPoints');
            $rewardPoints = $this->RewardPoints->find()->where(["{$noOfJoinedStudents} Between from_student and to_student"])->first();

            if (!empty($rewardPoints)) {

                $reward->point_id = $rewardPoints->id;
                $reward->points = $rewardPoints->points;
                $reward->number_points_dollar = intval($this->g_configs['general']['txt.number_of_points_per_dollar']);
                $reward->total = intval($rewardPoints->points / $reward->number_points_dollar);
            }
            $reward->created = $app->status_time;
            // debug($noOfJoinedStudents);
            // debug($reward);
            // dd($rewardPoints);
            $this->CounselorRewards->save($reward);


            // Update counselor current rewards

            $this->loadModel('Counselors');
            //Check if this app saved to rewards before
            $counselor = $this->Counselors->find()->where(['id' => $user['counselor_id']])->first();

            if (!empty($counselor)) {

                $totalPointsMod = $this->CounselorRewards->find();
                // $totalPointsVal = $totalPointsMod->select(['sum_totals' => $totalPointsMod->func()->sum('CounselorRewards.total')])->where(['counselor_id' => $user['counselor_id'], 'is_paid != 1'])->first();

                $totalPoints = $totalPointsMod->select(['sum_totals' => $totalPointsMod->func()->sum('CounselorRewards.total'), 'sum_points' => $totalPointsMod->func()->sum('CounselorRewards.points')])->where(['counselor_id' => $user['counselor_id'], 'is_paid != 1'])->first();
                $this->loadModel('Users');
                $noOfStudents = $this->Users->find()->innerJoinWith('Applications')->where(['counselor_id' => $user['counselor_id']])->count();
                // dd($noOfStudents);
                $noOfJoinedStudents = $this->CounselorRewards->find()->where(['counselor_id' => $user['counselor_id'], 'is_paid != 1'])->count();
                $counselor['total_points_reward'] = $totalPoints['sum_totals'];
                $counselor['total_points'] = $totalPoints['sum_points'];
                $counselor['number_of_students'] = $noOfStudents;
                $counselor['number_joined_students'] = $noOfJoinedStudents;

                $this->Counselors->save($counselor);
            }
        }
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
            $statusesBtns[$key] = '<span class="btn-status ' . str_replace(' ', '-', $status) . '">' . $status . '</span>';
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

            //comment* $error = $data['file']->getError();
            if ((is_array($data['file']) && $data['file']['error'] == UPLOAD_ERR_OK) || (is_object($data['file']) && $data['file']->getError() == UPLOAD_ERR_OK)) {
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
        ])->where(['active' => 1, 'is_destination' => 1])->order(['country_name' => 'asc']);
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
