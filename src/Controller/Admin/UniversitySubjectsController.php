<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * UniversitySubjects Controller
 *
 */

class UniversitySubjectsController extends AppController
{


    private function __mainUniversity($university_id = null)
    {


        $mainUniversityTitle = '';
        if (!$university_id && $this->Session->check('university_id')) {
            $university_id = $this->Session->read('university_id');
        }
        if ($university_id) {
            $this->loadModel('Universities');
            $mainUniversity = $this->Universities->find()->select(['title'])->where(['id' => $university_id])->first();
            // dd($mainUniversity);
            if (!empty($mainUniversity))
                $mainUniversityTitle = $mainUniversity['title'];
        }

        $this->set('mainUniversityTitle', $mainUniversityTitle);
        //4, 6, 7
        $this->set('university_id', $university_id);
    }


    private function __redirectToIndex()
    {
        if ($this->Session->check('university_id'))
            return $this->redirect(['action' => 'index', $this->Session->read('university_id')]);
        else
            return $this->redirect(['action' => 'index']);
    }
    public function index($university_id = null)
    {
        $conditions = $this->_filter_params();
        if (isset($university_id)) {
            $conditions['UniversitySubjects.university_id'] = $university_id;
            $this->Session->write('university_id', $university_id);
        }
        $this->__mainUniversity($university_id);

        $universitySubjects = $this->paginate($this->UniversitySubjects, [
            'conditions' => $conditions,
            'contain' => [
                'Universities' => ['fields' => ['university_name']],
                'SubjectAreas' => ['fields' => ['title']]
            ]
        ]);

        // dd($universitySubjects);
        // $this->loadModel("Universities");
        // $universities = $this->Universities->find('list', [
        //     'keyField' => 'id', 'valueField' => 'university_name'
        // ])->where(['active' => 1])->order(['university_name' => 'asc'])->toArray();
        // $this->set('universities', $universities);

        $parameters = $this->request->getAttribute('params');

        $this->set(compact('universitySubjects', 'parameters'));
    }
    public function list($university_id = null)
    {
        $conditions = $this->_filter_params();

        if (isset($university_id)) {
            $conditions['university_id'] = $university_id;
            $this->Session->write('university_id', $university_id);
        }
        $this->__mainUniversity($university_id);
        $universitySubjects = $this->paginate($this->UniversitySubjects, [
            'conditions' => $conditions,
            'contain' => [
                'Universities' => ['fields' => ['university_name']],
                'SubjectAreas' => ['fields' => ['title']]
            ]
        ]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('universitySubjects', 'parameters'));
    }

    public function add($university_id = null)
    {
        $universitySubject = $this->UniversitySubjects->newEmptyEntity();

        if (isset($university_id)) {
            $this->Session->write('university_id', $university_id);
        }
        $this->__mainUniversity($university_id);

        $this->loadModel("SubjectAreas");
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);

        if ($this->request->is('post')) {
            $universitySubject = $this->UniversitySubjects->patchEntity($universitySubject, $this->request->getData());
            if ($this->UniversitySubjects->save($universitySubject)) {

                $this->Flash->success(__('The University Subject has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The University Subject could not be saved. Please, try again.'));
        }

        $this->__common();

        $this->set(compact('universitySubject'));
    }

    public function edit($id = null)
    {
        $universitySubject = $this->UniversitySubjects->get($id);

        // dd($universitySubject);

        $this->Session->write('university_id', $universitySubject['university_id']);

        $this->__mainUniversity($universitySubject['university_id']);

        $this->loadModel("SubjectAreas");
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $universitySubject = $this->UniversitySubjects->patchEntity($universitySubject, $this->request->getData());


            if ($this->UniversitySubjects->save($universitySubject)) {
                $this->Flash->success(__('The University Subject has been saved.'));
                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The University Subject could not be saved. Please, try again.'));
        }

        $this->__common();


        $this->set(compact('universitySubject', 'id'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $universitySubject = $this->UniversitySubjects->get($id);

        $this->Session->write('university_id', $universitySubject['university_id']);

        $this->__mainUniversity($universitySubject['university_id']);
        if ($this->UniversitySubjects->delete($universitySubject)) {
            $this->Flash->success(__('The University Subject has been deleted.'));
        } else {
            $this->Flash->error(__('The University Subject could not be deleted. Please, try again.'));
        }
        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->UniversitySubjects->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The UniversitySubjects has been deleted.'));
        } else {
            $this->Flash->error(__('The UniversitySubjects could not be deleted. Please, try again.'));
        }
        $this->__redirectToIndex();
    }

    public function view($id = null)
    {
        $universitySubject = $this->UniversitySubjects->get($id);

        $this->Session->write('university_id', $universitySubject['university_id']);

        $this->__mainUniversity($universitySubject['university_id']);
        $this->set('universitySubject', $universitySubject);
    }

    private function __common()
    {
    }
}
