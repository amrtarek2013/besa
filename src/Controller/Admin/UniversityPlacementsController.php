<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * UniversityPlacements Controller
 *
 */

class UniversityPlacementsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $universityPlacements = $this->paginate($this->UniversityPlacements, ['conditions' => $conditions, 'order'=>['continent'=>'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->UniversityPlacements->continents;
        $this->set(compact('universityPlacements', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $universityPlacements = $this->paginate($this->UniversityPlacements, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->UniversityPlacements->continents;
        $this->set(compact('universityPlacements', 'parameters', 'continents'));
    }

    public function add()
    {
        $universityPlacement = $this->UniversityPlacements->newEmptyEntity();
        if ($this->request->is('post')) {
            $universityPlacement = $this->UniversityPlacements->patchEntity($universityPlacement, $this->request->getData());
            if ($this->UniversityPlacements->save($universityPlacement)) {
                $this->Flash->success(__('The UniversityPlacement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The UniversityPlacement could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('universityPlacement_new', 'universityPlacements', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->UniversityPlacements->continents;
        $this->set(compact('universityPlacement', 'continents'));
    }

    public function edit($id = null)
    {
        $universityPlacement = $this->UniversityPlacements->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
           $universityPlacement = $this->UniversityPlacements->patchEntity($universityPlacement, $this->request->getData());

            
            if ($this->UniversityPlacements->save($universityPlacement)) {
                $this->Flash->success(__('The UniversityPlacement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The UniversityPlacement could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->UniversityPlacements->continents;
        $this->set(compact('universityPlacement', 'id', 'continents'));
        $this->_ajaxImageUpload('universityPlacement_' . $id, 'universityPlacements', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $universityPlacement = $this->UniversityPlacements->get($id);
        if ($this->UniversityPlacements->delete($universityPlacement)) {
            $this->Flash->success(__('The UniversityPlacement has been deleted.'));
        } else {
            $this->Flash->error(__('The UniversityPlacement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->UniversityPlacements->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The UniversityPlacements has been deleted.'));
        } else {
            $this->Flash->error(__('The UniversityPlacements could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $universityPlacement = $this->UniversityPlacements->get($id);

        $this->set('universityPlacement', $universityPlacement);
    }

    private function __common()
    {
        $uploadSettings = $this->UniversityPlacements->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
