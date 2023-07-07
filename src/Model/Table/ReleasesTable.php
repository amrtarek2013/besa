<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Files Model
 *
 */
class ReleasesTable extends Table
{


    public $filters = ['created' => array('type' => 'date_range')];
    public $filters2 = ['created' => array('type' => 'date_range')];
    // public $filters = ['file'=>'like'];
    // public $modelName = 'files';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);


        // $this->setDisplayField('file');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        // $this->belongsTo('Files');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        // $validator
        //     ->integer('id')
        //     ->allowEmptyString('id', null, 'create');

        // $validator
        //     ->scalar('title')
        //     ->maxLength('name', 100)
        //     ->allowEmptyString('name');

        // $validator
        //     ->uploadedFile('avatar',[]);

        return $validator;
    }



}
