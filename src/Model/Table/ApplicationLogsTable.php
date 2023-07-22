<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ApplicationLogsTable extends Table
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

    $this->setTable('application_logs');
    // $this->setDisplayField('user_id');
    $this->setPrimaryKey('id');
    $this->addBehavior('Timestamp');

    // $this->belongsTo('Users')->setForeignKey('user_id');
    // $this->belongsTo('Services')->setForeignKey('service_id');
    $this->belongsTo('StudyLevels')->setForeignKey('study_level_id');
    // $this->belongsTo('Universities')->setForeignKey('university_id');
    $this->hasMany('ApplicationCourses')->setForeignKey('application_id');
  }

  /**
   * Default validation rules.
   *
   * @param \Cake\Validation\Validator $validator Validator instance.
   * @return \Cake\Validation\Validator
   */
  public function validationDefault(Validator $validator): Validator
  {

    return $validator;
  }
}