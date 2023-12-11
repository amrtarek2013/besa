<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Database\Expression\QueryExpression;
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

        $conditions = $this->_filter_params();
        // $conditions = [];
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
            $user->bd = $data['day'] . '-' . $data['month'] . '-' . $data['year'];
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

            if (!empty($data['mobile_code']))
                $data['mobile_code'] = str_replace('+', '', $data['mobile_code']);

            if (!empty($data['date']) && strtotime($data['date']))
                $user->bd = date('Y-m-d', strtotime($data['date'])); //$data['year'] . '-' . $data['month'] . '-' . $data['day'];
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The User has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The User could not be saved. Please, try again.'));
        }

        $user->bd = isset($user['bd']) ? $user['bd']->format('d/m/Y') : '';
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
    public function confirmMulti()
    {
        $this->request->allowMethod(['patch', 'post', 'put']);


        if ($this->request->is(['patch', 'post', 'put'])) {
            $ids = $this->request->getData('ids');

            if (is_array($ids)) {
                // $this->Users->find(['id IN' => $ids]);

                // $expression = new QueryExpression('confirmed = true and active = true');
                // $this->Users->updateAll([$expression], ['id IN' => $ids]);

                $queryObject = $this->Users->query();

                $queryObject->update()->set([
                    "confirmed" => true,
                    "active" => true
                ])->where(['id IN' => $ids])->execute();
                $this->Flash->success(__('The Users has been confirmed.'));
            } else {
                $this->Flash->error(__('The Users could not be confirmed. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $user = $this->Users->find()->where(['Users.id' => $id])->contain([
            'Countries' => ['fields' => ['country_name']],
            // 'StudyLevels' => ['fields' => ['title']],
            'SubjectAreas' => ['fields' => ['title']], 'Destinations' => ['fields' => ['country_name']],
            'Nationalities' => ['fields' => ['country_name']]
        ])->first();

        $user->bd = isset($user['bd']) ? $user['bd']->format('d/m/Y') : '';
        $this->set('user', $user);
        $this->loadModel('StudyLevels');
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
    }

    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $users = $this->Users->find('all')->contain(['Countries', 'Destinations', 'Nationalities', 'SubjectAreas'])->where($conditions)->toArray();

        // dd($users);
        $dataToExport[] = array(
            'User ID' => 'User ID',
            'name' => 'Name',
            'email' => 'Email',
            'mobile' => 'Mobile',

            'country_id' => 'Country of residence',
            'nationality_id' => 'Nationally',
            'current_status' => 'Current School / Uni',
            'current_study_level' => 'Current/last Level of study',
            'subject_area_id' => 'Major of Study',
            'destination_id' => 'Country you study at',
        );
        $this->loadModel('StudyLevels');

        foreach ($users as $user) {
            $dataToExport[] = [
                $user->id,
                $user->first_name . ' ' . $user->last_name,
                $user->email,
                '(+' . $user->mobile_code . ') ' . $user->mobile,

                isset($user->country) ? $user->country->country_name : '',
                isset($user->nationality) ? $user->nationality->country_name : '',
                $user->current_status,
                isset($this->StudyLevels->mainStudyLevels[$user->current_study_level]) ? $this->StudyLevels->mainStudyLevels[$user->current_study_level] : '',
                isset($user->subject_area) ? $user->subject_area->title : '',
                isset($user->destination) ? $user->destination->country_name : '',
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

            //comment* $error = $data['file']->getError();
            if ((is_array($data['file']) && $data['file']['error'] == UPLOAD_ERR_OK) || (is_object($data['file']) && $data['file']->getError() == UPLOAD_ERR_OK)) {
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
        $this->set('currentStudyLevels', $this->StudyLevels->mainStudyLevels);

        $this->loadModel('SubjectAreas');
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
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
