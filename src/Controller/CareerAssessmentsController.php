<?php

declare(strict_types=1);

namespace App\Controller;

use Orhanerday\OpenAi\OpenAi;
use Cake\Datasource\ConnectionManager;

class CareerAssessmentsController extends AppController
{
    public function index()
    {
        $connection = ConnectionManager::get("default");
        $query = "SELECT clause, phrase, choices FROM career_assessments_question_clauses AS A, career_assessments_question_phrases AS B, career_assessments_question_choices AS C WHERE A.id = B.clause_id AND C.id = B.choices_id;";
        $data = $connection->execute($query)->fetchAll("assoc");
        $this->set(compact("data"));
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
            "GoLang Software Engineer",
            "Crazy Doctor",
            "Chemistry Teacher",
            "Artistic Graphic Designer",
            "Evil Accountant",
            "Stupid Lawyer",
            "Lonely Electrician",
            "Fat Chef",
            "Virgin Mechanic",
            "Horney Nurse"
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
