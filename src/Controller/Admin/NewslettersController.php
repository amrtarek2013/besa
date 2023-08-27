<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Newsletters Controller
 *
 */

class NewslettersController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $newsletters = $this->paginate($this->Newsletters, ['conditions' => $conditions, 'order' => ['id' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        
        $this->set(compact('newsletters', 'parameters'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $newsletters = $this->paginate($this->Newsletters, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        
        $this->set(compact('newsletters', 'parameters'));
    }

    public function add()
    {
        $newsletter = $this->Newsletters->newEmptyEntity();
        if ($this->request->is('post')) {
            $newsletter = $this->Newsletters->patchEntity($newsletter, $this->request->getData());
            if ($this->Newsletters->save($newsletter)) {
                $this->Flash->success(__('The Newsletter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Newsletter could not be saved. Please, try again.'));
        }
        $this->set('id', false);

        $this->__common();
        $this->set(compact('newsletter'));
    }

    public function edit($id = null)
    {
        $newsletter = $this->Newsletters->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $newsletter = $this->Newsletters->patchEntity($newsletter, $this->request->getData());


            if ($this->Newsletters->save($newsletter)) {
                $this->Flash->success(__('The Newsletter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Newsletter could not be saved. Please, try again.'));
        }

        $this->__common();

        $this->set(compact('newsletter', 'id'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $newsletter = $this->Newsletters->get($id);
        if ($this->Newsletters->delete($newsletter)) {
            $this->Flash->success(__('The Newsletter has been deleted.'));
        } else {
            $this->Flash->error(__('The Newsletter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Newsletters->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Newsletters has been deleted.'));
        } else {
            $this->Flash->error(__('The Newsletters could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $newsletter = $this->Newsletters->get($id);

        $this->set('mainNewsletters', $this->Newsletters->mainNewsletters);
        $this->set('newsletter', $newsletter);
    }

    private function __common()
    {
    }


    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $newsletters = $this->Newsletters->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'id' => 'ID',
            'email' => 'Email',
            // 'destination' => 'Destination',
            // 'rank' => 'Rank',
            // 'description' => 'Description'
        );

        foreach ($newsletters as $newsletter) {
            $dataToExport[] = [
                $newsletter->id,
                $newsletter->email,
                // $newsletter->destination,
                // $newsletter->rank,
                // $newsletter->description,
                // '',
                // ($newsletter->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'newsletters-list-' . date('Ymd'));

        exit();
    }
}
