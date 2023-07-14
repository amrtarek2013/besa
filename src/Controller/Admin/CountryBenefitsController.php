<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * CountryBenefits Controller
 *
 */

class CountryBenefitsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $countryBenefits = $this->paginate($this->CountryBenefits, ['conditions' => $conditions, 'order' => ['continent' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->CountryBenefits->continents;
        $this->set(compact('countryBenefits', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $countryBenefits = $this->paginate($this->CountryBenefits, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->CountryBenefits->continents;
        $this->set(compact('countryBenefits', 'parameters', 'continents'));
    }

    public function add()
    {
        $countryBenefit = $this->CountryBenefits->newEmptyEntity();
        if ($this->request->is('post')) {
            $countryBenefit = $this->CountryBenefits->patchEntity($countryBenefit, $this->request->getData());
            if ($this->CountryBenefits->save($countryBenefit)) {
                $this->Flash->success(__('The Country Benefit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Country Benefit could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('countryBenefit_new', 'countryBenefits', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->CountryBenefits->continents;
        $this->set(compact('countryBenefit', 'continents'));
    }

    public function edit($id = null)
    {
        $countryBenefit = $this->CountryBenefits->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $countryBenefit = $this->CountryBenefits->patchEntity($countryBenefit, $this->request->getData());


            if ($this->CountryBenefits->save($countryBenefit)) {
                $this->Flash->success(__('The Country Benefit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Country Benefit could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->CountryBenefits->continents;
        $this->set(compact('countryBenefit', 'id', 'continents'));
        $this->_ajaxImageUpload('countryBenefit_' . $id, 'countryBenefits', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $countryBenefit = $this->CountryBenefits->get($id);
        if ($this->CountryBenefits->delete($countryBenefit)) {
            $this->Flash->success(__('The Country Benefit has been deleted.'));
        } else {
            $this->Flash->error(__('The Country Benefit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->CountryBenefits->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The CountryBenefits has been deleted.'));
        } else {
            $this->Flash->error(__('The CountryBenefits could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $countryBenefit = $this->CountryBenefits->get($id);

        $this->set('countryBenefit', $countryBenefit);
    }

    private function __common()
    {
        $uploadSettings = $this->CountryBenefits->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
