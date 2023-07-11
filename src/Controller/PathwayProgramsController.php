<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class PathwayProgramsController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout');

        $pathwayPrograms = $this->PathwayPrograms->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

        
        
        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $this->set('book_free_meeting', $book_free_meeting);
        $this->set('pathwayPrograms', $pathwayPrograms);
    }
    public function details($id = null)
    {
        $pathwayProgram = $this->PathwayPrograms->findByPermalink($id)->first();

        // debug($pathwayProgram);
        $this->set('bodyClass', 'pageUnitedKingdom pageServices');

        if (empty($pathwayProgram))

            throw new NotFoundException(__('Not found'));

        $this->set('pathwayProgram', $pathwayProgram);
        $this->set('permalink', $id);

    }
}
