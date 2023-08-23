<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Career Images Controller
 *
 */

class CareerImagesController extends AppController
{

    public function index($career_id = null)
    {
        $conditions = $this->_filter_params();


        if (isset($career_id)) {
            $conditions['career_id'] = $career_id;
            $this->Session->write('career_id', $career_id);
        }

        $careerImages = $this->paginate($this->CareerImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('careerImages', 'parameters'));
        $this->__common();
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $careerImages = $this->paginate($this->CareerImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->__common();
        $this->set(compact('careerImages', 'parameters'));
    }

    public function add()
    {
        $careerImage = $this->CareerImages->newEmptyEntity();
        if ($this->request->is('post')) {
            $careerImage = $this->CareerImages->patchEntity($careerImage, $this->request->getData());
            if ($this->CareerImages->save($careerImage)) {
                $this->Flash->success(__('The CareerImage has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The CareerImage could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('careerImage_new', 'careerImages', false, false, ['image']);
        $this->set('id', false);

        $this->__common();

        $this->set(compact('careerImage'));
    }

    public function edit($id = null)
    {
        $careerImage = $this->CareerImages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $careerImage = $this->CareerImages->patchEntity($careerImage, $this->request->getData());
            if ($this->CareerImages->save($careerImage)) {
                $this->Flash->success(__('The CareerImage has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The CareerImage could not be saved. Please, try again.'));
        }

        $this->__common();


        $this->set(compact('careerImage', 'id'));
        $this->_ajaxImageUpload('careerImage_' . $id, 'careerImages', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $careerImage = $this->CareerImages->get($id);
        if ($this->CareerImages->delete($careerImage)) {
            $this->Flash->success(__('The CareerImage has been deleted.'));
        } else {
            $this->Flash->error(__('The CareerImage could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->CareerImages->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Career Images has been deleted.'));
        } else {
            $this->Flash->error(__('The Career Images could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function view($id = null)
    {
        $careerImage = $this->CareerImages->get($id);

        $this->set('careerImage', $careerImage);
    }

    private function __common()
    {
        $uploadSettings = $this->CareerImages->getUploadSettings();

        $this->loadModel('Careers');
        $careers = $this->Careers->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(["active" => 1])->order(['display_order' => 'ASC'])->toArray();
        $this->set(compact('uploadSettings', 'careers'));
    }

    private function __redirectToIndex()
    {
        if ($this->Session->check('career_id'))
            return $this->redirect(['action' => 'index', $this->Session->read('career_id')]);
        else
            return $this->redirect(['action' => 'index']);
    }
}
