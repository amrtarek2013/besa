<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class UniversityPlacementsController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout');

        $universityPlacements = $this->UniversityPlacements->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

        
        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $this->set('book_free_meeting', $book_free_meeting);
        $this->set('universityPlacements', $universityPlacements);
    }
    public function details($id = null)
    {
        $universityPlacement = $this->UniversityPlacements->findByPermalink($id)->first();

        // debug($universityPlacement);
        $this->set('bodyClass', 'pageUnitedKingdom pageServices');

        if (empty($universityPlacement))

            throw new NotFoundException(__('Not found'));

        $this->set('universityPlacement', $universityPlacement);
        $this->set('permalink', $id);

    }
}
