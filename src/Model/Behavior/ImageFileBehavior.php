<?php

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
// use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Intervention\Image\ImageManager;

use Cake\Collection\Collection;
// use Cake\Database\Type;
use Cake\Utility\Hash;
// use Exception;
// use \Cake\Utility\Inflector;
// use Cake\Http\ServerRequest as HandleRequest;



class ImageFileBehavior extends Behavior
{


    /**
     * Table instance
     *
     * @var \Cake\ORM\Table;
     */
    protected $_imagesTable;

    protected $_defaultSettingsKeys = ['ImageUpload', 'FileUpload'];

    private $protectedFieldNames = [
        'priority',
    ];

    private $_tempfiles_to_delete = [];

    /**
     * Default configuration
     *
     * @var array
     */


    protected $_defaultConfig = [
        'ImageUpload' => [
            'resize' => ['width' => 640, 'height' => 480],
            'width' => 600,
            'height' => 800,
            'thumbs' => [['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']],
            'file_name' => '{$rand}_{$file_name}',
            'extensions' => array('jpg', 'png', 'gif', 'jpeg'),
            'datePath' => false,
            'path' => 'img/uploads/',
            'aspect_required' => false,
            'aspect_tolerance' => '0.05',
            'manager' => [
                // 'driver' => 'imagick',
                'driver' => 'gd'
            ],
            'required' => false,
            'delete_file_on_update' => true,
            'folder_prefix_field' => false,
            'type' => ''
        ],
        'FileUpload' => [
            'file_name' => '{$rand}_{$file_name}',
            'extensions' => array('pdf', 'doc', 'docx'),
            'path' => 'files/file/uploads/',
            'required' => false,
            'delete_file_on_update' => true,
            'max_file_size' => '20MB',
            'max_file_size_kb' => '20480',
            'folder_prefix_field' => false,
            'type' => ''
        ]


    ];

    public $settings = [];

    public function initialize(array $config): void
    {
        $originalSettings = $this->getConfig(null, []);

        // dd($this->getTable());
        $configs = [];
        foreach ($config as $type => $data) {
            foreach ($data as $field => $settings) {




                if (isset($originalSettings[$type][$field])) {
                    unset($originalSettings[$type][$field]);
                }


                $configs[$field] = array_merge($originalSettings[$type], $settings);

                if (isset($settings['resize'])) {
                    if (is_array($settings['resize']) && !empty($settings['resize'])) {
                        if ($settings['resize']['width'] > 0)
                            $configs[$field]['width'] = $settings['resize']['width'];
                        if ($settings['resize']['height'] > 0)
                            $configs[$field]['height'] = $settings['resize']['height'];
                    }
                }


                $configs[$field]['type'] = $type;
            }
        }
        $this->settings = $configs;

        $this->setConfig($configs);
        $this->setConfig('className', null);
    }




    public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
    {
        foreach ($this->getConfig(null, []) as $field => $settings) {

            if ($entity->has($field) && $entity->get($field) instanceof \Psr\Http\Message\UploadedFileInterface) {
                if ($entity->get($field)->getError() === UPLOAD_ERR_OK) {
                    $this->process($field, $settings, $entity, $path);
                } else {
                    throw new \Exception("Cannot find anything to process for the field `$field`");
                }
            }


            if (in_array($field, $this->_defaultSettingsKeys)) continue;

            if (in_array($field, $this->protectedFieldNames)) {
                continue;
            }

            $postData = $_POST;
            // dd($_FILES[$field]);
            // debug($_FILES);
            // debug($entity);

            // die;
            $tmpmodel = TableRegistry::getTableLocator()->get('TempFiles');
            if (
                isset($postData[$field])
                && $postData[$field] != '' && is_string($postData[$field])
            ) {
                if (isset($entity->{$field}) && $entity->{$field} != '') {
                    $postData = (is_array($entity->{$field}) ? $entity->{$field} : [$field => $entity->{$field}]);
                }

                $fileData = $tmpmodel->find()->where(['hash' => $postData[$field]])->first();

                if (!$fileData) {
                    continue;
                }

                // $fileData = $fileData->toArray();
                if (!empty($fileData) && file_exists(WWW_ROOT . 'files/temp_files/' .  $fileData->name)) {
                    $_FILES[$field] = array(
                        'name' => $fileData->name,
                        'tmp_name' =>  WWW_ROOT . 'files/temp_files/' . $fileData->name,
                        'size' => filesize(WWW_ROOT . 'files/temp_files/' . $fileData->name),
                        'error' => 0,
                    );
                    if ($entity->isNew()) {
                        $this->_tempfiles_to_delete[$fileData->id]['file'] = WWW_ROOT . 'files/temp_files/' . $fileData->name;
                    } else {
                        $this->_tempfiles_to_delete[$fileData->id]['file'] = WWW_ROOT . 'files/temp_files/' . $fileData->name;
                        $this->_tempfiles_to_delete[$fileData->id]['id'] = $entity->id;
                    }
                } else {
                    $_FILES[$field] = array(
                        'name' => '',
                        'tmp_name' => '',
                        'type' => '',
                        'size' => 0,
                        'error' => UPLOAD_ERR_NO_FILE,
                    );
                    $ret = false;
                    $model->validationErrors[$field] = __('Invalid file signature, file ignored. Please re-upload the file', true);
                }
            } elseif (is_array($entity->{$field})) {
                $fileDatas = $entity->{$field};
                $_FILES[$field] = array(
                    'name' =>  $fileDatas['name'],
                    'tmp_name' =>  $fileDatas['tmp_name'],
                    'size' => $fileDatas['size'],
                    'error' => 0,
                );
                // debug($_FILES);


            }

            if (!isset($_FILES[$field])) {
                continue;
            }
            if (Hash::get($_FILES[$field], 'error') != 0) {
                if (Hash::get($settings, 'restoreValueOnFailure', true)) {
                    $entity->set($field, $entity->getOriginal($field));
                    $entity->setDirty($field, false);
                }
                continue;
            }

            $res = false;
            if ($settings['type'] == 'ImageUpload') {

                $res =  $this->_imageHandler($_FILES[$field], $field, $settings, $entity);
            } elseif ($settings['type'] == 'FileUpload') {
                $res =   $this->_fileHandler($_FILES[$field], $field, $settings, $entity);
            }
            // debug($res);die;
            $yearPathText = '';
            if (is_array($settings['datePath']) && isset($settings['datePath']['path'])) {
                $yearPathText = $settings['datePath']['path'];
                $yearPathText = str_replace("{year}", date('Y'), $yearPathText);
                $yearPathText = str_replace("{month}", date('m'), $yearPathText);
            }

            if ($res) {
                if (is_array($settings['datePath']) && isset($settings['datePath']['path'])) {
                    $entity->set($field, $yearPathText . DS . $res);
                } else {
                    $entity->set($field, $res);
                }
            } else {
                // $entity->setDirty($field, false);
            }
        }
        // die('sads');
    }

    public function _fileHandler($file, $field, $settings, $entity)
    {

        $settings['max_file_size_kb'] = isset($settings['max_file_size_kb']) ? $settings['max_file_size_kb'] : '20480';
        $settings['max_file_size'] = isset($settings['max_file_size']) ? $settings['max_file_size'] : '20MB';

        $max_kb_size = $settings['max_file_size_kb'];


        if (($file['size'] / 1024) > $max_kb_size) {
            die('File size is larger than');
        }



        $folder = WWW_ROOT . $settings['path'] . DS;
        ini_set('upload_max_filesize', $settings['max_file_size']);
        ini_set('post_max_size', $settings['max_file_size']);
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
                die('File size is too large');
                return false;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                die('File size is too large');

                return false;
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                die('Cannot write to temp directory');

                return false;
                break;
            case UPLOAD_ERR_CANT_WRITE:
                die('Cannot write to temp directory');

                return false;
                break;
            case UPLOAD_ERR_PARTIAL:
                die('File could not be uploaded');

                return false;
                break;
            case UPLOAD_ERR_NO_FILE:
                if (empty($entity->id)) {

                    if ($settings['required']) {
                        die('No file selected. This field is required');

                        return false;
                    } else {
                        $entity->set($field, '');
                        return true;
                    }
                }
                break;
        }

        $ext = $this->__get_extension($file['name']);
        $exts = array_map('strtolower', $settings['extensions']);
        if (!in_array($ext, $exts)) {
            die('Invalid file type. Types required');
            return false;
        }

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        if (!is_writable($folder)) {
            $Model->validationErrors[$field] = __('Destination folder is not writable or never exists!', true);
            return false;
        } else {
            $uniqid = substr(uniqid(), 8);

            $filename = str_replace('{$rand}', $uniqid, $settings['file_name']);
            $ext = substr($file['name'], strrpos($file['name'], '.'));
            $name = substr($file['name'], 0, strrpos($file['name'], '.'));
            $fname = $this->createSlug($name) . $ext;
            $filename = str_replace('{$file_name}', $fname, $filename);



            if (move_uploaded_file($file['tmp_name'], $folder . $filename)) {
                $entity->set($field, $filename);
                chmod($folder . $filename, 0777);

                return $filename;
            } else {
                die('Error while saving uploaded file');
                return false;
            }
        }
    }

    public function _imageHandler($image, $field, $settings, $entity)
    {


        if (isset($image['type']) && $image['type'] !== 'image/svg+xml') {
            $uniqid = uniqid();
            $filename = str_replace('{$rand}', $uniqid, $settings['file_name']);
            $name = substr($image['name'], 0, strrpos($image['name'], '.'));
            $ext = $this->__get_extension($image['name']);
            $exts = array_map('strtolower', $settings['extensions']);
            $fname = $this->createSlug($name) . '.' . $ext;
            $filename = str_replace('{$file_name}', $fname, $filename);
            $yearPathText = '';
            if (is_array($settings['datePath']) && isset($settings['datePath']['path'])) {
                $yearPathText = $settings['datePath']['path'];
                $yearPathText = str_replace("{year}", date('Y'), $yearPathText);


                $yearPathText = str_replace("{month}", date('m'), $yearPathText) . DS;

                $basepath = WWW_ROOT . $settings['path'];
            } else {
                $basepath = WWW_ROOT . $settings['path'];
            }




            if (!file_exists($basepath)) {
                mkdir($basepath, 0775, true);
            }
            if (!file_exists($basepath . $yearPathText)) {
                mkdir($basepath . $yearPathText, 0775, true);
            }
            $image['name'] = $filename;
            $dir = new Folder($basepath);
            $dir->chmod($basepath, 0775, true);

            if (!file_exists($basepath . $yearPathText)) {


                mkdir($basepath . $yearPathText, 0775, true);
            }


            $width = isset($settings['resize']['width']) ? $settings['resize']['width'] : 0;
            $height = isset($settings['resize']['height']) ? $settings['resize']['height'] : 0;


            $manager = new ImageManager($settings['manager']);
            $img = $manager->make($image['tmp_name']);
            // dd($img);
            if (!empty($settings['resize'])) {
                if ($settings['resize']['height']) {
                    // $img->resize($settings['resize']['width'], $settings['resize']['height'], function ($constraint) {
                    //     $constraint->aspectRatio();
                    // });
                    $img->fit($settings['resize']['width'], $settings['resize']['height']);
                } else {
                    $img->resize($settings['resize']['width'], null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->fit($settings['resize']['width']);
                }
            }
            // debug($basepath);
            // debug($yearPathText);
            // debug($filename);
            // fd($basepath.$yearPathText. $filename);

            $upload = $img->save($basepath . $yearPathText . $filename, 100);

            if ($settings['thumbs']) {
                foreach ($settings['thumbs'] as $thumb) {


                    $this->createThumbnail($manager, $basepath, $filename, $thumb, $yearPathText);
                }
            }




            if ($upload) {
                return $filename;
            }
        } else {
            return $this->_fileHandler($image, $field, $settings, $entity);
        }

        return false;





        // debug($entity);die;

    }

    function __get_extension($name)
    {
        $pos = strpos($name, '.');
        if ($pos !== false) {
            return strtolower(substr($name, $pos + 1));
        }
        return '';
    }

    public static function createSlug($str, $delimiter = '-')
    {

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

    public function createThumbnail($manager, $basepath, $filename, $thumb, $yearPathText = '')
    {


        // fd($basepath.$yearPathText.DS.$thumb['thumb_prefix']);
        $img = $manager->make($basepath . $yearPathText . DS . $filename)->resize($thumb['width'], $thumb['height'], function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($basepath . $yearPathText . DS . $thumb['thumb_prefix'] . $filename, 100);
    }


    function chmod_r($dir, $dirPermissions, $filePermissions)
    {
        $dp = opendir($dir);
        while ($file = readdir($dp)) {
            if (($file == ".") || ($file == ".."))
                continue;

            $fullPath = $dir . "/" . $file;
            $dir = new Folder();
            $dir->chmod($fullPath, 0755, true);
        }
        closedir($dp);
    }



    public function afterSave(Event $event, Entity $entity, ArrayObject $options): void
    {
        if (!empty($this->_tempfiles_to_delete)) {


            $tmpmodel = TableRegistry::getTableLocator()->get('TempFiles');

            foreach ($this->_tempfiles_to_delete as $id => $data) {
                if (isset($data['id'])) {
                    $tFiles = $tmpmodel->find()->where(['temp_token' => $data['id']])->all();
                } else {
                    $tFiles = $tmpmodel->findById($id)->all();
                }
                foreach ($tFiles as $tFile) {
                    $tmpmodel->delete($tFile);
                }

                if (file_exists($data['file']))
                    unlink($data['file']);
            }
            $this->_tempfiles_to_delete = [];
        }
    }


    function getImageSettings($field = false, $param = false)
    {



        if (!$field && !$param)
            return $this->settings;
        else if (!$param)
            return $this->settings[$field];
        else
            return $this->settings[$field][$param];
    }

    function setImageSettings($field, $param, $value)
    {

        $this->settings[$field][$param] = $value;
    }


    /**
     * beforeMarshal event
     *
     * If a field is allowed to be empty as defined in the validation it should be unset to prevent processing
     *
     * @param \Cake\Event\Event $event Event instance
     * @param \ArrayObject $data Data to process
     * @param \ArrayObject $options Array of options for event
     *
     * @return void
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {


        foreach ($this->getConfig() as $field => $settings) {



            if (!isset($data[$field])) {
                continue;
            }



            // unset($data[$field]);

            /** @var \Laminas\Diactoros\UploadedFile $upload */
            $upload = $data[$field];


            if (
                $this->_table->getValidator()->isEmptyAllowed($field, false) &&
                $upload instanceof \Psr\Http\Message\UploadedFileInterface &&
                $upload->getError() === UPLOAD_ERR_NO_FILE
            ) {
                unset($data[$field]);
            }
        }
    }


    public function getUploadSettings()
    {
        return $this->getConfig();
    }
}
