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

        $text = 'Based on your interests and preferences, here are some career recommendations for you:

            1. Data Analyst or Statistician: You enjoy analyzing data using statistics, so a career in data analysis or statistics could be a good fit for you.
            
            2. Substance Abuse Counselor: You have an interest in counseling people with drug or alcohol addiction, so a career in substance abuse counseling could be rewarding for you.
            
            3. Film Producer or Director: You are interested in directing the making of a movie and entertaining an audience, so a career in film production or directing could be a great match for you.
            
            4. Financial Analyst or Investment Manager: Given your interest in finance, critical thinking, and decision-making, a career in financial analysis or investment management could be a good fit for you.
            
            5. Environmental Engineer or Conservationist: With your interest in investigating causes of climate change and nature and agriculture, a career in environmental engineering or conservation could be fulfilling for you.
            
            These are just a few options based on your interests and preferences. It\'s important to further research these careers and consider your skills and strengths to make an informed decision.';
    }
    public function processedText($text)
    {
        // Split the text into lines
        $lines = explode("\n", $text);

        // Initialize an array to hold the processed lines
        $processedLines = [];

        // Iterate through each line
        foreach ($lines as $line) {
            // Trim whitespace
            $trimmedLine = trim($line);

            // Skip empty lines
            if (empty($trimmedLine)) continue;

            // Check if the line starts with a number followed by a period (e.g., "1.")
            if (preg_match('/^\d+\./', $trimmedLine)) {
                // Wrap the line in <h1> tags
                $processedLines[] = "<p>$trimmedLine</p>";
            }
        }

        // Combine the processed lines back into a single string
        $processedText =   implode("\n", $processedLines);

        // Print the processed text
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

        $response = $this->processedText($response);
        $this->request->getSession()->write("results", $response);

        return $this->redirect([
            "controller" => "CareerAssessments",
            "action" => "results",
        ]);
    }
}
