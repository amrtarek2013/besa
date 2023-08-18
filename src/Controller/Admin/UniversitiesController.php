<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Universities Controller
 *
 */

class UniversitiesController extends AppController
{

    public function index($country_id = null)
    {
        $conditions = $this->_filter_params();

        if (isset($country_id)) {
            $conditions['country_id'] = $country_id;
            $this->Session->write('country_id', $country_id);
        }


        $universities = $this->paginate($this->Universities, ['conditions' => $conditions, 'order' => ['title' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->Universities->types;
        $this->set(compact('universities', 'parameters', 'types'));

        $this->__common();
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $universities = $this->paginate($this->Universities, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->Universities->types;
        $this->set(compact('universities', 'parameters', 'types'));
    }

    public function add()
    {
        $university = $this->Universities->newEmptyEntity();
        if ($this->request->is('post')) {
            $university = $this->Universities->patchEntity($university, $this->request->getData());
            if ($this->Universities->save($university)) {
                $this->Flash->success(__('The University has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The University could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('university_new', 'universities', false, false, ['logo', 'image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $types = $this->Universities->types;
        $this->set(compact('university', 'types'));
    }

    public function edit($id = null)
    {
        $university = $this->Universities->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $university = $this->Universities->patchEntity($university, $this->request->getData());


            if ($this->Universities->save($university)) {
                $this->Flash->success(__('The University has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The University could not be saved. Please, try again.'));
        }

        $this->__common();

        $types = $this->Universities->types;
        $this->set(compact('university', 'id', 'types'));
        $this->_ajaxImageUpload('university_' . $id, 'universities', $id, ['id' => $id], ['logo', 'image', 'flag', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $university = $this->Universities->get($id);
        if ($this->Universities->delete($university)) {
            $this->Flash->success(__('The University has been deleted.'));
        } else {
            $this->Flash->error(__('The University could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Universities->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Universities has been deleted.'));
        } else {
            $this->Flash->error(__('The Universities could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function view($id = null)
    {
        $university = $this->Universities->get($id);

        $this->set('university', $university);
    }

    private function __common()
    {
        $uploadSettings = $this->Universities->getUploadSettings();
        $this->set(compact('uploadSettings'));


        $this->loadModel("Countries");
        $countries = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(["active" => 1, 'is_destination' => 1])->order(['country_name' => 'ASC'])->toArray();
        $this->set("countries", $countries);
    }


    private function __redirectToIndex()
    {
        if ($this->Session->check('country_id'))
            return $this->redirect(['action' => 'index', $this->Session->read('country_id')]);
        else
            return $this->redirect(['action' => 'index']);
    }



    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $users = $this->Users->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'User ID' => 'User ID',
            'name' => 'Name',
            // 'job_title' => 'Job Title',
            'email' => 'Email',
            'address' => 'Address',
            // 'barcode_number' => 'Barcode Number',
            'password' => 'Password',
            'active' => 'Active',
        );

        foreach ($users as $user) {
            $dataToExport[] = [
                $user->id,
                $user->name,
                // $user->job_title,
                $user->email,
                $user->address,
                // $user->barcode_number,
                '',
                ($user->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'users-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $error = $data['file']->getError();
            if ($data['file']->getError() == UPLOAD_ERR_OK) {
                $this->loadComponent('Csv');
                $usersArray = $this->Csv->convertCsvToArray($data['file'], $this->Users->schema_of_import);
                foreach ($usersArray as $userLine) {
                    if (empty($userLine['id'])) {
                        unset($userLine['id']);
                        $user = $this->Users->newEmptyEntity();
                    } else {
                        $user = $this->Users->get($userLine['id']);
                    }
                    if (empty($userLine['password'])) {
                        unset($userLine['password']);
                    }

                    $userLine['active'] = (strtolower($userLine['active']) == 'yes') ? 1 : 0;
                    // fd($userLine);
                    $user = $this->Users->patchEntity($user, $userLine);
                    // dd($user);
                    $this->Users->save($user);
                }
            }

            $this->Flash->success(__('The Users has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('user'));
    }
}
