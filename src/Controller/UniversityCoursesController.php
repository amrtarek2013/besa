<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class UniversityCoursesController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout pageServices');


        // $conditions['UniversityCourses.active'] = 1;
        $conditions = [];

        $courses = $this->UniversityCourses->find()->contain(['Majors' => ['fields' => ['title']], 'Courses' => ['fields' => ['course_name']], 'Countries' => ['fields' => ['country_name']], 'Universities' => ['fields' => ['university_name', 'rank']], 'Services' => ['fields' => ['title']], 'SubjectAreas' => ['fields' => ['title']]])->where($conditions)->order(['UniversityCourses.display_order' => 'asc'])->limit(10)->all();

        $this->set('courses', $courses->toArray());


        $this->set('wishLists', $this->getWishLists());

        $this->set('appCourses', $this->getAppCourses());

        // $this->loadModel('Majors');
        $this->set('wishLists', $this->getWishLists());

        // $courseMajors = $this->Majors->find('list')->where(['active' => 1])->order(['display_order' => 'asc']);

        // $this->set('courseMajors', $courseMajors);
        // $this->loadModel('Countries');
        // $countriesList = $this->Countries->find('list', [
        //     'keyField' => 'id', 'valueField' => 'country_name'
        // ])->where(['active' => 1])->order(['display_order' => 'asc']);

        // $this->set('countriesList', $countriesList);
    }

    public function study()
    {
        $this->set('bodyClass', 'pageAbout pageServices');
        $universityCourses = $this->UniversityCourses->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();
        $this->set('universityCourses', $universityCourses);


        $this->loadModel('Courses');
        $studyCourses = $this->Courses->find(
            'list',
            [
                'keyField' => 'id', 'valueField' => 'course_name'
            ]
        )
            // ->where(['active' => 1])
            ->order(['display_order' => 'asc']);
        $this->set('studyCourses', $studyCourses);


        $this->loadModel('Majors');
        $courseMajors = $this->Majors->find('list')->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('courseMajors', $courseMajors);


        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('countriesList', $countriesList);


        $this->loadModel('Services');
        $servicesSearchList = $this->Services->find('all')->where(['active' => 1, 'show_in_search' => 1])
            ->order([/*'display_order' => 'asc',*/'search_degree_options' => 'ASC'])->all()->toArray();
        // debug($servicesSearchList);
        $this->set('servicesSearchList', $servicesSearchList);
        $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);
        $this->set('studyLevels', $this->UniversityCourses->studyLevels);
        if(!empty($_GET['steps'])){
           $this->render('study2'); 
        }
    }


    public function results()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $conditions = $this->__prepConditions();
        // $conditions['UniversityCourses.active'] = 1;

        $courses = $this->UniversityCourses->find()->contain(['Courses' => ['fields' => ['course_name']], 'Countries' => ['fields' => ['country_name']], 'Universities' => ['fields' => ['university_name', 'rank']], 'Services' => ['fields' => ['title']], 'SubjectAreas' => ['fields' => ['title']]])->where($conditions)->order(['UniversityCourses.display_order' => 'asc'])->limit(10)->all();

        $this->set('courses', $courses->toArray());


        $this->set('wishLists', $this->getWishLists());
        $this->set('appCourses', $this->getAppCourses());
        // $this->loadModel('Majors');
        // $courseMajors = $this->Majors->find('list')->where(['active' => 1])->order(['display_order' => 'asc']);

        // $this->set('courseMajors', $courseMajors);
        // $this->loadModel('Countries');
        // $countriesList = $this->Countries->find('list', [
        //     'keyField' => 'id', 'valueField' => 'country_name'
        // ])->where(['active' => 1])->order(['display_order' => 'asc']);

        // $this->set('countriesList', $countriesList);
    }

    private function __prepConditions()
    {

        $conditions = [];
        $url_params = $this->request->getQuery();
        // print_r($url_params);
        // debug($url_params);
        unset($url_params['url'], $url_params['page'], $url_params['sort'], $url_params['direction']);


        if (isset($url_params['service_id']))
            $conditions['UniversityCourses.service_id'] = $url_params['service_id'];
        else
            unset($url_params['service_id']);
        if (isset($url_params['course_id']))
            $conditions['UniversityCourses.course_id'] = $url_params['course_id'];
        else
            unset($url_params['service_id']);

        if (isset($url_params['min_budget']))
            $conditions['UniversityCourses.fees >='] = $url_params['min_budget'];
        if (isset($url_params['max_budget']))
            $conditions['UniversityCourses.fees <='] = $url_params['max_budget'];

        if (isset($url_params['degree'])) {

            if ($url_params['degree'] == 2) {
                if (isset($url_params['study_level_id']))
                    $conditions['UniversityCourses.study_level_id'] = $url_params['study_level_id'];
                // if (isset($url_params['subject_area_id']))
                //     $conditions['UniversityCourses.subject_area_id'] = $url_params['subject_area_id'];
            } else {
                if (isset($url_params['major_id']))
                    $conditions['UniversityCourses.major_id'] = $url_params['major_id'];
                if (isset($url_params['country_id'])){
                    if(is_array($url_params['country_id'])){
                        $conditions['UniversityCourses.country_id in'] = $url_params['country_id'];
                    }else{
                        $conditions['UniversityCourses.country_id'] = $url_params['country_id'];
                    }
                }
            }
        }

        // print_r($conditions);
        return $conditions;
    }

    public function details($id = null)
    {
        $course = $this->UniversityCourses->find()
            ->contain(['Courses' => ['fields' => ['course_name']], 'Countries' => ['fields' => ['country_name']], 'Universities' => ['fields' => ['university_name', 'rank']], 'Services' => ['fields' => ['title']], 'SubjectAreas' => ['fields' => ['title']]])
            // ->where(['UniversityCourses.active' => 1])
            ->order(['UniversityCourses.display_order' => 'asc'])->first();

        // debug($course);
        $this->set('bodyClass', 'pageAbout pageServices');

        if (empty($course))

            throw new NotFoundException(__('Not found'));

        // print_r($course);
        $this->set('course', $course);
        $this->set('permalink', $id);
    }
}
