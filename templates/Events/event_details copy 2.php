<?php
// $image_path = 'uploads' . DS . 'events' . DS . $event['image'];
// debug(WWW_ROOT . $image_path);
// debug($event);

// debug(file_exists(WWW_ROOT . $image_path));
?>
<section class="main-banner british-banner fair-banner <?= $event['style'] ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= $event['image_path'] ?>" alt="" style="z-index: 2;" width="">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">

                    <?php $tt = explode(' ', trim($event['title'])) ?>
                    <h1 class="relative-text"><?= substr($tt[0], 0, 6) ?></h1>
                    <h2 class="title text-left"><?= $event['title'] ?></h2>
                    <?php
                    if (!isset($event['style'])) {
                    ?>
                        <p class="relative-textP">
                            <?= $event['text'] ?>
                        </p>
                    <?php } else { ?>

                        <?= $event['text'] ?>
                    <?php } ?>

                </div>
            </div>
        </div>
        <div class="row">
            <?php
            if (!isset($event['style'])) {
            ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="text text-radius">
                            <p class="descrp">
                                <?= $event['center_text'] ?>
                            </p>

                        </div>
                    </div>


                </div>

            <?php } else { ?>

                <!-- <div class="col-md-6">
                    <div class="text text-radius">
                        <?= $event['left_text'] ?>
                    </div>
                </div> -->
            <?php } ?>

            <?php
            if (isset($event['style'])) {
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
            <?php } ?>
        </div>
    </div>
</section>

<section class="youtube-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridContainerYoutube">
                    <div class="video">
                        <?php
                        $event['video'] = !empty($event['video']) ? $event['video'] : 'https://www.youtube.com/v/D0UnqGm_miAF';
                        ?>
                        <object width="767" height="432" data="<?= $event['video'] ?>" type="application/x-shockwave-flash">
                            <param name="src" value="<?= $event['video'] ?>" />
                        </object>
                        <!-- <video controls poster="<?= $event['video_thumb_path'] ?>" width="100%">
                            <source src="<?= $event['video'] ?>">
                            Your browser does not support the video tag.
                        </video> -->
                    </div>
                    <div class="text">

                        <?= $event['video_right_text'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (sizeof($eventImages) > 0) : ?>
    <section class="slider-photoGalley">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title-photoGalley">Photo Galley</h2>
                </div>
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme photoGalley-slider">
                        <?php
                        foreach ($eventImages as $eventImage) {
                        ?>
                            <div class="item">
                                <div class="image">
                                    <img src="<?= $eventImage['image_path'] ?>" alt="<?= $eventImage['title'] ?>">
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="tabes british-tabes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title" style="color: #fff;">To know more about <?= $event['title'] ?>, guidelines and <br> registration, contact our office for more details.</h3>
                <div class="gridTabes">
                    <a href="#" class="btn clear-blue foundation">Event Subscription</a>
                    <a href="#" class="btn greenish-teal master">Become a Sponsor</a>

                </div>
            </div>
        </div>
    </div>
</section>