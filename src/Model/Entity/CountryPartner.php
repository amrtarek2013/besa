<?php

declare(strict_types=1);

namespace App\Model\Entity;

// use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class CountryPartner extends Entity
{
    // use LazyLoadEntityTrait;

    protected $_virtual = ['image_path', 'video_thumb_path'];

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

        $no_image_path = DS . 'img' . DS . 'portrait-of-female-un.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'country_partners' . DS . $this->image;
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
        debug($this->video_thumb);
        if (!empty($this->video_thumb)) {
            debug($this->video_thumb);
            $image_path = 'uploads' . DS . 'country_partners' . $this->video_thumb;
            debug($image_path);
            debug(WWW_ROOT . $image_path);
            debug(file_exists(WWW_ROOT . $image_path));
            if (file_exists(WWW_ROOT . $image_path)) {
                debug(DS . $image_path);
                return DS . $image_path;
            } else
                return $no_image_path;
        }
        return $no_image_path;
    }
}
