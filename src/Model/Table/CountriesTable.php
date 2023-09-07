<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class CountriesTable extends Table
{


    public $filters = [
        'country_name' => 'like',
        // 'code' => array('type' => 'like', 'options' => array('type' => 'text')),

        'continent',
        'is_destination' => ['options' => ['options' => [1 => 'Yes', 0 => 'No']]],
    ];

    // public $continents = [

    //     'uk' => 'UK', 'eur' => 'Europe', 'na' => 'North America',
    //     'other' => 'Other Countries',
    // ];
    public $continents = [

        'uk' => 'UK', 'eur' => 'Europe', 'na' => 'North America',
        'other' => 'Other Countries',
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

        $this->setTable('countries');
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
                        'path' => 'uploads/countries',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],
                    // 'mobile_image' => [
                    //     'resize' => ['width' => 360, 'height' => 0],
                    //     'datePath' => ['path' => ''],
                    //     // 'datePath' => false,
                    //     // 'path' => WWW_ROOT . 'img/countries',
                    //     'path' => 'uploads/countries',
                    //     'file_name' => '{$rand}_{$file_name}',
                    //     'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
                    // ],

                    'banner_image' => [
                        'resize' => ['width' => 1440, 'height' => 439],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/countries',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],

                    'flag' => [
                        'resize' => ['width' => 1440, 'height' => 439],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'img/flags',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],

                ]
            ]
        );

        $this->hasMany('Universities')->setForeignKey('country_id');
        $this->hasMany('Testimonials')->setForeignKey('country_id');
        $this->hasMany('UniveristyCourses')->setForeignKey('country_id');
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('country_name', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        Cache::delete('book_appointment_destinations');
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
