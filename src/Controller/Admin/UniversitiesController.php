<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;

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
        // dd($universities);
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
            $data = $this->request->getData();
            // $data['logo'] = $data['logo']->toArray();
            // $data['image'] = $data['image']->toArray();
            $university = $this->Universities->patchEntity($university, $data);
            if ($university->getErrors()) {
                Configure::write('debug', true);
                Configure::write('debug', 1);
                dd($university->getErrors());
            }
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
        // Configure::write('debug', true);
        // Configure::write('debug', 1);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $university = $this->Universities->patchEntity($university, $this->request->getData());


            if ($this->Universities->save($university)) {
                $this->Flash->success(__('The University has been saved.'));

                $this->__redirectToIndex();
            } else {
                dd($university->getErrors());
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
        $universities = $this->Universities->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'id' => 'University ID',
            'university_name' => 'University Name',
            'destination' => 'Destination',
            'rank' => 'Rank',
            'description' => 'Description'
        );

        foreach ($universities as $university) {
            $dataToExport[] = [
                $university->id,
                $university->university_name,
                $university->destination,
                $university->rank,
                $university->description,
                // '',
                // ($university->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'universities-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $university = $this->Universities->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();


            // Configure::write('debug', true);
            // Configure::write('debug', 1);
            // var_dump($data['file']);
            // dd('DD');
            //comment* $error = $data['file']->getError();

            if ((is_array($data['file']) && $data['file']['error'] == UPLOAD_ERR_OK) || (is_object($data['file']) && $data['file']->getError() == UPLOAD_ERR_OK)) {

                //load all countries

                $this->loadModel("Countries");
                $countries = $this->Countries->find('list', [
                    'keyField' => 'code', 'valueField' => 'id'
                ])->toArray();
                $countriesTitles = $this->Countries->find('list', [
                    'keyField' => 'university_name', 'valueField' => 'id'
                ])->toArray();


                // dd($countries);
                $this->loadComponent('Csv');
                // dd($data['file']);
                $universitiesArray = $this->Csv->convertCsvToArray($data['file'], $this->Universities->schema_of_import);
                // dd($universitiesArray);
                $universityList = [];
                $counter = 0;
                foreach ($universitiesArray as $universityLine) {

                    $university = $this->Universities->newEmptyEntity();
                    if (isset($universityLine['id']) && empty($universityLine['id'])) {
                        unset($universityLine['id']);
                    } else if (isset($universityLine['id'])  && !empty($universityLine['id'])) {
                        $university = $this->Universities->get($universityLine['id']);
                    }

                    if (isset($universityLine['active']))
                        $universityLine['active'] = (strtolower($universityLine['active']) == 'yes') ? 1 : 0;
                    $universityLine['logo'] = trim($universityLine['university_name']) . '.png';
                    $universityLine['title'] = $universityLine['university_name'];

                    if (isset($universityLine['destination']))
                        $universityLine['country_name'] = trim($universityLine['destination']);

                    if (isset($countries[trim($universityLine['destination'])]))
                        $universityLine['country_id'] = $countries[trim($universityLine['destination'])];
                    else if (isset($countriesTitles[trim($universityLine['destination'])]))
                        $universityLine['country_id'] = $countriesTitles[trim($universityLine['destination'])];
                    $university = $this->Universities->patchEntity($university, $universityLine);

                    $universityList[] = $university;
                    $counter++;
                    if ($counter == 50) {
                        // dd($universityList);
                        $this->Universities->saveMany($universityList);
                        $universityList = [];
                        $counter = 0;
                    }
                }

                if ($counter > 0) {

                    // dd($universityList);
                    $this->Universities->saveMany($universityList);
                    $universityList = [];
                    $counter = 0;
                }
            }

            $this->Flash->success(__('The Universities has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('university'));
    }
}
