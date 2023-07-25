<?php

declare(strict_types=1);

namespace App\Controller\Councillor;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Exception;

/**
 * Councillors Controller
 *
 */

class CouncillorsController extends AppController
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
        $councillorData = $this->Auth->user();
        // debug($_SESSION);

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
            $this->autoRender = false;
        }
        $msg = $this->getSnippet('councillor_login_success');
        // $popup_image = $this->getSnippet_image('councillor_login_success');
        if ($councillorData) {

            $return['url']    = "/councillor";
            $return['status']  = 1;
            // $return['message'] = 'Success';
            $return['message'] = $msg;
            // $return['popup_image'] = $popup_image;
            $return['type']    = 'login';
            $return['title'] = 'Thank You';

            if ($this->request->is('ajax')) {
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This councillor already exist!!'))));
            } else {

                // $this->Flash->success(__('Welcome'));
                $this->redirect('/councillor');
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
            $uuu = $this->Councillors->find()->where(['email' => $p_data['email']])->first();
            // debug($uuu);
            // debug($p_data);
            $p_data['password'] = (new \Cake\Auth\DefaultPasswordHasher())->hash($p_data['password']);


            $red_url = "/councillor";
            if (!empty($p_data["from_url"])) {
                $red_url = $p_data["from_url"];
            }

            $councillor = $this->Auth->identify();

            // dd($councillor);
            if ($councillor) {


                $return['url']    = $red_url;
                $return['url_text'] = 'Continue';
                $return['status']  = 1;
                $return['title'] = 'Thank You';
                // $return['message'] = 'Success';
                $return['message'] = $msg;
                // $return['popup_image'] = $popup_image;
                $return['type']    = 'login';
                if (!$councillor['confirmed'] || !$councillor['active']) {

                    $return['status']  = 0;
                    $return['title'] = 'Email not Confirmed';
                    $return['message'] = 'Email not Confirmed';
                } else {
                    $this->Auth->setUser($councillor);
                }

                // $this->loadModel('Subscriptions');
                // $subscription = $this->Subscriptions->find()->where([
                //     'Subscriptions.councillor_id' => $councillor['id'],
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

                $msg = $this->getSnippet('councillor_login_error');
                // $popup_image = $this->getSnippet_image('councillor_login_success');
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
                    $this->redirect('/councillor');

                } else {

                    $this->Flash->error(__($return['message']));
                    $this->redirect('/councillor/register');
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
        $councillor = $this->Councillors->find()->where(['hash' => $hash_data])->first();
        if (empty($councillor)) {
            $this->Flash->error(__('Wrong Data', true));
            $this->redirect('/');
        }

        if ($this->request->is('post')) {
            // $councillor = $this->Councillors->patchEntity($councillor, $this->request->getData());
            $data = $this->request->getData();
            $councillor->password = $data['password'];
            $this->Councillors->save($councillor);
            // dd($data);
            $this->redirect('/councillor/register');
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

            $councillor = $this->Councillors->find()->where(['email' => $data['email']])->first();

            if (!empty($councillor)) {

                // $new_passowrd   = substr(md5(rand() . ''), 0, 6);

                // $councillor->password = $new_passowrd;
                $id = $councillor['id'];
                $hashed_value = $councillor['hash'];
                if (empty($hashed_value) || $hashed_value == null) {
                    $hashed_value = md5($id . uniqid() . md5($councillor['email'] . $_SERVER['HTTP_USER_AGENT']));
                }
                $councillor->hash = $hashed_value;
                $councillor->hash_created_date = date('Y-m-d H:i:s');
                // dd($councillor);
                if ($this->Councillors->save($councillor, ['validate' => false])) {
                    $to = $councillor['email'];
                    $from = '';

                    $url = Router::url('/councillor/reset-password/' . $hashed_value, true);
                    $replace = array(
                        '{%first_name%}' => $councillor['first_name'],
                        '{%last_name%}' => $councillor['last_name'],
                        '{%new_password%}' => '<a href="' . $url . '">Click Here</a>',
                    );

                    $this->sendEmail($to, false, 'councillor.notify_councillor_reset_password', $replace);
                    $this->Flash->success('Your new password reset link has been sent to your email');
                    $this->redirect('/councillor/forgot-password-success');
                } else {

                    $this->Flash->error('Could not reset your password..');
                    $this->redirect('/councillor/forgot-password');
                }
            } else {
                $this->Flash->error('This email is not exsist!');
                $this->redirect('/councillor/forgot-password');
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

        // $this->Session->delete('Councillor');
        return $this->redirect($this->Auth->logout());
    }

    public function loginAs($id)
    {
        $this->autoRender = false;

        $councillor = $this->Councillors->get($id);
        $this->Auth->setUser($councillor->toArray());
        return $this->redirect('/councillor');
    }

    public function sendConfirmationEmail($councillor)
    {
        // $councillor = $this->Auth->user();
        $hashed_value = $councillor['hash'] ? $councillor['hash'] : md5($councillor['id'] . uniqid() . md5($councillor['email'] . $_SERVER['HTTP_USER_AGENT']));

        $un_replace = array(
            '{%first_name%}' => $councillor['first_name'],
            '{%last_name%}' => $councillor['last_name'],
            '{%email%}' => $councillor['email'],
            '{%mobile%}' => $councillor['mobile'],
            '{%confirmation_url%}' => Router::url(array('controller' => 'Councillors', 'action' => 'confirm_email', $hashed_value), true),
        );
        // $councillor['email'] = 'developerae@thesitefactory.com.au';
        $councillor = $this->Councillors->find()->where(["id" => $councillor['id']])->first();
        $councillor->hash = $hashed_value;
        $this->Councillors->save($councillor);

        $this->sendEmail($councillor['email'], false, 'councillor.re-confirm-email-address', $un_replace, []);

        $this->Flash->success(__('The confirmation email has been sent.'));

        return $this->redirect('/');
    }

    public function confirmEmail($confirm_code = false)
    {

        if ($confirm_code) {

            $confirm_code = preg_replace('/\s+/', ' ', $confirm_code);
            $confirm_code = str_ireplace(' ', '', $confirm_code);
        }
        $councillor = $this->Councillors->find()->where(["hash" => $confirm_code])->first();

        if (isset($_GET['test'])) {
            echo $confirm_code . '</br >';
            debug($councillor);
            die;
        }

        if (!$councillor) {
            $this->Flash->error('Invalid security code');
            $this->redirect('/');
        }
        $councillor->email_confirmed = true;
        $councillor->confirmed = true;
        $councillor->active = true;
        if ($this->Councillors->save($councillor)) {
            $this->Flash->success('Email Confirmed');
            // $this->admin_loginas($this->Councillors->id);
            $this->redirect('/');
        }
        $this->redirect('/');
    }


    // public function index()
    // {

    //     $conditions = $this->_filter_params();

    // $councillors = $this->paginate($this->Councillors, ['conditions' => $conditions/*, 'contain' => ['CouncillorGroups']*/]);
    //     // foreach ($councillors as $id => $councillor) {
    //     //     $councillor->councillor_group_name = $councillor->councillor_group->title;
    //     // }
    //     $parameters = $this->request->getAttribute('params');
    //     $this->set(compact('councillors', 'parameters'));
    //     $this->formCommon();
    // }


    public function formCommon()
    {
        // $this->loadModel('CouncillorGroups');
        // $councillorGroups =  $this->CouncillorGroups->find('list', array('keyField' => 'id', 'valueField' => 'title'));
        // $this->set(compact('councillorGroups'));
    }


    public function workTimes($id = null)
    {
        $councillor = $this->Councillors->get($id);
        $this->loadModel('CouncillorWorkDayTimes');
        $councillorWorkDayTimes = $this->CouncillorWorkDayTimes->find('all', array('conditions' => ['CouncillorWorkDayTimes.councillor_id' => $id], 'order' => array('CouncillorWorkDayTimes.id' => 'desc'), 'contain' => []))->toArray();

        if (!empty($councillorWorkDayTimes)) {

            $councillorWorkDayTimes = Hash::combine($councillorWorkDayTimes, '{n}.day', '{n}');
        }


        if ($this->request->is(['patch', 'post', 'put'])) {

            $formData = $this->request->getData();

            foreach ($formData['CouncillorWorkDayTimes'] as $time) {

                $time['councillor_id'] = $id;

                if (!empty($time['id'])) {
                    $emptyEntity = $this->CouncillorWorkDayTimes->get($time['id']);
                } else {
                    $emptyEntity = $this->CouncillorWorkDayTimes->newEmptyEntity();
                }

                $entity = $this->CouncillorWorkDayTimes->patchEntity($emptyEntity, $time);

                $this->CouncillorWorkDayTimes->save($entity);
            }

            $this->Flash->success(__('The Councillor Work Time has been saved.'));
            return $this->redirect(['action' => 'workTimes', $id]);
        }


        $days = daysList();
        $this->set(compact('councillor', 'days', 'id', 'councillorWorkDayTimes'));
    }


    public function register()
    {

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
        }
        $this->set('bodyClass', '');




        $councillorData = $this->Auth->user();

        $return                          = [];

        $msg = $this->getSnippet('councillor_register_success');
        // dd($councillorData);
        if ($councillorData) {
            if ($this->request->is('ajax')) {
                $return['url']    = "/councillor";
                $return['status']  = 1;

                $return['message'] = $msg;
                $return['type']    = 'login';
                $return['title'] = 'Thank You';
                die(json_encode($return));
                // die(json_encode(array('status' => 'failed', 'message' => __('This councillor already exist!!'))));
            } else {

                $this->Flash->success(__('Welcome'));
                $this->redirect('/councillor');
            }
        }
        // Configure::write('debug', false);

        $councillorEntity = $this->Councillors->newEmptyEntity();
        $validation                      = ['validate' => 'register'];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->data = $this->request->getData();
            $existed_councillor = $this->Councillors->find()->where(["email" => $this->data['email']])->first();

            if ($existed_councillor) {
                if ($this->request->is('ajax')) {
                    die(json_encode(array('status' => 'failed', 'message' => __('This councillor already exist!!'))));
                } else {

                    $this->Flash->error(__('This councillor already exist!!'));
                }
            } else {
                $councillorEntity = $this->Councillors->patchEntity($councillorEntity, $this->data, $validation);

                if ($this->Councillors->save($councillorEntity)) {
                    $id = $councillorEntity->id;

                    $councillor = $this->Councillors->get($id);

                    $to = $councillor['email'];

                    $from    = $this->g_configs['general']['txt.send_mail_from'];
                    $replace = array(
                        '{%first_name%}' => $councillor['first_name'],
                        '{%last_name%}'  => $councillor['last_name'],
                        // '{%councillorname%}'  => $councillor['councillorname'],
                        '{%email%}'  => $councillor['email'],
                        '{%mobile%}'  => $councillor['mobile'],
                    );
                    $this->sendEmail($to, $from, 'councillor.notify_councillor_registration', $replace);
                    $this->sendEmail(false, $from, 'admin.notify_councillor_registration', $replace);

                    $return['url']    = "/councillor";
                    $return['status']  = 1;
                    $return['message'] = $msg;
                    $return['type']    = 'register';
                    $return['title'] = 'Thank You';
                    $return['url_text'] = 'Continue';

                    $this->sendConfirmationEmail($councillor);
                    // $this->Auth->setUser($councillor->toArray());
                    // die(json_encode($return));
                } else {

                    // dd($councillorEntity->getErrors());


                    $return['url']    = "/councillor";
                    $return['status']  = 0;
                    $return['validationErrors']  = $councillorEntity->getErrors();
                    $return['message'] = 'Invalid credentials, try again';

                    // $return['message'] = $this->getSnippet('councillor_register_error');
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
                        $this->redirect('/councillor');
                    } else {

                        $this->Flash->error(__($return['message']));
                    }
                }
            }
        }


        $this->set('councillor', $councillorEntity);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);

    }

    public function profile()
    {


        $councillor = $this->Auth->user();
        try {
            $councillor = $this->Councillors->get($councillor['id']);

            if (!$councillor) {
                $this->Flash->error(__('Councillor not Found!!!'));
                $this->redirect('/councillor/logout');
            }
        } catch (Exception $ex) {

            $this->Flash->error(__('Councillor not Found!!!'));
            $this->redirect('/councillor/logout');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sent_data = $this->request->getData();
            $councillor = $this->Councillors->patchEntity($councillor, $this->request->getData()/*, ['validate' => 'profile']*/);

            if (!empty($sent_data['password']) && !empty($sent_data['passwd']) && $sent_data['password'] == $sent_data['passwd']) {
                $councillor->password = $sent_data['password'];
            } else {
                $councillor->password = "";
                unset($councillor->password);
            }
            if (empty($councillor->councillorname))
                $councillor->councillorname = $councillor->email;

            if ($this->Councillors->save($councillor)) {
                $this->Flash->success(__('The profile date has been saved.'));

                // return $this->redirect(['action' => 'accountInfo']);
            } else

                // dd($councillor->getErrors());
                $this->Flash->error(__('The profile data could not be saved. Please, try again.'));
        }
        $this->set(compact('councillor'));
        // $this->set('councillor', $councillorEntity);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);
    }


    public function accountInfo()
    {
        $councillor_session = $this->Auth->user();
        $councillor = $this->Councillors->get($councillor_session["id"]);
        $this->set(compact('councillor'));

        $advertising_questions_section = $this->getSnippet('advertising-questions-section');
        $this->set("advertising_questions_section", $advertising_questions_section);
    }

    public function dashboard()
    {


        $councillor = $this->Auth->user();
        // $this->set_dynamic_layout("dashboard");
        // $this->pageTitle = $h1 = __("Dashboard", true);
        $data  = array();
        // if (!empty($councillor)) {
        //     try {
        //code...

        $councillorEntity = $this->Councillors->newEmptyEntity();

        $data = $this->Councillors->patchEntity($councillorEntity, $councillor);
        // dd($councillor);
        // $data            = $this->Councillors->get($councillor);

        // dd($data);
        //     } catch (\Throwable $th) {
        //         //throw $th;

        //         // dd($councillor->getErrors());
        //         $this->redirect('/');
        //     }
        // } else {
        //     $this->redirect('/');
        // }
        $this->set('data', $data);
        // $this->set('edit', 1);
        // $this->loadModel('Ads');
        // $this->set('presenter_dashboard_ad', $this->Ads->get_ads('councillor-dashboard'));
        //$this->set('levels', $this->Councillors->PresenterSkill->levels);
        // $this->set('h1', $h1);
    }
    public function _profile()
    {
        $councillor = $this->is_councillor();
        if (!$this->is_councillor()) {
            $this->Flash->error('You must login first', "fail alert alert-error");
            $this->redirect('/councillor/register');
        }
        // $this->get_dynamic_layout("dashboard");
        if (!empty($this->data)) {
            $this->Councillors->id = $councillor['id'];
            if (!empty($this->data['password']) && !$councillor['confirmed']) {
                $this->data['confirmed'] = 1;
            }
            $need_verification = false;

            // if ($this->data['email'] != $councillor['email']) {
            //     $need_verification                       = true;
            //     $data['hash']                    = "";
            //     $data['confirm_email']           = 0;
            //     $data['verification_email_sent'] = 0;
            // }

            if ($this->Councillors->saveCouncillor($this->data, $councillor['id'])) {
                $councillor = $this->Councillors->get($this->Councillors->id);
                // if ($need_verification) {
                //     $this->_send_verification_email($councillor);
                // }
                $this->Session->write('councillor', $councillor);
                $this->Flash->success(__("Your profile has been saved successfully.", true), "Sucmessage alert alert-Sucmessage");
                $this->redirect(array('controller' => 'councillors', 'action' => 'profile'));
            } else {
                $this->Flash->error(__("Your profile could not be saved.", true), "fail alert alert-error");
            }
        } else {

            unset($councillor['password']);
            $this->data = $councillor;
            unset($this->data["id"]);
        }
        $this->pageTitle = $h1 = __("My Profile", true);
        $this->set('h1', $h1);
    }
}
