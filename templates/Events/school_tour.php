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

<section class="journey-discovery-besa-tours">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex">
                    <img src="<?= WEBSITE_URL ?>img/new-desgin/school_tour/5264880.png" alt="journey discovery besa tours" loading="lazy">
                    <h4 class="title">Embark on a <span>Journey of Discovery: </span> <br> BESA School Tours Unveil the World of Study Abroad</h4>
                    <p class="description">At BESA, we believe that studying abroad is an unparalleled opportunity forpersonal and intellectual growth.We understand the importance of immersingoneself in different cultures</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="remote-school-tour-counseling">
    <div class="container">
        <div class="row">
            
            <div class="col-md-12">
                <h2 class="school-tour-header">Request a School Tour</h2>
                <div class="d-flex">
                    <div class="school-tour-image">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/school_tour/1171274969.png" alt="Request a School Tour" loading="lazy">
                    </div>
                    <div class="school-tour-content">
                        <p>
                            Access study abroad counseling conveniently from any location and at your own pace. 
                            If you're seeking guidance on studying abroad but prefer to avoid in-person 
                            meetings or face challenges like traffic

                        </p>
                        <p>
                            we have the perfect solution for you. Reach out to us to schedule a remote counseling
                             session with IDP's knowledgeable education counselors. They will provide comprehensive 
                             support to help you reach your dream destination. From analyzing your study options
                        </p>
                        <p>
                            and selecting the ideal destination, university, and course, 
                            to assisting with application submissions, visa guidance, accommodation 
                        </p>
                        <p>
                            services, and more – all of this can be conveniently accessed online. 
                            Don't let barriers hold you back; take advantage of our remote counseling services today
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($schools)) : ?>
    <div class="school-tour-slider">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="slider">
                        <div class="owl-carousel owl-school-tour">
                            <?php foreach ($schools as $school) : ?>
                                <?php if (!empty($school['school_images'])) : ?>
                                    <div class="item">
                                        <h2 class="title_28"><?= $school['name'] ?></h2>
                                            <?php 
                                            // Get the first image from the array
                                            $simage = reset($school['school_images']); 
                                            ?>
                                            <div class="image-box">
                                                <img src="<?= $simage['image_path'] ?>" alt="<?= $simage['title'] ?>">
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
    <!-- <div class="banner-ourSchool">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="large-image">
                        <img id="largeImage" src="<?php // $highlighted['image_path'] ?>" alt="Large Image">
                        <div class="caption">
                            <p>Our School Tour at <?php // $highlighted['name'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

<?php endif; ?>

<section class="main-banner Create-account-banner  visitors-application book-appointment">
    <div class="container-fluid">
        <div class="row">
        
            <div class="col-md-12">
                <?php  $this->Form->create(null, array('url' => 'contact-us', 'type' => 'file', 'id' => 'FormBookAppointment', 'class' => 'register')); ?>

                <input type="hidden" id="type" name="type" value="request-school-tour">
                <p class="light-para">
                    <?php //$requestSchoolTourAppointmentSnippet ?>

                </p>

                <div class="container-formBox">
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