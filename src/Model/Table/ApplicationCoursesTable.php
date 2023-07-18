<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Event;
use ArrayObject;
// use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use MobileValidator\MobileValidator;

class ApplicationCoursesTable extends Table
{


  public $modelName = 'application_courses';
  public $filters = ['application_id' => 'like', 'course_id' => 'like'];



  /**
   * Initialize method
   *
   * @param array $config The configuration for the Table.
   * @return void
   */
  public function initialize(array $config): void
  {
    parent::initialize($config);

    $this->setTable('application_courses');
    $this->setDisplayField('course_id');
    $this->setPrimaryKey('id');
    $this->addBehavior('Timestamp');
    $this->belongsTo('Courses')->setForeignKey('course_id');
    $this->belongsTo('Applications')->setForeignKey('application_id');
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
