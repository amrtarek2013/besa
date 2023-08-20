<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Exception;

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


        // $this->loadComponent('Auth');
        $userData = $this->Auth->user();
        // debug($_SESSION);

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

            if ($this->request->is('ajax')) {
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This user already exist!!'))));
            } else {

                // $this->Flash->success(__('Welcome'));
                $this->redirect('/user');
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
            $uuu = $this->Users->find()->where(['email' => $p_data['email']])->first();
            // debug($uuu);
            // debug($p_data);
            $p_data['password'] = (new \Cake\Auth\DefaultPasswordHasher())->hash($p_data['password']);

            // debug($p_data);
            // debug($p_data);
            // die;

            $red_url = "/user";
            if (!empty($p_data["from_url"])) {
                $red_url = $p_data["from_url"];
            }

            $user = $this->Auth->identify();

            // dd($user);
            if ($user) {

                if (!empty($user['last_url'])) {
                    $this->Session->write('search_url', $user['last_url']);

                    $this->set('last_search_url', $user['last_url']);
                }
                $return['url']    = $red_url;
                $return['url_text'] = 'Continue';
                $return['status']  = 1;
                $return['title'] = 'Thank You';
                // $return['message'] = 'Success';
                $return['message'] = $msg;
                // $return['popup_image'] = $popup_image;
                $return['type']    = 'login';
                if (!$user['confirmed'] || !$user['active']) {

                    $return['status']  = 0;
                    $return['title'] = 'Email not Confirmed';
                    $return['message'] = 'Email not Confirmed';
                } else {
                    $this->Auth->setUser($user);
                }

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
                    $this->redirect('/user/register');
                }
            }
        }

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
            $this->redirect('/user/register');
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

                    $url = Router::url('/user/reset-password/' . $hashed_value, true);
                    $replace = array(
                        '{%first_name%}' => $user['first_name'],
                        '{%last_name%}' => $user['last_name'],
                        '{%new_password%}' => '<a href="' . $url . '">Click Here</a>',
                    );

                    $this->sendEmail($to, false, 'user.notify_user_reset_password', $replace);
                    $this->Flash->success('Your new password reset link has been sent to your email');
                    $this->redirect('/user/forgot-password-success');
                } else {

                    $this->Flash->error('Could not reset your password..');
                    $this->redirect('/user/forgot-password');
                }
            } else {
                $this->Flash->error('This email is not exsist!');
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

    public function sendConfirmationEmail($user)
    {
        // $user = $this->Auth->user();
        $hashed_value = $user['hash'] ? $user['hash'] : md5($user['id'] . uniqid() . md5($user['email'] . $_SERVER['HTTP_USER_AGENT']));

        $un_replace = array(
            '{%first_name%}' => $user['first_name'],
            '{%last_name%}' => $user['last_name'],
            '{%email%}' => $user['email'],
            '{%mobile%}' => $user['mobile'],
            '{%confirmation_url%}' => Router::url(array('controller' => 'Users', 'action' => 'confirm_email', $hashed_value), true),
        );
        // $user['email'] = 'developerae@thesitefactory.com.au';
        $user = $this->Users->find()->where(["id" => $user['id']])->first();
        $user->hash = $hashed_value;
        $this->Users->save($user);

        $this->sendEmail($user['email'], false, 'user.re-confirm-email-address', $un_replace, []);
        $this->Flash->success(__('The confirmation email has been sent.'));
        return $this->redirect('/');
    }
    public function confirmEmail($confirm_code = null)
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

        if (!isset($user)) {
            $this->Flash->error('Invalid security code');
            return $this->redirect('/');
        }
        $user->email_confirmed = true;
        $user->confirmed = true;
        $user->active = true;
        if ($this->Users->save($user)) {

            // $this->Auth->setUser($user->toArray());

            $this->Session->write('user', $user->toArray());
            $_SESSION['User'] = $user->toArray();
            $this->Flash->success('Email Confirmed');
            // $this->admin_loginas($this->Users->id);
            $this->redirect('/user');
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
                $userEntity = $this->Users->patchEntity($userEntity, $this->data, $validation);

                if ($this->Session->check('search_url'))
                    $userEntity->last_url = $this->Session->read('search_url');
                if ($this->Users->save($userEntity)) {
                    $id = $userEntity->id;

                    $user = $this->Users->get($id);

                    $to = $user['email'];

                    $from    = $this->g_configs['general']['txt.send_mail_from'];
                    $replace = array(
                        '{%first_name%}' => $user['first_name'],
                        '{%last_name%}'  => $user['last_name'],
                        // '{%username%}'  => $user['username'],
                        '{%email%}'  => $user['email'],
                        '{%mobile%}'  => $user['mobile'],
                    );

                    // $this->sendEmail($to, $from, 'user.notify_user_registration', $replace);
                    $url = '<a href="' . Router::url('/admin/users/edit/' . $user['id'], true) . '" >View</a>';
                    $replace['{%view_link%}'] = $url;
                    $this->sendEmail($to, $from, 'admin.notify_user_registration', $replace);

                    $return['url']    = "/user";
                    $return['status']  = 1;
                    $return['message'] = $msg;
                    $return['type']    = 'register';
                    $return['title'] = 'Thank You';
                    $return['url_text'] = 'Continue';

                    $this->sendConfirmationEmail($user);
                    // $this->Auth->setUser($user->toArray());
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
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);


        $destinationsList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->order(['country_name' => 'asc']);
        $this->set('destinationsList', $destinationsList);

        $countriesCodesList = $this->Countries->find()->select(['code','phone_code','country_name', 'flag'
        ])->where(['active' => 1])->order(['phone_code' => 'asc']);

        $countriesCodesList = Hash::combine(
            $countriesCodesList->toArray(),
            '{n}.phone_code',
            // ['<img src="%s" /> %s +%s', '{n}.flag_path', '{n}.country_name', '{n}.phone_code']
            ['+%s', '{n}.phone_code']
        );
        // dd($countriesCodesList);
        $this->set('countriesCodesList', $countriesCodesList);

        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
        $this->set('studyLevels', $studyLevels);

        $this->loadModel('SubjectAreas');
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);

        // $this->redirect('/');
    }

    public function profile()
    {


        $user = $this->Auth->user();
        try {
            $user = $this->Users->get($user['id']);

            if (!$user) {
                $this->Flash->error(__('User not Found!!!'));
                $this->redirect('/user/logout');
            }
        } catch (Exception $ex) {

            $this->Flash->error(__('User not Found!!!'));
            $this->redirect('/user/logout');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sent_data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $this->request->getData()/*, ['validate' => 'profile']*/);

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

                // return $this->redirect(['action' => 'accountInfo']);
            } else

                // dd($user->getErrors());
                $this->Flash->error(__('The profile data could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);

        $destinationsList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->order(['country_name' => 'asc']);
        $this->set('destinationsList', $destinationsList);

        
        $countriesCodesList = $this->Countries->find()->select(['code','phone_code'
        ])->where(['active' => 1])->order(['phone_code' => 'asc']);

        $countriesCodesList = Hash::combine(
            $countriesCodesList->toArray(),
            '{n}.phone_code',
            ['+%s', '{n}.phone_code']
        );
        
        $this->set('countriesCodesList', $countriesCodesList);

        $this->loadModel('StudyLevels');
        // $studyLevels = $this->StudyLevels->find('list', [
        //     'keyField' => 'id', 'valueField' => 'title'
        // ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);

        $this->loadModel('SubjectAreas');
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);

        $id = $user['id'];
        $this->set(compact('id'));
        $this->_ajaxImageUpload('user_' . $user['id'], 'users', $user['id'], ['id' => $id], ['image']);
        $uploadSettings = $this->Users->getUploadSettings();
        $this->set(compact('uploadSettings'));
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

        // $userEntity = $this->Users->newEmptyEntity();

        // $data = $this->Users->patchEntity($userEntity, $user);
        // dd($data);
        $user            = $this->Users->get($user['id']);
        // dd($user);
        // dd($data);
        //     } catch (\Throwable $th) {
        //         //throw $th;

        //         // dd($user->getErrors());
        //         $this->redirect('/');
        //     }
        // } else {
        //     $this->redirect('/');
        // }
        $this->set('data', $user);
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
            $this->redirect('/user/register');
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
}
