<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use \Cake\Http\Session;
use Cake\Event\EventInterface;
use \Cake\Utility\Inflector;

use Cake\Core\Configure;
use \Cake\Http\Cookie;
use Cake\I18n\I18n;

use Cake\ORM\TableRegistry;
use App\Model\Table\MenusTable;
use Cake\Utility\Hash;
use \Zend\Diactoros\UploadedFile;

class AppController extends Controller
{
    public $prefixesNeedMenues = ['admin', 'user', 'councillor'];
    public $sideMenus = array();
    public $g_configs = array();
    public $locale_pr = "";
    public $permissions_ids = array();
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Session');
        // $this->loadComponent('Auth');
        $this->set('prefix', $this->request->getParam('prefix'));

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        if (empty($_SERVER["HTTPS"])) {
            $local = array(
                '127.0.0.1',
                '::1'
            );

            if (!(!empty($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $local))) {

                $this->redirect("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            }
        }
        $this->setDefaultLayout();

        // $isIP = (bool)ip2long($_SERVER['HTTP_HOST']);
        // print_r($_SERVER['HTTP_HOST']);
        // echo "----------";
        // var_dump($isIP);
        // die;
        // //https://162.240.42.17/dashboard/

        ini_set('memory_limit', '1024M');

        // $this->loadModel('Admins');
        // $admin = $this->Admins->get(4, [
        //     'contain' => [],
        // ]);
        // $admin->password = '123456';

        //     $this->Admins->save($admin);
        //     die('done');

        $permitted_controllers = ["Roles"];
        $current_controller = $this->request->getParam('controller');
        $current_action = $this->request->getParam('action');

        // echo $current_controller."-------".$current_action;die;
        if ($current_action == "deleteMulti") {
            $current_action = "delete";
        }
        if (in_array($current_action, ["loadFilesClassification", "classify", "submitClassifiedFiles"])) {
            $current_action = "classification";
        }
        if (in_array($current_action, ["loadFilesAnnotation", "annotate", "submitAnnotatedFiles"])) {
            $current_action = "annotation";
        }
        if (in_array($current_action, ["loadFilesReview", "doReview", "submitReviewedFiles"])) {
            $current_action = "review";
        }
        if ($current_controller == "Releases" &&  in_array($current_action, ["download", "dailyCron", "downloadAnnotations"])) {
            $current_action = "daily";
        }
        $current_prefix = $this->request->getParam('prefix') != null ? strtolower($this->request->getParam('prefix')) : '';

        $this->set(compact('current_controller', 'current_action', 'current_prefix'));
        // debug($current_prefix);
        if (isset($this->authCom) && !empty($this->Auth->user())) {
            if (
                in_array($current_controller, $permitted_controllers) ||
                ($current_controller == "Localizations" && $current_action == "setLocale")
                || ($current_controller == "Admins" && $current_action == "login")
                || ($current_controller == "Admins" && $current_action == "logout")
                || ($current_controller == "Admins" && $current_action == "dashboard")
                || ($current_controller == "GeneralConfigurations" && $current_action == "enableRandomSelection")
                || ($current_action == "resetFilter")
                || ($current_action == "updateDisplayOrder")
                || ($current_controller == "Menus")
                || ($current_controller == "Files" && $current_action == "cronZipDailyFiles")
                || ($current_controller == "Files" && $current_action == "generateDemoFiles")

                || ($current_controller == "Users")
                || ($current_controller == "Councillors")
                // || ($current_controller == "Users" && $current_action == "register")
                // || ($current_controller == "Users" && $current_action == "logout")
                // || ($current_controller == "Users" && $current_action == "dashboard")
                // || ($current_controller == "Users" && $current_action == "forgotPassword")
                // || ($current_controller == "Users" && $current_action == "resetPassword")
                // || ($current_controller == "Users" && $current_action == "forgotPasswordSuccess")
            ) {
            } else {
                if (!$this->is_permitted($current_controller, $current_action)) {
                    die("You don't have a permission to do this action.");
                }
            }
        }

        $permissions_list = $this->permissions_list();
        $this->set('permissions_list', $permissions_list);
        // echo $current_controller."------".$current_action;die;

        if (isset($this->authCom) && !empty($this->Auth->user())) {
            if ($this->checkIfSuperadmin()) {
                $this->set('is_super_admin', true);
            } else {
                $this->set('is_super_admin', false);
            }
            $logged_user_info = $this->Auth->user();
            $this->set('logged_user_info', $logged_user_info);
        }

        $session = $this->getRequest()->getSession();

        if ($session->check('locale')) {
            $locale = $session->read('locale');
            I18n::setLocale($locale);
        } else {
            $locale = I18n::getLocale();
            // $session->write('locale', $locale);
        }
        // print_r($_SESSION);die;
        $direction = 'ltr';
        $locale = Configure::read('App.defaultLocale');
        $switchLang = 'ar';
        $currLang = 'en';
        $date_picket_orientation = 'left';
        $locale_pr = "";
        if ($this->Session->check('locale')) {
            $locale = $this->Session->read('locale');

            if ($locale == 'ar_AE') {
                $switchLang = 'en';
                $currLang = 'ar';
                $direction = 'rtl';
                $date_picket_orientation = 'right';
                $locale_pr = "_ar";
            } else {
                $direction = '';
                $switchLang = 'ar';
                $currLang = 'en';
                $date_picket_orientation = 'left';
                $locale_pr = "";
            }
        }
        $this->locale_pr = $locale_pr;
        $this->set('switchLang', $switchLang);
        $this->set('currLang', $currLang);
        $this->set('direction', $direction);
        $this->set('date_picket_orientation', $date_picket_orientation);

        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "http" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $current_url_arr = explode("?", $current_url);
        $this->set('current_url_without_parameters', $current_url_arr[0]);

        $current_prefix = $this->request->getParam('prefix') != null ? strtolower($this->request->getParam('prefix')) : '';

        $this->set('current_prefix', $current_prefix);
        if (in_array($current_prefix, $this->prefixesNeedMenues)) {

            $this->_loadMenuItems();
        } else {
        }

        $header = $this->getSnippet("header");
        // print_r($header);
        $footer = $this->getSnippet("footer");
        $this->set('header', $header);
        $this->set('footer', $footer);

        $this->loadModel('Countries');
        $countries = $this->Countries->find()->where(['active' => 1, 'continent is not null and continent !=""'])->order(['display_order' => 'asc'])->all();
        $countriesData = Hash::combine($countries->toArray(), '{n}.id', '{n}', '{n}.continent');

        // $countryEarth = Hash::combine($countries->toArray(), '{n}.id', '{n}', '{n}.continent');
        // debug($countries);

        $this->set('countries', $countriesData);
        $this->set('countriesEarth', $countries->toArray());
        $this->set('continents', $this->Countries->continents);

        $this->loadModel('Services');
        $this->set('serviceTypes', $this->Services->types);
        $services = $this->Services->find()->where(['active' => 1])->order(['type' => 'ASC', 'display_order' => 'asc'])->all();
        $footerServices = $this->Services->find()->where(['active' => 1, 'show_on_footer' => 1])->order(['type' => 'ASC', 'display_order' => 'asc'])->all();

        $this->set('servicesList', $services);
        $services = Hash::combine($services->toArray(), '{n}.id', '{n}', '{n}.type');

        $this->set('servicesMenuList', $services);
        $this->set('footerServices', $footerServices);

        $this->loadModel('Events');
        $events = $this->Events->find()->where(['active' => 1])->order(['display_order' => 'asc'])->all();
        $this->set('eventsMenuList', $events);
        $this->_loadConfig();
    }
    protected function _loadConfig()
    {
        $this->loadModel("GeneralConfigurations");
        $all_configs = $this->GeneralConfigurations->find()->where()->toArray();
        $configs = [];
        foreach ($all_configs as $config_row) {
            $configs[$config_row->config_group][$config_row->field] = $config_row->value;
        }
        $this->g_configs = $configs;
        $this->set("g_configs", $configs);
    }

    public function setDefaultLayout()
    {
        $prefix = $this->request->getParam('prefix');
        if (isset($prefix) && !empty($prefix)) {
            $this->set('layoutUrlPrefix', Inflector::dasherize($prefix));

            switch (Inflector::dasherize($prefix)) {

                case 'admin':
                    $this->viewBuilder()->setLayout('admin');
                    $this->authCom = $this->loadComponent('Auth', [
                        'authenticate' => [
                            'Basic' => ['userModel' => 'Admins'],
                            'Form' => [
                                'userModel' => 'Admins',
                                'fields' => ['username' => 'name', 'password' => 'password'],
                            ],
                        ],
                        'loginAction' => [
                            'controller' => 'Admins',
                            'action' => 'login',
                        ],
                        'loginRedirect' => [
                            'controller' => 'Admins',
                            'action' => 'dashboard',
                        ],
                        'logoutRedirect' => [
                            'controller' => 'Admins',
                            'action' => 'login',
                        ],
                        'storage' => [
                            'className' => 'Session',
                            'key' => 'Auth.Admin',
                        ],
                        'unauthorizedRedirect' => $this->referer(),
                    ]);
                    $this->Auth->allow(['cronZipDailyFiles']);

                    if ($this->Auth->user()) {
                        $this->set('auth', $this->Auth);
                    }
                    $this->set('admin_title_prefix', "BESA System");
                    break;

                case 'user':
                    $this->viewBuilder()->setLayout('default');
                    $this->authCom = $this->loadComponent('Auth', [
                        'authenticate' => [
                            'Basic' => ['userModel' => 'Users'],
                            'Form' => [
                                'userModel' => 'Users',
                                'fields' => ['username' => 'email', 'password' => 'password'],
                            ],
                        ],
                        'loginAction' => [
                            'controller' => 'Users',
                            'action' => 'register',
                        ],
                        'loginRedirect' => [
                            'controller' => 'Users',
                            'action' => 'dashboard',
                        ],
                        'logoutRedirect' => [
                            'controller' => 'Users',
                            'action' => 'register',
                        ],
                        'storage' => [
                            'className' => 'Session',
                            'key' => 'Auth.User',
                        ],
                        'unauthorizedRedirect' => $this->referer(),
                    ]);
                    $this->Auth->allow(['login', 'logout', 'register', 'confirmEmail', 'forgotPassword', 'resetPassword', 'forgotPasswordSuccess', 'cronZipDailyFiles']);

                    if ($this->Auth->user()) {
                        $this->set('auth', $this->Auth);
                    }
                    $this->set('user_title_prefix', "BESA System");
                    $this->set('urlPrefixText', "User");
                    $this->set('pageHead', "User");
                    break;

                case 'councillor':
                    $this->viewBuilder()->setLayout('default');
                    $this->authCom = $this->loadComponent('Auth', [
                        'authenticate' => [
                            'Basic' => ['userModel' => 'Councillors'],
                            'Form' => [
                                'userModel' => 'Councillors',
                                'fields' => ['username' => 'email', 'password' => 'password'],
                            ],
                        ],
                        'loginAction' => [
                            'controller' => 'Councillors',
                            'action' => 'register',
                        ],
                        'loginRedirect' => [
                            'controller' => 'Councillors',
                            'action' => 'dashboard',
                        ],
                        'logoutRedirect' => [
                            'controller' => 'Councillors',
                            'action' => 'register',
                        ],
                        'storage' => [
                            'className' => 'Session',
                            'key' => 'Auth.Councillor',
                        ],
                        'unauthorizedRedirect' => $this->referer(),
                    ]);
                    $this->Auth->allow(['login', 'logout', 'register', 'confirmEmail', 'forgotPassword', 'resetPassword', 'forgotPasswordSuccess', 'cronZipDailyFiles']);

                    if ($this->Auth->user()) {
                        $this->set('auth', $this->Auth);
                    }
                    $this->set('user_title_prefix', "BESA System");
                    $this->set('urlPrefixText', "Councillor");
                    $this->set('pageHead', "Councillor");
                    break;

                default:
                    $this->viewBuilder()->setLayout('default');
            }
        }
    }

    public function checkIfSuperadmin()
    {
        $user = $this->Auth->user();

        if (!empty($user) && isset($user['super_admin']) && $user['super_admin'] == true) {
            return true;
        }
        return false;
        // $this->Flash->error(__('you are not authorized to view this page please contact system administrator'));
        // return $this->redirect('/admin');
    }

    public function is_permitted($controller, $action)
    {
        if (empty($controller) || empty($action)) {
            return false;
        }
        $this->loadModel("Permissions");
        $this->loadModel("RolesPermissions");
        $permission_row = $this->Permissions->find()->where(['controller' => $controller, 'action' => $action])->first();
        if (!empty($permission_row)) {
            $permission_row = $permission_row->toArray();
        }
        if (empty($permission_row)) {
            return false;
        }

        $user = $this->Auth->user();
        // print_r($user);die;
        if (empty($user)) {
            return false;
        }

        $role_permission_row = $this->RolesPermissions->find()->where(['role_id' => $user["role_id"], 'permission_id' => $permission_row["id"]])->first();
        if (empty($role_permission_row)) {
            return false;
        }
        return true;
    }
    public function permissions_list()
    {
        $permitted_list = [];

        $this->loadModel("RolesPermissions");
        $this->loadModel("Permissions");

        // if(empty($this->authCom)){
        //     return $permitted_list;
        // }
        $prefix = $this->request->getParam('prefix');
        if (isset($prefix) && !empty($prefix)) {
            $user = $this->Auth->user();

            if (!isset($user["role_id"])) {

                // $permitted_list = ['login', 'logout','register','profile','dashboard', 'forgotPassword','resetPassword','forgot-password-success'];
                return $permitted_list;
            }
            if (empty($user)) {
                return $permitted_list;
            }
            $all_role_permissions = $this->RolesPermissions->find()->where(['role_id' => $user["role_id"]])->toArray();

            $permissions_ids = [];
            foreach ($all_role_permissions as $key => $value) {
                $permissions_ids[] = $value->permission_id;
            }
            $this->permissions_ids = $permissions_ids;

            $related_permissions = $this->Permissions->find()->where(['id IN' => $permissions_ids])->toArray();
            foreach ($related_permissions as $key => $value) {
                $perm_key = $value->controller . "_" . $value->action;
                $permitted_list[] = $perm_key;
            }
        }
        return $permitted_list;
    }

    protected function _filter_params($params = false, $filter_name = 'filters')
    {
        // print_r($params);die;
        $modelName = $this->name;

        $conditions = array();
        if (!empty($this->modelName)) {
            $modelName = $this->modelName;
        }
        $session = $this->getRequest()->getSession();

        $filters = false;
        $ignore_session = false;
        // debug($this->{$modelName}->filters);
        if (!empty($this->{$modelName}->{$filter_name})) {
            $filters = $this->{$modelName}->{$filter_name};
        } else {
            $this->set(compact('filters', 'modelName'));
            return $conditions;
        }

        // $modelName =$this->{$modelName}->getTable();
        // $modelName = Inflector::underscore($modelName);
        $this->set(compact('filters', 'modelName'));
        $allParams = $this->request->getAttribute('params');
        $filterKey = $allParams['controller'] . '_' . $allParams['action'] . "_Filter";
        // dd($filterKey);
        // debug($filterKey);
        $url_params = $this->request->getQuery();

        unset($url_params['url'], $url_params['page'], $url_params['sort'], $url_params['direction']);



        $params = empty($params) ? $url_params : $params;
        // print_r($params);die;
        $sessionParams = $session->read($filterKey);

        if (!$ignore_session && $sessionParams && empty($params)) {
            $params = $sessionParams;
        } elseif (!$ignore_session && !empty($params)) {
            $session->write($filterKey, $params);
        }

        foreach ($filters as $field => $filters) {
            if (is_numeric($field)) {
                $field = $filters;
                $type = '=';
                $param = $field;
            } elseif (is_string($filters)) {
                $type = $filters;
                $param = $field;
            } elseif (is_array($filters)) {
                $type = empty($filters['type']) ? '=' : $filters['type'];
                $param = $field;
            }
            switch (strtolower($type)) {
                case '=':

                    if (!empty($params[$param]) || (isset($params[$param]) && strval($params[$param]) === '0')) {
                        if (!is_numeric($params[$param])) {
                            if (is_array($params[$param])) {
                                $conditions["{$modelName}.$field in"] = $params[$param];
                            } else {
                                $conditions["lower({$modelName}.$field)"] = strtolower($params[$param]);
                            }
                        } else {
                            $conditions["{$modelName}.$field"] = $params[$param];
                        }
                    }
                    break;
                case 'like':
                    if (!empty($params[$param]) || (isset($params[$param]) && strval($params[$param]) === '0')) {
                        $params[$param] = strtolower($params[$param]);
                        $conditions["lower({$modelName}.$field) LIKE"] = "%{$params[$param]}%";
                    }
                    break;
                case 'date_range':

                    $from = empty($filter['from']) ? $field . '_from' : $filter['from'];
                    $to = empty($filter['to']) ? $field . '_to' : $filter['to'];

                    // $from_param = empty($filters['from']) ? ($param . "_from") : $filters['from'];
                    // $to_param = empty($filters['from']) ? ($param . '_to') : $filters['to'];

                    if (!empty($params[$param . "_from"])) {

                        $conditions["{$modelName}.$field >="] = date('Y-m-d 00:00:00', strtotime($params[$param . "_from"]));
                    }
                    if (!empty($params[$param . '_to'])) {

                        $conditions["{$modelName}.$field <="] = date('Y-m-d 23:59:59', strtotime($params[$param . '_to']));
                    }
                    break;
                case 'date_time_range':

                    $from_param = empty($filter['from']) ? $field . "_from" : $filter['from'];
                    $to_param = empty($filter['from']) ? $field . '_to' : $filter['to'];


                    if (!empty($params[$from_param])) {
                        if (!empty($params[$from_param . "Time"])) {
                            $conditions["{$modelName}.$field >="] = date('Y-m-d H:i:s', strtotime($params[$from_param] . $params[$from_param . "Time"]));
                        } else {
                            $conditions["{$modelName}.$field >="] = date('Y-m-d 00:00:00', strtotime($params[$from_param]));
                        }
                    }
                    if (!empty($params[$to_param])) {
                        if (!empty($params[$to_param . "Time"])) {
                            $conditions["{$modelName}.$field <="] = date('Y-m-d H:i:s', strtotime($params[$to_param] . $params[$to_param . "Time"]));
                        } else {
                            $conditions["{$modelName}.$field <="] = date('Y-m-d 23:59:59', strtotime($params[$to_param]));
                        }
                    }
                    break;
                case 'number_range':
                    $from_param = empty($filters['from']) ? 'from' : $filters['from'];
                    $to_param = empty($filters['from']) ? 'to' : $filters['to'];
                    if (!empty($params[$param . "_from"]) || (isset($params[$param]) && strval($params[$param . "_from"]) === '0')) {
                        $conditions["{$modelName}.$field >="] = $params[$from_param];
                    }
                    if (!empty($params[$param . '_to']) || (isset($params[$param . '_to']) && strval($params[$param . '_to']) === '0')) {
                        $conditions["{$modelName}.$field <="] = $params[$param . '_to'];
                    }
                    break;
                default:
                    if (!empty($params[$param]) || (isset($params[$param]) && strval($params[$param]) === '0')) {
                        $conditions["{$modelName}.$field $type"] = $params[$param];
                    }
                    break;
            }
        }
        // dd($conditions);


        return $conditions;
    }
    public function resetFilter($action)
    {
        // dsadsad
        // dd();
        $this->autoRender = false;
        $modelName = Inflector::pluralize($this->name);
        // debug($modelName);

        if (!empty($this->modelName)) {
            $modelName = $this->modelName;
        }
        $allParams = $this->request->getAttribute('params');

        $filterKey = $allParams['controller'] . '_' . $action . "_Filter";
        // dd($filterKey);
        $session = $this->getRequest()->getSession();
        // debug($session->read());die;
        $session->delete($filterKey);
        echo "Success";
    }
    public function updateDisplayOrder()
    {
        $params = $this->request->getAttribute('params');
        $model = Inflector::camelize($this->name);

        foreach ($this->request->getData() as $field => $value) {
            if (strpos($field, 'display_order') === false) {
                continue;
            }
            $id = substr($field, strlen('display_order_'));
            $table = TableRegistry::getTableLocator()->get($model);
            $data = $table->get($id);
            $data->display_order = intval($value);
            $table->save($data);
        }
        if ($this->request->is('ajax')) {
            die(json_encode(array('status' => 'success', 'message' => 'Display Order Updated Successfully')));
        } else {
            $this->redirect($this->referer(array('action' => 'index'), true));
        }
    }

    // ************************************************
    // ****************** Menus Work ******************
    // ************************************************
    public function _loadMenuItems($reFind = false)
    {
        $prefix = empty($this->request->getParam('prefix')) ? '' : strtolower($this->request->getParam('prefix'));

        if (empty($this->sideMenus[$prefix]) || $reFind) {
            $conditions = array();
            $conditions['active'] = true;
            $conditions['prefix'] = $prefix;
            if (!empty($this->permissions_ids)) {
                $conditions['permission_id in'] = $this->permissions_ids;
            } else {
                $conditions['permission_id in'] = "-1";
            }
            $this->Menus = new MenusTable();
            $menus = $this->Menus->find('threaded')->where($conditions)->order('display_order asc')->all();

            $this->sideMenus[$prefix] = $this->checkmenu($menus->toArray(), $prefix);
            // print_r($this->sideMenus);die;
            $this->set('sideMenus', $this->sideMenus);
        } else {
            $this->set('sideMenus', $this->sideMenus[$prefix]);
        }
    }

    public function checkmenu($menus, $prefix)
    {
        $current_url = $_SERVER['REQUEST_URI'];
        $current_url = str_replace('/work/annotation', '', $current_url);
        $current_url = str_replace('/annotation/', '/', $current_url);

        $read_path = array();
        $uniqe_url = array();
        $write_path = array();
        $session = $this->getRequest()->getSession();

        $read_url = $session->read("{$prefix}_menu_path");


        foreach ($menus as $k1 => $menu) {

            if (isset($uniqe_url[$menu->link])) {
                $menus[$k1]->link = $menu->link . "?m_key=" .  $menu->id;
            }
            $uniqe_url[$menu->link] = true;
            if (isset($uniqe_url["#"])) {
                unset($uniqe_url["#"]);
            }
            if ($menu->full_link == $read_url) {
                $read_path[1] = $k1;
            }

            if ($menu->full_link == $current_url) {
                $write_path[1] = $k1;
            }

            foreach ($menu->children as $k2 => $child) {

                if (isset($uniqe_url[$child->link])) {
                    $menus[$k1]->children[$k2]->link = $child->link . "?m_key=" . $child->id;
                }

                $uniqe_url[$child->link] = true;
                if (isset($uniqe_url["#"])) {
                    unset($uniqe_url["#"]);
                }

                if ($child->full_link == $read_url) {
                    $read_path[1] = $k1;
                    $read_path[2] = $k2;
                }

                if ($child->full_link == $current_url) {
                    $write_path[1] = $k1;
                    $write_path[2] = $k2;
                }

                foreach ($child->children as $k3 => $ch) {
                    if (isset($uniqe_url[$ch->link])) {
                        $menus[$k1]->children[$k2]->children[$k3]->link = $ch->link . "?m_key=" . $ch->id;
                    }
                    $uniqe_url[$ch->link] = true;
                    if (isset($uniqe_url["#"])) {
                        unset($uniqe_url["#"]);
                    }
                    if ($ch->full_link == $read_url) {
                        $read_path[1] = $k1;
                        $read_path[2] = $k2;
                        $read_path[3] = $k3;
                    }

                    if ($ch->full_link == $current_url) {
                        $write_path[1] = $k1;
                        $write_path[2] = $k2;
                        $write_path[3] = $k3;
                    }

                    foreach ($ch->children as $k4 => $chil4) {
                        if (isset($uniqe_url[$chil4->link])) {
                            $menus[$k1]->children[$k2]->children[$k3]->link = $chil4->link . "?m_key=" . $chil4->id;
                        }
                        $uniqe_url[$chil4->link] = true;

                        if (isset($uniqe_url["#"])) {
                            unset($uniqe_url["#"]);
                        }
                        if ($chil4->full_link == $read_url) {
                            $read_path[1] = $k1;
                            $read_path[2] = $k2;
                            $read_path[3] = $k3;
                        }

                        if ($chil4->full_link == $current_url) {
                            $write_path[1] = $k1;
                            $write_path[2] = $k2;
                            $write_path[3] = $k3;
                        }


                        foreach ($chil4->children as $k5 => $chil5) {
                            if (isset($uniqe_url[$chil5->link])) {
                                $menus[$k1]->children[$k2]->children[$k3]->link = $chil5->link . "?m_key=" . $chil5->id;
                            }
                            $uniqe_url[$chil5->link] = true;

                            if (isset($uniqe_url["#"])) {
                                unset($uniqe_url["#"]);
                            }
                            if ($chil5->full_link == $read_url) {
                                $read_path[1] = $k1;
                                $read_path[2] = $k2;
                                $read_path[3] = $k3;
                                $read_path[4] = $k4;
                            }

                            if ($chil5->full_link == $current_url) {
                                $write_path[1] = $k1;
                                $write_path[2] = $k2;
                                $write_path[3] = $k3;
                                $write_path[4] = $k4;
                            }
                        }
                    }
                }
            }
        }

        if (count($write_path) > 0) {
            $session->write("{$prefix}_menu_path", $current_url);
            $menus[$write_path[1]]->is_opened = true;

            if (isset($write_path[2]))
                $menus[$write_path[1]]->children[$write_path[2]]->is_opened = true;

            if (isset($write_path[3]))
                $menus[$write_path[1]]->children[$write_path[2]]->children[$write_path[3]]->is_opened = true;

            if (isset($write_path[4]))
                $menus[$write_path[1]]->children[$write_path[2]]->children[$write_path[3]]->children[$write_path[4]]->is_opened = true;
        } else if (count($read_path) > 0) {
            $menus[$read_path[1]]->is_opened = true;

            if (isset($read_path[2]))
                $menus[$read_path[1]]->children[$read_path[2]]->is_opened = true;

            if (isset($read_path[3]))
                $menus[$read_path[1]]->children[$read_path[2]]->children[$read_path[3]]->is_opened = true;

            if (isset($read_path[4]))
                $menus[$read_path[1]]->children[$read_path[2]]->children[$read_path[3]]->children[$read_path[4]]->is_opened = true;
        }

        return $menus;
    }
    protected function __insert_file_log($log_data)
    {
        $this->loadModel("FileLogs");
        $file_log = $this->FileLogs->newEmptyEntity();
        $file_log = $this->FileLogs->patchEntity($file_log, $log_data);
        if ($this->FileLogs->save($file_log)) {
            return true;
        }
        return false;
    }

    protected function _zip_files_for_release($files_list_to_zip)
    {
        $upload_path = str_replace('webroot/index.php', '', $_SERVER["SCRIPT_FILENAME"]);
        $upload_path .= 'webroot/uploads/';

        $zip = new \ZipArchive();
        $zf_name = "release-" . date("d-m-Y") . ".zip";
        $zipFilePath = $upload_path . 'zip_files/' . $zf_name;

        if (file_exists($zipFilePath)) {
            $zf_name = "release-" . date("d-m-Y") . "-" . rand(1, 1000) . ".zip";
            $zipFilePath = $upload_path . 'zip_files/' . $zf_name;
            // unlink ($_SERVER['DOCUMENT_ROOT']."/TEST/".$DelFilePath); 
        }
        if ($zip->open($zipFilePath, \ZIPARCHIVE::CREATE) != TRUE) {
            die("Could not open archive");
        }
        foreach ($files_list_to_zip as $file_name) {
            $zip->addFile($upload_path . 'files/' . $file_name, $file_name);
        }
        $zip->close();
        if (file_exists($zipFilePath)) {
            return $zf_name;
        }
        return false;
    }

    public function _ajaxImageUpload($name, $table, $id = false, $where = false, $fields = false)
    {
        $this->createImageToken($name);
        $this->setTempImages($table, $id, $where, $fields);
    }

    public function createImageToken($name)
    {

        if (!$this->Session->read($name . "_token")) {
            $token = md5(time() . $name);
            $this->Session->write($name . "_token", $token);
            $this->set("mainAdminToken", $token);
        } else {
            $token = $this->Session->read($name . "_token");
            $this->set("mainAdminToken", $token);
        }
    }
    public function userToken()
    {

        if (!$this->Session->read("user_token")) {
            $token = md5(time() . '');
            $this->Session->write("user_token", $token);
            $this->set("user_token", $token);
        } else {
            $token = $this->Session->read("user_token");
            $this->set("user_token", $token);
        }
        return $token;
    }

    public function setTempImages($table, $id = false, $where = false, $fields = [])
    {

        if (!$id) {
            return true;
        }
        $this->loadModel('TempFiles');

        // $this->TempFiles->deleteAll(['temp_token' => $ids]);
        $temp_images = $this->TempFiles->find('list', [
            'keyField' => 'id',
            'valueField' => 'temp_token',
        ])->where(array("temp_token" => $id));

        $temp_images = $temp_images->toArray();
        // $this->TempFiles->deleteAll(['temp_token' => $id]);

        $_arr = [];
        // $tt = $this->loadTable($table);
        // $table = $tt->getAlias();
        $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));

        $this->loadModel($table);
        $images = $this->{$table}->find();
        if ($where) {
            $images = $images->where($where);
        }
        if (!empty($fields)) {
            $fields['id'] = 'id'; // to make an condithion only we will un set this latter
            $images = $images->select($fields);
        }
        unset($fields['id']);
        $images = $images->all()->toArray();


        if ($images) {
            foreach ($images as $item) {
                if (in_array($item['id'], $temp_images)) {
                    continue;
                }


                foreach ($fields as $field) {

                    if (!$item[$field] && !$item[$field . '_path']) {
                        continue;
                    }

                    $name = '';
                    if (isset($item[$field . '_path'])) {
                        $image_ = WWW_ROOT . $item[$field . '_path'];
                        $name = $item[$field . '_path'];
                    } elseif (isset($item[$field])) {
                        $image_ = WWW_ROOT . $item[$field];
                        $name = $item[$field];
                    }
                    $temp = $this->TempFiles->newEmptyEntity();
                    $temp->name = $name;
                    $temp->temp_token = $id;
                    $temp->field_name = $field;
                    $temp->display_order = $item['display_order'];
                    $temp->hash = uniqid();

                    $image_ = WWW_ROOT . $name;

                    if (file_exists($image_) && isset($item[$field])) {
                        $file = [
                            $field => new UploadedFile(
                                $image_,
                                filesize($image_), // filesize in bytes
                                0, // upload (error) status
                                basename($item[$field]), // upload filename
                                mime_content_type($image_) // upload mime type
                            ),
                        ];
                        $file = $file[$field];
                        $tmpName = $file->getStream()->getMetadata('uri');
                        $targetPath = $this->tempPath . $file->getClientFilename();
                        $up = copy($tmpName, $targetPath);
                        $temp->name = $file->getClientFilename();
                    }
                    $_arr[] = $temp;
                    $this->TempFiles->save($temp);
                }
            }
            // debug($_arr);die;

            // die;
        }
    }


    public function getSnippet($name)
    {

        // $this->loadModel('Snippets');
        return TableRegistry::getTableLocator()->get('Snippets')->getContent($name);
    }


    public function sendEmail($to = false, $from = false, $email_template_name, $replace, $attachments = false)
    {

        $local = array(
            '127.0.0.1',
            '::1'
        );

        if (!(!empty($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $local))) {
            $this->loadComponent('EmailSender');
            $this->EmailSender->send($to, $from, $email_template_name, $replace, $attachments);
        }
        return true;
    }


    public function getWishLists()
    {

        $wishLists = [];

        $this->loadModel('WishLists');
        if (isset($_SESSION['Auth']['User'])) {
            $user = $_SESSION['Auth']['User'];

            // $wishLists = $this->WishLists->find()->where(['user_id' => $user['id']])->order(['display_order' => 'asc'])->all();
            $wishLists = $this->WishLists->find('list', [
                'keyField' => 'course_id', 'valueField' => 'course_id'
            ])->where(['user_id' => $user['id']])->order(['display_order' => 'asc'])->toArray();
        } else {

            $token = $this->userToken();
            $wishLists = $this->WishLists->find('list', [
                'keyField' => 'course_id', 'valueField' => 'course_id'
            ])->where(['user_token' => $token])->order(['display_order' => 'asc'])->toArray();
        }
        return $wishLists;
    }
}
