<?php
namespace MobileValidator;
use MobileValidator\classes\blocked_number;
use MobileValidator\config;
use MobileValidator\includes\functions;




class MobileValidator
{

    protected $_validator;


 public function __construct()
    {
       $this->init();
    }
    public function init()
    {
      include_once PLUGINS  . "MobileValidator" . DS ."src" . DS . 'config.php'; 
      include_once PLUGINS  . "MobileValidator" . DS ."src" . DS .'includes' . DS . 'db.php'; 
      include_once PLUGINS  . "MobileValidator" . DS ."src" . DS .'includes' . DS . 'functions.php';
      $this->_validator = new blocked_number();

    }

   
    public function validate($number)
    {
      
       // return $this->_validator->IsBlocked($number) ;
          
    }

    public function IsBlocked($number)
    {
      
       return $this->_validator->IsBlocked($number) ;
          
    }
}