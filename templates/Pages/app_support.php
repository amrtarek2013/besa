
<div class="hero-section2 hero-support">
    <div class="container">
        <div class="col-md-6">
            <div class="img-hero ">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-support.png" alt="hero Support ">
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-hero">
                <h1 class="title-hero">Support </h1>
                <p>For help and support, leave us your message or question, and we will respond to you quickly</p>
            </div>
        </div>
    </div>
</div>


<section class=" register-banner  app-support">

    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <!-- <form action="" class="register"> -->

                <?= $this->Form->create(null, ['url' => '/enquiries/contactUs', 'class' => 'regsiter', 'id' => 'contactusForm']) ?>
                <input type="hidden" id="type" name="type" value="app-support">
                <div class="container-formBox">
                    <div class="grid-container">
                        <?php

                        echo $this->Form->control('name', [
                            'placeholder' => 'Your name', 'type' => 'text', 'label' => 'First name',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        echo $this->Form->control('surname', [
                            'placeholder' => 'Surname', 'type' => 'text', 'label' => 'Last name ',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        // echo $this->Form->control('tel', [
                        //     'placeholder' => 'Your Mobile ', 'type' => 'tel', 'label' => 'Mobile',
                        //     'class' => 'required', 'required' => true,
                        //     'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        // ]);

                        echo $this->element('mobile_with_code');

                        echo $this->Form->control('email', [
                            'placeholder' => 'Email Address', 'type' => 'email',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        ?>

                    </div>
                    <!-- <div class="form-area">
                            <label for="">Message</label>
                            <textarea name="" id="" cols="40" rows="10"></textarea>
                        </div> -->
                    <div style="padding:  20px 0 0;">
                        <?php
                        echo $this->Form->control('message', [
                            'placeholder' => 'Your Message', 'type' => 'textarea',
                            'class' => 'required', 'required' => true, 'label' => 'Message*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        ?>
                        <?= $this->element('security_code') ?>
                        <div class="container2-submit">
                           

                            <input type="submit" value="Send" class="btn btn" style="width: 240px;">
                        </div>
                    </div>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>


<!-- <?= $app_support_section ?> -->

<script type="text/javascript">
    var request_busy = false;
    $(function() {
        $('#contactusForm').validate({
            rules: {

                'name': {
                    required: true,
                    minlength: 3,
                },
                'surname': {
                    required: true,
                    minlength: 3,
                },
                'email': {
                    required: true,
                    email: true
                },

                'message': {
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