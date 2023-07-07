<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * TempFiles Controller
 *
 */

class TempFilesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->getEventManager()->off($this->Csrf);
    }

    public function index()
    {

        $conditions = $this->_filter_params();

        $tempFiles = $this->paginate($this->TempFiles, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('tempFiles', 'parameters'));
    }

    public function add()
    {
        $tempFile = $this->TempFiles->newEmptyEntity();
        if ($this->request->is('post')) {
            $tempFile = $this->TempFiles->patchEntity($tempFile, $this->request->getData());
            if ($this->TempFiles->save($tempFile)) {
                $this->Flash->success(__('The Temp File has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Temp File could not be saved. Please, try again.'));
        }

        $this->set(compact('tempFile'));
    }

    public function edit($id = null)
    {
        $tempFile = $this->TempFiles->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tempFile = $this->TempFiles->patchEntity($tempFile, $this->request->getData());
            if ($this->TempFiles->save($tempFile)) {
                $this->Flash->success(__('The Temp File has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Temp File could not be saved. Please, try again.'));
        }
        $this->set(compact('tempFile'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tempFile = $this->TempFiles->get($id);
        if ($this->TempFiles->delete($tempFile)) {
            $this->Flash->success(__('The Temp File has been deleted.'));
        } else {
            $this->Flash->error(__('The Temp File could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->TempFiles->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The TempFiles has been deleted.'));
        } else {
            $this->Flash->error(__('The TempFiles could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $tempFile = $this->TempFiles->get($id);

        $this->set('tempFile', $tempFile);
    }
}
