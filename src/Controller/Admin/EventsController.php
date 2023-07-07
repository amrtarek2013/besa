<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Events Controller
 *
 */

class EventsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $events = $this->paginate($this->Events, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        
        $this->set(compact('events', 'parameters'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $events = $this->paginate($this->Events, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        
        $this->set(compact('events', 'parameters'));
    }

    public function add()
    {
        $event = $this->Events->newEmptyEntity();
        if ($this->request->is('post')) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The Event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Event could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('event_new', 'events', false, false, ['video_thumb','icon', 'image', 'banner_image', 'mobile_image']);
        $this->set('id', false);

        $this->__common();
        
        $this->set(compact('event'));
    }

    public function edit($id = null)
    {
        $event = $this->Events->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            // debug($this->request->getData());
            // debug($event);die;
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The Event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Event could not be saved. Please, try again.'));
        }

        $this->__common();

        
        $this->set(compact('event', 'id'));
        $this->_ajaxImageUpload('event_' . $id, 'events', $id, ['id' => $id], [/*'video',*/'video_thumb','icon', 'image', 'banner_image', 'mobile_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->success(__('The Event has been deleted.'));
        } else {
            $this->Flash->error(__('The Event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Events->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Events has been deleted.'));
        } else {
            $this->Flash->error(__('The Events could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $event = $this->Events->get($id);

        $this->set('event', $event);
    }

    private function __common()
    {
        $uploadSettings = $this->Events->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
