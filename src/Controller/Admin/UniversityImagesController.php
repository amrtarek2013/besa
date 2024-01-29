<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * University Images Controller
 *
 */

class UniversityImagesController extends AppController
{
    
    private function __university($university_id = null)
    {


        $universityTitle = '';
        if (!$university_id && $this->Session->check('university_id')) {
            $university_id = $this->Session->read('university_id');
        }
        if ($university_id) {
            $this->loadModel('Universities');
            $university = $this->Universities->find()->select(['title'])->where(['id' => $university_id])->first();
            if (!empty($university))
                $universityTitle = $university['title'];
        }

        // dd($universityTitle);
        $this->set('universityTitle', $universityTitle);
        //4, 6, 7
        $this->set('university_id', $university_id);
    }

    public function index($university_id = null)
    {
        $conditions = $this->_filter_params();


        if (isset($university_id)) {
            $conditions['university_id'] = $university_id;
            $this->Session->write('university_id', $university_id);
        }

        $this->__university($university_id);
        $universityImages = $this->paginate($this->UniversityImages, [
            'contain' => ['Universities' => ['fields' => ['university_name']]],
            'conditions' => $conditions
        ]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('universityImages', 'parameters'));
        $this->__common();
    }
    public function list($university_id = null)
    {
        $conditions = $this->_filter_params();


        if (isset($university_id)) {
            $conditions['university_id'] = $university_id;
            $this->Session->write('university_id', $university_id);
        }
        
        $this->__university($university_id);
        $universityImages = $this->paginate($this->UniversityImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->__common();
        $this->set(compact('universityImages', 'parameters'));
    }

    public function add()
    {
        $universityImage = $this->UniversityImages->newEmptyEntity();
        if ($this->request->is('post')) {
            $universityImage = $this->UniversityImages->patchEntity($universityImage, $this->request->getData());
            if ($this->UniversityImages->save($universityImage)) {
                $this->Flash->success(__('The UniversityImage has been saved.'));

                
                $this->Session->write('university_id', $universityImage['university_id']);
                $this->__university($universityImage['university_id']);
                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The UniversityImage could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('universityImage_new', 'universityImages', false, false, ['image']);
        $this->set('id', false);

        $this->__common();

        $this->set(compact('universityImage'));
    }

    public function edit($id = null)
    {
        $universityImage = $this->UniversityImages->get($id);
        
        $this->Session->write('university_id', $universityImage['university_id']);
        $this->__university($universityImage['university_id']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $universityImage = $this->UniversityImages->patchEntity($universityImage, $this->request->getData());
            if ($this->UniversityImages->save($universityImage)) {
                $this->Flash->success(__('The UniversityImage has been saved.'));

                $this->Session->write('university_id', $universityImage['university_id']);
                $this->__university($universityImage['university_id']);
                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The UniversityImage could not be saved. Please, try again.'));
        }

        $this->__common();


        $this->set(compact('universityImage', 'id'));
        $this->_ajaxImageUpload('universityImage_' . $id, 'universityImages', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $universityImage = $this->UniversityImages->get($id);
        
        $this->Session->write('university_id', $universityImage['university_id']);
        $this->__university($universityImage['university_id']);
        if ($this->UniversityImages->delete($universityImage)) {
            $this->Flash->success(__('The UniversityImage has been deleted.'));
        } else {
            $this->Flash->error(__('The UniversityImage could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->UniversityImages->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The University Images has been deleted.'));
        } else {
            $this->Flash->error(__('The University Images could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function view($id = null)
    {
        $universityImage = $this->UniversityImages->get($id);

        $this->Session->write('university_id', $universityImage['university_id']);
        $this->__university($universityImage['university_id']);
        $this->set('universityImage', $universityImage);
    }

    private function __common()
    {
        $uploadSettings = $this->UniversityImages->getUploadSettings();

        $this->loadModel('Universities');
        $universities = $this->Universities->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->order(['title' => 'ASC'])->toArray();
        $this->set(compact('uploadSettings', 'universities'));
    }


    private function __redirectToIndex()
    {
        if ($this->Session->check('university_id'))
            return $this->redirect(['action' => 'index', $this->Session->read('university_id')]);
        else
            return $this->redirect(['action' => 'index']);
    }
}
