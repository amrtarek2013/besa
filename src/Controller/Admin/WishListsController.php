<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * WishLists Controller
 *
 */

class WishListsController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $wishLists = $this->paginate($this->WishLists, ['conditions' => $conditions, 'contain'=>['Courses'], 'order'=>['continent'=>'ASC']]);
        $parameters = $this->request->getAttribute('params');
        // dd($wishLists);
        $this->set(compact('wishLists', 'parameters'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $wishLists = $this->paginate($this->WishLists, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        
        $this->set(compact('wishLists', 'parameters'));
    }

    // public function add()
    // {
    //     $wishList = $this->WishLists->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $wishList = $this->WishLists->patchEntity($wishList, $this->request->getData());
    //         if ($this->WishLists->save($wishList)) {
    //             $this->Flash->success(__('The WishList has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The WishList could not be saved. Please, try again.'));
    //     }
    //     $this->_ajaxImageUpload('wishList_new', 'wishLists', false, false, ['image_why_study','image', 'flag', 'banner_image']);
    //     $this->set('id', false);

    //     $this->__common();
        
    //     $this->set(compact('wishList'));
    // }

    // public function edit($id = null)
    // {
    //     $wishList = $this->WishLists->get($id);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //        $wishList = $this->WishLists->patchEntity($wishList, $this->request->getData());

            
    //         if ($this->WishLists->save($wishList)) {
    //             $this->Flash->success(__('The WishList has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The WishList could not be saved. Please, try again.'));
    //     }

    //     $this->__common();

        
    //     $this->set(compact('wishList', 'id'));
    //     $this->_ajaxImageUpload('wishList_' . $id, 'wishLists', $id, ['id' => $id], ['image_why_study','image', 'flag', 'banner_image']);
    //     $this->render('add');
    // }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $wishList = $this->WishLists->get($id);
        if ($this->WishLists->delete($wishList)) {
            $this->Flash->success(__('The WishList has been deleted.'));
        } else {
            $this->Flash->error(__('The WishList could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->WishLists->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The WishLists has been deleted.'));
        } else {
            $this->Flash->error(__('The WishLists could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $wishList = $this->WishLists->get($id);

        $this->set('wishList', $wishList);
    }

    private function __common()
    {
        $uploadSettings = $this->WishLists->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
