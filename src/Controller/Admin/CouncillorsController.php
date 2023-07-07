<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Councillors Controller
 *
 */

class CouncillorsController extends AppController
{


    public function getAll()
    {
        $all = $this->Councillors->find('all');
        $searchForValue = ',';
        $stringValue = ',3,4,';

        if (strpos($stringValue, $searchForValue) !== false) {
            echo "Found";
        }
        foreach ($all as  $one) {
            if (strpos($one->councillor_group_id, ",") !== false) continue;
            $one->councillor_group_id = ',' . $one->councillor_group_id . ',';
            $this->Councillors->save($one);
            //    dd($one);
        }
        dd('$one');
    }

    public function index()
    {

        $conditions = $this->_filter_params();
        // $conditions['Councillors.is_office_admin !='] = 1;

        $councillors = $this->paginate($this->Councillors, ['conditions' => $conditions, 'contain' => ['Countries', 'Services']]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('councillors', 'parameters'));
        $this->formCommon();
    }

    public function add()
    {
        $councillor = $this->Councillors->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $councillor = $this->Councillors->patchEntity($councillor, $data);
            if ($this->Councillors->save($councillor)) {
                $this->Flash->success(__('The Councillor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Councillor could not be saved. Please, try again.'));
        }

        // $this->_ajaxImageUpload('Councillors_new', 'councillors', false, false, ['image']);
        $this->set('id', false);

        $this->formCommon();

        $this->set(compact('councillor'));
    }

    public function edit($id = null)
    {
        $councillor = $this->Councillors->get($id);



        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();



            $councillor = $this->Councillors->patchEntity($councillor, $data);


            if ($this->Councillors->save($councillor)) {
                $this->Flash->success(__('The Councillor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Councillor could not be saved. Please, try again.'));
        }
        $this->formCommon();
        $this->set(compact('id'));
        // $this->_ajaxImageUpload('Councillors_' . $id, 'councillors', $id, ['id' => $id], ['image']);
        $this->set(compact('councillor'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $councillor = $this->Councillors->get($id);
        if ($this->Councillors->delete($councillor)) {
            $this->Flash->success(__('The Councillor has been deleted.'));
        } else {
            $this->Flash->error(__('The Councillor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Councillors->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Councillors has been deleted.'));
        } else {
            $this->Flash->error(__('The Councillors could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $councillor = $this->Councillors->get($id);

        $this->set('councillor', $councillor);
    }

    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $councillors = $this->Councillors->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'Councillor ID' => 'Councillor ID',
            'name' => 'Name',
            // 'job_title' => 'Job Title',
            'email' => 'Email',
            'address' => 'Address',
            // 'barcode_number' => 'Barcode Number',
            'password' => 'Password',
            'active' => 'Active',
        );

        foreach ($councillors as $councillor) {
            $dataToExport[] = [
                $councillor->id,
                $councillor->name,
                // $councillor->job_title,
                $councillor->email,
                $councillor->address,
                // $councillor->barcode_number,
                '',
                ($councillor->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'councillors-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $councillor = $this->Councillors->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $error = $data['file']->getError();
            if ($data['file']->getError() == UPLOAD_ERR_OK) {
                $this->loadComponent('Csv');
                $councillorsArray = $this->Csv->convertCsvToArray($data['file'], $this->Councillors->schema_of_import);
                foreach ($councillorsArray as $councillorLine) {
                    if (empty($councillorLine['id'])) {
                        unset($councillorLine['id']);
                        $councillor = $this->Councillors->newEmptyEntity();
                    } else {
                        $councillor = $this->Councillors->get($councillorLine['id']);
                    }
                    if (empty($councillorLine['password'])) {
                        unset($councillorLine['password']);
                    }

                    $councillorLine['active'] = (strtolower($councillorLine['active']) == 'yes') ? 1 : 0;
                    // fd($councillorLine);
                    $councillor = $this->Councillors->patchEntity($councillor, $councillorLine);
                    // dd($councillor);
                    $this->Councillors->save($councillor);
                }
            }

            $this->Flash->success(__('The Councillors has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('councillor'));
    }

    public function formCommon()
    {

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('countriesList', $countriesList);



        $this->loadModel('Courses');
        $courses = $this->Courses->find('list', [
            'keyField' => 'id', 'valueField' => 'course_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('courses', $courses->toArray());

        $this->set('studyLevels', $this->Courses->studyLevels);

        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1, 'show_in_search' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('services', $services);
    }

    public function workTimes($id = null)
    {
        $councillor = $this->Councillors->get($id);
        $this->loadModel('CouncillorWorkDayTimes');
        $councillorWorkDayTimes = $this->CouncillorWorkDayTimes->find('all', array('conditions' => ['CouncillorWorkDayTimes.councillor_id' => $id], 'order' => array('CouncillorWorkDayTimes.id' => 'desc'), 'contain' => []))->toArray();

        if (!empty($councillorWorkDayTimes)) {

            $councillorWorkDayTimes = Hash::combine($councillorWorkDayTimes, '{n}.day', '{n}');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            $formData = $this->request->getData();

            foreach ($formData['CouncillorWorkDayTimes'] as $time) {

                $time['councillor_id'] = $id;

                if (!empty($time['id'])) {
                    $emptyEntity = $this->CouncillorWorkDayTimes->get($time['id']);
                } else {
                    $emptyEntity = $this->CouncillorWorkDayTimes->newEmptyEntity();
                }

                $entity = $this->CouncillorWorkDayTimes->patchEntity($emptyEntity, $time);

                $this->CouncillorWorkDayTimes->save($entity);
            }

            $this->Flash->success(__('The Councillor Work Time has been saved.'));
            return $this->redirect(['action' => 'workTimes', $id]);
        }

        $days = daysList();
        $this->set(compact('councillor', 'days', 'id', 'councillorWorkDayTimes'));
    }
}
