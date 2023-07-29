<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Seo Controller
 *
 */

class SeoController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $seo = $this->paginate($this->Seo, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('seo', 'parameters'));
    }

    public function add()
    {
        $seo = $this->Seo->newEmptyEntity();
        if ($this->request->is('post')) {
            $seo = $this->Seo->patchEntity($seo, $this->request->getData());
            if ($this->Seo->save($seo)) {
                $this->Flash->success(__('The Seo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Seo could not be saved. Please, try again.'));
        }

        $this->set(compact('seo'));
    }

    public function edit($id = null)
    {
        $seo = $this->Seo->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seo = $this->Seo->patchEntity($seo, $this->request->getData());
            if ($this->Seo->save($seo)) {
                $this->Flash->success(__('The Seo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Seo could not be saved. Please, try again.'));
        }
        $this->set(compact('seo'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $seo = $this->Seo->get($id);
        if ($this->Seo->delete($seo)) {
            $this->Flash->success(__('The Seo has been deleted.'));
        } else {
            $this->Flash->error(__('The Seo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Seo->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Seo has been deleted.'));
        } else {
            $this->Flash->error(__('The Seo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $seo = $this->Seo->get($id);

        $this->set('seo', $seo);
    }
}
