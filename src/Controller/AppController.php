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
use Cake\Cache\Cache;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use \Zend\Diactoros\UploadedFile;

class AppController extends Controller
{
    public $prefixesNeedMenues = ['admin', 'user', 'counselor'];
    public $sideMenus = array();
    public $g_configs = array();
    public $g_dynamic_routes = array();
    public $locale_pr = "";
    public $permissions_ids = array();
    public $permissions_list = [];

    protected $tempPath = WWW_ROOT . 'files' . DS . 'temp_files' . DS;
    public $pageTitle = null;
    public $metaDescription = null;
    public $metaKeywords = null;
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
    public function _checkDebug()
    {

        $session = $this->getRequest()->getSession();

        if (isset($_GET['debug'])) {
            if ($_GET['debug'] == 0) {
                $session->write('debug', false);
            } else {
                $session->write('debug', true);
            }
        }
        if ($session->check('debug')) {
            $debuger = $session->read('debug');
            Configure::write('debug', $debuger);
            if ($debuger > 0) {
                $myApp = new \App\Application('/var/www/html/ozrepo/config');
                $myApp->addPlugin('DebugKit');
                // debug('DebugKit');
            }
        }
    }
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->_checkDebug();

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

        $permitted_controllers = ["Roles", "Menus"];
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
                (in_array($current_controller, $permitted_controllers) && $this->checkIfSuperadmin()) ||
                ($current_controller == "Localizations" && $current_action == "setLocale")
                || ($current_controller == "Admins" && $current_action == "login")
                || ($current_controller == "Admins" && $current_action == "logout")
                || ($current_controller == "Admins" && $current_action == "dashboard")
                || ($current_controller == "GeneralConfigurations" && $current_action == "enableRandomSelection")
                || ($current_action == "resetFilter")
                || ($current_action == "updateDisplayOrder")
                // || ($current_controller == "Menus")
                // || ($current_controller == "Files" && $current_action == "cronZipDailyFiles")
                // || ($current_controller == "Files" && $current_action == "generateDemoFiles")

                || ($current_controller == "Users" && $current_prefix == 'user')
                || ($current_controller == "Counselors" && $current_prefix == 'counselor')
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

        $this->permissions_list = $permissions_list = $this->permissions_list();

        // dd($this->permissions_list());
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

            // SEO functions
            // $this->_set_seo();
        }

        // $header = $this->getSnippet("header");
        // // print_r($header);
        // $footer = $this->getSnippet("footer");
        // $this->set('header', $header);
        // $this->set('footer', $footer);

        $this->loadModel('Countries');
        $countries = $this->Countries->find()->where(['active' => 1, 'continent is not null and continent !=""', 'is_destination' => 1])
            ->cache('countries_app_data')->order(['country_name' => 'asc'])->all();
        $countriesData = Hash::combine($countries->toArray(), '{n}.id', '{n}', '{n}.continent');

        // $countryEarth = Hash::combine($countries->toArray(), '{n}.id', '{n}', '{n}.continent');
        // debug($countries);

        $this->set('countries', $countriesData);
        $this->set('countriesEarth', $countries->toArray());
        $this->set('continents', $this->Countries->continents);

        // $this->loadModel('Services');
        // $this->set('serviceTypes', $this->Services->types);
        // $services = $this->Services->find()->where(['active' => 1])->order(['type' => 'ASC', 'title' => 'asc'])->all();
        // $footerServices = $this->Services->find()->where(['active' => 1, 'show_on_footer' => 1])->order(['type' => 'ASC', 'display_order' => 'asc'])->all();

        // $this->set('servicesList', $services);
        // $services = Hash::combine($services->toArray(), '{n}.id', '{n}', '{n}.type');

        // $this->set('servicesMenuList', $services);
        // $this->set('footerServices', $footerServices);

        $this->loadModel('Events');
        $events = $this->Events->find()->where(['active' => 1])->cache('events_app_menu_list')->order(['display_order' => 'asc'])->all();
        $this->set('eventsMenuList', $events);
        $this->_loadConfig();

        if (!in_array($current_prefix, $this->prefixesNeedMenues) || $current_action != 'admin') {

            // SEO functions
            $this->_set_seo();
            $this->allCoursesList();
            $this->loadDynamicRoutes();
        }
    }

    protected function _loadConfig()
    {
        $cached_config = Cache::read('configs', '_configs_');
        // dd($cached_config);
        if (empty($cached_config)) {
            $this->loadModel('GeneralConfigurations');
            $cached_config = $this->GeneralConfigurations->find()->where()->toArray();

            $configs = [];
            foreach ($cached_config as $config_row) {
                $configs[$config_row->config_group][$config_row->field] = $config_row->value;
            }
            $cached_config = $configs;
            Cache::write('configs', $cached_config, '_configs_');
        }
        $GLOBALS['Configs'] = $cached_config;
        $this->g_configs = $cached_config;

        $this->set("g_configs", $cached_config);
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

                case 'counselor':
                    $this->viewBuilder()->setLayout('default');
                    $this->authCom = $this->loadComponent('Auth', [
                        'authenticate' => [
                            'Basic' => ['userModel' => 'Counselors'],
                            'Form' => [
                                'userModel' => 'Counselors',
                                'fields' => ['username' => 'email', 'password' => 'password'],
                            ],
                        ],
                        'loginAction' => [
                            'controller' => 'Counselors',
                            'action' => 'login',
                        ],
                        'loginRedirect' => [
                            'controller' => 'Counselors',
                            'action' => 'dashboard',
                        ],
                        'logoutRedirect' => [
                            'controller' => 'Counselors',
                            'action' => 'login',
                        ],
                        'storage' => [
                            'className' => 'Session',
                            'key' => 'Auth.Counselor',
                        ],
                        'unauthorizedRedirect' => $this->referer(),
                    ]);
                    $this->Auth->allow(['index', 'login', 'logout', 'register', 'confirmEmail', 'forgotPassword', 'resetPassword', 'forgotPasswordSuccess', 'cronZipDailyFiles']);

                    if ($this->Auth->user()) {
                        $this->set('auth', $this->Auth);
                    }
                    $this->set('user_title_prefix', "BESA System");
                    $this->set('urlPrefixText', "Counselor");
                    $this->set('pageHead', "Counselor");
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
        // dd($controller.', '.$action);
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

        $this->set('user', $user);
        $role_permission_row = $this->RolesPermissions->find()->where(['role_id' => $user["role_id"], 'permission_id' => $permission_row["id"]])->first();
        if (empty($role_permission_row)) {
            return false;
        }
        return true;
    }
    public function permissions_list()
    {
        $permitted_list = [];
        $permissions_list = [];

        $cached_permissions = [];
        $cached_permissionsids = [];
        $prefix = $this->request->getParam('prefix');
        if (isset($prefix) && !empty($prefix)) {


            ///////////////
            $cached_permissions = Cache::read('permissions', '_permissions_');
            $cached_permissionsids = Cache::read('permissionsids', '_permissionsids_');
            // dd($cached_permissionsids);

            $user = $this->Auth->user();

            if (!isset($user["role_id"])) {

                return $permitted_list;
            }
            if (empty($user)) {
                return $permitted_list;
            }

            // debug($cached_permissions);
            // debug($cached_permissionsids);
            // dd((empty($cached_permissions) || !isset($cached_permissionsids[$user['role_id']]) || !isset($cached_permissions[$user['role_id']])));
            if (empty($cached_permissions) || !isset($cached_permissionsids[$user['role_id']]) || !isset($cached_permissions[$user['role_id']])) {

                $this->loadModel("RolesPermissions");
                $this->loadModel("Permissions");


                $all_role_permissions = $this->RolesPermissions->find()->where(['role_id' => $user["role_id"]])->toArray();
                // dd($all_role_permissions);

                $permissions_ids = [];
                foreach ($all_role_permissions as $key => $value) {
                    $permissions_ids[] = $value->permission_id;
                }
                $this->permissions_ids = $permissions_ids;

                $related_permissions = $this->Permissions->find()->where(['id IN' => $permissions_ids])->toArray();
                foreach ($related_permissions as $key => $value) {
                    $perm_key = $value->controller . "_" . $value->action;
                    $permitted_list[] = $perm_key;
                    $permissions_list[strtolower($value->controller) . "." . strtolower($value->action)] = strtolower($value->controller) . "." . strtolower($value->action);
                }

                $cached_permissions[$user['role_id']] = $permissions_list;
                $cached_permissionsids[$user['role_id']] = $this->permissions_ids;

                Cache::write('permissions', $cached_permissions, '_permissions_');
                Cache::write('permissionsids', $cached_permissionsids, '_permissionsids_');
            } else if (isset($cached_permissions[$user["role_id"]])) {

                // dd($cached_permissions[$user["role_id"]]);
                $permissions_list = $cached_permissions[$user["role_id"]];
                $this->permissions_ids = $cached_permissionsids[$user["role_id"]];
            }

            $GLOBALS['Permissions'] = $cached_permissions;

            /////////////
        }
        $this->permissionList = $permissions_list;

        $this->set('permissionList', $permissions_list);
        $this->set('permissions_ids', $this->permissions_ids);

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
                        // $conditions["{$modelName}.$field $type"] = $params[$param];
                        $conditions["{$modelName}.$field"] = $params[$param];
                    }
                    break;
            }
        }

        return $conditions;
    }
    public function resetFilter($action)
    {
        $this->autoRender = false;
        $modelName = Inflector::pluralize($this->name);
        // debug($modelName);

        if (!empty($this->modelName)) {
            $modelName = $this->modelName;
        }
        $allParams = $this->request->getAttribute('params');

        $filterKey = $allParams['controller'] . '_' . $action . "_Filter";;
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

        $cached_menus = Cache::read('menus', '_menus_');
        $user = $this->Auth->user();
        $role_id = '';
        $checkPrefix = $prefix;
        if (isset($user["role_id"]) && $prefix == 'admin') {

            // dd($user);
            $checkPrefix .= "_{$user['role_id']}";
        }

        // dd((empty($cached_menus) || !isset($cached_menus[$checkPrefix]) || empty($this->sideMenus[$prefix]) || $reFind) );
        $menus = [];
        if (empty($cached_menus) || !isset($cached_menus[$checkPrefix]) || empty($this->sideMenus[$prefix]) || $reFind) {
            $conditions = array();
            $conditions['active'] = true;
            $conditions['prefix'] = $prefix;

            if (!empty($this->permissions_ids)) {
                $conditions['permission_id in'] = $this->permissions_ids;
            } else {
                $conditions['permission_id in'] = "-1";
            }
            $this->Menus = new MenusTable();

            $cached_menus[$checkPrefix] = $this->Menus->find('threaded')->where($conditions)->order('display_order asc')->all()->toArray();
            // dd($cached_menus);

            Cache::write('menus', $cached_menus, '_menus_');

            $this->sideMenus[$prefix] = $this->checkmenu($cached_menus[$checkPrefix], $prefix);
            // dd($this->sideMenus);
            $this->set('sideMenus', $this->sideMenus);
        } else {
            $this->set('sideMenus', $this->sideMenus[$checkPrefix]);
        }

        // if (empty($this->sideMenus[$prefix]) || $reFind) {
        //     $conditions = array();
        //     $conditions['active'] = true;
        //     $conditions['prefix'] = $prefix;

        //     $user = $this->Auth->user();
        //     // if (!empty($user['role_id']) && $prefix == 'admin') {

        //     //     $conditions['role_id'] = $user['role_id'];
        //     // } else {
        //     if (!empty($this->permissions_ids)) {
        //         $conditions['permission_id in'] = $this->permissions_ids;
        //     } else {
        //         $conditions['permission_id in'] = "-1";
        //     }
        //     // }
        //     $this->Menus = new MenusTable();
        //     $menus = $this->Menus->find('threaded')->where($conditions)->order('display_order asc')->all();
        //     // dd($menus);
        //     $this->sideMenus[$prefix] = $this->checkmenu($menus->toArray(), $prefix);
        //     // print_r($this->sideMenus);die;
        //     $this->set('sideMenus', $this->sideMenus);
        // } else {
        //     $this->set('sideMenus', $this->sideMenus[$prefix]);
        // }
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


        // dd($menus);
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


        $cached_snippets = Cache::read($name, '_snippets_');

        if (empty($cached_snippets) || !isset($cached_snippets)) {

            $cached_snippets = TableRegistry::getTableLocator()->get('Snippets')->getContent($name);

            Cache::write($name, $cached_snippets, '_snippets_');
        }
        return $cached_snippets;
    }


    public function sendEmail($to = false, $from = false, $email_template_name, $replace, $attachments = false)
    {

        $local = array(
            '127.0.0.1',
            '::1'
        );

        if ($_SERVER['HTTP_HOST'] == 'besa.intimedev.com')
            return true;

        if (!(!empty($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $local))) {
            $this->loadComponent('EmailSender');
            $replace['{%website_url%}'] = WEBSITE_PATH;
            $this->EmailSender->send($to, $from, $email_template_name, $replace, $attachments);
        }
        return true;
    }


    public function getWishLists($wishConds = [])
    {

        $wishLists = [];

        $this->loadModel('WishLists');

        if (isset($_SESSION['Auth']['User'])) {
            $user = $_SESSION['Auth']['User'];

            $wishConds['user_id'] = $user['id'];
        } else {

            $token = $this->userToken();
            $wishConds['user_token'] = $token;
        }

        $wishLists = $this->WishLists->find('list', [
            'keyField' => 'course_id', 'valueField' => 'course_id'
        ])->where($wishConds)->order(['course_id' => 'asc'])->toArray();
        return $wishLists;
    }


    public function getAppCourses($conds = [])
    {

        $appCourses = [];

        $this->loadModel('Applications');
        // $conds['save_later'] = 1;
        if (isset($_SESSION['Auth']['User'])) {
            $user = $_SESSION['Auth']['User'];
            $conds['user_id'] = $user['id'];
        } else {

            $token = $this->userToken();
            $conds['user_token'] = $token;
        }

        $conds['save_later !='] = 2;
        $appCourses = $this->Applications->find()
            ->where($conds)->contain(['ApplicationCourses'])
            ->order(['Applications.created' => 'DESC'])->first();

        if (!empty($appCourses['application_courses']))
            $appCourses = Hash::combine($appCourses['application_courses'], '{n}.university_course_id', '{n}.university_course_id');
        else
            $appCourses = [];
        return $appCourses;
    }


    public function _set_seo()
    {

        $this->loadModel('Seo');


        $current_url = Router::url(null);
        $record = $this->Seo->find()->where(array("'" . $current_url . "' LIKE criteria"))->first();
        // dd($record);
        if ($record) {
            $record->toArray();
        }
        if (!empty($record)) {
            $this->titleAlias = $record['title'];
            $this->set('title', $record['title']);
            $this->metaDescription = $record['description'];
            $this->metaKeywords = $record['keywords'];
        } else {

            if (empty($this->metaDescription)) {

                $this->metaDescription = $this->g_configs['general']['txt.description'];
            }
            if (empty($this->metaKeywords)) {
                $this->metaKeywords = $this->g_configs['general']['txt.keywords'];
            }
        }

        $this->set('metaDescription', h(substr(preg_replace('/\\s+/', ' ', $this->metaDescription), 0, 500)));
        $this->set('metaKeywords', $this->metaKeywords);
    }

    public function allCoursesList()
    {

        $cached_courses = Cache::read('courses', '_courses_');

        // dd($cached_courses);
        if (empty($cached_courses)) {
            $this->loadModel('UniversityCourses');
            $cached_courses = $this->UniversityCourses->find(
                'list',
                ['keyField' => 'id', 'valueField' => 'course_name']
            )->order(['course_name' => 'asc'])->toArray();

            Cache::write('courses', $cached_courses, '_courses_');
        }
        $this->set('studyCoursesList', $cached_courses);
    }
    public function loadDynamicRoutes()
    {

        $cached_dynamicroutes = Cache::read('dynamicroutes', '_dynamicroutes_');


        // dd($cached_dynamicroutes);

        if (empty($cached_dynamicroutes)) {
            $DynamicRoutes = TableRegistry::getTableLocator()->get('DynamicRoutes');

            $dynamicRoutes = $DynamicRoutes->find()->select(['slug', 'controller' => 'lower(controller)', 'action' => 'lower(action)'])->where(['is_active' => 1])->all();
            $dynamicRoutes = Hash::combine($dynamicRoutes->toArray(), ['%s.%s', '{n}.controller', '{n}.action'], '{n}.slug');
            $cached_dynamicroutes = $this->g_dynamic_routes = $dynamicRoutes;

            Cache::write('dynamicroutes', $dynamicRoutes, '_dynamicroutes_');
        }

        $this->set('g_dynamic_routes', $cached_dynamicroutes);
    }

    /**********************
     * 
     * Bitrix Function
     * ************************** */


    public function sendToBitrix($data, $type, $enquiryTypes = [])
    {
        $extras = [];
        $this->loadModel('SubjectAreas');
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $extras['subjectAreas']=$subjectAreas;

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc'])->toArray();
        $extras['countriesList']=$countriesList;
        
        $this->loadModel('Enquiries');
        $extras['fairVenues'] = $this->Enquiries->fairVenues;

        if(!empty($data['email']) && $data['email']=='eng.karimgamal90@gmail.com' ){
            if(!empty($data['bd'])){
                $extras['bd']=$data['bd']->format('d.m.Y');
            }
            // print_r($data);die;
            // print_r($type);die;
            // Configure::write('debug', 2);
            $main_dir = '/home/u975649297/domains/besaeg.com/public_html';
            require_once ($main_dir.'/plugins/bitrix/BitrixIntegration.php');
            $bitrix = new \BitrixIntegration();
            $bitrix->get_lead_by_mobile();
            // $bitrix->execute($data,$type,$extras);
        }
        return true;
    }
}
