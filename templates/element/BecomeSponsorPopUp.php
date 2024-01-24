<div class="remodal remodal-form british-trophy-subscription-modal" data-remodal-id="british-trophy-event-subscription">
    <button data-remodal-action="close" class="remodal-close">
        <img src="<?= WEBSITE_URL ?>img/new-desgin/remodal-close.svg" alt="close remodal">

    </button>
    <h2>The British Trophy Event Subscription</h2>


    <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'FormBritishTrophySubscription', 'class' => 'subscription-form')); ?>
    <input type="hidden" id="type" name="type" value="british-trophy-subscription">
    <?= $this->Form->control('first_name', [
        'placeholder' => 'School name', 'label' => 'School name*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
    ]) ?>

    <?= $this->Form->control('last_name', [
        'placeholder' => 'Contact person name*', 'label' => 'Contact person name*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
    ]) ?>

    <?= $this->element('mobile_with_code', ['phone_label' => 'Phone number']) ?>

    <?= $this->Form->control('email', [
        'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
    ]) ?>

    <?= $this->Form->control('certificate', [
        'type' => 'file',
        'class' => 'required', 'required' => true, 'label' => 'Upload attending students details*',
        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
    ]); ?>
    <!-- <div class="form-area">
            <label for="school-name">School name</label>
            <input type="text" id="school-name" placeholder="Enter school name" required>
        </div>
        <div class="form-area">
            <label for="work-email">Work Email</label>
            <input type="email" id="work-email" placeholder="Enter work email" required>
        </div>
        <div class="form-area">
            <label for="phone-number">Phone number</label>
            <input type="tel" id="phone-number" placeholder="Enter phone number" required>
        </div>
        <div class="form-area">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter email" required>
        </div>
        <div class="form-area">
            <label for="file-upload">Upload attending students details</label>
            <input type="file" id="file-upload" required>
        </div> -->
    <div class="form-area ">
        <label for="" style="color:transparent;" class="hidden-mobile">`</label>
        <div class="checkbox-container">
            <div class="checkbox terms">
                <label for="terms-conditions">
                    <input type="checkbox" id="terms-conditions" required>
                    <p><label for="">I agree to <a href="<?= Cake\Routing\Router::url('/content/terms-conditions') ?>">terms & conditions</a> </label></p>
                </label>
            </div>
            <div class="checkbox news">
                <label for="latest-news">
                    <input type="checkbox" id="latest-news">
                    <p>I'd like being informed about latest news and tips</p>
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary subscription-btn">Submit</button>
    <?= $this->Form->end() ?>
</div>

<?php

/*

<section class="main-banner Create-account-banner visitors-application educational-institution  british-Trophy">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">

                    <img src="<?= WEBSITE_URL ?>img/customer-support-flat.png" alt="customer support" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Trophy</h1>
                    <h2 class="title text-left">The British<br />Trophy Event<br />Subscription</h2>
                    <!-- <h2 class="title text-left-mobile">The British<br />Trophy Event<br />Subscription</h2> -->
                </div>
            </div>

            <div class="col-md-12 ">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'FormBritishTrophySubscription', 'class' => 'register')); ?>
                <input type="hidden" id="type" name="type" value="british-trophy-subscription">
                <!-- <p class="light-para">For the purpose of applying regulation, your details are required.</p> -->

                <div class="container-formBox">
                    <!-- <h4 class="title">Create an account to apply</h4> -->
                    <div class="grid-container">

                        <?= $this->Form->control('first_name', [
                            'placeholder' => 'School name', 'label' => 'School name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('last_name', [
                            'placeholder' => 'Contact person name*', 'label' => 'Contact person name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->element('mobile_with_code') ?>

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('certificate', [
                            'type' => 'file',
                            'class' => 'required', 'required' => true, 'label' => 'Upload attending students details*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]); ?>
                        <?php $this->element('security_code', ['show_label' => true])  ?>

                        <?= $this->element('security_code', ['show_label' => true]) ?>

                        <div class="form-area check-en">
                            <div class="checkboxes">
                                <div class="terms-conditions">
                                    <input type="checkbox" name="terms" id="terms" required="required">
                                    <label for="">I agree to <a href="<?= Cake\Routing\Router::url('/content/terms-conditions') ?>">terms & conditions</a> </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="is_subscribed" id="is_subscribed">
                                    <label for="">I’d like being informed about latest news and tips</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn greenish-teal">Submit</button>

                </div>
                <?= $this->Form->end() ?>

            </div>

        </div>
    </div>
</section>
<? */ ?>
<?php if ($this->request->is('mobile')) { ?>
    <script>
        $(document).ready(function() {

            let text = $('.title .text-left').html();
            text = text.replace('<br/>', ' ');
            $('.title .text-left').html(text);
        });
    </script>
<?php } ?>



<!-- Remodal HTML structure for sponsor form -->
<div class="remodal remodal-form  british-trophy-sponsor-modal" data-remodal-id="become-sponsor">
    <button data-remodal-action="close" class="remodal-close">
        <img src="<?= WEBSITE_URL ?>img/new-desgin/remodal-close.svg" alt="close remodal">

    </button>
    <h2>Become a sponsor</h2>

    <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'SponsorForm', 'class' => 'subscription-form')); ?>

    <input type="hidden" id="type" name="type" value="become-sponsor">
    <?= $this->Form->control('school_name', [
        'placeholder' => 'Your institution name', 'label' => 'Institution Name*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
    ]) ?>
    <?= $this->Form->control('school_counselor_name', [
        'placeholder' => 'Your contact person name*', 'label' => 'Contact Person Name*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
    ]) ?>


    <?= $this->element('mobile_with_code', ['phone_label' => 'Phone number']) ?>
    <?= $this->Form->control('email', [
        'placeholder' => 'Your email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
        'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
    ]) ?>

    <?= $this->element('security_code', ['show_label' => true]) ?>
    <button type="submit" class="btn btn-primary btn-submit">Submit</button>
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
    $(function() {

        $('#FormBritishTrophySubscription').validate({
            rules: {

                'first_name': {
                    required: true,
                    minlength: 3,
                },
                'last_name': {
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

                'certificate': {
                    required: true,
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

                alert('aaaaaaaaaa');
                enquirySubmitForm(form, true);
            }
        });

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

    });
</script>