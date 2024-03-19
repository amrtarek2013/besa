<style>
    h1 {
        color: #263238;
        text-align: center;
        font-size: 48px;
        margin: 30px 0;
        font-weight: bold;

    }

    label {
        margin: 0 15px;
        font-size: 16px;

    }

    fieldset {
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        background: white;
        width: 65%;
        margin: 0 auto 40px;
    }

    legend {
        font-size: 28px;
        font-weight: bold;
        color: #263238;
    }

    

    /* Styling the radio buttons and the labels */
    input[type="radio"] {
        margin-right: 5px;
    }

    /* Enhancing the look of the button */
    button,
    input[type="submit"] {
        background-color: #5cb85c;
        /* Green */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        margin: 0 auto 50px;
        display: block;
    }

    button:hover,
    input[type="submit"]:hover {
        background-color: #449d44;
        /* Darker green */
    }

    /* Adding some space between form elements */
    br {
        clear: both;
        margin-bottom: 10px;
    }

    /* Additional styles for responsiveness and accessibility */
    @media (max-width: 600px) {
        h1 {
            font-size: 28px
        }

        body {
            margin: 10px;
        }

        fieldset {
            padding: 10px;
            width: 90%;
        }

        label {
            display: block;
        }
    }

    :focus {
        outline: 2px dashed var(--text-color);

        outline-offset: 4px;
    }


    .assessment {
        margin: 100px 0 0;
    }

    .question-number {
        font-size: 20px;
        color: #546E7A;
        font-weight: 400;
    }

    h2 {
        color: #263238;
        font-size: 20px;
        font-weight: 600;

    }

    .options {
        margin: 20px 0;
    }

    .option {
        font-size: 16px;
        height: 56px;
        display: flex;
        padding: 10px;
        text-align: left;
        border: 1px solid #CFD8DC;
        cursor: pointer;
        position: relative;
        color: #263238;
        background: transparent;
        padding-left: 45px;
        align-items: center;
        max-width: 500px;
        margin: 0 0 20px 0;
        width: 100%
    }

    .option-number {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        line-height: 20px;
        text-align: center;
        background: transparent;
        border-radius: 6px;
        color: #263238;
        border: 1px solid #000000;
        display: flex;
        align-items: center;
        justify-content: center;

        font-weight: 600;
        font-size: 14px;


    }

    .option:hover {
        background: #e7e7e7;
    }

    .skip {
        display: block;
        background: none;
        border: none;
        color: var(--text-color);
        cursor: pointer;
        font-size: 14px;
        margin: 0
    }

    .skip:hover {
        text-decoration: underline;
        background: none;

    }

    /** container-confirmation */
    .container-confirmation {}

    .search-confirmation {
        text-align: center;

    }



    .confirmation-text {
        margin-top: 20px;
        margin-bottom: 20px;
        font-size: 20px;
        color: #263238;
        font-weight: 400;
        line-height: 30px;
    }

    .buttons .btn-confirmation {
        background-color: #F7F7F7;
        padding: 10px 20px;
        border-radius: 8px;
        margin: 5px auto;
        cursor: pointer;
        color: #263238;
        outline: none;
        font-size: 28px;
        font-weight: 600;
        height: 64px;
        max-width: 340px;
        width: 100%;
        border-radius: 12px;

    }



    .explore {
        background: linear-gradient(107deg, #0B4C97 6.38%, #68B8E8 147.19%);
        color: #fff;
        margin-top: 50px;
        height: 56px;
        font-size: 16px;
        font-weight: 600;
        max-width: 340px;
        width: 100%;
        border-radius: 12px;

    }
</style>


            <h1>Career Assessment</h1>

            <div class="assessment">
                <p class="question-number" id="question-number">Question 1 of 24</p>

                <div class="question">
                    <h4 id='question-clause'>question-clause</h4>

                    <h2 id='question-head'>question-head</h2>
                    <div class="options" id="choices-content">
                        <button class="option" data-option="1"> <span class="option-number ">1</span> Begin your discovery journey</button>
                    </div>
                    <button class="skip" id="next">Skip Question</button>
                </div>
            </div>



<?php

$questions = [];
// $careerAssessmentsQuestions = $careerAssessmentsQuestions->toArray();


foreach ($careerAssessmentsQuestions as &$item) {



    // unset($item['clause_id']);
    unset($item['choices_id']);
    $item['choices'] = json_decode($item["choices"], true);



    // if (!isset($questions[$clause])) {
    //     $questions[$clause] = [];
    // }

    // $questions[$clause][] = [
    //     "phrase" => $item["phrase"],
    //     "choices" => json_decode($item["choices"], true)
    // ];
}

// $i = 0;
// foreach ($questions as $clause => $items) {
//     if ($i == 1 || $i == 3 || $i == 7) {
//         $itemsToRemove = sizeof($items) * ($i != 7 ? 0.98 : 0.66);
//         for ($j = 0; $j < $itemsToRemove; $j++) {
//             $randomIndex = array_rand($items);
//             unset($items[$randomIndex]);
//         }
//         $questions[$clause] = $items;
//     }
//     $i++;
// }

?>
<script>
    var all_questions = <?php echo json_encode($careerAssessmentsQuestions); ?>;
    var currentQuestionIndex = <?php echo (int) $careerAssessmentsSurvey->current_answer ?>;

    function updateCounter(index) {

        $('#question-number').text('Question ' + (index + 1) + ' of ' + all_questions.length);
    }

    function showQuestion(index) {
        var question = all_questions[index];
        updateCounter(index);
        // $('#question-head').html(`${question.clause} ${question.phrase} ${question.id}?`);
        $('#question-clause').html(`${question.clause}`);
        $('#question-head').html(`${question.phrase}?`);


        $('#choices-content').empty();

        $('#choices-content').slideUp();
        question.choices.forEach(function(choice, i) {
            var choice_str = `<button class="option" data-option="${i}" data-answer="${choice}" data-qid="${question.id}" data-qindex="${index}"> <span class="option-number ">${i+1}</span> ${choice}</button>`;
            $('#choices-content').append(choice_str);
        });
        $('#choices-content').slideDown();
    }
    $(document).ready(function() {



        $(document).on('click', '#choices li', function() {
            all_questions[currentQuestionIndex].userChoice = $(this).data('index');
            $(this).siblings().removeClass('selected');
            $(this).addClass('selected');
        });

        $('#next').click(function() {
            if (currentQuestionIndex < all_questions.length - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
            } else {
                alert('You have completed the questionnaire!');
                // Here you could also handle the completion, like sending the answers to a server or showing a summary of the answers.
            }
        });

        showQuestion(currentQuestionIndex);
    });


    $(document).on('click', '#choices-content .option', function() {
        var choiceText = $(this).text(); // Get the text of the clicked choice
        console.log($(this));

        // data-option="${i}" data-answer="${choice}" data-qid="${question.id}" data-qindex="${question.index}"
        var quid = $(this).data('qid');
        var qindex = $(this).data('qindex') + 1;
        var qanswer = $(this).data('option');
        var qanswer_txt = $(this).data('answer');
        var survey_id = '<?php echo $careerAssessmentsSurvey->id ?>';


        // alert("You selected: " + choiceText); // Show an alert with the choice text

        var asnwer_url = `<?= Cake\Routing\Router::url('/') ?>user/career-assessments/answer/${survey_id}/${quid}/${qanswer}/${qanswer_txt}/${qindex}/${all_questions.length}`;

        $.ajax({
            url: asnwer_url,
            method: "get",
            data: {},
            success: function(result) {

                console.log(result);

                result = JSON.parse(result);

                if (currentQuestionIndex < all_questions.length - 1) {
                    currentQuestionIndex++;
                    showQuestion(currentQuestionIndex);
                } else {

                     window.location.href = `<?= Cake\Routing\Router::url('/') ?>user/career-assessments/view/${survey_id}`;
                    // Here you could also handle the completion, like sending the answers to a server or showing a summary of the answers.
                }


            }
        });






    });


    document.querySelectorAll('.option').forEach(option => {
        option.addEventListener('click', function() {
            alert('Option selected: ' + this.getAttribute('data-option'));
            // Here you would handle the selection logic
        });
    });

    document.querySelector('.skip').addEventListener('click', function() {
        // alert('Question skipped');
        // Here you would handle the skip logic
    });
</script>