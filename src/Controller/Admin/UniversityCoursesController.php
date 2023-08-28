<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Utility\Hash;

/**
 * UniversityCourses Controller
 *
 */

class UniversityCoursesController extends AppController
{

    public function index()
    {
        // Configure::write('debug', 0);
        $conditions = $this->_filter_params();
        // dd($conditions);
        $universityCourses = $this->paginate($this->UniversityCourses, ['conditions' => $conditions, 'contain' => ['Courses', 'Universities', 'StudyLevels', 'SubjectAreas', 'Countries'], 'limit' => 20, 'order' => ['course_name' => 'ASC']]);
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
        ])->where(["active" => 1, 'is_destination' => 1])->order(['country_name' => 'ASC'])->toArray();
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




    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $universityCourses = $this->UniversityCourses->find()->contain(['Universities', 'StudyLevels', 'SubjectAreas', 'Countries'])->where($conditions)->all()->toArray();

        $dataToExport[] = array(
            'id' => 'Course ID',
            'course_name' => 'Course Name',

            'study_level_id' => 'Study Level ID',
            'study_level' => 'Study Level',

            'subject_area_id' => 'Subject Area ID',
            'subject_area' => 'Subject Area',

            'university_id' => 'University ID',
            'university' => 'University',

            'country_id' => 'Destination ID',
            'country' => 'Destination',

            'total_fees' => 'Total Tuition Fees (GBP)',
            'fees' => 'Tution Fees Per Year (GBP)',
            'duration' => 'Duration (Years)',
            'intake' => 'Intake',

            'description' => 'Description'

        );

        foreach ($universityCourses as $universityCourse) {
            $dataToExport[] = [
                $universityCourse->id,
                $universityCourse->course_name,

                $universityCourse->study_level_id,
                $universityCourse->study_level->title,

                $universityCourse->subject_area_id,
                $universityCourse->subject_area->title,

                $universityCourse->university_id,
                $universityCourse->university->university_name,

                $universityCourse->country_id,
                $universityCourse->country->country_name,

                number_format(floatval($universityCourse->total_fees), 2),
                number_format(floatval($universityCourse->fees), 2),
                $universityCourse->duration,
                $universityCourse->intake,

                $universityCourse->description

                // ($universityCourse->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'universityCourses-list-' . date('Ymd'));

        exit();
    }
    public function import1()
    {

        $universityCourse = $this->UniversityCourses->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();


            var_dump($data['file']);
            
            var_dump($data['file']['error']);
            
            die('DD');
            $error = $data['file']->getError();

            if ($data['file']->getError() == UPLOAD_ERR_OK) {

                //load all countries

                $this->loadModel("Countries");
                // $countries = $this->Countries->find('list', [
                //     'keyField' => 'country_name', 'valueField' => 'id'
                // ])->toArray();
                $countries = $this->Countries->find()->select(['title' => 'trim(lower(country_name))', 'id'])->toArray();
                $countries = Hash::combine($countries, '{n}.title', '{n}.id');
                // $countriesTitles = $this->Countries->find('list', [
                //     'keyField' => 'university_name', 'valueField' => 'id'
                // ])->toArray();

                $this->loadModel("Universities");
                $universities = $this->Universities->find()->select(['title' => 'trim(lower(university_name))', 'id'])->toArray();
                $universities = Hash::combine($universities, '{n}.title', '{n}.id');
                $this->loadModel("SubjectAreas");
                $subjectAreas = $this->SubjectAreas->find()->select(['title' => 'trim(lower(title))', 'id'])->toArray();
                $subjectAreas = Hash::combine($subjectAreas, '{n}.title', '{n}.id');
                $this->loadModel("StudyLevels");
                $studyLevels = $this->StudyLevels->find()->select(['title' => 'trim(lower(title))', 'id'])->toArray();
                $studyLevels = Hash::combine($studyLevels, '{n}.title', '{n}.id');

                $this->loadComponent('Csv');
                // dd($data['file']);
                $universitiesArray = $this->Csv->convertCsvToArray($data['file'], $this->UniversityCourses->schema_of_import);
                // dd($universitiesArray);
                $universityCourseList = [];
                $counter = 0;
                // dd($universitiesArray);
                foreach ($universitiesArray as $universityCourseLine) {

                    $universityCourse = $this->UniversityCourses->newEmptyEntity();

                    if (isset($universityCourseLine['id']) && empty($universityCourseLine['id'])) {
                        unset($universityCourseLine['id']);
                    } else if (isset($universityCourseLine['id'])  && !empty($universityCourseLine['id'])) {
                        $universityCourse = $this->UniversityCourses->get($universityCourseLine['id']);
                    }

                    if (isset($universityCourseLine['active']))
                        $universityCourseLine['active'] = (strtolower($universityCourseLine['active']) == 'yes') ? 1 : 0;

                    if (empty($universityCourseLine['country_id']) && isset($countries[strtolower(trim($universityCourseLine['destination']))]))
                        $universityCourseLine['country_id'] = $countries[strtolower(trim($universityCourseLine['destination']))];

                    if (empty($universityCourseLine['university_id']) && isset($countries[strtolower(trim($universityCourseLine['university']))]))
                        $universityCourseLine['university_id'] = $universities[strtolower(trim($universityCourseLine['university']))];

                    if (empty($universityCourseLine['subject_area_id']) && isset($subjectAreas[strtolower(trim($universityCourseLine['subject_area']))]))
                        $universityCourseLine['subject_area_id'] = $subjectAreas[strtolower(trim($universityCourseLine['subject_area']))];

                    if (empty($universityCourseLine['study_level_id']) && isset($studyLevels[strtolower(trim($universityCourseLine['study_level']))]))
                        $universityCourseLine['study_level_id'] = $studyLevels[strtolower(trim($universityCourseLine['study_level']))];

                    $universityCourseLine['total_fees'] = !empty($universityCourseLine['total_fees']) ? floatval(str_replace(',', '', $universityCourseLine['total_fees'])) : 0.00;
                    $universityCourseLine['fees'] = !empty($universityCourseLine['fees']) ? floatval(str_replace(',', '', $universityCourseLine['fees'])) : 0.00;
                    $universityCourse = $this->UniversityCourses->patchEntity($universityCourse, $universityCourseLine, ['validate'=>false]);

                    $universityCourseList[] = $universityCourse;
                    $counter++;
                    if ($counter == 50) {
                        // dd($universityCourseList);
                        $this->UniversityCourses->saveMany($universityCourseList);
                        $universityCourseList = [];
                        $counter = 0;
                    }
                }

                if ($counter > 0) {

                    // dd($universityCourseList);
                    $this->UniversityCourses->saveMany($universityCourseList);
                }

                // dd($universityCourseList);
                $this->Flash->success(__('The University Courses has been imported...'));
            } else {

                $this->Flash->success(__('Sorry, the University Courses couldn\'t been imported.'));
                dd($error);
            }

            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('universityCourse'));
    }
    public function import()
    {

        $universityCourse = $this->UniversityCourses->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();


            // $error = $data['file']->getError();

            if ($data['file']['error'] == UPLOAD_ERR_OK) {

                //load all countries

                $this->loadModel("Countries");
                // $countries = $this->Countries->find('list', [
                //     'keyField' => 'country_name', 'valueField' => 'id'
                // ])->toArray();
                $countries = $this->Countries->find()->select(['title' => 'trim(lower(country_name))', 'id'])->toArray();
                $countries = Hash::combine($countries, '{n}.title', '{n}.id');
                // $countriesTitles = $this->Countries->find('list', [
                //     'keyField' => 'university_name', 'valueField' => 'id'
                // ])->toArray();

                $this->loadModel("Universities");
                $universities = $this->Universities->find()->select(['title' => 'trim(lower(university_name))', 'id'])->toArray();
                $universities = Hash::combine($universities, '{n}.title', '{n}.id');
                $this->loadModel("SubjectAreas");
                $subjectAreas = $this->SubjectAreas->find()->select(['title' => 'trim(lower(title))', 'id'])->toArray();
                $subjectAreas = Hash::combine($subjectAreas, '{n}.title', '{n}.id');
                $this->loadModel("StudyLevels");
                $studyLevels = $this->StudyLevels->find()->select(['title' => 'trim(lower(title))', 'id'])->toArray();
                $studyLevels = Hash::combine($studyLevels, '{n}.title', '{n}.id');

                $this->loadComponent('Csv');
                // dd($data['file']);
                
                $universitiesArray = $this->Csv->convertCsvToArrayNew($data['file'], $this->UniversityCourses->schema_of_import);
                // die('ssssssss');
                // dd($universitiesArray);
                $universityCourseList = [];
                $counter = 0;
                // dd($universitiesArray);
                foreach ($universitiesArray as $universityCourseLine) {

                    $universityCourse = $this->UniversityCourses->newEmptyEntity();

                    if (isset($universityCourseLine['id']) && empty($universityCourseLine['id'])) {
                        unset($universityCourseLine['id']);
                    } else if (isset($universityCourseLine['id'])  && !empty($universityCourseLine['id'])) {
                        $universityCourse = $this->UniversityCourses->get($universityCourseLine['id']);
                    }

                    if (isset($universityCourseLine['active']))
                        $universityCourseLine['active'] = (strtolower($universityCourseLine['active']) == 'yes') ? 1 : 0;

                    if (empty($universityCourseLine['country_id']) && isset($countries[strtolower(trim($universityCourseLine['destination']))]))
                        $universityCourseLine['country_id'] = $countries[strtolower(trim($universityCourseLine['destination']))];

                    if (empty($universityCourseLine['university_id']) && isset($countries[strtolower(trim($universityCourseLine['university']))]))
                        $universityCourseLine['university_id'] = $universities[strtolower(trim($universityCourseLine['university']))];

                    if (empty($universityCourseLine['subject_area_id']) && isset($subjectAreas[strtolower(trim($universityCourseLine['subject_area']))]))
                        $universityCourseLine['subject_area_id'] = $subjectAreas[strtolower(trim($universityCourseLine['subject_area']))];

                    if (empty($universityCourseLine['study_level_id']) && isset($studyLevels[strtolower(trim($universityCourseLine['study_level']))]))
                        $universityCourseLine['study_level_id'] = $studyLevels[strtolower(trim($universityCourseLine['study_level']))];

                    $universityCourseLine['total_fees'] = !empty($universityCourseLine['total_fees']) ? floatval(str_replace(',', '', $universityCourseLine['total_fees'])) : 0.00;
                    $universityCourseLine['fees'] = !empty($universityCourseLine['fees']) ? floatval(str_replace(',', '', $universityCourseLine['fees'])) : 0.00;
                    $universityCourse = $this->UniversityCourses->patchEntity($universityCourse, $universityCourseLine, ['validate'=>false]);

                    $universityCourseList[] = $universityCourse;
                    $counter++;
                    if ($counter == 50) {
                        // dd($universityCourseList);
                        $this->UniversityCourses->saveMany($universityCourseList);
                        $universityCourseList = [];
                        $counter = 0;
                    }
                }

                if ($counter > 0) {

                    // dd($universityCourseList);
                    $this->UniversityCourses->saveMany($universityCourseList);
                }

                // dd($universityCourseList);
                $this->Flash->success(__('The University Courses has been imported...'));
            } else {

                $this->Flash->success(__('Sorry, the University Courses couldn\'t been imported.'));
                // dd($error);
            }

            return $this->redirect(['action' => 'import']);
        }

        $this->set(compact('universityCourse'));
    }
}
