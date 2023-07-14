<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * CountryPartners Controller
 *
 */

class CountryPartnersController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $countryPartners = $this->paginate($this->CountryPartners, ['conditions' => $conditions, 'order' => ['continent' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->CountryPartners->continents;
        $this->set(compact('countryPartners', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $countryPartners = $this->paginate($this->CountryPartners, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->CountryPartners->continents;
        $this->set(compact('countryPartners', 'parameters', 'continents'));
    }

    public function add()
    {
        $countryPartner = $this->CountryPartners->newEmptyEntity();
        if ($this->request->is('post')) {
            $countryPartner = $this->CountryPartners->patchEntity($countryPartner, $this->request->getData());
            if ($this->CountryPartners->save($countryPartner)) {
                $this->Flash->success(__('The  Country Partner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The  Country Partner could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('countryPartner_new', 'countryPartners', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->CountryPartners->continents;
        $this->set(compact('countryPartner', 'continents'));
    }

    public function edit($id = null)
    {
        $countryPartner = $this->CountryPartners->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $countryPartner = $this->CountryPartners->patchEntity($countryPartner, $this->request->getData());


            if ($this->CountryPartners->save($countryPartner)) {
                $this->Flash->success(__('The  Country Partner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The  Country Partner could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->CountryPartners->continents;
        $this->set(compact('countryPartner', 'id', 'continents'));
        $this->_ajaxImageUpload('countryPartner_' . $id, 'countryPartners', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $countryPartner = $this->CountryPartners->get($id);
        if ($this->CountryPartners->delete($countryPartner)) {
            $this->Flash->success(__('The  Country Partner has been deleted.'));
        } else {
            $this->Flash->error(__('The  Country Partner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->CountryPartners->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The CountryPartners has been deleted.'));
        } else {
            $this->Flash->error(__('The CountryPartners could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $countryPartner = $this->CountryPartners->get($id);

        $this->set('countryPartner', $countryPartner);
    }

    private function __common()
    {
        $uploadSettings = $this->CountryPartners->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
