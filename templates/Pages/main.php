<section class="header animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="main-slider  owl-carousel owl-theme animateddiv">
                    <?php

                    use Cake\Routing\Router;

                    if (!empty($sliders)) {
                        foreach ($sliders as $key => $slider) {

                    ?>
                            <div class="item">
                                <div class="text ">
                                    <div class="fadeInUp">
                                        <h1 class="title"><?= $slider['title'] ?></h1>
                                        <p class=""><?= $slider['text'] ?></p>
                                    </div>
                                    <div class="buttons fadeInUp">
                                        <?php if (isset($slider['url'])) { ?>
                                            <a href="<?= $slider['url'] ?>" class="btn MainBtn apply-now">
                                                <?= $slider['url_label'] ?>
                                                <i aria-hidden="true" class="far fa-arrow-alt-circle-right"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a href="/event-details/<?= $slider['permalink'] ?>" class="btn MainBtn apply-now">
                                                Apply Now
                                                <i aria-hidden="true" class="far fa-arrow-alt-circle-right"></i>
                                            </a>
                                        <?php } ?>


                                        <?php if (isset($slider['right_url'])) { ?>
                                            <a href="<?= $slider['right_url'] ?>" class="btn MainBtn contact-us"><?= $slider['right_url_label'] ?></a>

                                        <?php } else { ?>
                                            <a href="/contact-us" class="btn MainBtn contact-us">Contact Us</a>

                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="image fadeInDown">
                                    <?php
                                    if (isset($slider['image_path'])) {
                                    ?>
                                        <img src="<?= $slider['image_path'] ?>" alt="">
                                    <?php } else { ?>

                                        <img src="<?= WEBSITE_URL ?>img/bg-popup-1.png" alt="" class="box-message bounceIn">
                                        <img src="<?= WEBSITE_URL ?>img/bg-popup-2.png" alt="" class="icon-message bounceIn">
                                        <img src="<?= WEBSITE_URL ?>img/background-header.png" alt="">
                                    <?php } ?>
                                </div>
                            </div>
                    <?php
                        }
                    } ?>
                </div>
                <div class="arrow-bottomGoSection">
                    <a href="#scroll_about"><img src="<?= WEBSITE_URL ?>img/icon/chevron-circle-up.svg" alt=""></a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php //= $home_aboutus 
?>

<?php //= $home_why_besa 
?>

<!--New section 25/5/2023 by en -->
<?= $home_study_journey ?>
<!-- Start study-broad-guidance  -->
<!-- <section class="study-broad-guidance">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">YOUR JOURNEY STARTS HERE IN 5 EASY STEPS!</h2>
                <h4 class="title-green">Make your study abroad journey happen with BESA.</h4>
                <p class="description">
                    Explore a wide range of programs, choose which country will be your new home and which university
                    you want to study at. Our dedicated experts are ready to support you all the way through your UCAS,
                    admission & visa application. <br />
                    To ask any questions you may have you can now
                </p>
                <a href="#" class="btn btn-dark">Book a meeting </a>
            </div>
            <div class="col-md-12">
                <div class="contaienr-conditions">
                    <div class="box">
                        <div class="icon">
                            <img src="<?= WEBSITE_URL ?>img/new-images/eye-icon.svg" alt="icon eye">
                        </div>
                        <h2>Explore</h2>
                        <p class="descrip">Explore studying abroad & check you meet the entry requirements.</p>
                    </div>
                    <div class="box">
                        <span class="arrow-green"></span>
                        <div class="icon">
                            <img src="<?= WEBSITE_URL ?>img/new-images/write-icon.svg" alt="icon eye">
                        </div>
                        <h2>Create</h2>
                        <p class="descrip">Create an Account and Apply for Your Chosen Program and University Destination</p>
                    </div>
                    <div class="box">
                        <span class="arrow-green"></span>
                        <div class="icon">
                            <img src="<?= WEBSITE_URL ?>img/new-images/home-icon.svg" alt="icon eye">
                        </div>
                        <h2>Receive</h2>
                        <p class="descrip">Receive Offers & Select Chosen University</p>
                    </div>
                    <div class="box">
                        <span class="arrow-green"></span>
                        <div class="icon">
                            <img src="<?= WEBSITE_URL ?>img/new-images/calc-icon.svg" alt="icon eye">
                        </div>
                        <h2>Pay</h2>
                        <p class="descrip">Pay Deposit & Apply for Your Student Visa with Our Dedicated Experts</p>
                    </div>
                    <div class="box">
                        <div class="icon">
                            <img src="<?= WEBSITE_URL ?>img/new-images/like-icon.svg" alt="icon eye">
                        </div>
                        <h2>Ready</h2>
                        <p class="descrip">Congratulations! You are ready to go!</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section> -->
<!-- End study-broad-guidance  -->

<!-- Start Why Besa 2-->
<!-- <section class="why_besa2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">WHY BESA?</h2>
            </div>
            <div class="col-md-12">
                <div class="container-icons">
                    <div class="icon-box">
                        <h4>10+ Years <br />Industry Leader</h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/aniversary-1.svg" alt="10+ Years Industry Leader">
                    </div>
                    <div class="icon-box">
                        <h4>400+ Partners</h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/group-icon.svg" alt="400+ Partners">
                    </div>
                    <div class="icon-box">
                        <h4>Partial Scholarships <br /> Access</h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/grad-icon.svg" alt="Partial Scholarships Access">
                    </div>
                    <div class="icon-box">
                        <h4>Worldwide Study <br /> Destinations</h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/map-icon.svg" alt="Worldwide Study Destinations">
                    </div>
                    <div class="icon-box">
                        <h4>Application <br /> Assistance & Fast <br /> Admission Process</h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/file-cut-icon.svg" alt="Application Assistance">
                    </div>
                </div>

                <div class="container-icons secondry-container-icons">
                    <div class="icon-box">
                        <h4>Dedicated <br> Expert <br> Councilors</h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/chat-icon.svg" alt="Dedicated">
                    </div>
                    <div class="icon-box">
                        <h4>Live Application <br> Tracking Through <br> Our Mobile App</h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/screen-icon.svg" alt="Live Application">
                    </div>
                    <div class="icon-box">
                        <h4>Expert Visa <br> Application <br> Assistance </h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/plane-icon.svg" alt="Expert Visa">
                    </div>
                    <div class="icon-box">
                        <h4>international <br /> Offices</h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/earth-icon.svg" alt="international Offices ">
                    </div>
                    <div class="icon-box">
                        <h4>BESA International <br /> Education Fairs & <br /> School Tours </h4>
                        <img src="<?= WEBSITE_URL ?>img/new-images/calander.svg" alt="BESA International">
                    </div>
                </div>

            </div>
        </div>
    </div>
</section> -->
<!-- End Why Besa 2-->

<?= $home_why_besa2 ?>


<?= $this->element("choose-place-earth", ['colWidth' => '9', 'redirectUrl' => 'destination']) ?>

<!-- Start testimonials 2-->

<!-- <section class="testimonials2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">TESTIMONIALS</h2>
                <div class="container-videos">
                    <?php

                    if (!empty($testimonials)) :
                        foreach ($testimonials as $key => $testimonial) :

                    ?>
                            <div class="box-video">
                                <video controls poster="<?= $testimonial['video_thumb_path'] ?>">
                                    <source src="<?= $testimonial['video_url'] ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- End testimonials 2-->
<?php //= $this->element("choose-place-earth") 
?>
<?php //= $home_our_partners 
?>
<?php /* ?>

<section class="events have-animations">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="fadeInUp animated-slow">
                    <!-- <h2 class="title">EVENTS</h2> -->
                    <p class="description">We are connected with our beloved students, schools, as well as <br> our partners abroad.</p>
                </div>
                <div class="gridContainer-events">


                    <?php

                    if (!empty($events)) {
                        foreach ($events as $key => $event) {

                    ?>
                            <div class="box fadeInUp">
                                <div class="icon">
                                    <img src="<?= $event['icon_path'] ?>" alt="">
                                </div>
                                <h3 class="titleBx"><?= $event['title'] ?></h3>
                                <p class="descriptionBX">
                                    <?= $event['sub_title'] ?>
                                </p>
                                <a href="/event-details/<?= $event['permalink'] ?>" class="btn MainBtn learn-more">
                                    Learn More
                                    <img src="<?=WEBSITE_URL?>img/icon/arrow-right.svg" alt="">
                                </a>
                            </div>

                    <?php
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>
                </section>
                <?php */ ?>

<!-- <section class="our-services">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Our Services</h2>
                <div class="pana-accordion" id="accordion">
                    <div class="pana-accordion-wrap">

                        <?php

                        if (!empty($services)) {
                            foreach ($services as $key => $service) {

                        ?>
                                <div class="pana-accordion-item">
                                    <img width="500" height="415" src="<?= $service['image_path'] ?>" />
                                    <div class="text-acco">
                                        <h3 class="title-acco"><?= $service['title'] ?></h3>
                                        <a href="<?= Router::url('/service-details/' . $service['permalink']) ?>" class="btn discover-more">Discover More</a>
                                    </div>
                                </div>


                        <?php
                            }
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<?= $this->element('testimonials', ['testimonials' => $testimonials]) ?>

<section class="contact-us">
    <div class="top-dots-img">
        <img src="<?= WEBSITE_URL ?>img/icon/dots-bakground.svg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Need any help?</h2>

            </div>
            <div class="col-md-11 col-md-offset-1">
                <div class="form">
                    <!-- <h3 class="title-form">Reach Us</h3> -->
                    <h3 class="title-form">Drop us a message and one of our Advisot and Study Abroad Experts will respond to you</h3>

                </div>
            </div>
            <div class="col-md-5 col-md-offset-1 ">
                <div class="form">

                    <?= $this->Form->create($enquiry, ['url' => '/enquiries/contactUs', 'id' => 'contactusForm']) ?>

                    <input type="hidden" id="type" name="type" value="home">
                    <!-- <div class="form-area">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="your name">
                    </div>
                    <div class="form-area">
                        <input type="email" id="email" name="email" placeholder="Email Address">
                    </div>
                    <div class="form-area">
                        <textarea id="message" name="message" placeholder="Your Message"></textarea>
                    </div> -->

                    <?php

                    echo $this->Form->control('name', [
                        'placeholder' => 'Your name', 'type' => 'text', 'label' => false,
                        'class' => 'required', 'required' => true,
                        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    ]);


                    // echo $this->Form->control('phone', [
                    //     'placeholder' => 'Your Phone', 'type' => 'text', 'label'=>false,
                    //     'class' => 'required',
                    //     'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    // ]);

                    echo $this->Form->control('email', [
                        'placeholder' => 'Email Address', 'type' => 'email',
                        'class' => 'required', 'label' => false, 'required' => true,
                        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    ]);
                    ?>
                    <?php

                    // echo $this->Form->control('subject', [
                    //     'placeholder' => 'Email subject', 'type' => 'text',
                    //     'class' => 'required', 'label' => false,
                    //     'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    // ]);
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
                <div class="text">
                    <p>
                        <?= $mainBranch['name'] ?>
                        <?php //=$mainBranch['address'].', '.$mainBranch['city'].', '.$mainBranch['state'].', '.$mainBranch['postcode'].', '.$mainBranch['country']
                        ?>
                    </p>
                    <p><?= $mainBranch['phone'] ?></p>
                    <p><?= $mainBranch['email'] ?></p>
                </div>
                <!-- <div class="map">

                    <img src="<?= $mainBranch['location_image_path'] ?>" alt="">
                </div> -->
            </div>

        </div>
    </div>
    <div class="bottom-dots-img">
        <img src="<?= WEBSITE_URL ?>img/icon/dots-bakground.svg" alt="">

    </div>
</section>