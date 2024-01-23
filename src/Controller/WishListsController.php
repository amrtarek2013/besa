<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class WishListsController extends AppController
{

    // public function index()
    // {
    //     $this->set('bodyClass', 'pageAbout pageServices');

    //     $wishLists = $this->WishLists->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

    //     $this->set('wishLists', $wishLists);
    // }


    public function index()
    {
        // $conditions = $this->_filter_params();

        // $user = $this->Auth->user();
        $conditions = [];
        $wishLists = $this->getWishLists();

        $this->loadModel('UniversityCourses');

        $courses = $this->UniversityCourses->find()->contain(
            [
                'Courses' => ['fields' => ['course_name']],
                'Countries' => ['fields' => ['country_name']],
                'Universities' => ['fields' => ['university_name', 'rank']],
                'Services' => ['fields' => ['title']],
                'StudyLevels' => ['fields' => ['title']],
                'SubjectAreas' => ['fields' => ['title']]
            ]
        )->where(['UniversityCourses.id IN' => $wishLists])->order(['UniversityCourses.display_order' => 'asc'])->limit(10)->all();

        $this->set('courses', $courses->toArray());
        $this->set('wishLists', $wishLists);
        $this->set('appCourses', $this->getAppCourses());
        $parameters = $this->request->getAttribute('params');
        // dd($wishLists);
        $this->set(compact('parameters'));
    }

    public function add($course_id, $isNew = 'add')
    {

        $this->loadModel('UniversityCourses');

        $message = __('The Course not found. Please, try again.');
        $status = 'error';
        $this->loadModel('UniversityCourses');
        $course = $this->UniversityCourses->find()->where(['id' => $course_id])->first();

        $wishList = $this->WishLists->newEmptyEntity();
        if ($course) {
            if ($isNew == 'add') {
                $wishList = $this->WishLists->patchEntity($wishList, $this->request->getData());
                $wishList->course_id = $course_id;
                $wishList->university_course_id = $course_id;
                if (isset($_SESSION['Auth']['User'])) {
                    $user = $_SESSION['Auth']['User'];
                    $wishList->user_id = $user['id'];
                } else
                    $wishList->user_token = $this->userToken();

                if ($this->WishLists->save($wishList)) {
                    $message = __('The Course added to WishList Successfully.');
                    $status = 'success';
                } else {
                    $message = __('The WishList could not be saved. Please, try again.');
                }
            } else {
                $conditions = [
                    // 'course_id' => $course_id,
                    'university_course_id' => $course_id
                ];
                if (isset($_SESSION['Auth']['User'])) {
                    $user = $_SESSION['Auth']['User'];
                    $conditions['user_id'] = $user['id'];
                } else
                    $conditions['user_token'] = $this->userToken();
                $wishList = $this->WishLists->find()->where($conditions)->first();
                if ($wishList) {
                    $this->WishLists->delete($wishList);
                }
                $status = 'deleted';

                $message = __('The Course removed from the WishList Successfully.');
            }
        }

        if ($this->request->is('ajax')) {
            die(json_encode(['status' => $status, 'message' => $message]));
        } else {
            $this->redirect($this->referer(array('action' => 'index'), true));
        }
    }



    public function addUni($uni_id, $isNew = 'add')
    {

        $this->loadModel('UniversityCourses');

        $message = __('The university not found. Please, try again.');
        $status = 'error';
        $this->loadModel('Universities');
        $university = $this->Universities->find()->where(['id' => $uni_id])->first();

        $wishList = $this->WishLists->newEmptyEntity();
        if ($university) {
            if ($isNew == 'add') {
                $wishList = $this->WishLists->patchEntity($wishList, $this->request->getData());
                $wishList->university_id = $uni_id;
                if (isset($_SESSION['Auth']['User'])) {
                    $user = $_SESSION['Auth']['User'];
                    $wishList->user_id = $user['id'];
                } else
                    $wishList->user_token = $this->userToken();

                if ($this->WishLists->save($wishList)) {
                    $message = __('The university added to WishList Successfully.');
                    $status = 'success';
                } else {
                    $message = __('The WishList could not be saved. Please, try again.');
                }
            } else {
                $conditions = [
                    // 'course_id' => $course_id,
                    'university_id' => $uni_id
                ];
                if (isset($_SESSION['Auth']['User'])) {
                    $user = $_SESSION['Auth']['User'];
                    $conditions['user_id'] = $user['id'];
                } else
                    $conditions['user_token'] = $this->userToken();
                $wishList = $this->WishLists->find()->where($conditions)->first();
                if ($wishList) {
                    $this->WishLists->delete($wishList);
                }
                $status = 'deleted';

                $message = __('The university removed from the WishList Successfully.');
            }
        }

        if ($this->request->is('ajax')) {
            die(json_encode(['status' => $status, 'message' => $message]));
        } else {
            $this->redirect($this->referer(array('action' => 'index'), true));
        }
    }
}
