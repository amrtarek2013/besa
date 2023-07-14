<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class CountryBenefitsTable extends Table
{


    public $filters = [
        // 'country_name' => 'like',
        // 'code' => array('type' => 'like', 'options' => array('type' => 'text')),
        
        // 'continent',
    ];

    public $continents = [

        'uk' => 'UK', 'eur' => 'Europe', 'na' => 'North America',
        'other' => 'Other CountryBenefits',
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

        $this->setTable('country_benefits');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'image' => [
                        'resize' => ['width' => 295, 'height' => 196],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/country_benefits',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '120', 'height' => '60']
                        ],
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

        if ($entity->isNew() && empty($entity->permalink)) {
            $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->title, '_')));
        }
    }
}
