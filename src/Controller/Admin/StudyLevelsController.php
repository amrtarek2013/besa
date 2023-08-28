<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * StudyLevels Controller
 *
 */

class StudyLevelsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $studyLevels = $this->paginate($this->StudyLevels, ['conditions' => $conditions, 'order' => ['id' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->StudyLevels->types;
        $this->set(compact('studyLevels', 'parameters', 'types'));

        $this->set('searchDegreeOptions', $this->StudyLevels->searchDegreeOptions);

        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $studyLevels = $this->paginate($this->StudyLevels, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->StudyLevels->types;

        $this->set('searchDegreeOptions', $this->StudyLevels->searchDegreeOptions);
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
        $this->set(compact('studyLevels', 'parameters', 'types'));
    }

    public function add()
    {
        $studyLevel = $this->StudyLevels->newEmptyEntity();
        if ($this->request->is('post')) {
            $studyLevel = $this->StudyLevels->patchEntity($studyLevel, $this->request->getData());
            if ($this->StudyLevels->save($studyLevel)) {
                $this->Flash->success(__('The StudyLevel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The StudyLevel could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('studyLevel_new', 'studyLevels', false, false, ['icon', 'image', 'banner_image', 'mobile_image']);
        $this->set('id', false);

        $this->__common();
        $types = $this->StudyLevels->types;
        $this->set(compact('studyLevel', 'types'));
    }

    public function edit($id = null)
    {
        $studyLevel = $this->StudyLevels->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $studyLevel = $this->StudyLevels->patchEntity($studyLevel, $this->request->getData());


            if ($this->StudyLevels->save($studyLevel)) {
                $this->Flash->success(__('The StudyLevel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The StudyLevel could not be saved. Please, try again.'));
        }

        $this->__common();

        $types = $this->StudyLevels->types;
        $this->set(compact('studyLevel', 'id', 'types'));
        $this->_ajaxImageUpload('studyLevel_' . $id, 'studyLevels', $id, ['id' => $id], ['icon', 'image', 'banner_image', 'mobile_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $studyLevel = $this->StudyLevels->get($id);
        if ($this->StudyLevels->delete($studyLevel)) {
            $this->Flash->success(__('The StudyLevel has been deleted.'));
        } else {
            $this->Flash->error(__('The StudyLevel could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->StudyLevels->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The StudyLevels has been deleted.'));
        } else {
            $this->Flash->error(__('The StudyLevels could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $studyLevel = $this->StudyLevels->get($id);

        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
        $this->set('studyLevel', $studyLevel);
    }

    private function __common()
    {
        $uploadSettings = $this->StudyLevels->getUploadSettings();
        $this->set(compact('uploadSettings'));

        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
        $this->set('searchDegreeOptions', $this->StudyLevels->searchDegreeOptions);
    }


    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $studyLevels = $this->StudyLevels->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'id' => 'Subject Area ID',
            'title' => 'Subject Area Name',
            'main_study_level_id' => 'Main Study Level',
            // 'destination' => 'Destination',
            // 'rank' => 'Rank',
            // 'description' => 'Description'
        );

        foreach ($studyLevels as $studyLevel) {
            $dataToExport[] = [
                $studyLevel->id,
                $studyLevel->title,
                $this->StudyLevels->mainStudyLevels[$studyLevel->main_study_level_id]
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'studyLevels-list-' . date('Ymd'));

        exit();
    }
    public function import()
    {

        $studyLevel = $this->StudyLevels->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();


            // Configure::write('debug', true);
            // Configure::write('debug', 1);
            // var_dump($data['file']);
            // dd('DD');
            $error = $data['file']->getError();

            if ($data['file']->getError() == UPLOAD_ERR_OK) {

                //load all StudyLevels

                $this->loadModel("StudyLevels");
                $this->StudyLevels->virtualFields = array(
                    'name' => "LOWER(StudyLevels.title)"
                );
                $studyLevels = $this->StudyLevels->find('list', [
                    'keyField' => "title", 'valueField' => 'id'
                ])->toArray();

                // debug($studyLevels);
                $this->loadComponent('Csv');
                // dd($data['file']);
                $studyLevelsArray = $this->Csv->convertCsvToArray($data['file'], $this->StudyLevels->schema_of_import);
                // dd($studyLevelsArray);
                $studyLevelList = [];
                $fstudyLevelList = [];
                $counter = 0;
                foreach ($studyLevelsArray as $studyLevelLine) {

                    $studyLevel = $this->StudyLevels->newEmptyEntity();

                    if (isset($studyLevels[$studyLevelLine['title']])) {
                        $fstudyLevelList[] = $studyLevelLine['title'];

                        $studyLevel = $this->StudyLevels->get($studyLevels[$studyLevelLine['title']]);

                        $studyLevel->is_old = 0;
                        // continue;
                    }
                    if (isset($studyLevelLine['id']) && empty($studyLevelLine['id'])) {
                        unset($studyLevelLine['id']);
                    } else if (isset($studyLevelLine['id'])  && !empty($studyLevelLine['id'])) {
                        $studyLevel = $this->StudyLevels->get($studyLevelLine['id']);
                    }

                    if (isset($studyLevelLine['active']))
                        $studyLevelLine['active'] = (strtolower($studyLevelLine['active']) == 'yes') ? 1 : 0;
                    else
                        $studyLevelLine['active'] = 1;

                    $studyLevelLine['title'] = trim($studyLevelLine['title']);
                    $studyLevel = $this->StudyLevels->patchEntity($studyLevel, $studyLevelLine);

                    $studyLevel->main_study_level_id = isset($this->StudyLevels->mainStudyLevelsTitle[trim($studyLevelLine['main_study_level_id'])]) ? $this->StudyLevels->mainStudyLevelsTitle[trim($studyLevelLine['main_study_level_id'])] : 0;
                    $studyLevelList[] = $studyLevel;
                    $counter++;
                    if ($counter == 50) {
                        // dd($studyLevelList);
                        $this->StudyLevels->saveMany($studyLevelList);
                        $studyLevelList = [];
                        $counter = 0;
                    }
                }
                // debug($studyLevelList);
                // dd($fstudyLevelList);

                if ($counter > 0) {

                    // dd($studyLevelList);
                    $this->StudyLevels->saveMany($studyLevelList);
                    $studyLevelList = [];
                    $counter = 0;
                }
            }

            $this->Flash->success(__('The StudyLevels has been imported.'));
            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('studyLevel'));
    }
}
