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
class AdminsTable extends Table
{


    public $filters = ['name'=>'like'];
    public $modelName = 'admins';
    
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

          $this->addBehavior('ImageFile', array(
            'ImageUpload'=>['avatar'=>['resize' => false]],
            // 'FileUpload'=>['avatar'=>['file_name' => '{$rand}_{$file_name}']],
            
          ));
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        // $validator
        //     ->scalar('name')
        //     ->maxLength('name', 100)
        //     ->allowEmptyString('name');
        $validator->notEmptyString('name', 'This field is required.');

        // $validator
        //     ->scalar('password')
        //     ->maxLength('password', 100)
        //     ->allowEmptyString('password');

        $validator->minLength('password', 6, 'Passowrd length must be greater than 6 letters.')
                    ->equalToField('password', 'repeat_password', 'Password must be same as the confirm password field');
        $validator->allowEmptyString('password');

            // ->notEmptyString('password', 'This field is required.');
        // $validator->requirePresence('password', 'create');

        // $validator->requirePresence([
        //     'password' => [
        //         'mode' => 'create',
        //         'message' => 'An author is required.',
        //     ]
        // ]);

        // $validator
        //     ->uploadedFile('avatar',[]);

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {

        $rules->add($rules->isUnique(['name'], 'This username has already been used.'));
        // $rules->add($rules->isUnique(['user_name'], 'This data has already been used.'));

        return $rules;
    }



}
