<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\ServerRequest;
use Cake\Core\Configure;
use Cake\View\View;


class FileLogsController extends AppController
{
    // public $paginate = [
    //     // 'limit' => 1,
    //     'order' => [
    //         'Files.created' => 'desc'
    //     ]
    // ];

    // public function accounting(){
    // 	// Configure::write('debug', true);
    // 	$this->loadModel("FileLogs");
    //     $conditions = $this->_filter_params(false,"accounting_filters");
    //     $parameters = $this->request->getAttribute('params');
    //     if (!empty($parameters["?"])) {

    //     	$this->paginate = array('limit' => 100);
    //     	$conditions['FileLogs.status in'] = [2,3,4,6,7,9,10];
    //     	$files = $this->paginate($this->FileLogs, [
    //     										'conditions' => $conditions,
    //     										'group' => ["FileLogs.file_id","FileLogs.status"],
    //     									]);
    //     	$this->set(compact('files'));

    //     	//get total classified files for this user
    //     	$classifications_conditions = $conditions;
    //     	$classifications_conditions['FileLogs.status in'] = [2,3,4];
    //     	$q = $this->FileLogs->find();
    //     	$classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
    //     							->where($classifications_conditions)
    //                                 // ->group(["FileLogs.file_id","FileLogs.status"])
    //                                 ->all()->toArray();
    //         $classified_files_number = $classified_files_number_obj[0]->files_count;
    //     	$this->set("classified_files_number",$classified_files_number);

    //     	//get total annotated files for this user
    //     	$annotations_conditions = $conditions;
    //     	$annotations_conditions['FileLogs.status in'] = [6,7];
    //     	$q = $this->FileLogs->find();
    //     	$annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
    //     							->where($annotations_conditions)
    //                                 ->all()->toArray();
    //         $annotated_files_number = $annotated_files_number_obj[0]->files_count;
    //     	$this->set("annotated_files_number",$annotated_files_number);

    //     	//get total reviewed files for this user
    //     	$reviews_conditions = $conditions;
    //     	$reviews_conditions['FileLogs.status in'] = [9,10];
    //     	$q = $this->FileLogs->find();
    //     	$reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
    //     							->where($reviews_conditions)
    //                                 ->all()->toArray();
    //         $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
    //     	$this->set("reviewed_files_number",$reviewed_files_number);

    //         $accounting_classification_files = $this->g_configs['accounting']['classification_files'];
    //         $accounting_classification_cost = $this->g_configs['accounting']['classification_cost'];
    //         $one_file_classification_cost = floatval($accounting_classification_cost) /  floatval($accounting_classification_files);

    //         $accounting_annotation_files = $this->g_configs['accounting']['annotation_files'];
    //         $accounting_annotation_cost = $this->g_configs['accounting']['annotation_cost'];
    //         $one_file_annotation_cost = floatval($accounting_annotation_cost) /  floatval($accounting_annotation_files);

    //         $accounting_review_files = $this->g_configs['accounting']['review_files'];
    //         $accounting_review_cost = $this->g_configs['accounting']['review_cost'];
    //         $one_file_review_cost = floatval($accounting_review_cost) /  floatval($accounting_review_files);

    //     	$classification_cost = $one_file_classification_cost*intval($classified_files_number);
    //     	$annotation_cost = $one_file_annotation_cost*intval($annotated_files_number);
    //     	$review_cost = $one_file_review_cost*intval($reviewed_files_number);

    //     	$total_cost = $classification_cost + $annotation_cost + $review_cost;

    //     	$this->set(compact('classification_cost','annotation_cost','review_cost','total_cost'));
    //     }

    //     $this->__common();
    //     $this->set(compact('parameters'));

    // }

    public function accounting()
    {
        // Configure::write('debug', true);
        $this->loadModel("FileLogs");
        $conditions = $this->_filter_params(false, "accounting_filters");
        $parameters = $this->request->getAttribute('params');

        $accounting_classification_files = $this->g_configs['accounting']['classification_files'];
        $accounting_classification_cost = $this->g_configs['accounting']['classification_cost'];
        $one_file_classification_cost = floatval($accounting_classification_cost) /  floatval($accounting_classification_files);

        $accounting_annotation_files = $this->g_configs['accounting']['annotation_files'];
        $accounting_annotation_cost = $this->g_configs['accounting']['annotation_cost'];
        $one_file_annotation_cost = floatval($accounting_annotation_cost) /  floatval($accounting_annotation_files);

        $accounting_review_files = $this->g_configs['accounting']['review_files'];
        $accounting_review_cost = $this->g_configs['accounting']['review_cost'];
        $one_file_review_cost = floatval($accounting_review_cost) /  floatval($accounting_review_files);

        // if (!empty($parameters["?"])) {
        if (!empty($conditions['FileLogs.admin_id in'])) {
            $admin_ids = json_encode($conditions['FileLogs.admin_id in']);
            $this->set("admin_ids", $admin_ids);
        }

        $conditions['FileLogs.status in'] = [2, 3, 4, 6, 7, 9, 10];
        // $this->paginate = array('limit' => 100);
        // $files = $this->paginate($this->FileLogs, [
        //                                  'conditions' => $conditions,
        //                                  'group' => ["FileLogs.file_id","FileLogs.status"],
        //                              ]);
        // $this->set(compact('files'));

        //*******************************************
        $this->loadModel("Admins");
        $admins = $this->Admins->find('list', [
            'keyField' => 'id', 'valueField' => 'name'
        ])->where(["super_admin is" => null])->toArray();

        $query = $this->FileLogs->find();
        $all_files_count = $query->select(['files_count' => $query->func()->count('id'), 'status', 'admin_id'])
            ->where($conditions)
            ->group(['status', 'admin_id'])
            // ->order([$sort => $dir])
            ->all()->toArray();
        $team_report_data = [];
        foreach ($all_files_count as $key => $value) {
            if (empty($classification_count[$value->admin_id])) {
                $classification_count[$value->admin_id] = 0;
            }
            if (empty($annotation_count[$value->admin_id])) {
                $annotation_count[$value->admin_id] = 0;
            }
            if (empty($review_count[$value->admin_id])) {
                $review_count[$value->admin_id] = 0;
            }
            if (in_array($value->status, $this->FileLogs->classification_status)) {
                $classification_count[$value->admin_id] += $value->files_count;
            } elseif (in_array($value->status, $this->FileLogs->annotation_status)) {
                $annotation_count[$value->admin_id] += $value->files_count;
            } elseif (in_array($value->status, $this->FileLogs->review_status)) {
                $review_count[$value->admin_id] += $value->files_count;
            }
            $team_report_data[$value->admin_id] = [
                'user' => $admins[$value->admin_id],
                'classification' => $classification_count[$value->admin_id],
                'classification_cost' => $one_file_classification_cost * intval($classification_count[$value->admin_id]),

                'annotation' => $annotation_count[$value->admin_id],
                'annotation_cost' => $one_file_annotation_cost * intval($annotation_count[$value->admin_id]),

                'review' => $review_count[$value->admin_id],
                'review_cost' => $one_file_review_cost * intval($review_count[$value->admin_id]),
            ];
        }
        // print_r($all_files_count);
        $this->set(compact('team_report_data'));
        //*******************************************

        //get total classified files for this user
        $classifications_conditions = $conditions;
        $classifications_conditions['FileLogs.status in'] = [2, 3, 4];
        $q = $this->FileLogs->find();
        $classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($classifications_conditions)
            // ->group(["FileLogs.file_id","FileLogs.status"])
            ->all()->toArray();
        $classified_files_number = $classified_files_number_obj[0]->files_count;
        $this->set("classified_files_number", $classified_files_number);

        //get total annotated files for this user
        $annotations_conditions = $conditions;
        $annotations_conditions['FileLogs.status in'] = [6, 7];
        $q = $this->FileLogs->find();
        $annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($annotations_conditions)
            ->all()->toArray();
        $annotated_files_number = $annotated_files_number_obj[0]->files_count;
        $this->set("annotated_files_number", $annotated_files_number);

        //get total reviewed files for this user
        $reviews_conditions = $conditions;
        $reviews_conditions['FileLogs.status in'] = [9, 10];
        $q = $this->FileLogs->find();
        $reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($reviews_conditions)
            ->all()->toArray();
        $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
        $this->set("reviewed_files_number", $reviewed_files_number);



        $classification_cost = $one_file_classification_cost * intval($classified_files_number);
        $annotation_cost = $one_file_annotation_cost * intval($annotated_files_number);
        $review_cost = $one_file_review_cost * intval($reviewed_files_number);

        $total_cost = $classification_cost + $annotation_cost + $review_cost;

        $this->set(compact('classification_cost', 'annotation_cost', 'review_cost', 'total_cost'));
        // }

        $this->__common();
        $this->set(compact('parameters'));
    }

    public function allAccounting()
    {
        // Configure::write('debug', true);
        $this->loadModel("FileLogs");
        $conditions = $this->_filter_params(false, "all_accounting_filters");
        $parameters = $this->request->getAttribute('params');
        if (!empty($parameters["?"])) {

            $this->paginate = array('limit' => 100);
            $conditions['FileLogs.status in'] = [2, 3, 4, 6, 7, 9, 10];
            $files = $this->paginate($this->FileLogs, [
                'conditions' => $conditions,
                'group' => ["FileLogs.file_id", "FileLogs.status"],
            ]);
            $this->set(compact('files'));

            //get total classified files for this user
            $classifications_conditions = $conditions;
            $classifications_conditions['FileLogs.status in'] = [2, 3, 4];
            $q = $this->FileLogs->find();
            $classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
                ->where($classifications_conditions)
                // ->group(["FileLogs.file_id","FileLogs.status"])
                ->all()->toArray();
            $classified_files_number = $classified_files_number_obj[0]->files_count;
            $this->set("classified_files_number", $classified_files_number);

            //get total annotated files for this user
            $annotations_conditions = $conditions;
            $annotations_conditions['FileLogs.status in'] = [6, 7];
            $q = $this->FileLogs->find();
            $annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
                ->where($annotations_conditions)
                ->all()->toArray();
            $annotated_files_number = $annotated_files_number_obj[0]->files_count;
            $this->set("annotated_files_number", $annotated_files_number);

            //get total reviewed files for this user
            $reviews_conditions = $conditions;
            $reviews_conditions['FileLogs.status in'] = [9, 10];
            $q = $this->FileLogs->find();
            $reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
                ->where($reviews_conditions)
                ->all()->toArray();
            $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
            $this->set("reviewed_files_number", $reviewed_files_number);

            $accounting_classification_files = $this->g_configs['accounting']['classification_files'];
            $accounting_classification_cost = $this->g_configs['accounting']['classification_cost'];
            $one_file_classification_cost = floatval($accounting_classification_cost) /  floatval($accounting_classification_files);

            $accounting_annotation_files = $this->g_configs['accounting']['annotation_files'];
            $accounting_annotation_cost = $this->g_configs['accounting']['annotation_cost'];
            $one_file_annotation_cost = floatval($accounting_annotation_cost) /  floatval($accounting_annotation_files);

            $accounting_review_files = $this->g_configs['accounting']['review_files'];
            $accounting_review_cost = $this->g_configs['accounting']['review_cost'];
            $one_file_review_cost = floatval($accounting_review_cost) /  floatval($accounting_review_files);

            $classification_cost = $one_file_classification_cost * intval($classified_files_number);
            $annotation_cost = $one_file_annotation_cost * intval($annotated_files_number);
            $review_cost = $one_file_review_cost * intval($reviewed_files_number);

            $total_cost = $classification_cost + $annotation_cost + $review_cost;

            $this->set(compact('classification_cost', 'annotation_cost', 'review_cost', 'total_cost'));
        }

        $this->__common();
        $this->set(compact('parameters'));
    }

    public function myWorkSummary()
    {
        // Configure::write('debug', true);
        if ($this->authCom && !empty($this->Auth->user())) {
            $current_user = $this->Auth->user();
        } else {
            die("No Permissions");
        }

        $this->loadModel("FileLogs");
        $conditions = $this->_filter_params(false, "all_accounting_filters");
        $parameters = $this->request->getAttribute('params');
        // if (!empty($parameters["?"])) {

        $this->paginate = array('limit' => 100);
        $conditions['FileLogs.status in'] = [2, 3, 4, 6, 7, 9, 10];
        $conditions['FileLogs.admin_id'] = $current_user['id'];
        $files = $this->paginate($this->FileLogs, [
            'conditions' => $conditions,
            'group' => ["FileLogs.file_id", "FileLogs.status"],
        ]);
        $this->set(compact('files'));

        //get total classified files for this user
        $classifications_conditions = $conditions;
        $classifications_conditions['FileLogs.status in'] = [2, 3, 4];
        $q = $this->FileLogs->find();
        $classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($classifications_conditions)
            // ->group(["FileLogs.file_id","FileLogs.status"])
            ->all()->toArray();
        $classified_files_number = $classified_files_number_obj[0]->files_count;
        $this->set("classified_files_number", $classified_files_number);

        //get total annotated files for this user
        $annotations_conditions = $conditions;
        $annotations_conditions['FileLogs.status in'] = [6, 7];
        $q = $this->FileLogs->find();
        $annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($annotations_conditions)
            ->all()->toArray();
        $annotated_files_number = $annotated_files_number_obj[0]->files_count;
        $this->set("annotated_files_number", $annotated_files_number);

        //get total reviewed files for this user
        $reviews_conditions = $conditions;
        $reviews_conditions['FileLogs.status in'] = [9, 10];
        $q = $this->FileLogs->find();
        $reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($reviews_conditions)
            ->all()->toArray();
        $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
        $this->set("reviewed_files_number", $reviewed_files_number);

        $classification_cost = isset($this->g_configs['general']['cost_of_classification_for_one_file']) ? floatval($this->g_configs['general']['cost_of_classification_for_one_file']) * intval($classified_files_number) : 0;
        $annotation_cost = isset($this->g_configs['general']['cost_of_annotation_for_one_file']) ? floatval($this->g_configs['general']['cost_of_annotation_for_one_file']) * intval($annotated_files_number) : 0;
        $review_cost = isset($this->g_configs['general']['cost_of_review_for_one_file']) ? floatval($this->g_configs['general']['cost_of_review_for_one_file']) * intval($reviewed_files_number) : 0;

        $total_cost = $classification_cost + $annotation_cost + $review_cost;

        $this->set(compact('classification_cost', 'annotation_cost', 'review_cost', 'total_cost'));
        // }

        $this->__common();
        $this->set(compact('parameters'));
    }

    public function index()
    {
        // $this->checkIfSuperadmin();
        $conditions = $this->_filter_params();
        $this->paginate = array('limit' => 100);
        $files = $this->paginate($this->Files, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters', 'files'));
    }



    public function tasksReporting()
    {
        // Configure::write('debug', true);
        if ($this->authCom && !empty($this->Auth->user())) {
            $current_user = $this->Auth->user();
        } else {
            die("No Permissions");
        }

        $this->loadModel("FileLogs");
        $conditions = $this->_filter_params(false, "tasks_reports_filters");
        $parameters = $this->request->getAttribute('params');
        // if (!empty($parameters["?"])) {
        $this->paginate = array('limit' => 50);

        $task_to_show = 'all';
        if (empty($conditions['FileLogs.status'])) {
            $conditions['FileLogs.status in'] = [2, 3, 4, 6, 7, 9, 10];
        } else {
            if ($conditions['FileLogs.status'] == '100') {
                $conditions['FileLogs.status in'] = [2, 3, 4];
                $task_to_show = '100';
            } elseif ($conditions['FileLogs.status'] == '101') {
                $conditions['FileLogs.status in'] = [6, 7];
                $task_to_show = '101';
            } elseif ($conditions['FileLogs.status'] == '102') {
                $conditions['FileLogs.status in'] = [9, 10];
                $task_to_show = '102';
            }
        }
        unset($conditions['FileLogs.status']);
        $this->set(compact('task_to_show'));
        // print_r($conditions);

        // $conditions['FileLogs.admin_id'] = $current_user['id'];
        $files = $this->paginate($this->FileLogs, [
            'conditions' => $conditions,
            'group' => ["FileLogs.file_id", "FileLogs.status"],
        ]);
        $this->set(compact('files'));

        //get total classified files for this user
        $classifications_conditions = $conditions;
        $classifications_conditions['FileLogs.status in'] = [2, 3, 4];
        $q = $this->FileLogs->find();
        $classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($classifications_conditions)
            // ->group(["FileLogs.file_id","FileLogs.status"])
            ->all()->toArray();
        $classified_files_number = $classified_files_number_obj[0]->files_count;
        $this->set("classified_files_number", $classified_files_number);

        //get total annotated files for this user
        $annotations_conditions = $conditions;
        $annotations_conditions['FileLogs.status in'] = [6, 7];
        $q = $this->FileLogs->find();
        $annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($annotations_conditions)
            ->all()->toArray();
        $annotated_files_number = $annotated_files_number_obj[0]->files_count;
        $this->set("annotated_files_number", $annotated_files_number);

        //get total reviewed files for this user
        $reviews_conditions = $conditions;
        $reviews_conditions['FileLogs.status in'] = [9, 10];
        $q = $this->FileLogs->find();
        $reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
            ->where($reviews_conditions)
            ->all()->toArray();
        $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
        $this->set("reviewed_files_number", $reviewed_files_number);

        $classification_cost = isset($this->g_configs['general']['cost_of_classification_for_one_file']) ? floatval($this->g_configs['general']['cost_of_classification_for_one_file']) * intval($classified_files_number) : 0;
        $annotation_cost = isset($this->g_configs['general']['cost_of_annotation_for_one_file']) ? floatval($this->g_configs['general']['cost_of_annotation_for_one_file']) * intval($annotated_files_number) : 0;
        $review_cost = isset($this->g_configs['general']['cost_of_review_for_one_file']) ? floatval($this->g_configs['general']['cost_of_review_for_one_file']) * intval($reviewed_files_number) : 0;
        $total_cost = $classification_cost + $annotation_cost + $review_cost;

        $this->set(compact('classification_cost', 'annotation_cost', 'review_cost', 'total_cost'));
        // }

        $this->__common();
        $this->set(compact('parameters'));
    }



    public function teamReporting()
    {
        // Configure::write('debug', true);
        if ($this->authCom && !empty($this->Auth->user())) {
            $current_user = $this->Auth->user();
        } else {
            die("No Permissions");
        }

        $this->loadModel("FileLogs");
        $conditions = $this->_filter_params(false, "team_reports_filters");
        $parameters = $this->request->getAttribute('params');

        if (!empty($conditions['FileLogs.admin_id in'])) {
            $admin_ids = json_encode($conditions['FileLogs.admin_id in']);
            $this->set("admin_ids", $admin_ids);
        }

        if (!empty($parameters["?"])) {
            // print_r($conditions);
            $this->paginate = array('limit' => 50);

            $task_to_show = 'all';
            $conditions['FileLogs.status in'] = [2, 3, 4, 6, 7, 9, 10];
            // if(empty($conditions['FileLogs.status'])){
            //     $conditions['FileLogs.status in'] = [2,3,4,6,7,9,10];
            // }else{
            //     if($conditions['FileLogs.status']=='100'){
            //         $conditions['FileLogs.status in'] = [2,3,4];
            //         $task_to_show = '100';
            //     }elseif($conditions['FileLogs.status']=='101'){
            //         $conditions['FileLogs.status in'] = [6,7];
            //         $task_to_show = '101';
            //     }elseif($conditions['FileLogs.status']=='102'){
            //         $conditions['FileLogs.status in'] = [9,10];
            //         $task_to_show = '102';
            //     }
            // }
            // unset($conditions['FileLogs.status']);
            $this->set(compact('task_to_show'));

            //*************************************
            $this->loadModel("Admins");
            $admins = $this->Admins->find('list', [
                'keyField' => 'id', 'valueField' => 'name'
            ])->where(["super_admin is" => null])->toArray();

            $query = $this->FileLogs->find();
            $all_files_count = $query->select(['files_count' => $query->func()->count('id'), 'status', 'admin_id'])
                ->where($conditions)
                ->group(['status', 'admin_id'])
                // ->order([$sort => $dir])
                ->all()->toArray();
            $team_report_data = [];
            foreach ($all_files_count as $key => $value) {
                if (empty($classification_count[$value->admin_id])) {
                    $classification_count[$value->admin_id] = 0;
                }
                if (empty($annotation_count[$value->admin_id])) {
                    $annotation_count[$value->admin_id] = 0;
                }
                if (empty($review_count[$value->admin_id])) {
                    $review_count[$value->admin_id] = 0;
                }
                if (in_array($value->status, $this->FileLogs->classification_status)) {
                    $classification_count[$value->admin_id] += $value->files_count;
                } elseif (in_array($value->status, $this->FileLogs->annotation_status)) {
                    $annotation_count[$value->admin_id] += $value->files_count;
                } elseif (in_array($value->status, $this->FileLogs->review_status)) {
                    $review_count[$value->admin_id] += $value->files_count;
                }
                $team_report_data[$value->admin_id] = [
                    'user' => $admins[$value->admin_id],
                    'classification' => $classification_count[$value->admin_id],
                    'annotation' => $annotation_count[$value->admin_id],
                    'review' => $review_count[$value->admin_id],
                ];
            }
            //*************************************
            // print_r($team_report_data);die;
            $this->set(compact('team_report_data'));


            // $conditions['FileLogs.admin_id'] = $current_user['id'];
            $files = $this->paginate($this->FileLogs, [
                'conditions' => $conditions,
                'group' => ["FileLogs.file_id", "FileLogs.status"],
            ]);
            $this->set(compact('files'));

            //get total classified files for this user
            $classifications_conditions = $conditions;
            $classifications_conditions['FileLogs.status in'] = [2, 3, 4];
            $q = $this->FileLogs->find();
            $classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
                ->where($classifications_conditions)
                // ->group(["FileLogs.file_id","FileLogs.status"])
                ->all()->toArray();
            $classified_files_number = $classified_files_number_obj[0]->files_count;
            $this->set("classified_files_number", $classified_files_number);

            //get total annotated files for this user
            $annotations_conditions = $conditions;
            $annotations_conditions['FileLogs.status in'] = [6, 7];
            $q = $this->FileLogs->find();
            $annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
                ->where($annotations_conditions)
                ->all()->toArray();
            $annotated_files_number = $annotated_files_number_obj[0]->files_count;
            $this->set("annotated_files_number", $annotated_files_number);

            //get total reviewed files for this user
            $reviews_conditions = $conditions;
            $reviews_conditions['FileLogs.status in'] = [9, 10];
            $q = $this->FileLogs->find();
            $reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id')])
                ->where($reviews_conditions)
                ->all()->toArray();
            $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
            $this->set("reviewed_files_number", $reviewed_files_number);

            $classification_cost = isset($this->g_configs['general']['cost_of_classification_for_one_file']) ? floatval($this->g_configs['general']['cost_of_classification_for_one_file']) * intval($classified_files_number) : 0;
        $annotation_cost = isset($this->g_configs['general']['cost_of_annotation_for_one_file']) ? floatval($this->g_configs['general']['cost_of_annotation_for_one_file']) * intval($annotated_files_number) : 0;
        $review_cost = isset($this->g_configs['general']['cost_of_review_for_one_file']) ? floatval($this->g_configs['general']['cost_of_review_for_one_file']) * intval($reviewed_files_number) : 0;

            $total_cost = $classification_cost + $annotation_cost + $review_cost;

            $this->set(compact('classification_cost', 'annotation_cost', 'review_cost', 'total_cost'));
        }

        $this->__common();
        $this->set(compact('parameters'));
    }



    protected function __common()
    {
        $this->loadModel("Admins");
        $admins = $this->Admins->find('list', [
            'keyField' => 'id', 'valueField' => 'name'
        ])->where(["super_admin is" => null])->toArray();
        $this->set("admins", $admins);

        // $this->loadModel("Files");
        // $admins = $this->Files->find('list', [
        //     'keyField' => 'id', 'valueField' => 'file'
        // ])->where(["super_admin is"=>null])->toArray();
        // $this->set("admins",$admins);

        $status_tasks = $this->FileLogs->status_tasks;
        $this->set("status_tasks", $status_tasks);

        $tasks_codes = $this->FileLogs->tasks_codes;
        $this->set("statuses", $tasks_codes);
    }



    public function timeline()
    {
        // Configure::write('debug', true);
        $dir = "asc";
        $sort = "cdate";

        if ($this->authCom && !empty($this->Auth->user())) {
            $current_user = $this->Auth->user();
        } else {
            die("No Permissions");
        }

        $conditions = $this->_filter_params(false, "timeline_reports_filters");
        $parameters = $this->request->getAttribute('params');

        if (!empty($conditions['FileLogs.admin_id in'])) {
            $admin_ids = json_encode($conditions['FileLogs.admin_id in']);
            $this->set("admin_ids", $admin_ids);
        }

        $task_to_show = 'all';
        if (empty($conditions['FileLogs.status'])) {
            $cond1 = $conditions;
            $cond2 = $conditions;
            $cond3 = $conditions;
            //Classification
            $cond1['FileLogs.status in'] = [2, 3, 4];
            //Annotation
            $cond2['FileLogs.status in'] = [6, 7];
            //Review
            $cond3['FileLogs.status in'] = [9, 10];
            //All
            $conditions['FileLogs.status in'] = [2, 3, 4, 6, 7, 9, 10];
        } else {
            if ($conditions['FileLogs.status'] == '100') {
                $conditions['FileLogs.status in'] = [2, 3, 4];
                $task_to_show = '100';
                $chart_color = '#007bff';
            } elseif ($conditions['FileLogs.status'] == '101') {
                $conditions['FileLogs.status in'] = [6, 7];
                $task_to_show = '101';
                $chart_color = '#dc3545';
            } elseif ($conditions['FileLogs.status'] == '102') {
                $conditions['FileLogs.status in'] = [9, 10];
                $task_to_show = '102';
                $chart_color = '#28a745';
            }
            unset($conditions['FileLogs.status']);
        }
        $this->set(compact('task_to_show'));

        //Sort
        if (!empty($parameters["?"])) {
            if (!empty($parameters["?"]['sort'])) {
                $sort = test_input($parameters["?"]['sort']);
            }
            if (!empty($parameters["?"]['dir'])) {
                $dir = test_input($parameters["?"]['dir']);
            } else {
                $dir = "asc";
            }
        }

        //**** Files per day query ****
        if ($task_to_show == 'all') {
            //All
            $query = $this->FileLogs->find();
            $files_count_per_day = $query->select(['files_count' => $query->func()->count('id'), 'cdate' => 'DATE(created)'])
                ->where($conditions)
                ->group('cdate')
                ->order([$sort => $dir])
                ->all()->toArray();
            $x_axis_data = [];
            foreach ($files_count_per_day as $k1 => $v) {
                $x_axis_data[] = $v->cdate;
            }
            $this->set("x_axis_data", json_encode($x_axis_data));
            $this->set("files_count_per_day", $files_count_per_day);

            //Classification
            $query = $this->FileLogs->find();
            $files_count_per_day = $query->select(['files_count' => $query->func()->count('id'), 'cdate' => 'DATE(created)'])
                ->where($cond1)
                ->group('cdate')
                ->order([$sort => $dir])
                ->all()->toArray();
            $y_axis_data = [];
            foreach ($x_axis_data as $vv) {
                $y_axis_data[$vv] = 0;
            }
            foreach ($files_count_per_day as $k1 => $v) {
                $y_axis_data[$v->cdate] = $v->files_count;
            }
            $y_axis_data_params[] = [
                'type' => 'line',
                'data' => array_values($y_axis_data),
                'backgroundColor' => 'transparent',
                'borderColor' => '#007bff',
                'pointBorderColor' => '#007bff',
                'pointBackgroundColor' => '#007bff',
                'fill' => false
                // pointHoverBackgroundColor: '#007bff',
                // pointHoverBorderColor    : '#007bff'
            ];


            //Annotation
            $query = $this->FileLogs->find();
            $files_count_per_day = $query->select(['files_count' => $query->func()->count('id'), 'cdate' => 'DATE(created)'])
                ->where($cond2)
                ->group('cdate')
                ->order([$sort => $dir])
                ->all()->toArray();
            $y_axis_data = [];
            foreach ($x_axis_data as $vv) {
                $y_axis_data[$vv] = 0;
            }
            foreach ($files_count_per_day as $k1 => $v) {
                $y_axis_data[$v->cdate] = $v->files_count;
            }
            $y_axis_data_params[] = [
                'type' => 'line',
                'data' => array_values($y_axis_data),
                'backgroundColor' => 'transparent',
                'borderColor' => '#dc3545',
                'pointBorderColor' => '#dc3545',
                'pointBackgroundColor' => '#dc3545',
                'fill' => false
            ];



            //Review
            $query = $this->FileLogs->find();
            $files_count_per_day = $query->select(['files_count' => $query->func()->count('id'), 'cdate' => 'DATE(created)'])
                ->where($cond3)
                ->group('cdate')
                ->order([$sort => $dir])
                ->all()->toArray();
            $y_axis_data = [];
            foreach ($x_axis_data as $vv) {
                $y_axis_data[$vv] = 0;
            }
            foreach ($files_count_per_day as $k1 => $v) {
                $y_axis_data[$v->cdate] = $v->files_count;
            }
            $y_axis_data_params[] = [
                'type' => 'line',
                'data' => array_values($y_axis_data),
                'backgroundColor' => 'transparent',
                'borderColor' => '#28a745',
                'pointBorderColor' => '#28a745',
                'pointBackgroundColor' => '#28a745',
                'fill' => false
            ];
            $this->set("y_axis_data", json_encode($y_axis_data_params));
        } else {
            $query = $this->FileLogs->find();
            $files_count_per_day = $query->select(['files_count' => $query->func()->count('id'), 'cdate' => 'DATE(created)'])
                ->where($conditions)
                ->group('cdate')
                ->order([$sort => $dir])
                ->all()->toArray();
            $x_axis_data = [];
            $y_axis_data = [];
            foreach ($files_count_per_day as $k1 => $v) {
                $x_axis_data[] = $v->cdate;
                $y_axis_data[] = $v->files_count;
            }
            $y_axis_data_params = [
                [
                    'type' => 'line',
                    'data' => $y_axis_data,
                    'backgroundColor' => 'transparent',
                    'borderColor' => $chart_color,
                    'pointBorderColor' => $chart_color,
                    'pointBackgroundColor' => $chart_color,
                    'fill' => false
                ]
            ];
            $this->set("x_axis_data", json_encode($x_axis_data));
            $this->set("y_axis_data", json_encode($y_axis_data_params));
            $this->set("files_count_per_day", $files_count_per_day);
        }


        //**** Total files query ****
        $query2 = $this->FileLogs->find();
        $total_files_number_obj = $query2->select(['files_count' => $query2->func()->count('id')])
            ->where($conditions)
            ->all()->toArray();
        $this->set("total_files_number", $total_files_number_obj[0]->files_count);
        $this->set("suggestedMax", 5);

        //**** Export ****
        // if(!empty($req_data["export"]) && $req_data["export"]=="export" ){
        //     $this->autoLayout = $this->autoRender =  false;
        //     $array[] = array(
        //         __('Day'),
        //         __('Number of users')
        //     );
        //     foreach ($users_count_per_day as $key => $value) {
        //         $array[] = array(
        //             $value->cdate,
        //             $value->users_count
        //         );
        //     }
        //     $this->loadComponent('Csv');
        //     $this->Csv->download($array, 'users_per_day');
        // }

        // $user = $this->Users->newEmptyEntity();
        // $this->set(compact('user'));

        $this->__common();
        $this->set(compact('parameters'));

        $this->set("dir", $dir);
    }
}
