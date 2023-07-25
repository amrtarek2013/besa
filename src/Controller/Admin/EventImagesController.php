<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Event Images Controller
 *
 */

class EventImagesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $eventImages = $this->paginate($this->EventImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('eventImages', 'parameters'));
        $this->__common();
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $eventImages = $this->paginate($this->EventImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->__common();
        $this->set(compact('eventImages', 'parameters'));
    }

    public function add()
    {
        $eventImage = $this->EventImages->newEmptyEntity();
        if ($this->request->is('post')) {
            $eventImage = $this->EventImages->patchEntity($eventImage, $this->request->getData());
            if ($this->EventImages->save($eventImage)) {
                $this->Flash->success(__('The EventImage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The EventImage could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('eventImage_new', 'eventImages', false, false, ['image']);
        $this->set('id', false);

        $this->__common();

        $this->set(compact('eventImage'));
    }

    public function edit($id = null)
    {
        $eventImage = $this->EventImages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eventImage = $this->EventImages->patchEntity($eventImage, $this->request->getData());
            if ($this->EventImages->save($eventImage)) {
                $this->Flash->success(__('The EventImage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The EventImage could not be saved. Please, try again.'));
        }

        $this->__common();


        $this->set(compact('eventImage', 'id'));
        $this->_ajaxImageUpload('eventImage_' . $id, 'eventImages', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $eventImage = $this->EventImages->get($id);
        if ($this->EventImages->delete($eventImage)) {
            $this->Flash->success(__('The EventImage has been deleted.'));
        } else {
            $this->Flash->error(__('The EventImage could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->EventImages->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Event Images has been deleted.'));
        } else {
            $this->Flash->error(__('The Event Images could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $eventImage = $this->EventImages->get($id);

        $this->set('eventImage', $eventImage);
    }

    private function __common()
    {
        $uploadSettings = $this->EventImages->getUploadSettings();

        $this->loadModel('Events');
        $events = $this->Events->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(["active" => 1])->order(['title'=>'ASC'])->toArray();
        $this->set(compact('uploadSettings','events'));
    }
}
