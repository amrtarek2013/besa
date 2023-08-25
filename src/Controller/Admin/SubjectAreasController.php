<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * SubjectAreas Controller
 *
 */

class SubjectAreasController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $subjectAreas = $this->paginate($this->SubjectAreas, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('subjectAreas', 'parameters'));

        $this->__common();
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $subjectAreas = $this->paginate($this->SubjectAreas, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('subjectAreas', 'parameters'));
    }

    public function add()
    {
        $subjectArea = $this->SubjectAreas->newEmptyEntity();
        if ($this->request->is('post')) {
            $subjectArea = $this->SubjectAreas->patchEntity($subjectArea, $this->request->getData());
            if ($this->SubjectAreas->save($subjectArea)) {
                $this->Flash->success(__('The SubjectArea has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The SubjectArea could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('subjectArea_new', 'subjectAreas', false, false, ['image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $this->set(compact('subjectArea'));
    }

    public function edit($id = null)
    {
        $subjectArea = $this->SubjectAreas->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subjectArea = $this->SubjectAreas->patchEntity($subjectArea, $this->request->getData());


            if ($this->SubjectAreas->save($subjectArea)) {
                $this->Flash->success(__('The SubjectArea has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The SubjectArea could not be saved. Please, try again.'));
        }

        $this->__common();

        $this->set(compact('subjectArea', 'id'));
        $this->_ajaxImageUpload('subjectArea_' . $id, 'subjectAreas', $id, ['id' => $id], ['image', 'flag', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $subjectArea = $this->SubjectAreas->get($id);
        if ($this->SubjectAreas->delete($subjectArea)) {
            $this->Flash->success(__('The SubjectArea has been deleted.'));
        } else {
            $this->Flash->error(__('The SubjectArea could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->SubjectAreas->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The SubjectAreas has been deleted.'));
        } else {
            $this->Flash->error(__('The SubjectAreas could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $subjectArea = $this->SubjectAreas->get($id);

        $this->set('subjectArea', $subjectArea);
    }

    private function __common()
    {
        // $uploadSettings = $this->SubjectAreas->getUploadSettings();
        // $this->set(compact('uploadSettings'));


        $this->loadModel("Countries");
        $countries = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(["active" => 1, 'is_destination' => 1])->order(['country_name' => 'ASC'])->toArray();
        $this->set("countries", $countries);


        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->all();
        $this->set('services', $services);
    }



    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $subjectAreas = $this->SubjectAreas->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'id' => 'Subject Area ID',
            'title' => 'Subject Area Name',
            // 'destination' => 'Destination',
            // 'rank' => 'Rank',
            // 'description' => 'Description'
        );

        foreach ($subjectAreas as $subjectArea) {
            $dataToExport[] = [
                $subjectArea->id,
                $subjectArea->title,
                // $subjectArea->destination,
                // $subjectArea->rank,
                // $subjectArea->description,
                // '',
                // ($subjectArea->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'subjectAreas-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $subjectArea = $this->SubjectAreas->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();


            // Configure::write('debug', true);
            // Configure::write('debug', 1);
            // var_dump($data['file']);
            // dd('DD');
            $error = $data['file']->getError();

            if ($data['file']->getError() == UPLOAD_ERR_OK) {

                //load all SubjectAreas

                $this->loadModel("SubjectAreas");
                $this->SubjectAreas->virtualFields = array(
                    'name' => "LOWER(SubjectAreas.title)"
                );
                $subjectAreas = $this->SubjectAreas->find('list', [
                    'keyField' => "title", 'valueField' => 'id'
                ])->toArray();

                // debug($subjectAreas);
                $this->loadComponent('Csv');
                // dd($data['file']);
                $subjectAreasArray = $this->Csv->convertCsvToArray($data['file'], $this->SubjectAreas->schema_of_import);
                // dd($subjectAreasArray);
                $subjectAreaList = [];
                $fsubjectAreaList = [];
                $counter = 0;
                foreach ($subjectAreasArray as $subjectAreaLine) {

                    $subjectArea = $this->SubjectAreas->newEmptyEntity();

                    if (isset($subjectAreas[$subjectAreaLine['title']])) {
                        $fsubjectAreaList[] = $subjectAreaLine['title'];

                        $subjectArea = $this->SubjectAreas->get($subjectAreas[$subjectAreaLine['title']]);
                     
                        $subjectArea->is_old = 0;
                        // continue;
                    }
                    if (isset($subjectAreaLine['id']) && empty($subjectAreaLine['id'])) {
                        unset($subjectAreaLine['id']);
                    } else if (isset($subjectAreaLine['id'])  && !empty($subjectAreaLine['id'])) {
                        $subjectArea = $this->SubjectAreas->get($subjectAreaLine['id']);
                    }

                    if (isset($subjectAreaLine['active']))
                        $subjectAreaLine['active'] = (strtolower($subjectAreaLine['active']) == 'yes') ? 1 : 0;
                    else
                        $subjectAreaLine['active'] = 1;

                    $subjectAreaLine['title'] = trim($subjectAreaLine['title']);
                    $subjectArea = $this->SubjectAreas->patchEntity($subjectArea, $subjectAreaLine);

                    $subjectAreaList[] = $subjectArea;
                    $counter++;
                    if ($counter == 50) {
                        // dd($subjectAreaList);
                        $this->SubjectAreas->saveMany($subjectAreaList);
                        $subjectAreaList = [];
                        $counter = 0;
                    }
                }
                // debug($subjectAreaList);
                // dd($fsubjectAreaList);

                if ($counter > 0) {

                    // dd($subjectAreaList);
                    $this->SubjectAreas->saveMany($subjectAreaList);
                    $subjectAreaList = [];
                    $counter = 0;
                }
            }

            $this->Flash->success(__('The SubjectAreas has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('subjectArea'));
    }
}
