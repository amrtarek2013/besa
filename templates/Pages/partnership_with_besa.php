<section class="main-banner register-banner  partiner-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/new-images/partiner-background.png" alt="" style="z-index: 2;" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">PARTNER</h1>
                    <h2 class="title text-left">PARTNERSHIP <br> WITH BESA</h2>
                </div>
            </div>

            <?= $partnership_with_besa ?>
            <!-- <div class="col-md-12" style="padding: 0">
                <div class="title-banner-blue">
                    <h3>BESA: CONNECTING PEOPLE WORLDWIDE</h3>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0;">
                <div class="container-iconsPartners">
                    <div class="boxPart">
                        <img src="<?= WEBSITE_URL ?>img/new-images/part-icon01.png" alt="">
                        <h4 class="titlePart">GROWTH</h4>
                        <p class="descrip">BESA is your trusted partner, <br> together we will fulfill student’s <br> ambitions internationally</p>
                    </div>
                    <div class="boxPart">
                        <img src="<?= WEBSITE_URL ?>img/new-images/part-icon02.png" alt="">
                        <h4 class="titlePart">ACCESS</h4>
                        <p class="descrip">Partnering with BESA means access to a wide range of resources and opportunities in the industry</p>
                    </div>
                    <div class="boxPart">
                        <img src="<?= WEBSITE_URL ?>img/new-images/part-icon03.png" alt="">
                        <h4 class="titlePart">EVENTS</h4>
                        <p class="descrip">BESA’s events are not to be missed! An opportunity for our partners to grow their presence and join us in exciting ventures</p>
                    </div>
                </div>
            </div>
           -->
            <div class="col-md-12" style="padding: 0;">
                <div class="line-stained">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-md-12">

                <?= $this->Form->create(null, ['url' => '/enquiries/contactUs', 'type' => 'file', 'id' => 'contactusForm']) ?>
                <input type="hidden" id="type" name="type" value="partnership-with-besa">
                <div class="container-formBox">
                    <div class="gray-box">
                        <p>Submit this form with your business details and one of our representatives will be in contact with you.</p>
                    </div>
                    <div class="grid-container">

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


                    <div class="container-submit">
                        <ul class="custome-list">
                            <li>For the purpose of applying regulation, your details are required.</li>
                        </ul>
                        <!-- <a href="#" class="btn greenish-teal" style="width: 240px;">SUBMIT</a> -->
                        <input type="submit" value="Submit" class="btn greenish-teal" style="width: 240px;">
                    </div>
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