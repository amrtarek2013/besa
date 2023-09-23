<?php

declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Cache\Cache;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class FairEventsTable extends Table
{


    public $filters = [
        'title' => array('type' => 'like', 'options' => array('type' => 'text')),
    ];

    public $centerBoxStyle = [0 => 'Full Width', 1 => 'Rouded Box'];

    protected $tempPath = WWW_ROOT . 'files' . DS . 'temp_files' . DS;
    protected $finalPath = WWW_ROOT . 'files' . DS . 'event_videos' . DS;


    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('fair_events');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');


        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'main_image' => [
                        'resize' => [],
                        'datePath' => ['path' => ''],
                        'width' => false, 'height' => false,
                        // 'datePath' => false,
                        'path' => 'uploads/fair_events',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '60', 'height' => '60']
                        ],
                    ],
                    'image' => [
                        'resize' => ['width' => 400, 'height' => 400],
                        'datePath' => ['path' => ''],
                        'width' => 400, 'height' => 400,
                        // 'datePath' => false,
                        'path' => 'uploads/fair_events',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '60', 'height' => '60']
                        ],
                    ],

                ]
            ]
        );
        $this->hasMany('EventImages')->setForeignKey('event_id');
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('title', 'This field is required.');

        return $validator;
    }

    public function afterSave($event, $entity, $options)
    {
        Cache::delete('fair_events');
        clearViewCache();
    }


    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
    }


    public function beforeMarshal(EventInterface $event, ArrayObject $entity, ArrayObject $options)
    {
        if (is_array($entity['countries'])) {
            $entity['countries'] = "," . implode(',', $entity['countries']) . ",";
        }
        if (is_array($entity['universities'])) {
            $entity['universities'] = "," . implode(',', $entity['universities']) . ",";
        }
    }
}
