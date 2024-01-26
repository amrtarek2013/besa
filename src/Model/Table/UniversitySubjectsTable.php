<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class UniversitySubjectsTable extends Table
{


    public $filters = [
        // 'country_name' => 'like',
        // 'code' => array('type' => 'like', 'options' => array('type' => 'text')),

        // 'continent',
    ];

    public $continents = [

        'uk' => 'UK', 'eur' => 'Europe', 'na' => 'North America',
        'other' => 'Other UniversitySubjects',
    ];
    public $types = [0 => 'Full Service'];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('university_subjects');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Universities')->setForeignKey('university_id');
        $this->belongsTo('SubjectAreas')->setForeignKey('subject_area_id');
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('subject_area_id', 'This field is required.');

        $validator->notEmptyString('university_id', 'This field is required.');
        // $validator->notEmptyString('text', 'This field is required.');

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
