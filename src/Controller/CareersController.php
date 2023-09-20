<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class CareersController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout');

        $careers = $this->Careers->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

        $this->set('careers', $careers);
        $this->loadModel('CareerImages');
        $careerImages = $this->CareerImages->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

        $this->set('careerImages', $careerImages);

        $besa_careers_benefits = $this->getSnippet('besa_careers_benefits');

        $this->set('besa_careers_benefits', $besa_careers_benefits);
    }
    public function details($permalink = null, $id = null)
    {
        $career = null;
        if ($id)
            $career = $this->Careers->get($id)->first();
        else
            $career = $this->Careers->findByPermalink($permalink)->first();

        // debug($career);
        $this->set('bodyClass', 'pageUnitedKingdom pageServices');

        if (empty($career))

            throw new NotFoundException(__('Not found'));

        $this->set('career', $career);
        $this->set('permalink', $id);
    }
}
