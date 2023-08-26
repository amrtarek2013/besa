<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;

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
            // 'study_level' => 'Study Level',
            'subject_area' => 'Subject Area',
            'university' => 'University',
            'country' => 'Destination',
            'total_fees' => 'Total Tuition Fees (GBP)',
            'fees' => 'Tution Fees Per Year (GBP)',
            'duration' => 'Duration (Years)',
            'intake' => 'Intake',
            // 'destination' => 'Destination',
            // 'rank' => 'Rank',
            // 'description' => 'Description'
        );

        foreach ($universityCourses as $universityCourse) {
            $dataToExport[] = [
                $universityCourse->id,
                $universityCourse->course_name,
                // $universityCourse->study_level->title,
                $universityCourse->subject_area->title,
                $universityCourse->university->university_name,
                $universityCourse->country->country_name,
                number_format(floatval($universityCourse->total_fees),2),
                number_format(floatval($universityCourse->fees),2),
                $universityCourse->duration,
                $universityCourse->intake,
                // $universityCourse->destination,
                // $universityCourse->rank,
                // $universityCourse->description,
                // '',
                // ($universityCourse->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'universityCourses-list-' . date('Ymd'));

        exit();
    }
    // public function import()
    // {

    //     $universityCourse = $this->UniversityCourses->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $data = $this->request->getData();


    //         // Configure::write('debug', true);
    //         // Configure::write('debug', 1);
    //         // var_dump($data['file']);
    //         // dd('DD');
    //         $error = $data['file']->getError();

    //         if ($data['file']->getError() == UPLOAD_ERR_OK) {

    //             //load all countries

    //             $this->loadModel("Countries");
    //             $countries = $this->Countries->find('list', [
    //                 'keyField' => 'code', 'valueField' => 'id'
    //             ])->toArray();
    //             $countriesTitles = $this->Countries->find('list', [
    //                 'keyField' => 'university_name', 'valueField' => 'id'
    //             ])->toArray();


    //             // dd($countries);
    //             $this->loadComponent('Csv');
    //             // dd($data['file']);
    //             $universitiesArray = $this->Csv->convertCsvToArray($data['file'], $this->UniversityCourses->schema_of_import);
    //             // dd($universitiesArray);
    //             $universityCourseList = [];
    //             $counter = 0;
    //             foreach ($universitiesArray as $universityCourseLine) {

    //                 $universityCourse = $this->UniversityCourses->newEmptyEntity();
    //                 if (isset($universityCourseLine['id']) && empty($universityCourseLine['id'])) {
    //                     unset($universityCourseLine['id']);
    //                 } else if (isset($universityCourseLine['id'])  && !empty($universityCourseLine['id'])) {
    //                     $universityCourse = $this->UniversityCourses->get($universityCourseLine['id']);
    //                 }

    //                 if (isset($universityCourseLine['active']))
    //                     $universityCourseLine['active'] = (strtolower($universityCourseLine['active']) == 'yes') ? 1 : 0;
    //                 $universityCourseLine['logo'] = trim($universityCourseLine['university_name']) . '.png';
    //                 $universityCourseLine['title'] = $universityCourseLine['university_name'];

    //                 if (isset($universityCourseLine['destination']))
    //                     $universityCourseLine['country_name'] = trim($universityCourseLine['destination']);

    //                 if (isset($countries[trim($universityCourseLine['destination'])]))
    //                     $universityCourseLine['country_id'] = $countries[trim($universityCourseLine['destination'])];
    //                 else if (isset($countriesTitles[trim($universityCourseLine['destination'])]))
    //                     $universityCourseLine['country_id'] = $countriesTitles[trim($universityCourseLine['destination'])];
    //                 $universityCourse = $this->UniversityCourses->patchEntity($universityCourse, $universityCourseLine);

    //                 $universityCourseList[] = $universityCourse;
    //                 $counter++;
    //                 if ($counter == 50) {
    //                     // dd($universityCourseList);
    //                     $this->UniversityCourses->saveMany($universityCourseList);
    //                     $universityCourseList = [];
    //                     $counter = 0;
    //                 }
    //             }

    //             if ($counter > 0) {

    //                 // dd($universityCourseList);
    //                 $this->UniversityCourses->saveMany($universityCourseList);
    //                 $universityCourseList = [];
    //                 $counter = 0;
    //             }
    //         }

    //         $this->Flash->success(__('The UniversityCourses has been imported.'));
    //         return $this->redirect(['action' => 'import']);
    //     }

    //     $this->set(compact('universityCourse'));
    // }
}
