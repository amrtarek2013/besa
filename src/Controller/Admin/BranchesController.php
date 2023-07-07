<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Branches Controller
 *
 */

class BranchesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $branches = $this->paginate($this->Branches, ['conditions' => $conditions, 'order'=>['continent'=>'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Branches->continents;
        $this->set(compact('branches', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $branches = $this->paginate($this->Branches, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Branches->continents;
        $this->set(compact('branches', 'parameters', 'continents'));
    }

    public function add()
    {
        $branch = $this->Branches->newEmptyEntity();
        if ($this->request->is('post')) {
            $branch = $this->Branches->patchEntity($branch, $this->request->getData());
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The Branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Branch could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('branch_new', 'branches', false, false, ['location_image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->Branches->continents;
        $this->set(compact('branch', 'continents'));
    }

    public function edit($id = null)
    {
        $branch = $this->Branches->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
           $branch = $this->Branches->patchEntity($branch, $this->request->getData());

            
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The Branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Branch could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->Branches->continents;
        $this->set(compact('branch', 'id', 'continents'));
        $this->_ajaxImageUpload('branch_' . $id, 'branches', $id, ['id' => $id], ['location_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $branch = $this->Branches->get($id);
        if ($this->Branches->delete($branch)) {
            $this->Flash->success(__('The Branch has been deleted.'));
        } else {
            $this->Flash->error(__('The Branch could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Branches->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Branches has been deleted.'));
        } else {
            $this->Flash->error(__('The Branches could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $branch = $this->Branches->get($id);

        $this->set('branch', $branch);
    }

    private function __common()
    {
        $uploadSettings = $this->Branches->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
