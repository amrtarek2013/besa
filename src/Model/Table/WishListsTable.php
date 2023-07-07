<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class WishListsTable extends Table
{


    public $filters = [
        // 'country_name' => 'like',
        // 'code' => array('type' => 'like', 'options' => array('type' => 'text')),
        
        // 'continent',
    ];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('wishlists');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Courses');

    }



    public function validationDefault(Validator $validator): Validator
    {
        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        clearViewCache();
    }
}
