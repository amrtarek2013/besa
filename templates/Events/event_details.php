<?php
// $image_path = 'uploads' . DS . 'events' . DS . $event['image'];
// debug(WWW_ROOT . $image_path);
// debug($event);

// debug(file_exists(WWW_ROOT . $image_path));
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

<div class="sec-upcoming">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h4>Upcoming </h4>
                <h5>IDP Study Abroad Expo in Egypt</h5>
                <p>Meet the experts from the top universities and ask them about your study options, their admission requirements, tuition fees, partial scholarships, how to register and more. Attend IDP Study Abroad Expo for FREE.</p>
            </div>
            <div class="col-md-4">
                <div class="image">
                    <img src="./img/Expo.png" alt="" loading="lazy">
                </div>
            </div>
            <div class="col-md-12">
                <div class="content">
                    <div class="grid-3col">
                        <div class="box">
                            <h3>Where</h3>
                            <p>
                            Tolip El Narges - 5th Settlement, New Cairo - <br>
                            Cinderella Ballroom, Cairo, Egypt.
                            </p>
                        </div>
                        <div class="box">
                            <h3>When</h3>
                            <p>16th Oct 2023   03:00 PM - 09:00 PM</p>
                        </div>
                        <div class="box">
                            <h3>Attending countries</h3>
                            <div class="country d-flex">
                                <img src="./img/australia_glossy_round_icon_640.png" alt="">
                                <img src="./img/united_states_of_america_glossy_round_icon_640.png" alt="">
                                <img src="./img/lithuania_glossy_round_icon_640.png" alt="">
                                <img src="./img/hungary_glossy_round_icon_256.png" alt="">
                                <img src="./img/canada_glossy_round_icon_640.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-register">Register Now</a>
            </div>
        </div>
    </div>
</div> 
<?= $event['text'] ?>

<?= $this->element('BecomeSponsorPopUp') ?>

