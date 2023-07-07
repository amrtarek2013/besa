<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Courses Controller
 *
 */

class CoursesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $courses = $this->paginate($this->Courses, ['conditions' => $conditions]);
        // debug($courses);
        $parameters = $this->request->getAttribute('params');
        
        $this->set(compact('courses', 'parameters'));

        $this->__common();
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $courses = $this->paginate($this->Courses, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        
        $this->set(compact('courses', 'parameters'));
    }

    public function add()
    {
        $course = $this->Courses->newEmptyEntity();
        if ($this->request->is('post')) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The Course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Course could not be saved. Please, try again.'));
        }
        // $this->_ajaxImageUpload('course_new', 'courses', false, false, ['image', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        
        $this->set(compact('course'));
    }

    public function edit($id = null)
    {
        $course = $this->Courses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());


            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The Course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Course could not be saved. Please, try again.'));
        }

        $this->__common();

        
        $this->set(compact('course', 'id'));
        // $this->_ajaxImageUpload('course_' . $id, 'courses', $id, ['id' => $id], ['image', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $course = $this->Courses->get($id);
        if ($this->Courses->delete($course)) {
            $this->Flash->success(__('The Course has been deleted.'));
        } else {
            $this->Flash->error(__('The Course could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Courses->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Courses has been deleted.'));
        } else {
            $this->Flash->error(__('The Courses could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $course = $this->Courses->get($id);

        $this->set('course', $course);
    }

    private function __common()
    {
        // $uploadSettings = $this->Courses->getUploadSettings();
        // $this->set(compact('uploadSettings'));


        $this->loadModel("Countries");
        $countries = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(["active" => 1])->order(['display_order' => 'ASC'])->toArray();
        $this->set("countries", $countries);


        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('services', $services);

        $this->loadModel("Universities");
        $universities = $this->Universities->find('list', [
            'keyField' => 'id', 'valueField' => 'university_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('universities', $universities);

        $this->loadModel("SubjectAreas");
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['display_order' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);

        $this->set('studyLevels', $this->Courses->studyLevels);
    }
}
