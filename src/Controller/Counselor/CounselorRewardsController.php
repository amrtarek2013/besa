<?php

declare(strict_types=1);

namespace App\Controller\Counselor;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Counselor Reward Controller
 *
 */

class CounselorRewardsController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $user = $this->Auth->user();
        $conditions['CounselorRewards.counselor_id'] = $user['id'];
        $counselorRewards = $this->paginate($this->CounselorRewards, ['contain' => ['Users' => ['fields' => ['first_name']]], 'conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('counselorRewards', 'parameters'));
    }
}
