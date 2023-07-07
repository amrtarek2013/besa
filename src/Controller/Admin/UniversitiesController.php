<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Universities Controller
 *
 */

class UniversitiesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $universities = $this->paginate($this->Universities, ['conditions' => $conditions]);
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
            $university = $this->Universities->patchEntity($university, $this->request->getData());
            if ($this->Universities->save($university)) {
                $this->Flash->success(__('The University has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The University could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('university_new', 'universities', false, false, ['image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $types = $this->Universities->types;
        $this->set(compact('university', 'types'));
    }

    public function edit($id = null)
    {
        $university = $this->Universities->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $university = $this->Universities->patchEntity($university, $this->request->getData());


            if ($this->Universities->save($university)) {
                $this->Flash->success(__('The University has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The University could not be saved. Please, try again.'));
        }

        $this->__common();

        $types = $this->Universities->types;
        $this->set(compact('university', 'id', 'types'));
        $this->_ajaxImageUpload('university_' . $id, 'universities', $id, ['id' => $id], ['image', 'flag', 'banner_image']);
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

        return $this->redirect(['action' => 'index']);
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

        return $this->redirect(['action' => 'index']);
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
        ])->where(["active" => 1])->order(['display_order' => 'ASC'])->toArray();
        $this->set("countries", $countries);
    }
}
