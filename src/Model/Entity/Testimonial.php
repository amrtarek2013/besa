<?php

declare(strict_types=1);

namespace App\Model\Entity;

use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class Testimonial extends Entity
{
    use LazyLoadEntityTrait;
    protected $_virtual = ['image_path','thumb_image_path', 'video_thumb'];

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

        $no_image_path = DS . 'img' . DS . 'men.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'testimonials' . DS . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }

    protected function _getThumbImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'men.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'testimonials' . DS .'thumb_'. str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }
    protected function _getVideoThumbPath()
    {

        $no_image_path = DS . 'img' . DS . 'men.png';
        if (!empty($this->video_thumb)) {
            $image_path = 'uploads' . DS . 'testimonials' . $this->video_thumb;
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }
}
