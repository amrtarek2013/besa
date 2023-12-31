<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class UniversitiesController extends AppController
{

    public function index($country = null)
    {
        $this->set('bodyClass', 'pageAbout pageServices');


        // $universities = $this->Universities->find()->where($conditions)->order(['university_name' => 'asc'])->limit(10)->all();

        $conditions = $this->_filter_params();
        $conditions = ['active' => 1, 'is_partner' => 1];
        if (isset($country)) {

            // $c_id = explode('-', $country);
            // if (isset($c_id[0]) && is_numeric($c_id[0]))
            $conditions['country_id'] = $country;
        }

        $this->loadModel('Countries');
        $countryDeatils = $this->Countries->find()->select(['country_name'])->where(['id'=>$country])->first();
        
        $this->set('country_name',$countryDeatils['country_name']);
        $universities = $this->paginate($this->Universities, [
            'conditions' => $conditions,
            'distinct' => ['university_name'],
            'order' => ['title' => 'ASC'], 'limit' => 20
        ]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('universities', 'parameters'));

        // dd($universities);
        // $this->set('universities', $universities);
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
