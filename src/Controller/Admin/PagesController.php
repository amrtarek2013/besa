<?php

declare(strict_types=1);

namespace App\Controller\Admin;


use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Pages Controller
 *
 */

class PagesController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();
        // debug($conditions);die;
        $pages = $this->paginate($this->Pages, ['conditions' => $conditions, 'order' => ['title' => 'asc']]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('pages', 'parameters'));
    }
    

    public function add()
    {
        $page = $this->Pages->newEmptyEntity();
        if ($this->request->is('post')) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('The Page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Page could not be saved. Please, try again.'));
        }
        $this->set(compact('page'));
        $this->__common();
        $this->_ajaxImageUpload('page_new', 'pages', false, false, ['banner_image']);
       
    }

    public function edit($id = null,$source='')
    {
        $page = $this->Pages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('The Page has been saved.'));
                if(!empty($source)){
                    return $this->redirect(['controller'=>$source,'action' => 'index']);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Page could not be saved. Please, try again.'));
        }
        $this->set(compact('page', 'id'));
        $this->__common();
        $this->_ajaxImageUpload('page_' . $id, 'pages', $id, ['id' => $id], ['banner_image']);
        
        $this->render('add');
    }

    public function delete($id = null,$source='')
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
            $this->Flash->success(__('The Page has been deleted.'));
        } else {
            $this->Flash->error(__('The Page could not be deleted. Please, try again.'));
        }
        if(!empty($source)){
            return $this->redirect(['controller'=>$source,'action' => 'index']);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete', 'get']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Pages->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Pages has been deleted.'));
        } else {
            $this->Flash->error(__('The Pages could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $page = $this->Pages->get($id);

        $this->set('page', $page);
    }

    private function __common()
    {
        $uploadSettings = $this->Pages->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }

    function pageSection($section,$category_id = false)
    {
        if ($this->request->is('ajax') || 1) {
            // dd($section);
            if (!empty($section)) {
                $model = $section;

                $dynamic_banners = array(
                    'DynamicBanner-LIST-YOUR-CAR' => 1,
                    'DynamicBanner-SEARCH-BY-CATEGORY' => 2,
                    'DynamicBanner-SEARCH-BY-MAKE-and-MODEL' => 3,
                    'DynamicBanner-2-BUTTONS' => 4,
                    'DynamicBanner-3-BUTTONS' => 5
                );


                if (isset($dynamic_banners[$model])) {

                    $this->loadModel("DynamicBanner");


                    $result = $this->DynamicBanner->find("all", array("conditions" => array("version" => $dynamic_banners[$model])));
                    $model = "DynamicBanner";
                } else {
                    $PageSecModel = TableRegistry::getTableLocator()->get('page_sections');
                    $modelName = $PageSecModel->find()->where(['file_name' => $model])->first();
                    $newModel = TableRegistry::getTableLocator()->get($modelName->model_name);
                    if ($section == 'advertisingsections'){
                        $data = $newModel->find('all')->where(['fixed' => false]);
                    }elseif ($section == 'free_htmls' && !empty($category_id)){
                        $data = $newModel->find()->where(['category_id' => $category_id]);
                    }
                    else{
                        $data = $newModel->find('all');
                    }

                    $result = $data->toArray();
                }

                $data_array = array();
                foreach ($result as $i => $record) {
                    $data_array[$i]['id'] = $record->id;
                    if ($model == 'Special') {
                        $title = $record->spc_fname . ' ' . $record->spc_lname;
                    } else {
                        $title = (!empty($record->title)) ? $record->title : $record->name;
                    }
                    $data_array[$i]['name'] = $title;

                    // Added by Dk For Free Html Category
                    if ($model == 'free_htmls') { // && !empty($record->category_id)) {
                        $data_array[$i]['category_id'] = $record->category_id;
                    }
                }

                // Added by Dk For Free Html Category
                // if ($model == 'free_htmls') {
                //     $data_array      = Hash::combine($data_array, "{n}.id", "{n}", "{n}.category_id");
                //     // dd($data_array);
                // }
            }

            echo json_encode($data_array);
            exit;
        }
        $this->autoRender = false;
    }


    public function preview()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $this->viewBuilder()->setLayout('default');
            // debug($data);
            $this->set('page', $data);
            $this->render('view');
        }
    }

    public function all()
    {
        $conditions = $this->_filter_params();
        // debug($conditions);die;
        $this->paginate = [
            'limit' => 100,
            'order' => [
                'Pages.display_order' => 'asc'
            ]
        ];
        $this->set('menus', $this->Pages->find('list', array('conditions' => array('(Pages.menu_id = 0 OR Pages.menu_id IS NULL)'))));

        $this->set('submenus', $this->Pages->find('list', array('conditions' => array('Pages.submenu_id' => 0))));
        $pages = $this->paginate($this->Pages, ['conditions' => $conditions]);
        // debug($pages);die;
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('pages', 'parameters'));
    }

    function redirectToHome($id)
    {
        // $this->layout = $this->autoRender = false;
        if (!$id) {
            $this->Flash->error(__('The Pages could not be found. Please, try again.'));
            $this->redirect(array('action' => 'all'));
        }

        $page =  $this->Pages->get($id);

        $this->loadModel('Urls');

        $id = $this->Urls->createIfNotExistByPageId($page);
        $this->redirect(array('controller' => 'urls', 'action' => 'edit', $id));
    }
    function sectionsbycategory($category_id)
    {
        // dd($section);
        if (!empty($category_id)) {
            $PageSecModel = TableRegistry::getTableLocator()->get('page_sections');
            $related_sections = $PageSecModel->find('all')->where(['category_id' => $category_id]);
            $result = $related_sections->toArray();

            // Free htmls
            $freeModel = TableRegistry::getTableLocator()->get('free_htmls');
            $related_free_sections = $freeModel->find('all')->where(['category_id' => intval($category_id)]);
            $free_arr = $related_free_sections->toArray();
            // print_r($free_arr);die;



            $data_array = array();
            foreach ($result as $i => $record) {
                $data_array[$i]['id'] = $record->id;
                $data_array[$i]['name'] = $record->title;
                $data_array[$i]['fname'] = $record->file_name;
            }
            if(!empty($free_arr)){
                $tmp_arr['id'] = 1010101010;
                $tmp_arr['name'] = "Free Htmls";
                $tmp_arr['fname'] = "free_htmls";
                $data_array[] = $tmp_arr;
            }
        }

        echo json_encode($data_array);
        exit;
        
        $this->autoRender = false;
    }

    public function deletecache()
    {


        $this->autoRender = false;
        $cachefolders = array( 'models','persistent', 'views','configs','queries','snippets');


        foreach ($cachefolders as $folder) {
            echo TMP . 'cache' . DS . $folder . DS.' --+ <br>';
            $model = glob(TMP . 'cache' . DS . $folder . DS . '*'); 
            // dd($model);
          
            foreach ($model as $file) { // iterate files
                echo $file.' --+ <br>';
                if (is_file($file))
                    unlink($file); // delete file
            }
        }
        $cacheroot = glob(TMP . 'cache' . DS . '*'); // get all file names
        foreach ($cacheroot as $file) { // iterate files
            if (is_file($file)){
                echo $file.' --+ <br>';
                unlink($file); // delete file
            }
                //echo $file ;
               
        }
        die(":D");
    }

}
