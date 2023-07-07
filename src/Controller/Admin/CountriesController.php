<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Countries Controller
 *
 */

class CountriesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $countries = $this->paginate($this->Countries, ['conditions' => $conditions, 'order'=>['continent'=>'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Countries->continents;
        $this->set(compact('countries', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $countries = $this->paginate($this->Countries, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Countries->continents;
        $this->set(compact('countries', 'parameters', 'continents'));
    }

    public function add()
    {
        $country = $this->Countries->newEmptyEntity();
        if ($this->request->is('post')) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('The Country has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Country could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('country_new', 'countries', false, false, ['image_why_study','image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->Countries->continents;
        $this->set(compact('country', 'continents'));
    }

    public function edit($id = null)
    {
        $country = $this->Countries->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
           $country = $this->Countries->patchEntity($country, $this->request->getData());

            
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('The Country has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Country could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->Countries->continents;
        $this->set(compact('country', 'id', 'continents'));
        $this->_ajaxImageUpload('country_' . $id, 'countries', $id, ['id' => $id], ['image_why_study','image', 'flag', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $country = $this->Countries->get($id);
        if ($this->Countries->delete($country)) {
            $this->Flash->success(__('The Country has been deleted.'));
        } else {
            $this->Flash->error(__('The Country could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Countries->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Countries has been deleted.'));
        } else {
            $this->Flash->error(__('The Countries could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $country = $this->Countries->get($id);

        $this->set('country', $country);
    }

    private function __common()
    {
        $uploadSettings = $this->Countries->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
