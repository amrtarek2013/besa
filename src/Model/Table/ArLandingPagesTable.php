<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ArLandingPagesTable extends Table
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

        $this->setTable('ar_landing_pages');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'right_logo' => [
                        'resize' => ['width' => 60, 'height' => 41],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/landings',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '60', 'height' => '41']
                        ],
                    ],

                    'left_image' => [
                        'resize' => ['width' => 728, 'height' => 700],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/landings',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '120', 'height' => '110']
                        ],
                    ],

                ]
            ]
        );
    }



    public function validationDefault(Validator $validator): Validator
    {

        return $validator;
    }
}
