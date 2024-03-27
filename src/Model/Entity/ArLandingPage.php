<?php
declare(strict_types=1);

namespace App\Model\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class ArLandingPage extends Entity
{
    use LazyLoadEntityTrait;
    
    

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */

   


    protected $_virtual = ['left_image_path', 'thumb_left_image_path','right_logo_path', 'thumb_right_logo_path'];

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

    protected function _getLeftImagePath()
    {

        $no_image_path = DS . 'img' . DS . '230x190.png';
        $no_image_path ="";

        if (!empty($this->left_image)) {
            $image_path = 'uploads' . DS . 'landings' . DS . str_replace(DS, "", $this->left_image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getThumbLeftImagePath()
    {

        $no_image_path = DS . 'img' . DS . '30x190.png';
        if (!empty($this->left_image)) {
            $image_path = 'uploads' . DS . 'landings' . DS . "thumb_" . str_replace(DS, "", $this->left_image);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return null;
        }
        return null;
    }

    protected function _getRightLogoPath()
    {

        $no_image_path = DS . 'img' . DS . 'ug-study-homepage-banner-reg.png';
        $no_image_path ="";

        if (!empty($this->right_logo)) {
            $image_path = 'uploads' . DS . 'landings' . DS . str_replace(DS, "", $this->right_logo);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return $no_image_path;
        }
        return $no_image_path;
    }


    protected function _getThumbRightLogoPath()
    {

        $no_image_path = DS . 'img' . DS . '230x190.png';
        $no_image_path ="";

        if (!empty($this->right_logo)) {
            $image_path = 'uploads' . DS . 'landings' . DS . "thumb_" . str_replace(DS, "", $this->right_logo);
            if (file_exists(WWW_ROOT . $image_path))
                return DS . $image_path;
            else
                return null;
        }
        return null;
    }


    

}
