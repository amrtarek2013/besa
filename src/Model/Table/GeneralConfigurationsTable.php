<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Cache\Cache;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use stdClass;

/**
 * Admins Model
 *
 * @method \App\Model\Entity\Admin get($primaryKey, $options = [])
 * @method \App\Model\Entity\Admin newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Admin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Admin|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Admin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Admin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Admin[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Admin findOrCreate($search, callable $callback = null, $options = [])
 */
class GeneralConfigurationsTable extends Table
{


    public $g_configs;
    public $filters = [
        'field' => ['like'],
        'config_group' => ['like']
    ];
    // public $modelName = 'roles';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);


        // $this->setDisplayField('title');

        $this->setTable('general_configurations');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }


    public $colours = array(
        '#005BAA' => 'blue',
        '#ED1C24' => 'red',
        '#58585B' => 'Gray',
        '#ffffff' => 'White',
        '#fff000' => 'Yellow',
        '#D3D3D3' => 'light grey',
        '#30db30' => 'light green',
        '#000000' => 'Black',
        '#ffa500' => 'orange',
    );
    public $conf_sort = array(
        "txt.site_name",
        "txt.configuration_admin_mail",
        "txt.send_mail_from",
        "txt.admin_user_name",
        "pwd.admin_password",
        "txt.keywords",
        "txt.description",
        "txt.domain",
        "txt.phone",
        "txt.alternative_phone",
        "txt.mobile",
        "txt.zoom",


        "txt.google_api_key",

        "textarea.invoice_footer_text",
        "chk.enable_sms_functional",

        "file.main_logo",
        "textarea.auction_car_terms_and_conditions",

        "textarea.seo_js_head_code",
        'txt.classification_files_count', 'txt.annotation_files_count', 'txt.review_files_count', 'txt.selector_mechanism',

        "txt.partners",
        "txt.happy_students",
        "txt.destinations",

    );

    public $dropdownYesNoOptions = array(
        1 => 'Yes',
        0 => 'No',
    );

    public $extensions = array(
        'txt' => 'text',
        'pwd' => 'password',
        'chk' => 'radio',
        'file' => 'file',
        'textarea' => 'textarea',
        'dropdown' => 'dropdown'
    );

    public $fieldCanUploaded = array(
        'file.main_logo',
    );
    public function getFields(String $group = null, $return = 'fields')
    {
        $generalConfiguration = $this->find('list', ['keyField' => 'field', 'valueField' => 'value'])->where(['config_group' => $group]);
        return $generalConfiguration->toArray();
    }

    public function getconfigGroups()
    {
        $generalConfiguration = $this->find('list', ['keyField' => 'config_group', 'valueField' => 'config_group']);
        return $generalConfiguration->toArray();
    }

    function insertOrUpdateConfigs($data, $group, $oldData)
    {
        $AllData = array();

        //***********
        $formData = $data['data']['GeneralConfiguration'];

        foreach ($formData as $field => $value) {
            if (empty($value) && $value !== "0" && $value !== 0) {
                continue;
            }
            $field = preg_replace("/_/", '.', $field, 1);
            $dataToSave = array();
            $this->checkIfExist($field, $group);
            $new = $this->newEmptyEntity();
            $newData = [];
            $newData['config_group'] = $group;
            $newData['field'] = $field;

            // debug($field);
            // debug($this->fieldCanUploaded);
            // debug($oldData);
            if (in_array($field, $this->fieldCanUploaded)) {

                $new = $this->patchEntity($new, $newData);

                // dd($value);
                if ((is_array($value) && $value['error'] != UPLOAD_ERR_OK) || (is_object($value) && $value->getError() != UPLOAD_ERR_OK)) {
                    // if ($value->getError() > 0) {

                    $new->value = $oldData[$field];
                    $newData['value'] = $oldData[$field];
                } else {
                    $newData['value'] = $this->_upload($field, $value);
                }
            } else {
                $new->value = $value;
                $newData['value'] = $value;
            }

            $admin = $this->patchEntity($new, $newData);

            $this->save($admin);
        }
        return true;
    }

    public function checkIfExist($field, $group)
    {
        $data = $this->find()->where(array('GeneralConfigurations.config_group' => $group, 'GeneralConfigurations.field' => $field))->first();

        if (!empty($data)) {
            $entity = $this->get($data->id);
            $this->delete($entity);
        }
        return false;
    }

    public function _upload($field, $value)
    {


        // echo $value;
        // dd($value);
        $file_name = '';
        if (is_array($value)) {

            $file_name = $value['name'];
        } else if (is_object($value)) {

            $file_name = $value->getClientFilename();
        }
        // $file_size = $value->getSize();
        // $file_tmp = $value->getStream()->getMetadata('uri');
        // $file_type = $value->getClientMediaType();
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $newFileName = uniqid('configs_') . '.' . $ext;
        $value->moveTo(WWW_ROOT . "img/" . $newFileName);
        //   move_uploaded_file($file_tmp,WWW_ROOT."img/".$findName);
        $img = '/img/' . $newFileName;
        return $img;
    }



    public static function getCached($group = null, $field = null)
    {
        $cached_config = Cache::read('configs', '_configs_');
        if ($cached_config !== null) {
            $cached_config = Cache::read('configs', '_configs_');
        } else {
            $self = new self();
            $cached_config = $self->getConfig();
            Cache::write('configs', $cached_config, '_configs_');
        }
        if ($group && isset($cached_config[$group]))
            return $cached_config[$group];
        elseif (
            $group && isset($cached_config[$group]) && $field &&
            isset($cached_config[$group][$field])
        )
            return $cached_config[$group][$field];
        elseif (!$group)
            return $cached_config;
        else {
            return false;
        }
    }

    public function getConfig($group = null, $field = null)
    {
        $conditions = array();
        if (!empty($field)) {
            $conditions['field'] = $field;
        }

        if (!empty($group)) {
            $conditions['config_group'] = $group;
        }
        $model = new self;

        $list = array();
        $lists = $model->find()->where($conditions)->all();
        foreach ($lists as $val) {

            $list[$val->config_group][$val->field] = $val->value;
        }
        $model = null;
        if (!empty($group) && empty($field) && count($list) == 1) {
            return $list[$group];
        } elseif (!empty($group) && !empty($field) && count($list) == 1) {
            return $list[$group][$field];
        } else {
            return $list;
        }
    }
    public function decode_var($var)
    {
        if (strpos($var, '.') === false)
            return false;
        $object = new stdClass();
        $ex = explode('.', $var);
        $object->group = $ex[0];
        $object->setting = $ex[1];
        return $object;
    }

    public function clearCache()
    {
        if (Cache::delete('configs', '_configs_')) {
            $this->g_configs = null;
            return true;
        }
        return false;
    }

    public function validationDefault(Validator $validator): Validator
    {

        return $validator;
    }
    public function afterSave($event, $entity, $options)
    {
        $this->clearCache();
        clearViewCache();
    }
}
