<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Http\ServerRequest;

/**
 * Permissions Controller
 *
 * @property \App\Model\Table\PermissionsTable $Permissions
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PermissionsController extends AppController
{

    public $paginate = [
        // 'limit' => 1,
        'order' => [
            'Permissions.name' => 'asc'
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
        $permissions = $this->paginate($this->Permissions, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters','permissions'));
    }

    /**
     * View method
     *
     * @param string|null $id Permission id.
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
        $permission = $this->Permissions->newEmptyEntity();
        if ($this->request->is('post')) {
            $permission = $this->Permissions->patchEntity($permission, $this->request->getData());
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permission could not be saved. Please, try again.'));
        }
        $this->set(compact('permission'));
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
        $permission = $this->Permissions->get($id, [
            'contain' => [],
        ]);
        unset($permission->password);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $permission = $this->Permissions->patchEntity($permission, $this->request->getData());
            // debug($this->request->getData());
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The permission could not be saved. Please, try again.'));
        }
        $this->set(compact('permission'));
        $this->render('add');
    }
    public function permissions($permission_id = null){
        $this->loadModel("PermissionsPermissions");
        $this->loadModel("Permissions");
        $all_cer_permissions = $this->Permissions->find("all")->order(['permission_group'])->toArray();
        

        $this->set('all_cer_permissions',$all_cer_permissions);

        $saved_perm_arr = $this->PermissionsPermissions->find("all")->where(["permission_id"=>$permission_id])->toArray();
        $saved_perm = [];
        foreach ($saved_perm_arr as $rp) {
            $saved_perm[]=$rp->permission_id;
        }
        // print_r($all_cer_permissions);die;
        $this->set('saved_perm',$saved_perm);
        $saved = true;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $req_data = $this->request->getData();

            $this->PermissionsPermissions->deleteAll(['permission_id' => $permission_id]);
            if(!empty($req_data["permissions"])){
                foreach ($req_data["permissions"] as $key => $value) {
                    $permissionsPermissions = $this->PermissionsPermissions->newEmptyEntity();
                    $rol_arr = ["permission_id"=>$permission_id,"permission_id"=>$value];
                    $permissionsPermissions = $this->Permissions->patchEntity($permissionsPermissions, $rol_arr);
                    if ($this->PermissionsPermissions->save($permissionsPermissions)) {
                        $saved = true;
                    }
                }
            }

            if ($saved) {
                $this->Flash->success(__('The permissions has been saved.'));
                return $this->redirect(['action' => 'permissions',$permission_id]);
            }else{
                $this->Flash->error(__('The permissionsPermissions could not be saved. Please, try again.'));
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
        $permission = $this->Permissions->get($id);
        if ($this->Permissions->delete($permission)) {
            $this->Flash->success(__('The permission has been deleted.'));
        } else {
            $this->Flash->error(__('The permission could not be deleted. Please, try again.'));
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
