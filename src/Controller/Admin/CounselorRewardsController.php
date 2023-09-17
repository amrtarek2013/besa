<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Counselor Reward Controller
 *
 */

class CounselorRewardsController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $counselorRewards = $this->paginate($this->CounselorRewards, ['contain' => ['Counselor' => ['fields' => ['first_name']], 'User' => ['fields' => ['first_name']]], 'conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('counselorRewards', 'parameters'));
    }

    public function add()
    {
        $counselorReward = $this->CounselorRewards->newEmptyEntity();
        if ($this->request->is('post')) {
            $counselorReward = $this->CounselorRewards->patchEntity($counselorReward, $this->request->getData());
            if ($this->CounselorRewards->save($counselorReward)) {
                $this->Flash->success(__('The Counselor Reward has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Counselor Reward could not be saved. Please, try again.'));
        }

        $this->set(compact('counselorReward'));
    }

    public function edit($id = null)
    {
        $counselorReward = $this->CounselorRewards->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $counselorReward = $this->CounselorRewards->patchEntity($counselorReward, $this->request->getData());
            if ($this->CounselorRewards->save($counselorReward)) {
                $this->Flash->success(__('The Counselor Reward has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Counselor Reward could not be saved. Please, try again.'));
        }
        $this->set(compact('counselorReward'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $counselorReward = $this->CounselorRewards->get($id);
        if ($this->CounselorRewards->delete($counselorReward)) {
            $this->Flash->success(__('The Counselor Reward has been deleted.'));
        } else {
            $this->Flash->error(__('The Counselor Reward could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->CounselorRewards->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Counselor Reward has been deleted.'));
        } else {
            $this->Flash->error(__('The Counselor Reward could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $counselorReward = $this->CounselorRewards->get($id);

        $this->set('counselorReward', $counselorReward);
    }
}
