<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController ;

/**
 * CareerAssessmentsAnswers Controller
 *
 */

class CareerAssessmentsAnswersController extends AppController
{

    public function index()
    {

        $conditions = $this->_filter_params();

        $careerAssessmentsAnswers = $this->paginate($this->CareerAssessmentsAnswers,['conditions'=>$conditions]);
        $parameters = $this->request->getAttribute('params');
        $this->set(compact('careerAssessmentsAnswers','parameters'));
    }

    public function add()
    {
        $careerAssessmentsAnswer = $this->CareerAssessmentsAnswers->newEmptyEntity();
        if ($this->request->is('post')) {
            $careerAssessmentsAnswer = $this->CareerAssessmentsAnswers->patchEntity($careerAssessmentsAnswer, $this->request->getData());
            if ($this->CareerAssessmentsAnswers->save($careerAssessmentsAnswer)) {
                $this->Flash->success(__('The Career Assessments Answer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Career Assessments Answer could not be saved. Please, try again.'));
        }
         
        $this->set(compact('careerAssessmentsAnswer'));


    }

    public function edit($id = null)
    {
        $careerAssessmentsAnswer = $this->CareerAssessmentsAnswers->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $careerAssessmentsAnswer = $this->CareerAssessmentsAnswers->patchEntity($careerAssessmentsAnswer, $this->request->getData());
            if ($this->CareerAssessmentsAnswers->save($careerAssessmentsAnswer)) {
                $this->Flash->success(__('The Career Assessments Answer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Career Assessments Answer could not be saved. Please, try again.'));
        }
        $this->set(compact('careerAssessmentsAnswer'));
        $this->render('add');

    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete','get']);
        $careerAssessmentsAnswer = $this->CareerAssessmentsAnswers->get($id);
        if ($this->CareerAssessmentsAnswers->delete($careerAssessmentsAnswer)) {
            $this->Flash->success(__('The Career Assessments Answer has been deleted.'));
        } else {
            $this->Flash->error(__('The Career Assessments Answer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteMulti()
    {
        $this->request->allowMethod(['post', 'delete']);

        $ids = $this->request->getData('ids');
        
        if(is_array($ids) ){
          $this->CareerAssessmentsAnswers->deleteAll(['id IN' => $ids]);
         $this->Flash->success(__('The CareerAssessmentsAnswers has been deleted.'));
        } else {
            $this->Flash->error(__('The CareerAssessmentsAnswers could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
        
    }

    public function view($id = null)
    {
        $careerAssessmentsAnswer = $this->CareerAssessmentsAnswers->get($id);

        $this->set('careerAssessmentsAnswer', $careerAssessmentsAnswer);
    }


}
