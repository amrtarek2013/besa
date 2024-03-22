<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class SlidersTable extends Table
{


    public $filters = [
        'title' => array('type' => 'like', 'options' => array('type' => 'text')),
    ];

    public $types = [0 => 'Full Slider'];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sliders');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'image' => [
                        'resize' => ['width' => 1180, 'height' => 688],
                        'width' => 1180, 'height' => 688,
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/sliders',
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
                        // 'path' => WWW_ROOT . 'img/sliders',
                        'path' => 'uploads/sliders',
                        'file_name' => '{$rand}_{$file_name}',
                        'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
                    ]
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

        Cache::delete('home_sliders');
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

        clearViewCache();
    }
}
