<?php

use Cake\Routing\Router;
?>
<link rel="stylesheet" href="<?= Router::url('/intlTelInput/css/intlTelInput.min.css?v=' . time()) ?>" />

<?php


$phone_code = isset($phone_code) ? $phone_code : 'mobile_code';
$phone_name = isset($phone_name) ? $phone_name : 'mobile';
$phone_label = isset($phone_label) ? $phone_label : 'Mobile';

$modileCodeId = 'mobile_code' . rand();
?>
<style>
    .mobile_code,
    #mobile-code,
    #phone-code {
        display: none !important;
    }
</style>
<div class="form-area ">
    <?= $this->Form->label($phone_name, $phone_label . '*') ?>
    <?= $this->Form->control($phone_name, [
        'type' => 'tel', 'placeholder' => $phone_label, 'label' => false, 'class' => 'form-control', 'required' => true
    ]) ?>
    <?= $this->Form->control($phone_code, [
        'class' => 'country_code mobile_code', 'label' => false,
        'type' => 'text', 
        'id' => $modileCodeId
    ]) ?>
</div>

<script src="<?= Router::url('/intlTelInput/js/intlTelInput.js?v=' . time()) ?>"></script>

<script src="<?= Router::url('/intlTelInput/js/utils.js?v=' . time()) ?>"></script>

<script>
    var input = document.querySelector("#" + "<?= $modileCodeId ?>");
    window.intlTelInput(input, {
        // show dial codes too
        separateDialCode: true,
        // If there are some countries you want to show on the top.
        // here we are promoting russia and singapore.
        preferredCountries: ["eg", "sd", "gb", "us"],
        //Default country
        // initialCountry: "eg",
        // show only these countres, remove all other
        // onlyCountries: ["ru", "cn", "pk", "sg", "my", "bd"],
        // If there are some countries you want to execlde.
        // here we are exluding india and israel.
        // excludeCountries: ["in", "il"]
    });
    $('.iti__country').on('click', function() {
        $("#" + "<?= $modileCodeId ?>").val($(this).data('dial-code'));
        console.log($(this).data('dial-code'));
    });
</script>