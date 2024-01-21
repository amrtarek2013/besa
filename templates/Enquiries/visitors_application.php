<link rel="preload" as="image" href="<?= WEBSITE_URL ?>img/Welcome-vis.png">
<link rel="preload" as="image" href="<?= WEBSITE_URL ?>img/dots-153.png">


<div class="hero-visitors">
    <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-visitors.png" alt="hero visitors ">

    <div class="text-hero">
        <h2 class="title-hero">Start your journey <br> of <span class="blue">studying Abroad </span> </h2>
        <p>Register today to attend One of the biggest Educational fairs in Egypt. </p>
        <a href="" class="link-blue">Free Entry</a>
    </div>
</div>

<section class="visitors-application">
    <div class="container ">
        <div class="row">


            <div class="col-md-12 ">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'FormVisitorApp', 'class' => 'register')); ?>
                <input type="hidden" id="type" name="type" value="visitors-application">

                <!-- <p class="light-para">For the purpose of applying regulation, your details are required.</p> -->

                <div class="container-formBox">
                    <h4 class="title">Join Us</h4>
                    <div class="grid-container">

                        <?= $this->Form->control('name', [
                            'placeholder' => 'Your first name',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>'], 'label' => 'First Name*', 'required' => true
                        ]) ?>

                        <?= $this->Form->control('surname', [
                            'placeholder' => 'your last name*', 'label' => 'Last Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->element('mobile_with_code') ?>

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Your email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('school_name', [
                            'type' => 'text', 'placeholder' => 'Your school / university', 'label' => 'School / University name / Occupation *', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('study_level', [
                            'placeholder' => 'Select your level', 'type' => 'select', 'empty' => 'Select your level*',
                            'options' => $mainStudyLevels, 'label' => 'Level of study*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('destination_id', [
                            'placeholder' => 'Select your destination*', 'type' => 'select', 'empty' => 'Select your destination*',
                            'options' => $destinationsList, 'label' => 'Study destination interested in*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('fair_venue', [
                            'placeholder' => 'Select your Fair Venue*', 'type' => 'select', 'empty' => 'Select your Fair Venue*',
                            'options' => $fairVenues, 'label' => 'Fair Venue*', 'required' => true, 'value' => (isset($selected_fair_venue) ? $selected_fair_venue : ''),
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->element('security_code', ['show_label' => true]) ?>

                    </div>

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
                        <!-- <a href="#" class="btn greenish-teal">SUBMIT</a> -->

                    </div>
                    <button type="submit" class="btn greenish-teal">Submit</button>

                </div>
                <?= $this->Form->end() ?>

            </div>

            <div class="col-md-12">
                <!-- <p class="light-para" style="line-height: 28px;">
                    <?php // $visitorsApplicationToText 
                    ?>

                </p> -->
            </div>
        </div>
    </div>
</section>

<section class="university-representatives-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Meet top university representatives</h2>
                <p class="description">
                    from more than 10 countries, and know more <br>
                    about requirements, tuition fees, visa requirements and more
                </p>
                <div class=" logos-part">
                    <img src="https://dummyimage.com/235x64/d9d9d9/000000.png" alt="">
                    <img src="https://dummyimage.com/235x64/d9d9d9/000000.png" alt="">
                    <img src="https://dummyimage.com/235x64/d9d9d9/000000.png" alt="">
                    <img src="https://dummyimage.com/235x64/d9d9d9/000000.png" alt="">
                    <img src="https://dummyimage.com/235x64/d9d9d9/000000.png" alt="">

                </div>
            </div>
        </div>
    </div>
</section>
<section class="fair-attendance-benefits">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Reasons to attend our fair</h2>

                <div class="d-flex content-benefits">
                    <div class="image">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/image-attendance-benefits.png" alt="image attendance benefits ">
                    </div>
                    <div class="text">
                        <ul class="benefits-list">
                            <li>
                                <span class="benefit-title">Diverse Educational Opportunities:</span>
                                <p>Our fairs showcase a wide range of educational institutions, including universities, colleges, Pathway Providers and Boarding Schools, from over 10 Countries.</p>
                            </li>
                            <li>
                                <span class="benefit-title">Face-to-Face Interaction:</span>
                                <p>Meeting representatives from institutions in person provides a unique opportunity to ask questions, gather information, and gain insights that may not be available online.</p>
                            </li>
                            <li>
                                <span class="benefit-title">Discover New Destinations:</span>
                                <p>BESA Group’s fairs feature institutions from over 10 countries, giving attendees the chance to discover new study destinations and consider options they may not have initially considered.</p>
                            </li>
                            <li>
                                <span class="benefit-title">Personalized Advice:</span>
                                <p>Our team of experts is on hand to offer personalized guidance on educational pathways, program selection, accommodations options and visa process. We help attendees make informed decisions based on their unique interests and goals.</p>
                            </li>
                            <li>
                                <span class="benefit-title">Comprehensive Information:</span>
                                <p>Access comprehensive information on program offerings, admission requirements, application deadlines, and academic excellence. It’s a one-stop-shop for all your educational inquiries.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


<section class="study-abroad-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Why study abroad?</h2>

                <div class="d-flex content-benefits">

                    <div class="text">
                        <ul class="benefits-list">
                            <li class="benefit-item">
                                <span class="benefit-title">Diverse Educational Opportunities</span>
                                <p>Our fairs showcase a wide range of educational institutions, including universities, colleges, Pathway Providers and Boarding Schools, from over 10 Countries.</p>
                            </li>
                            <li class="benefit-item">
                                <span class="benefit-title">Personal Growth</span>
                                <p>Studying abroad is a transformative journey that encourages personal growth and development. It challenges you to step out of your comfort zone, become more independent, build resilience, and gain a deeper understanding of yourself and the world around you.</p>
                            </li>
                            <li class="benefit-item">
                                <span class="benefit-title">Diverse International Community</span>
                                <p>Studying abroad allows you to join a diverse community of international students from all over the world. This multicultural environment fosters cross-cultural understanding, global perspectives, and lifelong friendships.</p>
                            </li>
                            <li class="benefit-item">
                                <span class="benefit-title">Work Opportunities</span>
                                <p>Many countries allow international students to work part-time during their studies, providing valuable practical experience and opportunities to offset living expenses. Additionally, exploring job opportunities after graduation can lead to a fulfilling career in your host country or elsewhere.</p>
                            </li>
                            <li class="benefit-item">
                                <span class="benefit-title">High Employability</span>
                                <p>A degree from an international university is highly regarded by employers globally. It demonstrates your adaptability, language proficiency, and ability to thrive in diverse environments, making you a desirable candidate in the competitive job market.</p>
                            </li>
                            <li class="benefit-item">
                                <span class="benefit-title">Global Network</span>
                                <p>Studying abroad provides the opportunity to establish a global network of friends, peers, and professionals. This network can be invaluable for future collaborations, career opportunities, and personal connections that span the globe.</p>
                            </li>
                        </ul>
                    </div>
                    <div class="image">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/image study-abroad.png" alt="image study abroad ">
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="fair-locations-schedule">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Our fairs locations</h2>
                <h4 class="location-center">
                    <img src="<?= WEBSITE_URL ?>img/new-desgin/location.svg" alt="">
                    Cairo, Dusit Thani Lakeview
                </h4>

                <div class="d-flex">
                    <div class="date-box">
                        <h5>28 September</h5>
                        <p>
                            <span>from</span>
                            <span>10:30 AM – 1:30 PM</span>
                            <span>4:00 PM – 8:00 PM</span>
                        </p>
                    </div>
                    <div class="date-box">
                        <h5>29 September</h5>
                        <p>
                            <span>from</span>
                            <span>4:00 PM – 8:00 PM</span>
                        </p>
                    </div>
                </div>
                <div class="map-container">
                    <img src="https://dummyimage.com/1792x1024/d9d9d9/000000.png" alt="Map" />
                </div>
                <a href="#" class="btn MainBtn view-maps">View on maps</a>
            </div>
        </div>
    </div>

</section>


<script type="text/javascript">
    var request_busy = false;
    $(function() {
        setInterval(function() {
            reLoadCaptchaV3();
        }, 2 * 60 * 1000);
        $('#FormVisitorApp').validate({
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
                'study_level': {
                    required: true,
                },
                'school_name': {
                    required: true,
                    minlength: 3,
                },
                'destination_id': {
                    required: true,
                },
                'fair_venue': {
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

                console.log('enquirySubmitForm2222');
                enquirySubmitForm(form, true);
            }
        });
    });
</script>