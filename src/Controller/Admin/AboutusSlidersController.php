<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Aboutus Sliders Controller
 *
 */

class AboutusSlidersController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $aboutusSliders = $this->paginate($this->AboutusSliders, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('aboutusSliders', 'parameters'));
        $this->__common();
    }
    public function list($country_id = null)
    {
        $conditions = $this->_filter_params();

        $aboutusSliders = $this->paginate($this->AboutusSliders, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->__common();
        $this->set(compact('aboutusSliders', 'parameters'));
    }

    public function add()
    {
        $aboutusSlider = $this->AboutusSliders->newEmptyEntity();
        if ($this->request->is('post')) {
            $aboutusSlider = $this->AboutusSliders->patchEntity($aboutusSlider, $this->request->getData());
            if ($this->AboutusSliders->save($aboutusSlider)) {
                $this->Flash->success(__('The Aboutus Slider has been saved.'));


                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The Aboutus Slider could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('aboutusSlider_new', 'aboutusSliders', false, false, ['image']);
        $this->set('id', false);

        $this->__common();

        $this->set(compact('aboutusSlider'));
    }

    public function edit($id = null)
    {
        $aboutusSlider = $this->AboutusSliders->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aboutusSlider = $this->AboutusSliders->patchEntity($aboutusSlider, $this->request->getData());
            if ($this->AboutusSliders->save($aboutusSlider)) {

                $this->Flash->success(__('The Aboutus Slider has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The Aboutus Slider could not be saved. Please, try again.'));
        }
        $this->__common();
        $this->set(compact('aboutusSlider', 'id'));
        $this->_ajaxImageUpload('aboutusSlider_' . $id, 'aboutusSliders', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $aboutusSlider = $this->AboutusSliders->get($id);
        if ($this->AboutusSliders->delete($aboutusSlider)) {
            $this->Flash->success(__('The Aboutus Slider has been deleted.'));
        } else {
            $this->Flash->error(__('The Aboutus Slider could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->AboutusSliders->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Aboutus Sliders has been deleted.'));
        } else {
            $this->Flash->error(__('The Aboutus Sliders could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function view($id = null)
    {
        $aboutusSlider = $this->AboutusSliders->get($id);

        $this->set('aboutusSlider', $aboutusSlider);
    }

    private function __redirectToIndex()
    {
        // if ($this->Session->check('country_id'))
        //     return $this->redirect(['action' => 'index', $this->Session->read('country_id')]);
        // else
        return $this->redirect(['action' => 'index']);
    }
    private function __common()
    {
        $uploadSettings = $this->AboutusSliders->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
