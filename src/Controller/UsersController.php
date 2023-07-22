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
 * Users Controller
 *
 */

class UsersController extends AppController
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

        $userData = $this->Auth->user();

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
            $this->autoRender = false;
        }
        $msg = $this->getSnippet('user_login_success');
        // $popup_image = $this->getSnippet_image('user_login_success');
        if ($userData) {

            $return['url']    = "/user";
            $return['status']  = 1;
            // $return['message'] = 'Success';
            $return['message'] = $msg;
            // $return['popup_image'] = $popup_image;
            $return['type']    = 'login';
            $return['title'] = 'Thank You';
        }


        $return = [];
        $return['message'] = 'Invalid credentials, try again';
        $return['type']    = 'login';
        $return['status']  = 0;
        $return['title'] = 'Error';
        // $return['url_text'] = 'Back';
        if ($this->request->is('post')) {

            $p_data = $this->request->getData();
            $red_url = "/user";
            if (!empty($p_data["from_url"])) {
                $red_url = $p_data["from_url"];
            }
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $return['url']    = $red_url;
                $return['url_text'] = 'Continue';
                $return['status']  = 1;
                $return['title'] = 'Thank You';
                // $return['message'] = 'Success';
                $return['message'] = $msg;
                // $return['popup_image'] = $popup_image;
                $return['type']    = 'login';
                // $this->loadModel('Subscriptions');
                // $subscription = $this->Subscriptions->find()->where([
                //     'Subscriptions.user_id' => $user['id'],
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

                $msg = $this->getSnippet('user_login_error');
                // $popup_image = $this->getSnippet_image('user_login_success');
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

                    $this->redirect('/user');
                } else {

                    $this->Flash->error(__($return['message']));
                }
            }
        }

        // $this->redirect('/');
    }

    public function resetPassword($hash_data = false)
    {

        $this->viewBuilder()->disableAutoLayout();

        $this->layout = false;
        if (!$hash_data) {
            $this->Flash->error(__('Wrong Data', true));
            $this->redirect('/');
        }
        $user = $this->Users->find()->where(['hash' => $hash_data])->first();
        if (empty($user)) {
            $this->Flash->error(__('Wrong Data', true));
            $this->redirect('/');
        }

        if ($this->request->is('post')) {
            // $user = $this->Users->patchEntity($user, $this->request->getData());
            $data = $this->request->getData();
            $user->password = $data['password'];
            $this->Users->save($user);
            // dd($data);
            $this->redirect('/user/login');
        }
    }

    public function forgotPasswordSuccess()
    {
        $this->viewBuilder()->disableAutoLayout();
    }
    public function forgotPassword()
    {
        $this->viewBuilder()->disableAutoLayout();
        // Configure::write('debug', false);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $user = $this->Users->find()->where(['email' => $data['email']])->first();

            if (!empty($user)) {

                // $new_passowrd   = substr(md5(rand() . ''), 0, 6);

                // $user->password = $new_passowrd;
                $id = $user['id'];
                $hashed_value = $user['hash'];
                if (empty($hashed_value) || $hashed_value == null) {
                    $hashed_value = md5($id . uniqid() . md5($user['email'] . $_SERVER['HTTP_USER_AGENT']));
                }
                $user->hash = $hashed_value;
                $user->hash_created_date = date('Y-m-d H:i:s');
                // dd($user);
                if ($this->Users->save($user, ['validate' => false])) {
                    $to = $user['email'];
                    $from = '';

                    $url = '<a href="' . Router::url('/user/reset-password/' . $hashed_value, true) . '" >Click Here</a>'; //Router::url('/user/reset-password/' . $hashed_value, true);

                    $replace = array(
                        '{%first_name%}' => $user['first_name'],
                        '{%last_name%}' => $user['last_name'],
                        '{%new_password%}' => $url,
                    );

                    $this->sendEmail($to, false, 'new_password', $replace);
                    $this->Flash->success('Your new password reset link has been sent to your email');
                    $this->redirect('/user/forgot-password-success');
                } else {

                    $this->Flash->error('Could not reset your password..', 'Errormessage');
                    $this->redirect('/user/forgot-password');
                }
            } else {
                $this->Flash->error('This email is not exsist!', 'Errormessage');
                $this->redirect('/user/forgot-password');
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

        // $this->Session->delete('User');
        return $this->redirect($this->Auth->logout());
    }

    public function loginAs($id)
    {
        $this->autoRender = false;

        $user = $this->Users->get($id);
        $this->Auth->setUser($user->toArray());
        return $this->redirect('/user');
    }

    public function sendConfirmationEmail()
    {
        $seller = $this->Auth->user();
        $hashed_value = $seller['hash'] ? $seller['hash'] : md5($seller['id'] . uniqid() . md5($seller['email'] . $_SERVER['HTTP_USER_AGENT']));

        $url = '<a href="' . Router::url('/users/confirm_email/' . $hashed_value, true) . '" >Click Here</a>';
        $un_replace = array(
            '{%first_name%}' => $seller['first_name'],
            '{%last_name%}' => $seller['last_name'],
            '{%confirmation_url%}' => $url
        );
        $seller['email'] = 'developerae@thesitefactory.com.au';
        $user = $this->Users->find()->where(["id" => $seller['id']])->first();
        $user->hash = $hashed_value;
        $this->Users->save($user);

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
        $user = $this->Users->find()->where(["hash" => $confirm_code])->first();

        if (isset($_GET['test'])) {
            echo $confirm_code . '</br >';
            debug($user);
            die;
        }

        if (!$user) {
            $this->Flash->error('Invalid security code');
            $this->redirect('/');
        }
        $user->email_confirmed = true;
        $user->confirmed = true;
        $user->active = true;
        if ($this->Users->save($user)) {

            // $this->Auth->setUser($user->toArray());

            // $this->Session->write('user', $user->toArray());
            $this->Flash->success('Email Confirmed');
            // $this->admin_loginas($this->Users->id);
            $this->redirect('/user/register');
        }
        $this->redirect('/');
    }


    // public function index()
    // {

    //     $conditions = $this->_filter_params();

    // $users = $this->paginate($this->Users, ['conditions' => $conditions/*, 'contain' => ['UserGroups']*/]);
    //     // foreach ($users as $id => $user) {
    //     //     $user->user_group_name = $user->user_group->title;
    //     // }
    //     $parameters = $this->request->getAttribute('params');
    //     $this->set(compact('users', 'parameters'));
    //     $this->formCommon();
    // }


    public function formCommon()
    {
        // $this->loadModel('UserGroups');
        // $userGroups =  $this->UserGroups->find('list', array('keyField' => 'id', 'valueField' => 'title'));
        // $this->set(compact('userGroups'));
    }


    public function workTimes($id = null)
    {
        $user = $this->Users->get($id);
        $this->loadModel('UserWorkDayTimes');
        $userWorkDayTimes = $this->UserWorkDayTimes->find('all', array('conditions' => ['UserWorkDayTimes.user_id' => $id], 'order' => array('UserWorkDayTimes.id' => 'desc'), 'contain' => []))->toArray();

        if (!empty($userWorkDayTimes)) {

            $userWorkDayTimes = Hash::combine($userWorkDayTimes, '{n}.day', '{n}');
        }


        if ($this->request->is(['patch', 'post', 'put'])) {

            $formData = $this->request->getData();

            foreach ($formData['UserWorkDayTimes'] as $time) {

                $time['user_id'] = $id;

                if (!empty($time['id'])) {
                    $emptyEntity = $this->UserWorkDayTimes->get($time['id']);
                } else {
                    $emptyEntity = $this->UserWorkDayTimes->newEmptyEntity();
                }

                $entity = $this->UserWorkDayTimes->patchEntity($emptyEntity, $time);

                $this->UserWorkDayTimes->save($entity);
            }

            $this->Flash->success(__('The User Work Time has been saved.'));
            return $this->redirect(['action' => 'workTimes', $id]);
        }


        $days = daysList();
        $this->set(compact('user', 'days', 'id', 'userWorkDayTimes'));
    }


    public function register()
    {

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
        }
        $this->set('bodyClass', '');




        $userData = $this->Auth->user();

        $return                          = [];

        $msg = $this->getSnippet('user_register_success');
        // dd($userData);
        if ($userData) {
            if ($this->request->is('ajax')) {
                $return['url']    = "/user";
                $return['status']  = 1;

                $return['message'] = $msg;
                $return['type']    = 'login';
                $return['title'] = 'Thank You';
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This user already exist!!'))));
            } else {

                $this->Flash->success(__('Welcome'));
                $this->redirect('/user');
            }
        }
        // Configure::write('debug', false);

        $userEntity = $this->Users->newEmptyEntity();
        $validation                      = ['validate' => 'register'];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->data = $this->request->getData();
            $existed_user = $this->Users->find()->where(["email" => $this->data['email']])->first();

            if ($existed_user) {
                if ($this->request->is('ajax')) {
                    die(json_encode(array('status' => 'failed', 'message' => __('This user already exist!!'))));
                } else {

                    $this->Flash->error(__('This user already exist!!'));
                }
            } else {
                $this->data['bd'] = implode('-', [$this->data['year'], $this->data['month'], $this->data['day']]);
                $userEntity = $this->Users->patchEntity($userEntity, $this->data, $validation);

                if ($this->Users->save($userEntity)) {
                    $id = $userEntity->id;

                    $user = $this->Users->get($id);

                    $to = $user['email'];

                    $from    = $this->g_configs['basic']['txt.send_mail_from'];
                    $replace = array(
                        '{%first_name%}' => $user['first_name'],
                        '{%last_name%}'  => $user['last_name'],
                        '{%username%}'  => $user['username'],
                        '{%email%}'  => $user['email'],
                        '{%mobile%}'  => $user['mobile'],
                    );
                    $this->sendEmail($to, $from, 'user.notify_user_registration', $replace);
                    $url = '<a href="' . Router::url('/admin/users/edit/' . $user['id'], true) . '" >View</a>';
                    $replace['{%view_link%}'] = $url;
                    $this->sendEmail($to, $from, 'admin.notify_user_registration', $replace);

                    $return['url']    = "/user";
                    $return['status']  = 1;
                    $return['message'] = $msg;
                    $return['type']    = 'register';
                    $return['title'] = 'Thank You';
                    $return['url_text'] = 'Continue';

                    $this->Auth->setUser($user->toArray());
                    // die(json_encode($return));
                } else {

                    // dd($userEntity->getErrors());


                    $return['url']    = "/user";
                    $return['status']  = 0;
                    $return['validationErrors']  = $userEntity->getErrors();
                    $return['message'] = 'Invalid credentials, try again';

                    // $return['message'] = $this->getSnippet('user_register_error');
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
                        $this->redirect('/user');
                    } else {

                        $this->Flash->error(__($return['message']));
                    }
                }
            }
        }


        $this->set('user', $userEntity);
        // $this->loadModel('Countries');
        // $countriesList = $this->Countries->find('list', [
        //     'keyField' => 'id', 'valueField' => 'country_name'
        // ])->where(['active' => 1])->order(['display_order' => 'asc']);
        // $this->set('countriesList', $countriesList);

        // $this->redirect('/');
    }

    public function profile()
    {


        $user = $this->Auth->user();
        $user = $this->Users->get($user['id']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sent_data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'profile']);

            if (!empty($sent_data['password']) && !empty($sent_data['passwd']) && $sent_data['password'] == $sent_data['passwd']) {
                $user->password = $sent_data['password'];
            } else {
                $user->password = "";
                unset($user->password);
            }
            if (empty($user->username))
                $user->username = $user->email;

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The profile date has been saved.'));

                return $this->redirect(['action' => 'accountInfo']);
            }

            // dd($user->getErrors());
            $this->Flash->error(__('The profile data could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        // $this->set('user', $userEntity);
        // $this->loadModel('Countries');
        // $countriesList = $this->Countries->find('list', [
        //     'keyField' => 'id', 'valueField' => 'country_name'
        // ])->where(['active' => 1])->order(['display_order' => 'asc']);
        // $this->set('countriesList', $countriesList);

    }


    public function accountInfo()
    {
        $user_session = $this->Auth->user();
        $user = $this->Users->get($user_session["id"]);
        $this->set(compact('user'));

        $advertising_questions_section = $this->getSnippet('advertising-questions-section');
        $this->set("advertising_questions_section", $advertising_questions_section);
    }

    public function dashboard()
    {


        $user = $this->Auth->user();
        // $this->set_dynamic_layout("dashboard");
        // $this->pageTitle = $h1 = __("Dashboard", true);
        $data  = array();
        // if (!empty($user)) {
        //     try {
        //code...

        $userEntity = $this->Users->newEmptyEntity();

        $data = $this->Users->patchEntity($userEntity, $user);
        // dd($user);
        // $data            = $this->Users->get($user);

        // dd($data);
        //     } catch (\Throwable $th) {
        //         //throw $th;

        //         // dd($user->getErrors());
        //         $this->redirect('/');
        //     }
        // } else {
        //     $this->redirect('/');
        // }
        $this->set('data', $data);
        // $this->set('edit', 1);
        // $this->loadModel('Ads');
        // $this->set('presenter_dashboard_ad', $this->Ads->get_ads('user-dashboard'));
        //$this->set('levels', $this->Users->PresenterSkill->levels);
        // $this->set('h1', $h1);
    }
    public function _profile()
    {
        $user = $this->is_user();
        if (!$this->is_user()) {
            $this->Flash->error('You must login first', "fail alert alert-error");
            $this->redirect('/user/login');
        }
        // $this->get_dynamic_layout("dashboard");
        if (!empty($this->data)) {
            $this->Users->id = $user['id'];
            if (!empty($this->data['password']) && !$user['confirmed']) {
                $this->data['confirmed'] = 1;
            }
            $need_verification = false;

            // if ($this->data['email'] != $user['email']) {
            //     $need_verification                       = true;
            //     $data['hash']                    = "";
            //     $data['confirm_email']           = 0;
            //     $data['verification_email_sent'] = 0;
            // }

            if ($this->Users->saveUser($this->data, $user['id'])) {
                $user = $this->Users->get($this->Users->id);
                // if ($need_verification) {
                //     $this->_send_verification_email($user);
                // }
                $this->Session->write('user', $user);
                $this->Flash->success(__("Your profile has been saved successfully.", true), "Sucmessage alert alert-Sucmessage");
                $this->redirect(array('controller' => 'users', 'action' => 'profile'));
            } else {
                $this->Flash->error(__("Your profile could not be saved.", true), "fail alert alert-error");
            }
        } else {

            unset($user['password']);
            $this->data = $user;
            unset($this->data["id"]);
        }
        $this->pageTitle = $h1 = __("My Profile", true);
        $this->set('h1', $h1);
    }

    public function testxls()
    {

        // $spreadsheet = new Spreadsheet();
        // $activeWorksheet = $spreadsheet->getActiveSheet();
        // $activeWorksheet->setCellValue('A1', 'Hello World !');

        // $writer = new Xlsx($spreadsheet);
        // $writer->save('hello world.xlsx');


        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);

        $reader->setLoadAllSheets();
        $spreadsheet = $reader->load('universities.xlsx');

        $loadedSheetNames = $spreadsheet->getSheetNames();

        $this->loadModel('Universities');
        $this->loadModel('Courses');
        $savedCourses = [];
        $savedCoursesUni = [];

        $this->loadModel('UniversityCourses');
        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('list', ['keyField' => 'permalink', 'valueField' => 'id'])->where(['active' => 1])->toArray();
        // dd($studyLevels);
        $universityList = [];
        $degree = null;
        $studyLevel = null;
        foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
            // debug('<b>Worksheet #' . $sheetIndex . ' -> ' . $loadedSheetName . ' (Formatted)</b>');
            $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            // var_dump($sheetData);
            $counter = 0;
            $university = $this->Universities->newEmptyEntity();
            $university->university_name = $university->title = trim($loadedSheetName);
            $university->active = 1;
            $university->country_id = 238;

            $studyLevelID = null;
            $universityList[] = $university;

            $this->Universities->save($university);
            $university_id = $university->id;

            $cou_list = [];

            foreach ($sheetData as $i => $row) {

                if (
                    $i == 0 || !$row['B'] || !$row['C'] || !$row['D'] || !$row['E'] || strtolower(trim($row['B'])) == 'course'
                    || (isset($savedCoursesUni[str_replace(' ', '', str_replace(',', ' ', strtolower(trim($row['B']))))]) && $savedCoursesUni[str_replace(' ', '', str_replace(',', ' ', strtolower(trim($row['B']))))] == $university_id)
                )
                    continue;


                $mainCourseName = str_replace([' ', ','], ' ', strtolower(trim($row['B'])));

                // debug(trim($row['A']));
                if ($row['A']) {
                    $studyLevel = $degree = trim($row['A']);
                    $stLevel = str_replace(['.', "'", ","], ' ', strtolower($studyLevel));
                    // debug($stLevel);
                    // var_dump(strpos($stLevel,'master'));
                    // var_dump(strpos($stLevel,'phd'));
                    // var_dump(strpos($stLevel,'bachelor'));
                    if (
                        strpos($stLevel, 'master') !== false
                        || strpos($mainCourseName, 'msc') !== false || strpos($mainCourseName, 'mres') !== false
                        || strpos($mainCourseName, 'llm') !== false || strpos($mainCourseName, 'mph') !== false
                        || strpos($mainCourseName, 'march') !== false || strpos($mainCourseName, 'pgd') !== false
                        || strpos($mainCourseName, 'pgc') !== false
                    ) {

                        $studyLevelID = $studyLevels['master-degrees'];
                    } else if (strpos($stLevel, 'phd') !== false || strpos($mainCourseName, 'phd') !== false) {
                        $studyLevelID = $studyLevels['phd-degrees'];
                    } else if (
                        strpos($stLevel, 'bachelor') !== false || strpos($mainCourseName, 'bsc') !== false
                        || strpos($mainCourseName, 'ba') !== false
                    ) {
                        $studyLevelID = $studyLevels['bachelor-degree'];
                    } else if (
                        strpos($mainCourseName, 'pgce') !== false || strpos($mainCourseName, 'pgdip') !== false
                        || strpos($mainCourseName, 'mba') !== false || strpos($mainCourseName, 'gdip') !== false
                    ) {
                        $studyLevelID = $studyLevels['postgraduate-degrees'];
                    }
                    // dd($studyLevelID);
                    // if (!$studyLevelID) {
                    //     debug($stLevel);
                    //     dd($mainCourseName);
                    // }
                } else {
                    if (
                        strpos($mainCourseName, 'msc') !== false || strpos($mainCourseName, 'ma') !== false
                        || strpos($mainCourseName, 'msc') !== false || strpos($mainCourseName, 'mres') !== false
                        || strpos($mainCourseName, 'llm') !== false || strpos($mainCourseName, 'mph') !== false
                        || strpos($mainCourseName, 'march') !== false || strpos($mainCourseName, 'pgd') !== false
                        || strpos($mainCourseName, 'pgc') !== false
                    ) {

                        $studyLevelID = $studyLevels['master-degrees'];
                    } else if (strpos($mainCourseName, 'phd') !== false) {
                        $studyLevelID = $studyLevels['phd-degrees'];
                    } else if (
                        strpos($mainCourseName, 'bsc') !== false || strpos($mainCourseName, 'ba') !== false
                    ) {
                        $studyLevelID = $studyLevels['bachelor-degree'];
                    } else if (
                        strpos($mainCourseName, 'pgce') !== false || strpos($mainCourseName, 'pgdip') !== false
                        || strpos($mainCourseName, 'mba') !== false || strpos($mainCourseName, 'gdip') !== false
                    ) {
                        $studyLevelID = $studyLevels['postgraduate-degrees'];
                    }
                }
                // dd($row['A']);



                $course = $this->UniversityCourses->newEmptyEntity();
                if (isset($savedCourses[$mainCourseName])) {

                    $course->course_id = $savedCourses[$mainCourseName];
                    $course->active = 1;

                    $course->study_level_id = $studyLevelID;
                } else {

                    $mainCourse = $this->Courses->newEmptyEntity();
                    $mainCourse->course_name = trim($row['B']);
                    $mainCourse->active = 1;

                    $mainCourse->study_level_id = $studyLevelID;
                    $this->Courses->save($mainCourse);
                    $course->course_id = $mainCourse->id;

                    $savedCourses[$mainCourseName] = $mainCourse->id;
                    $savedCoursesUni[$mainCourseName] = $university_id;
                }

                $course->university_id = $university_id;
                $course->country_id = 238;
                $course->degree = $degree;
                $course->study_level_id = $studyLevelID;
                $course->course_name = trim($row['B']);

                $course->duration = trim($row['C']);
                $course->intake = trim($row['D']);
                $course->fees = floatval($row['E']);
                $course->active = 1;
                $cou_list[$counter] = $course;

                if ($counter == 100) {
                    $counter = 0;
                    // debug($universityList);
                    // dd($cou_list);
                    $this->UniversityCourses->saveMany($cou_list);
                    $cou_list = [];
                } else
                    $counter++;
            }

            $this->UniversityCourses->saveMany($cou_list);
        }


        die('done');
    }
    public function updateCourseService()
    {
        $this->loadModel('Courses');

        $this->loadModel('UniversityCourses');
        $courses = $this->UniversityCourses->find()->contain(['Courses'])->distinct('course_id')->all();
        $updatedCourses = [];
        $counter = 0;
        foreach ($courses as $course) {

            $mCourse = $course['course'];
            $mCourse['service_id'] = $course['service_id'];
            $mCourse['study_level_id'] = $course['study_level_id'];
            $updatedCourses[$counter] = $mCourse;

            $counter++;
            if ($counter == 100) {

                $this->Courses->saveMany($updatedCourses);
                $updatedCourses = [];
                $counter = 0;
            }
        }

        $this->Courses->saveMany($updatedCourses);
        dd($updatedCourses);
    }
}
