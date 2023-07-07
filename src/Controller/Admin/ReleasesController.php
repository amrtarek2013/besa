<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Http\ServerRequest;
use Cake\Core\Configure;
/**
 * Releases Controller
 *
 */
class ReleasesController extends AppController
{

    public $paginate = [
        // 'limit' => 1,
        'order' => [
            'Releases.name' => 'asc'
        ]
    ];

    /**
     * Index method
     * @return \Cake\Http\Response|null
     */
    public function daily()
    {
        // http://localhost/work/annotation/admin/files/cron-zip-daily-files
        $conditions = $this->_filter_params();
        $this->paginate = array('limit' => 100);
        $releases = $this->paginate($this->Releases, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters','releases'));
    }
    // public function dailyCron()
    // {
    //     Configure::write('debug', true);
    //     $today_start = date("Y-m-d 00:00:00");
    //     $today_end = date("Y-m-d 23:59:59");
        
    //     $this->loadModel("FileLogs");
    //     $this->loadModel("Files");
    //     $log_conds["FileLogs.status in"] = [9,11];
    //     if(!empty($conditions["Releases.created >="])){
    //         $log_conds["FileLogs.created >="] = $today_start;
    //     }
    //     if(!empty($conditions["Releases.created <="])){
    //         $log_conds["FileLogs.created <="] = $today_end;
    //     }
    //     $logs = $this->FileLogs->find()->where($log_conds)->all()->toArray();
    //     $files_ids = [];
    //     foreach ($logs as $key => $value) {
    //         $files_ids[] = $value->file_id;
    //     }

    //     $conds = [];
    //     $conds['status'] = 9;
    //     $conds['id in'] = array_unique($files_ids);
    //     $files_list = $this->Files->find()->where($conds)->all()->toArray();
        
    //     // zip files
    //     $files_list_to_zip = [];
    //     $upload_path = str_replace('webroot/index.php', '', $_SERVER["SCRIPT_FILENAME"]);
    //     $upload_path .='webroot/uploads/';
    //     foreach ($files_list as $key => $value) {
    //         if(!empty($value->file) && file_exists($upload_path.'files/'.$value->file)){
    //             $files_list_to_zip[$value->id] = $value->file;
    //         }
    //     }
    //     $zipped_file_name = $this->_zip_files_for_release($files_list_to_zip);
        
    //     $release_data["zip_file"] = $zipped_file_name;
    //     $release = $this->Releases->newEmptyEntity();
    //     $release = $this->Releases->patchEntity($release, $release_data);
    //     if ($this->Releases->save($release)) {
    //         die("done");
    //     }

    //     // $output_pdf_file = $upload_path."zip_files/". $zipped_file_name;
    //     // header('Content-Type: application/zip');
    //     // header("Content-disposition: inline;filename=" . basename($output_pdf_file));
    //     // header('Content-Length: ' . filesize($output_pdf_file));
    //     // readfile($output_pdf_file);
        
    //     // ignore_user_abort(true);
    //     // unlink($output_pdf_file);

    //     die("not done");

        
    // }

    public function custom()
    {
        // Configure::write('debug', true);

        $conditions = $this->_filter_params(false,"filters2");
        $parameters = $this->request->getAttribute('params');

        if (!empty($parameters["?"])) {
            
            $this->loadModel("FileLogs");
            $this->loadModel("Files");
            $log_conds["FileLogs.status in"] = [9,11];
            if(!empty($conditions["Releases.created >="])){
                $log_conds["FileLogs.created >="] = $conditions["Releases.created >="];
            }
            if(!empty($conditions["Releases.created <="])){
                $log_conds["FileLogs.created <="] = $conditions["Releases.created <="];
            }
            $logs = $this->FileLogs->find()->where($log_conds)->all()->toArray();
            $files_ids = [];
            foreach ($logs as $key => $value) {
                $files_ids[] = $value->file_id;
            }
            if(!empty($files_ids)){
                if(!empty($_GET['submit2'])){
                    $nconds2["Files.id in"] = $files_ids;
                    $nfiles = $this->Files->find()->where($nconds2)->all()->toArray();
                    if(!empty($nfiles)){
                        $this->autoLayout = $this->autoRender =  false;
                        $array[] = array(
                            __('File'),
                            __('Annotation'),
                            __('Review Note')
                        );

                        foreach ($nfiles as $file_row) {
                            $array[] = array(
                                $file_row->file,
                                $file_row->annotation_note,
                                $file_row->review_note
                            );
                        }
                        $this->loadComponent('Csv');
                        $this->Csv->download($array, 'release_annotations');
                        die;
                    }
                }


                $conds = [];
                $conds['status'] = 9;
                $conds['id in'] = array_unique($files_ids);
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
                $output_pdf_file = $upload_path."zip_files/". $zipped_file_name;
                header('Content-Type: application/zip');
                header("Content-disposition: inline;filename=" . basename($output_pdf_file));
                header('Content-Length: ' . filesize($output_pdf_file));
                readfile($output_pdf_file);
                
                ignore_user_abort(true);
                unlink($output_pdf_file);

                exit;
            }
            $this->Flash->error(__('No files available for release on the selected period.'));
            return $this->redirect(['action' => 'custom']);
        }

        
    }

    public function download($id)
    {
        $selected_file = $this->Releases->get($id);
        if(!empty($selected_file)){
            $file_type = "zip";
            $upload_path = str_replace('webroot/index.php', '', $_SERVER["SCRIPT_FILENAME"]);
            $upload_path .='webroot/uploads/zip_files/';

            $output_pdf_file = $upload_path . $selected_file->zip_file;
            header('Content-Type: application/' . $file_type);
            header("Content-disposition: inline;filename=" . basename($output_pdf_file));
            header('Content-Length: ' . filesize($output_pdf_file));
            // //            $this->autoRender = false;
            readfile($output_pdf_file);
            exit;
        }
        die("Invalid file");
    }
    public function downloadAnnotations($id,$from='daily'){
        // Configure::write('debug', true);
        $release = $this->Releases->get($id);
        if(!empty($release)){
            $this->loadModel("FileLogs");
            $this->loadModel("Files");
            $conds["FileLogs.release_id"] = 1;
            $logs = $this->FileLogs->find()->where($conds)->all()->toArray();
            
            if(!empty($logs)){
                $files_ids = [];
                foreach ($logs as $value) {
                    $files_ids[]=$value->file_id;
                }
                if(!empty($files_ids)){
                    $conds2["Files.id in"] = $files_ids;
                    $files = $this->Files->find()->where($conds2)->all()->toArray();
                    if(!empty($files)){
                        $this->autoLayout = $this->autoRender =  false;
                        $array[] = array(
                            __('File'),
                            __('Annotation'),
                            __('Review Note')
                        );

                        foreach ($files as $file_row) {
                            $array[] = array(
                                $file_row->file,
                                $file_row->annotation_note,
                                $file_row->review_note
                            );
                        }
                        $this->loadComponent('Csv');
                        $this->Csv->download($array, 'release_annotations');
                        die;
                    }
                }
            }
        }
        $this->Flash->error(__('Invalid Release.'));
        return $this->redirect(['action' => $from]);

    }

    
}
