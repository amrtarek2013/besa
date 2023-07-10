<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * YoungLearners Controller
 *
 */

class YoungLearnersController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $youngLearners = $this->paginate($this->YoungLearners, ['conditions' => $conditions, 'order' => ['continent' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->YoungLearners->continents;
        $this->set(compact('youngLearners', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $youngLearners = $this->paginate($this->YoungLearners, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->YoungLearners->continents;
        $this->set(compact('youngLearners', 'parameters', 'continents'));
    }

    public function add()
    {
        $youngLearner = $this->YoungLearners->newEmptyEntity();
        if ($this->request->is('post')) {
            $youngLearner = $this->YoungLearners->patchEntity($youngLearner, $this->request->getData());
            if ($this->YoungLearners->save($youngLearner)) {
                $this->Flash->success(__('The YoungLearner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The YoungLearner could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('youngLearner_new', 'youngLearners', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->YoungLearners->continents;
        $this->set(compact('youngLearner', 'continents'));
    }

    public function edit($id = null)
    {
        $youngLearner = $this->YoungLearners->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $youngLearner = $this->YoungLearners->patchEntity($youngLearner, $this->request->getData());


            if ($this->YoungLearners->save($youngLearner)) {
                $this->Flash->success(__('The YoungLearner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The YoungLearner could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->YoungLearners->continents;
        $this->set(compact('youngLearner', 'id', 'continents'));
        $this->_ajaxImageUpload('youngLearner_' . $id, 'youngLearners', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $youngLearner = $this->YoungLearners->get($id);
        if ($this->YoungLearners->delete($youngLearner)) {
            $this->Flash->success(__('The YoungLearner has been deleted.'));
        } else {
            $this->Flash->error(__('The YoungLearner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->YoungLearners->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The YoungLearners has been deleted.'));
        } else {
            $this->Flash->error(__('The YoungLearners could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $youngLearner = $this->YoungLearners->get($id);

        $this->set('youngLearner', $youngLearner);
    }

    private function __common()
    {
        $uploadSettings = $this->YoungLearners->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
