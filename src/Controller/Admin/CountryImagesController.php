<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Country Images Controller
 *
 */

class CountryImagesController extends AppController
{

    public function index($country_id = null)
    {
        $conditions = $this->_filter_params();


        if (isset($country_id)) {
            $conditions['country_id'] = $country_id;
            $this->Session->write('country_id', $country_id);
        }
        $countryImages = $this->paginate($this->CountryImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('countryImages', 'parameters'));
        $this->__common();
    }
    public function list($country_id = null)
    {
        $conditions = $this->_filter_params();


        if (isset($country_id))
            $conditions['country_id'] = $country_id;
        $countryImages = $this->paginate($this->CountryImages, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->__common();
        $this->set(compact('countryImages', 'parameters'));
    }

    public function add()
    {
        $countryImage = $this->CountryImages->newEmptyEntity();
        if ($this->request->is('post')) {
            $countryImage = $this->CountryImages->patchEntity($countryImage, $this->request->getData());
            if ($this->CountryImages->save($countryImage)) {
                $this->Flash->success(__('The CountryImage has been saved.'));


                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The CountryImage could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('countryImage_new', 'countryImages', false, false, ['image']);
        $this->set('id', false);

        $this->__common();

        $this->set(compact('countryImage'));
    }

    public function edit($id = null)
    {
        $countryImage = $this->CountryImages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $countryImage = $this->CountryImages->patchEntity($countryImage, $this->request->getData());
            if ($this->CountryImages->save($countryImage)) {

                $this->Flash->success(__('The Country Image has been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The Country Image could not be saved. Please, try again.'));
        }
        $this->__common();
        $this->set(compact('countryImage', 'id'));
        $this->_ajaxImageUpload('countryImage_' . $id, 'countryImages', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $countryImage = $this->CountryImages->get($id);
        if ($this->CountryImages->delete($countryImage)) {
            $this->Flash->success(__('The CountryImage has been deleted.'));
        } else {
            $this->Flash->error(__('The CountryImage could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->CountryImages->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Country Images has been deleted.'));
        } else {
            $this->Flash->error(__('The Country Images could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function view($id = null)
    {
        $countryImage = $this->CountryImages->get($id);

        $this->set('countryImage', $countryImage);
    }

    private function __redirectToIndex()
    {
        if ($this->Session->check('country_id'))
            return $this->redirect(['action' => 'index', $this->Session->read('country_id')]);
        else
            return $this->redirect(['action' => 'index']);
    }
    private function __common()
    {
        $uploadSettings = $this->CountryImages->getUploadSettings();

        $this->loadModel('Countries');
        $countries = $this->Countries->find('list', [
            'keyField' => 'id',
            'valueField' => 'country_name',
        ])->where(["active" => 1, 'is_destination'=>1])->order(['country_name' => 'ASC'])->toArray();
        $this->set(compact('uploadSettings', 'countries'));
    }
}
