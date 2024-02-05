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
            <?= $this->Form->select(
                $item["phrase"],
                $item["choices"],
                [
                    "empty" => "Select an option",
                    "required" => true
                ]
            ) ?>
        <?php endforeach; ?>
    </fieldset>
<?php endforeach; ?>

<?= $this->Form->button("Submit") ?>
<?= $this->Form->end() ?>
