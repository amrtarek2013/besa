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

        $counselorData = $this->Auth->user();

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
        }


        $return = [];
        $return['message'] = 'Invalid credentials, try again';
        $return['type']    = 'login';
        $return['status']  = 0;
        $return['title'] = 'Error';
        // $return['url_text'] = 'Back';
        if ($this->request->is('post')) {

            $p_data = $this->request->getData();
            $red_url = "/counselor";
            if (!empty($p_data["from_url"])) {
                $red_url = $p_data["from_url"];
            }
            $counselor = $this->Auth->identify();
            if ($counselor) {
                $this->Auth->setUser($counselor);
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
            $this->redirect('/counselor/login');
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

                    $this->sendEmail($to, false, 'new_password', $replace);
                    $this->Flash->success('Your new password reset link has been sent to your email');
                    $this->redirect('/counselor/forgot-password-success');
                } else {

                    $this->Flash->error('Could not reset your password..', 'Errormessage');
                    $this->redirect('/counselor/forgot-password');
                }
            } else {
                $this->Flash->error('This email is not exsist!', 'Errormessage');
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

    public function sendConfirmationEmail()
    {
        $seller = $this->Auth->user();
        $hashed_value = $seller['hash'] ? $seller['hash'] : md5($seller['id'] . uniqid() . md5($seller['email'] . $_SERVER['HTTP_USER_AGENT']));

        $un_replace = array(
            '{%first_name%}' => $seller['first_name'],
            '{%last_name%}' => $seller['last_name'],
            '{%confirmation_url%}' => Router::url(array('controller' => 'Counselors', 'action' => 'confirm_email', $hashed_value), true),
        );
        $seller['email'] = 'developerae@thesitefactory.com.au';
        $counselor = $this->Counselors->find()->where(["id" => $seller['id']])->first();
        $counselor->hash = $hashed_value;
        $this->Counselors->save($counselor);

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
        $counselor = $this->Counselors->find()->where(["hash" => $confirm_code])->first();

        if (isset($_GET['test'])) {
            echo $confirm_code . '</br >';
            debug($counselor);
            die;
        }

        if (!$counselor) {
            $this->Flash->error('Invalid security code', 'Errormessage');
            $this->redirect('/');
        }
        $counselor->email_confirmed = true;
        $counselor->confirmed = true;
        if ($this->Counselors->save($counselor)) {
            $this->Flash->success('Email Confirmed', 'Sucmessage');
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


    public function workTimes($id = null)
    {
        $counselor = $this->Counselors->get($id);
        $this->loadModel('CounselorWorkDayTimes');
        $counselorWorkDayTimes = $this->CounselorWorkDayTimes->find('all', array('conditions' => ['CounselorWorkDayTimes.counselor_id' => $id], 'order' => array('CounselorWorkDayTimes.id' => 'desc'), 'contain' => []))->toArray();

        if (!empty($counselorWorkDayTimes)) {

            $counselorWorkDayTimes = Hash::combine($counselorWorkDayTimes, '{n}.day', '{n}');
        }


        if ($this->request->is(['patch', 'post', 'put'])) {

            $formData = $this->request->getData();

            foreach ($formData['CounselorWorkDayTimes'] as $time) {

                $time['counselor_id'] = $id;

                if (!empty($time['id'])) {
                    $emptyEntity = $this->CounselorWorkDayTimes->get($time['id']);
                } else {
                    $emptyEntity = $this->CounselorWorkDayTimes->newEmptyEntity();
                }

                $entity = $this->CounselorWorkDayTimes->patchEntity($emptyEntity, $time);

                $this->CounselorWorkDayTimes->save($entity);
            }

            $this->Flash->success(__('The Counselor Work Time has been saved.'));
            return $this->redirect(['action' => 'workTimes', $id]);
        }


        $days = daysList();
        $this->set(compact('counselor', 'days', 'id', 'counselorWorkDayTimes'));
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
                $return['url']    = "/counselor";
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

                    $from    = $this->g_configs['basic']['txt.send_mail_from'];
                    $replace = array(
                        '{%first_name%}' => $counselor['first_name'],
                        '{%last_name%}'  => $counselor['last_name'],
                        '{%counselorname%}'  => $counselor['counselorname'],
                        '{%email%}'  => $counselor['email'],
                        '{%mobile%}'  => $counselor['mobile'],
                    );
                    $this->sendEmail($to, $from, 'counselor.notify_counselor_registration', $replace);
                    $this->sendEmail($to, $from, 'admin.notify_counselor_registration', $replace);

                    $return['url']    = "/counselor";
                    $return['status']  = 1;
                    $return['message'] = $msg;
                    $return['type']    = 'register';
                    $return['title'] = 'Thank You';
                    $return['url_text'] = 'Continue';

                    $this->Auth->setUser($counselor->toArray());
                    // die(json_encode($return));
                } else {

                    // dd($counselorEntity->getErrors());


                    $return['url']    = "/counselor";
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
        // $this->loadModel('Countries');
        // $countriesList = $this->Countries->find('list', [
        //     'keyField' => 'id', 'valueField' => 'country_name'
        // ])->where(['active' => 1, 'is_destination'=>1])->order(['country_name' => 'asc']);
        // $this->set('countriesList', $countriesList);
        // $this->redirect('/');
    }

    public function profile()
    {


        $counselor = $this->Auth->user();
        $counselor = $this->Counselors->get($counselor['id']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sent_data = $this->request->getData();
            $counselor = $this->Counselors->patchEntity($counselor, $this->request->getData(), ['validate' => 'profile']);

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

                return $this->redirect(['action' => 'accountInfo']);
            }

            // dd($counselor->getErrors());
            $this->Flash->error(__('The profile data could not be saved. Please, try again.'));
        }
        $this->set(compact('counselor'));
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
            $this->redirect('/counselor/login');
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
        $universityList = [];
        $degree = null;
        foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
            // debug('<b>Worksheet #' . $sheetIndex . ' -> ' . $loadedSheetName . ' (Formatted)</b>');
            $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            // var_dump($sheetData);
            $counter = 0;
            $university = $this->Universities->newEmptyEntity();
            $university->title = trim($loadedSheetName);


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

                if ($row['A']) {
                    $degree = trim($row['A']);
                }

                $mainCourseName = str_replace(' ', '', str_replace(',', ' ', strtolower(trim($row['B']))));


                $course = $this->UniversityCourses->newEmptyEntity();
                if (isset($savedCourses[$mainCourseName])) {

                    $course->course_id = $savedCourses[$mainCourseName];
                } else {

                    $mainCourse = $this->Courses->newEmptyEntity();
                    $mainCourse->course_name = trim($row['B']);
                    $this->Courses->save($mainCourse);
                    $course->course_id = $mainCourse->id;

                    $savedCourses[$mainCourseName] = $mainCourse->id;
                    $savedCoursesUni[$mainCourseName] = $university_id;
                }

                $course->university_id = $university_id;
                $course->country_id = 238;
                $course->degree = $degree;
                $course->course_name = trim($row['B']);

                $course->duration = trim($row['C']);
                $course->intake = trim($row['D']);
                $course->fees = floatval($row['E']);
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

    public function checkuni()
    {

        $this->loadModel('Universities');

        $universities = $this->Universities->find()->select(['title' => 'trim(lower(university_name))', 'id'])->toArray();
        $universities = Hash::combine($universities, '{n}.title', '{n}.id');

        // dd($universities);

        $not_partners = [
            'aston university - oncampus' => 'Aston University - ONCAMPUS',
            'university of birmingham - kaplan uk' => 'University of Birmingham - Kaplan UK',
            'city, university of london - into uk' => 'City, University of London - INTO UK',
            'university of essex - kaplan uk' => 'University of Essex - Kaplan UK',
            'durham university - study group uk' => 'Durham University - Study Group UK',
            'university of huddersfield - study group uk' => 'University of Huddersfield - Study Group UK',
            'university of hull - oncampus' => 'University of Hull - ONCAMPUS',
            'kingston university london - study group uk' => 'Kingston University London - Study Group UK',
            'liverpool john moores university - study group uk' => 'Liverpool John Moores University - Study Group UK',
            'london south bank university - oncampus' => 'London South Bank University - ONCAMPUS',
            'university of reading - oncampus' => 'University of Reading - ONCAMPUS',
            'university of southampton - oncampus' => 'University of Southampton - ONCAMPUS',
            'loughborough university - oncampus' => 'Loughborough University - ONCAMPUS',
            'university of aberdeen - study group uk' => 'University of Aberdeen - Study Group UK',
            'cardiff university - study group uk' => 'Cardiff University - Study Group UK',
            'university of strhclyde - study group uk' => 'University of Strhclyde - Study Group UK',
            'leeds beckett - study group uk' => 'Leeds Beckett - Study Group UK',
            'university of sussex - study group uk' => 'University of Sussex - Study Group UK',
            'university of leeds - study group uk' => 'University of Leeds - Study Group UK',
            'university of surrey - study group uk' => 'University of Surrey - Study Group UK',
            'university of south wales - qa higher educion' => 'University of South Wales - QA Higher Educion',
            'middlesex university - qa higher educion' => 'Middlesex University - QA Higher Educion',
            'solent university - qa higher educion' => 'Solent University - QA Higher Educion',
        ];

        $universitiesList = [];
        $counter = 0;
        foreach ($not_partners as $k => $v) {

            $university = $this->Universities->newEmptyEntity();

            if (isset($universities[$k])) {

                $university->id = $universities[$k];
                $university->is_partner = 0;
                $counter++;
            } else {

                $university->title = $university->university_name = $v;
                $university->is_partner = 0;
                $counter++;
            }
            $universitiesList[] = $university;
        }
        if ($counter > 0) {
            $this->Universities->saveMany($universitiesList);
        }
        dd($universitiesList);
        die('sssss');
    }
    public function testuncourses()
    {

        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);

        $reader->setLoadAllSheets();
        $spreadsheet = $reader->load('1st Patch Universities Courses Data in UK.xlsx');

        $loadedSheetNames = $spreadsheet->getSheetNames();

        $this->loadModel('Universities');
        $this->loadModel('Courses');

        $this->loadModel('UniversityCourses');

        $this->loadModel('SubjectAreas');
        $this->loadModel('StudyLevels');
        $savedCourses = [];
        $savedCoursesUni = [];

        $universities = $this->Universities->find()->select(['title' => 'trim(lower(university_name))', 'id'])->toArray();
        $universities = Hash::combine($universities, '{n}.title', '{n}.id');

        // $subjectAreas = $this->SubjectAreas->find('list', [
        //     'keyField' => "title", 'valueField' => 'id'
        // ])->toArray();
        // $studyLevels = $this->StudyLevels->find('list', [
        //     'keyField' => "title", 'valueField' => 'id'
        // ])->toArray();

        $subjectAreas = $this->SubjectAreas->find()->select(['title' => 'trim(lower(title))', 'id'])->toArray();
        $subjectAreas = Hash::combine($subjectAreas, '{n}.title', '{n}.id');

        $studyLevels = $this->StudyLevels->find()->select(['title' => 'trim(lower(title))', 'id'])->toArray();
        $studyLevels = Hash::combine($studyLevels, '{n}.title', '{n}.id');

        $universityList = [];
        $degree = null;
        $numberOfCourses = 0;
        $numberOfFailedCourses = [];
        $numberOfMUniCourses = 0;
        $numberOfMUnis = 0;
        $numberOfFaileds = [];
        $numberOfSucsUn = [];
        foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {

            $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $counter = 0;
            $loadedSheetName = trim($loadedSheetName);
            $university_id = null;

            // if (isset($universities[strtolower(trim($loadedSheetName))])) {

            //     $university_id = $universities[strtolower(trim($loadedSheetName))];
            //     $numberOfSucsUn[$university_id] = trim($loadedSheetName);
            // } else {
            //     $found = false;
            // foreach ($universities as $uni_name => $uni_id) {
            //     similar_text(trim($loadedSheetName), $uni_name, $percent);
            //     if ($percent >= 80) {

            //         $university_id = $uni_id;
            //         $numberOfSucsUn[$uni_id] = trim($loadedSheetName);
            //         $found = true;
            //     }
            // }
            // if (!$found && !isset($numberOfFaileds[strtolower(trim($loadedSheetName))])) {
            //     $numberOfMUnis++;
            //     $numberOfFaileds[strtolower(trim($loadedSheetName))] = trim($loadedSheetName);
            // }
            // else {


            // }
            // }
            // else {
            //     $this->Universities->save($university);
            // }

            // $universityList[] = $university;

            // $university_id = $university->id;

            $cou_list = [];

            foreach ($sheetData as $i => $row) {

                if (!isset($row['C']) || strtolower(trim($row['C'])) == 'course name') {
                    continue;
                }
                $mainCourseName = str_replace([' ', ','], ' ', strtolower(trim($row['C'])));
                $numberOfCourses++;

                if (
                    $i == 0 || !$row['A'] || strtolower(trim($row['C'])) == 'course name'
                    // || ((isset($saved[$mainCourseName])
                    //     && $savedCoursesUni[$mainCourseName] == $university_id)
                    // )
                ) {
                    continue;
                }

                $course = $this->UniversityCourses->newEmptyEntity();
                // if (!empty($university_id)) {

                //     $course->university_id = $university_id;
                // } else {


                if (isset($universities[strtolower(trim($row['D']))])) {

                    $university_id = $universities[strtolower(trim($row['D']))];
                    $numberOfSucsUn[$university_id] = trim($row['D']);
                    if ((isset($saved[$mainCourseName])
                        && $savedCoursesUni[$mainCourseName] == $university_id)) {
                        continue;
                    }
                } else {

                    $university = $this->Universities->newEmptyEntity();
                    $university->title = $university->university_name = trim(trim($row['D']));
                    $university->is_partner = 1;
                    $this->Universities->save($university);
                    $university_id = $university->id;
                    $universities[strtolower($university->title)] = $university_id;
                    // if (!isset($numberOfFaileds[strtolower(trim($row['D']))])) {
                    //     $numberOfMUnis++;
                    //     $numberOfFaileds[strtolower(trim($loadedSheetName))] = trim($loadedSheetName);
                    // }
                }
                // }

                if (isset($savedCourses[strtolower($mainCourseName)])) {

                    $course->course_id = $savedCourses[strtolower($mainCourseName)];
                } else {

                    $mainCourse = $this->Courses->newEmptyEntity();
                    $mainCourse->course_name = trim($row['C']);
                    $this->Courses->save($mainCourse);
                    $course->course_id = $mainCourse->id;

                    $savedCourses[strtolower($mainCourseName)] = $mainCourse->id;
                    $savedCoursesUni[strtolower($mainCourseName)] = $university_id;
                }

                if (isset($studyLevels[strtolower(trim($row['A']))])) {

                    $course->study_level_id = $studyLevels[strtolower(trim($row['A']))];
                }
                if (isset($subjectAreas[strtolower(trim($row['B']))])) {

                    $course->subject_area_id = $subjectAreas[strtolower(trim($row['B']))];
                }
                $course->course_name = trim($row['C']);

                $course->university_title = trim($row['D']);
                $course->total_fees = floatval($row['E']);
                $course->fees = floatval($row['F']);
                $course->duration = !empty($row['G']) ? trim($row['G'] . '') : '';
                $course->intake = !empty($row['H']) ? trim($row['H']) : '';

                $course->university_id = $university_id;
                $course->country_id = 238;

                $cou_list[$counter] = $course;

                if ($counter == 100) {
                    $counter = 0;
                    $this->UniversityCourses->saveMany($cou_list);
                    $cou_list = [];
                } else
                    $counter++;
            }

            // debug($cou_list);

            $this->UniversityCourses->saveMany($cou_list);
        }

        // debug($numberOfMUnis);

        // debug(24 - $numberOfMUnis);


        // debug($numberOfSucsUn);
        // debug($numberOfFaileds);

        // debug($numberOfCourses);
        // debug($numberOfMUniCourses);
        // debug($numberOfCourses - $numberOfMUniCourses);
        // debug($universityList);
        // debug($savedCourses);
        die('done');
    }
}
