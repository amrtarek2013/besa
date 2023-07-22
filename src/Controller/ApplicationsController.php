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

    public function addCourseToApplication($course_id, $isNew = 'add')
    {

        $this->loadModel('UniversityCourses');

        $message = __('The Course not found. Please, try again.');
        $status = 'error';
        $this->loadModel('UniversityCourses');
        $course = $this->UniversityCourses->find()->where(['id' => $course_id])->first();

        $this->loadModel('Applications');
        $conds = []; //['save_later' => 1];
        if (isset($_SESSION['Auth']['User'])) {
            $user = $_SESSION['Auth']['User'];
            $conds['user_id'] = $user['id'];
        } else {

            $token = $this->userToken();
            $conds['user_token'] = $token;
        }
        $application = $this->Applications->find()->where($conds)
            ->contain(['Users', 'ApplicationCourses', 'Universities', 'Services', 'StudyLevels'])
            ->order(['Applications.created' => 'DESC'])->first();

        if (empty($application)) {
            $application = $this->Applications->newEmptyEntity();
            // $application->user_id = $user['id'];
        }

        $this->loadModel('ApplicationCourses');
        $applicationCourse = $this->ApplicationCourses->newEmptyEntity();
        if ($course) {

            if ($isNew == 'add') {
                $applicationCourse = $this->ApplicationCourses->patchEntity($applicationCourse, $this->request->getData());
                $applicationCourse->university_course_id = $course_id;
                if (!is_array($application) && empty($application->toArray())) {
                    if (isset($_SESSION['Auth']['User'])) {
                        $user = $_SESSION['Auth']['User'];
                        $application->user_id = $user['id'];
                    } else
                        $application->user_token = $this->userToken();

                    $application->university_id = $course['university_id'];
                    $application->service_id = $course['service_id'];
                    $application->study_level_id = $course['study_level_id'];

                    // dd($application);
                    $this->Applications->save($application);
                    $applicationCourse->application_id = $application->id;

                    if ($this->ApplicationCourses->save($applicationCourse)) {
                        $message = __('The Course added to Application Successfully.');
                        $status = 'success';
                    } else {
                        $message = __('The Application could not be saved. Please, try again.');
                    }
                } else {

                    $conditions = ['university_course_id' => $course_id, 'application_id' => $application->id];

                    $appCourse = $this->ApplicationCourses->find()->where($conditions)->first();
                    if ($appCourse) {
                        // $this->ApplicationCourses->delete($applicationCourse);
                        // $status = 'success';

                        $message = __('The Course already exist in the Application.');
                    } else {
                        $applicationCourse->application_id = $application->id;
                        if ($this->ApplicationCourses->save($applicationCourse)) {
                            $message = __('The Course added to Application Successfully.');
                            $status = 'success';
                        } else {
                            $message = __('The Application could not be saved. Please, try again.');
                        }
                    }
                }
            } else {
                $conditions = ['university_course_id' => $course_id, 'application_id' => $application->id];
                // if (isset($_SESSION['Auth']['User'])) {
                //     $user = $_SESSION['Auth']['User'];
                //     $conditions['user_id'] = $user['id'];
                // } else
                //     $conditions['user_token'] = $this->userToken();

                $applicationCourse = $this->ApplicationCourses->find()->where($conditions)->first();
                if ($applicationCourse) {
                    $this->ApplicationCourses->delete($applicationCourse);
                }
                $status = 'deleted';

                $message = __('The Course removed from the Application Successfully.');
            }
        }

        if ($this->request->is('ajax')) {
            die(json_encode(['status' => $status, 'message' => $message]));
        } else {
            $this->redirect($this->referer(array('controller' => 'applications', 'action' => 'index'), true));
        }
    }

    public function add($course_id, $isNew = 'add')
    {

        $this->loadModel('UniversityCourses');

        $message = __('The Course not found. Please, try again.');
        $status = 'error';
        $this->loadModel('UniversityCourses');
        $course = $this->UniversityCourses->find()->where(['id' => $course_id])->first();

        $wishList = $this->WishLists->newEmptyEntity();
        if ($course) {
            if ($isNew == 'add') {
                $wishList = $this->WishLists->patchEntity($wishList, $this->request->getData());
                $wishList->course_id = $course_id;
                if (isset($_SESSION['Auth']['User'])) {
                    $user = $_SESSION['Auth']['User'];
                    $wishList->user_id = $user['id'];
                } else
                    $wishList->user_token = $this->userToken();

                if ($this->WishLists->save($wishList)) {
                    $message = __('The Course added to WishList Successfully.');
                    $status = 'success';
                } else {
                    $message = __('The WishList could not be saved. Please, try again.');
                }
            } else {
                $conditions = ['course_id' => $course_id];
                if (isset($_SESSION['Auth']['User'])) {
                    $user = $_SESSION['Auth']['User'];
                    $conditions['user_id'] = $user['id'];
                } else
                    $conditions['user_token'] = $this->userToken();
                $wishList = $this->WishLists->find()->where($conditions)->first();
                if ($wishList) {
                    $this->WishLists->delete($wishList);
                }
                $status = 'deleted';

                $message = __('The Course removed from the WishList Successfully.');
            }
        }

        if ($this->request->is('ajax')) {
            die(json_encode(['status' => $status, 'message' => $message]));
        } else {
            $this->redirect($this->referer(array('action' => 'index'), true));
        }
    }

    public function index($studylevel_id = null)
    {
        $conds = [];
        $user_id = null;
        if (isset($_SESSION['Auth']['User'])) {
            $user = $_SESSION['Auth']['User'];
            $user_id = $wish_cond['user_id'] = $conds['user_id'] = $user['id'];
        } else {

            $token = $this->userToken();
            $wish_cond['user_token'] = $conds['user_token'] = $token;
        }
        $application = $this->Applications->find()->where($conds)
            ->contain(['Users', 'ApplicationCourses', 'Universities', 'Services', 'StudyLevels'])
            ->order(['Applications.created' => 'DESC'])->first();



        $appService = $application['study_level']['permalink'];

        // debug($application);
        $this->set('appService', $appService);
        // dd($this->Applications->app_files);



        $appFiles = $this->Applications->app_files[$appService];
        $this->loadModel('StudyLevels');
        if (isset($studylevel_id)) {
            $studyLevel = $this->StudyLevels->find()->where(['active' => 1, 'id' => $studylevel_id])->first();

            $this->set('studyLevel', $studyLevel);

            $appService = $studyLevel['permalink'];
            $appFiles = $this->Applications->app_files[$appService];

            $application['study_level']['title'] = $studyLevel['title'];
            $application['study_level']['id'] = $studyLevel['id'];
            $this->set('studyLevel', $studyLevel);
        }

        // dd($appFiles);
        $this->set('appFiles', $appFiles);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // debug($application);
            // dd($_FILES);
            $application = $this->Applications->patchEntity($application, $data);

            $uploadPath = WWW_ROOT . 'uploads/files/applications';
            // debug($uploadPath);
            $upResult = UploadFiles($_FILES, $appFiles, $uploadPath, 'pdf');

            if (empty($upResult['errors'])) {
                foreach ($upResult['names'] as $fieldName => $value) {
                    $application[$fieldName] = $value;
                }


                // if (isset($data['save_later'])) {
                //     $application->save_later = 1;
                // } else if (isset($data['save'])) {

                //     $application->save_later = 2;
                // }

                if ($this->Applications->save($application)) {

                    if (isset($data['save']) && $user_id) {
                        $this->loadModel('Users');
                        $user = $this->Users->get($user_id);

                        $to = $user['email'];

                        $from    = $this->g_configs['general']['txt.send_mail_from'];
                        $replace = array(
                            '{%name%}' => $user['first_name'],
                            '{%surname%}'  => $user['last_name'],
                            // // '{%username%}'  => $user['username'],
                            '{%email%}'  => $user['email'],
                            '{%mobile%}'  => $user['mobile'],

                        );
                        $this->sendEmail($to, $from, 'user.notify_user_new_apply', $replace);

                        $url = '<a href="' . Router::url('/admin/applications/view/' . $application['id'], true) . '" >View</a>';
                        $replace['{%view_link%}'] = $url;
                        $this->sendEmail(false, $from, 'admin.notify_user_new_apply', $replace);
                    }
                }
                $this->Flash->success(__('The Application files are saved successfuly.'));
                return $this->redirect(['action' => 'index']);
            }
            // dd($upResult['errors']);s
            $this->set('appErrors', $upResult['errors']);
            $this->Flash->error(__('The Application could not be saved. Please, try again.'));
        }

        // $this->loadModel('WishLists');
        // $wishLists = $this->WishLists->find('list', ['keyField' => 'course_id', 'valueField' => 'course_id'])
        //     ->where($wish_cond)->toArray();
        // debug($wishLists);

        $wishLists = $this->getWishLists();

        $appCourses = $this->getAppCourses();
        // if (!empty($application['application_courses']))
        //     $appCourses = Hash::combine($application['application_courses'], '{n}.course_id', '{n}.course_id');
        // debug($appCourses);
        $this->loadModel('UniversityCourses');

        $cIds = array_merge($appCourses, $wishLists);
        // debug($cIds);
        $courses = [];
        if (!empty($cIds))
            $courses = $this->UniversityCourses->find()->contain(
                [
                    'Courses' => ['fields' => ['course_name']],
                    'Countries' => ['fields' => ['country_name']],
                    'Universities' => ['fields' => ['university_name', 'rank']],
                    'Services' => ['fields' => ['title']],
                    'StudyLevels' => ['fields' => ['title']],
                    'SubjectAreas' => ['fields' => ['title']]
                ]
            )->where(['UniversityCourses.id IN' => $cIds])->order(['UniversityCourses.display_order' => 'asc'])->limit(10)->all()->toArray();

        if (empty($courses)) {
            $this->Flash->error(__('There is no courses selected!'));
            return $this->redirect('/study');
        }
        $this->set('courses', $courses);
        $this->set('wishLists', $wishLists);
        $this->set('appCourses', $appCourses);
        $this->set('application', $application);


        // $this->loadModel('StudyLevels');
        // $studyLevels = $this->StudyLevels->find('all')->where(['active' => 1])
        //     ->order(['display_order' => 'asc'])->all()->toArray();
        // $this->set('studyLevels', $studyLevels);

        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('studyLevels', $studyLevels);
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

        // $this->set('studyLevels', $this->Courses->studyLevels);

        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1, 'show_in_search' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('services', $services);


        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('all')->where(['active' => 1])
            ->order(['display_order' => 'asc'])->all()->toArray();
        $this->set('studyLevels', $studyLevels);

        // $this->redirect('/');
    }
}
