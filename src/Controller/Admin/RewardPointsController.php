<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Reward Point Controller
 *
 */

class RewardPointsController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $rewardPoints = $this->paginate($this->RewardPoints, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('rewardPoints', 'parameters'));
    }

    public function add()
    {
        $rewardPoint = $this->RewardPoints->newEmptyEntity();
        if ($this->request->is('post')) {
            $rewardPoint = $this->RewardPoints->patchEntity($rewardPoint, $this->request->getData());
            if ($this->RewardPoints->save($rewardPoint)) {
                $this->Flash->success(__('The Reward Point has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Reward Point could not be saved. Please, try again.'));
        }

        $this->set(compact('rewardPoint'));
    }

    public function edit($id = null)
    {
        $rewardPoint = $this->RewardPoints->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rewardPoint = $this->RewardPoints->patchEntity($rewardPoint, $this->request->getData());
            if ($this->RewardPoints->save($rewardPoint)) {
                $this->Flash->success(__('The Reward Point has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Reward Point could not be saved. Please, try again.'));
        }
        $this->set(compact('rewardPoint'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $rewardPoint = $this->RewardPoints->get($id);
        if ($this->RewardPoints->delete($rewardPoint)) {
            $this->Flash->success(__('The Reward Point has been deleted.'));
        } else {
            $this->Flash->error(__('The Reward Point could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->RewardPoints->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Reward Point has been deleted.'));
        } else {
            $this->Flash->error(__('The Reward Point could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $rewardPoint = $this->RewardPoints->get($id);

        $this->set('rewardPoint', $rewardPoint);
    }
}
