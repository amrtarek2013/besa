<link rel="stylesheet" href="/intl-tel-input/css/intlTelInput.css" />
<script src="/intl-tel-input/js/intlTelInput.min.js"></script>
<style>
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
        'class' => 'country_code mobile_code', 'label' => false, 'required' => true,
        'type' => 'select',
    ]) ?>
</div>

<script>
    var input = document.querySelector(".mobile_code");
    window.intlTelInput(input, {
        // show dial codes too
        separateDialCode: true,
        // If there are some countries you want to show on the top.
        // here we are promoting russia and singapore.
        preferredCountries: ["eg", "gbp", "us"],
        //Default country
        initialCountry: "eg",
        // show only these countres, remove all other
        // onlyCountries: ["ru", "cn", "pk", "sg", "my", "bd"],
        // If there are some countries you want to execlde.
        // here we are exluding india and israel.
        // excludeCountries: ["in", "il"]
    });
</script>