<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class CareerImagesTable extends Table
{


    public $filters = [
        'title' => 'like',
        // 'code' => array('type' => 'like', 'options' => array('type' => 'text')),
        
        // 'continent',
    ];

    public $continents = [

        'uk' => 'UK', 'eur' => 'Europe', 'na' => 'North America',
        'other' => 'Other CareerImages',
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

        $this->setTable('career_images');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'image' => [
                        'resize' => ['width' => 279, 'height' => 243],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/career_images',
                        'file_name' => '{$rand}_{$file_name}',

                        // 'thumbs' => [
                        //     ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        // ],
                    ],
                    
                ]
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
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

        // if ($entity->isNew() && empty($entity->permalink)) {
        //     $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->title, '_')));
        // }
    }
}
