<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * PathwayPrograms Controller
 *
 */

class PathwayProgramsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $pathwayPrograms = $this->paginate($this->PathwayPrograms, ['conditions' => $conditions, 'order'=>['continent'=>'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->PathwayPrograms->continents;
        $this->set(compact('pathwayPrograms', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $pathwayPrograms = $this->paginate($this->PathwayPrograms, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->PathwayPrograms->continents;
        $this->set(compact('pathwayPrograms', 'parameters', 'continents'));
    }

    public function add()
    {
        $pathwayProgram = $this->PathwayPrograms->newEmptyEntity();
        if ($this->request->is('post')) {
            $pathwayProgram = $this->PathwayPrograms->patchEntity($pathwayProgram, $this->request->getData());
            if ($this->PathwayPrograms->save($pathwayProgram)) {
                $this->Flash->success(__('The PathwayProgram has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The PathwayProgram could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('pathwayProgram_new', 'pathwayPrograms', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->PathwayPrograms->continents;
        $this->set(compact('pathwayProgram', 'continents'));
    }

    public function edit($id = null)
    {
        $pathwayProgram = $this->PathwayPrograms->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
           $pathwayProgram = $this->PathwayPrograms->patchEntity($pathwayProgram, $this->request->getData());

            
            if ($this->PathwayPrograms->save($pathwayProgram)) {
                $this->Flash->success(__('The PathwayProgram has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The PathwayProgram could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->PathwayPrograms->continents;
        $this->set(compact('pathwayProgram', 'id', 'continents'));
        $this->_ajaxImageUpload('pathwayProgram_' . $id, 'pathwayPrograms', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $pathwayProgram = $this->PathwayPrograms->get($id);
        if ($this->PathwayPrograms->delete($pathwayProgram)) {
            $this->Flash->success(__('The PathwayProgram has been deleted.'));
        } else {
            $this->Flash->error(__('The PathwayProgram could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->PathwayPrograms->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The PathwayPrograms has been deleted.'));
        } else {
            $this->Flash->error(__('The PathwayPrograms could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $pathwayProgram = $this->PathwayPrograms->get($id);

        $this->set('pathwayProgram', $pathwayProgram);
    }

    private function __common()
    {
        $uploadSettings = $this->PathwayPrograms->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
