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
        'type' => 'tel', 'placeholder' => $phone_label, 'label' => false, 'class' => 'form-control', 'required' => true,
        'value' => (isset($mobileValue) ? $mobileValue : '')
    ]) ?>
    <?= $this->Form->control($phone_code, [
        'class' => 'country_code mobile_code', 'label' => false,
        'type' => 'text',
        'id' => $modileCodeId,
        // 'pattern' => "[0-9]{5}[-][0-9]{7}[-][0-9]{1}",
        'value' => (isset($mobileCodeValue) ? '+' . $mobileCodeValue : '')
    ]) ?>

</div>

<script src="<?= Router::url('/intlTelInput/js/intlTelInput.js?v=' . time()) ?>"></script>

<script src="<?= Router::url('/intlTelInput/js/utils.js?v=' . time()) ?>"></script>
<script src="<?= Router::url('/intlTelInput/js/data.js?v=' . time()) ?>"></script>

<script>
    var countriesCodes = <?= json_encode($countriesCodes) ?>;

    console.log(window.allCountriesDialCodes);
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
    $(document).ready(function() {

        $("#" + "<?= $modileCodeId ?>").val($('.iti__selected-dial-code').html().replace('+', ''));
        $('#country-id').on('change', function() {
            var codeid = $(this).val();
            if (codeid != '' && codeid != undefined) {
                countryCode = countriesCodes[codeid].toLowerCase();


                if (countryCode == 'the us')
                    countryCode = 'us';
                if (countryCode == 'uk')
                    countryCode = 'gb';
                
                var selectedCountry = '.iti__country[data-country-code="' + countryCode + '"]';

                $('.iti__selected-flag').html('<div class="iti__flag iti__' + countryCode + '"></div><div class="iti__selected-dial-code">+' + allCountriesDialCodes[countryCode] + '</div><div class="iti__arrow"></div>');
                
                // $('.iti__selected-dial-code').html($(selectedCountry + " .iti__dial-code").html());
                $("#" + "<?= $modileCodeId ?>").val(allCountriesDialCodes[countryCode]);
            }
        });
    });
    $('.iti__country').on('click', function() {

        $('.iti__selected-flag').html('<div class="iti__flag iti__' + $(this).data('country-code') + '"></div><div class="iti__selected-dial-code">+' + $(this).data('dial-code') + '</div><div class="iti__arrow"></div>');
        $("#" + "<?= $modileCodeId ?>").val($(this).data('dial-code'));

    });
</script>