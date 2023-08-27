<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

use Cake\Validation\Validator;

class NewslettersTable extends Table
{


    public $filters = [
        'title' => array('type' => 'like', 'options' => array('type' => 'text')),
    ];


    public $schema_of_export = array(
        'id',
        'title',
        // 'destination',
        // 'rank',
        // 'description',

    );

    public $schema_of_import = array(
        // 'id',
        'title',
        // 'destination',
        // 'rank',
        // 'description'
    );
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('newsletters');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }



    public function validationDefault(Validator $validator): Validator
    {


        $validator->notEmptyString('title', 'This field is required.');

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

    }
}
