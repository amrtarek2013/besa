<style>
   

    h1 {
        color: #333;
        text-align: center;
        font-size: 48px;
    
        font-weight: bold;
        margin-top: -140px;
    margin-bottom: 80px;

    }

    label {
        margin: 0 15px;
        font-size: 16px;

    }

    fieldset {
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        background: white;
        width: 65%;
        margin: 0 auto 40px;
    }

    legend {
        font-size: 17px;
        font-weight: bold;
        color: #333;
    }

   

    /* Styling the radio buttons and the labels */
    input[type="radio"] {
        margin-right: 5px;
    }

    
 

    :focus {
        outline: 2px dashed #5cb85c;
        outline-offset: 4px;
    }
    @media (max-width: 768px) {
    h1 {
        font-size: 28px;
        margin-top: 0;

    }
    .assessment {
    margin: 0;
}
#question-head {
    margin-left: 0;
}
.options {
    margin: 20px 0 0 0;
}
    fieldset {
        padding: 10px;
        width: 90%;
    }

    label {
        display: block;
    }
}
</style>

<h1>Career Assessment</h1>


<fieldset>
    <legend> Based on your interests and preferences, here are some career recommendations for you:</legend>
    <?php if (empty($careerAssessmentsSurvey->chatgpt_response))
        echo "Survey not completed";
    else
        echo $careerAssessmentsSurvey->chatgpt_response; ?>
</fieldset>