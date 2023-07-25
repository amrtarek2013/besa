<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class UniversitiesController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $universities = $this->Universities->find()->where(['active' => 1])->order(['university_name' => 'asc'])->limit(10)->all();
        
        $this->set('universities', $universities);
    }
    public function details($id = null)
    {
        $university = $this->Universities->findByPermalink($id)->first();

        // debug($university);
        $this->set('bodyClass', 'pageAbout pageServices');

        if (empty($university))

            throw new NotFoundException(__('Not found'));

        // print_r($university);
        $this->set('university', $university);
        $this->set('permalink', $id);
    }

}
