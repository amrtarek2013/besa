<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class BranchesTable extends Table
{
    public $filters = [
        'name' => 'like',
        // 'code' => array('type' => 'like', 'options' => array('type' => 'text')),

        // 'continent',
    ];

    public $continents = [

        'uk' => 'UK', 'eur' => 'Europe', 'na' => 'North America',
        'other' => 'Other Branches',
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

        $this->setTable('branches');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'location_image' => [
                        'resize' => ['width' => 348, 'height' => 155],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 348, 'height' => 155,
                        'path' => 'uploads/branches',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            // ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],
                    'flag' => [
                        'resize' => ['width' => 92, 'height' => 92],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 92, 'height' => 92,
                        'path' => 'uploads/branches',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            // ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],
                ],
                // 'ImageUpload' => [
                //     'image' => [
                //         'resize' => ['width' => 629, 'height' => 355],
                //         'datePath' => ['path' => ''],
                //         // 'datePath' => false,
                //         'width' => 629, 'height' => 355,
                //         'path' => 'uploads/branches',
                //         'file_name' => '{$rand}_{$file_name}',

                //         'thumbs' => [
                //             // ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                //         ],
                //     ],
                // ]
            ]
        );
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('name', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        
        Cache::delete('home_branches');
        Cache::delete('contactus_branches');
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

        if (!empty($entity->name) && $entity->isDirty('name')) {
            $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->name, '_')));
        }

        // if (empty($entity->banner_image)) {
        //     $entity->banner_image = str_replace('\\','',$entity->banner_image);
        // }
    }
}
