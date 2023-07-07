<?php
declare (strict_types = 1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
/**
 * Menus Controller
 *
 */

class MenusController extends AppController {

	public function a() {
		$conditions = $this->_filter_params();
		$this->paginate['sortWhitelist'] = ['*'];
		$menus = $this->paginate($this->Menus, ['conditions' => $conditions]);
		$parameters = $this->request->getAttribute('params');
		$this->set(compact('menus', 'parameters'));
		$this->_common();
	}
	public function index() {
		// Configure::write('debug', true);
		$conditions = $this->_filter_params();
		if (isset($conditions['Menus.is_parent'])) {
			$is_parent = $conditions['Menus.is_parent'];
			if ($is_parent == 1) {
				$conditions['Menus.parent_id'] = 0;
			} else {
				$conditions['Menus.parent_id !='] = 0;
			}
			unset($conditions['Menus.is_parent']);
		}

		$query = $this->Menus->find('all')->where($conditions)->contain('SubMenu');
		$menus = $this->paginate($query);

		$parameters = $this->request->getAttribute('params');
		$parents = [];
		$allparents = $this->Menus->find('all')->where(['parent_id' => 0]);
		foreach ($allparents as $menu) {
			$parents[$menu->id] = ucfirst($menu->prefix).' - '.$menu->title;
		}
// dd($parents);
		// $parents = $this->Menus->find('list')->where(['parent_id <' => 1]);
		// $parents = $parents->toArray();
		
		$this->set(compact('menus', 'parameters', 'parents'));

		$this->_common();
	}

	public function children($parentId) {

		$conditions = $this->_filter_params();
		if (isset($conditions['Menus.is_parent'])) {
			unset($conditions['Menus.is_parent']);
		}

		$conditions['Menus.parent_id'] = $parentId;

		$query = $this->Menus->find('all')->where($conditions)->contain('SubMenu');
		$menus = $this->paginate($query);

		$parameters = $this->request->getAttribute('params');

		$parents = $this->Menus->find('list')->where(['parent_id <' => 1]);
		$parents = $parents->toArray();
		$this->set(compact('menus', 'parameters', 'parents'));

		$this->_common();
	}

	public function add() {
		Configure::write('debug', true);
		$menu = $this->Menus->newEmptyEntity();
		if ($this->request->is('post')) {
			$menu = $this->Menus->patchEntity($menu, $this->request->getData());
			if ($this->Menus->save($menu)) {
				$this->Flash->success(__('The Menu has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The Menu could not be saved. Please, try again.'));
		}

		$this->set(compact('menu'));
		$this->_common();

	}

	public function edit($id = null) {
		Configure::write('debug', true);
		$menu = $this->Menus->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			// debug($this->request->getData());die;
			$menu = $this->Menus->patchEntity($menu, $this->request->getData());
			if ($this->Menus->save($menu)) {
				$this->Flash->success(__('The Menu has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The Menu could not be saved. Please, try again.'));
		}
		$this->set(compact('menu'));
		$this->_common();
		$this->render('add');

	}

	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete', 'get']);
		$menu = $this->Menus->get($id);
		if ($this->Menus->delete($menu)) {
			$this->Flash->success(__('The Menu has been deleted.'));
		} else {
			$this->Flash->error(__('The Menu could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	public function deleteMulti() {
		$this->request->allowMethod(['post', 'delete', 'get']);

		$ids = $this->request->getData('ids');

		if (is_array($ids)) {
			$this->Menus->deleteAll(['id IN' => $ids]);
			$this->Flash->success(__('The Menus has been deleted.'));
		} else {
			$this->Flash->error(__('The Menus could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);

	}

	public function view($id = null) {
		$menu = $this->Menus->get($id);

		$this->set('menu', $menu);
	}

	public function _common() {
		$finalMenuList = [];
		$menus = $this->Menus->find('all')->Order(['title'=>'asc']);
		$finalMenuList[0] = '---';
		foreach ($menus as $menu) {
			$finalMenuList[$menu->id] = ucfirst($menu->prefix).' - '.$menu->title;
		}
		// dd($finalMenuList);
		
		$prefixs = $this->Menus->prefixs;
		$types = $this->Menus->types;
		$this->set(compact('prefixs', 'types'));
		$this->set('menuList', $finalMenuList);

		$this->loadModel("Permissions");

		$permissions = $this->Permissions->find('list', [
                        'keyField' => 'id', 'valueField' => 'title' . $this->locale_pr
                    ])->toArray();
		$this->set('permissions', $permissions);
	}

}
