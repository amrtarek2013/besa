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
class FilesTable extends Table
{


    public $filters = [];
    // public $filters = ['file'=>'like'];
    public $modelName = 'files';
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

    public $status_labels = [
                            0 =>"New",
                            1 =>"Under Classification",
                            2 =>"Classified as Good",
                            3 =>"Classified as Bad",
                            4 =>"Classified as Mix",
                            5 =>"Under annotation",
                            6 =>"Annotated and Ready for Review",
                            7 =>"Annotation Rejected",
                            8 =>"Under Review",
                            9 =>"Reviewed and accepted",
                            10 =>"Reviewed and rejected",
                            11 =>"Released on daily releases",
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


        $this->setDisplayField('file');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        // $this->hasMany('FileLogs');
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
