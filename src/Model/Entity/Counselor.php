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
class Counselor extends Entity
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

    protected $_virtual = ['image_path', 'thumb_image_path'];
    public $modelName = 'counselors';
    // protected $imagePath =  '/img/uploads/';
    protected $_accessible = [
        '*' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        // 'password',
    ];

    public function initialize(array $config): void
    {
    }
    ///img/new-images/profile-test01.png

    protected function _getImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'new-images' . DS . 'profile-test01.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'counselors' . DS . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getThumbImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'new-images' . DS . 'profile-test01.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'counselors' . DS . "thumb_" . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else

            return null;
        }
    return null;
    }
}
