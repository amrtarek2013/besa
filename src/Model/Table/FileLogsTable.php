<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Files Model
 *
 */
class FileLogsTable extends Table
{


    public $filters = [];
    public $accounting_filters = [
                                // 'admin_id'=>['title'=>"User",'empty'=>"Select a user","required"=>true],
                                'created' => array('type' => 'date_range'),
                                'admin_id'=>['title'=>"User",'empty'=>false,"required"=>false,'multiple'=>true],
                                ];
    public $all_accounting_filters = [
                                'created' => array('type' => 'date_range')
                                ];
    public $tasks_reports_filters = [
                                'created' => array('type' => 'date_range'),
                                'status'=>['title'=>"Task",'empty'=>"Select a task",]
                                ];
    public $team_reports_filters = [
                                'created' => array('type' => 'date_range'),
                                'admin_id'=>['title'=>"User",'empty'=>false,"required"=>false,'multiple'=>true],
                                // 'status'
                                ];
    public $timeline_reports_filters = [
                                'created' => array('type' => 'date_range'),
                                'admin_id'=>['title'=>"User",'empty'=>false,"required"=>false,'multiple'=>true],
                                'status'=>['title'=>"Task",'empty'=>"All Tasks",]
                                ];
    // public $filters = ['file'=>'like'];
    // public $modelName = 'files';
    public $classification_status = [
                                        "1"=>"2", // Good
                                        "2"=>"3", // Bad
                                        "3"=>"4", // Mix
                                    ];
    public $annotation_status = [
        "1"=>"6", // accepted
        "2"=>"7", // rejected
    ];

    public $review_status = [
        "1"=>"9", // accepted
        "2"=>"10", // rejected
    ];

    public $status_tasks = [
        "2"=>"Classification",
        "3"=>"Classification",
        "4"=>"Classification",
        
        "6"=>"Annotation",
        "7"=>"Annotation",
        
        "9"=>"Review",
        "10"=>"Review",
    ];

    public $tasks_codes = [
        "100"=>"Classification",
        "101"=>"Annotation",
        "102"=>"Review",
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


        // $this->setDisplayField('file');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        // $this->belongsTo('Files');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        // $validator
        //     ->integer('id')
        //     ->allowEmptyString('id', null, 'create');

        // $validator
        //     ->scalar('title')
        //     ->maxLength('name', 100)
        //     ->allowEmptyString('name');

        // $validator
        //     ->uploadedFile('avatar',[]);

        return $validator;
    }



}
