<section class="main-banner Create-account-banner  visitors-application book-appointment">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/book_appointment.png" alt="" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Book </h1>
                    <h2 class="title text-left">Book an <br />appointment</h2>
                </div>
            </div>




            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'type' => 'file', 'id' => 'FormBookAppointment', 'class' => 'register')); ?>

                <input type="hidden" id="type" name="type" value="book-appointment">
                <p class="light-para">
                    <?= $bookAppointmentSnippet ?>

                </p>

                <div class="container-formBox">
                    <p class="light-para">For the purpose of applying regulation, your details are required.</p>
                    <div class="grid-container">

                        <?= $this->Form->control('name', [
                            'placeholder' => 'Full Name*', 'label' => 'Full Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>



                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->element('mobile_with_code') ?>

                        <?= $this->Form->control('destination_id', [
                            'placeholder' => 'Study destination interested in*', 'type' => 'select', 'empty' => 'Select Study destination interested in*',
                            'options' => $destinationsList, 'label' => 'Study destination interested in*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('subject_area_id', [
                            'placeholder' => 'Subject area interested in*', 'type' => 'select', 'empty' => 'Select Subject area interested in*',
                            'options' => $subjectAreasList, 'label' => 'Subject area interested in*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}" id="subject-area">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('study_level', [
                            'placeholder' => 'Study level interested in*', 'type' => 'select', 'empty' => 'Select Study level interested in*',
                            'options' => $interestedStudyLevels, 'label' => 'Study level interested in*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->element('security_code', ['show_label' => true]) ?>

                    </div>
                    <!--
                    <div class="container-submit">

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

                    </div> -->
                    <button type="submit" class="btn greenish-teal">Submit</button>

                </div>
                <?= $this->Form->end() ?>

            </div>

        </div>
    </div>
</section>

<script type="text/javascript">
    var request_busy = false;
    $(function() {
        $('#FormBookAppointment').validate({
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
                
                'destination_id': {
                    required: true,
                },
                'subject_area_id': {
                    required: true,
                },
                'study_level': {
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