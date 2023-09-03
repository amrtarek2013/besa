<?php

declare(strict_types=1);

namespace App\Model\Entity;

// use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class Event extends Entity
{
    // use LazyLoadEntityTrait;


    // protected $finalPath = DS . 'files' . DS . 'event_videos' . DS;

    protected $_virtual = ['image_path', 'thumb_image_path', 'video_thumb'/*,'video_path'*/, 'icon_path','image_path', 'thumb_image_path', 'banner_image_path', 'mobile_image_path'];

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

        $no_image_path = DS . 'img' . DS . 'hero-bg11.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'events' . DS . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getThumbImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'hero-bg11.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'events' . DS . "thumbs_" . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else

                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getIconPath()
    {

        $no_image_path = DS . 'img' . DS . 'icon' . DS . 'education-Fairs.svg';
        if (!empty($this->icon)) {
            $image_path = 'uploads' . DS . 'events' . DS . 'icon' . DS . str_replace(DS, "", $this->icon);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getBannerImagePath()
    {

        $no_image_path = DS . 'images' . DS . 'no-image.png';
        if (!empty($this->banner_image)) {
            $image_path = 'uploads' . DS . 'events' . DS . str_replace(DS, "", $this->banner_image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }
    protected function _getMobileImagePath()
    {


        $no_image_path = DS . 'images' . DS . 'no-image.png';
        if (!empty($this->mobile_image)) {
            $image_path = 'uploads' . DS . 'events' . DS . str_replace(DS, "", $this->mobile_image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    // protected function _getVideoPath()
    // {

    //     $no_video_path = DS . 'files' . DS . 'dummy_video.mp4';
    //     if (!empty($this->video)) {
    //         $video_path = $this->finalPath . DS . $this->video;
    //         if (file_exists(WWW_ROOT . $video_path))
    //             return $video_path;
    //         else
    //             return $no_video_path;
    //     }
    //     return $no_video_path;
    // }

    protected function _getVideoThumbPath()
    {

        $no_video_path = DS . 'img' . DS . '767x450.png';
        if (!empty($this->video_thumb)) {
            $video_path = $this->finalPath . DS . $this->video_thumb;
            if (file_exists(WWW_ROOT . $video_path))
                return $video_path;
            else
                return $no_video_path;
        }
        return $no_video_path;
    }
}
