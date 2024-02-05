<style>
    /* Base styles */
body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
}

h1 {
    color: #333;
    text-align: center;
    font-size: 48px;
    margin: 30px 0;

}
label{
    margin: 0 15px;

}

fieldset {
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    background: white;
    width: 65%;
    margin: 0  auto 40px;
}

legend {
    font-size: 1.2em;
    font-weight: bold;
    color: #333;
}

p {
    margin: 10px 0;
}

/* Styling the radio buttons and the labels */
input[type="radio"] {
    margin-right: 5px;
}

/* Enhancing the look of the button */
button, input[type="submit"] {
    background-color: #5cb85c; /* Green */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    margin: 0 auto 50px;
    display: block;
}

button:hover, input[type="submit"]:hover {
    background-color: #449d44; /* Darker green */
}

/* Adding some space between form elements */
br {
    clear: both;
    margin-bottom: 10px;
}

/* Additional styles for responsiveness and accessibility */
@media (max-width: 600px) {
    h1{
        font-size:28px
    }
    body {
        margin: 10px;
    }

    fieldset {
        padding: 10px;
        width: 90%;
    }
    label{
        display:block;
    }
}

:focus {
    outline: 2px dashed #5cb85c;
    outline-offset: 4px;
}

</style>
<?php

$questions = [];

foreach ($data as $item) {
    $clause = $item["clause"];

    if (!isset($questions[$clause])) {
        $questions[$clause] = [];
    }

    $questions[$clause][] = [
        "phrase" => $item["phrase"],
        "choices" => json_decode($item["choices"], true)
    ];
}

$i = 0;
foreach ($questions as $clause => $items) {
    if ($i == 1 || $i == 3 || $i == 7) {
        $itemsToRemove = sizeof($items) * ($i != 7 ? 0.98 : 0.66);
        for ($j = 0; $j < $itemsToRemove; $j++) {
            $randomIndex = array_rand($items);
            unset($items[$randomIndex]);
        }
        $questions[$clause] = $items;
    }
    $i++;
}

?>

<h1>Career Assessment</h1>

<?= $this->Form->create(null, ["url" => ["controller" => "CareerAssessments", "action" => "submit"]]) ?>

<?php foreach ($questions as $clause => $items) : ?>
    <fieldset>
        <legend><?= $clause ?></legend>
        <?php foreach ($items as $item) : ?>
            <p><?= $item["phrase"] ?></p>
            <?= $this->Form->radio(
                $item["phrase"],
                $item["choices"],
                ["required" => true]
            ) ?>
            <br /><br />
        <?php endforeach; ?>
    </fieldset>
<?php endforeach; ?>

<?= $this->Form->button("Submit") ?>
<?= $this->Form->end() ?>
