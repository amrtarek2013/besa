<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TempFilesTable extends Table
{

    public $absolutePath = WWW_ROOT .'files/temp_files/';
    public $path = '/files/temp_files/';
    public $filters = [];
    public $displayField = 'name';
    public $sort = false;
    public $folder = 'tmpfiles/';
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('temp_files');
        $this->setPrimaryKey('id');
        
                  


    }



    public function validationDefault(Validator $validator): Validator
    {

        return $validator;
    }

}
