<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class CoursesController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $courses = $this->Courses->find()
            ->contain([
                'Countries' => ['fields' => ['country_name']],
                // 'Universities' => ['fields' => ['university_name', 'rank']],
                'Services' => ['fields' => ['title']],
                'StudyLevels' => ['fields' => ['title']],
                // 'SubjectAreas' => ['fields' => ['title']]
            ])
            ->where(['Courses.active' => 1])->order(['Courses.display_order' => 'asc'])
            ->limit(10)->all();

        $this->set('courses', $courses->toArray());

        $this->loadModel('Majors');
        $courseMajors = $this->Majors->find('list')->where(['active' => 1])->order(['display_order' => 'asc']);

        $this->set('courseMajors', $courseMajors);
        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination'=>1])->order(['display_order' => 'asc']);

        $this->set('countriesList', $countriesList);
    }

    public function study()
    {
        $this->set('bodyClass', 'pageAbout pageServices');
        $courses = $this->Courses->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();
        $this->set('courses', $courses);


        $this->loadModel('Majors');
        $courseMajors = $this->Majors->find('list')->where(['active' => 1])->order(['display_order' => 'asc']);
        $this->set('courseMajors', $courseMajors);


        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination'=>1])->order(['display_order' => 'asc']);
        $this->set('countriesList', $countriesList);


        $this->loadModel('Services');
        $servicesSearchList = $this->Services->find('all')->where(['active' => 1, 'show_in_search' => 1])
            ->order([/*'display_order' => 'asc',*/'search_degree_options' => 'ASC'])->all()->toArray();
        // debug($servicesSearchList);
        $this->set('servicesSearchList', $servicesSearchList);
        $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);

        $this->loadModel('StudyLevels');
        $studyLevels = $this->StudyLevels->find('all')->where(['active' => 1])
            ->order(['display_order' => 'asc'])->all()->toArray();
        $this->set('studyLevels', $studyLevels);
    }


    public function results()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $conditions = $this->__prepConditions();
        $conditions['Courses.active'] = 1;

        debug($conditions);
        $courses = $this->Courses->find()->contain([
            'Countries' => ['fields' => ['country_name']],
            // 'Universities' => ['fields' => ['university_name', 'rank']], 
            'Services' => ['fields' => ['title']],
            'StudyLevels' => ['fields' => ['title']],
            // 'SubjectAreas' => ['fields' => ['title']]
        ])->where($conditions)->order(['Courses.display_order' => 'asc'])->limit(10)->all();

        $this->set('courses', $courses->toArray());


        // $this->loadModel('Majors');
        // $courseMajors = $this->Majors->find('list')->where(['active' => 1])->order(['display_order' => 'asc']);

        // $this->set('courseMajors', $courseMajors);
        // $this->loadModel('Countries');
        // $countriesList = $this->Countries->find('list', [
        //     'keyField' => 'id', 'valueField' => 'country_name'
        // ])->where(['active' => 1, 'is_destination'=>1])->order(['display_order' => 'asc']);

        // $this->set('countriesList', $countriesList);
    }

    private function __prepConditions()
    {

        $conditions = [];
        $url_params = $this->request->getQuery();
        $url_params = $this->request->getQuery();

        debug($url_params);
        unset($url_params['url'], $url_params['page'], $url_params['sort'], $url_params['direction']);


        if (isset($url_params['service_id']))
            $conditions['Courses.service_id'] = $url_params['service_id'];

        if (isset($url_params['study_level_id']))
            $conditions['Courses.study_level_id'] = $url_params['study_level_id'];

        if (isset($url_params['min_budget']))
            $conditions['Courses.fees >='] = $url_params['min_budget'];
        if (isset($url_params['max_budget']))
            $conditions['Courses.fees <='] = $url_params['max_budget'];

        if (isset($url_params['degree'])) {

            if ($url_params['degree'] == 2) {
                if (isset($url_params['study_level_id']))
                    $conditions['Courses.study_level_id'] = $url_params['study_level_id'];
                // if (isset($url_params['subject_area_id']))
                //     $conditions['Courses.subject_area_id'] = $url_params['subject_area_id'];
            } else {
                if (isset($url_params['major_id']))
                    $conditions['Courses.major_id'] = $url_params['major_id'];
                if (isset($url_params['county_id']))
                    $conditions['Courses.county_id'] = $url_params['county_id'];
            }
        }


        return $conditions;
    }

    public function details($id = null)
    {
        $course = $this->Courses->findByPermalink($id)->first();

        // debug($course);
        $this->set('bodyClass', 'pageAbout pageServices');

        if (empty($course))

            throw new NotFoundException(__('Not found'));

        // print_r($course);
        $this->set('course', $course);
        $this->set('permalink', $id);
    }
}
