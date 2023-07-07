<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Blogs Controller
 *
 */

class BlogsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $blogs = $this->paginate($this->Blogs, ['conditions' => $conditions, 'order'=>['continent'=>'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Blogs->continents;
        $this->set(compact('blogs', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $blogs = $this->paginate($this->Blogs, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Blogs->continents;
        $this->set(compact('blogs', 'parameters', 'continents'));
    }

    public function add()
    {
        $blog = $this->Blogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $blog = $this->Blogs->patchEntity($blog, $this->request->getData());
            if ($this->Blogs->save($blog)) {
                $this->Flash->success(__('The Blog has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Blog could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('blog_new', 'blogs', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->Blogs->continents;
        $this->set(compact('blog', 'continents'));
    }

    public function edit($id = null)
    {
        $blog = $this->Blogs->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
           $blog = $this->Blogs->patchEntity($blog, $this->request->getData());

            
            if ($this->Blogs->save($blog)) {
                $this->Flash->success(__('The Blog has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Blog could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->Blogs->continents;
        $this->set(compact('blog', 'id', 'continents'));
        $this->_ajaxImageUpload('blog_' . $id, 'blogs', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $blog = $this->Blogs->get($id);
        if ($this->Blogs->delete($blog)) {
            $this->Flash->success(__('The Blog has been deleted.'));
        } else {
            $this->Flash->error(__('The Blog could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Blogs->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Blogs has been deleted.'));
        } else {
            $this->Flash->error(__('The Blogs could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $blog = $this->Blogs->get($id);

        $this->set('blog', $blog);
    }

    private function __common()
    {
        $uploadSettings = $this->Blogs->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
