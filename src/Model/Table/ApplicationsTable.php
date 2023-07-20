<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Event;
use ArrayObject;
// use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use MobileValidator\MobileValidator;

class ApplicationsTable extends Table
{


  public $modelName = 'applications';
  public $filters = [
    /*'user_id' => 'like', 'course_id' => 'like'*/
    'status' => ['options' => ['options' => [0 => 'Pendeing', 1 => 'Under-Review', 2 => 'Approved', 3 => 'Rejected']]],
    'save_later' => ['options' => ['options' => [0 => 'InProgress', 2 => 'Completed', 1 => 'Save Later']]]
  ];

  public $statuses = [0 => 'Pendeing', 1 => 'Under-Review', 2 => 'Approved', 3 => 'Rejected'];
  public $saveLater = [0 => 'InProgress', 2 => 'Completed', 1 => 'Save Later'];
  public $app_files = [

    'foundation-programs' => [
      'passport' => ['label' => 'Passport*', 'required' => true],
      'high_school_certificate' => ['label' => 'High School Certificate', 'required' => false],
      'ilets_elt' => ['label' => 'ILETS /ELT', 'required' => false],
    ],

    'international-year-one' => [
      'passport' => ['label' => 'Passport*', 'required' => true],
      'high_school_certificate' => ['label' => 'High School Certificate', 'required' => false],
      'ilets_elt' => ['label' => 'ILETS /ELT', 'required' => false],
    ],

    'bachelor-degree' => [
      'passport' => ['label' => 'Passport*', 'required' => true],
      'high_school_certificate' => ['label' => 'High School Ccertificate*', 'required' => true],
      'personal_statement' => ['label' => 'Personal Statement*', 'required' => true],
      'academic_recommendation_letter' => ['label' => 'Academic Recommendation Letter*', 'required' => true],
      'ilets_elt' => ['label' => 'ILETS /ELT', 'required' => false],
    ],

    'pre-masters' => [
      'passport' => ['label' => 'Passport*', 'required' => true],
      'university_transcript' => ['label' => 'University Transcript*', 'required' => true],
      'personal_statement' => ['label' => 'Personal Statement', 'required' => false],
      'recommendation_letter' => ['label' => 'Recommendation Letter', 'required' => false],
      'ilets_elt' => ['label' => 'ILETS /ELT', 'required' => false],
    ],

    'master-degrees' => [
      'passport' => ['label' => 'Passport*', 'required' => true],
      'university_transcript' => ['label' => 'University Transcript*', 'required' => true],
      'personal_statement' => ['label' => 'Personal Statement*', 'required' => true],
      'updated_cv' => ['label' => 'Updated CV*', 'required' => true],
      'professional_recommendation_letter' => ['label' => 'Professional Recommendation Letter', 'required' => false],
      'academic_recommendation_letter' => ['label' => 'Academic Recommendation Letter', 'required' => false],
      'ilets_elt' => ['label' => 'ILETS /ELT', 'required' => false],
    ],

    'phd-degree' => [
      'passport' => ['label' => 'Passport*', 'required' => true],
      'university_transcript' => ['label' => 'University Transcript*', 'required' => true],
      'personal_statement' => ['label' => 'Personal Statement*', 'required' => true],
      'updated_cv' => ['label' => 'Updated CV*', 'required' => true],
      'research_proposal' => ['label' => 'Research Proposal*', 'required' => true],
      'professional_recommendation_letter' => ['label' => 'Professional Recommendation Letter', 'required' => false],
      'academic_recommendation_letter' => ['label' => 'Academic Recommendation Letter', 'required' => false],
      'ilets_elt' => ['label' => 'ILETS /ELT', 'required' => false],
    ],

    'postgraduate-degrees' => [
      'passport' => ['label' => 'Passport*', 'required' => true],
      'university_transcript' => ['label' => 'University Transcript*', 'required' => true],
      'personal_statement' => ['label' => 'Personal Statement*', 'required' => true],
      'updated_cv' => ['label' => 'Updated CV*', 'required' => true],
      'research_proposal' => ['label' => 'Research Proposal*', 'required' => true],
      'professional_recommendation_letter' => ['label' => 'Professional Recommendation Letter', 'required' => false],
      'academic_recommendation_letter' => ['label' => 'Academic Recommendation Letter', 'required' => false],
      'ilets_elt' => ['label' => 'ILETS /ELT', 'required' => false],
    ],
  ];


  public $app_files_fields = [

    'passport' => 'Passport',
    'high_school_certificate' => 'High School Ccertificate',
    'personal_statement' => 'Personal Statement',
    'academic_recommendation_letter' => 'Academic Recommendation Letter',

    'university_transcript' => 'University Transcript',
    'recommendation_letter' => 'Recommendation Letter',

    'updated_cv' => 'Updated CV',
    'professional_recommendation_letter' => 'Professional Recommendation Letter',

    'research_proposal' => 'Research Proposal',
    'ilets_elt' => 'ILETS /ELT',

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

    $this->setTable('applications');
    $this->setDisplayField('user_id');
    $this->setPrimaryKey('id');
    $this->addBehavior('Timestamp');

    // $this->addBehavior('ImageFile', ['ImageUpload' => ['image' => []]]);

    // $this->addBehavior('ImageFile', [

    //   'FileUpload' => [
    //     'passport' => [
    //       'file_name' => '{$rand}_{$file_name}',
    //       'extensions' => array('pdf'/*, 'doc', 'docx'*/),
    //       'path' => 'files/applications/',
    //       'required' => true,
    //     ],
    //     'ilets_elt' => [
    //       'file_name' => '{$rand}_{$file_name}',
    //       'extensions' => array('pdf'/*, 'doc', 'docx'*/),
    //       'path' => 'files/applications/',
    //       'required' => true,
    //     ],
    //   ],
    // ]);

    $this->belongsTo('Users')->setForeignKey('user_id');
    $this->belongsTo('Services')->setForeignKey('service_id');
    $this->belongsTo('Universities')->setForeignKey('university_id');
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

    // $validator->notEmptyString('passport', 'This field is required.');
    // $validator->notEmptyString('ilets_elt', 'This field is required.');
    return $validator;
  }



  public function validationRegister(Validator $validator): Validator
  {


    return $validator;
  }
}
