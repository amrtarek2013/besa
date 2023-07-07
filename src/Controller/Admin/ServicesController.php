<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Services Controller
 *
 */

class ServicesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $services = $this->paginate($this->Services, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->Services->types;
        $this->set(compact('services', 'parameters', 'types'));
        
        $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $services = $this->paginate($this->Services, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $types = $this->Services->types;
        
        $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);
        $this->set(compact('services', 'parameters', 'types'));
    }

    public function add()
    {
        $service = $this->Services->newEmptyEntity();
        if ($this->request->is('post')) {
            $service = $this->Services->patchEntity($service, $this->request->getData());
            if ($this->Services->save($service)) {
                $this->Flash->success(__('The Service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Service could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('service_new', 'services', false, false, ['icon','image', 'banner_image', 'mobile_image']);
        $this->set('id', false);

        $this->__common();
        $types = $this->Services->types;
        $this->set(compact('service', 'types'));
        
        $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);
    }

    public function edit($id = null)
    {
        $service = $this->Services->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
           $service = $this->Services->patchEntity($service, $this->request->getData());

            
            if ($this->Services->save($service)) {
                $this->Flash->success(__('The Service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Service could not be saved. Please, try again.'));
        }

        $this->__common();

        $types = $this->Services->types;
        $this->set(compact('service', 'id', 'types'));
        $this->_ajaxImageUpload('service_' . $id, 'services', $id, ['id' => $id], ['icon','image', 'banner_image', 'mobile_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $service = $this->Services->get($id);
        if ($this->Services->delete($service)) {
            $this->Flash->success(__('The Service has been deleted.'));
        } else {
            $this->Flash->error(__('The Service could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Services->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Services has been deleted.'));
        } else {
            $this->Flash->error(__('The Services could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $service = $this->Services->get($id);

        $this->set('service', $service);
    }

    private function __common()
    {
        $uploadSettings = $this->Services->getUploadSettings();
        $this->set(compact('uploadSettings'));
        
        $this->set('searchDegreeOptions', $this->Services->searchDegreeOptions);
    }
}
