<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use \Cake\Http\Session;
use Cake\Event\EventInterface;
use \Cake\Utility\Inflector;


class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Session');
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
        $this->setDefaultLayout();
    }

    public function setDefaultLayout()
    {
        $prefix = $this->request->getParam('prefix');
        if (isset($prefix) && !empty($prefix)) {
            $this->set('layoutUrlPrefix', Inflector::dasherize($prefix));

            switch (Inflector::dasherize($prefix)) {
                
                case 'admin':
                    $this->viewBuilder()->setLayout('admin');
                    $this->loadComponent('Auth', [
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

                    if ($this->Auth->user()) {
                        $this->set('auth', $this->Auth);
                    }
                    $this->set('admin_title_prefix', "BESA Admin Dashboard");
                    break;
                
                    

                default:
                    $this->viewBuilder()->setLayout('default');
            }
        }
    }

    public function checkIfSuperadmin()
    {
        $user = $this->Auth->user();
        
        if ($user['super_admin'] == true) {
            return true;
        }
        $this->Flash->error(__('you are not authorized to view this page please contact system administrator'));
        return $this->redirect('/admin');
    }
}
