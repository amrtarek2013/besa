<?php

declare(strict_types=1);

namespace App\Model\Entity;

// use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class FairEvent extends Entity
{
    // use LazyLoadEntityTrait;


    protected $_virtual = ['main_image_path', 'thumb_main_image_path', 'image_path', 'thumb_image_path'];

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

    protected function _getMainImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'International_Education_Fair.png';
        if (!empty($this->main_image)) {
            $image_path = 'uploads' . DS . 'events' . DS . str_replace(DS, "", $this->main_image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getThumbMainImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'International_Education_Fair.png';
        if (!empty($this->main_image)) {
            $image_path = 'uploads' . DS . 'events' . DS . "thumb_" . str_replace(DS, "", $this->main_image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else

                return null;
        }
        return null;
    }

    protected function _getImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'International_Education_Fair.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'events' . DS . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return null;
        }
        return null;
    }


    protected function _getThumbImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'International_Education_Fair.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'events' . DS . "thumb_" . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else

                return null;
        }
        return null;
    }
}
