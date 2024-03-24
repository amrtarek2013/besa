<div class="hero-section hero-events">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-events.png" alt="hero about us">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Events</h1>
        </div>
    </div>

</div>

<section class="bottom-hero-section bottom-events ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-bottom-hero">
                    <p>
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
                <div class="col-md-12">
                    <?php foreach ($eventsList as $event) :


                    ?>
                        <div class="d-flex container-events">
                            <div class="double_img">
                                <?php if (!empty($event['image_path'])) : ?>
                                    <img class="" src="<?= $event['image_path'] ?>" alt="">
                                    <img src="<?= $event['image2_path'] ?>" alt="" class="relative-img-border">
                                <?php else : ?>
                                    <img src="<?= WEBSITE_URL ?>img/new-desgin\dummy_image/500x350.png" alt="">
                                    <img src="<?= WEBSITE_URL ?>img/new-desgin\dummy_image/250x200.png" alt="" class="relative-img-border">
                                <?php endif; ?>
                            </div>
                            <div class="text">
                                <h3><?= $event['title'] ?></h3>
                                <p><?= $event['sub_title'] ?></p>
                                <div class="timline-eve">
                                    <?php

                                    $event['right_text'] = trim($event['right_text']);
                                    $arr = explode("\n", $event['right_text']);



                                    if (!empty($arr))
                                        foreach ($arr as $key => $item) {
                                            $item = trim($item);

                                            if ($key === array_key_last($arr)) {
                                                echo " <div class='item'>
                                                <img src='/img/new-desgin/timer.svg' alt=''>
                                                 <p> $item</p>
                                            </div>";
                                            } else {
                                                echo " <div class='item'>
                                                <img src='/img/new-desgin/timer.svg' alt=''>
                                                <img src=' /img/new-desgin/line-timline.svg' alt='' class='line-timer'>
                                                <p> $item</p>
                                            </div>";
                                            }
                                        }

                                    ?></p>



                                </div>
                                <a href="/event-details/<?= $event['permalink'] ?>" class="btn discover-more MainBtn">Discover More</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>




<?php
    // }
} ?>