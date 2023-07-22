<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Majors Controller
 *
 */

class MajorsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $majors = $this->paginate($this->Majors, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('majors', 'parameters'));

        $this->__common();
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $majors = $this->paginate($this->Majors, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('majors', 'parameters'));
    }

    public function add()
    {
        $major = $this->Majors->newEmptyEntity();
        if ($this->request->is('post')) {
            $major = $this->Majors->patchEntity($major, $this->request->getData());
            if ($this->Majors->save($major)) {
                $this->Flash->success(__('The Major has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Major could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('major_new', 'majors', false, false, ['image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $this->set(compact('major'));
    }

    public function edit($id = null)
    {
        $major = $this->Majors->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $major = $this->Majors->patchEntity($major, $this->request->getData());


            if ($this->Majors->save($major)) {
                $this->Flash->success(__('The Major has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Major could not be saved. Please, try again.'));
        }

        $this->__common();

        $this->set(compact('major', 'id'));
        $this->_ajaxImageUpload('major_' . $id, 'majors', $id, ['id' => $id], ['image', 'flag', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $major = $this->Majors->get($id);
        if ($this->Majors->delete($major)) {
            $this->Flash->success(__('The Major has been deleted.'));
        } else {
            $this->Flash->error(__('The Major could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Majors->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Majors has been deleted.'));
        } else {
            $this->Flash->error(__('The Majors could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $major = $this->Majors->get($id);

        $this->set('major', $major);
    }

    private function __common()
    {
        // $uploadSettings = $this->Majors->getUploadSettings();
        // $this->set(compact('uploadSettings'));


        // $this->loadModel("Countries");
        // $countries = $this->Countries->find('list', [
        //     'keyField' => 'id', 'valueField' => 'country_name'
        // ])->where(["active" => 1])->order(['display_order' => 'ASC'])->toArray();
        // $this->set("countries", $countries);


        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['display_order' => 'asc'])->all();
        $this->set('services', $services);
        

        // $this->loadModel("Universities");
        // $universities = $this->Universities->find()->where(['active' => 1])->order(['display_order' => 'asc'])->all();
        // $this->set('universities', $universities);


        // $this->set('studyLevels', $this->Services->studyLevels);
    }
}
