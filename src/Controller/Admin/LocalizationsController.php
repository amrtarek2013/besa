<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\I18n;
// use Cake\Controller\Component\CookieComponent;


class LocalizationsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    public function setLocale($locale = 'ar')
    {
        if($locale == 'ar'){
            $locale =  'ar_AE';
        }elseif($locale == 'en'){
            $locale =  'en_US';
        }else{
            $locale =  'ar_AE';
        }
        I18n::setLocale($locale);
        $this->Session->write('locale',$locale);
       
        return $this->redirect($this->referer());

    }

   
}
