<?php
declare (strict_types = 1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Menu extends Entity {
	protected $_virtual = ['full_link','is_opened'];

	protected $_accessible = [
		'*' => true,
	];

	/**
	 * Fields that are excluded from JSON versions of the entity.
	 *
	 * @var array
	 */

	protected $_hidden = [

	];

	public function initialize(array $config): void {

	}

	protected function _getFullLink() {
		if ($this->type == 1) {
			return $this->link;
		} else {
			return '/' . $this->prefix . $this->link;
		}

	}

}
