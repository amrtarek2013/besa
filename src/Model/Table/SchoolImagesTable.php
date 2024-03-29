<?php

declare(strict_types=1);

namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class SchoolImagesTable extends Table
{


    public $filters = [
        'title' => array('type' => 'like', 'options' => array('type' => 'text')),
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

        $this->setTable('school_images');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [

                    'image' => [
                        // 'resize' => ['width' => 313, 'height' => 266],
                        'resize' => ['width' => 1013, 'height' => 548],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        // 'width' => 313, 'height' => 266,
                        'width' => 1013, 'height' => 548,
                        'path' => 'uploads/school_images',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => 120, 'height' => 60],
                        ],
                    ],
                    // 'mobile_image' => [
                    //     'resize' => ['width' => 360, 'height' => 0],
                    //     'datePath' => ['path' => ''],
                    //     // 'datePath' => false,
                    //     'path' => 'uploads/school_images',
                    //     'file_name' => '{$rand}_{$file_name}',
                    //     'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
                    // ],

                ]
            ]
        );

        $this->belongsTo('Schools')->setForeignKey('school_id');
    }



    public function validationDefault(Validator $validator): Validator
    {

        // $validator->notEmptyString('title', 'This field is required.');

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
    }
}
