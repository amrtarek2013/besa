<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Utility\Hash;

/**
 * Enquiries Controller
 *
 */

class EnquiriesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        // Configure::write('debug', true);
        // Configure::write('debug', 1);

        $enquiries = $this->paginate($this->Enquiries, ['conditions' => $conditions, 'order' => ['created' => 'DESC']]);
        $parameters = $this->request->getAttribute('params');

        // $this->loadModel('Branches');
        // $branches = $this->Branches->find('list');
        // $types = $this->Enquiries->find('list', [
        //     'keyField' => 'type',
        //     'valueField' => 'type',
        // ])->where(['type !=' => '', 'type is not null'])->distinct('type');
        $types = $this->Enquiries->enquiryTypesList;

        $this->set(compact('enquiries', 'parameters', 'types'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $enquiries = $this->paginate($this->Enquiries, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Enquiries->continents;
        $this->set(compact('enquiries', 'parameters', 'continents'));
    }

    public function add()
    {
        $enquiry = $this->Enquiries->newEmptyEntity();
        if ($this->request->is('post')) {
            $enquiry = $this->Enquiries->patchEntity($enquiry, $this->request->getData());
            if ($this->Enquiries->save($enquiry)) {
                $this->Flash->success(__('The Enquiry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Enquiry could not be saved. Please, try again.'));
        }
        // $this->_ajaxImageUpload('branch_new', 'enquiries', false, false, ['image_why_study','image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->Enquiries->continents;
        $this->set(compact('enquiry', 'continents'));
    }

    public function edit($id = null)
    {
        $enquiry = $this->Enquiries->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $enquiry = $this->Enquiries->patchEntity($enquiry, $this->request->getData());


            if ($this->Enquiries->save($enquiry)) {
                $this->Flash->success(__('The Enquiry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Enquiry could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->Enquiries->continents;
        $this->set(compact('enquiry', 'id', 'continents'));
        // $this->_ajaxImageUpload('branch_' . $id, 'enquiries', $id, ['id' => $id], ['image_why_study','image', 'flag', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $enquiry = $this->Enquiries->get($id);
        if ($this->Enquiries->delete($enquiry)) {
            $this->Flash->success(__('The Enquiry has been deleted.'));
        } else {
            $this->Flash->error(__('The Enquiry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Enquiries->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Enquiries has been deleted.'));
        } else {
            $this->Flash->error(__('The Enquiries could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $enquiry = $this->Enquiries->find()->contain(['Countries' => ['fields' => ['country_name']], 'SubjectAreas' => ['fields' => ['title']]])->where(['Enquiries.id' => $id])->first();

        $this->loadModel('StudyLevels');
        $this->set('enquiry', $enquiry);
        $this->set('enquiryType', $this->Enquiries->enquiryTypes[$enquiry['type']]);
        $this->set('interestedStudyLevels', $this->Enquiries->interestedStudyLevels);
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);

        $this->set('fairVenues', $this->Enquiries->fairVenues);
    }


    // public function export()
    // {
    //     $now = gmdate('D, d M Y H:i:s') . ' GMT';
    //     ini_set('memory_limit', '2024M');
    //     set_time_limit(0);

    //     Configure::write('debug', false);
    //     $this->viewBuilder()->disableAutoLayout();
    //     $this->set("statuses", $this->Enquiries->status_list);

    //     $parameters = $this->request->getAttribute('params');

    //     $url_query = (isset($parameters['?'])) ? $parameters['?'] : [];

    //     $conditions = [];
    //     $conditions = $this->_filter_params();
    //     // print_r($conditions);
    //     // $url_params = array();
    //     // if (isset($parameters['?'])) {
    //     //     $url_params = $parameters['?'];
    //     // }
    //     // if (isset($url_params['limit']) and $url_params['limit'] != "") {
    //     //     $limit = intval($url_params['limit']);
    //     // } else {
    //     //     $limit = 100;
    //     // }
    //     // print_r($url_params);
    //     // die;
    //     // $conditions = $this->_mainConditions($parameters);
    //     $delimited = array('tab' => "\t", 'semi' => ";", 'comma' => ",");

    //     $fieldsArray = [
    //         'Primary Key' => 'Enquiries.id',
    //         'User Name' => 'Enquiries.name',
    //         'Phone' => 'Enquiries.mobile',
    //         'Email Address' => 'Enquiries.email',
    //         'Created' => 'Enquiries.created',

    //     ];

    //     // $conditions = [];
    //     $statuslist    = $this->Enquiries->status_list;
    //     $count    = $this->Enquiries->find()->where($conditions)->count();
    //     $enquiries = $this->Enquiries
    //         ->find()
    //         ->where($conditions)
    //         ->select(array_values($fieldsArray))
    //         ->contain(['Branches' => ['fields' => ['name']]])
    //         ->limit($count)
    //         ->order(['Enquiries.id' => 'desc'])
    //         ->all();
    //     // ->all();

    //     // print_r($conditions);
    //     // print_r($enquiries);
    //     // die;

    //     // $count = 200000; // for debuging
    //     $data = $enquiries->toArray();


    //     foreach ($data as $Enquiry) {

    //         if (!empty($Enquiry['branch'])) {
    //             $Enquiry['branch'] = $Enquiry['branch']['name'];
    //         }
    //         if (isset($Enquiry['created'])) {
    //             $Enquiry['created'] = $Enquiry['created']->format('d/m/Y H:i:s');
    //         }
    //     }

    //     $headers = array(
    //         'Primary Key',
    //         'User Name',
    //         'Phone',
    //         'Email Address',
    //         'Created',

    //         'Branch',
    //         // 'Allocated Time',

    //     );

    //     $fileName = 'enquiries-report-' . date('YmdHis', time());
    //     header('Content-Encoding: UTF-8');
    //     header("Content-type: text/csv");
    //     header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');
    //     header("Pragma: no-cache");
    //     header("Expires: 0");

    //     $output = fopen('php://output', 'w');
    //     fputcsv($output, $headers);
    //     foreach ($data as $k => $v) {
    //         // debug($output);
    //         // debug($v->toArray());
    //         fputcsv($output, $v->toArray());
    //     }
    //     // dd($data);
    //     fclose($output);
    //     // flush();
    //     // ob_end_clean();

    //     exit();
    // }

    public function export()
    {

        $this->autoLayout = $this->autoRender = false;
        $conditions = $this->_filter_params();
        $enquiries = $this->Enquiries->find('all')->where($conditions)->toArray();

        $dataToExport[] = array(
            'id' => 'Enquiry ID',
            'name' => 'Name',
            'email' => 'Email',
            'address' => 'Address',
        );

        foreach ($enquiries as $enquiry) {
            $dataToExport[] = [
                $enquiry->id,
                $enquiry->name,
                // $enquiry->job_title,
                $enquiry->email,
                $enquiry->address,
                // $enquiry->barcode_number,
                '',
                ($enquiry->active) ? 'Yes' : 'No',
            ];
        }

        $this->loadComponent('Csv');
        $this->Csv->download($dataToExport, 'Enquiries-list-' . date('Ymd'));

        exit();
    }

    private function __common()
    {
        // $uploadSettings = $this->Enquiries->getUploadSettings();
        // $this->set(compact('uploadSettings'));
    }
}
