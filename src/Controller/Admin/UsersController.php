<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Users Controller
 *
 */

class UsersController extends AppController
{


    public function getAll()
    {
        $all = $this->Users->find('all');
        $searchForValue = ',';
        $stringValue = ',3,4,';

        if (strpos($stringValue, $searchForValue) !== false) {
            echo "Found";
        }
        foreach ($all as  $one) {
            if (strpos($one->user_group_id, ",") !== false) continue;
            $one->user_group_id = ',' . $one->user_group_id . ',';
            $this->Users->save($one);
            //    dd($one);
        }
        dd('$one');
    }

    public function index()
    {

        // $conditions = $this->_filter_params();
        $conditions = [];
        // $conditions['Users.is_office_admin !='] = 1;

        $users = $this->paginate($this->Users, ['conditions' => $conditions, 'contain' => ['Countries' => ['fields' => ['country_name']]/*, 'Services'*/]]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('users', 'parameters'));
        $this->formCommon();
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The User has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The User could not be saved. Please, try again.'));
        }

        // $this->_ajaxImageUpload('Users_new', 'users', false, false, ['image']);
        $this->set('id', false);

        $this->formCommon();

        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id);



        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();



            $user = $this->Users->patchEntity($user, $data);


            if ($this->Users->save($user)) {
                $this->Flash->success(__('The User has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The User could not be saved. Please, try again.'));
        }
        $this->formCommon();
        $this->set(compact('id'));
        // $this->_ajaxImageUpload('Users_' . $id, 'users', $id, ['id' => $id], ['image']);
        $this->set(compact('user'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The User has been deleted.'));
        } else {
            $this->Flash->error(__('The User could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Users->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Users has been deleted.'));
        } else {
            $this->Flash->error(__('The Users could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id);

        $this->set('user', $user);
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

    public function formCommon()
    {

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('countriesList', $countriesList);
        $this->loadModel('StudyLevels');
        // $studyLevels = $this->StudyLevels->find('list', [
        //     'keyField' => 'id', 'valueField' => 'title'
        // ])->where(['active' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);

        $this->loadModel('SubjectAreas');
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);
    }

    public function workTimes($id = null)
    {
        $user = $this->Users->get($id);
        $this->loadModel('UserWorkDayTimes');
        $userWorkDayTimes = $this->UserWorkDayTimes->find('all', array('conditions' => ['UserWorkDayTimes.user_id' => $id], 'order' => array('UserWorkDayTimes.id' => 'desc'), 'contain' => []))->toArray();

        if (!empty($userWorkDayTimes)) {

            $userWorkDayTimes = Hash::combine($userWorkDayTimes, '{n}.day', '{n}');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            $formData = $this->request->getData();

            foreach ($formData['UserWorkDayTimes'] as $time) {

                $time['user_id'] = $id;

                if (!empty($time['id'])) {
                    $emptyEntity = $this->UserWorkDayTimes->get($time['id']);
                } else {
                    $emptyEntity = $this->UserWorkDayTimes->newEmptyEntity();
                }

                $entity = $this->UserWorkDayTimes->patchEntity($emptyEntity, $time);

                $this->UserWorkDayTimes->save($entity);
            }

            $this->Flash->success(__('The User Work Time has been saved.'));
            return $this->redirect(['action' => 'workTimes', $id]);
        }

        $days = daysList();
        $this->set(compact('user', 'days', 'id', 'userWorkDayTimes'));
    }
}
