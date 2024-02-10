<style>
    /* Base styles */
    body {
        background-color: #f4f4f4;
        color: #333;
    }

    h1 {
        color: #333;
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
        border-radius: 5px;
        background: white;
        width: 65%;
        margin: 0 auto 40px;
    }

    legend {
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }

    p {
        margin: 20px 0 15px;
        font-size: 18px;

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
        outline: 2px dashed #5cb85c;
        outline-offset: 4px;
    }
</style>

<h1>Career Assessment</h1>


<fieldset>
    <legend> Based on your interests and preferences, here are some career recommendations for you:</legend>
    <?php

    echo $response;

    ?>
</fieldset>