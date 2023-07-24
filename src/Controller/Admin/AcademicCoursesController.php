<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * AcademicCourses Controller
 *
 */

class AcademicCoursesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $courses = $this->paginate($this->AcademicCourses, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->AcademicCourses->types;
        $this->set(compact('courses', 'parameters', 'types'));
        
        $this->__common();
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $courses = $this->paginate($this->AcademicCourses, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->AcademicCourses->types;
        $this->set(compact('courses', 'parameters', 'types'));
    }

    public function add()
    {
        $course = $this->AcademicCourses->newEmptyEntity();
        if ($this->request->is('post')) {
            $course = $this->AcademicCourses->patchEntity($course, $this->request->getData());
            if ($this->AcademicCourses->save($course)) {
                $this->Flash->success(__('The Course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Course could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('course_new', 'courses', false, false, ['image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $types = $this->AcademicCourses->types;
        $this->set(compact('course', 'types'));
    }

    public function edit($id = null)
    {
        $course = $this->AcademicCourses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->AcademicCourses->patchEntity($course, $this->request->getData());


            if ($this->AcademicCourses->save($course)) {
                $this->Flash->success(__('The Course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Course could not be saved. Please, try again.'));
        }

        $this->__common();

        $types = $this->AcademicCourses->types;
        $this->set(compact('course', 'id', 'types'));
        $this->_ajaxImageUpload('course_' . $id, 'courses', $id, ['id' => $id], ['image', 'flag', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $course = $this->AcademicCourses->get($id);
        if ($this->AcademicCourses->delete($course)) {
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
            $this->AcademicCourses->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The AcademicCourses has been deleted.'));
        } else {
            $this->Flash->error(__('The AcademicCourses could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $course = $this->AcademicCourses->get($id);

        $this->set('course', $course);
    }

    private function __common()
    {
        $uploadSettings = $this->AcademicCourses->getUploadSettings();
        $this->set(compact('uploadSettings'));


        $this->loadModel("Countries");
        $countries = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(["active" => 1, 'is_destination'=>1])->order(['display_order' => 'ASC'])->toArray();
        $this->set("countries", $countries);
    }
}
