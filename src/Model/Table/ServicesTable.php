<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class ServicesTable extends Table
{


    public $filters = [
        'title' => array('type' => 'like', 'options' => array('type' => 'text')),
        'category',
        'show_on_home'
    ];

    public $types = [0 => 'Pathway Programs', 1 => 'Direct Entry', 2 => 'Others'];
    public $searchDegreeOptions = [1 => 'Bachelor/Postgraduate Degree', 2 => 'Boarding/Summer Degree'];
    // public $types = [0 => ['title' => 'Pathway Programs', 'icon' => ''], 1 => ['title' => 'Direct Entry', 'icon' => ''], 2 => ['title' => 'Others', 'icon' => '']];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('services');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [

                    'icon' => [
                        'resize' => ['width' => 32, 'height' => 32],
                        'width' => 32, 'height' => 32,
                        'datePath' => ['path' => ''],

                        'extensions' => array('jpg', 'png', 'gif', 'jpeg', 'svg'),
                        // 'datePath' => false,
                        'path' => 'uploads/services/icon',
                        'file_name' => '{$rand}_{$file_name}'
                    ],
                    'image' => [
                        'resize' => ['width' => 500, 'height' => 418],
                        'width' => 500, 'height' => 418,
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/services',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],
                    'mobile_image' => [
                        'resize' => ['width' => 360, 'height' => 0],
                        'width' => 360, 'height' => 0,
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        // 'path' => WWW_ROOT . 'img/services',
                        'path' => 'uploads/services',
                        'file_name' => '{$rand}_{$file_name}',
                        'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
                    ],

                    'banner_image' => [
                        'resize' => ['width' => 1440, 'height' => 439],
                        'width' => 1440, 'height' => 439,
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/services',
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


        $validator->notEmptyString('title', 'This field is required.');

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
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
}
