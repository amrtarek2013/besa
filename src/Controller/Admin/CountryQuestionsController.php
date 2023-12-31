<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * CountryQuestions Controller
 *
 */

class CountryQuestionsController extends AppController
{

    public function index($country_id = null)
    {
        $conditions = $this->_filter_params();

        if (isset($country_id)) {
            $conditions['country_id'] = $country_id;
            $this->Session->write('country_id', $country_id);
        }

        $countryQuestions = $this->paginate($this->CountryQuestions, ['conditions' => $conditions, 'order' => ['continent' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');



        $this->loadModel('Countries');
        $countries = $this->Countries->find('list', [
            'keyField' => 'id',
            'valueField' => 'country_name',
        ])->where(["active" => 1, 'is_destination'=>1])->order(['country_name' => 'ASC'])->toArray();

        $this->set(compact('countryQuestions', 'parameters', 'countries'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $countryQuestions = $this->paginate($this->CountryQuestions, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');


        $this->loadModel('Countries');
        $countries = $this->Countries->find('list', [
            'keyField' => 'id',
            'valueField' => 'country_name',
        ])->where(["active" => 1, 'is_destination'=>1])->order(['country_name' => 'ASC'])->toArray();
        $this->set(compact('countryQuestions', 'parameters', 'countries'));
    }

    public function add()
    {
        $countryQuestion = $this->CountryQuestions->newEmptyEntity();
        if ($this->request->is('post')) {
            $countryQuestion = $this->CountryQuestions->patchEntity($countryQuestion, $this->request->getData());
            if ($this->CountryQuestions->save($countryQuestion)) {
                $this->Flash->success(__('The Country Questionhas been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The Country Questioncould not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('countryQuestion_new', 'countryQuestions', false, false, ['image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->CountryQuestions->continents;
        $this->set(compact('countryQuestion', 'continents'));
    }

    public function edit($id = null)
    {
        $countryQuestion = $this->CountryQuestions->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $countryQuestion = $this->CountryQuestions->patchEntity($countryQuestion, $this->request->getData());


            if ($this->CountryQuestions->save($countryQuestion)) {
                $this->Flash->success(__('The Country Questionhas been saved.'));

                $this->__redirectToIndex();
            }
            $this->Flash->error(__('The Country Questioncould not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->CountryQuestions->continents;
        $this->set(compact('countryQuestion', 'id', 'continents'));
        $this->_ajaxImageUpload('countryQuestion_' . $id, 'countryQuestions', $id, ['id' => $id], ['image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $countryQuestion = $this->CountryQuestions->get($id);
        if ($this->CountryQuestions->delete($countryQuestion)) {
            $this->Flash->success(__('The Country Questionhas been deleted.'));
        } else {
            $this->Flash->error(__('The Country Questioncould not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->CountryQuestions->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The CountryQuestions has been deleted.'));
        } else {
            $this->Flash->error(__('The CountryQuestions could not be deleted. Please, try again.'));
        }

        $this->__redirectToIndex();
    }

    private function __redirectToIndex()
    {
        if ($this->Session->check('country_id'))
            return $this->redirect(['action' => 'index', $this->Session->read('country_id')]);
        else
            return $this->redirect(['action' => 'index']);
    }
    public function view($id = null)
    {
        $countryQuestion = $this->CountryQuestions->get($id);

        $this->set('countryQuestion', $countryQuestion);
    }

    private function __common()
    {
        $uploadSettings = $this->CountryQuestions->getUploadSettings();

        $this->loadModel('Countries');
        $countries = $this->Countries->find('list', [
            'keyField' => 'id',
            'valueField' => 'country_name',
        ])->where(["active" => 1, 'is_destination'=>1])->order(['country_name' => 'ASC'])->toArray();
        $this->set(compact('uploadSettings', 'countries'));
    }
}
