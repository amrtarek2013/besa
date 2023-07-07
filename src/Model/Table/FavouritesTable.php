<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class FavouritesTable extends Table
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

        $this->setTable('favourites');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        
        


    }



    public function validationDefault(Validator $validator): Validator
    {

        return $validator;
    }

}
