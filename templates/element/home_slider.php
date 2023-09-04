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
                                            <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['events.eventdetails']) ?>/<?= $slider['permalink'] ?>" class="btn MainBtn apply-now">
                                                Apply Now
                                                <i aria-hidden="true" class="far fa-arrow-alt-circle-right"></i>
                                            </a>
                                        <?php } ?>


                                        <?php if (isset($slider['right_url']) && !empty($slider['right_url_label'])) { ?>
                                            <a href="<?= $slider['right_url'] ?>" class="btn MainBtn contact-us"><?= $slider['right_url_label'] ?></a>

                                        <?php } else { ?>
                                            <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['enquiries.contactus']) ?>" class="btn MainBtn contact-us">Contact Us</a>

                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="image fadeInDown">
                                    <?php
                                    if (isset($slider['image_path'])) {
                                    ?>
                                        <img <?= !empty($slider['thumb_image_path']) ? 'class="desktop-image"' : '' ?> src="<?= $slider['image_path'] ?>" alt="">
                                        <?= !empty($slider['thumb_image_path']) ? '<img src="' . $slider['thumb_image_path'] . '" class="mobile-image" alt="">' : '' ?>

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