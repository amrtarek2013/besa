<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class YoungLearnersController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout');

        $youngLearners = $this->YoungLearners->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

        
        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $this->set('book_free_meeting', $book_free_meeting);
        $this->set('youngLearners', $youngLearners);
    }
    public function details($id = null)
    {
        $youngLearner = $this->YoungLearners->findByPermalink($id)->first();

        // debug($youngLearner);
        $this->set('bodyClass', 'pageUnitedKingdom pageServices');

        if (empty($youngLearner))

            throw new NotFoundException(__('Not found'));

        $this->set('youngLearner', $youngLearner);
        $this->set('permalink', $id);

    }
}
