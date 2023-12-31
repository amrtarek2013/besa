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

class AcademicCoursesTable extends Table
{


    public $filters = [
        'course_name' => array('type' => 'like', 'options' => array('type' => 'text')),
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

        $this->setTable('academic_courses');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'image' => [
                        'resize' => ['width' => 414, 'height' => 414],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 414, 'height' => 414,
                        'path' => 'uploads/academic_courses',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],
                    // 'mobile_image' => [
                    //     'resize' => ['width' => 360, 'height' => 0],
                    //     'datePath' => ['path' => ''],
                    //     // 'datePath' => false,
                    //     // 'path' => WWW_ROOT . 'img/academic_courses',
                    //     'path' => 'uploads/academic_courses',
                    //     'file_name' => '{$rand}_{$file_name}',
                    //     'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
                    // ],

                    'banner_image' => [
                        'resize' => ['width' => 1440, 'height' => 439],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 1440, 'height' => 439,
                        'path' => 'uploads/academic_courses',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],

                ]
            ]
        );
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('course_name', 'This field is required.');
        $validator->notEmptyString('code', 'This field is required.');
        $validator->notEmptyString('description', 'This field is required.');
        $validator->notEmptyString('duration', 'This field is required.');
        $validator->notEmptyString('intake', 'This field is required.');
        $validator->notEmptyString('fees', 'This field is required.');
        $validator->notEmptyString('city', 'This field is required.');
        $validator->notEmptyString('country_id', 'This field is required.');
        $validator->notEmptyString('university_id', 'This field is required.');
        $validator->notEmptyString('subject_area_id', 'This field is required.');
        $validator->notEmptyString('university_id', 'This field is required.');

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

        if ($entity->isNew() && empty($entity->permalink)) {
            $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->title, '_')));
        }

        // if (empty($entity->banner_image)) {
        //     $entity->banner_image = str_replace('\\','',$entity->banner_image);
        // }
    }

    /////////////////////////////////////////
    ////////// Validate Add/edit
    public function validationAddEdit(Validator $validator): Validator
    {
        
        $validator->notEmptyString('course_name', 'This field is required.');
        $validator->notEmptyString('code', 'This field is required.');
        $validator->notEmptyString('description', 'This field is required.');
        $validator->notEmptyString('duration', 'This field is required.');
        $validator->notEmptyString('intake', 'This field is required.');
        $validator->notEmptyString('fees', 'This field is required.');
        $validator->notEmptyString('city', 'This field is required.');
        $validator->notEmptyString('country_id', 'This field is required.');
        $validator->notEmptyString('university_id', 'This field is required.');
        $validator->notEmptyString('subject_area_id', 'This field is required.');
        $validator->notEmptyString('university_id', 'This field is required.');
        return $validator;
    }
}
