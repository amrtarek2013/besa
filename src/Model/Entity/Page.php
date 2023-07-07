<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;


class Page extends Entity
{

    protected $_virtual = ['url_link'];

    protected $_accessible = [
'*'=>true,

];

    

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */

    protected $_hidden = [
       
    ];

    public function initialize(array $config): void
    {
     
    }

    public function beforeSave($event, $entity, $options){
        debug($entity->permalink);die;
    }

    protected function _getUrlLink()
    {
        $url_link = '';

        if($this->is_url == 1){
            $url_link = $this->url;
        }else{
            $url_link = Router::url('/content/'.$this->permalink,true);
        }
        return  $url_link;

      
    }

    

}
