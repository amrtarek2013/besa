<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TestimonialsTable extends Table
{


    public $filters = [];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('testimonials');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        // $this->addBehavior('ImageFile',['ImageUpload' =>['image' => []]]);          

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [

                    'image' => [
                        'resize' => ['width' => 136, 'height' => 136],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 136, 'height' => 136,
                        'path' => 'uploads/testimonials',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],
                    'video_thumb' => [
                        'resize' => ['width' => 418, 'height' => 255],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 418, 'height' => 255,
                        'path' => 'uploads/testimonials',
                        'file_name' => '{$rand}_{$file_name}',

                        // 'thumbs' => [
                        //     ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        // ],
                    ],
                ]
            ]
        );
    }


    public function beforeSave($event, $entity, $options)
    {
        // debug($entity);die;
    }
    public function validationDefault(Validator $validator): Validator
    {

        
        $validator->notEmptyString('client_name', 'This field is required.');
        $validator->notEmptyString('university', 'This field is required.');
        
        $validator->notEmptyString('text', 'This field is required.');
        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        clearViewCache();
    }
}
