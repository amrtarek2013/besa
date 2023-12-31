<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
// use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line
// use Cake\Auth\DefaultPasswordHasher;

/**
 * Admin Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $password
 * @property string|null $image
 */
class ApplicationLog extends Entity
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

    protected $_virtual = [];
    public $modelName = 'applicationLogs';
    
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

    public function initialize(array $config): void
    {
    }

    
}
