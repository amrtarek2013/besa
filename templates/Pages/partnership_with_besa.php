<div class="hero-section hero-partnership-with-besa">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-partnership-with-besa.png" alt="hero Partnership With BESA" loading="lazy">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Partnership With BESA </h1>
        </div>
    </div>
</div>
<!-- <div class="global-engagement icons-partnership">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">BESA Connecting people Worldwide</h2>
                <div class="group-cards">
                    <div class="card-eng">
                        <div class="circle-gradient">
                            <div class="container-circle">
                                <img src="<?php// WEBSITE_URL ?>img/new-desgin/school_tour/icon_1.svg" alt="Icon Global connection" loading="lazy">
                            </div>
                        </div>
                        <h4>Growth</h4>
                        <p>BESA is your trusted partner together we will fulfill student’s ambitions internationally</p>
                    </div>
                    <div class="card-eng">
                        <div class="circle-gradient">
                            <div class="container-circle">
                                <img src="<?php// WEBSITE_URL ?>img/new-desgin/school_tour/icon_2.svg" alt="Icon Language" loading="lazy">
                            </div>
                        </div>
                        <h4>Access</h4>
                        <p>Partnering with BESA means access to a wide range of resources and opportunities in the industry</p>
                    </div>
                    <div class="card-eng">
                        <div class="circle-gradient">
                            <div class="container-circle">
                                <img src="<?php// WEBSITE_URL ?>img/new-desgin/school_tour/icon_3.svg" alt="Icon Dreams" loading="lazy">
                            </div>
                        </div>
                        <h4>Events</h4>
                        <p>BESA’s events are not to be missed! An opportunity for our partners to grow their presence and join us in exciting ventures</p>
                    </div>
                </div>
                <h4 class="bottom-title-black">Submit this form with your business details and one of our<br>representatives will be in contact with you.</h4>
            </div>
        </div>
    </div>
</div> -->

<?= $partnership_with_besa ?>


<section class="main-banner register-banner  partnership-form">
   

    <div class="container">
        <div class="row">

            <div class="col-md-12">

                <?= $this->Form->create(null, ['url' => '/enquiries/contactUs', 'type' => 'file', 'id' => 'contactusForm']) ?>
                <input type="hidden" id="type" name="type" value="partnership-with-besa">
                <div class="container-formBox">
               
                    <div class="grid-2col">

                        <?php

                        echo $this->Form->control('name', [
                            'placeholder' => 'Name', 'type' => 'text', 'label' => 'Company/institution name*',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        echo $this->element('mobile_with_code', ['phone_label' => 'Phone']);
                        // echo $this->Form->control('phone', [
                        //     'placeholder' => 'Phone Number', 'type' => 'text', 'label' => 'Phone Number*',
                        //     'class' => 'required', 'required' => true,
                        //     'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        // ]);


                        echo $this->Form->control('email', [
                            'placeholder' => 'Email Address', 'type' => 'email',
                            'class' => 'required', 'required' => true, 'label' => 'Email address*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        echo $this->Form->control('address', [
                            'placeholder' => 'Business Address', 'type' => 'text',
                            'class' => 'required', 'required' => true, 'label' => 'Business address*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        echo $this->Form->control('certificate', [
                            'type' => 'file',
                            'class' => 'required', 'required' => true, 'label' => 'Upload business certificate*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);


                        echo $this->Form->control('how_hear_about_us', [
                            'placeholder' => 'How did you hear about us?', 'type' => 'text',
                            'class' => 'required', 'required' => true, 'label' => 'How did you hear about us?*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        ?>

                        <?= $this->element('security_code') ?>
                    </div>
                    <input type="submit" value="Submit" class="btn greenish-teal" style="margin: 48px auto 0;">
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var request_busy = false;
    $(function() {

        $('#contactusForm').validate({
            rules: {

                'name': {
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
                'address': {
                    required: true,
                    minlength: 3,
                },
                'certificate': {
                    required: true,
                },
                'how_hear_about_us': {
                    required: true
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