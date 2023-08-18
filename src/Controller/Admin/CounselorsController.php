<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Counselors Controller
 *
 */

class CounselorsController extends AppController
{


    public function getAll()
    {
        $all = $this->Counselors->find('all');
        $searchForValue = ',';
        $stringValue = ',3,4,';

        if (strpos($stringValue, $searchForValue) !== false) {
            echo "Found";
        }
        foreach ($all as  $one) {
            if (strpos($one->counselor_group_id, ",") !== false) continue;
            $one->counselor_group_id = ',' . $one->counselor_group_id . ',';
            $this->Counselors->save($one);
            //    dd($one);
        }
        dd('$one');
    }

    public function index()
    {

        $conditions = $this->_filter_params();
        // $conditions['Counselors.is_office_admin !='] = 1;

        $counselors = $this->paginate($this->Counselors, ['conditions' => $conditions, 'contain' => ['Countries']]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('counselors', 'parameters'));
        $this->formCommon();
    }

    public function add()
    {
        $counselor = $this->Counselors->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $counselor = $this->Counselors->patchEntity($counselor, $data);

            if (!empty($data->password))
                $data['pp'] = $data->passwd;
            if ($this->Counselors->save($counselor)) {
                $this->Flash->success(__('The Counselor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Counselor could not be saved. Please, try again.'));
        }

        // $this->_ajaxImageUpload('Counselors_new', 'counselors', false, false, ['image']);
        $this->set('id', false);

        $this->formCommon();

        $this->set(compact('counselor'));
    }

    public function edit($id = null)
    {
        $counselor = $this->Counselors->get($id);



        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
         

            $counselor = $this->Counselors->patchEntity($counselor, $data);
            // dd($counselor);
            if (!empty($counselor->isDirty('password')))
                $counselor['pp'] = $counselor->passwd;
            if ($this->Counselors->save($counselor)) {
                $this->Flash->success(__('The Counselor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Counselor could not be saved. Please, try again.'));
        }
        $this->formCommon();
        $this->set(compact('id'));
        // $this->_ajaxImageUpload('Counselors_' . $id, 'counselors', $id, ['id' => $id], ['image']);
        $this->set(compact('counselor'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $counselor = $this->Counselors->get($id);
        if ($this->Counselors->delete($counselor)) {
            $this->Flash->success(__('The Counselor has been deleted.'));
        } else {
            $this->Flash->error(__('The Counselor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Counselors->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Counselors has been deleted.'));
        } else {
            $this->Flash->error(__('The Counselors could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $counselor = $this->Counselors->get($id);

        $this->set('counselor', $counselor);
    }

    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $counselors = $this->Counselors->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'Counselor ID' => 'Counselor ID',
            'name' => 'Name',
            // 'job_title' => 'Job Title',
            'email' => 'Email',
            'address' => 'Address',
            // 'barcode_number' => 'Barcode Number',
            'password' => 'Password',
            'active' => 'Active',
        );

        foreach ($counselors as $counselor) {
            $dataToExport[] = [
                $counselor->id,
                $counselor->name,
                // $counselor->job_title,
                $counselor->email,
                $counselor->address,
                // $counselor->barcode_number,
                '',
                ($counselor->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'counselors-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $counselor = $this->Counselors->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $error = $data['file']->getError();
            if ($data['file']->getError() == UPLOAD_ERR_OK) {
                $this->loadComponent('Csv');
                $counselorsArray = $this->Csv->convertCsvToArray($data['file'], $this->Counselors->schema_of_import);
                foreach ($counselorsArray as $counselorLine) {
                    if (empty($counselorLine['id'])) {
                        unset($counselorLine['id']);
                        $counselor = $this->Counselors->newEmptyEntity();
                    } else {
                        $counselor = $this->Counselors->get($counselorLine['id']);
                    }
                    if (empty($counselorLine['password'])) {
                        unset($counselorLine['password']);
                    }

                    $counselorLine['active'] = (strtolower($counselorLine['active']) == 'yes') ? 1 : 0;
                    // fd($counselorLine);
                    $counselor = $this->Counselors->patchEntity($counselor, $counselorLine);
                    // dd($counselor);
                    $this->Counselors->save($counselor);
                }
            }

            $this->Flash->success(__('The Counselors has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('counselor'));
    }

    public function formCommon()
    {

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);
    }

    public function workTimes($id = null)
    {
        $counselor = $this->Counselors->get($id);
        $this->loadModel('CounselorWorkDayTimes');
        $counselorWorkDayTimes = $this->CounselorWorkDayTimes->find('all', array('conditions' => ['CounselorWorkDayTimes.counselor_id' => $id], 'order' => array('CounselorWorkDayTimes.id' => 'desc'), 'contain' => []))->toArray();

        if (!empty($counselorWorkDayTimes)) {

            $counselorWorkDayTimes = Hash::combine($counselorWorkDayTimes, '{n}.day', '{n}');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            $formData = $this->request->getData();

            foreach ($formData['CounselorWorkDayTimes'] as $time) {

                $time['counselor_id'] = $id;

                if (!empty($time['id'])) {
                    $emptyEntity = $this->CounselorWorkDayTimes->get($time['id']);
                } else {
                    $emptyEntity = $this->CounselorWorkDayTimes->newEmptyEntity();
                }

                $entity = $this->CounselorWorkDayTimes->patchEntity($emptyEntity, $time);

                $this->CounselorWorkDayTimes->save($entity);
            }

            $this->Flash->success(__('The Counselor Work Time has been saved.'));
            return $this->redirect(['action' => 'workTimes', $id]);
        }

        $days = daysList();
        $this->set(compact('counselor', 'days', 'id', 'counselorWorkDayTimes'));
    }
}
