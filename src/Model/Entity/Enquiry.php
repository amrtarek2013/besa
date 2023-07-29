<?php

declare(strict_types=1);

namespace App\Model\Entity;

// use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

use Cake\ORM\Entity;


class Enquiry extends Entity
{
    // use LazyLoadEntityTrait;

    protected $_virtual = ['file_path'];

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

    protected function _getFIlePath()
    {

        if (!empty($this->certificate)) {
            $file_path = 'uploads' . DS . 'enquiries' . DS . str_replace(DS, "", $this->certificate);
            if (file_exists(WWW_ROOT . $file_path))
                return DS . $file_path;
            else
                return '#';
        }
        return '#';
    }
}
