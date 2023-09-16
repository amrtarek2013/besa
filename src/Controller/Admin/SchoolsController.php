<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Utility\Hash;

/**
 * Schools Controller
 *
 */

class SchoolsController extends AppController
{

    public function index($country_id = null)
    {
        $conditions = $this->_filter_params();

        if (isset($country_id)) {
            $conditions['country_id'] = $country_id;
            $this->Session->write('country_id', $country_id);
        }


        $schools = $this->paginate($this->Schools, ['conditions' => $conditions, 'contain' => ['Countries'], 'order' => ['name' => 'ASC']]);
        // dd($schools);
        $parameters = $this->request->getAttribute('params');
        $types = $this->Schools->types;
        $this->set(compact('schools', 'parameters', 'types'));

        $this->__common();
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $schools = $this->paginate($this->Schools, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->Schools->types;
        $this->set(compact('schools', 'parameters', 'types'));
    }

    public function add()
    {
        $school = $this->Schools->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // $data['logo'] = $data['logo']->toArray();
            // $data['image'] = $data['image']->toArray();
            $school = $this->Schools->patchEntity($school, $data);
            if ($school->getErrors()) {
                Configure::write('debug', true);
                Configure::write('debug', 1);
                dd($school->getErrors());
            }
            if ($this->Schools->save($school)) {
                $this->Flash->success(__('The School has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The School could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('school_new', 'schools', false, false, ['logo', 'image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $types = $this->Schools->types;
        $this->set(compact('school', 'types'));
    }

    public function edit($id = null)
    {
        $school = $this->Schools->get($id);
        // Configure::write('debug', true);
        // Configure::write('debug', 1);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $school = $this->Schools->patchEntity($school, $this->request->getData());


            if ($this->Schools->save($school)) {
                $this->Flash->success(__('The School has been saved.'));

                $this->__redirectToIndex();
            } else {

                $this->Flash->error(__('The School could not be saved. Please, try again.'));
            }
        }

        $this->__common();

        $types = $this->Schools->types;
        $this->set(compact('school', 'id', 'types'));
        $this->_ajaxImageUpload('school_' . $id, 'schools', $id, ['id' => $id], ['logo', 'image', 'flag', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $school = $this->Schools->get($id);
        if ($this->Schools->delete($school)) {
            $this->Flash->success(__('The School has been deleted.'));
        } else {
            $this->Flash->error(__('The School could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Schools->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Schools has been deleted.'));
        } else {
            $this->Flash->error(__('The Schools could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function view($id = null)
    {
        $school = $this->Schools->get($id);

        $this->set('school', $school);
    }

    private function __common()
    {
        $uploadSettings = $this->Schools->getUploadSettings();
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
        $schools = $this->Schools->find('all')->contain(['Countries' => ['fields' => ['country_name']]])->where($conditions)->toArray();

        $dataToExport[] = array(
            'id' => 'School ID',
            'name' => 'School Name',
            'country_id' => 'Destination ID',
            'destination' => 'Destination',
            'rank' => 'Rank',
            'is_partner'=>'Is Partner',
            'description' => 'Description'
        );

        foreach ($schools as $school) {
            $dataToExport[] = [
                $school->id,
                $school->name,
                $school->country_id,
                $school->country->country_name,
                $school->rank,
                $school->is_partner,
                $school->description,
                // '',
                // ($school->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'schools-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $school = $this->Schools->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();


            // Configure::write('debug', true);
            // Configure::write('debug', 1);
            // var_dump($data['file']);
            // dd('DD');
            //comment* $error = $data['file']->getError();

            if ($data['file']->getError() == UPLOAD_ERR_OK) {

                //load all countries

                $this->loadModel("Countries");

                $countries = $this->Countries->find()->select(['name' => 'trim(lower(country_name))', 'id'])->toArray();
                $countries = Hash::combine($countries, '{n}.name', '{n}.id');


                // dd($countries);
                $this->loadComponent('Csv');
                // dd($data['file']);
                $schoolsArray = $this->Csv->convertCsvToArray($data['file'], $this->Schools->schema_of_import);
                // dd($schoolsArray);
                $schoolList = [];
                $counter = 0;
                foreach ($schoolsArray as $schoolLine) {

                    $school = $this->Schools->newEmptyEntity();
                    if (isset($schoolLine['id']) && empty($schoolLine['id'])) {
                        unset($schoolLine['id']);
                    } else if (isset($schoolLine['id'])  && !empty($schoolLine['id'])) {
                        $school = $this->Schools->get($schoolLine['id']);
                    }

                    if (isset($schoolLine['active']))
                        $schoolLine['active'] = (strtolower($schoolLine['active']) == 'yes') ? 1 : 0;
                    $schoolLine['logo'] = trim($schoolLine['name']) . '.png';
                    // $schoolLine['name'] = $schoolLine['name'];

                    // if (isset($schoolLine['destination']))
                    //     $schoolLine['country_name'] = trim($schoolLine['destination']);

                    if (empty($schoolLine['country_id']) && isset($countries[strtolower(trim($schoolLine['destination']))]))
                        $schoolLine['country_id'] = $countries[strtolower(trim($schoolLine['destination']))];

                    $school = $this->Schools->patchEntity($school, $schoolLine);

                    $schoolList[] = $school;
                    $counter++;
                    if ($counter == 50) {
                        // dd($schoolList);
                        $this->Schools->saveMany($schoolList);
                        $schoolList = [];
                        $counter = 0;
                    }
                }

                if ($counter > 0) {

                    // dd($schoolList);
                    $this->Schools->saveMany($schoolList);
                    $schoolList = [];
                    $counter = 0;
                }
            }

            $this->Flash->success(__('The Schools has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('school'));
    }
}