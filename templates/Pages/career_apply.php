<div class=" hero-section hero-counselor hero-apply">
<div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-apply.png" alt="hero Apply Career">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Apply <span>With BESA</span></h1>
        </div>
    </div>
</div>



<section class="main-banner register-banner  partiner-banner">
    <div class="container-fluid">
        <div class="row">
          

            <?= $partnership_with_besa ?>

        </div>
    </div>

    <div class="container ">
        <div class="row">

            <div class="col-md-12">

                <?= $this->Form->create(null, ['url' => '/enquiries/contactUs', 'type' => 'file', 'id' => 'contactusForm']) ?>
                <input type="hidden" id="type" name="type" value="career-apply">
                <div class="container-formBox apply-form">
                    <div class="gray-box">
                        <p>Submit this form with your details and one of our representatives will be in contact with you.</p>

                    </div>

                        
                    <div class="grid-container">

                    <?= $this->Form->control('career_id', [
                        'placeholder' => 'Career', 'type' => 'select', 'empty' => 'Select Career',
                        'options' => $careersList, 'label' => 'Career*', 'required' => true, 'value' => $id,
                        'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                    ]) ?>

                        <?php

                        echo $this->Form->control('name', [
                            'placeholder' => 'Name', 'type' => 'text', 'label' => 'Name*',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        echo $this->Form->control('surname', [
                            'placeholder' => 'Surname', 'type' => 'text', 'label' => 'Surname*',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        // echo $this->Form->control('phone', [
                        //     'placeholder' => 'Phone Number', 'type' => 'text', 'label' => 'Phone Number*',
                        //     'class' => 'required', 'required' => true,
                        //     'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        // ]);

                        echo $this->element('mobile_with_code');

                        echo $this->Form->control('email', [
                            'placeholder' => 'Email Address', 'type' => 'email',
                            'class' => 'required', 'required' => true, 'label' => 'Email address*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        echo $this->Form->control('address', [
                            'placeholder' => 'Address', 'type' => 'text',
                            'class' => 'required', 'required' => true, 'label' => 'Address*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        echo $this->Form->control('certificate', [
                            'type' => 'file',
                            'class' => 'required', 'required' => true, 'label' => 'Upload CV*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);


                        echo $this->Form->control('how_hear_about_us', [
                            'placeholder' => 'How did you hear about us?', 'type' => 'text',
                            'class' => 'required', 'required' => true, 'label' => 'How did you hear about us?*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        ?>

                        <?= $this->element('security_code', ['show_label' => true]) ?>
                    </div>


                    <div class="container-submit">
                     
                        <!-- <a href="#" class="btn greenish-teal" style="width: 240px;">SUBMIT</a> -->
                        <input type="submit" value="Submit" class="btn greenish-teal btn-primary" style="max-width: 455px;">
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
                'surname': {
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
                'career_id': {
                    required: true,
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