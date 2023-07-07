<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class ServicesController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $services = $this->Services->find()->where(['active' => 1])->order(['display_order' => 'asc'])->all();
        
        $this->set('services', $services);
        
        $services_page_text = $this->getSnippet('services_page_text');
        $this->set('services_page_text', $services_page_text);

        
        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $this->set('book_free_meeting', $book_free_meeting);
    }
    public function details($id = null)
    {
        $service = $this->Services->findByPermalink($id)->first();

        $this->set('bodyClass', 'pageAbout pageServices');

        if (empty($service))

            throw new NotFoundException(__('Not found'));

        // print_r($service);
        $this->set('service', $service);
        $this->set('permalink', $id);
    }
    public function b2bServices()
    {
        $this->set('bodyClass', '');
        
        $b2b_services = $this->getSnippet('b2b_services');
        $this->set('b2b_services', $b2b_services);
    }


    public function display($id = null)
    {



        $service = $this->Services->findByPermalink($id)->first();

        /*if (strpos($id, 'franchise') !== false) {
            $this->_privatesellerAuth();
            $franchisor = $this->Auth->user();
          
            if (!$franchisor || !$franchisor['franchisor']) {

                $this->Flash->error(__('Please login', true));
                $this->redirect('/franchise-login');
            }
        }*/


        if (empty($service))

            throw new NotFoundException(__('Not found'));

        // if ($service->is_url) {
        //         $this->redirect($service['url']);
        //     }

        // $this->createFormToken();
        $this->set('service', $service);
        $this->set('permalink', $id);
    }
}
