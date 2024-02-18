<style>


h1 {
    color: #263238;
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
    color: #263238;
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
width:100%
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
  color: #007bff;
  cursor: pointer;
  font-size:14px;
  margin:0
}

.skip:hover {
  text-decoration: underline;
  background: none;

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

<div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="assessment">
  <div class="question">
    <p class="question-number">Question 1 of 24</p>
    <h2>What will you get from the Subject Discovery Assessment?</h2>
    <div class="options">
      <button class="option" data-option="1"><span class="option-number">1</span>Begin your discovery journey</button>
      <button class="option" data-option="2"><span class="option-number">2</span>Begin your discovery journey</button>
      <button class="option" data-option="3"><span class="option-number">3</span>Begin your discovery journey</button>
      <button class="option" data-option="4"><span class="option-number">4</span>Begin your discovery journey</button>
      <button class="option" data-option="5"><span class="option-number">5</span>Begin your discovery journey</button>
    </div>
    <button class="skip">Skip Question</button>
  </div>
</div>
        </div>
    </div>
</div>


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






<script>
 document.querySelectorAll('.option').forEach(option => {
  option.addEventListener('click', function() {
    alert('Option selected: ' + this.getAttribute('data-option'));
    // Here you would handle the selection logic
  });
});

document.querySelector('.skip').addEventListener('click', function() {
  alert('Question skipped');
  // Here you would handle the skip logic
});


</script>