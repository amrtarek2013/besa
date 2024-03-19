<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\AppController;

use Orhanerday\OpenAi\OpenAi;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;

class CareerAssessmentsController extends AppController
{
    public function index($survey_id = 0)
    {
        // $connection = ConnectionManager::get("default");
        // $query = "SELECT clause, phrase, choices FROM career_assessments_question_clauses AS A, career_assessments_question_phrases AS B, career_assessments_question_choices AS C WHERE A.id = B.clause_id AND C.id = B.choices_id;";
        // $data = $connection->execute($query)->fetchAll("assoc");
        $user = $this->Auth->user();
        $this->loadModel('CareerAssessmentsSurvey');



        $survey = $this->CareerAssessmentsSurvey->find()->where(['user_id' => $user['id'], 'id' => $survey_id, 'is_completed' => 0])->order(['id' => 'DESC'])->first();


        if (empty($survey)) {

            $survey_count = $this->CareerAssessmentsSurvey->find()->where(['user_id' => $user['id']])->count();

            $survey = $this->CareerAssessmentsSurvey->find()->where(['user_id' => $user['id']])->order(['id' => 'DESC'])->first();



            if (!empty($survey) && !$survey->is_completed) {
                $careerAssessmentsSurvey  = $survey;
            } elseif ($survey_count >= 2) {

                $this->Flash->error(__('You have exceeded number of trails.'));
                return $this->redirect(['action' => 'surveys']);
            } else {
                $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->newEmptyEntity();

                $careerAssessmentsSurvey->user_id = $user['id'];

                $this->CareerAssessmentsSurvey->save($careerAssessmentsSurvey);
            }
        } else {
            $careerAssessmentsSurvey  = $survey;
        }



        $this->loadModel('CareerAssessmentsQuestionPhrases');
        $careerAssessmentsQuestions = [];
        for ($clauseId = 1; $clauseId <= 8; $clauseId++) {
            $array2 = $this->CareerAssessmentsQuestionPhrases->find()->where(['clause_id' => $clauseId])->order('RAND()')->limit(5)->all();
            array_push($careerAssessmentsQuestions, ...$array2);
        }




        $this->set('careerAssessmentsQuestions', $careerAssessmentsQuestions);

        $this->set('careerAssessmentsSurvey', $careerAssessmentsSurvey);



        $this->set(compact("data"));
    }

    public function surveys()
    {
        // $query = "SELECT clause, phrase, choices FROM career_assessments_question_clauses AS A, career_assessments_question_phrases AS B, career_assessments_question_choices AS C WHERE A.id = B.clause_id AND C.id = B.choices_id;";
        // $data = $connection->execute($query)->fetchAll("assoc");

        $this->loadModel('CareerAssessmentsSurvey');

        $user = $this->Auth->user();
        $this->loadModel('CareerAssessmentsSurvey');
        $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->find()->where(['user_id' => $user['id']])->order(['id' => 'asc'])->limit(5)->all();
        $this->set('careerAssessmentsSurvey', $careerAssessmentsSurvey);
    }

    public function view($survey_id = 0)
    {
        // $connection = ConnectionManager::get("default");
        // $query = "SELECT clause, phrase, choices FROM career_assessments_question_clauses AS A, career_assessments_question_phrases AS B, career_assessments_question_choices AS C WHERE A.id = B.clause_id AND C.id = B.choices_id;";
        // $data = $connection->execute($query)->fetchAll("assoc");
        $user = $this->Auth->user();
        $this->loadModel('CareerAssessmentsSurvey');
        $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->find()->where(['user_id' => $user['id'], 'id' => $survey_id, 'is_completed' => 1])->first();

        $this->set('careerAssessmentsSurvey', $careerAssessmentsSurvey);
    }

    public function answer($survey_id = 0, $q_id = 0, $answer, $answer_txt, $q_index, $total_questions = 2000)
    {
        debug($total_questions);

        $user = $this->Auth->user();
        $this->loadModel('CareerAssessmentsSurvey');
        $this->loadModel('CareerAssessmentsAnswers');

        $survey = $this->CareerAssessmentsSurvey->find()->where(['user_id' => $user['id'], 'id' => $survey_id, 'is_completed' => 0])->order(['id' => 'DESC'])->first();
        debug($survey);
        if (empty($survey) || $q_id > 2000) {
            // $this->getChatGptResponse($survey);
            die(json_encode(array("status" => 0, "msg" => "Survey completed")));
        }

        $careerAssessmentsAnswer = $this->CareerAssessmentsAnswers->newEmptyEntity();


        $existAssessmentsAnswer = $this->CareerAssessmentsAnswers->find()->where([
            'career_assessments_survey_id' => $survey_id,
            'question_id' => $q_id,
            'user_id' => $user['id']
        ])->first();
        if ($existAssessmentsAnswer) {
            $careerAssessmentsAnswer->id = $existAssessmentsAnswer->id;
        }

        $careerAssessmentsAnswer->user_id = $user['id'];
        $careerAssessmentsAnswer->career_assessments_survey_id = $survey_id;
        $careerAssessmentsAnswer->question_id = $q_id;
        $careerAssessmentsAnswer->answer_txt = $answer_txt;
        $careerAssessmentsAnswer->answer = $answer;
        $this->CareerAssessmentsAnswers->save($careerAssessmentsAnswer);

        // Saving survey status
        $newData = ['current_answer' => $q_index];
        if ($q_index >= $total_questions) {
            $newData['is_completed'] = true;
            $newData['chatgpt_response'] =  $this->getChatGptResponse($survey);
        }
        $careerAssessmentsSurvey = $this->CareerAssessmentsSurvey->patchEntity($survey,  $newData);
        $this->CareerAssessmentsSurvey->save($careerAssessmentsSurvey);


        die(json_encode(array("status" => 1, "q" => $q_id, "answer" => $answer, $q_index,  $total_questions)));
    }
    function getChatGptResponse($survey)
    {



        $connection = ConnectionManager::get("default");
        $query = "SELECT phrase, answer FROM career_assessments_answers  , career_assessments_question_phrases    WHERE career_assessments_answers.question_id = career_assessments_question_phrases.id and career_assessments_answers.career_assessments_survey_id ={$survey->id};";
        $data = $connection->execute($query)->fetchAll("assoc");
        $data = Hash::combine($data, '{n}.phrase',   '{n}.answer');
        $data = json_encode($data);

        // die;

        // $data = json_encode($this->request->getData());

        // $careers = [
        //     "Software Engineer",
        //     "Doctor",
        //     "Teacher",
        //     "Graphic Designer",
        //     "Accountant",
        //     "Lawyer",
        //     "Electrician",
        //     "Chef",
        //     "Mechanic",
        //     "Nurse"
        // ];

        // $data .= "\n\nBased on these data, recommend top three careers for me out of this list: " . implode(',', $careers);

        $open_ai = new OpenAi(env("OPENAI_API_KEY"));
        $chat = $open_ai->chat([
            "model" => "gpt-3.5-turbo-1106",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are an AI career advisor. Please provide recommendations based on the user's interests and preferences."
                ],
                [
                    "role" => "user",
                    "content" => $data
                ],
            ],
            "temperature" => 0.5,
            "max_tokens" => 4000,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
        ]);

        $response = json_decode($chat)->choices[0]->message->content;
        $response = $this->processResponse($response);
        return  $response;
    }
    private function processResponse($text)
    {
        $lines = explode("\n", $text);

        $processedLines = [];

        foreach ($lines as $line) {
            $trimmedLine = trim($line);

            if (empty($trimmedLine))
                continue;

            if (preg_match('/^\d+\./', $trimmedLine)) {
                $processedLines[] = "<p>$trimmedLine</p>";
            }
        }

        $processedText = implode("\n", $processedLines);

        return $processedText;
    }


    public function results()
    {
        $response = $this->request->getSession()->read("results");
        $this->set(compact("response"));
    }

    public function submit()
    {
        $this->request->allowMethod(["post"]);

        $data = json_encode($this->request->getData());

        $careers = [
            "Software Engineer",
            "Doctor",
            "Teacher",
            "Graphic Designer",
            "Accountant",
            "Lawyer",
            "Electrician",
            "Chef",
            "Mechanic",
            "Nurse"
        ];

        $data .= "\n\nBased on these data, recommend top three careers for me out of this list: " . implode(',', $careers);

        $open_ai = new OpenAi(env("OPENAI_API_KEY"));
        $chat = $open_ai->chat([
            "model" => "gpt-3.5-turbo-1106",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are an AI career advisor. Please provide recommendations based on the user's interests and preferences."
                ],
                [
                    "role" => "user",
                    "content" => $data
                ],
            ],
            "temperature" => 0.5,
            "max_tokens" => 4000,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
        ]);

        $response = json_decode($chat)->choices[0]->message->content;
        $response = $this->processResponse($response);

        $this->request->getSession()->write("results", $response);

        return $this->redirect([
            "controller" => "CareerAssessments",
            "action" => "results",
        ]);
    }
}
