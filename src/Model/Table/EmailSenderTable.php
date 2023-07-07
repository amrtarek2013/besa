<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
// use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
// use Cake\Validation\Validator;

use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
use Cake\Utility\Hash;
use Cake\Mailer\Mailer;

class EmailSenderTable extends Table
{

    public $siteConfigs= null;
    public $_mailer= null;
    public $configs= null;

    public function initialize(array $config): void
    {
        parent::initialize($config);
         $table = TableRegistry::getTableLocator()->get('GeneralConfigurations');
        $this->siteConfigs = $table->getConfig();
        $this->_mailer = new Mailer('default');
    }


    

    protected function _setSiteMail($value='')
    {
    	return [$this->siteConfigs['basic']['txt.send_mail_from']=>$this->siteConfigs['basic']['txt.site_name']];
    }


    protected function _prepareContent($email_template_name,$placeholders)
    {

    	
    	$this->SystemEmails = TableRegistry::get('SystemEmails');
    	$template = $this->SystemEmails->find()
    					->where(['SystemEmails.name' => $email_template_name])
    					->contain(['EmailLayouts'])
    					->first();

    	if($template->active == false || !$template){
    		return false;
    	}
    	$subject = str_replace(array_keys($placeholders), array_values($placeholders), $template->subject);
    	$emailContent = str_replace(array_keys($placeholders), array_values($placeholders), $template->message);
    	$this->_mailer->setSubject($subject);
    	if($template->has('email_layout')){
            $content = str_replace(['{%content%}'],[$emailContent], $template->email_layout->content);

    	}else{
    		$content = $emailContent;
    	}
    	
    	return $content;
    }


    protected function _prepareMailer($to = false, $from = false)
    {
    	if(!$from){
           $from=$this->_setSiteMail(); 
        }
        if(!$to){
            $to=$this->_setSiteMail();  
        }


    	$this->_mailer->setTo($to)
    		->setFrom($from)
    		->setEmailFormat('html')
    		->viewBuilder()
                ->setTemplate('dynamic')
                ->setLayout('dynamic');
    } 


    public function sendEmail($to = false, $from = false, $email_template_name, $replace=[],$attach = false)
    {
        $this->_prepareMailer($to, $from);
        if($attach){

			//         	[
			//     'photo.png' => [ // file name
			//         'file' => '/full/some_hash.png',// file path
			//         'mimetype' => 'image/png', // file type
			//         'contentId' => 'my-unique-id' // file unique-id
			//     ]
			// ]
            if(!is_array($attach)){
                $attach = [$attach];
            }
        	$this->_mailer->setAttachments($attach);
        }
        $content = $this->_prepareContent($email_template_name, $replace);
        // echo ( $content);
        if(!$content){
        	return false;
        }
        $deliver = $this->_mailer->deliver($content);
		return true; 
    }

}