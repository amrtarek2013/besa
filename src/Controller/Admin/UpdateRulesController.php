<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\ServerRequest;


/**
 * UpdateRules Controller
 *
 * @property \App\Model\Table\UpdateRulesTable $UpdateRules
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UpdateRulesController extends AppController
{

    public $paginate = [
        // 'limit' => 1,
        'order' => [
            // 'Roles.name' => 'asc'
        ]
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        // $this->checkIfSuperadmin();

        // $conditions = $this->_filter_params();
        $conditions = [];
        $this->paginate = array('limit' => 100);
        $updateRules = $this->paginate($this->UpdateRules, ['conditions' => $conditions]);

        $this->__set_os_list();
        
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters'));
        $this->set('datalist', $updateRules);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $this->checkIfSuperadmin();
        $updateRule = $this->UpdateRules->newEmptyEntity();
        if ($this->request->is('post')) {
            $updateRule = $this->UpdateRules->patchEntity($updateRule, $this->request->getData());
            if ($this->UpdateRules->save($updateRule)) {
                $this->Flash->success(__('The update rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The update rule could not be saved. Please, try again.'));
        }
        $this->__set_os_list();
        $this->set(compact('updateRule'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // $this->checkIfSuperadmin();
        $updateRule = $this->UpdateRules->get($id, [
            'contain' => [],
        ]);
        unset($updateRule->password);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $updateRule = $this->UpdateRules->patchEntity($updateRule, $this->request->getData());
            // debug($this->request->getData());
            if ($this->UpdateRules->save($updateRule)) {
                $this->Flash->success(__('The update rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The update rule could not be saved. Please, try again.'));
        }
        $this->__set_os_list();
        $this->set(compact('updateRule'));
        $this->render('add');
    }
    

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->checkIfSuperadmin();
        // $this->request->allowMethod(['post', 'delete']);
        $updateRule = $this->UpdateRules->get($id);
        if ($this->UpdateRules->delete($updateRule)) {
            $this->Flash->success(__('The update rule has been deleted.'));
        } else {
            $this->Flash->error(__('The update rule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->checkIfSuperadmin();
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Admins->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The admins has been deleted.'));
        } else {
            $this->Flash->error(__('The admins could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    function __set_os_list(){
        $os_list = [
                            0 =>__("Android"),
                            1 =>__("iOS"),
                            2 =>__("Huawei"),
                        ];
        $this->set("os_list",$os_list);
    }
}
