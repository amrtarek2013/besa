<?= $this->element('home_slider', ['sliders' => $sliders, 'g_dynamic_routes' => $g_dynamic_routes], ['cache' => ['key' => 'home_slider', 'config' => '_view_long_']]) ?>
<?= $homeEvents ?>
<!--New section 25/5/2023 by en -->
<?= $home_study_journey ?>

<?= $home_why_besa2 ?>

<?= $home_assessment_section ?>

<?= $this->element("choose-place-earth", ['colWidth' => '9', 'redirectUrl' => 'destination'], ['cache' => ['key' => 'choose_place_earth', 'config' => '_view_long_']]) ?>

<!--Start Events Section-->
<?php if (!empty($homeBlogs)) : ?>
    <div class="home-blogs home-events">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-events display-flex">
                        <?php foreach ($home_main_events as $event) : ?>
                            <div class="box-blog display-flex">
                                <div class="card-img-top">
                                    <img src="/img/new-desgin/events.png" alt="event"  loading="lazy">
                                </div>
                                <div class="content-blog">
                                    <h4 class="title-blog">
                                        <a href="<?= Cake\Routing\Router::url('/event-details/' . $event['permalink']) ?>" class="read-anchor"><?= $event['title'] ?></a>
                                    </h4>
                                    <p class="description-blog"><?= $event['sub_title'] ?></p>
                                    <div class="timline-eve">
                                        <div class="item">
                                            <img src="/img/new-desgin/timer.svg" alt=""> 
                                            <img src=" /img/new-desgin/line-timline.svg" alt="" class="line-timer"> 
                                            <p> 21  Oct 2023</p>              
                                        </div>
                                        <div class="item">
                                            <img src="/img/new-desgin/timer.svg" alt="">  
                                            <p>09 Dec 2023</p> 
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-transpernt">View more <img src="/img/new-desgin/arrow right.svg" alt=""></a>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
<!--End Events Section-->
<!--Start Blogs Section-->
<?php if (!empty($homeBlogs)) : ?>
    <div class="home-blogs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="display-flex">
                        <?php foreach ($homeBlogs as $blog) : ?>
                            <div class="box-blog display-flex">
                                <div class="content-blog">
                                    <p><a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['blogs.details'] . '/' . $blog['permalink']) ?>" class="read-anchor"><?= $blog['title'] ?></a></p>
                                    <p><?= $blog['short_text'] ?></p>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
<!--End Blogs Section-->

<?= $this->element('testimonials', ['testimonials' => $testimonials], ['cache' => ['key' => 'home_testimonials', 'config' => '_view_long_']]) ?>

<section class="contact-us">
    <div class="top-dots-img">
        <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/dots-bakground.svg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Need any help?</h2>

            </div>
            <div class="col-md-12">
                <h3 class="title-form">Drop us a message and one of our Advisor and Study Abroad Experts will respond to you</h3>
            </div>
            <div class="col-md-5 col-md-offset-1 ">
                <div class="form">

                    <?= $this->Form->create($enquiry, ['url' => '/enquiries/contactUs', 'id' => 'contactusForm']) ?>

                    <input type="hidden" id="type" name="type" value="home">

                    <?php

                    echo $this->Form->control('name', [
                        'placeholder' => 'Your name', 'type' => 'text', 'label' => false,
                        'class' => 'required', 'required' => true,
                        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    ]);


                    echo $this->Form->control('email', [
                        'placeholder' => 'Email Address', 'type' => 'email',
                        'class' => 'required', 'label' => false, 'required' => true,
                        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    ]);

                    // echo  $this->element('mobile_with_code', ['phone_label' => 'Mobile']);

                    echo $this->Form->control('message', [
                        'placeholder' => 'Your Message', 'type' => 'textarea',
                        'class' => 'required', 'label' => false, 'required' => true,
                        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    ]);
                    ?>

                    <?= $this->element('security_code') ?>
                    <input type="submit" value="Send" class="btn MainBtn submit">

                    <?= $this->Form->end() ?>

                </div>

            </div>
            <div class="col-md-6">
                <?php if (!empty($mainBranch)) { ?>
                    <div class="text">
                        <p>
                            <?= $mainBranch['name'] ?>

                        </p>
                        <p><?= $mainBranch['phone'] ?></p>
                        <p><?= $mainBranch['email'] ?></p>
                    </div>

                <?php } ?>
            </div>

        </div>
    </div>
    <div class="bottom-dots-img">
        <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/dots-bakground.svg" alt="">

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
                    minlength: 8,
                    maxlength: 13,
                },
                'email': {
                    required: true,
                    email: true
                },

                'message': {
                    required: true,
                    minlength: 5
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