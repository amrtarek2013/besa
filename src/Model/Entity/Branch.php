<?php

declare(strict_types=1);

namespace App\Model\Entity;

// use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class Branch extends Entity
{
    // use LazyLoadEntityTrait;

    protected $_virtual = ['location_image_path', 'flag_path'];

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

    protected function _getLocationImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'map.png';
        if (!empty($this->location_image)) {
            $image_path = 'uploads' . DS . 'branches' . DS . $this->location_image;
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }
    protected function _getFlagPath()
    {

        $no_image_path = DS . 'img' . DS . 'flag-egypt.png';
        if (!empty($this->flag)) {
            $image_path = 'uploads' . DS . 'branches' . DS . $this->flag;
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }
}
