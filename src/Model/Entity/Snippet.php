<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use \Cake\Utility\Inflector;

class Snippet extends Entity
{

    protected $_virtual = [];

    protected $_accessible = [
'*'=>true
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



    

}
