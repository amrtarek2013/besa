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

                    use Cake\Routing\Router;

                    ?>

                </p> -->
            </div>
        </div>
    </div>
</section>


<?php if (!empty($topUniversitiesList)) : ?>
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

                        <?php foreach ($topUniversitiesList as $university) : ?>
                            <a href="<?= Router::url('/' . $g_dynamic_routes['universities.details'] . '/') . $university['permalink'] ?>"><img src="<?= $university['logo_path'] ?>" alt="<?= $university['university_name'] ?>"></a>
                             <!-- <img src="https://dummyimage.com/235x64/d9d9d9/000000.png" alt=""> -->
                           
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php echo $visitorsApplicationToText ?>



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