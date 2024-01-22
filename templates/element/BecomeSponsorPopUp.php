<!-- Remodal HTML structure for sponsor form -->
<div class="remodal remodal-form  british-trophy-sponsor-modal" data-remodal-id="become-sponsor">
    <button data-remodal-action="close" class="remodal-close">
        <img src="<?= WEBSITE_URL ?>img/new-desgin/remodal-close.svg" alt="close remodal">

    </button>
    <h2>Become a sponsor</h2>

    <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'SponsorForm', 'class' => 'subscription-form')); ?>
    
    <input type="hidden" id="type" name="type" value="become-sponsor">
    <?= $this->Form->control('school_name', [
        'placeholder' => 'Institution Name', 'label' => 'Institution Name*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
    ]) ?>
    <?= $this->Form->control('school_counselor_name', [
        'placeholder' => 'Contact Person Name*', 'label' => 'Contact Person Name*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
    ]) ?>


    <?= $this->element('mobile_with_code') ?>
    <?= $this->Form->control('email', [
        'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
    ]) ?>

    <?= $this->element('security_code', ['show_label' => true]) ?>
    <!-- <form class="subscription-form"> -->
    <!-- <div class="form-area">
        <label for="institution-name">Institution Name</label>
        <input type="text" id="institution-name" placeholder="Enter Institution Name" required>
    </div>
    <div class="form-area">
        <label for="contact-person-name">Contact Person Name</label>
        <input type="text" id="contact-person-name" placeholder="Enter Contact Person Name" required>
    </div>
    <div class="form-area">
        <label for="phone-number">Phone number</label>
        <input type="tel" id="phone-number" placeholder="Your phone number" required>
    </div>
    <div class="form-area">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Enter your email" required>
    </div> -->
    <button type="submit" class="btn btn-primary btn-submit">Submit</button>
    <!-- </form> -->

    <?= $this->Form->end() ?>
</div>

<?php
/*
?>
 <div class="remodal removebg" data-remodal-id="become-sponsor" style="max-width: 1060px !important;">

    <section class="register-banner Create-account-banner">

        <div class="">
            <div class="row">

                <div class="col-md-12">


                    <button data-remodal-action="close" class="remodal-close"></button>
                    <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'SponsorForm', 'class' => 'register')); ?>

                    <input type="hidden" id="type" name="type" value="become-sponsor">
                    <div class="container-formBox">

                        <h4 class="title">Become a Sponsor</h4>

                        <div class="grid-container">

                            <?= $this->Form->control('school_name', [
                                'placeholder' => 'Institution Name', 'label' => 'Institution Name*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                            ]) ?>
                            <?= $this->Form->control('school_counselor_name', [
                                'placeholder' => 'Contact Person Name*', 'label' => 'Contact Person Name*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                            ]) ?>


                            <?= $this->element('mobile_with_code') ?>
                            <?= $this->Form->control('email', [
                                'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>

                            <?= $this->element('security_code', ['show_label' => true]) ?>
                        </div>

                        <div class="container-submit container-submit-one-col">

                            <button type="submit" class="btn greenish-teal">SUBMIT</button>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>

                </div>
            </div>
        </div>
    </section>
    <br>
    
</div>
<?php */
?>


<?php //echo $this->Html->script('new-js/jquery.validate'); 
?>
<!-- <script src="/js/new-js/jquery.validate.js" async></script> -->

<script type="text/javascript">
    var request_busy = false;
    $(function() {
        // setInterval(function() {
        //     reLoadCaptchaV3();
        // }, 2 * 60 * 1000);
        $('#SponsorForm').validate({
            rules: {
                'school_name': {
                    required: true,
                    minlength: 3,
                },
                'mobile': {
                    required: true,
                    minlength: 10,
                    maxlength: 13
                },
                'email': {
                    required: true,
                    email: true
                },
                'school_counselor_name': {
                    required: true,
                    minlength: 3,
                },
            },
            messages: {

            },
            errorClass: "error-message",
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.insertAfter(element, false);
            },
            submitHandler: function(form) {
                // form.submit();
                enquirySubmitForm(form, true);
            }
        });

        <?php /*?>
        sponsorSubmitForm = function(form, register) {

            if (!request_busy) {

                // $('body').LoadingOverlay("show");

                request_busy = true;
                // $('#registerbox .modal').append("<div class='remodal-loading'></div>");
                $.ajax({
                    type: "POST",
                    url: $(form).prop('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                }).done(function(data) {
                    request_busy = false;
                    $('.remodal-loading').remove();
                    console.log(data.status);
                    if (data.status) {


                        // notification('success', data.message, data.title);


                        $('.error-message').remove();
                        $(form)[0].reset();

                        // reLoadCaptchaV3();

                    } else {

                        // $('body').LoadingOverlay("hide");

                        // notification('error', data.message, data.title);

                        var rmodal_id = 'modal';

                        // reLoadCaptchaV3();
                        $('.error-message').remove();
                        if (data['validationErrors']) {
                            for (i in data.validationErrors) {
                                if (typeof(data.validationErrors[i]) === 'object') {
                                    var errors_array = data.validationErrors[i];
                                    for (j in errors_array) {
                                        $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + errors_array[j] + '</div>');
                                    }
                                } else {
                                    $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + data.validationErrors[i] + '</div>');
                                }
                            }
                        }

                    }
                    var binst = $('[data-remodal-id=become-sponsor]').remodal();
                    binst.close();

                    $('.modalMsg #msgText').html(data.message);
                    var inst = $('[data-remodal-id=modalMsg]').remodal();
                    inst.open();
                });

                // $('body').LoadingOverlay("hide");
            }
        }
        
        <?php */ ?>

    });
</script>