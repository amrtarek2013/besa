<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
use Cake\Utility\Hash;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;

// GeneralConfigurations

/**
 * EmailSender component
 */
class EmailSenderComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
    	'SiteMail'=>[]
    ];

    public $configs= null;
    public $siteConfigs= null;
    public $_mailer= null;


    protected function _setSiteMail($value='')
    {
    	return [$this->siteConfigs['general']['txt.send_mail_from']=>$this->siteConfigs['general']['txt.site_name']];
    }


    public function initialize(array $config): void
    {
    	parent::initialize($config);
    	 $table = TableRegistry::getTableLocator()->get('GeneralConfigurations');
        $this->siteConfigs = $table->getConfig();
        $this->_mailer = new Mailer('default');
    }

    protected function _prepareContent($email_template_name,$placeholders)
    {

    	
    	$SystemEmails = TableRegistry::get('SystemEmails');
    	$template = $SystemEmails->find()
    					->where(['SystemEmails.name' => $email_template_name])
    					->contain(['EmailLayouts'])
    					->first();
        // debug($template);
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

    public function send($to = false, $from = false, $email_template_name, $replace=[],$attach = false)
    {
        $this->_prepareMailer($to, $from);
        if($attach){
            if(!is_array($attach)){
                $attach = [$attach];
            }
        	$this->_mailer->setAttachments($attach);
        }
        $content = $this->_prepareContent($email_template_name, $replace);
        if(!$content){
        	return false;
        }
        $deliver = $this->_mailer->deliver($content);
		return true;    	
    }

    public function sendPrizeMail($user, $prize,$template = 'winner_email',$attach = false)
    {
        // $user->email = 'developerae@thesitefactory.com.au';
        $this->_prepareMailer($user->email,"prizewinner@ozcar.com.au");
        $replace = [
            '{%first_name%}'=>$user->first_name,
            '{%last_name%}'=>$user->last_name,
            '{%email%}'=>$user->email,
            '{%prize_title%}'=>$prize->name_email,
            '{%prize_description%}'=>$prize->short_desc_email,
            '{%prize_image%}'=>"<img src='https://www.ozcar.com.au/". ($prize->image_path)."' >",
        ];
        // dd($replace);
        debug($replace);


        
        // $this->_mailer->setBcc("amr.tarek2013@gmail.com"); 
        // $this->_mailer->addTo('blake@dkadvertising.com.au', 'blake');
        // $this->_mailer->addTo('gerard@silvertrees.net', 'Gerard');
        // $this->_mailer->addTo('johnkohlenberg@dkadvertising.com.au', 'johnkohlenberg');
        $this->_mailer->setBcc("prizewinner@ozcar.com.au");

        if($attach){
            if(!is_array($attach)){
                $attach = [$attach];
            }
        	$this->_mailer->setAttachments($attach);
        }
        
        $content = $this->_prepareContent('winner_email', $replace);
        debug($content);

        if(!$content){
        	return false;
        }
        $deliver = $this->_mailer->deliver($content);
		return true;    	
    }


   


}
