<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
// use Cake\Core\Configure;
/**
 * Snippets Controller
 *
 */

class SnippetsController extends AppController
{

    public function index($cat = null)
    {
        $this->checkIfSuperadmin();

        $conditions = $this->_filter_params();
        // debug($conditions);die;
        if (isset($cat))
            $conditions['category'] = $cat;
        $snippets = $this->paginate($this->Snippets, ['conditions' => $conditions, 'limit' => 100]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('snippets', 'parameters'));

        $categoryTitle = isset($this->Snippets->snippetCategories[$cat])?$this->Snippets->snippetCategories[$cat]: 'Enquiries';
        $this->set('categoryTitle', $categoryTitle);
        $this->__common();
    }

    public function list($cat = null)
    {

        $conditions = $this->_filter_params();
        $conditions['active'] = true;

        if (isset($cat))
            $conditions['category'] = $cat;
        $snippets = $this->paginate($this->Snippets, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('snippets', 'parameters'));
        $this->__common();
    }

    public function add()
    {
        $this->checkIfSuperadmin();
        $snippet = $this->Snippets->newEmptyEntity();
        if ($this->request->is('post')) {
            $snippet = $this->Snippets->patchEntity($snippet, $this->request->getData());
            if ($this->Snippets->save($snippet)) {
                $this->Flash->success(__('The Snippet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Snippet could not be saved. Please, try again.'));
        }

        $this->__common();
        $this->set(compact('snippet'));
    }

    public function edit($name = null)
    {


        $this->checkIfSuperadmin();
        $snippet = $this->Snippets->findByName($name)->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $snippet = $this->Snippets->patchEntity($snippet, $this->request->getData());

            // debug($snippet); die;
            if ($this->Snippets->save($snippet)) {
                $this->Snippets->updateCache($name);
                $this->Flash->success(__('The Snippet has been saved.'));

                return $this->redirect(['action' => 'index', $snippet['category']]);
            }
            $this->Flash->error(__('The Snippet could not be saved. Please, try again.'));
        }
        $this->__common();
        $this->set(compact('snippet'));
        $this->render('add');
    }

    public function manage($name = null)
    {
        // Configure::write('debug', true);
        $snippet = $this->Snippets->findByName($name)->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $snippet = $this->Snippets->patchEntity($snippet, $this->request->getData());

            if ($this->Snippets->save($snippet)) {
                $this->Snippets->updateCache($name);
                $this->Flash->success(__('The Snippet has been saved.'));

                return $this->redirect(['action' => 'index', $snippet['category']]);
            }
            // dd($snippet->getErrors());
            $this->Flash->error(__('The Snippet could not be saved. Please, try again.'));
        }
        $this->__common();
        $this->set(compact('snippet'));
    }

    private function __common()
    {
        $this->set('categories', $this->Snippets->snippetCategories);
        $this->set('modalPopupIDs', $this->Snippets->modalPopupIDs);

        $uploadSettings = $this->Snippets->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
    public function delete($id = null)
    {
        $this->checkIfSuperadmin();
        $this->request->allowMethod(['post', 'delete', 'get']);
        $snippet = $this->Snippets->get($id);
        if ($this->Snippets->delete($snippet)) {
            $this->Flash->success(__('The Snippet has been deleted.'));
        } else {
            $this->Flash->error(__('The Snippet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', $snippet['category']]);
    }

    public function deleteMulti()
    {
        $this->checkIfSuperadmin();
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Snippets->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Snippets has been deleted.'));
        } else {
            $this->Flash->error(__('The Snippets could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    private function __redirectToIndex()
    {
        if ($this->Session->check('category'))
            return $this->redirect(['action' => 'index', $this->Session->read('category')]);
        else
            return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $snippet = $this->Snippets->get($id);

        $this->set('snippet', $snippet);
    }

    public function updateAll($value = '')
    {
        $this->checkIfSuperadmin();
        die;
        $snippetss = array(

            array('name' => 'footer', 'title' => 'Footer', 'advanced_editor' => true, 'no_inserts' => true, 'single' => true),
            array('name' => 'home_footer_mobile', 'title' => 'Home Mobile Footer', 'advanced_editor' => true, 'mobile' => true),


            array('name' => 'top', 'title' => 'Top Section', 'advanced_editor' => true, 'single' => true, 'type' => 'dynamic_pages'),
            array('name' => 'bottom', 'title' => 'Bottom Section', 'advanced_editor' => true, 'single' => true, 'type' => 'dynamic_pages'),
        );


        foreach ($snippetss as  $snippets) {
            $snippet = $this->Snippets->findByPermalink($snippets['name'])->first();
            if ($snippet) {
                if ($snippets['advanced_editor']) {
                    $snippet->editor_type = 2;
                } else {
                    $snippet->editor_type = 0;
                }
                $snippet->title = ($snippets['title']) ? $snippets['title'] : '';
                $snippet->single = (isset($snippets['single'])) ? $snippets['single'] : false;
                $snippet->active = (isset($snippets['active'])) ? $snippets['active'] : false;
                $snippet->ads = (isset($snippets['ads'])) ? json_encode($snippets['ads']) : '{}';
                $this->Snippets->save($snippet);
            }
        }

        die;
    }
}
