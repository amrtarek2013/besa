<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;

class UniversityCoursesController extends AppController
{

    public function index($country = null, $perm = null, $type = 1)
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $conditions = $this->__prepConditions();

        if (!$this->Session->check('Auth.User'))
            $this->Session->write('search_url', $_SERVER["REQUEST_URI"]);

        $conditions['UniversityCourses.active'] = 1;


        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);



        // $this->loadModel('Services');
        // $servicesSearchList = $this->Services->find('all')->where(['active' => 1, 'show_in_search' => 1])
        //     ->order([/*'display_order' => 'asc',*/'search_degree_options' => 'ASC'])->all()->toArray();
        // // debug($servicesSearchList);
        // $this->set('servicesSearchList', $servicesSearchList);
        // $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);

        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('studyLevels', $studyLevels);
        // dd($studyLevels);


        $this->loadModel("SubjectAreas");
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);


        $url_params = $this->request->getQuery();
        // print_r($url_params);
        // debug($url_params);
        unset($url_params['url'], $url_params['page'], $url_params['sort'], $url_params['direction']);

        // $conditions = $this->_filter_params();
        if (isset($country) && $type == 1) {

            // $c_id = explode('-', $country);
            // if (isset($c_id[0]) && is_numeric($c_id[0]))
            $conditions['UniversityCourses.country_id'] = $country;
            $url_params['country_id'] = $country;
        } else if ($type == 2) {

            $conditions['UniversityCourses.university_id'] = $country;
            $url_params['university_id'] = $country;
        }


        $this->loadModel('Universities');
        $universitiesList = $this->Universities->find()->select(['id', 'university_name', 'country_id'])
            ->where(['active' => 1])->order(['university_name' => 'asc']);

        $allUniversities = Hash::combine($universitiesList->toArray(), '{n}.id', '{n}.university_name');
        $this->set('allUniversities', $allUniversities);

        $universitiesList = Hash::combine($universitiesList->toArray(), '{n}.id', '{n}.university_name', '{n}.country_id');
        $this->set('universitiesList', $universitiesList);
        $this->set('filterParams', $url_params);

        // $courses = $this->UniversityCourses->find()->contain([
        //     'Majors' => ['fields' => ['title']], 'Courses' => ['fields' => ['course_name']],
        //     'Countries' => ['fields' => ['country_name','use_country_currency', 'currency']],
        //     'Universities' => ['fields' => ['university_name', 'rank']],
        //     'Services' => ['fields' => ['title']], 'StudyLevels' => ['fields' => ['title']], 'SubjectAreas' => ['fields' => ['title']]
        // ])->where($conditions)->order(['UniversityCourses.display_order' => 'asc'])->limit(10)->all();


        $courses = $this->paginate($this->UniversityCourses, [
            'contain' => [
                'Courses' => ['fields' => ['course_name']],
                'Countries' => ['fields' => ['country_name', 'use_country_currency', 'currency']],
                'Universities' => ['fields' => ['university_name', 'rank']],
                'StudyLevels' => ['fields' => ['title']],
                'SubjectAreas' => ['fields' => ['title']]
            ],
            'conditions' => $conditions, 'order' => ['course_name' => 'ASC'], 'limit' => 20
        ]);

        // $courses = $this->paginate($this->UniversityCourses, [
        //     'contain' => [
        //         // 'Majors' => ['fields' => ['title']],
        //         // 'Courses' => ['fields' => ['course_name']],
        //         'Countries' => ['fields' => ['country_name', 'use_country_currency', 'currency']],
        //         'Universities' => ['fields' => ['university_name', 'rank']],
        //         // 'Services' => ['fields' => ['title']], 
        //         'StudyLevels' => ['fields' => ['title']],
        //         'SubjectAreas' => ['fields' => ['title']]
        //     ],
        //     'conditions' => $conditions, 'order' => ['course_name' => 'ASC'], 'limit' => 20
        // ]);

        $coursesDetails = Hash::combine($courses->toArray(), '{n}.id', '{n}');
        $this->set('courses', $courses->toArray());

        $this->set('coursesDetails', $coursesDetails);
        $this->set('appCourses', $this->getAppCourses());
        $this->set('wishLists', $this->getWishLists());
    }

    public function study()
    {
        $this->set('bodyClass', 'pageAbout pageServices');
        // $universityCourses = $this->UniversityCourses->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();
        // $this->set('universityCourses', $universityCourses);


        $this->loadModel('Courses');
        // $studyCourses = $this->Courses->find(
        //     'list',
        //     ['keyField' => 'id', 'valueField' => 'course_name']
        // )
        //     // ->where(['active' => 1])
        //     ->order(['course_name' => 'asc']);


        // $studyCourses = $this->Courses->find()->where(['active' => 1])->all()->toArray();
        // $this->set('studyCourses', $studyCourses);
        // dd($studyCourses);

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);


        // $this->loadModel('Services');
        // $servicesSearchList = $this->Services->find('all')->where(['active' => 1, 'show_in_search' => 1])
        //     ->order([/*'display_order' => 'asc',*/'search_degree_options' => 'ASC'])->all()->toArray();
        // // debug($servicesSearchList);
        // $this->set('servicesSearchList', $servicesSearchList);
        // $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);

        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('all')->where(['active' => 1])
            ->order(['title' => 'asc'])->all()->toArray();
        $this->set('studyLevels', $studyLevels);
        // dd($studyLevels);


        $this->loadModel("SubjectAreas");
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);

        // if (!empty($_GET['steps'])) {
        $this->render('study2');
        // }
    }


    public function results()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $conditions = $this->__prepConditions();


        $parameters = $this->request->getAttribute('params');
        $this->set('parameters', $parameters);

        // $conditions['UniversityCourses.active'] = 1;
        // debug($_SERVER['REQUEST_URI']);
        // $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .  $_SERVER['HTTP_HOST'];
        // $url = $base_url . $_SERVER["REQUEST_URI"];
        // debug($url);
        if (!$this->Session->check('Auth.User'))
            $this->Session->write('search_url', $_SERVER["REQUEST_URI"]);
        // $courses = $this->UniversityCourses->find()->contain([
        //     'Courses' => ['fields' => ['course_name']], 'Countries' => ['fields' => ['country_name','use_country_currency', 'currency']], 'Universities' => ['fields' => ['university_name', 'rank']], 'Services' => ['fields' => ['title']], 'StudyLevels' => ['fields' => ['title']], 'SubjectAreas' => ['fields' => ['title']]
        // ])->where($conditions)->order(['UniversityCourses.display_order' => 'asc'])->limit(10)->all()->->toArray();

        // $conditions = $this->_filter_params();
        $conditions['UniversityCourses.active'] = 1;
        // if (isset($country)) {

        //     // $c_id = explode('-', $country);
        //     // if (isset($c_id[0]) && is_numeric($c_id[0]))
        //     $conditions['UniversityCourses.country_id'] = $country;
        // }



        $this->loadModel('Universities');
        $universitiesList = $this->Universities->find()->select(['id', 'university_name', 'country_id'])
            ->where(['active' => 1])->order(['university_name' => 'asc']);

        $allUniversities = Hash::combine($universitiesList->toArray(), '{n}.id', '{n}.university_name');
        $this->set('allUniversities', $allUniversities);

        $limit = 6;
        $distinct = 'id';
        if (isset($parameters['?']['stype']) && $parameters['?']['stype'] != 'a') {
            $limit = 18;
            $this->set('stype', $parameters['?']['stype']);
            if ($parameters['?']['stype'] == 'u') {
                $distinct = 'university_id';
                unset($conditions['university_id']);
            }
        } else
            $this->set('stype', 'a');

        $courses = $this->paginate($this->UniversityCourses, [
            'contain' => [
                'Courses' => ['fields' => ['course_name']],
                'Countries' => ['fields' => ['country_name', 'use_country_currency', 'currency', 'code']],
                'Universities' => ['fields' => ['id', 'university_name', 'rank', 'permalink', 'country_id']],
                'Services' => ['fields' => ['title']],
                'StudyLevels' => ['fields' => ['title']],
                'SubjectAreas' => ['fields' => ['title']]
            ],
            'distinct' => $distinct,
            'conditions' => $conditions, 'order' => ['course_name' => 'ASC'], 'limit' => $limit
        ]);

        
        $coursesCount = $this->UniversityCourses->find()->contain([
            'Courses' => ['fields' => ['course_name']],
            'Countries' => ['fields' => ['country_name', 'use_country_currency', 'currency', 'code']],
            'Universities' => ['fields' => ['id', 'university_name', 'rank', 'permalink', 'country_id']],
            'Services' => ['fields' => ['title']],
            'StudyLevels' => ['fields' => ['title']],
            'SubjectAreas' => ['fields' => ['title']]
        ])->distinct(['UniversityCourses.id'])->where($conditions)->count();

        $uniCount = $this->UniversityCourses->find()->contain([
            'Courses' => ['fields' => ['course_name']],
            'Countries' => ['fields' => ['country_name', 'use_country_currency', 'currency', 'code']],
            'Universities' => ['fields' => ['id', 'university_name', 'rank', 'permalink', 'country_id']],
            'Services' => ['fields' => ['title']],
            'StudyLevels' => ['fields' => ['title']],
            'SubjectAreas' => ['fields' => ['title']]
        ])->distinct(['UniversityCourses.university_id'])->where($conditions)->count();

        // dd($uniCount);
        // dd($courses->toArray());
        $this->set('totalCount', $uniCount + $coursesCount);//$courses->count());
        $this->set('coursesCount', $coursesCount);//$courses->count());
        $this->set('uniCount', $uniCount);
        $universitiesResults = Hash::combine($courses->toArray(), '{n}.university.permalink', '{n}.university');

        // dd($universitiesResults);
        $this->set('universitiesResults', $universitiesResults);
        $coursesDetails = Hash::combine($courses->toArray(), '{n}.id', '{n}');
        $this->set('courses', $courses->toArray());


        // debug($coursesDetails);
        // debug($courses);
        $this->set('coursesDetails', $coursesDetails);
        $this->set('wishLists', $this->getWishLists());
        $this->set('uniWishLists', $this->getUniWishLists());
        $this->set('appCourses', $this->getAppCourses());



        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->order(['country_name' => 'asc']);
        $this->set('countriesList', $countriesList);


        // $this->loadModel('Services');
        // $servicesSearchList = $this->Services->find('all')->where(['active' => 1, 'show_in_search' => 1])
        //     ->order([/*'display_order' => 'asc',*/'search_degree_options' => 'ASC'])->all()->toArray();
        // // debug($servicesSearchList);
        // $this->set('servicesSearchList', $servicesSearchList);
        // $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);

        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('studyLevels', $studyLevels);
        // dd($studyLevels);


        $this->loadModel("SubjectAreas");
        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('subjectAreas', $subjectAreas);
    }

    private function __prepConditions()
    {

        $conditions = [];
        $url_params = $this->request->getQuery();
        // print_r($url_params);
        // debug($url_params);
        unset($url_params['url'], $url_params['page'], $url_params['sort'], $url_params['direction']);

        $this->set('filterParams', $url_params);

        if (isset($url_params['service_id']) && !empty($url_params['service_id']))
            $conditions['UniversityCourses.service_id'] = $url_params['service_id'];
        else
            unset($url_params['service_id']);

        if (isset($url_params['course_id']) && !empty($url_params['course_id']))
            $conditions['UniversityCourses.course_id'] = $url_params['course_id'];
        else
            unset($url_params['course_id']);

        if (isset($url_params['id']) && !empty($url_params['id']))
            $conditions['UniversityCourses.id'] = $url_params['id'];
        else
            unset($url_params['id']);

        if (isset($url_params['university_id']) && !empty($url_params['university_id']))
            $conditions['UniversityCourses.university_id'] = $url_params['university_id'];
        else
            unset($url_params['university_id']);

        if (isset($url_params['intake']) && !empty($url_params['intake']))
            $conditions['UniversityCourses.intake'] = $url_params['intake'];
        else
            unset($url_params['intake']);

        if (isset($url_params['rank']) && !empty($url_params['rank']))
            $conditions['Universities.rank'] = $url_params['rank'];
        else
            unset($url_params['rank']);


        if (isset($url_params['duration']) && !empty($url_params['duration'])) {
            if (intval($url_params['duration']) == 1) {

                $conditions['UniversityCourses.duration <'] = 12;
                $conditions['UniversityCourses.duration_type'] = 1;
            } else {
                $conditions['UniversityCourses.duration_type'] = 0;
                if (intval($url_params['duration']) == 6) {

                    $conditions['UniversityCourses.duration >'] = intval($url_params['duration']) - 1;
                } else {
                    $conditions[] = 'UniversityCourses.duration between ' . (intval($url_params['duration']) - 1) . ' AND ' . intval($url_params['duration']);
                }
            }
        } else
            unset($url_params['duration']);

        if (isset($url_params['min_budget']) && !empty($url_params['min_budget']))
            $conditions['UniversityCourses.fees >='] = $url_params['min_budget'];
        if (isset($url_params['max_budget']) && !empty($url_params['max_budget']))
            $conditions['UniversityCourses.fees <='] = $url_params['max_budget'];


        if (isset($url_params['study_level_id']) && !empty($url_params['study_level_id'])) {
            $conditions[] = ["(Courses.study_level_id = {$url_params['study_level_id']} OR UniversityCourses.study_level_id = {$url_params['study_level_id']})"];
        }
        if (isset($url_params['subject_area_id']) && !empty($url_params['subject_area_id'])) {
            // $conditions['Courses.subject_area_id'] = $url_params['subject_area_id'];
            $conditions[] = ["(Courses.subject_area_id = {$url_params['subject_area_id']} OR UniversityCourses.subject_area_id = {$url_params['subject_area_id']})"];
        }

        if (isset($url_params['country_id']) && !empty($url_params['country_id']))
            if (is_array($url_params['country_id'])) {
                $conditions['UniversityCourses.country_id in'] = $url_params['country_id'];
            } else {
                $conditions['UniversityCourses.country_id'] = $url_params['country_id'];
            }
        // if (isset($url_params['degree'])) {

        //     if ($url_params['degree'] == 2) {
        //         if (isset($url_params['study_level_id']))
        //             $conditions['UniversityCourses.study_level_id'] = $url_params['study_level_id'];
        //         // if (isset($url_params['subject_area_id']))
        //         //     $conditions['UniversityCourses.subject_area_id'] = $url_params['subject_area_id'];
        //     } else {
        //         if (isset($url_params['major_id']))
        //             $conditions['UniversityCourses.major_id'] = $url_params['major_id'];
        //         if (isset($url_params['country_id'])) {
        //             if (is_array($url_params['country_id'])) {
        //                 $conditions['UniversityCourses.country_id in'] = $url_params['country_id'];
        //             } else {
        //                 $conditions['UniversityCourses.country_id'] = $url_params['country_id'];
        //             }
        //         }
        //     }
        // }

        // print_r($conditions);
        return $conditions;
    }

    public function details($id = null, $permalink = null)
    {

        // $this->set('bodyClass', 'pageAbout pageServices');
        $course = $this->UniversityCourses->find()
            ->contain([
                // 'Courses' => ['fields' => ['course_name']],
                'Countries' => ['fields' => ['country_name', 'use_country_currency', 'currency']],
                'Universities' => ['fields' => ['university_name', 'rank', 'permalink', 'short_description']],
                'Services' => ['fields' => ['title']],
                'SubjectAreas' => ['fields' => ['title']],
                'StudyLevels' => ['fields' => ['title']]
            ])
            ->where(['UniversityCourses.id' => $id])
            ->order(['UniversityCourses.display_order' => 'asc'])->first();

        // debug($course);
        $this->set('bodyClass', 'pageAbout pageServices');

        if (empty($course))

            throw new NotFoundException(__('Not found'));

        // print_r($course);
        $this->set('course', $course);
        $this->set('permalink', $permalink);


        $this->set('appCourses', $this->getAppCourses());
        $this->set('wishLists', $this->getWishLists());
    }
}
