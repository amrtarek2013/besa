<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CareerAssessmentsSurveyTable extends Table
{


    public $filters = [];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('career_assessments_survey');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        
        


    }



    public function validationDefault(Validator $validator): Validator
    {

        return $validator;
    }

}
