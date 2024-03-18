<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController ;

/**
 * CareerAssessmentsSurvey Controller
 *
 */

class CareerAssessmentsSurveyController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $careerAssessmentsSurvey = $this->paginate($this->CareerAssessmentsSurvey,['conditions'=>$conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('careerAssessmentsSurvey','parameters'));
    }

    public function add()
    {
        $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->newEmptyEntity();
        if ($this->request->is('post')) {
            $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->patchEntity($careerAssessmentsSurvey, $this->request->getData());
            if ($this->CareerAssessmentsSurvey->save($careerAssessmentsSurvey)) {
                $this->Flash->success(__('The Career Assessments Survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Career Assessments Survey could not be saved. Please, try again.'));
        }
         
        $this->set(compact('careerAssessmentsSurvey'));


    }

    public function edit($id = null)
    {
        $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->patchEntity($careerAssessmentsSurvey, $this->request->getData());
            if ($this->CareerAssessmentsSurvey->save($careerAssessmentsSurvey)) {
                $this->Flash->success(__('The Career Assessments Survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Career Assessments Survey could not be saved. Please, try again.'));
        }
        $this->set(compact('careerAssessmentsSurvey'));
        $this->render('add');

    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete','get']);
        $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->get($id);
        if ($this->CareerAssessmentsSurvey->delete($careerAssessmentsSurvey)) {
            $this->Flash->success(__('The Career Assessments Survey has been deleted.'));
        } else {
            $this->Flash->error(__('The Career Assessments Survey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');
        
        if(is_array($ids) ){
          $this->CareerAssessmentsSurvey->deleteAll(['id IN' => $ids]);
         $this->Flash->success(__('The CareerAssessmentsSurvey has been deleted.'));
        } else {
            $this->Flash->error(__('The CareerAssessmentsSurvey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
        
    }

    public function view($id = null)
    {
        $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->get($id);

        $this->set('careerAssessmentsSurvey', $careerAssessmentsSurvey);
    }


}
