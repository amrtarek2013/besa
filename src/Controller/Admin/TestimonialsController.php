<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Testimonials Controller
 *
 */

class TestimonialsController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $testimonials = $this->paginate($this->Testimonials, ['conditions' => $conditions, 'contain'=>['Countries'=>['fields'=>['country_name']]]]);
        // debug($testimonials);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('testimonials', 'parameters'));
    }

    public function add()
    {
        $testimonial = $this->Testimonials->newEmptyEntity();
        if ($this->request->is('post')) {
            $testimonial = $this->Testimonials->patchEntity($testimonial, $this->request->getData());
            if ($this->Testimonials->save($testimonial)) {
                $this->Flash->success(__('The Testimonial has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Testimonial could not be saved. Please, try again.'));
        }

        $this->_common();
        $this->_ajaxImageUpload('testimonial_new', 'testimonials', false, false, ['image', 'video_thumb']);
        $id = false;
        // $uploadSettings = $this->TestimonialBackgrounds->getUploadSettings();
        $this->set(compact('testimonial', 'id'));
    }

    public function edit($id = null)
    {
        // Configure::write('debug', true);
        $testimonial = $this->Testimonials->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $testimonial = $this->Testimonials->patchEntity($testimonial, $this->request->getData());
            if ($this->Testimonials->save($testimonial)) {
                $this->Flash->success(__('The Testimonial has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Testimonial could not be saved. Please, try again.'));
        }

        $this->_ajaxImageUpload('testimonial_' . $id, 'testimonials', $id, ['id' => $id], ['image', 'video_thumb']);
        // $uploadSettings = $this->TestimonialBackgrounds->getUploadSettings();

        $this->set(compact('testimonial', 'id'));
        $this->_common();

        $this->render('add');
    }

    private function _common()
    {

        $uploadSettings = $this->Testimonials->getUploadSettings();
        $this->set(compact('uploadSettings'));


        $this->loadModel("Countries");
        $countries = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(["active" => 1, 'is_destination' => 1])->order(['country_name' => 'ASC'])->toArray();
        $this->set("countries", $countries);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $testimonial = $this->Testimonials->get($id);
        if ($this->Testimonials->delete($testimonial)) {
            $this->Flash->success(__('The Testimonial has been deleted.'));
        } else {
            $this->Flash->error(__('The Testimonial could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Testimonials->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Testimonials has been deleted.'));
        } else {
            $this->Flash->error(__('The Testimonials could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $testimonial = $this->Testimonials->get($id);

        $this->set('testimonial', $testimonial);
    }
}
