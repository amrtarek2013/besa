<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Http\ServerRequest;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{

    public $paginate = [
        // 'limit' => 1,
        'order' => [
            'Roles.name' => 'asc'
        ]
    ];

    /**
     * Index method
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        // $this->checkIfSuperadmin();

        $conditions = $this->_filter_params();
        $this->paginate = array('limit' => 100);
        $roles = $this->paginate($this->Roles, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters','roles'));
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     // $this->checkIfSuperadmin();
    //     $admin = $this->Admins->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set('admin', $admin);
    // }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $this->checkIfSuperadmin();
        $role = $this->Roles->newEmptyEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $this->set(compact('role'));
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
        $role = $this->Roles->get($id, [
            'contain' => [],
        ]);
        unset($role->password);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $role = $this->Roles->patchEntity($role, $this->request->getData());
            // debug($this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $this->set(compact('role'));
        $this->render('add');
    }
    public function permissions($role_id = null){
        $this->loadModel("RolesPermissions");
        $this->loadModel("Permissions");
        $all_cer_permissions = $this->Permissions->find("all")->order(['permission_group'])->toArray();
        

        $this->set('all_cer_permissions',$all_cer_permissions);

        $saved_perm_arr = $this->RolesPermissions->find("all")->where(["role_id"=>$role_id])->toArray();
        $saved_perm = [];
        foreach ($saved_perm_arr as $rp) {
            $saved_perm[]=$rp->permission_id;
        }
        // print_r($all_cer_permissions);die;
        $this->set('saved_perm',$saved_perm);
        $saved = true;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $req_data = $this->request->getData();

            $this->RolesPermissions->deleteAll(['role_id' => $role_id]);
            if(!empty($req_data["permissions"])){
                foreach ($req_data["permissions"] as $key => $value) {
                    $rolesPermissions = $this->RolesPermissions->newEmptyEntity();
                    $rol_arr = ["role_id"=>$role_id,"permission_id"=>$value];
                    $rolesPermissions = $this->Roles->patchEntity($rolesPermissions, $rol_arr);
                    if ($this->RolesPermissions->save($rolesPermissions)) {
                        $saved = true;
                    }
                }
            }

            if ($saved) {
                $this->Flash->success(__('The permissions has been saved.'));
                return $this->redirect(['action' => 'permissions',$role_id]);
            }else{
                $this->Flash->error(__('The rolesPermissions could not be saved. Please, try again.'));
            }

        }
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
        if(!$this->checkIfSuperadmin()){
            $this->Flash->error(__('you are not authorized to view this page please contact system administrator'));
            return $this->redirect('/admin');
        }
        // $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
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
}
