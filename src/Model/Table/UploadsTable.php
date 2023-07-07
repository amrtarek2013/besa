<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Admins Model
 *
 * @method \App\Model\Entity\Admin get($primaryKey, $options = [])
 * @method \App\Model\Entity\Admin newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Admin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Admin|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Admin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Admin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Admin[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Admin findOrCreate($search, callable $callback = null, $options = [])
 */
class UploadsTable extends Table
{


    public $filters = [/*'name'=>'like'*/];
    public $modelName = 'uploads';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);


        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

          // $this->addBehavior('ImageFile', array(
            // 'ImageUpload'=>['avatar'=>['resize' => false]],
            // 'FileUpload'=>['avatar'=>['file_name' => '{$rand}_{$file_name}']],
            
          // ));
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
        //     ->scalar('name')
        //     ->maxLength('name', 100)
        //     ->allowEmptyString('name');

        // $validator
        //     ->scalar('password')
        //     ->maxLength('password', 100)
        //     ->allowEmptyString('password');

        // $validator
        //     ->uploadedFile('avatar',[]);

        return $validator;
    }



}
