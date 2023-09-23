<?php
// $image_path = 'uploads' . DS . 'events' . DS . $event['image'];
// debug(WWW_ROOT . $image_path);
// debug($event);

// debug(file_exists(WWW_ROOT . $image_path));

use Cake\Routing\Router;

?>
<section class="main-banner british-banner fair-banner <?= $event['style'] ?>" style="padding-bottom:0 !important;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= $event['main_image_path'] ?>" alt="" style="z-index: 2;" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">

                    <?php $tt = explode(' ', trim($event['title'])) ?>
                    <h1 class="relative-text"><?= substr($tt[0], 0, 6) ?></h1>
                    <h2 class="title text-left"><?= $event['title'] ?></h2>
                    <?php
                    /*if (!isset($event['style'])) {
                    ?>
                        <p class="relative-textP">
                            <?= $event['text'] ?>
                        </p>
                    <?php } else { ?>

                        <?= $event['text'] ?>
                    <?php }*/ ?>

                </div>
            </div>
        </div>

        <?php
        if (isset($event['style']) && $event['style'] == 1) {
        ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="text text-radius" style="<?= !empty($event['font_color']) ? 'color:' . $event['font_color'] : '' ?><?= !empty($event['background_color']) ? ';background-color:' . $event['background_color'] : '' ?>">
                        <p class="descrp">
                            <?= $event['center_text'] ?>
                        </p>

                    </div>
                </div>


            </div>

    </div>

<?php } else { ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="padding: 0;">
                <div class="title-banner-blue " style="<?= !empty($event['font_color']) ? 'color:' . $event['font_color'] : '' ?><?= !empty($event['background_color']) ? ';background-color:' . $event['background_color'] : '' ?>">
                    <?= $event['center_text'] ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
/*if (isset($event['style'])) {
                ?>
                    <div class="col-md-6">
                        <div class="text ">
                            <?= $event['right_text'] ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-gray">

                            <?= $event['center_text'] ?>
                        </div>
                    </div>
                <?php } */ ?>
</section>

<?php //if (isset($_GET['test'])) { 
?>
<?php
if (!empty($event['left_text']) && $event['id'] == 7 && !empty($event['fair_events'])) {
    echo $event['left_text'];


    if (isset($_GET['test'])) {
?>

        <style>
            .small-slider .owl-carousel.owl-drag .owl-item .item {
                max-width: 63px !important;
            }

            .small-slider .owl-item,
            .small-slider .image-box img {
                max-width: 63px !important;
            }

            .small-slider {
                padding: 0 !important;
                background: transparent;
                border-radius: 20px;
            }



            .step-back-slider.flags-slider .image-box,
            .step-back-slider.flags-slider .image-box img {

                max-width: 120px;
                /* height: 120px; */
                border-radius: 50%;
                border: none;
            }

            @media (min-width: 1200px) {

                .logos-slider .container,
                .flags-slider .container {
                    width: 1000px;
                }

                .small-slider .container {
                    width: 328px;
                    padding: 0;
                    margin: 0;

                }
            }

            .small-slider .owl-nav img {
                width: 20px !important;
            }

            .owl-carousel .owl-dots.disabled {
                display: none !important;
            }

            .small-slider .owl-prev {
                left: -35px;
            }

            .small-slider .owl-next {
                right: -35px;
            }

            .step-back-slider.logos-slider .image-box,
            .step-back-slider.logos-slider .image-box img {

                /* max-width: 120px; */
                /* border-radius: 50%; */
                border: none;
                max-height: 180px !important;
            }

            /* .step-back-slider.logos-slider .owl-nav img {
            width: 20px !important;
        } */


            .step-back-slider.logos-slider {

                background: transparent;
                padding: 0;
                /* border-radius: 20px; */
            }

            .step-back-slider.logos-slider .title_28 {
                color: #2575FC;
                font-family: "Poppins";
                font-size: 24px;
                font-style: normal;
                font-weight: 400;
                line-height: 35px;
            }

            .step-back-slider.logos-slider .slider {
                background: var(--bs-main);
                padding: 20px 0;
                border-radius: 29px;
            }
        </style>
        <div class="sec-upcoming">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php foreach ($event['fair_events'] as $fairEvent) { ?>
                            <div class="content">
                                <div class="grid-3col">
                                    <div class="box">
                                        <h3><span style="font-size:28px;"><strong><?= $fairEvent['title'] ?></strong></span><br />
                                            <br />
                                            Where
                                        </h3>

                                        <p><?= $fairEvent['locations'] ?></p>
                                    </div>

                                    <div class="box">
                                        <h3><br />
                                            <br />
                                            When
                                        </h3>

                                        <?= $fairEvent['dates'] ?>
                                    </div>
                                    <?php
                                    //if (false) { 
                                    ?>
                                    <div class="box">
                                        <h3><br />
                                            <br />
                                            Attending countries
                                        </h3>


                                        <?php
                                        if (!empty($fairEvent['countries'])) {
                                        ?>
                                            <div class="step-back-slider small-slider">
                                                <div class="container" style="width: 300px !important;">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <!-- <h2 class="title_28">Step Back in Time: Our Unforgettable Fair Memories!</h2> -->

                                                            <div class="slider">
                                                                <div class="owl-carousel owl-small-flag-logo">
                                                                    <?php

                                                                    foreach ($fairEvent['countries'] as $img) {
                                                                    ?>
                                                                        <div class="item">
                                                                            <div class="image-box" style="border:unset; border-radius: unset; height:63px">
                                                                                <img src="<?= $img['flag_path'] ?>" alt="" style="border-radius:50%;height: 63px;width: 63px; ">
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>
                                        <br /><br />

                                    </div>
                                </div>

                                <?php
                                if (!empty($fairEvent['universities'])) {
                                ?>
                                    <div class=" step-back-slider logos-slider">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h2 class="title_28">Attending Universities</h2>

                                                    <div class="slider">
                                                        <div class="owl-carousel owl-small-flag-logo">
                                                            <?php

                                                            foreach ($fairEvent['universities'] as $img) {
                                                            ?>
                                                                <div class="item">
                                                                    <div class="image-box">
                                                                        <img src="<?= $img['logo_path'] ?>" alt="">
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                                <br /><br />
                            </div>
                            <a class="btn btn-register" href="<?= Router::url('/education-fair/ief-form?location=' . strtolower($fairEvent['title'])) ?>">Register Now</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


<?php
    }
}

if (!empty($event['event_images'])) {
    // echo $this->element('event-slider', ['event_images' => $event['event_images']]);
}
?>
<?php //} 
?>
<?= $event['text'] ?>

<?= $this->element('BecomeSponsorPopUp') ?>