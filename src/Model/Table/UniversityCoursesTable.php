<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validation;
use Cake\Validation\Validator;
use Psr\Http\Message\UploadedFileInterface;

class UniversityCoursesTable extends Table
{


    public $filters = [
        // 'course_id' => array('type' => 'like', 'options' => array('title' => 'Course', 'type' => 'select')),
        'university_id' => array('title' => 'University', 'type' => 'select'),
        // 'university_title' => array('type' => 'like'),
        'course_name' => array('type' => 'like'),
        // 'university_name' => array('type' => 'like'),
        'country_id' => array('title' => 'Destination', 'type' => 'select'),

        'subject_area_id' => array('title' => 'Subject Area', 'type' => 'select'),
        'study_level_id' => array('title' => 'Study Level', 'type' => 'select'),
        // 'is_partner' => ['options' => ['options' => [1 => 'Yes', 0 => 'No']]],
        // 'show_on_destination' => ['options' => ['options' => [1 => 'Yes', 0 => 'No']]],

        'duration' => array('type' => 'like'),
        'fees' => array('type' => 'like'),
    ];

    public $types = [0 => 'Full Service'];

    public $studyLevels = [1 => 'Level 1', 2 => 'Level 2', 3 => 'Level 3', 4 => 'Level 4', 5 => 'Level 5',];


    public $schema_of_export = array(
        'id',
        'course_name',

        'study_level_id',
        'study_level',

        'subject_area_id',
        'subject_area',

        'university_id',
        'university',

        'country_id',
        'country',

        'total_fees',
        'fees',
        'duration',
        'intake',

        'description',
        'active' => 'Active'

    );

    public $schema_of_import = array(
        'id',
        'course_name',

        'study_level_id',
        'study_level',

        'subject_area_id',
        'subject_area',

        'university_id',
        'university',

        'country_id',
        'country',

        'total_fees',
        'fees',
        'duration',
        'intake',

        'description',
        'active' => 'Active'
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

        $this->setTable('university_courses');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');


        // $this->addBehavior(
        //     'ImageFile',
        //     [
        //         'ImageUpload' => [
        //             'image' => [
        //                 'resize' => ['width' => 414, 'height' => 414],
        //                 'datePath' => ['path' => ''],
        //                 // 'datePath' => false,
        //                 'width' => 414, 'height' => 414,
        //                 'path' => 'uploads/university_courses',
        //                 'file_name' => '{$rand}_{$file_name}',

        //                 'thumbs' => [
        //                     ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
        //                 ],
        //             ],
        //             // 'mobile_image' => [
        //             //     'resize' => ['width' => 360, 'height' => 0],
        //             //     'datePath' => ['path' => ''],
        //             //     // 'datePath' => false,
        //             //     // 'path' => WWW_ROOT . 'img/university_courses',
        //             //     'path' => 'uploads/university_courses',
        //             //     'file_name' => '{$rand}_{$file_name}',
        //             //     'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
        //             // ],

        //             'banner_image' => [
        //                 'resize' => ['width' => 1440, 'height' => 439],
        //                 'datePath' => ['path' => ''],
        //                 // 'datePath' => false,
        //                 'width' => 1440, 'height' => 439,
        //                 'path' => 'uploads/university_courses',
        //                 'file_name' => '{$rand}_{$file_name}',

        //                 'thumbs' => [
        //                     ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
        //                 ],
        //             ],

        //         ]
        //     ]
        // );


        $this->belongsTo('Courses')->setForeignKey('course_id');
        $this->belongsTo('Majors')->setForeignKey('major_id');
        $this->belongsTo('Countries')->setForeignKey('country_id');
        $this->belongsTo('Universities')->setForeignKey('university_id');
        $this->belongsTo('Services')->setForeignKey('service_id');
        $this->belongsTo('StudyLevels')->setForeignKey('study_level_id');
        $this->belongsTo('SubjectAreas')->setForeignKey('subject_area_id');
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('course_id', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');
        // $validator->notEmptyString('description', 'This field is required.');
        $validator->notEmptyString('duration', 'This field is required.');
        $validator->notEmptyString('intake', 'This field is required.');
        $validator->notEmptyString('fees', 'This field is required.');
        // $validator->notEmptyString('country_id', 'This field is required.');
        $validator->notEmptyString('university_id', 'This field is required.');
        $validator->notEmptyString('study_level_id', 'This field is required.');
        // $validator->notEmptyString('subject_area_id', 'This field is required.');
        // $validator->notEmptyString('university_id', 'This field is required.');

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

        // if ($entity->isNew() && empty($entity->permalink)) {
        //     $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->course_name, '_')));
        // }

        // if (empty($entity->banner_image)) {
        //     $entity->banner_image = str_replace('\\','',$entity->banner_image);
        // }
    }

    /////////////////////////////////////////
    ////////// Validate Add/edit
    public function validationAddEdit(Validator $validator): Validator
    {

        $validator->notEmptyString('course_name', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');
        // $validator->notEmptyString('description', 'This field is required.');
        $validator->notEmptyString('duration', 'This field is required.');
        $validator->notEmptyString('intake', 'This field is required.');
        $validator->notEmptyString('fees', 'This field is required.');
        $validator->notEmptyString('country_id', 'This field is required.');
        $validator->notEmptyString('university_id', 'This field is required.');
        // $validator->notEmptyString('subject_area_id', 'This field is required.');
        $validator->notEmptyString('study_level_id', 'This field is required.');
        return $validator;
    }
}
