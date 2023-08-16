<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\ServerRequest;
use Cake\Core\Configure;


/**
 * GeneralConfigurations Controller
 *
 * @property \App\Model\Table\GeneralConfigurationsTable $GeneralConfigurations
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GeneralConfigurationsController extends AppController
{

    public $paginate = [
        // 'limit' => 1,
        'order' => [
            // 'Roles.name' => 'asc'
        ]
    ];


    public function index()
    {

        if (!$this->checkIfSuperadmin()) {
            $this->Flash->error(__('you are not authorized to view this page please contact system administrator'));
            return $this->redirect('/admin');
        }

        $conditions = $this->_filter_params();
        $conditions["config_group"] = "general";
        $this->paginate = array('limit' => 100);
        $generalConfigurations = $this->paginate($this->GeneralConfigurations, ['conditions' => $conditions]);

        $parameters = $this->request->getAttribute('params');
        $this->set(compact('parameters', 'generalConfigurations'));

        $this->set('config_groups', $this->GeneralConfigurations->getconfigGroups());
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $this->checkIfSuperadmin();
        Configure::write('debug', true);
        $generalConfiguration = $this->GeneralConfigurations->newEmptyEntity();
        if ($this->request->is('post')) {
            $generalConfiguration = $this->GeneralConfigurations->patchEntity($generalConfiguration, $this->request->getData());
            if ($this->GeneralConfigurations->save($generalConfiguration)) {
                $this->Flash->success(__('The configuration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The configuration could not be saved. Please, try again.'));
        }
        $this->set(compact('generalConfiguration'));
    }
    public function accounting()
    {
        Configure::write('debug', true);
        $accounting_conf_fields = ["classification_cost", "annotation_cost", "review_cost", "classification_files", "annotation_files", "review_files"];
        $generalConfiguration = $this->GeneralConfigurations->newEmptyEntity();
        $this->set(compact('generalConfiguration'));


        $classification_cost = '';
        $annotation_cost = '';
        $review_cost = '';
        $classification_files = '';
        $annotation_files = '';
        $review_files = '';
        $acc_conf = $this->GeneralConfigurations->find()->where(['config_group' => "accounting"])->all()->toArray();
        foreach ($acc_conf as $conf_row) {
            if ($conf_row->field == "classification_cost") {
                $classification_cost = $conf_row->value;
            }
            if ($conf_row->field == "annotation_cost") {
                $annotation_cost = $conf_row->value;
            }
            if ($conf_row->field == "review_cost") {
                $review_cost = $conf_row->value;
            }
            if ($conf_row->field == "classification_files") {
                $classification_files = $conf_row->value;
            }
            if ($conf_row->field == "annotation_files") {
                $annotation_files = $conf_row->value;
            }
            if ($conf_row->field == "review_files") {
                $review_files = $conf_row->value;
            }
        }
        $this->set(compact("classification_cost", "annotation_cost", "review_cost", "classification_files", "annotation_files", "review_files"));

        if ($this->request->is('post')) {
            $reqData = $this->request->getData();
            if (!empty($reqData)) {
                foreach ($reqData as $key => $value) {
                    if (in_array($key, $accounting_conf_fields)) {
                        $this->GeneralConfigurations->updateAll(
                            [  // fields
                                'value' => $value,
                            ],
                            [  // conditions
                                'field' => $key,
                                'config_group' => "accounting",
                            ]
                        );
                    }
                }
                $this->Flash->success(__('The configuration has been saved.'));
                return $this->redirect(['action' => 'accounting']);
            }
        }
    }


    public function manage($group = 'general')
    {
        // phpinfo();
        $this->set('extensions', $this->GeneralConfigurations->extensions);
        $fields = $this->GeneralConfigurations->getFields($group);
        $this->set('fields', array_keys($fields));
        $this->set('group', $group);

        // $generalConfiguration = $this->GeneralConfigurations->getByGroup($group);
        $generalConfiguration = $this->GeneralConfigurations->find('list', ['keyField' => 'field', 'valueField' => 'value'])->where(['GeneralConfigurations.config_group' => $group]);
        // debug($generalConfiguration->toArray());
        $Configurations = $this->GeneralConfigurations->newEmptyEntity();
        $finalFields = array_merge($fields, $generalConfiguration->toArray());
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            if ($this->GeneralConfigurations->insertOrUpdateConfigs($this->request->getData(), $group, $finalFields)) {
                $this->Flash->success(__('The General Configuration has been saved.'));
                return $this->redirect(['action' => 'manage', $group]);
            }
            $this->Flash->error(__('The General Configuration could not be saved. Please, try again.'));
        }


        $this->set('finalFields', $finalFields);
        $dropdownYesNoOptions = $this->GeneralConfigurations->dropdownYesNoOptions;
        $colours = $this->GeneralConfigurations->colours;
        $conf_sort = $this->GeneralConfigurations->conf_sort;

        $this->set(compact('dropdownYesNoOptions', 'colours', 'conf_sort', 'Configurations'));
        // die;
        // $this->render('add');

    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // $this->checkIfSuperadmin();
        $generalConfiguration = $this->GeneralConfigurations->get($id, [
            'contain' => [],
        ]);
        unset($generalConfiguration->password);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $generalConfiguration = $this->GeneralConfigurations->patchEntity($generalConfiguration, $this->request->getData());
            // debug($this->request->getData());
            if ($this->GeneralConfigurations->save($generalConfiguration)) {
                $this->Flash->success(__('The configuration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The configuration could not be saved. Please, try again.'));
        }
        $this->set(compact('generalConfiguration'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->checkIfSuperadmin();
        // $this->request->allowMethod(['post', 'delete']);
        $generalConfiguration = $this->GeneralConfigurations->get($id);
        if ($this->GeneralConfigurations->delete($generalConfiguration)) {
            $this->Flash->success(__('The configuration has been deleted.'));
        } else {
            $this->Flash->error(__('The configuration could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->checkIfSuperadmin();
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Admins->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The admins has been deleted.'));
        } else {
            $this->Flash->error(__('The admins could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function enableRandomSelection()
    {
        if (!empty($this->request->getData())) {
            $req_data = $this->request->getData();
            if (isset($req_data["check"])) {
                $generalConfiguration = $this->GeneralConfigurations->find()->where(["config_group" => "conf"])->first();
                $data_to_save["value"] = ($req_data["check"] == 1) ? 1 : 0;
                $generalConfiguration = $this->GeneralConfigurations->patchEntity($generalConfiguration, $data_to_save);
                if ($this->GeneralConfigurations->save($generalConfiguration)) {
                    die("1");
                }
            }
        }
        die;
    }


    public function clearCache()
    {

        // Configure::write('debug', 2);

        $this->viewBuilder()->disableAutoLayout();
        echo '<h1 style="text-align: center;"><span style="color: #ff0000;">==> Start <==</span></h1>';

        $cacheroot = glob(TMP . 'cache' . DS . '*'); // get all file names

        echo '<h1 style="text-align: center;"><span style="color: #000;">==> Folder -- Root</span></h1>';
        foreach ($cacheroot as $file) {

            // iterate files
            if (is_file($file))
            //echo $file ;
            {
                gc_collect_cycles();
                unlink($file);
                echo "<h3>File -- " . basename($file) . " -- Deleted</h3>";
            }
            // delete file
        }

        $cachefolders = array('configs', 'models', 'persistent', 'views');

        foreach ($cachefolders as $folder) {
            $model = glob(TMP . 'cache' . DS . $folder . DS . '*'); // get all file names
            // debug($model);
            // die;
            echo '<h1 style="text-align: center;"><span style="color: #000;"> ==> Folder -- ' . $folder . '</span></h1>';

            foreach ($model as $file) {
                // iterate files
                if (is_file($file)) {

                    gc_collect_cycles();
                    unlink($file);
                    echo "<h3>File -- " . basename($file) . " -- Deleted</h3>";
                }
                // delete file
            }
        }

        echo '<h1 style="text-align: center;"><strong>-- Done, Thanks -- <span style="color: #ff0000;">AE</span>&nbsp;<img src="https://html-online.com/editor/tinymce4_6_5/plugins/emoticons/img/smiley-cool.gif" alt="cool" /> --</strong></h1>';
        // $this->flashMessage(__('--- All cache files are Deleted, Thanks -- AE :D --'), 'Sucmessage');
        die(":D");
        // $this->redirect(array('action' => 'index'));
    }
}
