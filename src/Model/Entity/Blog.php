<?php

declare(strict_types=1);

namespace App\Model\Entity;

// use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class Blog extends Entity
{
    // use LazyLoadEntityTrait;

    protected $_virtual = ['image_path', 'thumb_image_path','header_image_path', 'thumb_header_image_path'];

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

    protected function _getImagePath()
    {

        $no_image_path = DS . 'img' . DS . '230x190.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'blogs' . DS . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getThumbImagePath()
    {

        $no_image_path = DS . 'img' . DS . '30x190.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'blogs' . DS . "thumb_" . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return null;
        }
        return null;
    }

    protected function _getHeaderImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'ug-study-homepage-banner-reg.png';
        if (!empty($this->header_image)) {
            $image_path = 'uploads' . DS . 'blogs' . DS . str_replace(DS, "", $this->header_image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getThumbHeaderImagePath()
    {

        $no_image_path = DS . 'img' . DS . '230x190.png';
        if (!empty($this->header_image)) {
            $image_path = 'uploads' . DS . 'blogs' . DS . "thumb_" . str_replace(DS, "", $this->header_image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return null;
        }
        return null;
    }
}
