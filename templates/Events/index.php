<section class="main-banner events-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg7.png" alt="" style="z-index: 2;" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
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

if (!empty($eventsList)) {
    $eventsList = $eventsList->toArray();
    // foreach ($eventsList as $key => $event) {

?>


    <section class="tournament">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="double_img">
                        <!-- <img src="./img/football-tr (2).png" alt="">
                        <img src="./img/football-tr (1).png" alt="" class="relative-img-border"> -->
                        <?php

                        if (!empty($eventsList[0]['image_path'])) {
                        ?>
                            <div class="circle-img ">
                                <img class="circle-img " src="<?= $eventsList[0]['image_path'] ?>" alt="" style="width: 367px;height: 367px;">

                            </div>
                            <div class="circle-img">
                                <img src="<?= $eventsList[0]['image2_path'] ?>" alt="" class="circle-img relative-img-border">

                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="circle-img ">
                                <img src="<?= WEBSITE_URL ?>img/portrait-of-female-university-student-working-in-PWV893Q-1200W-1 2.png" alt="" style="width: 367px;height: 367px;">
                            </div>
                            <div class="circle-img">
                                <img src="<?= WEBSITE_URL ?>img/football-tr (1).png" alt="" class="circle-img relative-img-border">
                            </div>

                        <?php


                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text">
                        <h3><?= $eventsList[0]['title'] ?></h3>
                        <p><?= $eventsList[0]['sub_title'] ?>, .....</p>
                        <a href="/event-details/<?= $eventsList[0]['permalink'] ?>" class="btn discover-more">Discover More</a>

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
                        <?php if (isset($eventsList[1])) { ?>
                            <div class="left-box">
                                <div class="double_img">
                                    <?php

                                    if (!empty($eventsList[1]['image_path'])) {
                                    ?>
                                        <img src="<?= $eventsList[1]['image_path'] ?>" alt="" style="width: 382px;height: 323px;">
                                        <img src="<?= $eventsList[1]['image2_path'] ?>" alt="" class="img-rel" style="width: 238px;height: 210px;">
                                    <?php
                                    } else {
                                    ?>

                                        <img src="<?= WEBSITE_URL ?>img/International_Education_Fair.png" alt="" style="width: 382px;height: 323px;">
                                        <img src="<?= WEBSITE_URL ?>img/International_Education_Fair_border.png" alt="" class="img-rel" style="width: 238px;height: 210px;">
                                    <?php


                                    }
                                    ?>
                                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="dots-rel">
                                </div>
                                <div class="text">
                                    <h3><?= $eventsList[1]['title'] ?></h3>
                                    <p><?= $eventsList[1]['sub_title'] ?>, .....</p>
                                    <a href="/event-details/<?= $eventsList[1]['permalink'] ?>" class="btn discover-more">Discover More</a>
                                </div>
                            </div>

                        <?php } ?>
                        <div class="vertical-line-ellipse">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>

                        </div>

                        <?php if (isset($eventsList[2])) { ?>
                            <div class="right-box">
                                <div class="double_img">
                                    <?php

                                    if (!empty($eventsList[2]['image_path'])) {
                                    ?>
                                        <img src="<?= $eventsList[2]['image_path'] ?>" alt="">
                                        <img src="<?= $eventsList[2]['image2_path'] ?>" alt="" class="img-rel">
                                    <?php
                                    } else {
                                    ?>
                                        <img src="<?= WEBSITE_URL ?>img/Studying_Abroad.png" alt="">
                                        <img src="<?= WEBSITE_URL ?>img/Studying_Abroad_border.png" alt="" class="img-rel">
                                    <?php
                                    }
                                    ?>
                                    <img src="<?= WEBSITE_URL ?>img/small-dots.png" alt="" class="dots-rel">
                                </div>
                                <div class="text">
                                    <h3><?= $eventsList[2]['title'] ?></h3>
                                    <p><?= $eventsList[2]['sub_title'] ?>, .....</p>
                                    <a href="/event-details/<?= $eventsList[2]['permalink'] ?>" class="btn discover-more">Discover More</a>
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