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
                        Education isn’t just about academics — it’s about inspiring curiosity and exploration!
                        Join us for BESA's Events to learn, grow, and take home the competitions Trophy.
                    </p>
                </div>
            </div>
        </div>
    </div>

</section>


<section class="tournament">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="double_img">
                    <img src="./img/football-tr (2).png" alt="">
                    <img src="./img/football-tr (1).png" alt="" class="relative-img-border">
                </div>
            </div>
            <div class="col-md-6">
                <div class="text">
                    <h3>The British Trophy</h3>
                    <p>The British Trophy is a football tournament that is organized by BESA between international schools in Egypt since 2014. The tournament is run over 4 days between schools, where a team from each school; whether IGCSE, American Diploma, International Baccalaureate, .....</p>
                    <a href="" class="btn discover-more">Discover More</a>

                </div>
            </div>

        </div>
    </div>
</section>
<?php

use Cake\Routing\Router;

if (!empty($events)) {
    foreach ($events as $key => $event) {


?>
        <section class="linear-gradientSec background-blue" style="background:<?= $event['background_color'] ?> !important; background-image:url('<?= $event['image_path'] ?>')  !important;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-7  col-xs-12">
                        <div class="text">
                            <h3 class="title"><?= $event['title'] ?></h3>
                            <p class="descrp">
                                <?= $event['text'] ?>
                            </p>
                            <a href="<?= Router::url('/event-details/') . $event['permalink'] ?>" class="btn discover-more">Discover More</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12"></div>
                </div>
            </div>
        </section>
<?php
    }
} ?>