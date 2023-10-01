<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Cache\Cache;
use Cake\Utility\Hash;

class SnippetsTable extends Table
{


    public $filters = [
        'title' => 'like',
        'name' => '=',
        'category' => '='
    ];

    public $snippetCategories = [
        0 => 'General',
        1 => 'HomePage Snippets',
        2 => 'Services Snippets',
        3 => 'Events Snippets',
        4 => 'Countries Snippets',
        5 => 'Universities Snippets',
        6 => 'AboutUs Snippets',
        7 => 'ContactUs Snippets',
        8 => 'WhereToStudy Snippets',
        9 => 'B2BServices Snippets',
        10 => 'Other Snippets',
    ];


    public $snippet_categoriesList = [
        'General Snippets' => 0,
        'HomePage Snippets' => 1,
        'Services Snippets' => 2,
        'Events Snippets' => 3,
        'Countries Snippets' => 4,
        'Universities Snippets' => 5,
        'AboutUs Snippets' => 6,
        'ContactUs Snippets' => 7,
        'WhereToStudy Snippets' => 8,
        'B2BServices Snippets' => 9,
        'Other Snippets' => 10
    ];

    public $modalPopupIDs = [
        'modal' => 'User Login',
        'registerbox' => 'User Register',
        'forget_password' => 'User forget password',
        'userLogin' => 'User Login',
        'userRegisterbox' => 'User Register',
        'user_forget_password' => 'User forget password'
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('snippets');
        $this->setPrimaryKey('id');

        $this->addBehavior('ImageFile', [
            'ImageUpload' => [
                'image' => [
                    'path' => 'files/snippets',
                    'file_name' => '{$rand}_{$file_name}',
                    'width' => 482, 'height' => 437,
                    'resize' => ['width' => 482, 'height' => 437],
                    // 'thumbs' => [
                    //     ['thumb_prefix' => 'thumb_', 'width' => '294', 'height' => '165']
                    // ],
                ],
            ]
        ]);
    }



    public function validationDefault(Validator $validator): Validator
    {
        // $validator->requirePresence('name')
        //     ->notEmptyString('name', 'Please fill this field');
        return $validator;
    }


    public function getContent($name)
    {

        if (Cache::read($name, '_snippets_')) {
            return Cache::read($name, '_snippets_');
        } else {
            $mdl = new self;

            $conditions['name'] = $name;
            $snippet = $mdl->find()->where(['name' => $name, 'active' => 1])->first();
            if ($snippet) {
                Cache::write($name, $snippet->content, '_snippets_');
                return ($snippet->content);
            } else {

                Cache::write($name, '', '_snippets_');
                return '';
            }
        }
    }
    public function getPopupImage($name)
    {

        if (Cache::read($name . "_image", '_snippets_')) {
            return Cache::read($name . "_image", '_snippets_');
        } else {
            $mdl = new self;

            $conditions['name'] = $name;
            $snippet = $mdl->find()->where(['name' => $name])->first();
            // print_r($snippet);die;
            if ($snippet) {
                Cache::write($name . "_image", "/files/snippets/" . $snippet->image, '_snippets_');
                return ("/files/snippets/" . $snippet->image);
            } else {
                return '';
            }
        }
    }


    public function afterSave($event, $entity, $options)
    {

        // Cache::delete('snippets', '_snippets_');
        clearViewCache();
    }
    public function updateCache($name)
    {
        Cache::delete($name, '_snippets_');
        Cache::delete($name . "_image", '_snippets_');
        $snippet = $this->find()->where(['name' => $name])->first();

        Cache::write($name, $snippet->content, '_snippets_');
        Cache::write($name . "_image", "/files/snippets/" . $snippet->image, '_snippets_');
        clearViewCache();
    }
}
