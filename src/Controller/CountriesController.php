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
        $this->set('countryImages', $countryImages);



        $this->loadModel('CountryBenefits');
        $countryBenefits = $this->CountryBenefits->find()->where(['active' => 1, 'country_id' => $country['id']])->order(['display_order' => 'ASC'])->all();
        $this->set('countryBenefits', $countryBenefits);


        $this->loadModel('CountryQuestions');
        $countryQuestions = $this->CountryQuestions->find()->where(['active' => 1, 'country_id' => $country['id']])->order(['display_order' => 'ASC'])->all();
        $this->set('countryQuestions', $countryQuestions);


        $this->loadModel('CountryPartners');
        $countryPartners = $this->CountryPartners->find()->where(['active' => 1, 'country_id' => $country['id']])->order(['display_order' => 'ASC'])->all();
        $this->set('countryPartners', $countryPartners);
        
        
        $this->loadModel('CountryPartners');
        $countryPartnersVideos = $this->CountryPartners->find()->where(['active' => 1, 'video_url is not null', 'country_id' => $country['id']])->order(['display_order' => 'ASC'])->limit(2)->all();
        $this->set('countryPartnersVideos', $countryPartnersVideos);
        
    }
}
