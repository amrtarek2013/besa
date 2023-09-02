<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class MenusTable extends Table
{

	public $filters = [
		'title' => 'like',
		'prefix' => [
			'options' => [
				'options' => [
					'admin' => 'Admin area',
					'user' => 'User area',
					'counselor' => 'Counselor area'
					// 'university-admin' => 'University area',

				]
			]
		],
		'parent_id' => [],
		'is_parent' => ['options' => ['options' => [0 => 'No', 1 => 'Yes']]],
		'active' => ['options' => ['options' => [0 => 'No', 1 => 'Yes']]],

	];

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */

	public $prefixs = [
		'admin' => 'Admin area',
		'user' => 'User area',
		'counselor' => 'Counselor area'
		// 'university-admin' => 'University area',
	];
	public $types = [0 => 'Internal link', 1 => 'External link'];

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('menus');
		$this->setPrimaryKey('id');
		$this->addBehavior('Timestamp');
		// $this->addBehavior('Tree');

		$this->addAssociations([
			'hasMany' => [
				'SubMenu' =>
				[
					'className' => 'App\Model\Table\MenusTable',
					'foreignKey' => 'parent_id',
					'dependent' => true,
					'conditions' => ['active' => true],
					'sort' => ['display_order asc'],
				],
			],
		]);

		// $this->belongsTo('Roles')->setForeignKey('role_id');
	}

	public function validationDefault(Validator $validator): Validator
	{

		return $validator;
	}

	public function afterSave($event, $entity, $options)
	{
		Cache::delete('menus', '_menus_');
		clearViewCache();
	}
}
