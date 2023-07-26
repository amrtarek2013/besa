<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validation;
use Cake\Validation\Validator;
use Psr\Http\Message\UploadedFileInterface;

class UniversitiesTable extends Table
{


    public $filters = [
        'university_name' => array('type' => 'like', 'options' => array('type' => 'text')),
        'show_on_destination' => ['options' => ['options' => [1 => 'Yes', 0 => 'No']]],
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

        $this->setTable('universities');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [

                    'logo' => [
                        'resize' => [],
                        // 'width' => 0, 'height' => 0,
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/universities/logo',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '60', 'height' => '60']
                        ],
                    ],
                    'image' => [
                        // 'resize' => ['width' => 414, 'height' => 414],
                        'resize' => ['width' => 230, 'height' => 190],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 230, 'height' => 190,
                        'path' => 'uploads/universities',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [

                            ['thumb_prefix' => 'thumb_', 'width' => '120', 'height' => '100']
                        ],
                    ],
                    // 'mobile_image' => [
                    //     'resize' => ['width' => 360, 'height' => 0],
                    //     'datePath' => ['path' => ''],
                    //     // 'datePath' => false,
                    //     // 'path' => WWW_ROOT . 'img/universities',
                    //     'path' => 'uploads/universities',
                    //     'file_name' => '{$rand}_{$file_name}',
                    //     'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
                    // ],

                    'banner_image' => [
                        'resize' => ['width' => 1440, 'height' => 439],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 1440, 'height' => 439,
                        'path' => 'uploads/universities',
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

        $this->belongsTo('Countries')->setForeignKey('country_id');
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('university_name', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');
        // $validator->email('email', false, 'Please enter a valid email address.')->notEmptyString('email', 'This field is required.');
        // $validator->notEmptyString('telephone', 'This field is required.');
        // $validator->notEmptyString('address', 'This field is required.');
        // $validator->notEmptyString('postcode', 'This field is required.');
        // $validator->notEmptyString('state', 'This field is required.');
        // $validator->notEmptyString('city', 'This field is required.');
        $validator->notEmptyString('country_id', 'This field is required.');

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

        // if (empty($entity->banner_image)) {
        //     $entity->banner_image = str_replace('\\','',$entity->banner_image);
        // }
    }

    /////////////////////////////////////////
    ////////// Validate Add/edit
    public function validationAddEdit(Validator $validator): Validator
    {

        $validator->notEmptyString('university_name', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');
        // $validator->email('email', false, 'Please enter a valid email address.')->notEmptyString('email', 'This field is required.');
        // $validator->notEmptyString('telephone', 'This field is required.');
        // $validator->notEmptyString('address', 'This field is required.');
        // $validator->notEmptyString('postcode', 'This field is required.');
        // $validator->notEmptyString('state', 'This field is required.');
        // $validator->notEmptyString('city', 'This field is required.');
        $validator->notEmptyString('country_id', 'This field is required.');
        return $validator;
    }
}
