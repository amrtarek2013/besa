<?php

declare(strict_types=1);

namespace App\Controller\Counselor;

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

        $user = $this->Auth->user();
        $conditions['CounselorRewards.counselor_id'] = $user['id'];
        $counselorInvoices = $this->paginate($this->CounselorInvoices, ['contain' => ['Counselors' => ['fields' => ['first_name']]], 'conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set('paymentMethods', $this->CounselorInvoices->paymentMethods);
        $this->set('paymentMethodFields', $this->CounselorInvoices->paymentMethodFields);
        $this->set(compact('counselorInvoices', 'parameters'));
    }

    public function withdraw()
    {

        $user = $this->Auth->user();

        $this->loadModel('Counselors');
        $counselor = $this->Counselors->get($user['id']);
        $this->loadModel('CounselorRewards');

        $counselorRewardConds = [];
        $counselorRewardConds['CounselorRewards.counselor_id'] = $user['id'];
        $counselorRewardConds['is_paid !='] = 1;
        $counselorRewardConds[] = '(invoice_id is null)';
        $counselorRewards = $this->CounselorRewards->find('list', ['fieldKey' => 'id', 'valueKey' => 'id'])->where($counselorRewardConds)->all()->toArray();

        if (empty($counselorRewards)) {

            $this->Flash->error(__('Sorry, you don\'t have any points Or you already requested the current Points.'));
            $this->redirect('/counselor');
        } 

        $counselorInvoice = $this->CounselorInvoices->newEmptyEntity();
        if ($this->request->is('post')) {
            $counselorInvoice = $this->CounselorInvoices->patchEntity($counselorInvoice, $this->request->getData());
            // dd($counselorInvoice);
            $counselorRewardConds = [];
            $counselorInvoice['counselor_id'] = $user['id'];

            $this->loadModel('CounselorRewards');

            $counselorRewardConds['counselor_id'] = $counselorInvoice['counselor_id'] = $user['id'];
            $counselorRewardConds['is_paid !='] = 1;
            $counselorRewardConds[] = '(invoice_id is null)';
            // $counselorRewards = $this->CounselorRewards->find('list', ['fieldKey' => 'id', 'valueKey' => 'id'])->where($counselorRewardConds)->all()->toArray();


            // Re-Calculate Points and total
            $totalPointsMod = $this->CounselorRewards->find();
            $totalPoints = $totalPointsMod->select(['sum_totals' => $totalPointsMod->func()->sum('CounselorRewards.total'), 'sum_points' => $totalPointsMod->func()->sum('CounselorRewards.points')])
                ->where($counselorRewardConds)->first();

            if (!$totalPoints['sum_points'] || $totalPoints['sum_points'] == 0) {

                $this->Flash->error(__('Sorry, you don\'t have any points. Please, try again.'));
            } else {
                $counselorInvoice['total_points'] = $totalPoints['sum_points'];
                $counselorInvoice['total'] = $totalPoints['sum_totals'] / intval($this->g_configs['general']['txt.number_of_points_per_dollar']);
                $counselorInvoice['points_per_dollar'] = intval($this->g_configs['general']['txt.number_of_points_per_dollar']);

                if ($this->CounselorInvoices->save($counselorInvoice)) {

                    // Update CounselorRewards invoice_id
                    $this->CounselorRewards->updateAll(
                        [  // fields
                            'invoice_id' => $counselorInvoice->id
                        ],
                        [  // conditions
                            'CounselorRewards.id IN' => $counselorRewards
                        ]
                    );

                    // Update Counselors 
                    $noOfJoinedStudents = $this->CounselorRewards->find()->where(['counselor_id' => $user['id'], 'is_paid != 1'])->count();
                    $counselor['total_points_reward'] = $totalPoints['sum_totals'];
                    $counselor['total_points'] = $totalPoints['sum_points'];
                    $counselor['number_joined_students'] = $noOfJoinedStudents;

                    $this->Counselors->save($counselor);


                    /// Send Admin Email
                    $url = Router::url('/admin/counselor-invoices/view/' . $counselorInvoice->id, true);

                    $a_replace = array(
                        '{%name%}' => $counselor['name'],
                        '{%email%}' => $counselor['email'],
                        '{%mobile%}' => $counselor['mobile'],
                        '{%view_link%}'  => $url,
                        '{%website_url%}' => WEBSITE_PATH
                    );

                    $this->sendEmail($this->g_configs['general']['txt.admin_email'], false, 'admin.notify_counselor_invoice_request', $a_replace);

                    $url = Router::url('/counselor/counselor-invoices/view/' . $counselorInvoice->id, true);

                    $u_replace = array(
                        '{%name%}' => $counselor['name'],
                        '{%email%}' => $counselor['email'],
                        '{%mobile%}' => $counselor['mobile'],
                        '{%view_link%}'  => $url,
                        '{%website_url%}' => WEBSITE_PATH
                    );
                    $email_template = 'counselor.notify_counselor_invoice_request';


                    $this->sendEmail($counselor['email'], false, $email_template, $u_replace);

                    $this->Flash->success(__('The Withdraw Request has been sent.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The Withdraw Request could not be saved. Please, try again.'));
            }
        }

        $this->set('paymentMethods', $this->CounselorInvoices->paymentMethods);
        $this->set('paymentMethodFields', $this->CounselorInvoices->paymentMethodFields);
        $this->set(compact('counselorInvoice'));


        $this->set('counselor', $counselor);
    }

    public function edit($id = null)
    {

        $user = $this->Auth->user();
        $conditions = ['counselor_id' => $user['id'], 'CounselorInvoices.id' => $id];
        $counselorInvoice = $this->CounselorInvoices->find()->where($conditions)->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
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
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);

        $user = $this->Auth->user();
        $conditions = ['counselor_id' => $user['id'], 'CounselorInvoices.id' => $id];
        $counselorInvoice = $this->CounselorInvoices->find()->where($conditions)->first();
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

        $user = $this->Auth->user();
        $conditions = ['counselor_id' => $user['id']];
        if (is_array($ids)) {
            $conditions['id IN'] = $ids;
            $this->CounselorInvoices->deleteAll($conditions);
            $this->Flash->success(__('The Counselor Invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The Counselor Invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $user = $this->Auth->user();
        $conditions = ['counselor_id' => $user['id'], 'CounselorInvoices.id' => $id];
        $counselorInvoice = $this->CounselorInvoices->find()->contain(['CounselorRewards', 'CounselorRewards.Users' => ['fields' => ['first_name']]])->where($conditions)->first();

        $this->set('counselorInvoice', $counselorInvoice);

        $this->set('paymentMethods', $this->CounselorInvoices->paymentMethods);
        $this->set('paymentMethodFields', $this->CounselorInvoices->paymentMethodFields);
    }
}
