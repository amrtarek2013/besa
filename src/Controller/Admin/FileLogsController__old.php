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
   
    public function accounting(){
    	// Configure::write('debug', true);
    	$this->loadModel("FileLogs");
        $conditions = $this->_filter_params(false,"accounting_filters");
        $parameters = $this->request->getAttribute('params');
        if (!empty($parameters["?"])) {
        	
        	$this->paginate = array('limit' => 100);
        	$conditions['FileLogs.status in'] = [2,3,4,6,7,9,10];
        	$files = $this->paginate($this->FileLogs, [
        										'conditions' => $conditions,
        										'group' => ["FileLogs.file_id","FileLogs.status"],
        									]);
        	$this->set(compact('files'));

        	//get total classified files for this user
        	$classifications_conditions = $conditions;
        	$classifications_conditions['FileLogs.status in'] = [2,3,4];
        	$q = $this->FileLogs->find();
        	$classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
        							->where($classifications_conditions)
                                    // ->group(["FileLogs.file_id","FileLogs.status"])
                                    ->all()->toArray();
            $classified_files_number = $classified_files_number_obj[0]->files_count;
        	$this->set("classified_files_number",$classified_files_number);

        	//get total annotated files for this user
        	$annotations_conditions = $conditions;
        	$annotations_conditions['FileLogs.status in'] = [6,7];
        	$q = $this->FileLogs->find();
        	$annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
        							->where($annotations_conditions)
                                    ->all()->toArray();
            $annotated_files_number = $annotated_files_number_obj[0]->files_count;
        	$this->set("annotated_files_number",$annotated_files_number);

        	//get total reviewed files for this user
        	$reviews_conditions = $conditions;
        	$reviews_conditions['FileLogs.status in'] = [9,10];
        	$q = $this->FileLogs->find();
        	$reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
        							->where($reviews_conditions)
                                    ->all()->toArray();
            $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
        	$this->set("reviewed_files_number",$reviewed_files_number);

        	$classification_cost = floatval($this->g_configs['general']['cost_of_classification_for_one_file'])*intval($classified_files_number);
        	$annotation_cost = floatval($this->g_configs['general']['cost_of_annotation_for_one_file'])*intval($annotated_files_number);
        	$review_cost = floatval($this->g_configs['general']['cost_of_review_for_one_file'])*intval($reviewed_files_number);

        	$total_cost = $classification_cost + $annotation_cost + $review_cost;

        	$this->set(compact('classification_cost','annotation_cost','review_cost','total_cost'));
        }
                                    
        $this->__common();
        $this->set(compact('parameters'));

    }

    public function allAccounting(){
        // Configure::write('debug', true);
        $this->loadModel("FileLogs");
        $conditions = $this->_filter_params(false,"all_accounting_filters");
        $parameters = $this->request->getAttribute('params');
        if (!empty($parameters["?"])) {
            
            $this->paginate = array('limit' => 100);
            $conditions['FileLogs.status in'] = [2,3,4,6,7,9,10];
            $files = $this->paginate($this->FileLogs, [
                                                'conditions' => $conditions,
                                                'group' => ["FileLogs.file_id","FileLogs.status"],
                                            ]);
            $this->set(compact('files'));

            //get total classified files for this user
            $classifications_conditions = $conditions;
            $classifications_conditions['FileLogs.status in'] = [2,3,4];
            $q = $this->FileLogs->find();
            $classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
                                    ->where($classifications_conditions)
                                    // ->group(["FileLogs.file_id","FileLogs.status"])
                                    ->all()->toArray();
            $classified_files_number = $classified_files_number_obj[0]->files_count;
            $this->set("classified_files_number",$classified_files_number);

            //get total annotated files for this user
            $annotations_conditions = $conditions;
            $annotations_conditions['FileLogs.status in'] = [6,7];
            $q = $this->FileLogs->find();
            $annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
                                    ->where($annotations_conditions)
                                    ->all()->toArray();
            $annotated_files_number = $annotated_files_number_obj[0]->files_count;
            $this->set("annotated_files_number",$annotated_files_number);

            //get total reviewed files for this user
            $reviews_conditions = $conditions;
            $reviews_conditions['FileLogs.status in'] = [9,10];
            $q = $this->FileLogs->find();
            $reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
                                    ->where($reviews_conditions)
                                    ->all()->toArray();
            $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
            $this->set("reviewed_files_number",$reviewed_files_number);

            $classification_cost = floatval($this->g_configs['general']['cost_of_classification_for_one_file'])*intval($classified_files_number);
            $annotation_cost = floatval($this->g_configs['general']['cost_of_annotation_for_one_file'])*intval($annotated_files_number);
            $review_cost = floatval($this->g_configs['general']['cost_of_review_for_one_file'])*intval($reviewed_files_number);

            $total_cost = $classification_cost + $annotation_cost + $review_cost;

            $this->set(compact('classification_cost','annotation_cost','review_cost','total_cost'));
        }
                                    
        $this->__common();
        $this->set(compact('parameters'));

    }

    public function myWorkSummary(){
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        $this->loadModel("FileLogs");
        $conditions = $this->_filter_params(false,"all_accounting_filters");
        $parameters = $this->request->getAttribute('params');
        // if (!empty($parameters["?"])) {
            
            $this->paginate = array('limit' => 100);
            $conditions['FileLogs.status in'] = [2,3,4,6,7,9,10];
            $conditions['FileLogs.admin_id'] = $current_user['id'];
            $files = $this->paginate($this->FileLogs, [
                                                'conditions' => $conditions,
                                                'group' => ["FileLogs.file_id","FileLogs.status"],
                                            ]);
            $this->set(compact('files'));

            //get total classified files for this user
            $classifications_conditions = $conditions;
            $classifications_conditions['FileLogs.status in'] = [2,3,4];
            $q = $this->FileLogs->find();
            $classified_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
                                    ->where($classifications_conditions)
                                    // ->group(["FileLogs.file_id","FileLogs.status"])
                                    ->all()->toArray();
            $classified_files_number = $classified_files_number_obj[0]->files_count;
            $this->set("classified_files_number",$classified_files_number);

            //get total annotated files for this user
            $annotations_conditions = $conditions;
            $annotations_conditions['FileLogs.status in'] = [6,7];
            $q = $this->FileLogs->find();
            $annotated_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
                                    ->where($annotations_conditions)
                                    ->all()->toArray();
            $annotated_files_number = $annotated_files_number_obj[0]->files_count;
            $this->set("annotated_files_number",$annotated_files_number);

            //get total reviewed files for this user
            $reviews_conditions = $conditions;
            $reviews_conditions['FileLogs.status in'] = [9,10];
            $q = $this->FileLogs->find();
            $reviewed_files_number_obj = $q->select(['files_count' => $q->func()->count('id') ])
                                    ->where($reviews_conditions)
                                    ->all()->toArray();
            $reviewed_files_number = $reviewed_files_number_obj[0]->files_count;
            $this->set("reviewed_files_number",$reviewed_files_number);

            $classification_cost = floatval($this->g_configs['general']['cost_of_classification_for_one_file'])*intval($classified_files_number);
            $annotation_cost = floatval($this->g_configs['general']['cost_of_annotation_for_one_file'])*intval($annotated_files_number);
            $review_cost = floatval($this->g_configs['general']['cost_of_review_for_one_file'])*intval($reviewed_files_number);

            $total_cost = $classification_cost + $annotation_cost + $review_cost;

            $this->set(compact('classification_cost','annotation_cost','review_cost','total_cost'));
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
        $this->set(compact('parameters','files'));
    }

    

    
    protected function __common(){
        $this->loadModel("Admins");
        $admins = $this->Admins->find('list', [
            'keyField' => 'id', 'valueField' => 'name'
        ])->where(["super_admin is"=>null])->toArray();
        $this->set("admins",$admins);

        // $this->loadModel("Files");
        // $admins = $this->Files->find('list', [
        //     'keyField' => 'id', 'valueField' => 'file'
        // ])->where(["super_admin is"=>null])->toArray();
        // $this->set("admins",$admins);

        $status_tasks = $this->FileLogs->status_tasks;
        $this->set("status_tasks",$status_tasks);
    }


}
