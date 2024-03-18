<?php

declare(strict_types=1);

namespace App\Controller\Admin;


use Cake\Core\App;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use \Cake\Utility\Inflector;
use Cake\Core\ConventionsTrait;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

use Bake\Utility\TableScanner;
use Bake\Utility\TemplateRenderer;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CrudsController extends AppController
{

    use ConventionsTrait;

    public $basePath = '';
    public $hasFile = false;
    public $hasPassword = false;


    public $formFields = array();
    public $replace = array();
    public $ImageFileBehavior = '';
    public $uplodedFiles = array();
    public $uploadBehaviors = array('image' => 'ImageUpload', 'file' => 'FileUpload');




    public $viewPath = '';
    public $controllerPath = '';
    public $tablePath = '';
    public $entityPath = '';
    public $stubPath = WWW_ROOT . 'CrudGenerator/stubs/';

    public $tablePrefix = '';
    public $connection = 'default';
    public $actions = ['index', 'add'];



    public $fields = [
        'hidden' => 'Hidden field',
        'no' => 'Escape this field',
        'text' => 'Text',
        // 'select'=>'Select',
        'password' => 'Password',
        'textarea' => 'Textarea',
        'email' => 'Email',
        // 'number'=>'Number',
        // 'radio'=>'Radio Button',
        'checkbox' => 'Checkbox',
        'image' => 'Image',
        'file' => 'File',
    ];

    public function initialize(): void
    {
        $this->viewPath = Configure::read('App.paths.templates')[0];
        $this->controllerPath = current(App::classPath('Controller'));
        $this->tablePath = current(App::classPath('Model/Table'));
        $this->entityPath = current(App::classPath('Model/Entity'));
        if (!is_writable($this->viewPath)) {
            chmod($this->viewPath, 0775);
        }
        if (!is_writable($this->controllerPath)) {

            chmod($this->controllerPath, 0775);
        }
        if (!is_writable($this->tablePath)) {

            chmod($this->tablePath, 0775);
        }
        if (!is_writable($this->entityPath)) {
            chmod($this->entityPath, 0775);
        }
    }

    protected function getStub($from = 'Controller')
    {
        if ($from == 'Controller') {
            return $this->stubPath . 'controller.ae';
        } elseif ($from == 'Table') {
            return $this->stubPath . 'table.ae';
        } elseif ($from == 'Entity') {
            return $this->stubPath . 'entity.ae';
        } elseif ($from == 'index') {
            return $this->stubPath . 'views/index.ae';
        } elseif ($from == 'add') {
            return $this->stubPath . 'views/add.ae';
        } elseif ($from == 'edit') {
            return $this->stubPath . 'views/edit.ae';
        } elseif ($from == 'view') {
            return $this->stubPath . 'views/view.ae';
        }
    }

    public function index()
    {
        $this->checkIfSuperadmin();
        $collection =  $this->getDbInst();
        // Get the table names
        $tables = $collection->listTables();
        $this->set(compact('tables'));
    }

    public function create($permalink = null)
    {
        $this->checkIfSuperadmin();
        $cruds = $this->Cruds->newEmptyEntity();


        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $prefixs = $this->getPrefixs($data);
            foreach ($prefixs as $prefix) {
                if ($data['create_views'] == 1) {
                    $this->bakeViews($data, $permalink, $prefix);
                }
                if ($data['create_controller'] == 1) {
                    $this->bakeController($data, $permalink, $prefix);
                }
            }
            if ($data['create_model'] == 1) {
                $this->bakeModel($data, $permalink, '');
            }
        }

        $collection =  $this->getDbInst();
        $tableSchema = $collection->describe($permalink);
        $columns = $tableSchema->columns();
        $new_columns = [];
        foreach ($columns as $key => $column) {
            if ($column == 'id') continue;
            $new_columns[$column] = Inflector::humanize($column);
        }

        foreach ($this->actions as $action) {
            $actions[$action] = Inflector::humanize($action);
        }
        $fields = $this->fields;
        $this->set(compact('new_columns', 'fields', 'cruds', 'permalink', 'actions'));
    }

    public function getDbInst()
    {

        $db = ConnectionManager::get('default');

        // Create a schema collection.
        return $db->getSchemaCollection();
    }

    public function _getReplacment($data, $name, $prefix = '')
    {
        $prefix = ucfirst($prefix);
        $namespace = Configure::read('App.namespace');
        $controller = Inflector::camelize($name);
        $pluralName = $this->_variableName($controller);
        $singularName = $this->_singularName($controller);
        $singularHumanName = $this->_singularHumanName($controller);
        $pluralHumanName = $this->_variableName($controller);
        $defaultModel = sprintf('%s\Model\Table\%sTable', $namespace, $controller);
        $actions = ['index', 'view', 'add', 'edit', 'delete'];
        // $modelObj = TableRegistry::getTableLocator()->get($controller);
        $entityClassName = $this->_entityName($controller);
        $appController = "use $namespace\Controller\AppController ;";
        $linkPrefix = '';
        if (!empty($prefix)) {
            $linkPrefix = <<<EOD
,'$prefix' => true
EOD;
            $prefix = '\\' . $prefix;
        }

        // $displayField = $this->getDisplayField($modelObj);
        $fieldsArr = <<<EOD
\$fields = [
'basicModel'=>'$pluralName'
EOD;
        foreach ($data as $k => $dat) {
            if (is_array($dat)) {
                if (empty($dat['type']) && $dat['type'] != 'no') {
                    $dat['type'] = 'text';
                }
                if (!empty($dat['type']) && $dat['type'] != 'no') {
                    $this->formFields[$k]['field'] = $dat['field'];
                    $this->formFields[$k]['type'] = ($dat['type'] == 'image') ? 'file' : $dat['type'];
                    $fieldsArr .= ",
'" . $dat['field'] . "'=>[]";
                }

                if (($dat['type'] == 'file' || $dat['type'] == 'image')) {
                    $this->hasFile = true;
                    $this->uplodedFiles[$k]['field'] = $k;
                    $this->uplodedFiles[$k]['type'] = $dat['type'];
                    $this->uplodedFiles[$k]['behavior'] = $this->uploadBehaviors[$dat['type']];
                }



                if ($dat['type'] == 'password') {
                    $this->hasPassword = true;
                }
            }
        }
        $fieldsArr .= <<<EOD

];
EOD;
        $passwordSetter = $passwordUse = '';

        if ($this->hasPassword) {

            $passwordUse = <<<EOD
use Authentication\PasswordHasher\DefaultPasswordHasher;
EOD;
            $passwordSetter = <<<EOD
        protected function _setPassword(string \$password) : ?string
        {
            if (strlen(\$password) > 0) {
                return (new DefaultPasswordHasher())->hash(\$password);
            }
        }
EOD;
        }




        $this->replace = array(
            '{{ namespace }}' => $namespace,
            '{{ prefix }}' => $prefix,
            '{{ appController }}' => ($prefix) ? $appController : '',
            '{{ name }}' => $pluralName,
            '{{ pluralName }}' => $pluralName,
            '{{ singularName }}' => $singularName,
            '{{ currentModelName }}' => $entityClassName,
            '{{ singularHumanName }}' => $singularHumanName,
            '{{ table }}' => $name,
            '{{ fieldsArr }}' => $fieldsArr,
            '{{ urlPrefix }}' => ($prefix) ? ",'$prefix'" : '',
            '{{ controllerName }}' => $controller,
            '{{ linkPrefix }}' => $linkPrefix,
            '{{ passwordSetter }}' => $passwordSetter,
            '{{ passwordUse }}' => $passwordUse


        );


        return $this->replace;
    }





    public function bakeController($data, $name, $prefix)
    {

        $controller = Inflector::camelize($name);


        $replace = $this->_getReplacment($data, $name, $prefix);
        $stub = str_replace(array_keys($replace), $replace, file_get_contents($this->getStub('Controller')));
        $path = $this->controllerPath;
        if ($prefix) {
            $path .= ucfirst($prefix) . DS;
        }
        $fileName = $path . $controller . 'Controller.php';
        $this->_createFile($fileName, $stub);

        return true;
    }


    public function bakeModel($data, $name, $prefix)
    {

        $this->bakeTable($data, $name, $prefix);
        $this->bakeEntity($data, $name, $prefix);
        return true;
    }

    public function bakeTable($data, $name, $prefix)
    {
        $table = $this->getTable($name);
        // $tableObject = $this->_getTableObject($table);



        $replace = $this->_getReplacment($data, $name, $prefix);
        $replace['{{ ImageFileBehavior }}'] = $this->buildImageFileBehavior($data, $name);


        $stub = str_replace(array_keys($replace), $replace, file_get_contents($this->getStub('Table')));
        $path = $this->tablePath;

        $pluralName = $this->_variableName($name);
        $name = Inflector::camelize($name);
        $filename = $path . ucfirst($name) . 'Table.php';
        $this->_createFile($filename, $stub);
    }
    public function bakeEntity($data, $name, $prefix)
    {
        $replace = $this->_getReplacment($data, $name, $prefix);


        $replace['{{ accessible }}'] = $this->buildAccessibleFields($data, $name, $prefix);
        $stub = str_replace(array_keys($replace), $replace, file_get_contents($this->getStub('Entity')));

        $path = $this->entityPath;
        $name = Inflector::camelize($name);
        $modelObj = TableRegistry::getTableLocator()->get($name);
        $entityClassName = $this->_entityName($modelObj->getAlias());

        $filename = $path . ucfirst($entityClassName) . '.php';
        $this->_createFile($filename, $stub);
    }

    public function bakeViews($data, $name, $prefix): void
    {
        foreach ($this->actions as $action) {
            $this->bakeView($action, $data, $name, $prefix);
        }
    }

    public function bakeView($action, $data, $name, $prefix)
    {
        $controller = Inflector::camelize($name);
        $this->replace = $this->_getReplacment($data, $name, $prefix);
        $this->buildFormFields($action, $data, $name, $prefix);


        $stub = str_replace(array_keys($this->replace), $this->replace, file_get_contents($this->getStub($action)));
        $path = $this->viewPath;
        if ($prefix) {
            $path .= ucfirst($prefix) . DS;
        }
        $path .= $controller . DS;
        $filename = $path . Inflector::underscore($action) . '.php';

        $this->_createFile($filename, $stub);
    }


    public function buildImageFileBehavior($data, $name)
    {



        $behavior = ''; //$behavior[$one['behavior']] = [$one['field']=>[]]
        if (empty($this->uplodedFiles)) {
            $this->replace['{{ ImageFileBehavior }}'] = '';
            return '';
        }

        foreach ($this->uplodedFiles as $k => $one) {

            $behavior .= "'" . $one['behavior'] . "' =>['" . $one['field'] . "' => []]";
        }


        $replace['{{ ImageFileBehaviorData }}'] =  $behavior;
        $behaviordata =
            <<<EOD
\$this->addBehavior('ImageFile',[{{ ImageFileBehaviorData }}]);          
EOD;
        $this->replace['{{ ImageFileBehavior }}'] = str_replace(array_keys($replace), $replace, $behaviordata);
        return str_replace(array_keys($replace), $replace, $behaviordata);
    }




    public function buildAccessibleFields($data, $name, $prefix = '')
    {
        $replace = $this->_getReplacment($data, $name, $prefix);


        $accessible =
            <<<EOD
protected \$_accessible = [
EOD;
        $i = 0;
        foreach ($data as $k => $dat) {
            if (is_array($dat)) {
                if ($i == 0) {
                    $accessible .= "
'" . $dat['field'] . "'=>true";
                } else {
                    $accessible .= ",
'" . $dat['field'] . "'=>true";
                }

                $i++;
            }
        }
        $accessible .= <<<EOD

];
EOD;

        return $accessible;

        // protected $_accessible = [

        // ];

    }
    public function buildFormFields($action, $data, $name, $prefix = '')
    {

        $replace = $this->_getReplacment($data, $name, $prefix);

        $fields = '';
        if ($this->hasFile) {

            $fields =
                <<<EOD
           echo \$this->AdminForm->create(\${{ singularName }},['type'=>'file']);
            
EOD;
        } else {
            $fields =
                <<<EOD
           echo \$this->AdminForm->create(\${{ singularName }});

EOD;
        }
        foreach ($this->formFields as $oneField) {
            $fields .= "echo \$this->AdminForm->control('" . $oneField['field'] . "',['type'=>'" . $oneField['type'] . "']);
            ";
        }
        $this->replace['{{ formFields }}'] = str_replace(array_keys($replace), $replace, $fields);
        $this->replace['{{ actionName }}'] = ucfirst($action);

        return  true;
    }


    public function getHelpers($data): array
    {
        $helpers = [];
        if ($data['helpers']) {
            $helpers = explode(',', $data['helpers']);
            $helpers = array_values(array_filter(array_map('trim', $helpers)));
        }

        return $helpers;
    }

    public function getComponents($data): array
    {
        $components = [];
        if ($data['components']) {
            $components = explode(',', $data['components']);
            $components = array_values(array_filter(array_map('trim', $components)));
        }

        return $components;
    }
    public function getPrefixs($data): array
    {
        $components = [];
        $prefixs = [];
        if ($data['prefix']) {
            $prefixs = explode(',', $data['prefix']);
            $prefixs = array_values(array_filter(array_map('trim', $prefixs)));
        }
        if ($data['add_to_public'] == 1) {
            $prefixs[] = '';
        }

        return $prefixs;
    }

    public function _getTableObject(string $className): \Cake\ORM\Table
    {

        if (TableRegistry::getTableLocator()->exists($className)) {
            return TableRegistry::getTableLocator()->get($className);
        }
        return TableRegistry::getTableLocator()->get($className, [
            'name' => $className,
            'connection' => ConnectionManager::get($this->connection),
        ]);
    }

    public function getTable(string $name): string
    {


        return Inflector::underscore($name);
    }

    public function getDisplayField(\Cake\ORM\Table $model): ?string
    {
        return $model->getDisplayField();
    }


    public function _createFile($path, $data)
    {
        if (file_exists($path)) {
            unlink($path);
        }
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0775, true);
            @chmod(dirname($path), 0777);
        }

        $file = new File($path, true, 755);
        $file->write($data);
        chmod($path, 0775);
        return true;
    }
}
