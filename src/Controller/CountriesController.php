<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class CountriesController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $countries = $this->Countries->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

        $this->set('countriesData', $countries);
    }
    public function details($id = null)
    {
        $country = $this->Countries->findByPermalink($id)->first();

        // debug($country);
        $this->set('bodyClass', 'pageUnitedKingdom pageServices');

        if (empty($country))

            throw new NotFoundException(__('Not found'));

        $this->set('country', $country);
        $this->set('permalink', $id);



        $this->loadModel('Services');
        $this->set('serviceTypes', $this->Services->types);
        $services = $this->Services->find()->where(['active' => 1])->order(['type' => 'ASC', 'display_order' => 'asc'])->all();

        $this->set('countryServices', $services);

        $this->loadModel('CountryImages');
        $countryImages = $this->CountryImages->find()->where(['active' => 1, 'country_id' => $country['id']])->order('rand()')->limit(3)->all();

        // debug($countryImages);
        $this->set('countryImages', $countryImages);
    }
}
