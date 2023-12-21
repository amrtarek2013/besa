<div class="hero-section hero-placement hero-school-tour">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-school-tour.png" alt="hero Young learners">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">School   <span>Tours</span> </h1>
        </div>
    </div>
</div>

<section class="bottom-hero-section  bottom-school-tour">
    <?php if (false) : ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="">
                    <div class="title-bottom-hero">
                        <h4>Bringing a Glimpse of University Life Abroad to Your School</h4>
                        <p class="description">
                            At BESA, we're committed to connecting students with exciting opportunities for studying abroad. 
                            Our School Tours bring this experience directly to your school, introducing you to the world of 
                            international education.
                        </p>
                    </div>
                </div> 
            </div>
        </div>
    <?php endif; ?>
    <?=  $event['text'] ?>
</section>


<!-- <section class="main-banner british-banner fair-banner <?PHP// $event['style'] ?>" style="padding-bottom:0 !important;">
    
    <?php //if (false) : ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="padding: 0;">
                    <div class="title-banner-blue  title-banner-green">
                        <h2>Dreaming of studying abroad?</h2>
                        <p>
                            The journey from the MENA region to international
                            universities is an exciting one, and the International General Certificate of Secondary
                            Education (IGCSE) can be your passport to this adventure.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php //endif; ?>
    <?PHP // $event['text'] ?>
</section> -->


<?= $event['center_text'] ?>
<?php if (false) : ?>
    <div class="global-engagement">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title-eng">Here is why</h2>
                    <div class="group-cards">

                        <div class="card-eng">
                            <div class="circle-gradient">
                                <div class="container-circle">
                                    
                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/school_tour/icon_1.svg"  alt="Icon Global connection " loading="lazy">
                                </div>
                            </div>
                            <h4>Global Recognition with a Local Touch</h4>
                        </div>
                        <div class="card-eng">
                            <div class="circle-gradient">
                                <div class="container-circle">
                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/school_tour/icon_2.svg"  alt="Icon Language " loading="lazy">
                                </div>
                            </div>
                            <h4>Language Proficiency and Cultural Empowerment</h4>
                        </div>
                        <div class="card-eng">
                            <div class="circle-gradient">
                                <div class="container-circle">
                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/school_tour/icon_3.svg"  alt="Icon Dreams " loading="lazy">
                                </div>
                            </div>
                            <h4>Subject Depth for Diverse Dreams</h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ExploringAbroadSection">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="p_18">Embark on a Journey of Discovery: BESA School Tours Unveil the World of Study Abroad</p>
                    <p class="p_12">At BESA, we believe that studying abroad is an unparalleled opportunity forpersonal and intellectual growth. <br> We understand the importance of immersingoneself in different cultures</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php if (!empty($schools)) : ?>
    <div class="school-tour-slider">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="slider">
                        <div class="owl-carousel owl-school-tour">
                            <?php foreach ($schools as $school) : ?>
                                <?php $counter = 0; ?>

                                <?php if (!empty($school['school_images'])) : ?>

                                    <div class="slider-item">
                                        <h2 class="title_28"><?= $school['name'] ?></h2>
                                        <div class="grid-boxes">

                                            <?php foreach ($school['school_images'] as $simage) : ?>

                                                <?php $counter++; ?>
                                                <div class="image-box">
                                                    <img src="<?= $simage['image_path'] ?>" alt="<?= $simage['title'] ?>">
                                                </div>


                                                <?php if ($counter == 3) break; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- Repeat this structure for each slider item -->
                        </div>
                        <!-- Custom navigation buttons 
                        <div class="custom-navigation">
                            <button class="custom-prev">Previous</button>
                            <button class="custom-next">Next</button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>


<?php if (!empty($highlighted)) : ?>
    <div class="banner-ourSchool">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="large-image">
                        <img id="largeImage" src="<?= $highlighted['image_path'] ?>" alt="Large Image">
                        <div class="caption">
                            <p>Our School Tour at <?= $highlighted['name'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<section class="main-banner Create-account-banner  visitors-application book-appointment">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/book_appointment.png" alt=""  width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Book </h1>
                    <h2 class="title text-left">Request <br />a School Tour</h2>
                </div>
            </div>
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'type' => 'file', 'id' => 'FormBookAppointment', 'class' => 'register')); ?>

                <input type="hidden" id="type" name="type" value="request-school-tour">
                <p class="light-para">
                    <?= $requestSchoolTourAppointmentSnippet ?>

                </p>

                <div class="container-formBox">
                    <p class="light-para">For the purpose of applying regulation, your details are required.</p>
                    <div class="grid-container">

                        <?= $this->Form->control('name', [
                            'placeholder' => 'School Representative Name*', 'label' => 'School Representative Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Work Email', 'class' => 'form-control', 'label' => 'Work Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->element('mobile_with_code', ['phone_label' => 'Phone Number']) ?>

                        <?= $this->Form->control('school_name', [
                            'type' => 'text', 'placeholder' => 'School Name', 'label' => 'School Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('address', [
                            'type' => 'text', 'placeholder' => 'School Address', 'label' => 'School Address*', 'required' => true,
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
                
                'address': {
                    required: true,
                    minlength: 10,
                },
                'school_name': {
                    required: true,
                    minlength: 5,
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