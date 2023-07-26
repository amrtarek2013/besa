<?php

declare(strict_types=1);

namespace App\Model\Entity;

// use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class Enquiry extends Entity
{
    // use LazyLoadEntityTrait;

protected $_virtual = [];

    protected $_accessible = [
        '*' => true,
    ];



    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */

    protected $_hidden = [];

    public function initialize(array $config): void
    {
    }

    // protected function _getImagePath()
    // {

    //     $no_image_path = DS . 'img' . DS . 'hero-bg6.png';
    //     if (!empty($this->image)) {
    //         $image_path = 'uploads' . DS . 'countries' . DS . str_replace(DS,"",$this->image);
    //         if (file_exists(WWW_ROOT . $image_path))
    //             return DS . $image_path;
    //         else
    //             return $no_image_path;
    //     }
    //     return $no_image_path;
    // }
}
