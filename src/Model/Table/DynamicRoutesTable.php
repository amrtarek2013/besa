<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class DynamicRoutesTable extends Table
{


    public $filters = [];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dynamic_routes');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }
    public function validationDefault(Validator $validator): Validator
    {

        return $validator;
    }

    public function afterSave($event, $entity, $options)
    {
        
        Cache::delete('dynamicroutes', '_dynamicroutes_');
        Cache::delete('dynamic_routes_route');
        clearViewCache();
    }
}
