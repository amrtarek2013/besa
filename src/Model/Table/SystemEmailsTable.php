<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SystemEmailsTable extends Table
{

    public $filters = [
        'title' => 'like',
        'name' => 'like',
        // 'active'
        'active' => ['options' => ['options' => [0 => 'Not Active', 1 => 'Active']]]
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


        $this->setDisplayField('name');

        $this->setPrimaryKey('id');

        $this->belongsTo('EmailLayouts')->setForeignKey('email_layout_id');  
          
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');

        return $validator;
    }

    



}
