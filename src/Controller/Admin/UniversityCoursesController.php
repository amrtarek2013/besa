<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * UniversityCourses Controller
 *
 */

class UniversityCoursesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();
        $universityCourses = $this->paginate($this->UniversityCourses, ['conditions' => $conditions, 'contain' => ['Courses', 'Universities', 'StudyLevels', 'Services', 'Countries'], 'order' => ['course_name' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('universityCourses', 'parameters'));

        $this->__common();
    }

    public function list()
    {
        $conditions = $this->_filter_params();
        $universityCourses = $this->paginate($this->UniversityCourses, ['conditions' => $conditions, 'order' => ['course_name' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('universityCourses', 'parameters'));
    }

    public function add()
    {
        $universityCourse = $this->UniversityCourses->newEmptyEntity();
        if ($this->request->is('post')) {
            $universityCourse = $this->UniversityCourses->patchEntity($universityCourse, $this->request->getData());
            if ($this->UniversityCourses->save($universityCourse)) {
                $this->Flash->success(__('The University Course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The University Course could not be saved. Please, try again.'));
        }
        // $this->_ajaxImageUpload('course_new', 'universityCourses', false, false, ['image', 'banner_image']);
        $this->set('id', false);

        $this->__common();

        $this->set(compact('universityCourse'));
    }

    public function edit($id = null)
    {
        $universityCourse = $this->UniversityCourses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $universityCourse = $this->UniversityCourses->patchEntity($universityCourse, $this->request->getData());


            if ($this->UniversityCourses->save($universityCourse)) {
                $this->Flash->success(__('The University Course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The University Course could not be saved. Please, try again.'));
        }

        $this->__common();


        $this->set(compact('universityCourse', 'id'));
        // $this->_ajaxImageUpload('course_' . $id, 'universityCourses', $id, ['id' => $id], ['image', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $universityCourse = $this->UniversityCourses->get($id);
        if ($this->UniversityCourses->delete($universityCourse)) {
            $this->Flash->success(__('The University Course has been deleted.'));
        } else {
            $this->Flash->error(__('The University Course could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->UniversityCourses->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The UniversityCourses has been deleted.'));
        } else {
            $this->Flash->error(__('The UniversityCourses could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $universityCourse = $this->UniversityCourses->get($id);

        $this->set('universityCourse', $universityCourse);
    }

    private function __common()
    {
        // $uploadSettings = $this->UniversityCourses->getUploadSettings();
        // $this->set(compact('uploadSettings'));


        $this->loadModel("Courses");
        $courses = $this->Courses->find('list', [
            'keyField' => 'id', 'valueField' => 'course_name'
        ])->where(["active" => 1])->order(['course_name' => 'ASC'])->toArray();
        $this->set("courses", $courses);

        $this->loadModel("Countries");
        $countries = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(["active" => 1, 'is_destination'=>1])->order(['country_name' => 'ASC'])->toArray();
        $this->set("countries", $countries);


        $this->loadModel("Services");
        $services = $this->Services->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('services', $services);

        $this->loadModel("StudyLevels");
        $studyLevels = $this->StudyLevels->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('studyLevels', $studyLevels);

        $this->loadModel("Universities");
        $universities = $this->Universities->find('list', [
            'keyField' => 'id', 'valueField' => 'university_name'
        ])->where(['active' => 1])->order(['university_name' => 'asc'])->toArray();
        $this->set('universities', $universities);

        $this->loadModel("SubjectAreas");
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);

        $this->loadModel("Majors");
        $majors = $this->Majors->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('majors', $majors);
    }
}
