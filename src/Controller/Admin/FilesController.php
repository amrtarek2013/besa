<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Http\ServerRequest;
use Cake\Core\Configure;
use Cake\View\View;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\FilesTable $Roles
 *
 * @method \App\Model\Entity\File[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
{

    public $paginate = [
        // 'limit' => 1,
        'order' => [
            'Files.created' => 'desc'
        ]
    ];

    /**
     * Index method
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        // $this->checkIfSuperadmin();

        $conditions = $this->_filter_params();
        $this->paginate = array('limit' => 100);
        $files = $this->paginate($this->Files, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters','files'));
    }

    public function classification()
    {
        // Configure::write('debug', true);
        $files_count = $this->g_configs['general']['txt.classification_files_count'];
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        $conditions = [];
        $conditions['classifier_id'] = $current_user['id'];
        $conditions['or']=['status'=>1,'classify_submit'=>0];
        $old_loaded_files = $this->Files->find()->where($conditions)->limit($files_count)->all()->toArray();
        $this->set("files_to_classify",$old_loaded_files);

        /*$not_done_count = intval($files_count);
        if(count($old_loaded_files)){
            $not_done_count = count($old_loaded_files);
        }
        $done_count = intval($files_count) - $not_done_count;
        $done_percentage = ($done_count / intval($files_count))*100;
        $this->set("done_percentage",$done_percentage);
        $this->set("done_count",$done_count);
        $this->set("files_count",$files_count);*/

        // progress bar-1
        $total_loaded_files = count($old_loaded_files);
        $this->set("total_loaded_files",$total_loaded_files);
        $total_done_count = 0;

        
        $playlist_menu_html = '';
        $highlighted_track = "highlighted_track";
        foreach ($old_loaded_files as $file_row) {
            $class_icon = "";
            if($file_row->status=="2"){
                $class_icon = "<i class='fas fa-check'></i>";
                $total_done_count++;
            }else if($file_row->status=="3"){
                $class_icon = "<i class='fas fa-ban'></i>";
                $total_done_count++;
            }else if($file_row->status=="4"){
                $class_icon = "<i class='fas fa-border-all'></i>";
                $total_done_count++;
            }
            $playlist_menu_html .='<a class="'.$highlighted_track.' playlist_item playlist_item_'.$file_row->id.'" data-file-id="'.$file_row->id.'" data-fname="'.$file_row->file.'" href="#">'.$file_row->file.$class_icon.'</a>';
            $highlighted_track="";
        }
        $this->set("playlist_menu_html",$playlist_menu_html);

        // progress bar-2
        $this->set("total_done_count",$total_done_count);
        $done_percentage = ($total_done_count / intval($total_loaded_files))*100;
        $this->set("done_percentage",$done_percentage);

    }

    
    public function loadFilesClassification()
    {
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        $this->autoRender = false;
        $files_count = $this->g_configs['general']['txt.classification_files_count'];
        $new_load_count = 0;
        $new_loaded_files = [];

        // get old loaded files
        $conditions = [];
        $conditions['status'] = 1;
        $conditions['classifier_id'] = $current_user['id'];
        $old_loaded_files = $this->Files->find()->where($conditions)->limit($files_count)->all()->toArray();

        if(count($old_loaded_files)<$files_count){
            $new_load_count = intval($files_count) - count($old_loaded_files);
        }
        $selector = 'fifo';
        if(!empty($this->g_configs['general']['txt.selector_mechanism'])){
            $selector = $this->g_configs['general']['txt.selector_mechanism'];
        }
        if($new_load_count){
            // $conditions = [];
            // // $conditions['status'] = 0;
            // $conditions['or']['classifier_id is '] = null;
            // $conditions['or']['classifier_id'] = $current_user['id'];
            // $conditions[]['or']=['status'=>0,'classify_submit'=>0];
            // $new_loaded_files = $this->Files->find()->where($conditions)->limit($new_load_count)->all()->toArray();

            // Selectors
            if($selector=='lifo'){
                $conditions = [];
                $conditions['or']['classifier_id is '] = null;
                $conditions['or']['classifier_id'] = $current_user['id'];
                $conditions[]['or']=['status'=>0,'classify_submit'=>0];
                $new_loaded_files = $this->Files->find()->where($conditions)->limit($new_load_count)->order(['Files.created' => 'desc'])->all()->toArray();
            }else{
                $conditions = [];
                $conditions['or']['classifier_id is '] = null;
                $conditions['or']['classifier_id'] = $current_user['id'];
                $conditions[]['or']=['status'=>0,'classify_submit'=>0];
                $new_loaded_files = $this->Files->find()->where($conditions)->limit($new_load_count)->order(['Files.created' => 'asc'])->all()->toArray();
            }
        }
        $files_to_classify = array_merge($old_loaded_files,$new_loaded_files);
        
        $files_ids = [];
        if(!empty($files_to_classify)){
            foreach ($files_to_classify as $key => $value) {
                $files_ids[] = $value->id;
            }
        }
        if(true && !empty($files_ids)){
            $this->Files->updateAll(
                [  // fields
                    'classifier_id' => $current_user['id'],
                    'status' => 1
                ],
                [  // conditions
                    'Files.id IN' => $files_ids
                ]
            );
        }
        if(empty($files_to_classify)){
            $response->error_msg = __("No files to load");
            $response->status = 0;
        }else{
            $playlist_menu_html = '';
            $highlighted_track = 'highlighted_track';
            foreach ($files_to_classify as $file_row) {
                $playlist_menu_html .='<a class="'.$highlighted_track.' playlist_item playlist_item_'.$file_row->id.'" data-file-id="'.$file_row->id.'" data-fname="'.$file_row->file.'" href="#">'.$file_row->file.'</a>';
                $highlighted_track = '';
            }
            $progress_html = '<div class="skill">
                <p>Submission Progress</p>
                <div class="skill-bar skill3" style="width: 0%">
                    <span class="skill-count3">0%</span>
                </div>
            </div>
            <p>You submitted (0) files from ('.$files_count.') loaded files.</p>';

            $view = new View(null, null);
            $view->set(compact('files_to_classify'));            
            $view->set("playlist_menu_html",$playlist_menu_html);            
            

            $html = stripcslashes( stripslashes( $view->render('Admin/Files/classification_boxes', FALSE) ) );
            $response->html = $html;
            $response->status = 1;
            $response->playlist_menu = $playlist_menu_html;
            $response->progress_html = $progress_html;
        }

        echo json_encode($response);
        die();
    }

    public function classify(){
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        if ($this->request->is('post')) {
            $req_data = $this->request->getData();
            if(empty($req_data['classification_type']) || empty($req_data['file_id']) ){
                $this->__invalid_request();
            }
            $selected_file = $this->Files->get($req_data['file_id']);
            if($selected_file->classifier_id!=$current_user['id']){
                $this->__invalid_request();
            }

            $classification_status = $this->Files->classification_status[$req_data['classification_type']];
            if(!empty($classification_status)){
                $selected_file->status = $classification_status;
                if($this->Files->save($selected_file)){
                    
                    // $log_data = ["file_id"=>$selected_file->id,
                    //              "admin_id"=>$current_user['id'],
                    //              "status"=>$classification_status];
                    // $this->__insert_file_log($log_data);

                    $response->status = 1;
                    echo json_encode($response);
                    die();
                }else{
                    $this->__cant_save_request();
                }
            }
        }
        echo "done";die();
    }

    public function submitClassifiedFiles(){
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }
        if ($this->request->is('post')) {
            $req_data = $this->request->getData();
            
            if(!empty($req_data['classified_data'])){
                foreach ($req_data['classified_data'] as $file_id => $classification) {
                    if(!empty($file_id) && !empty($classification)){
                        $classification_status = $this->Files->classification_status[$classification];
                        $this->Files->updateAll(
                            [  // fields
                                'status' => $classification_status,
                                'classify_submit' => 1
                            ],
                            [  // conditions
                                'Files.id' => $file_id
                            ]
                        );
                        $selected_file = $this->Files->get($file_id);
                        $log_data = ["file_id"=>$file_id,
                                 "admin_id"=>$current_user['id'],
                                 "file_name"=>$selected_file->file,
                                 "status"=>$classification_status];
                        $this->__insert_file_log($log_data);

                    }
                }
                $response->status = 1;
                echo json_encode($response);
                die();
            }
        }
        $response->status = 0;
        echo json_encode($response);
        die();
    }
    //////////////////// Annotation ////////////////////
    public function annotation()
    {
        $files_count = $this->g_configs['general']['txt.annotation_files_count'];
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        $conditions = [];
        $conditions['annotator_id'] = $current_user['id'];
        $conditions['or']=['status'=>5,'annotate_submit'=>0];

        $old_loaded_files = $this->Files->find()->where($conditions)->limit($files_count)->all()->toArray();
        $this->set("files_to_annotate",$old_loaded_files);

        // progress bar data
        /*$not_done_count = intval($files_count);
        if(count($old_loaded_files)){
            $not_done_count = count($old_loaded_files);
        }
        $done_count = intval($files_count) - $not_done_count;
        $done_percentage = ($done_count / intval($files_count))*100;
        $this->set("done_percentage",$done_percentage);
        $this->set("done_count",$done_count);
        $this->set("files_count",$files_count);*/

        // progress bar-1
        $total_loaded_files = count($old_loaded_files);
        $this->set("total_loaded_files",$total_loaded_files);
        $total_done_count = 0;

        // side menu
        $playlist_menu_html = '';
        $highlighted_track = "highlighted_track";
        foreach ($old_loaded_files as $file_row) {
            $class_icon = "";
            if($file_row->status=="6"){
                $class_icon = "<i class='fas fa-check'></i>";
                $total_done_count++;
            }
            $playlist_menu_html .='<a class="'.$highlighted_track.' playlist_item playlist_item_'.$file_row->id.'" data-file-id="'.$file_row->id.'" data-fname="'.$file_row->file.'" href="#">'.$file_row->file.$class_icon.'</a>';
            $highlighted_track = "";
        }
        $this->set("playlist_menu_html",$playlist_menu_html);

        // progress bar-2
        $this->set("total_done_count",$total_done_count);
        $done_percentage = ($total_done_count / intval($total_loaded_files))*100;
        $this->set("done_percentage",$done_percentage);

    }
    public function annotate(){
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        if ($this->request->is('post')) {
            $req_data = $this->request->getData();
            if(empty($req_data['annotation_type']) || empty($req_data['file_id']) || empty($req_data['annotation_note']) ){
                $this->__invalid_request();
            }
            $selected_file = $this->Files->get($req_data['file_id']);
            if($selected_file->annotator_id!=$current_user['id']){
                $this->__invalid_request();
            }

            $annotation_status = $this->Files->annotation_status[$req_data['annotation_type']];
            $annotation_note = gr_clean_text($req_data['annotation_note']);
            if(!empty($annotation_status)){
                $selected_file->status = $annotation_status;
                $selected_file->annotation_note = $annotation_note;
                if($this->Files->save($selected_file)){
                    // $log_data = ["file_id"=>$selected_file->id,
                    //              "admin_id"=>$current_user['id'],
                    //              "annotation_note"=>$annotation_note,
                    //              "status"=>$annotation_status];
                    // $this->__insert_file_log($log_data);

                    $response->status = 1;
                    echo json_encode($response);
                    die();
                }else{
                    $this->__cant_save_request();
                }
            }
        }
        echo "done";die();
    }
    public function loadFilesAnnotation()
    {
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        $this->autoRender = false;
        $files_count = $this->g_configs['general']['txt.annotation_files_count'];
        $new_load_count = 0;
        $new_loaded_files = [];

        // get old loaded files
        $conditions = [];
        // $conditions['status'] = 5;
        $conditions['annotator_id'] = $current_user['id'];
        $conditions['or']=['status'=>5,'annotate_submit'=>0];
        $old_loaded_files = $this->Files->find()->where($conditions)->limit($files_count)->all()->toArray();

        if(count($old_loaded_files)<$files_count){
            $new_load_count = intval($files_count) - count($old_loaded_files);
        }
        if($new_load_count){
            $conditions = [];
            $conditions['status'] = 2;
            $conditions['classify_submit'] = 1;
            $conditions['or']['annotator_id is '] = null;
            $conditions['or']['annotator_id'] = $current_user['id'];
            $new_loaded_files = $this->Files->find()->where($conditions)->limit($new_load_count)->all()->toArray();
        }
        $files_to_annotate = array_merge($old_loaded_files,$new_loaded_files);
        
        $files_ids = [];
        if(!empty($files_to_annotate)){
            foreach ($files_to_annotate as $key => $value) {
                $files_ids[] = $value->id;
            }
        }
        if(true && !empty($files_ids)){
            $this->Files->updateAll(
                [  // fields
                    'annotator_id' => $current_user['id'],
                    'status' => 5
                ],
                [  // conditions
                    'Files.id IN' => $files_ids
                ]
            );
        }
        if(empty($files_to_annotate)){
            $response->error_msg = __("No files to load");
            $response->status = 0;
        }else{
            $playlist_menu_html = '';
            $highlighted_track = 'highlighted_track';
            foreach ($files_to_annotate as $file_row) {
                $playlist_menu_html .='<a class="'.$highlighted_track.' playlist_item playlist_item_'.$file_row->id.'" data-file-id="'.$file_row->id.'" data-fname="'.$file_row->file.'" href="#">'.$file_row->file.'</a>';
                $highlighted_track = '';
            }
            $progress_html = '<div class="skill">
                <p>Submission Progress</p>
                <div class="skill-bar skill3" style="width: 0%">
                    <span class="skill-count3">0%</span>
                </div>
            </div>
            <p>You submitted (0) files from ('.$files_count.') loaded files.</p>';

            $view = new View(null, null);
            $view->set(compact('files_to_annotate'));            
            $view->set("playlist_menu_html",$playlist_menu_html); 

            

            $html = stripcslashes( stripslashes( $view->render('Admin/Files/annotation_boxes', FALSE) ) );
            $response->html = $html;
            $response->status = 1;
            $response->playlist_menu = $playlist_menu_html;
            $response->progress_html = $progress_html;
        }

        echo json_encode($response);
        die();
    }

    public function submitAnnotatedFiles(){
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }
        if ($this->request->is('post')) {
            $req_data = $this->request->getData();
            
            if(!empty($req_data['annotated_data'])){
                foreach ($req_data['annotated_data'] as $file_id => $annotation) {
                    if(!empty($file_id) && !empty($annotation)){
                        $annotation_status = $this->Files->annotation_status["1"];
                        $this->Files->updateAll(
                            [  // fields
                                'status' => $annotation_status,
                                'annotate_submit' => 1
                            ],
                            [  // conditions
                                'Files.id' => $file_id
                            ]
                        );
                        $selected_file = $this->Files->get($file_id);
                        $log_data = ["file_id"=>$file_id,
                                 "admin_id"=>$current_user['id'],
                                 "annotation_note"=>$selected_file->annotation_note,
                                 "file_name"=>$selected_file->file,
                                 "status"=>$annotation_status];
                        $this->__insert_file_log($log_data);
                    }
                }
                $response->status = 1;
                echo json_encode($response);
                die();
            }
        }
        $response->status = 0;
        echo json_encode($response);
        die();
    }





    //////////////////// review ////////////////////
    public function review()
    {
        // Configure::write('debug', true);
        $files_count = $this->g_configs['general']['txt.review_files_count'];
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        $conditions = [];
        $conditions['reviewer_id'] = $current_user['id'];
        $conditions['or']=['status'=>8,'review_submit'=>0];
        $old_loaded_files = $this->Files->find()->where($conditions)->limit($files_count)->all()->toArray();
        $this->set("files_to_review",$old_loaded_files);

        // progress bar data
        /*$not_done_count = intval($files_count);
        if(count($old_loaded_files)){
            $not_done_count = count($old_loaded_files);
        }
        $done_count = intval($files_count) - $not_done_count;
        $done_percentage = ($done_count / intval($files_count))*100;
        $this->set("done_percentage",$done_percentage);
        $this->set("done_count",$done_count);
        $this->set("files_count",$files_count);*/

        // progress bar-1
        $total_loaded_files = count($old_loaded_files);
        $this->set("total_loaded_files",$total_loaded_files);
        $total_done_count = 0;

        // side menu
        $playlist_menu_html = '';
        $highlighted_track = "highlighted_track";
        foreach ($old_loaded_files as $file_row) {
            $class_icon = "";
            if($file_row->status=="9"){
                $class_icon = "<i class='fas fa-check'></i>";
                $total_done_count++;
            }
            $playlist_menu_html .='<a class="'.$highlighted_track.' playlist_item playlist_item_'.$file_row->id.'" data-file-id="'.$file_row->id.'" data-fname="'.$file_row->file.'" href="#">'.$file_row->file.$class_icon.'</a>';
            $highlighted_track="";
        }
        $this->set("playlist_menu_html",$playlist_menu_html);

        // progress bar-2
        $this->set("total_done_count",$total_done_count);
        $done_percentage = ($total_done_count / intval($total_loaded_files))*100;
        $this->set("done_percentage",$done_percentage);

    }
    public function doReview(){
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        if ($this->request->is('post')) {
            $req_data = $this->request->getData();
            if(empty($req_data['review_type']) || empty($req_data['file_id']) || empty($req_data['review_note']) ){
                $this->__invalid_request();
            }
            $selected_file = $this->Files->get($req_data['file_id']);
            if($selected_file->reviewer_id!=$current_user['id']){
                $this->__invalid_request();
            }

            $review_status = $this->Files->review_status[$req_data['review_type']];
            $review_note = gr_clean_text($req_data['review_note']);
            $annotation_note = gr_clean_text($req_data['annotation_note']);
            if(!empty($review_status)){
                $selected_file->status = $review_status;
                $selected_file->review_note = $review_note;
                $selected_file->annotation_note = $annotation_note;
                if($this->Files->save($selected_file)){
                    
                    // $log_data = ["file_id"=>$selected_file->id,
                    //              "admin_id"=>$current_user['id'],
                    //              "review_note"=>$review_note,
                    //              "annotation_note"=>$annotation_note,
                    //              "status"=>$review_status];
                    // $this->__insert_file_log($log_data);

                    $response->status = 1;
                    echo json_encode($response);
                    die();
                }else{
                    $this->__cant_save_request();
                }
            }
        }
        echo "done";die();
    }

    public function loadFilesReview()
    {
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }

        $this->autoRender = false;
        $files_count = $this->g_configs['general']['txt.review_files_count'];
        $new_load_count = 0;
        $new_loaded_files = [];

        // get old loaded files
        $conditions = [];
        // $conditions['status'] = 8;
        $conditions['reviewer_id'] = $current_user['id'];
        $conditions['or']=['status'=>8,'review_submit'=>0];
        $old_loaded_files = $this->Files->find()->where($conditions)->limit($files_count)->all()->toArray();

        if(count($old_loaded_files)<$files_count){
            $new_load_count = intval($files_count) - count($old_loaded_files);
        }
        if($new_load_count){
            $conditions = [];
            $conditions['status'] = 6;
            $conditions['annotate_submit'] = 1;
            $conditions['or']['reviewer_id is '] = null;
            $conditions['or']['reviewer_id'] = $current_user['id'];
            $new_loaded_files = $this->Files->find()->where($conditions)->limit($new_load_count)->all()->toArray();
        }
        $files_to_review = array_merge($old_loaded_files,$new_loaded_files);
        
        $files_ids = [];
        if(!empty($files_to_review)){
            foreach ($files_to_review as $key => $value) {
                $files_ids[] = $value->id;
            }
        }
        if(true && !empty($files_ids)){
            $this->Files->updateAll(
                [  // fields
                    'reviewer_id' => $current_user['id'],
                    'status' => 8
                ],
                [  // conditions
                    'Files.id IN' => $files_ids
                ]
            );
        }
        if(empty($files_to_review)){
            $response->error_msg = __("No files to load");
            $response->status = 0;
        }else{
            $playlist_menu_html = '';
            $highlighted_track = 'highlighted_track';
            foreach ($files_to_review as $file_row) {
                $playlist_menu_html .='<a class="'.$highlighted_track.' playlist_item playlist_item_'.$file_row->id.'" data-file-id="'.$file_row->id.'" data-fname="'.$file_row->file.'" href="#">'.$file_row->file.'</a>';
                $highlighted_track = '';
            }
            $progress_html = '<div class="skill">
                <p>Submission Progress</p>
                <div class="skill-bar skill3" style="width: 0%">
                    <span class="skill-count3">0%</span>
                </div>
            </div>
            <p>You submitted (0) files from ('.$files_count.') loaded files.</p>';

            $view = new View(null, null);
            $view->set(compact('files_to_review'));            
            $view->set("playlist_menu_html",$playlist_menu_html); 


            $html = stripcslashes( stripslashes( $view->render('Admin/Files/review_boxes', FALSE) ) );
            $response->html = $html;
            $response->status = 1;
            $response->playlist_menu = $playlist_menu_html;
            $response->progress_html = $progress_html;
        }

        echo json_encode($response);
        die();
    }

    public function submitReviewedFiles(){
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }
        if ($this->request->is('post')) {
            $req_data = $this->request->getData();
            
            if(!empty($req_data['reviewed_data'])){
                foreach ($req_data['reviewed_data'] as $file_id => $review) {
                    if(!empty($file_id) && !empty($review)){
                        $review_status = $this->Files->review_status["1"];
                        $this->Files->updateAll(
                            [  // fields
                                'status' => $review_status,
                                'review_submit' => 1
                            ],
                            [  // conditions
                                'Files.id' => $file_id
                            ]
                        );

                        $selected_file = $this->Files->get($file_id);
                        $log_data = ["file_id"=>$file_id,
                                 "admin_id"=>$current_user['id'],
                                 "review_note"=>$selected_file->review_note,
                                 "annotation_note"=>$selected_file->annotation_note,
                                 "file_name"=>$selected_file->file,
                                 "status"=>$review_status];
                        $this->__insert_file_log($log_data);
                    }
                }
                $response->status = 1;
                echo json_encode($response);
                die();
            }
        }
        $response->status = 0;
        echo json_encode($response);
        die();
    }




    protected function __invalid_request(){
        $response->error_msg = __("Invalid Request");
        $response->status = 0;
        echo json_encode($response);
        die();
    }

    protected function __cant_save_request(){
        $response->error_msg = __("The system can not save your request, pls contact your administrator. ");
        $response->status = 0;
        echo json_encode($response);
        die();
    }


    public function classified()
    {
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }
        
        // $this->loadModel("RolesPermissions");
        // $role_permission_row = $this->RolesPermissions->find()->where(['role_id'=>$current_user["role_id"],'permission_id'=>34])->first();
        // if(empty($role_permission_row)){
        //     die("No Permissions");
        // }
        $this->loadModel("FileLogs");
        $log_conds["admin_id"] = $current_user["id"];
        $log_conds["status IN"] = [2,3,4];
        $classified_files_logs = $this->FileLogs->find()->where($log_conds)->all()->toArray();
        $required_files_ids = [];
        if(!empty($classified_files_logs)){
            foreach ($classified_files_logs as $log_row) {
                $required_files_ids[] = $log_row->file_id;
            }
        }

        $conditions = $this->_filter_params();
        if(!empty($required_files_ids)){
            $conditions["id in"]=$required_files_ids;
        }else{
            $conditions["id"]=0;
        }
        $this->paginate = array('limit' => 100);
        $files = $this->paginate($this->Files, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters','files'));
        $this->__common();
    }
    public function annotated()
    {
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }
        
        $this->loadModel("FileLogs");
        $log_conds["admin_id"] = $current_user["id"];
        $log_conds["status IN"] = [6,7];
        $files_logs = $this->FileLogs->find()->where($log_conds)->all()->toArray();
        $required_files_ids = [];
        if(!empty($files_logs)){
            foreach ($files_logs as $log_row) {
                $required_files_ids[] = $log_row->file_id;
            }
        }

        $conditions = $this->_filter_params();
        if(!empty($required_files_ids)){
            $conditions["id in"]=$required_files_ids;
        }else{
            $conditions["id"]=0;
        }
        $this->paginate = array('limit' => 100);
        $files = $this->paginate($this->Files, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters','files'));
        $this->__common();
    }
    public function reviewed()
    {
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }
        
        $this->loadModel("FileLogs");
        $log_conds["admin_id"] = $current_user["id"];
        $log_conds["status IN"] = [9,10];
        $files_logs = $this->FileLogs->find()->where($log_conds)->all()->toArray();
        $required_files_ids = [];
        if(!empty($files_logs)){
            foreach ($files_logs as $log_row) {
                $required_files_ids[] = $log_row->file_id;
            }
        }
        // print_r($required_files_ids);die;
        if(empty($required_files_ids)){
            $required_files_ids = [0];
        }
        $conditions = $this->_filter_params();
        if(!empty($required_files_ids)){
            $conditions["id in"]=$required_files_ids;
        }else{
            $conditions["id"]=0;
        }
        $this->paginate = array('limit' => 100);
        $files = $this->paginate($this->Files, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters','files'));
        $this->__common();
    }


    public function cronZipDailyFiles(){
        // Configure::write('debug', true);
        // mail("eng.karimgamal90@gmail.com","My subject","Test");
        // die;
        // echo $_SERVER["SCRIPT_FILENAME"];die;
        //Search for all files not zipped - compressed=0
        $conds = [];
        $conds["compressed"] = 0;
        $conds["status"] = 9;
        $files_list = $this->Files->find()->where($conds)->all()->toArray();

        // zip files and
        $files_list_to_zip = [];
        $upload_path = str_replace('webroot/index.php', '', $_SERVER["SCRIPT_FILENAME"]);
        $upload_path .='webroot/uploads/';
        foreach ($files_list as $key => $value) {
            if(!empty($value->file) && file_exists($upload_path.'files/'.$value->file)){
                $files_list_to_zip[$value->id] = $value->file;
            }
        }
        $zipped_file_name = $this->_zip_files_for_release($files_list_to_zip);

        // change files status to compredded
        if(!empty($zipped_file_name)){
            $this->Files->updateAll(
                    [  // fields
                        'compressed' => 1
                    ],
                    [  // conditions
                        'Files.id IN' => array_keys($files_list_to_zip)
                    ]
                );
            
            //Add release info to DB
            $this->loadModel("Releases");
            $rel_data = ["zip_file"=>$zipped_file_name];
            $release = $this->Releases->newEmptyEntity();
            $release = $this->Releases->patchEntity($release, $rel_data);
            if ($this->Releases->save($release)) {
                // isnert files log
                foreach ($files_list_to_zip as $key => $value) {
                    $log_data = ["file_id"=>$key,
                                 "admin_id"=>0,
                                 "status"=>11,
                                 "release_id"=>$release->id,
                                ];
                    $this->__insert_file_log($log_data);
                }
            }

        }
        die("Done");


    }
    


    public function logs($file_id){
        // Configure::write('debug', true);
        if($this->authCom && !empty($this->Auth->user())){
            $current_user = $this->Auth->user();
        }else{
            die("No Permissions");
        }
            
        if(empty($file_id)){
            die("Invalid Request");
        }
        $selected_file = $this->Files->get($file_id);

        $this->loadModel("FileLogs");
        $log_conds["FileLogs.file_id"] = $file_id;
        $logs = $this->FileLogs->find()->where($log_conds)->all()->toArray();
        // print_r($logs);die;
        $this->set(compact('selected_file','logs'));
        $this->__common();
    }

    public function generateDemoFiles(){
        // die("--");
        // Configure::write('debug', true);
        $upload_path = str_replace('webroot/index.php', '', $_SERVER["SCRIPT_FILENAME"]);
        $upload_path .='webroot/uploads/files/';

        if ($this->request->is('post')) {
            $req_data = $this->request->getData();
            $number_of_files = intval($req_data['number_of_files']);
            if($number_of_files>0){
                for ($i=0; $i < $number_of_files; $i++) { 
                    $file_name = "file_".time()."_".rand(1,2000).".mp3";
                    $file_data["file"] = $file_name;
                    
                    $file = $this->Files->newEmptyEntity();
                    $file = $this->Files->patchEntity($file, $file_data);
                    if (copy($upload_path."file1.mp3",$upload_path.$file_name)) {
                        $this->Files->save($file);
                    }
                }
            }
            $this->Flash->success(__('Files generated successfully.'));
            return $this->redirect(['action' => 'generateDemoFiles']);
        }
    }

    public function importWorkFiles(){
        Configure::write('debug', true);
        if ($this->request->is('post')) {
            $req_data = $this->request->getData();
            if(!empty($req_data['import_latest_files']) && $req_data['import_latest_files']==1){
                // Read the import files list
                $this->loadModel('FileImports');
                $imported_files = $this->FileImports->find('list', [
                    'keyField' => 'id', 'valueField' => 'file_name'
                ])->toArray();

                // Loop on the new zip files
                $data_source_path = str_replace('webroot/index.php', '', $_SERVER["SCRIPT_FILENAME"]);
                $data_destination_path =$data_source_path.'webroot/uploads/files/';
                $data_source_path .='webroot/uploads/data_source/';

                $dircontents = scandir($data_source_path);
                // print_r($dircontents);die;
                $imported = false;
                foreach($dircontents as $file_to_import){
                    $ext = pathinfo($file_to_import, PATHINFO_EXTENSION);
                    $tm_folder_name = str_replace('.'.$ext, '', $file_to_import);
                    if(
                        $file_to_import != '.' && $file_to_import != '..' && 
                        !is_dir($data_source_path.'/'.$file_to_import) && $ext == 'zip'
                        && !in_array($file_to_import, $imported_files)
                    ){
                        // Unzip
                        if (!file_exists($data_source_path.$tm_folder_name)) {
                            mkdir($data_source_path.$tm_folder_name, 0777, true);
                        }
                        $zip = new \ZipArchive;
                        if ($zip->open($data_source_path.$file_to_import) === TRUE) {
                            $zip->extractTo($data_source_path.$tm_folder_name);
                            $zip->close();
                            // loop on folders
                            $tm_folder_name_contents = scandir($data_source_path.$tm_folder_name);
// print_r($tm_folder_name_contents);die;
                            foreach ($tm_folder_name_contents as $tmp_sub_folder) {
                                $tmp_sub_folder_fullPath = $data_source_path.$tm_folder_name.'/'.$tmp_sub_folder;
                                if($tmp_sub_folder != '.' && $tmp_sub_folder != '..' && is_dir($tmp_sub_folder_fullPath) ){
                                    // echo "--1--";
                                    $user_id = str_replace('salem', '', $tmp_sub_folder);
                                    $user_files = scandir($tmp_sub_folder_fullPath);
                                    // print_r($user_files);die;
                                    foreach ($user_files as $user_file) {
                                        if(
                                            $user_file != '.' && $user_file != '..' && 
                                            !is_dir($tmp_sub_folder_fullPath.'/'.$user_file) 
                                        ){
                                            //Move file
                                            $new_file_name = $user_id.'_'.$user_file;
                                            rename($tmp_sub_folder_fullPath.'/'.$user_file, $data_destination_path.$new_file_name);

                                            // Save file
                                            $file_data = [];
                                            $file_data["file"] = $new_file_name;
                                            $file_data["user_id"] = $user_id;
                                            
                                            $file = $this->Files->newEmptyEntity();
                                            $file = $this->Files->patchEntity($file, $file_data);
                                            $this->Files->save($file);



                                        }
                                    }
                                }
                                // die;
                            }
                            
                        }


                    //Save Log
                    $file_data = [];
                    $file_data["file_name"] = $file_to_import;
                    
                    $file_import = $this->FileImports->newEmptyEntity();
                    $file_import = $this->FileImports->patchEntity($file_import, $file_data);
                    $this->FileImports->save($file_import);
                    // delete folder
                    delete_full_folder($data_source_path.$tm_folder_name);
                    $imported = true;
                    }
                }
                if($imported){
                    $this->Flash->success(__('Files imported successfully.'));
                    return $this->redirect(['action' => 'importWorkFiles']);
                }else{
                    $this->Flash->error(__('The files could not be imported. Please, try again.'));
                    return $this->redirect(['action' => 'importWorkFiles']);
                }
                // print_r($dircontents);
                // End Loop
            }
        }
    }
    

    protected function __common(){
        $status_labels = $this->Files->status_labels;
        $this->set("status_labels",$status_labels);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     // $this->checkIfSuperadmin();
    //     $role = $this->Roles->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $role = $this->Roles->patchEntity($role, $this->request->getData());
    //         if ($this->Roles->save($role)) {
    //             $this->Flash->success(__('The role has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The role could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('role'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     // $this->checkIfSuperadmin();
    //     $role = $this->Roles->get($id, [
    //         'contain' => [],
    //     ]);
    //     unset($role->password);
    //     if ($this->request->is(['patch', 'post', 'put'])) {

    //         $role = $this->Roles->patchEntity($role, $this->request->getData());
    //         // debug($this->request->getData());
    //         if ($this->Roles->save($role)) {
    //             $this->Flash->success(__('The role has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }

    //         $this->Flash->error(__('The role could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('role'));
    //     $this->render('add');
    // }
    

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     if(!$this->checkIfSuperadmin()){
    //         $this->Flash->error(__('you are not authorized to view this page please contact system administrator'));
    //         return $this->redirect('/admin');
    //     }
    //     // $this->request->allowMethod(['post', 'delete']);
    //     $role = $this->Roles->get($id);
    //     if ($this->Roles->delete($role)) {
    //         $this->Flash->success(__('The role has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The role could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    // public function deleteMulti()
    // {
    //     $this->checkIfSuperadmin();
    //     $this->request->allowMethod(['post', 'delete']);

    //     $ids = $this->request->getData('ids');

    //     if (is_array($ids)) {
    //         $this->Admins->deleteAll(['id IN' => $ids]);
    //         $this->Flash->success(__('The admins has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The admins could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
