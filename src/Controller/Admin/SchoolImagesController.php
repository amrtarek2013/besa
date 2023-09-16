<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * School Images Controller
 *
 */

class SchoolImagesController extends AppController
{

    public function index($school_id = null)
    {
        $conditions = $this->_filter_params();


        if (isset($school_id)) {
            $conditions['school_id'] = $school_id;
            $this->Session->write('school_id', $school_id);
        }

        $schoolImages = $this->paginate($this->SchoolImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('schoolImages', 'parameters'));
        $this->__common();
    }
    public function list($school_id = null)
    {
        $conditions = $this->_filter_params();
        if (isset($school_id)) {
            $conditions['school_id'] = $school_id;
            $this->Session->write('school_id', $school_id);
        }
        $schoolImages = $this->paginate($this->SchoolImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->__common();
        $this->set(compact('schoolImages', 'parameters'));
    }

    public function add()
    {
        $schoolImage = $this->SchoolImages->newEmptyEntity();
        if ($this->request->is('post')) {
            $schoolImage = $this->SchoolImages->patchEntity($schoolImage, $this->request->getData());
            if ($this->SchoolImages->save($schoolImage)) {
                $this->Flash->success(__('The School Image has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The School Image could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('schoolImage_new', 'schoolImages', false, false, ['image']);
        $this->set('id', false);

        $this->__common();

        $this->set(compact('schoolImage'));
    }

    public function edit($id = null)
    {
        $schoolImage = $this->SchoolImages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schoolImage = $this->SchoolImages->patchEntity($schoolImage, $this->request->getData());
            if ($this->SchoolImages->save($schoolImage)) {
                $this->Flash->success(__('The School Image has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The School Image could not be saved. Please, try again.'));
        }

        $this->__common();


        $this->set(compact('schoolImage', 'id'));
        $this->_ajaxImageUpload('schoolImage_' . $id, 'schoolImages', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $schoolImage = $this->SchoolImages->get($id);
        if ($this->SchoolImages->delete($schoolImage)) {
            $this->Flash->success(__('The School Image has been deleted.'));
        } else {
            $this->Flash->error(__('The School Image could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->SchoolImages->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The School Images has been deleted.'));
        } else {
            $this->Flash->error(__('The School Images could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function view($id = null)
    {
        $schoolImage = $this->SchoolImages->get($id);

        $this->set('schoolImage', $schoolImage);
    }

    private function __common()
    {
        $uploadSettings = $this->SchoolImages->getUploadSettings();

        $this->loadModel('Schools');
        $schools = $this->Schools->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->where(["active" => 1])->order(['name' => 'ASC'])->toArray();
        $this->set(compact('uploadSettings', 'schools'));
    }

    private function __redirectToIndex()
    {
        if ($this->Session->check('school_id'))
            return $this->redirect(['action' => 'index', $this->Session->read('school_id')]);
        else
            return $this->redirect(['action' => 'index']);
    }
}
