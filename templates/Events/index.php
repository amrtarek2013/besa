<section class="main-banner events-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="/img/hero-bg7.png" alt="" style="z-index: 2;">
                    <img src="/img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Events</h1>
                    <h2 class="title text-left">Events</h2>
                    <p class="relative-textP">
                        <?= $events_page_text ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</section>

<?php

use Cake\Routing\Router;

if (!empty($events)) {
    $events = $events->toArray();
    // foreach ($events as $key => $event) {

?>


    <section class="tournament">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="double_img">
                        <!-- <img src="./img/football-tr (2).png" alt="">
                        <img src="./img/football-tr (1).png" alt="" class="relative-img-border"> -->
                        <?php

                        if (!empty($events[0]['event_images']) && sizeof($events[0]['event_images']) >= 2) {
                        ?>
                            <div class="circle-img ">
                                <img src="<?= $events[0]['event_images'][0]['image_path'] ?>" alt="">

                            </div>
                            <div class="circle-img relative-img-border">
                                <img src="<?= $events[0]['event_images'][1]['image_path'] ?>" alt="" class="">

                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="circle-img ">
                                <img src="/img/football-tr (2).png" alt="">
                            </div>
                            <div class="circle-img relative-img-border">
                                <img src="/img/football-tr (1).png" alt="" class="">
                            </div>

                        <?php


                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text">
                        <h3><?= $events[0]['title'] ?></h3>
                        <p><?= $events[0]['sub_title'] ?>, .....</p>
                        <a href="/event-details/<?= $events[0]['permalink'] ?>" class="btn discover-more">Discover More</a>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="important-events">
        <div class="container">
            <div class="row">
                <div class="col-md 12">
                    <div class="container-events">
                        <?php if (isset($events[1])) { ?>
                            <div class="left-box">
                                <div class="double_img">
                                    <?php

                                    if (!empty($events[1]['event_images']) && sizeof($events[1]['event_images']) >= 2) {
                                    ?>
                                        <img src="<?= $events[1]['event_images'][0]['image_path'] ?>" alt="" style="width: 382px;height: 323px;">
                                        <img src="<?= $events[1]['event_images'][1]['image_path'] ?>" alt="" class="img-rel"style="width: 238px;height: 210px;">
                                    <?php
                                    } else {
                                    ?>

                                        <img src="/img/International_Education_Fair.png" alt="" style="width: 382px;height: 323px;">
                                        <img src="/img/International_Education_Fair_border.png" alt="" class="img-rel" style="width: 238px;height: 210px;">
                                    <?php


                                    }
                                    ?>
                                    <img src="/img/dots-153.png" alt="" class="dots-rel">
                                </div>
                                <div class="text">
                                    <h3><?= $events[1]['title'] ?></h3>
                                    <p><?= $events[1]['sub_title'] ?>, .....</p>
                                    <a href="/event-details/<?= $events[1]['permalink'] ?>" class="btn discover-more">Discover More</a>
                                </div>
                            </div>

                        <?php } ?>
                        <div class="vertical-line-ellipse">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>

                        </div>

                        <?php if (isset($events[2])) { ?>
                            <div class="right-box">
                                <div class="double_img">
                                    <?php

                                    if (!empty($events[2]['event_images']) && sizeof($events[2]['event_images']) >= 2) {
                                    ?>
                                        <img src="<?= $events[2]['event_images'][0]['image_path'] ?>" alt="">
                                        <img src="<?= $events[2]['event_images'][1]['image_path'] ?>" alt="" class="img-rel">
                                    <?php
                                    } else {
                                    ?>
                                        <img src="/img/Studying_Abroad.png" alt="">
                                        <img src="/img/Studying_Abroad_border.png" alt="" class="img-rel">
                                    <?php
                                    }
                                    ?>
                                    <img src="/img/small-dots.png" alt="" class="dots-rel">
                                </div>
                                <div class="text">
                                    <h3><?= $events[2]['title'] ?></h3>
                                    <p><?= $events[2]['sub_title'] ?>, .....</p>
                                    <a href="/event-details/<?= $events[2]['permalink'] ?>" class="btn discover-more">Discover More</a>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    // }
} ?>