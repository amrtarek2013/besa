<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class StudyLevelsTable extends Table
{


    public $filters = [
        'title' => array('type' => 'like', 'options' => array('type' => 'text')),
    ];


    public $schema_of_export = array(
        'id',
        'title',
        'main_study_level_id'
        // 'destination',
        // 'rank',
        // 'description',

    );

    public $schema_of_import = array(
        // 'id',
        'title',
        'main_study_level_id'
        // 'destination',
        // 'rank',
        // 'description'
    );

    public $types = [0 => 'Pathway Programs', 1 => 'Direct Entry', 2 => 'Others'];

    // public $mainStudyLevels = [0 => 'Undergraduate', 1 => 'Postgraduate'];
    public $mainStudyLevels = [0 => 'Secondary Education', 1 => 'Post Secondary Education', 2 => 'Bachelor\'s Degree', 3 => 'Master\'s Degree', 4 => 'Doctorate'];
    public $mainStudyLevelsTitle = ['Secondary Education' => 0, 'Post Secondary Education' => 1, 'Bachelor\'s Degree' => 2, 'Master\'s Degree' => 3, 'Doctorate' => 4];
    /*
- Secondary Education 
- Post Secondary Education 
- Bachelor's Degree 
- Master's Degree
- Doctorate 


- Foundation 
- Undergraduate 
- Postgraduate 
- PhD
- English Course 
- School boarding 
    */

    public $searchDegreeOptions = [1 => 'Bachelor/Postgraduate Degree', 2 => 'Boarding/Summer Degree'];
    // public $types = [0 => ['title' => 'Pathway Programs', 'icon' => ''], 1 => ['title' => 'Direct Entry', 'icon' => ''], 2 => ['title' => 'Others', 'icon' => '']];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('study_levels');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [

                    'icon' => [
                        'resize' => ['width' => 32, 'height' => 32],
                        'width' => 32, 'height' => 32,
                        'datePath' => ['path' => ''],

                        'extensions' => array('jpg', 'png', 'gif', 'jpeg', 'svg'),
                        // 'datePath' => false,
                        'path' => 'uploads/study_levels/icon',
                        'file_name' => '{$rand}_{$file_name}'
                    ],
                    'image' => [
                        'resize' => ['width' => 500, 'height' => 418],
                        'width' => 500, 'height' => 418,
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/study_levels',
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
                        // 'path' => WWW_ROOT . 'img/study_levels',
                        'path' => 'uploads/study_levels',
                        'file_name' => '{$rand}_{$file_name}',
                        'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
                    ],

                    'banner_image' => [
                        'resize' => ['width' => 1440, 'height' => 439],
                        'width' => 1440, 'height' => 439,
                        'datePath' => ['path' => ''],
                        // 'datePath' => false,
                        'path' => 'uploads/study_levels',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                        ],
                    ],

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
}
