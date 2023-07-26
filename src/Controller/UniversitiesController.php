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
        $conditions = ['active' => 1];
        if (isset($country)) {

            // $c_id = explode('-', $country);
            // if (isset($c_id[0]) && is_numeric($c_id[0]))
            $conditions['country_id'] = $country;
        }

        $universities = $this->paginate($this->Universities, ['conditions' => $conditions, 'order' => ['title' => 'ASC'], 'limit' => 20]);
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
