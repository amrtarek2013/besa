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
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $studyLevels = $this->paginate($this->StudyLevels, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->StudyLevels->types;

        $this->set('searchDegreeOptions', $this->StudyLevels->searchDegreeOptions);
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

        $this->set('searchDegreeOptions', $this->StudyLevels->searchDegreeOptions);
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

        $this->set('studyLevel', $studyLevel);
    }

    private function __common()
    {
        $uploadSettings = $this->StudyLevels->getUploadSettings();
        $this->set(compact('uploadSettings'));

        $this->set('searchDegreeOptions', $this->StudyLevels->searchDegreeOptions);
    }
}
