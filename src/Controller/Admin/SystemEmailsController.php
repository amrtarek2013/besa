<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class SystemEmailsController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $systemEmails = $this->paginate($this->SystemEmails, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('systemEmails', 'parameters'));
    }

    public function add($name)
    {
        $email = $this->SystemEmails->newEmptyEntity();
        if ($this->request->is('post')) {
            $email = $this->SystemEmails->patchEntity($email, $this->request->getData());
            if ($this->SystemEmails->save($email)) {
                $this->Flash->success(__('The Email has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Email could not be saved. Please, try again.'));
        }
        $this->set(compact('email'));
        $this->set('emailLayouts', $this->getAllLayouts());

        if (!empty($this->SystemEmails->templates[$name]))
            $this->set('placeholder', $this->SystemEmails->templates[$name]);
    }

    public function view($id)
    {
        $email = $this->SystemEmails->get($id);
        debug($email);
        die;
    }

    public function edit($name)
    {
        $email = $this->SystemEmails->findByName($name)->firstOrFail();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $email = $this->SystemEmails->patchEntity($email, $this->request->getData());
            if ($this->SystemEmails->save($email)) {
                $this->Flash->success(__('The Email has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Email could not be saved. Please, try again.'));
        }
        $this->set(compact('email'));
        if (!empty($email->templates[$name]))
            $this->set('placeholder', $email->templates[$name]);
        $this->set('emailLayouts', $this->getAllLayouts());
        $this->render('add');
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $email = $this->SystemEmails->get($id);
        if ($this->SystemEmails->delete($email)) {
            $this->Flash->success(__('The email has been deleted.'));
        } else {
            $this->Flash->error(__('The email could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getAllLayouts()
    {
        $this->loadModel('EmailLayouts');
        $layouts = $this->EmailLayouts->find('list', ['keyField' => 'id', 'valueField' => 'name']);


        return $layouts->toArray();
    }
}
