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

    public $schema_of_export = array(
        'id',
        'university_name',
        'destination',
        'rank',
        'description',

    );

    public $schema_of_import = array(
        // 'id',
        'university_name',
        'destination',
        'rank',
        'description'
    );

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
                        'resize' => ['width' => 200, 'height' => 120],
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'width' => 200, 'height' => 120,
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

        $validator
            ->uploadedFile('image', [
                'types' => ['image/png', 'image/jpg', 'image/jpeg'], // only PNG image files
                'minSize' => 1024, // Min 1 KB
                'maxSize' => 1024 * 1024 // Max 1 MB
            ])
            
            ->add('image', 'filename', [
                'rule' => function (UploadedFileInterface $file) {
                    // filename must not be a path
                    $filename = $file->getClientFilename();
                    if (strcmp(basename($filename), $filename) === 0) {
                        return true;
                    }

                    return false;
                }
            ])
            ->add('image', 'extension', [
                'rule' => ['extension', ['png', 'jpg', 'jpeg']] // .png file extension only
            ]);
            // ->isArray('image')
            // ->allowEmptyArray('image');

        $validator->uploadedFile('logo', [
            'types' => ['image/png', 'image/jpg', 'image/jpeg'], // only PNG image files
            'minSize' => 1024, // Min 1 KB
            'maxSize' => 1024 * 1024 // Max 1 MB
        ])
            // ->add('logo', 'minSize', [
            //     'rule' => ['imageSize', [
            //         // Min 10x10 pixel
            //         'width' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
            //         'height' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
            //     ]]
            // ])
            // ->add('logo', 'maxSize', [
            //     'rule' => ['imageSize', [
            //         // Max 100x100 pixel
            //         'width' => [Validation::COMPARE_LESS_OR_EQUAL, 100],
            //         'height' => [Validation::COMPARE_LESS_OR_EQUAL, 100],
            //     ]]
            // ])
            ->add('logo', 'filename', [
                'rule' => function (UploadedFileInterface $file) {
                    // filename must not be a path
                    $filename = $file->getClientFilename();
                    if (strcmp(basename($filename), $filename) === 0) {
                        return true;
                    }

                    return false;
                }
            ])
            ->add('logo', 'extension', [
                'rule' => ['extension', ['png', 'jpg', 'jpeg']] // .png file extension only
            ])->isArray('logo')
            ->allowEmptyArray('logo');

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

        if ($entity->isNew() && empty($entity->permalink)) {
            $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->university_name, '_')));
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
