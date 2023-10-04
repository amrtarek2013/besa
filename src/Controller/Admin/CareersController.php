<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Careers Controller
 *
 */

class CareersController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $careers = $this->paginate($this->Careers, ['conditions' => $conditions, 'order'=>['continent'=>'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Careers->continents;
        $this->set(compact('careers', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $careers = $this->paginate($this->Careers, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Careers->continents;
        $this->set(compact('careers', 'parameters', 'continents'));
    }

    public function add()
    {
        $career = $this->Careers->newEmptyEntity();
        if ($this->request->is('post')) {
            $career = $this->Careers->patchEntity($career, $this->request->getData());
            if ($this->Careers->save($career)) {
                $this->Flash->success(__('The Career has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Career could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('career_new', 'careers', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->Careers->continents;
        $this->set(compact('career', 'continents'));
    }

    public function edit($id = null)
    {
        $career = $this->Careers->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
          
           $career = $this->Careers->patchEntity($career, $this->request->getData());

            
        //    debug($career);
            if ($this->Careers->save($career)) {
                // dd($_FILES);
                $this->Flash->success(__('The Career has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Career could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->Careers->continents;
        $this->set(compact('career', 'id', 'continents'));
        $this->_ajaxImageUpload('career_' . $id, 'careers', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $career = $this->Careers->get($id);
        if ($this->Careers->delete($career)) {
            $this->Flash->success(__('The Career has been deleted.'));
        } else {
            $this->Flash->error(__('The Career could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Careers->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Careers has been deleted.'));
        } else {
            $this->Flash->error(__('The Careers could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $career = $this->Careers->get($id);

        $this->set('career', $career);
    }

    private function __common()
    {
        $uploadSettings = $this->Careers->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
