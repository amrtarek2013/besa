<?php

declare (strict_types = 1);

namespace App\Controller;

/**
 * TempFiles Controller
 *
 */

class TempFilesController extends AppController {

	protected $tempPath = WWW_ROOT . 'files/temp_files/';
	protected $filePath = WWW_ROOT . 'files/temp_files/';
	protected $imagePath = '/files/temp_files/';

	public function index() {

		$conditions = $this->_filter_params();

		$tempFiles = $this->paginate($this->TempFiles, ['conditions' => $conditions]);
		$parameters = $this->request->getAttribute('params');
		$this->set(compact('tempFiles', 'parameters'));
	}

	public function add() {
		$tempFile = $this->TempFiles->newEmptyEntity();
		if ($this->request->is('post')) {
			$tempFile = $this->TempFiles->patchEntity($tempFile, $this->request->getData());
			if ($this->TempFiles->save($tempFile)) {
				$this->Flash->success(__('The Temp File has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The Temp File could not be saved. Please, try again.'));
		}

		$this->set(compact('tempFile'));
	}

	public function edit($id = null) {
		$tempFile = $this->TempFiles->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$tempFile = $this->TempFiles->patchEntity($tempFile, $this->request->getData());
			if ($this->TempFiles->save($tempFile)) {
				$this->Flash->success(__('The Temp File has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The Temp File could not be saved. Please, try again.'));
		}
		$this->set(compact('tempFile'));
		$this->render('add');
	}

	public function delete($id = null) {

		$token = $this->__checktoken();

		$tempFile = $this->TempFiles->findByHash($token)->first();
		debug($tempFile);die;

		if ($this->TempFiles->delete($tempFile)) {
			die(json_encode(array('success' => true, "id" => $tempFile->id, "qquuid" => $tempFile->id, "newUuid" => $token, 'hash' => $token, 'uuid' => $token)));
		} else {
			die(json_encode(array('success' => false, 'error' => implode('<br/>', $error))));
		}
	}

	public function mainDelete($id = null) {

		$token = $this->__checktoken();

		$tempFile = $this->TempFiles->findByHash($token)->first();
		debug($id);die;

		if ($this->TempFiles->delete($tempFile)) {
			die(json_encode(array('success' => true, "id" => $tempFile->id, "qquuid" => $tempFile->id, "newUuid" => $token, 'hash' => $token, 'uuid' => $token)));
		} else {
			die(json_encode(array('success' => false, 'error' => implode('<br/>', $error))));
		}
	}

	public function delete2($id = null) {

		$token = $this->__checkCarImagetoken();

		$tempFile = $this->TempFiles->findByHash($id)->first();

		if ($this->TempFiles->delete($tempFile)) {
			die(json_encode(array('success' => true, "id" => $tempFile->id, "qquuid" => $tempFile->id, "newUuid" => $token, 'hash' => $token, 'uuid' => $token)));
		} else {
			die(json_encode(array('success' => false, 'error' => implode('<br/>', $error))));
		}
	}

	public function deleteMulti() {
		$this->request->allowMethod(['post', 'delete']);

		$ids = $this->request->getData('ids');

		if (is_array($ids)) {
			$this->TempFiles->deleteAll(['id IN' => $ids]);
			$this->Flash->success(__('The TempFiles has been deleted.'));
		} else {
			$this->Flash->error(__('The TempFiles could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	public function view($id = null) {
		$tempFile = $this->TempFiles->get($id);

		$this->set('tempFile', $tempFile);
	}

	function upload($count = 1) {
		$this->autoRender = false;
		$tempFile = $this->TempFiles->newEmptyEntity();
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			// dd($data);
			$files = $this->request->getUploadedFiles();
			foreach ($files as $field => $file) {
				$hash = md5(rand() . uniqid() . rand());

				if (!file_exists($this->tempPath)) {
					mkdir($this->tempPath, 0777, true);
				}
				if (file_exists($this->tempPath . $file->getClientFilename())) {
					unlink($this->tempPath . $file->getClientFilename());
				}
				$file->moveTo($this->tempPath . $file->getClientFilename());
				$tempFile->{$field} = array(
					'name' => $file->getClientFilename(),
					'tmp_name' => $this->tempPath . $file->getClientFilename(),
					'size' => $file->getSize(),
					'type' => 'application/octet-stream',
					'error' => 0,
				);

				$tempFile->name = $file->getClientFilename();

				$tempFile->hash = $hash;
				$tempFile->field_name = $field;
				$tempFile->behavior = $field;
				$tempFile->uploaded_for = "{$this->request->getParam('controller')}.$field";
				// debug($tempFile);die;

				if ($this->TempFiles->save($tempFile)) {
					die(json_encode(array('success' => true, "id" => $tempFile->id, "qquuid" => $tempFile->id, "newUuid" => $hash, 'hash' => $hash, 'uuid' => $hash)));
				} else {
					die(json_encode(array('success' => false, 'error' => implode('<br/>', $error))));
				}
			}


		}

		$this->set(compact('tempFile'));
	}




	function sort() {

		$this->TempFiles->sort = true;

		$data = $this->request->getData();
		if (!empty($data)) {
			foreach ($data as $id => $value) {
				$tempId = (int) $id;
				if ($tempId) {
					$tempFile = $this->TempFiles->get($id);
					$tempFile->display_order = $value;
					$this->TempFiles->save($tempFile);
				}
			}
		}

		die;
	}

	function initial() {
		$token = $this->__checktoken();
		$f = $this->TempFiles->find()->where(array("temp_token" => $token));
		if (isset($_GET["inputName"])) {
			$f->where(array("field_name" => $_GET["inputName"]));
		}

		$f = $f->order(array("display_order" => 'asc'))->all();
		$arr = array();

		if ($f->count()) {
			foreach ($f as $key => $value) {
				if (empty($value->id) || empty($value->name)) {
					continue;
				}

				$tmp["name"] = $value->name;
				$tmp["id"] = $value->id;
				$tmp["uuid"] = $value->hash;
				$tmp["thumbnailUrl"] = $this->imagePath . $value->name;
				$arr[] = $tmp;
			}
		}

		// debug($arr);die;
		echo json_encode($arr);

		die;
	}

	function initial2() {
		$token = $this->__checkCarImagetoken();

		$f = $this->TempFiles->find()->where(array("car_image_token" => $token))->order(array("display_order" => 'asc'))->all();
		$arr = array();
		if ($f->count()) {
			foreach ($f as $key => $value) {
				if (empty($value->id) || empty($value->name)) {
					continue;
				}

				$tmp["name"] = $value->id;
				$tmp["id"] = $value->id;
				$tmp["uuid"] = $value->hash;
				$tmp["thumbnailUrl"] = $this->imagePath . $value->name;
				$arr[] = $tmp;
			}
		}

		echo json_encode($arr);
		die;
	}
	function __checktoken($sessionKey = 'temp_token') {
		$token = $_GET["token"];

		if (isset($_GET["sessionKey"])) {
			$sessionKey = $_GET["sessionKey"] . '_token';
		}
		if (strpos($token, "car_ad_id")) {
			$arr = explode("car_ad_id", $token);
			$this->set("token", $arr[1]);
			return $arr[1];
		}

		$token_seesion = $this->Session->read($sessionKey);

		if (empty($token_seesion)) {
			die;
		}
		$this->set("token", $token);
		return $token;
	}

	function __checkCarImagetoken() {
		$token = $_GET["token"];
		if (strpos($token, "car_image")) {

			$arr = explode("car_image", $token);

			$this->set("token", $arr[1]);
			return $arr[1];
		}
		$token_seesion = $this->Session->read("car_image_token");

		if (empty($token_seesion)) {
			die;
		}
		$this->set("token", $token);
		return $token;
	}

	function _upload() {
		$token = $this->__checktoken();
		//Configure::write('debug', 0);
		if (!empty($this->data) || $_SERVER['REQUEST_METHOD'] === 'POST') {

			$modelname = !empty($this->data) ? array_keys($this->data) : array_keys($this->params->query['data']); //preg_replace("/data\[(.*?)\]\[.*?\].*/", '\1', $inputName  );;

			$modelname = "Car";
			($modelname);
			$ImageResizeOptions = array();
			$resizeIndex = $_REQUEST['resizeIndex'];
			if (!empty($resizeIndex) && $modelname == "GalleryImage") {
				//$ImageResizeOptions = $modelname::$ResizesOptions;
				$ImageResizeOptions = array(
					'image' => array(
						PHOTO_GALLERY => array('resize' => true, 'create_thumbs' => false, 'aspect_required' => true, 'width' => 500, 'height' => 500),
						BANNER_GALLERY => array('resize' => false, 'create_thumbs' => false, 'aspect_required' => true, 'width' => 850, 'height' => 250),
						PAGECONTENT_GALLERY => array('resize' => false, 'create_thumbs' => false, 'aspect_required' => true, 'width' => 650, 'height' => 250),
						SIDEBAR_GALLERY => array('resize' => false, 'create_thumbs' => false, 'aspect_required' => true, 'width' => 120, 'height' => 120),
						MOBILE_GALLERY => array('resize' => false, 'create_thumbs' => false, 'aspect_required' => true, 'width' => 960, 'height' => 350),
					),
				);
			}

			$allowedmodels = $this->TempFile->allowedModels;
			$targetbehaviors = $this->TempFile->targetBehaviors;

			$targetbehaviors = array_combine($targetbehaviors, $targetbehaviors);

			//            $foundbehaviors = array_intersect($targetbehaviors, array_keys($this->{$modelname}->actsAs));

			$validmodel = in_array($modelname, $allowedmodels);
			//            if (!$validmodel || empty($foundbehaviors)) {
			//                // die(json_encode(array('success' => false, 'error' => 'Permission denied, (hint: check allowed Models)')));
			//            }
			$filtered_behaviors = array_intersect_key($this->{$modelname}->actsAs, $targetbehaviors);

			foreach ($filtered_behaviors as $behavior => &$options) {
				if (!empty($options)) {
					foreach ($options as $fkey => &$option) {
						if (!empty($ImageResizeOptions) && !empty($resizeIndex)) {
							$option = array_merge($option, $ImageResizeOptions[$fkey][$resizeIndex]);
						}
						$option['folder'] = $this->TempFile->folder;
					}
				} else {
					$options = array(stripos($behavior, 'image') !== false ? 'image' : 'file' => array('folder' => $this->TempFile->folder));
				}

			}
			//debug($filtered_behaviors);

			foreach ($filtered_behaviors as $bhv => $opts) {
				if (!empty($bhv)) {
					$this->TempFile->Behaviors->attach($bhv, $opts);
				}
			}

			$error = array();
			$hash = md5(rand() . uniqid() . rand());

			if (!isset($_SERVER['CONTENT_TYPE'])) { //
				; // do nothing
			} else if (strpos(strtolower($_SERVER['CONTENT_TYPE']), 'multipart/') === 0) {
				// hidden iframe form submission
				foreach ($this->data[$modelname] as $i => $file) {

					if (!$this->TempFile->save(array('TempFile' => array($i => $file, "temp_token" => $token, 'hash' => $hash, 'behavior' => $behavior, 'uploaded_for' => "$modelname.$i")))) {
						$error[] = reset($this->TempFile->validationErrors);
					}
				}
			} else {
				// ajax upload
				$input = fopen("php://input", "r");
				Configure::write('debug', 0);
				debug($input);
				die;
				$temp = tmpfile();
				$realSize = stream_copy_to_stream($input, $temp);
				fclose($input);

				$meta_data = stream_get_meta_data($temp);

				$tmp_name = $meta_data["uri"];

				$field = array_keys($this->params->query['data'][$modelname]);
				$field = reset($field);

				$behavior = $this->_getFieldBehavior($filtered_behaviors, $field);

				$this->data = array('TempFile' => array(
					$field => array(
						'name' => $this->params->query['data'][$modelname][$field],
						'tmp_name' => $tmp_name,
						'size' => filesize($tmp_name),
						'type' => 'application/octet-stream',
						'error' => 0,
					),
					'hash' => $hash,
					'behavior' => $behavior,
					'uploaded_for' => "$modelname.$field",
				));

				if (!$behavior) {
					$error[] = 'Permission Denied';
				} elseif (!$this->TempFile->save($this->data)) {
					$error[] = reset($this->TempFile->validationErrors);
				}
			}
			header('Content-Type: text/plain'); // respond as text/plain so ie can parse json correctly

			if (empty($error)) {
				//  $this->flashMessage('Success');
				die(json_encode(array('success' => true, "id" => $this->TempFile->id, "qquuid" => $this->TempFile->id, "newUuid" => $hash, 'hash' => $hash)));
			} else {
				//   $this->flashMessage(count($error) . 'Error(s) occured <br/>' . implode('<br/>', ($error)));
				die(json_encode(array('success' => false, 'error' => implode('<br/>', $error))));
			}
		}
		die("here");
		//        $this->redirect(array('action' => 'index'));
	}

	public function ajaxFiles($fieldName = '') {

		$this->autoRender = false;
		if (!file_exists($this->filePath)) {
			mkdir($this->filePath, 0775, true);
		}

		$tempFile = $_FILES[$fieldName]['tmp_name'];
		$targetPath = $this->filePath;
		$targetFile = rtrim($targetPath, '/') . '/' . $_FILES[$fieldName]['name'];

		// Validate the file type
		$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'mp4'); // File extensions
		$fileParts = pathinfo($_FILES[$fieldName]['name']);
		$response = array();
		if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
			move_uploaded_file($tempFile, $targetFile);
			$response['success'] = 1;
			foreach ($_POST as $key => $value) {
				$response[$key] = $value;
			}
			echo json_encode($response);
		} else {
			$response['success'] = 0;
			$response['error'] = 'Invalid file type.';
			echo json_encode($response);
		}
	}
}
