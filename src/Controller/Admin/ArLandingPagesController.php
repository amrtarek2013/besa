<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController ;

/**
 * ArLandingPages Controller
 *
 */

class ArLandingPagesController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $arLandingPages = $this->paginate($this->ArLandingPages,['conditions'=>$conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('arLandingPages','parameters'));
    }

    public function add()
    {
        $arLandingPage = $this->ArLandingPages->newEmptyEntity();
        if ($this->request->is('post')) {
            $arLandingPage = $this->ArLandingPages->patchEntity($arLandingPage, $this->request->getData());
            if ($this->ArLandingPages->save($arLandingPage)) {
                $this->Flash->success(__('The Ar Landing Page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Ar Landing Page could not be saved. Please, try again.'));
        }
        $this->__common();
        $this->set(compact('arLandingPage'));


    }

    public function edit($id = null)
    {
        $arLandingPage = $this->ArLandingPages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $arLandingPage = $this->ArLandingPages->patchEntity($arLandingPage, $this->request->getData());
            if ($this->ArLandingPages->save($arLandingPage)) {
                $this->Flash->success(__('The Ar Landing Page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Ar Landing Page could not be saved. Please, try again.'));
        }  
        $this->__common();
        $this->set(compact('arLandingPage'));
        $this->render('add');

    }
    private function __common()
    {
        $uploadSettings = $this->ArLandingPages->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete','get']);
        $arLandingPage = $this->ArLandingPages->get($id);
        if ($this->ArLandingPages->delete($arLandingPage)) {
            $this->Flash->success(__('The Ar Landing Page has been deleted.'));
        } else {
            $this->Flash->error(__('The Ar Landing Page could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');
        
        if(is_array($ids) ){
          $this->ArLandingPages->deleteAll(['id IN' => $ids]);
         $this->Flash->success(__('The ArLandingPages has been deleted.'));
        } else {
            $this->Flash->error(__('The ArLandingPages could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
        
    }

    public function view($id = null)
    {
        $arLandingPage = $this->ArLandingPages->get($id);

        $this->set('arLandingPage', $arLandingPage);
    }


}
