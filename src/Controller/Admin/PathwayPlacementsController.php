<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * PathwayPlacements Controller
 *
 */

class PathwayPlacementsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $pathwayPlacements = $this->paginate($this->PathwayPlacements, ['conditions' => $conditions, 'order'=>['continent'=>'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->PathwayPlacements->continents;
        $this->set(compact('pathwayPlacements', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $pathwayPlacements = $this->paginate($this->PathwayPlacements, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->PathwayPlacements->continents;
        $this->set(compact('pathwayPlacements', 'parameters', 'continents'));
    }

    public function add()
    {
        $pathwayPlacement = $this->PathwayPlacements->newEmptyEntity();
        if ($this->request->is('post')) {
            $pathwayPlacement = $this->PathwayPlacements->patchEntity($pathwayPlacement, $this->request->getData());
            if ($this->PathwayPlacements->save($pathwayPlacement)) {
                $this->Flash->success(__('The PathwayPlacement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The PathwayPlacement could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('pathwayPlacement_new', 'pathwayPlacements', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->PathwayPlacements->continents;
        $this->set(compact('pathwayPlacement', 'continents'));
    }

    public function edit($id = null)
    {
        $pathwayPlacement = $this->PathwayPlacements->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
           $pathwayPlacement = $this->PathwayPlacements->patchEntity($pathwayPlacement, $this->request->getData());

            
            if ($this->PathwayPlacements->save($pathwayPlacement)) {
                $this->Flash->success(__('The PathwayPlacement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The PathwayPlacement could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->PathwayPlacements->continents;
        $this->set(compact('pathwayPlacement', 'id', 'continents'));
        $this->_ajaxImageUpload('pathwayPlacement_' . $id, 'pathwayPlacements', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $pathwayPlacement = $this->PathwayPlacements->get($id);
        if ($this->PathwayPlacements->delete($pathwayPlacement)) {
            $this->Flash->success(__('The PathwayPlacement has been deleted.'));
        } else {
            $this->Flash->error(__('The PathwayPlacement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->PathwayPlacements->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The PathwayPlacements has been deleted.'));
        } else {
            $this->Flash->error(__('The PathwayPlacements could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $pathwayPlacement = $this->PathwayPlacements->get($id);

        $this->set('pathwayPlacement', $pathwayPlacement);
    }

    private function __common()
    {
        $uploadSettings = $this->PathwayPlacements->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
