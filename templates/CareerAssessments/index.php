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
label{
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
    margin: 0  auto 40px;
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


.assessment {
  font-family: 'Arial', sans-serif;
  max-width: 600px;
  margin: auto;
}

.question-number {
  font-size: 0.9em;
  color: #666;
}

h2 {
  color: #333;
  font-size: 1.2em;
}

.options {
  margin: 20px 0;
}

.option {
  display: block;
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  text-align: left;
  background: #f7f7f7;
  border: 1px solid #ddd;
  color: #333;
  cursor: pointer;
}

.option:hover {
  background: #e7e7e7;
}

.skip {
  display: block;
  background: none;
  border: none;
  color: #007bff;
  cursor: pointer;
}

.skip:hover {
  text-decoration: underline;
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



<div class="assessment">
  <div class="question">
    <p class="question-number">Question 1 of 24</p>
    <h2>What will you get from the Subject Discovery Assessment?</h2>
    <div class="options">
      <button class="option">Begin your discovery journey</button>
      <button class="option">Begin your discovery journey</button>
      <button class="option">Begin your discovery journey</button>
      <button class="option">Begin your discovery journey</button>
      <button class="option">Begin your discovery journey</button>
    </div>
    <button class="skip">Skip Question</button>
  </div>
</div>


<script>
    document.querySelectorAll('.option').forEach(option => {
  option.addEventListener('click', function() {
    alert('Option selected: Begin your discovery journey');
    // Here you would handle the selection logic, e.g., save the response and go to the next question
  });
});

document.querySelector('.skip').addEventListener('click', function() {
  alert('Question skipped');
  // Here you would handle the skip logic, e.g., go to the next question
});

</script>