<?php
// declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\ServerRequest;
use Cake\Core\Configure;
// use Cake\Auth\DefaultPasswordHasher;


/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminsController extends AppController
{

    public $paginate = [
        // 'limit' => 1,
        'order' => [
            'Admins.name' => 'asc'
        ]
    ];



    public function login()
    {

        if (!isset($_SESSION)) {
            session_start();
        }
        // debug($_SESSION);
        // print_r($this->request->getData());
        // die("---");
        // $admin = $this->Admins->get(4);
        // print_r($admin);die;
        // if (empty($_SERVER["HTTPS"])) {
        //     header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        //     exit;
        // }
        $this->viewBuilder()->disableAutoLayout();

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            // die('sdad');

            if ($user) {
                $this->Auth->setUser($user);
                $this->logedInUser = $user;
                // return $this->redirect($this->Auth->redirectUrl());
                return $this->redirect('/admin');
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }
    }

    public function logout()
    {
        // Configure::write('debug', true);
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->checkIfSuperadmin();

        $conditions = $this->_filter_params();

        $this->paginate = array('limit' => 100);
        $admins = $this->paginate($this->Admins, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters', 'admins'));
    }

    /**
     * View method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->checkIfSuperadmin();
        $admin = $this->Admins->get($id, [
            'contain' => [],
        ]);

        $this->set('admin', $admin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->checkIfSuperadmin();
        $admin = $this->Admins->newEmptyEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));

        $this->loadModel("Roles");
        $roles_data = $this->Roles->find()->all()->toArray();
        $roles_list = [];
        foreach ($roles_data as $key => $value) {
            $roles_list[$value->id] = $value->title;
        }
        $this->set("roles", $roles_list);
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        Configure::write('debug', true);
        $this->checkIfSuperadmin();
        $admin = $this->Admins->get($id, [
            'contain' => [],
        ]);
        unset($admin->password);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $req_data = $this->request->getData();
            if ($req_data["password"] == "" && $req_data["repeat_password"] == "") {
                unset($req_data["password"], $req_data["repeat_password"]);
            }
            // print_r($req_data);die;

            $admin = $this->Admins->patchEntity($admin, $req_data);
            // debug($this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // debug($admin->getErrors());
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->loadModel("Roles");
        $roles_data = $this->Roles->find()->all()->toArray();
        $roles_list = [];
        foreach ($roles_data as $key => $value) {
            $roles_list[$value->id] = $value->title;
        }
        $this->set("roles", $roles_list);

        $this->set(compact('admin'));
        $this->render('add');
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->checkIfSuperadmin();
        // $this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admins->get($id);
        if ($admin['super_admin'] != 1)
            if ($this->Admins->delete($admin)) {
                $this->Flash->success(__('The admin has been deleted.'));
            } else {
                $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
            }
        else
            $this->Flash->error(__('Sorry, you are not allowed to delete super admin!!!!.'));

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->checkIfSuperadmin();
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Admins->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The admins has been deleted.'));
        } else {
            $this->Flash->error(__('The admins could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function dashboard()
    {
        // Configure::write('debug', true);
        $this->loadModel("Files");

        $q = $this->Files->find();
        $total_files = $q->select(['files_count' => $q->func()->count('id')])
            ->all()->toArray();
        $this->set("total_files", $total_files[0]->files_count);

        $q = $this->Files->find();
        $classified_files = $q->select(['files_count' => $q->func()->count('id')])
            ->where(["classifier_id is not null"])
            ->all()->toArray();
        $this->set("classified_files", $classified_files[0]->files_count);

        $q = $this->Files->find();
        $annotated_files = $q->select(['files_count' => $q->func()->count('id')])
            ->where(["annotator_id is not null"])
            ->all()->toArray();
        $this->set("annotated_files", $annotated_files[0]->files_count);

        $q = $this->Files->find();
        $reviewed_files = $q->select(['files_count' => $q->func()->count('id')])
            ->where(["reviewer_id is not null"])
            ->all()->toArray();
        $this->set("reviewed_files", $reviewed_files[0]->files_count);
    }
    public function dashboard2()
    {
        // Configure::write('debug', true);
        $this->loadModel("Users");

        // ********** total_registered_users ********** 
        $query2 = $this->Users->find();
        $total_users_number_obj = $query2->select(['users_count' => $query2->func()->count('id')])
            // ->group('id')
            ->all()->toArray();
        $this->set("total_registered_users", $total_users_number_obj[0]->users_count);

        // ********** total_uploaded_files ********** 
        $this->loadModel("Uploads");
        $query3 = $this->Uploads->find();
        $total_uploaded_files_obj = $query3->select(['uploads_count' => $query3->func()->count('id')])
            ->all()->toArray();
        $this->set("total_uploaded_files", $total_uploaded_files_obj[0]->uploads_count);


        // ********** max_reached_lesson ********** 
        $q4 = $this->Uploads->find();
        $max_reached_lesson_obj = $q4->select(['max_lesson' => $q4->func()->max('lesson_id')])
            ->all()->toArray();
        $this->set("max_reached_lesson", $max_reached_lesson_obj[0]->max_lesson);


        // ********** total_nulled_uploads ********** 
        $this->loadModel("NulledUploads");
        $query5 = $this->NulledUploads->find();
        $total_NulledUploads_obj = $query5->select(['nulled_uploads_count' => $query5->func()->count('id')])
            // ->group('id')
            ->all()->toArray();
        $this->set("total_nulled_uploads", $total_NulledUploads_obj[0]->nulled_uploads_count);

        // ********** active_users ********** 
        $query6 = $this->Uploads->find();
        $active_users = $query6->select(['users_count' => $query6->func()->count('DISTINCT user_id')])
            // ->group('user_id')
            ->all()->toArray();
        $this->set("active_users", $active_users[0]->users_count);



        // ********** items_count ********** 
        $query7 = $this->Uploads->find();
        $all_items_count = $query7->select(['items_count' => $query7->func()->count('DISTINCT lesson_id,item_id')])
            // ->group('lesson_id,item_id')
            ->all()->toArray();
        $this->set("items_count", $all_items_count[0]->items_count);

        // ********** All and active country ********** 
        $active_users_obj = $this->Uploads->find()->select("user_id")->distinct("user_id")->all()->toArray();
        $active_users_ids = [];
        foreach ($active_users_obj as $k8 => $v8) {
            $active_users_ids[] = $v8->user_id;
        }
        $query8 = $this->Users->find();
        $active_country_count = $query8->select(['country_count' => $query8->func()->count('DISTINCT country')])->where(["id in" => $active_users_ids])
            ->all()->toArray();
        $this->set("active_country_count", $active_country_count[0]->country_count);

        $query9 = $this->Users->find();
        $all_country_count = $query9->select(['country_count' => $query9->func()->count('DISTINCT country')])->all()->toArray();
        $this->set("all_country_count", $all_country_count[0]->country_count);

        // $conditions = [];
        // if ($this->request->is('post')) {
        //     $req_data = $this->request->getData();
        //     if(!empty($req_data["from_date"])){
        //         $this->set("from_date",$req_data["from_date"]);
        //         $from_date_time = date("Y-m-d H:i:s",strtotime($req_data["from_date"]));
        //         if(!empty($req_data["to_date"])){
        //             $to_date_time = date("Y-m-d",strtotime($req_data["to_date"]));
        //             $to_date_time .= ' 23:59:59';
        //         }else{
        //             $to_date_time = date("Y-m-d");
        //             $to_date_time .= ' 23:59:59';
        //         }
        //         $this->set("to_date",date("d-m-Y",strtotime($to_date_time)));
        //         $conditions["created >="] = $from_date_time;
        //         $conditions["created <="] = $to_date_time;
        //     }
        // }
        // //users per country chart
        // $this->loadModel("Users");
        // $query = $this->Users->find();
        // $users_count_per_country = $query->select(['users_count' => $query->func()->count('id'), 'country'])
        //                             ->where($conditions)
        //                             ->group('country')
        //                             ->all()->toArray();
        // $users_count_per_country__countries_list = [];
        // $users_count_per_country__counts_list = [];
        // foreach ($users_count_per_country as $k1 => $v) {
        //     $users_count_per_country__countries_list[] = $v->country;
        //     $users_count_per_country__counts_list[] = $v->users_count;
        // }
        // $this->set("users_count_per_country__countries_list",json_encode($users_count_per_country__countries_list));
        // $this->set("users_count_per_country__counts_list",json_encode($users_count_per_country__counts_list));
        // $this->set("users_count_per_country",$users_count_per_country);


        // $query2 = $this->Users->find();
        // $total_users_number_obj = $query2->select(['users_count' => $query2->func()->count('id') ])
        //                             // ->group('id')
        //                             ->all()->toArray();

        // $admin = $this->Admins->newEmptyEntity();
        // $this->set(compact('admin'));

        // $this->set("total_users_number",$total_users_number_obj[0]->users_count);
    }

    public function osStatistics()
    {
        // Configure::write('debug', true);
        ini_set('memory_limit', '1024M');
        $this->loadModel("Users");
        $this->loadModel("Uploads");

        // ********** total_registered_users ********** 
        $total_registered_users = $this->_get_registered_users_number();
        $total_registered_users_android = $this->_get_registered_users_number('Android');
        $total_registered_users_ios = $this->_get_registered_users_number('iOS');
        $total_registered_users_huawei = $this->_get_registered_users_number('Huawei');

        $this->set("total_registered_users", $total_registered_users);
        $this->set("total_registered_users_android", $total_registered_users_android);
        $this->set("total_registered_users_ios", $total_registered_users_ios);
        $this->set("total_registered_users_huawei", $total_registered_users_huawei);


        // ********** total_uploaded_files ********** 
        $total_uploaded_files = $this->_get_total_uploaded_files();
        $total_uploaded_files_android = $this->_get_total_uploaded_files('Android');
        $total_uploaded_files_ios = $this->_get_total_uploaded_files('iOS');
        $total_uploaded_files_huawei = $this->_get_total_uploaded_files('Huawei');

        $this->set("total_uploaded_files", $total_uploaded_files);
        $this->set("total_uploaded_files_android", $total_uploaded_files_android);
        $this->set("total_uploaded_files_ios", $total_uploaded_files_ios);
        $this->set("total_uploaded_files_huawei", $total_uploaded_files_huawei);


        // ********** max_reached_lesson ********** 
        $max_reached_lesson = $this->_get_max_reached_lesson();
        $max_reached_lesson_android = $this->_get_max_reached_lesson('Android');
        $max_reached_lesson_ios = $this->_get_max_reached_lesson('iOS');
        $max_reached_lesson_huawei = $this->_get_max_reached_lesson('Huawei');

        $this->set("max_reached_lesson", $max_reached_lesson);
        $this->set("max_reached_lesson_android", $max_reached_lesson_android);
        $this->set("max_reached_lesson_ios", $max_reached_lesson_ios);
        $this->set("max_reached_lesson_huawei", $max_reached_lesson_huawei);


        // ********** active_users ********** 
        $active_users = $this->_get_active_users();
        $active_users_android = $this->_get_active_users('Android');
        $active_users_ios = $this->_get_active_users('iOS');
        $active_users_huawei = $this->_get_active_users('Huawei');

        $this->set("active_users", $active_users);
        $this->set("active_users_android", $active_users_android);
        $this->set("active_users_ios", $active_users_ios);
        $this->set("active_users_huawei", $active_users_huawei);


        // ********** items_count ********** 
        $items_count = $this->_get_items_count();
        $items_count_android = $this->_get_items_count('Android');
        $items_count_ios = $this->_get_items_count('iOS');
        $items_count_huawei = $this->_get_items_count('Huawei');

        $this->set("items_count", $items_count);
        $this->set("items_count_android", $items_count_android);
        $this->set("items_count_ios", $items_count_ios);
        $this->set("items_count_huawei", $items_count_huawei);

        // ********** All and active country ********** 
        $active_country_count = $this->_get_active_country_count();
        $active_country_count_android = $this->_get_active_country_count('Android');
        $active_country_count_ios = $this->_get_active_country_count('iOS');
        $active_country_count_huawei = $this->_get_active_country_count('Huawei');

        $this->set("active_country_count", $active_country_count);
        $this->set("active_country_count_android", $active_country_count_android);
        $this->set("active_country_count_ios", $active_country_count_ios);
        $this->set("active_country_count_huawei", $active_country_count_huawei);

        $all_country_count = $this->_get_all_country_count();
        $all_country_count_android = $this->_get_all_country_count('Android');
        $all_country_count_ios = $this->_get_all_country_count('iOS');
        $all_country_count_huawei = $this->_get_all_country_count('Huawei');

        $this->set("all_country_count", $all_country_count);
        $this->set("all_country_count_android", $all_country_count_android);
        $this->set("all_country_count_ios", $all_country_count_ios);
        $this->set("all_country_count_huawei", $all_country_count_huawei);
    }
    function _get_registered_users_number($os = '')
    {
        $query2 = $this->Users->find();
        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }
            $total_users_number_obj = $query2->select(['users_count' => $query2->func()->count('id')])
                ->where($conditions)
                ->all()->toArray();
        } else {
            $total_users_number_obj = $query2->select(['users_count' => $query2->func()->count('id')])
                ->all()->toArray();
        }
        return $total_users_number_obj[0]->users_count;
    }

    function _get_total_uploaded_files($os = '')
    {
        $query3 = $this->Uploads->find();
        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }
            $users_in_country = $this->Users->find()->where($conditions)->all()->toArray();
            if (!empty($users_in_country)) {
                $filtered_user_ids = [];
                foreach ($users_in_country as $ccvalue) {
                    $filtered_user_ids[] = $ccvalue->id;
                }
            }
            if (!empty($filtered_user_ids)) {
                $conditions1["user_id in"] = $filtered_user_ids;
            }
            $total_uploaded_files_obj = $query3->select(['uploads_count' => $query3->func()->count('id')])
                ->where($conditions1)
                ->all()->toArray();
        } else {
            $total_uploaded_files_obj = $query3->select(['uploads_count' => $query3->func()->count('id')])
                ->all()->toArray();
        }
        return $total_uploaded_files_obj[0]->uploads_count;
    }

    function _get_max_reached_lesson($os = '')
    {
        $q4 = $this->Uploads->find();
        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }
            $users_in_country = $this->Users->find()->where($conditions)->all()->toArray();
            if (!empty($users_in_country)) {
                $filtered_user_ids = [];
                foreach ($users_in_country as $ccvalue) {
                    $filtered_user_ids[] = $ccvalue->id;
                }
            }
            if (!empty($filtered_user_ids)) {
                $conditions1["user_id in"] = $filtered_user_ids;
            }
            $max_reached_lesson_obj = $q4->select(['max_lesson' => $q4->func()->max('lesson_id')])
                ->where($conditions1)
                ->all()->toArray();
        } else {
            $max_reached_lesson_obj = $q4->select(['max_lesson' => $q4->func()->max('lesson_id')])
                ->all()->toArray();
        }
        return $max_reached_lesson_obj[0]->max_lesson;
    }


    function _get_active_users($os = '')
    {
        $query6 = $this->Uploads->find();
        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }
            $users_in_country = $this->Users->find()->where($conditions)->all()->toArray();
            if (!empty($users_in_country)) {
                $filtered_user_ids = [];
                foreach ($users_in_country as $ccvalue) {
                    $filtered_user_ids[] = $ccvalue->id;
                }
            }
            if (!empty($filtered_user_ids)) {
                $conditions1["user_id in"] = $filtered_user_ids;
            }
            $active_users = $query6->select(['users_count' => $query6->func()->count('DISTINCT user_id')])
                ->where($conditions1)
                ->all()->toArray();
        } else {
            $active_users = $query6->select(['users_count' => $query6->func()->count('DISTINCT user_id')])
                ->all()->toArray();
        }
        return $active_users[0]->users_count;
    }

    function _get_items_count($os = '')
    {
        $query7 = $this->Uploads->find();

        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }
            $users_in_country = $this->Users->find()->where($conditions)->all()->toArray();
            if (!empty($users_in_country)) {
                $filtered_user_ids = [];
                foreach ($users_in_country as $ccvalue) {
                    $filtered_user_ids[] = $ccvalue->id;
                }
            }
            if (!empty($filtered_user_ids)) {
                $conditions1["user_id in"] = $filtered_user_ids;
            }

            $all_items_count = $query7->select(['items_count' => $query7->func()->count('DISTINCT lesson_id,item_id')])
                ->where($conditions1)
                ->all()->toArray();
        } else {
            $all_items_count = $query7->select(['items_count' => $query7->func()->count('DISTINCT lesson_id,item_id')])
                ->all()->toArray();
        }
        return $all_items_count[0]->items_count;
    }

    function _get_active_country_count($os = '')
    {


        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }


            $active_users_obj = $this->Uploads->find()->select("user_id")->distinct("user_id")->all()->toArray();
            $active_users_ids = [];
            foreach ($active_users_obj as $k8 => $v8) {
                $active_users_ids[] = $v8->user_id;
            }
            $conditions["id in"] = $active_users_ids;
            $query8 = $this->Users->find();
            $active_country_count = $query8->select(['country_count' => $query8->func()->count('DISTINCT country')])->where($conditions)
                ->all()->toArray();
        } else {
            $active_users_obj = $this->Uploads->find()->select("user_id")->distinct("user_id")->all()->toArray();
            $active_users_ids = [];
            foreach ($active_users_obj as $k8 => $v8) {
                $active_users_ids[] = $v8->user_id;
            }
            $query8 = $this->Users->find();
            $active_country_count = $query8->select(['country_count' => $query8->func()->count('DISTINCT country')])->where(["id in" => $active_users_ids])
                ->all()->toArray();
        }
        return $active_country_count[0]->country_count;
    }

    function _get_all_country_count($os = '')
    {
        $query9 = $this->Users->find();
        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }
            $all_country_count = $query9->select(['country_count' => $query9->func()->count('DISTINCT country')])->where($conditions)->all()->toArray();
        } else {
            $all_country_count = $query9->select(['country_count' => $query9->func()->count('DISTINCT country')])->all()->toArray();
        }
        return $all_country_count[0]->country_count;
    }
}
