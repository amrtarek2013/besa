<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;

class PagesTable extends Table
{


    public $filters = [
        // 'title'=>'like'
        'id',
        'title' => 'like',
        'permalink' => 'like',
        'active' => ['options' => ['options' => [0 => 'Not Active', 1 => 'Active']]]
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

        $this->setTable('pages');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');


        $this->addBehavior('ImageFile', [
            'ImageUpload' => ['banner_image' => [
                'path' => 'img/uploads/page_banner/',
                'file_name' => '{$rand}_{$file_name}',
                'width' => 1440, 'height' => 439,
                // 'resize' => ['width' => 482, 'height' => 437],
                // 'thumbs' => [
                //     ['thumb_prefix' => 'thumb_', 'width' => '294', 'height' => '165']
                // ],
            ]]
        ]);
    }
    public function beforeSave($event, $entity, $options)
    {
        // $entity->permalink = strtolower(Text::slug($entity->title,'_'));

        if ($entity->isNew() && empty($entity->permalink)) {
            $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->title, '_')));
        }
    }


    public function validationDefault(Validator $validator): Validator
    {

        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
        $validator
            ->scalar('title')
            ->notBlank('title');
        $validator
            ->scalar('content')
            ->notBlank('content');




        return $validator;
    }
}
