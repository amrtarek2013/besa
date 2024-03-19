<style>
   

    h1 {
        text-align: center;
    
        font-weight: bold;
        margin-top: -120px;
        margin-bottom: 80px;
        font-size: 32px;
        color: var(--text-color);

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
.box-fieldset{
 
   
        width: 100%;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        background: #f9f9f9;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }



    .box-fieldset p {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
        padding: 8px 0;
    }

    .box-fieldset  p:before {
        content: "• ";
        color: var(--text-color);
    }
</style>

<h1>Career Assessment</h1>


<fieldset class="box-fieldset">
    <legend> Based on your interests and preferences, here are some career recommendations for you:</legend>
    <?php if (empty($careerAssessmentsSurvey->chatgpt_response))
        echo "Survey not completed";
    else
        echo $careerAssessmentsSurvey->chatgpt_response; ?>
</fieldset>