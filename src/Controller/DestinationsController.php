<?php
declare(strict_types=1);

namespace App\Controller;

class DestinationsController extends AppController
{
  
    public function index(){
        // $this->set('bodyClass','pageAbout pageServices');
    }
    public function details(){
        $this->set('bodyClass','pageAbout pageServices');
    }
}
