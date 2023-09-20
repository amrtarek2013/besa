<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Utility\Hash;

/**
 * Counselor Invoice Controller
 *
 */

class CounselorInvoicesController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $counselorInvoices = $this->paginate($this->CounselorInvoices, ['contain' => ['Counselors' => ['fields' => ['first_name']]], 'conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set('paymentMethods', $this->CounselorInvoices->paymentMethods);
        $this->set('paymentMethodFields', $this->CounselorInvoices->paymentMethodFields);
        $this->set(compact('counselorInvoices', 'parameters'));
    }

    public function add()
    {
        $counselorInvoice = $this->CounselorInvoices->newEmptyEntity();
        if ($this->request->is('post')) {
            $counselorInvoice = $this->CounselorInvoices->patchEntity($counselorInvoice, $this->request->getData());
            if ($this->CounselorInvoices->save($counselorInvoice)) {
                $this->Flash->success(__('The Counselor Invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Counselor Invoice could not be saved. Please, try again.'));
        }

        $this->loadModel('Counselors');
        $counselors = $this->Counselors->find('list', ['keyField' => 'id', 'valueField' => 'first_name']);

        $this->set('paymentMethods', $this->CounselorInvoices->paymentMethods);
        $this->set('paymentMethodFields', $this->CounselorInvoices->paymentMethodFields);
        $this->set(compact('counselorInvoice', 'counselors'));
    }

    public function edit($id = null, $action = 'index')
    {
        $counselorInvoice = $this->CounselorInvoices->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $counselorInvoice = $this->CounselorInvoices->patchEntity($counselorInvoice, $this->request->getData());
            $counselorInvoice->comment_time = date('Y-m-d h:m:s');


            $uploadPath = WWW_ROOT . 'uploads/files/counselor_invoices';
            // dd($_FILES);
            $upResult = UploadFiles($_FILES, [], $uploadPath, 'pdf,doc,docx,png,jpeg,txt');

            if (empty($upResult['errors'])) {
                foreach ($upResult['names'] as $fieldName => $value) {
                    $counselorInvoice[$fieldName] = $value;
                }

                if ($this->CounselorInvoices->save($counselorInvoice)) {

                    $this->loadModel('CounselorRewards');

                    $counselorRewardConds['counselor_id'] = $counselorInvoice->counselor_id;
                    // $counselorRewardConds['is_paid !='] = 1;
                    $counselorRewardConds['invoice_id'] = $counselorInvoice->id;
                    $counselorRewards = $this->CounselorRewards->find('list', ['fieldKey' => 'id', 'valueKey' => 'id'])->where($counselorRewardConds)->all()->toArray();
                    // Update CounselorRewards is_paid
                    $this->CounselorRewards->updateAll(
                        [  // fields
                            'invoice_id' => $counselorInvoice->id,
                            'is_paid' => $counselorInvoice->is_paid
                        ],
                        [  // conditions
                            'CounselorRewards.id IN' => $counselorRewards
                        ]
                    );

                    if ($counselorInvoice->counselor_id) {

                        $this->loadModel('Counselors');
                        $counselor = $this->Counselors->find()->where(['id' => $counselorInvoice->counselor_id])->first();

                        if ($counselor) {

                            $to = $counselor['email'];

                            $from    = $this->g_configs['general']['txt.send_mail_from'];
                            $replace = array(
                                '{%name%}' => $counselor['first_name'],

                                '{%email%}'  => $counselor['email'],
                                '{%mobile%}'  => $counselor['mobile'],

                                '{%status%}'  => ($counselorInvoice['is_paid'] ? 'Yes' : 'No'),
                                '{%comment%}'  => $counselorInvoice['comment'],
                                '{%comment_time%}'  => is_string($counselorInvoice->comment_time) ? date('d/m/Y H:m:i', strtotime($counselorInvoice->comment_time)) : '',
                                '{%view_link%}'  => '<a href="' . Router::url('/counselor/invoices/view/' . $counselorInvoice['id'], true) . '" >View</a>',
                                '{%website_url%}' => WEBSITE_PATH

                            );

                            if ($counselorInvoice['is_paid']) {
                                $counselor->total_points = 0;
                                $counselor->total_points_rewards = 0;
                                $counselor->number_joined_students = 0;
                                $this->Counselors->save($counselor);
                            }
                            $this->sendEmail($to, $from, 'counselor.notify_counselor_invoice_request_updated', $replace);
                        }
                    }

                    $this->Flash->success(__('The Counselor Invoice has been saved.'));

                    // return $this->redirect(['action' => 'index']);
                    return $this->redirect(['action' => $action, $id]);
                }
            }
            $this->Flash->error(__('The Counselor Invoice could not be saved. Please, try again.'));
            return $this->redirect(['action' => $action]);
        }


        if ($action == 'view')
            return $this->redirect(['action' => $action, $id]);

        $this->loadModel('Counselors');
        $counselors = $this->Counselors->find('list', ['keyField' => 'id', 'valueField' => 'first_name']);

        $this->set('paymentMethods', $this->CounselorInvoices->paymentMethods);
        $this->set('paymentMethodFields', $this->CounselorInvoices->paymentMethodFields);
        $this->set(compact('counselorInvoice', 'counselors'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $counselorInvoice = $this->CounselorInvoices->get($id);
        if ($this->CounselorInvoices->delete($counselorInvoice)) {
            $this->Flash->success(__('The Counselor Invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The Counselor Invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->CounselorInvoices->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Counselor Invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The Counselor Invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $conditions = ['CounselorInvoices.id' => $id];
        $counselorInvoice = $this->CounselorInvoices->find()->contain(['Counselors' => ['fields' => ['first_name']], 'CounselorRewards', 'CounselorRewards.Users' => ['fields' => ['first_name']]])->where($conditions)->first();

        $this->set('counselorInvoice', $counselorInvoice);

        $this->set('paymentMethods', $this->CounselorInvoices->paymentMethods);
        $this->set('paymentMethodFields', $this->CounselorInvoices->paymentMethodFields);
    }
}
