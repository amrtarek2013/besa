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
        $wishLists = $this->WishLists->find('list', ['keyField' => 'course_id', 'valueField' => 'course_id'])
            ->where($conditions);

        $this->loadModel('UniversityCourses');

        $courses = $this->UniversityCourses->find()->contain(
            [
                'Courses' => ['fields' => ['course_name']],
                'Countries' => ['fields' => ['country_name']],
                'Universities' => ['fields' => ['university_name', 'rank']],
                'Services' => ['fields' => ['title']],
                'SubjectAreas' => ['fields' => ['title']]
            ]
        )->where(['UniversityCourses.id IN' => $wishLists])->order(['UniversityCourses.display_order' => 'asc'])->limit(10)->all();

        $this->set('courses', $courses->toArray());
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
                $conditions = ['course_id' => $course_id];
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
}
