<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Countries Controller
 *
 */

class CountriesController extends AppController
{

    public function index()
    {
        $conditions = $this->_filter_params();

        $countries = $this->paginate($this->Countries, ['conditions' => $conditions, 'order' => ['country_name' => 'ASC']]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Countries->continents;
        $this->set(compact('countries', 'parameters', 'continents'));
    }
    public function list()
    {
        $conditions = $this->_filter_params();
        $countries = $this->paginate($this->Countries, ['conditions' => $conditions]);
        $parameters = $this->request->getAttribute('params');
        $continents = $this->Countries->continents;
        $this->set(compact('countries', 'parameters', 'continents'));
    }

    public function add()
    {
        $country = $this->Countries->newEmptyEntity();
        if ($this->request->is('post')) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('The Country has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Country could not be saved. Please, try again.'));
        }
        $this->_ajaxImageUpload('country_new', 'countries', false, false, ['image_why_study', 'image', 'flag', 'banner_image']);
        $this->set('id', false);

        $this->__common();
        $continents = $this->Countries->continents;
        $this->set(compact('country', 'continents'));
    }

    public function edit($id = null)
    {
        $country = $this->Countries->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());


            if ($this->Countries->save($country)) {
                $this->Flash->success(__('The Country has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Country could not be saved. Please, try again.'));
        }

        $this->__common();

        $continents = $this->Countries->continents;
        // debug(strlen($country['top_text']));
        if (strlen($country['why_text']) == 0)
            $country->top_text = '<ul>
            <li>World-class education system with internationally recognised qualifications.</li>
            <li>Multicultural society promotes cross-cultural understanding.</li>
            <li>Safe and peaceful environment.</li>
            <li>Extensive support services for international students.</li>
            <li>Work opportunities on or off-campus during studies.</li>
            <li>Post-Graduation Work Permit and pathways to permanent residency.</li>
            <li>High standard of living amidst stunning natural landscapes.</li>
            <li>Cutting-edge research opportunities in universities.</li>
            <li>Global networking possibilities for students in Canada.</li>
        </ul>
        ';
        if (strlen($country['top_text']) == 0)
            $country->top_text = '<div class="study-section">
            <div class="container">
            <div class="row">
            <div class="col-md-12">
            <div class="d-flex work-life-info">
            <div class="image-container"><img alt="Student celebrating graduation" class="graduation-image" loading="lazy" src="/webroot/filebrowser/upload/images/ottawa-parliament-hill-building%201%20%281%29.png" /></div>
            
            <div class="text-container">
            <h4>WORK LIFE</h4>
            
            <p>Students can work on and off-campus while studying, with on-campus jobs conveniently available within the university or college. Off-campus work permits allow them to work up to 20 hours per week during regular academic sessions and full-time during breaks. Co-op and internship programs offer practical work experience, enhancing employability.</p>
            
            <p>After graduation, students may be eligible for a Post-Graduation Work Permit (PGWP), allowing them to work in Canada and gain valuable Canadian work experience for up to three years.</p>
            </div>
            </div>
            
            <div class="d-flex study-duration-info">
            <div class="text-container">
            <h4>STUDY LENGTH IN CANADA</h4>
            
            <p>The study length for international students varies based on the level of education. Bachelor&#39;s degrees typically take 3 to 4 years, master&#39;s degrees require 1 to 2 years, and doctoral programs generally last 4 to 6 years. However, the actual duration may depend on the specific program and the student&#39;s progress.</p>
            </div>
            
            <div class="image-container"><img alt="Academic institution in Canada" class="academic-image" loading="lazy" src="/webroot/filebrowser/upload/images/beautiful-shot-boats-parked-near-coal-harbour-vancouver%201.png" /></div>
            </div>
            
            <div class="d-flex explore-culture-info">
            <div class="image-container"><img alt="Canadian cultural elements" class="culture-image" loading="lazy" src="/webroot/filebrowser/upload/images/beautiful-shot-boats-parked-near-coal-harbour-vancouver%201%20%281%29.png" /></div>
            
            <div class="text-container">
            <h4>EXPLORE A VIBRANT LIFE &amp; CULTURE</h4>
            
            <p>Canada provides international students with a vibrant and diverse cultural experience. The country&#39;s inclusive environment offers various cultural events and festivals to participate in. Thriving cities with vibrant art, music, and entertainment scenes,</p>
            
            <p>coupled with breathtaking natural landscapes, create a balanced and exciting lifestyle. Canadians&#39; friendly and welcoming nature makes it easy for international students to make friends and form connections.</p>
            </div>
            </div>
            <a class="btn MainBtn explore-now" href="#" style="width: max-content;margin: 0 auto 20px;">Explore Studying in canda <img alt="" src="/webroot/filebrowser/upload/images/arrow%20right.svg" style="width: 24px; height: 24px;    margin-left: 5px;" /></a></div>
            </div>
            </div>
            </div>
            
            <div class="tuition-section">
            <div class="container">
            <div class="row">
            <div class="col-md-12">
            <div class="text-container">
            <h2 class="title">What is the average tuition fee for international students studying in Canada?</h2>
            
            <p>Students can work on and off-campus while studying, with on-campus jobs conveniently available within the university or college. Off-campus work permits allow them to work up to 20 hours per week during regular academic sessions and full-time during breaks.</p>
            
            <p>Co-op and internship programs offer practical work experience, enhancing employability. After graduation, students may be eligible for a Post-Graduation Work Permit (PGWP), allowing them to work in Canada and gain valuable Canadian work experience for up to three years.</p>
            </div>
            </div>
            </div>
            </div>
            </div>
            ';
        // debug($country);
        $this->set(compact('country', 'id', 'continents'));
        $this->_ajaxImageUpload('country_' . $id, 'countries', $id, ['id' => $id], ['image_why_study', 'image', 'flag', 'banner_image']);
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $country = $this->Countries->get($id);
        if ($this->Countries->delete($country)) {
            $this->Flash->success(__('The Country has been deleted.'));
        } else {
            $this->Flash->error(__('The Country could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');

        if (is_array($ids)) {
            $this->Countries->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The Countries has been deleted.'));
        } else {
            $this->Flash->error(__('The Countries could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = null)
    {
        $country = $this->Countries->get($id);

        $this->set('country', $country);
    }

    private function __common()
    {
        $uploadSettings = $this->Countries->getUploadSettings();
        $this->set(compact('uploadSettings'));
    }
}
