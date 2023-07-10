<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class PathwayPlacementsController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout');

        $pathwayPlacements = $this->PathwayPlacements->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

        $this->set('pathwayPlacements', $pathwayPlacements);
        
        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $this->set('book_free_meeting', $book_free_meeting);
    }
    public function details($id = null)
    {
        $pathwayPlacement = $this->PathwayPlacements->findByPermalink($id)->first();

        // debug($pathwayPlacement);
        $this->set('bodyClass', 'pageUnitedKingdom pageServices');

        if (empty($pathwayPlacement))

            throw new NotFoundException(__('Not found'));

        $this->set('pathwayPlacement', $pathwayPlacement);
        $this->set('permalink', $id);

    }
}
