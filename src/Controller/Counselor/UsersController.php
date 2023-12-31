<?php

declare(strict_types=1);

namespace App\Controller\Counselor;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Exception;

/**
 * Users Controller
 *
 */

class UsersController extends AppController
{


    public function index()
    {

        $counselor = $this->Auth->user();
        try {
            // $counselor = $this->Counselors->get($counselor['id']);

            if (!$counselor) {
                $this->Flash->error(__('Counselor not Found!!!'));
                $this->redirect('/counselor/logout');
            }
        } catch (Exception $ex) {

            $this->Flash->error(__('Counselor not Found!!!'));
            $this->redirect('/counselor/logout');
        }

        $conditions = $this->_filter_params();

        $conditions['Users.counselor_id'] = $counselor['id'];

        $usersApp = $this->paginate($this->Users, ['conditions' => $conditions, 'contain' => ['Countries' => ['fields' => ['country_name']], 'Applications'/*, 'Services'*/]]);
        // dd($usersApp->toArray());

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('usersApp', 'parameters'));
        $this->loadModel('Applications');
        $this->set('statuses', $this->Applications->statuses);
        $this->set('statusLabel', $this->Applications->statusLabel);
        $this->formCommon();
    }

    // public function add()
    // {
    //     $user = $this->Users->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $data = $this->request->getData();
    //         $user = $this->Users->patchEntity($user, $data);

    //         $counselor = $this->Auth->user();
    //         $user['counselor_id'] = $counselor['id'];
    //         if ($this->Users->save($user)) {
    //             $this->Flash->success(__('The User has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The User could not be saved. Please, try again.'));
    //     }

    //     // $this->_ajaxImageUpload('Users_new', 'users', false, false, ['image']);
    //     $this->set('id', false);

    //     $this->formCommon();

    //     $this->set(compact('user'));
    // }

    // public function edit($id = null)
    // {

    //     $counselor = $this->Auth->user();
    //     $conditions['id'] = $id;
    //     $conditions['counselor_id'] = $counselor['id'];
    //     $user = $this->Users->find($id)->where($conditions)->first();

    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $data = $this->request->getData();



    //         $user = $this->Users->patchEntity($user, $data);


    //         if ($this->Users->save($user)) {
    //             $this->Flash->success(__('The User has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The User could not be saved. Please, try again.'));
    //     }
    //     $this->formCommon();
    //     $this->set(compact('id'));
    //     // $this->_ajaxImageUpload('Users_' . $id, 'users', $id, ['id' => $id], ['image']);
    //     $this->set(compact('user'));
    //     $this->render('add');
    // }

    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete', 'get']);

    //     $counselor = $this->Auth->user();
    //     $conditions['id'] = $id;
    //     $conditions['counselor_id'] = $counselor['id'];
    //     $user = $this->Users->find($id)->where($conditions)->first();

    //     if ($this->Users->delete($user)) {
    //         $this->Flash->success(__('The User has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The User could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    // public function deleteMulti()
    // {
    //     $this->request->allowMethod(['post', 'delete']);

    //     $ids = $this->request->getData('ids');

    //     $counselor = $this->Auth->user();

    //     if (is_array($ids)) {
    //         $this->Users->deleteAll(['id IN' => $ids, 'counselor_id' => $counselor['id']]);
    //         $this->Flash->success(__('The Users has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The Users could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    public function view($id = null)
    {

        $conditions = ['Users.id' => $id];
        $counselor = $this->Auth->user();
        $conditions['Users.counselor_id'] = $counselor['id'];
        $user = $this->Users->find()->where($conditions)->contain(['Countries', 'StudyLevels', 'SubjectAreas', 'Destinations'])->first();

        // dd($user);
        $this->set('user', $user);
        $this->loadModel('StudyLevels');
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
    }

    public function export($sample = false)
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();

        $counselor = $this->Auth->user();
        $conditions['Users.counselor_id'] = $counselor['id'];
        $users = $this->Users->find('all')->where($conditions)->toArray();


        // if (!$sample) {
            $dataToExport[] = array(
                'id' => 'Student ID',
                'first_name' => 'Student Name',
                'email' => 'Email',
                'mobile' => 'Mobile',
                'high_school_grade' => 'Grade',
                'curriculum' => 'Curriculum'
            );
        // } else {

        //     $dataToExport[] = array(
        //         'first_name' => 'Student Name',
        //         'email' => 'Email',
        //         'mobile' => 'Mobile',
        //         'high_school_grade' => 'Grade',
        //         'curriculum' => 'Curriculum'
        //     );
        // }

        if (!$sample) {
            foreach ($users as $user) {
                $dataToExport[] = [
                    $user->id,
                    $user->first_name,
                    $user->email,
                    $user->mobile,
                    $user->high_school_grade,
                    $user->curriculum
                ];
            }
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'users-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $user = $this->Users->newEmptyEntity();

        $schema_of_import = [
            'id',
            'first_name',
            'email',
            'mobile',
            'grade',
            'curriculum'
        ];
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // dd($data);
            //comment* $error = $data['file']->getError();

            if ((is_array($data['file']) && $data['file']['error'] == UPLOAD_ERR_OK) || (is_object($data['file']) && $data['file']->getError() == UPLOAD_ERR_OK)) {

                $this->loadComponent('Csv');
                $usersArray = $this->Csv->convertCsvToArray($data['file'], $schema_of_import);

                // dd($data['file']);
                $counselor = $this->Auth->user();
                foreach ($usersArray as $userLine) {
                    if (empty($userLine['id'])) {
                        unset($userLine['id']);
                        $user = $this->Users->newEmptyEntity();
                    } else {
                        $user = $this->Users->get($userLine['id']);
                    }
                    // if (empty($userLine['password'])) {
                    //     unset($userLine['password']);
                    // }

                    // $userLine['active'] = (strtolower($userLine['active']) == 'yes') ? 1 : 0;
                    // fd($userLine);
                    $user = $this->Users->patchEntity($user, $userLine);
                    // dd($user);

                    $user['counselor_id'] = $counselor['id'];
                    $this->Users->save($user);
                }
            }

            $this->Flash->success(__('The Students CSV file has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('user'));
    }

    public function formCommon()
    {

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);


        $destinationsList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->order(['country_name' => 'asc']);
        $this->set('destinationsList', $destinationsList);


        $countriesCodesList = $this->Countries->find()->select([
            'code', 'phone_code'
        ])->where(['active' => 1])->order(['phone_code' => 'asc']);

        $countriesCodesList = Hash::combine(
            $countriesCodesList->toArray(),
            '{n}.phone_code',
            ['+%s', '{n}.phone_code']
        );

        $this->set('countriesCodesList', $countriesCodesList);
        $this->loadModel('StudyLevels');
        // $studyLevels = $this->StudyLevels->find('list', [
        //     'keyField' => 'id', 'valueField' => 'title'
        // ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);

        $this->loadModel('SubjectAreas');
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);
    }
}
