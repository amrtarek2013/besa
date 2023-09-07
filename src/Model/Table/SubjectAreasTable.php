<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class SubjectAreasTable extends Table
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
        'id',
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

        $this->setTable('subject_areas');
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
        //                 'path' => 'uploads/subject_areas',
        //                 'file_name' => '{$rand}_{$file_name}',

        //                 'thumbs' => [
        //                     ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
        //                 ],
        //             ],

        //             'banner_image' => [
        //                 'resize' => ['width' => 1440, 'height' => 439],
        //                 'datePath' => ['path' => ''],
        //                 // 'datePath' => false,
        //                 'width' => 1440, 'height' => 439,
        //                 'path' => 'uploads/subject_areas',
        //                 'file_name' => '{$rand}_{$file_name}',

        //                 'thumbs' => [
        //                     ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
        //                 ],
        //             ],

        //         ]
        //     ]
        // );
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('title', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');
        // $validator->notEmptyString('description', 'This field is required.');
        // $validator->notEmptyString('university_id', 'This field is required.');


        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        
        Cache::delete('book_appointment_subjectareas');
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

        if (
            ($entity->isNew() && empty($entity->permalink))
            || (!empty($entity->title) && $entity->isDirty('title'))
        ) {
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

        $validator->notEmptyString('title', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');
        // $validator->notEmptyString('description', 'This field is required.');
        // $validator->notEmptyString('university_id', 'This field is required.');
        return $validator;
    }
}
