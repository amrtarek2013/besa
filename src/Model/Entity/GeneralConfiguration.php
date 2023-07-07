<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
// use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line
// use Cake\Auth\DefaultPasswordHasher;

/**
 * Admin Entity
 *
 */
class GeneralConfiguration extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
     
     // protected $_virtual = ['image_path','full_avatar_path'];
     // public $modelName = 'roles';
     // protected $imagePath =  '/img/uploads/';
     protected $_accessible = [
        '*'=>true,
    ];

    // protected $_accessible = [
    //     'config_group' => true,
    //     'label' => true,
    //     'field' => true,
    //     'value' => true
    // ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [

    ];

    public function initialize(array $config): void
    {
     
    }

    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }


}
