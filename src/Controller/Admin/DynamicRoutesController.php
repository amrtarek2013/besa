<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use \Cake\Filesystem\Folder;
use \Cake\Filesystem\File;

/**
 * Dynamic Routes Controller
 *
 */

class DynamicRoutesController extends AppController
{

    public function index()
    {
        // $frontEndContrllers = $this->getControllers();
        // $frontEndContrllersActions = $this->getActions(null, $frontEndContrllers);
        // $userContrllers = $this->getControllers('User');
        // $userContrllersActions = $this->getActions('User', $userContrllers);
        // $counselorContrllers = $this->getControllers('Counselor');
        // $counselorContrllersActions = $this->getActions('Counselor', $counselorContrllers);

        // debug($frontEndContrllersActions);
        // debug($userContrllersActions);
        // debug($counselorContrllersActions);
        $conditions = $this->_filter_params();

        $dynamicRoutes = $this->paginate($this->DynamicRoutes, ['conditions' => $conditions, 'order' => ['continent' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('dynamicRoutes', 'parameters'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $dynamicRoutes = $this->paginate($this->DynamicRoutes, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('dynamicRoutes', 'parameters'));
    }

    public function add()
    {
        $dynamicRoute = $this->DynamicRoutes->newEmptyEntity();
        if ($this->request->is('post')) {
            $dynamicRoute = $this->DynamicRoutes->patchEntity($dynamicRoute, $this->request->getData());
            if ($this->DynamicRoutes->save($dynamicRoute)) {
                $this->Flash->success(__('The Dynamic Route has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Dynamic Route could not be saved. Please, try again.'));
        }


        $this->__common();

        $this->set(compact('dynamicRoute'));
    }

    public function getControllers($prefix = null)
    {
        $folder = new Folder(ROOT);
        $path = "src" . DS . "Controller";
        if ($prefix)
            $path .= DS . ucfirst($prefix);
        $controllerFiles = $folder->cd($path);
        $controllerFiles = $folder->find(".*.php", true);

        $skipControllers = ['AppController.php', 'AppControllerNoCache.php'];
        $cleanControllers = [];
        foreach ($controllerFiles as $key => $controller) {

            if (!in_array($controller, $skipControllers) && strpos($controller, '_') === false) {
                $cleanControllers[] = str_replace('Controller.php', '', $controller);
                //Could build a menu based on the controller here now, but do not
                //have time to do this now.
            }
        }
        return $cleanControllers;
    }
    public function getActions($prefix = null, $controllers)
    {
        $path = "templates";
        if ($prefix)
            $path .= DS . ucfirst($prefix);

        $cleanActions = [];
        foreach ($controllers as $controller) {
            if (in_array($controller, ['TempFiles', 'Localizations', 'Error']))
                continue;

            $fullpath = $path . DS . $controller;
            $folder = new Folder(ROOT);
            $actionFiles = $folder->cd($fullpath);
            $actionFiles = $folder->find(".*.php", true);

            $skipActions = ['import.php','security.php'];
            $cleanAction = [];
            foreach ($actionFiles as $key => $action) {

                // debug($controller . '.' . $action);
                if (!in_array($action, $skipActions) && strpos($action, 'copy') === false && strpos($action, 'old') === false) {
                    $cleanActions[$controller][] = str_replace('_', '-', str_replace('.php', '', $action));
                }
            }
        }
        return $cleanActions;
    }

    public function edit($id = null)
    {
        $dynamicRoute = $this->DynamicRoutes->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dynamicRoute = $this->DynamicRoutes->patchEntity($dynamicRoute, $this->request->getData());


            if ($this->DynamicRoutes->save($dynamicRoute)) {
                $this->Flash->success(__('The Dynamic Route has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Dynamic Route could not be saved. Please, try again.'));
        }

        $this->__common();


        $this->set(compact('dynamicRoute', 'id'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $dynamicRoute = $this->DynamicRoutes->get($id);
        if ($this->DynamicRoutes->delete($dynamicRoute)) {
            $this->Flash->success(__('The Dynamic Route has been deleted.'));
        } else {
            $this->Flash->error(__('The Dynamic Route could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->DynamicRoutes->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Dynamic Routes has been deleted.'));
        } else {
            $this->Flash->error(__('The Dynamic Routes could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $dynamicRoute = $this->DynamicRoutes->get($id);

        $this->set('dynamicRoute', $dynamicRoute);
    }

    private function __common()
    {
    }
}
