<?= $this->element('home_slider', ['sliders' => $sliders, 'g_dynamic_routes' => $g_dynamic_routes], ['cache' => ['key' => 'home_slider', 'config' => '_view_long_']]) ?>
<?= $homeEvents ?>
<!--New section 25/5/2023 by en -->
<?= $home_study_journey ?>

<?= $home_why_besa2 ?>

<?= $home_assessment_section ?>

<?= $this->element("choose-place-earth", ['colWidth' => '9', 'redirectUrl' => 'destination', 'pageType' => 'home'], ['cache' => ['key' => 'choose_place_earth_home', 'config' => '_view_long_']]) ?>

<!--Start Events Section-->
<?php if (!empty($home_main_events)) : ?>
    <div class="home-blogs home-events">
        <div class="top-text">
            <h4 class="title">Events</h4>
            <p class="description">Explore a world of opportunities with our events, crafted to enrich your educational journey. </p>
        </div>
        <div class="top-events">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container-events display-flex">
                            <?php foreach ($home_main_events as $event) : ?>
                                <div class="box-blog display-flex">
                                    <div class="card-img-top">
                                        <img src="/img/new-desgin/events.png" alt="event" loading="lazy">
                                    </div>
                                    <div class="content-blog">
                                        <h4 class="title-blog">
                                            <a href="<?= Cake\Routing\Router::url('/event-details/' . $event['permalink']) ?>" class="read-anchor"><?= $event['title'] ?></a>
                                        </h4>
                                        <p class="description-blog"><?= $event['sub_title'] ?></p>

                                        <?php if (!empty($event['fair_events'])) : ?>
                                            <div class="timline-eve">

                                                <?php
                                                $counter = sizeof($event['fair_events']);
                                                foreach ($event['fair_events'] as $count => $fair_event) : ?>
                                                    <?php if (!empty($fair_event['day_date'])) : ?>
                                                        <div class="item">
                                                            <img src="/img/new-desgin/timer.svg" alt="">
                                                            <?php if ($count < ($counter - 1)) : ?>
                                                                <img src=" /img/new-desgin/line-timline.svg" alt="" class="line-timer">

                                                            <?php endif; ?>
                                                            <p> <?= $fair_event['day_date'] ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <!-- <div class="item">
                                                    <img src="/img/new-desgin/timer.svg" alt="">
                                                    <p>09 Dec 2023</p>
                                                </div> -->
                                            </div>

                                        <?php endif; ?>
                                        <a href="<?= Cake\Routing\Router::url('/event-details/' . $event['permalink']) ?>" class="btn btn-transpernt">View more <img src="/img/new-desgin/arrow right.svg" alt=""></a>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php endif; ?>
<!--End Events Section-->
<!--Start Blogs Section-->
<?php if (!empty($homeBlogs)) : ?>
    <div class="home-blogs blogs-en">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="title">Blogs</h4>
                    <div class="owl-blogs">
                        <div id="wrap">
                            <section class="carousel-wrap">
                                <ul class="carousel carousel-blogs">
                                    <?php
                                    $counter = 1;
                                    foreach ($homeBlogs as $blog) {
                                        // Assign a class based on the counter
                                        $positionClass = '';
                                        switch ($counter) {
                                            case 1:
                                                $positionClass = 'left-pos';
                                                break;
                                            case 2:
                                                $positionClass = 'main-pos';
                                                break;
                                            case 3:
                                                $positionClass = 'right-pos';
                                                break;
                                            default:
                                                $positionClass = 'back-pos';
                                                break;
                                        }
                                    ?>
                                        <li class="items <?= $positionClass ?>" id="<?= $counter ?>">
                                            <div class="card">
                                                <h4 class="title">
                                                    <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['blogs.details'] . '/' . $blog['permalink']) ?>" class="read-anchor"><?= $blog['title'] ?></a>
                                                </h4>
                                                <p class="description">
                                                    <?= substr($blog['short_text'], 0, 200) . '...' ?>
                                                </p>

                                            </div>
                                        </li>
                                    <?php
                                        $counter++;
                                        // Reset counter to loop through classes again
                                        if ($counter > 4) {
                                            $counter = 1;
                                        }
                                    }
                                    ?>
                                </ul>
                                <span class="slider">
                                    <a href="javascript:void(0);" value="Prev" id="prev"><img src="<?= WEBSITE_URL ?>img/new-desgin/prev-arrow.svg"></a>
                                    <a href="javascript:void(0);" value="Next" id="next"><img src="<?= WEBSITE_URL ?>img/new-desgin/next-arrow.svg"></a>
                                </span>
                            </section>

                        </div>


                    </div>
                    <div class="display-flex">
                        <?php /* foreach ($homeBlogs as $blog) : ?>
                            <div class="box-blog display-flex">
                                <div class="content-blog">
                                    <p><a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['blogs.details'] . '/' . $blog['permalink']) ?>" class="read-anchor"><?= $blog['title'] ?></a></p>
                                    <p><?= $blog['short_text'] ?></p>
                                </div>
                            </div>

                        <?php endforeach;*/ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
<!--End Blogs Section-->

<?= $this->element('testimonials', ['testimonials' => $testimonials], ['cache' => ['key' => 'home_testimonials', 'config' => '_view_long_']]) ?>

<scetion class="top-universities">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title title-top">Top Universities</h2>
                <p class="description">We work wih best universities in the world</p>
                <div class="owl-carousel owl-theme owl-topUni">
                    <div class="item">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/img-unk.png" loading="lazy" alt="image United Kingdom">
                        <div class="title-box">
                            <h4>University of Manchester</h4>
                            <p class="flag">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/flag-unk.png" alt="flag United Kingdom">
                                <span>United Kingdom</span>
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/img-spain.png" loading="lazy" alt="image spain ">
                        <div class="title-box">
                            <h4>University of Mardid</h4>
                            <p class="flag">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/flag-spain.png" alt="flag spain ">
                                <span>Spain </span>
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/img-usk.png" loading="lazy" alt="image spain ">
                        <div class="title-box">
                            <h4>University of Washingnton</h4>
                            <p class="flag">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/flag-usk.png" alt="flag United States ">
                                <span>United States</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</scetion>


<section class="contact-us contact-us-home">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="title">Need any help?</h2>
                <h3 class="title-form">Drop us a message and one of our Advisor <br> and Study Abroad Experts will respond to you</h3>

            </div>
            <div class="col-md-10 col-md-offset-1 ">
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