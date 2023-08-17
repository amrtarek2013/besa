<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Dynamic Routes Controller
 *
 */

class DynamicRoutesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $dynamicRoutes = $this->paginate($this->DynamicRoutes, ['conditions' => $conditions, 'order'=>['continent'=>'ASC']]);
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
