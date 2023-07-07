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
        ])->where(["active" => 1])->order(['display_order' => 'ASC'])->toArray();
        $this->set("countries", $countries);


        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['display_order' => 'asc'])->all();
        $this->set('services', $services);

        // $this->loadModel("Universities");
        // $universities = $this->Universities->find()->where(['active' => 1])->order(['display_order' => 'asc'])->all();
        // $this->set('universities', $universities);

        // $this->set('studyLevels', $this->Courses->studyLevels);
    }
}
