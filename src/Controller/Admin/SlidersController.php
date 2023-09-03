<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Sliders Controller
 *
 */

class SlidersController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $sliders = $this->paginate($this->Sliders, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->Sliders->types;
        $this->set(compact('sliders', 'parameters', 'types'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $sliders = $this->paginate($this->Sliders, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->Sliders->types;
        $this->set(compact('sliders', 'parameters', 'types'));
    }

    public function add()
    {
        $slider = $this->Sliders->newEmptyEntity();
        if ($this->request->is('post')) {
            $slider = $this->Sliders->patchEntity($slider, $this->request->getData());
            if ($this->Sliders->save($slider)) {
                $this->Flash->success(__('The Slider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Slider could not be saved. Please, try again.'));
        }
        // $this->_ajaxImageUpload('slider_new', 'sliders', false, false, ['image', 'mobile_image']);
        $this->set('id', false);

        $this->__common();
        $types = $this->Sliders->types;
        $this->set(compact('slider', 'types'));
    }

    public function edit($id = null)
    {
        $slider = $this->Sliders->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $slider = $this->Sliders->patchEntity($slider, $this->request->getData());
            if ($this->Sliders->save($slider)) {
                $this->Flash->success(__('The Slider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Slider could not be saved. Please, try again.'));
        }
        
        $this->__common();

        $types = $this->Sliders->types;
        $this->set(compact('slider', 'id', 'types'));
        // $this->_ajaxImageUpload('slider_' . $id, 'sliders', $id, ['id' => $id], ['image', 'mobile_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $slider = $this->Sliders->get($id);
        if ($this->Sliders->delete($slider)) {
            $this->Flash->success(__('The Slider has been deleted.'));
        } else {
            $this->Flash->error(__('The Slider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Sliders->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Sliders has been deleted.'));
        } else {
            $this->Flash->error(__('The Sliders could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $slider = $this->Sliders->get($id);

        $this->set('slider', $slider);
    }

    private function __common()
    {
        $uploadSettings = $this->Sliders->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
