<?php

declare(strict_types=1);

namespace App\Model\Entity;

// use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class Career extends Entity
{
    // use LazyLoadEntityTrait;

    protected $_virtual = ['image_path', 'thumb_image_path','file_path'];

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

    
    protected function _getFilePath()
    {

        if (!empty($this->job_details)) {
            
            $file_path = 'uploads' . DS . 'careers' . DS . str_replace(DS, "", $this->job_details);
            if (file_exists(WWW_ROOT . $file_path))
                return DS . $file_path;
            else
                return '#';
        }
        return '#';
    }

    protected function _getImagePath()
    {

        $no_image_path = DS . 'img' . DS . '1600x440.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'careers' . DS . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getThumbImagePath()
    {

        $no_image_path = DS . 'img' . DS . 'portrait-of-female-un.png';
        if (!empty($this->image)) {
            $image_path = 'uploads' . DS . 'careers' . DS . "thumb_" . str_replace(DS, "", $this->image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else

            return null;
        }
    return null;
    }
}
