<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class CareersTable extends Table
{


    public $filters = [
        'title' => 'like',
        // 'code' => array('type' => 'like', 'options' => array('type' => 'text')),

        // 'continent',
    ];

    public $continents = [

        'uk' => 'UK', 'eur' => 'Europe', 'na' => 'North America',
        'other' => 'Other Careers',
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

        $this->setTable('careers');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'image' => [
                        'resize' => ['width' => 1600, 'height' => 440],
                        'datePath' => ['path' => ''],
                        'width' => 1600, 'height' => 440,
                        // 'datePath' => false,
                        'path' => 'uploads/careers',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '120', 'height' => '60']
                        ],
                    ],

                ],
                'FileUpload' => [
                    'certificate' => [
                        'file_name' => '{$rand}_{$file_name}',
                        'path' => 'uploads/careers',

                        'extensions' => array('pdf'),

                    ]
                ],
            ]
        );
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('title', 'This field is required.');
        // $validator->notEmptyString('text', 'This field is required.');

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        Cache::delete('careersList');
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

        if (($entity->isNew() && empty($entity->permalink))
            || (!empty($entity->title)  && $entity->isDirty('title'))
        ) {
            $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->title, '_')));
        }
    }
}
