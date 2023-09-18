<?php

declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Cache\Cache;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class EventsTable extends Table
{


    public $filters = [
        'title' => array('type' => 'like', 'options' => array('type' => 'text')),
        'show_on_home'
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

        $this->setTable('events');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');


        $this->addBehavior(
            'ImageFile',
            [
                'ImageUpload' => [
                    'icon' => [
                        'resize' => ['width' => 87, 'height' => 83],
                        'datePath' => ['path' => ''],
                        'width' => 87, 'height' => 83,
                        // 'datePath' => false,

                        'extensions' => array('jpg', 'png', 'gif', 'jpeg', 'svg'),
                        'path' => 'uploads/events/icon',
                        'file_name' => '{$rand}_{$file_name}'
                    ],
                    'main_image' => [
                        'resize' => [],
                        'datePath' => ['path' => ''],
                        'width' => false, 'height' => false,
                        // 'datePath' => false,
                        'path' => 'uploads/events',
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
                        'path' => 'uploads/events',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '60', 'height' => '60']
                        ],
                    ],
                    'image2' => [
                        'resize' => ['width' => 270, 'height' => 270],
                        'datePath' => ['path' => ''],
                        'width' => 270, 'height' => 270,
                        // 'datePath' => false,
                        'path' => 'uploads/events',
                        'file_name' => '{$rand}_{$file_name}',

                        'thumbs' => [
                            ['thumb_prefix' => 'thumb_', 'width' => '60', 'height' => '60']
                        ],
                    ],
                    // 'video_thumb' => [
                    //     'resize' => ['width' => 767, 'height' => 400],
                    //     'datePath' => ['path' => ''],
                    //     'width' => 767, 'height' => 400,
                    //     // 'datePath' => false,
                    //     'path' => 'files/event_videos',
                    //     'file_name' => '{$rand}_{$file_name}',
                    // ],
                    // 'mobile_image' => [
                    //     'resize' => ['width' => 360, 'height' => 0],
                    //     'datePath' => ['path' => ''],
                    //     'width' => 360, 'height' => 0,
                    //     // 'datePath' => false,
                    //     // 'path' => WWW_ROOT . 'Eventsevents',
                    //     'path' => 'uploads/events',
                    //     'file_name' => '{$rand}_{$file_name}',
                    //     'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
                    // ],

                    // 'banner_image' => [
                    //     'resize' => ['width' => 1440, 'height' => 439],
                    //     'width' => 1440, 'height' => 439,
                    //     'datePath' => ['path' => ''],
                    //     // 'datePath' => false,
                    //     'path' => 'uploads/events',
                    //     'file_name' => '{$rand}_{$file_name}',

                    //     'thumbs' => [
                    //         ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                    //     ],
                    // ],

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
        Cache::delete('home_events');
        Cache::delete('events_app_menu_list');
        clearViewCache();
    }


    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {

        if (
            ($entity->isNew() && empty($entity->permalink))
            // || (!empty($entity->title) && $entity->isDirty('title'))
        ) {
            $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->title, '_')));
        }
        // Move video File
        // if (!empty($entity->video) && file_exists($this->tempPath . $entity->video)) {
        //     debug($entity);
        //     die;
        //     if (!file_exists($this->finalPath)) {
        //         mkdir($this->finalPath, 0775, true);
        //     }
        //     $old_file = $entity->video;

        //     $fileName = $entity->video;
        //     $name = Text::slug(substr($fileName, 0, -4), '-');
        //     $ext = substr($fileName, -4);
        //     $fileName = $name . $ext;

        //     $move = rename($this->tempPath . $entity->video, $this->finalPath . $fileName);

        //     if ($move) {

        //         $entity->video = $fileName;
        //         $this->save($entity);
        //         $this->deleteOldVideo($old_file);
        //     }
        // }

        return true;
    }

    public function deleteOldVideo($name = '', $id = false)
    {
        // if (!empty($name)) {
        //     if (file_exists($this->finalPath . $name)) {
        //         unlink($this->finalPath . $name);
        //     }
        // }

        return true;
    }
}
