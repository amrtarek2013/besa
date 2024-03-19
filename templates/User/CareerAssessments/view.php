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

 
    .box-fieldset {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    box-sizing: border-box;
    margin: 20px 0;
}

.box-fieldset legend {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    padding: 0 10px;
    border: none;
    width: auto;
}

.box-fieldset p {
    font-size: 16px;
    line-height: 1.5;
    color: #555;
    padding: 5px 0;
}

/* Adding a bit more style */
.box-fieldset p:first-of-type {
    margin-top: 0;
}

.box-fieldset p:last-child {
    margin-bottom: 0;
}

/* Custom styles for better visual hierarchy */
.box-fieldset {
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.box-fieldset legend {
    background-color: #eef;
    border-radius: 4px;
    color: #333;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
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