<?php
// $image_path = 'uploads' . DS . 'events' . DS . $event['image'];
// debug(WWW_ROOT . $image_path);
// debug($event);

// debug(file_exists(WWW_ROOT . $image_path));

use Cake\Routing\Router;

?>

<div class="hero-section hero-education-fair">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-education-fair.png" alt="hero about us">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">International <span>Education Fair</span> </h1>
        </div>
    </div>

</div>

<section class="bottom-hero-section bottom-education-fair ">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="">
                <div class="title-bottom-hero">
                    <?= $event['center_text'] ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(false) { ?>
<div class="sec-upcoming">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>Upcoming</h4>
                <h5>BESA Study Abroad Expo in Egypt</h5>
                <div class="text">
                    <p>Engage with university from diverse countries to learn more about study abroad  <br> 
                        inquiries, including admission requirements, partial scholarships, and registration <br>  
                        steps from A to Z!
                    </p>
                    <p style="font-weight: 500; font-size: 32px; margin-top:170px; color: #263238" > 
                        <span style="color: var(--text-color)">Entry is free!</span> 
                        Join us and pave the way <br> 
                        for your international education!
                    </p>
                </div>
            </div>
         
        </div>
    </div>
</div>
<?php }?>




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


    // if (isset($_GET['test'])) {
?>


    <div class="sec-upcoming" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php foreach ($event['fair_events'] as $fairEvent) { ?>
                        <div class="content">
                            <h3 style=""><?php// $fairEvent['title'] ?></h3>
                            <h4 class="location-center">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/location.svg" alt="">
                                 <?= $fairEvent['locations'] ?></h4>
                            <div class="grid-3col">                            
                                <div class="box date-time">
                                    <?= $fairEvent['dates'] ?>
                                </div>
                                <?php
                                //if (false) { 
                                ?>
                                <div class="box">
                                    <h3>Attending countries</h3>


                                    <?php
                                    if (!empty($fairEvent['countries'])) {
                                    ?>
                                        <div class="step-back-slider small-slider">
                                            <div class="image-gallery">
                                                <?php foreach ($fairEvent['countries'] as $img) { ?>
                                                    <div class="image-box" style="display: inline-block; margin: 5px; border: unset; border-radius: unset; height: 63px;">
                                                        <img src="<?= $img['flag_path'] ?>" alt="" style="width: 41.469px;height: 25.613px;">
                                                    </div>
                                                <?php } ?>
                                                <h3>Attending countries</h3>
                                                <div class="grid-logos">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">

                                                </div>

                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>


                                </div>
                            </div>

                            <?php
                            if (!empty($fairEvent['universities'])) {
                            ?>
                                <div class=" step-back-slider logos-slider logo-slider-large">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="title_28">Attending Universities</h2>

                                                <div class="slider">
                                                    <div class="owl-carousel owl-logos-slider">
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

                        </div>
                        <a class="btn btn-register MainBtn" href="<?= Router::url('/education-fair/ief-form?location=' . strtolower($fairEvent['title'])) ?>">Register Now</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


<?php
}
// }

if (!empty($event['event_images'])) {
    echo $this->element('event-slider', ['slider_title' => $event['slider_title'], 'event_images' => $event['event_images']]);
}
?>
<?php //} 
?>
<?= $event['text'] ?>

<?= $this->element('BecomeSponsorPopUp') ?>