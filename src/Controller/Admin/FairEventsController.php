<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * FairEvents Controller
 *
 */

class FairEventsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $fairEvents = $this->paginate($this->FairEvents, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('fairEvents', 'parameters'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $fairEvents = $this->paginate($this->FairEvents, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');

        $this->set(compact('fairEvents', 'parameters'));
    }

    public function add()
    {
        $fairEvent = $this->FairEvents->newEmptyEntity();
        if ($this->request->is('post')) {
            $fairEvent = $this->FairEvents->patchEntity($fairEvent, $this->request->getData());
            if ($this->FairEvents->save($fairEvent)) {
                $this->Flash->success(__('The Fair Event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Fair Event could not be saved. Please, try again.'));
        }
        $this->set('id', false);

        $this->__common();

        $this->set(compact('fairEvent'));
    }

    public function edit($id = null)
    {
        $fairEvent = $this->FairEvents->get($id);
        $fairEvent['countries'] = !empty($fairEvent['countries']) ? explode(',', $fairEvent['countries']) : [];
        $fairEvent['universities'] = !empty($fairEvent['universities']) ? explode(',', $fairEvent['universities']) : [];
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fairEvent = $this->FairEvents->patchEntity($fairEvent, $this->request->getData());
            // dd($fairEvent);
            if ($this->FairEvents->save($fairEvent)) {
                $this->Flash->success(__('The Fair Event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Fair Event could not be saved. Please, try again.'));
        }

        $this->__common();
        $this->set(compact('fairEvent', 'id'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $fairEvent = $this->FairEvents->get($id);
        if ($this->FairEvents->delete($fairEvent)) {
            $this->Flash->success(__('The Fair Event has been deleted.'));
        } else {
            $this->Flash->error(__('The Fair Event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->FairEvents->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The FairEvents has been deleted.'));
        } else {
            $this->Flash->error(__('The FairEvents could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $fairEvent = $this->FairEvents->get($id);

        $this->set('fairEvent', $fairEvent);
    }

    private function __common()
    {
        $uploadSettings = $this->FairEvents->getUploadSettings();
        $this->set(compact('uploadSettings'));
        $this->set('centerBoxStyle', $this->FairEvents->centerBoxStyle);

        $this->loadModel('Universities');
        $cached_universities = $this->Universities->find(
            'list',
            ['keyField' => 'id', 'valueField' => 'university_name']
        )->order(['university_name' => 'asc'])->cache('cached_universities')->toArray();

        $this->set('universitiesList', $cached_universities);

        $this->loadModel('Countries');
        $countriesList = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1])->order(['country_name' => 'asc'])->toArray();
        $this->set('countriesList', $countriesList);



        $this->loadModel('Events');
        $eventsList = $this->Events->find(
            'list',
            ['keyField' => 'id', 'valueField' => 'title']
        )->order(['title' => 'asc'])->cache('cached_events')->toArray();

        $this->set('eventsList', $eventsList);
    }
}
