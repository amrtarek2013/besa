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

<?php //if (isset($_GET['test'])) { 
?>
<?php
if (!empty($event['left_text']) && $event['id'] == 7) {
    echo $event['left_text'];
?>

    <!-- <div class="sec-upcoming">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h4>Upcoming</h4>

                    <h5>BESA Study Abroad Expo in Egypt</h5>

                    <p>Engage with university from diverse countries to learn more about study abroad inquiries, including admission requirements, partial scholarships, and registration steps from A to Z!</p>

                    <p>Entry is free! Join us and pave the way for your international education!</p>
                </div>

                <div class="col-md-4">
                    <div class="image"><img alt="" loading="lazy" src="/img/Expo.png" /></div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="sec-upcoming">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <div class="grid-3col">
                            <div class="box">
                                <h3><span style="font-size:28px;"><strong>Cairo&nbsp;</strong></span><br />
                                    <br />
                                    Where
                                </h3>

                                <p>Dusit Thani Lakeview, El-Tessen street, New Cairo,</p>
                            </div>

                            <div class="box">
                                <h3><br />
                                    <br />
                                    When
                                </h3>

                                <p>28th September&nbsp;2023:&nbsp;10:30 AM- 01:30 PM, 4:00 PM - 8:00 PM<br />
                                    29th September 2023:&nbsp;4:00 PM - 8:00 PM</p>
                            </div>

                            <div class="box">
                                <h3><br />
                                    <br />
                                    Attending countries
                                </h3>

                                <div class="country d-flex"><img alt="" src="/webroot/filebrowser/upload/images/Untitled%20%2871%20x%2063%20px%29%20%281%29.png" style="width: 71px; height: 63px;" /> <img alt="" src="/webroot/filebrowser/upload/images/Untitled%20%2871%20x%2063%20px%29%20%282%29.png" style="width: 71px; height: 63px;" /> <img alt="" src="/webroot/filebrowser/upload/images/Untitled%20%2871%20x%2063%20px%29%20%283%29.png" style="width: 71px; height: 63px;" /> <img alt="" src="/img/hungary_glossy_round_icon_256.png" /> <img alt="" src="/img/canada_glossy_round_icon_640.png" /></div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-register" href="https://besaeg.com/education-fair/ief-form?location=cairo">Register Now</a>

                    <div class="content">
                        <div class="grid-3col">
                            <div class="box">
                                <h3><span style="font-size:28px;"><strong>Alexandria&nbsp;</strong></span><br />
                                    <br />
                                    Where
                                </h3>

                                <p>Hilton Corniche,&nbsp;El Geish Road, Sidi Bishr, Alexandria</p>
                            </div>

                            <div class="box">
                                <h3><br />
                                    <br />
                                    When
                                </h3>

                                <p>October 1st&nbsp;2023:&nbsp;10:00 AM- 01:30 PM, 4:00 PM - 8:00 PM</p>
                            </div>

                            <div class="box">
                                <h3><br />
                                    <br />
                                    Attending countries
                                </h3>

                                <div class="country d-flex"><img alt="" src="/webroot/filebrowser/upload/images/Untitled%20%2871%20x%2063%20px%29%20%281%29.png" style="width: 71px; height: 63px;" /> <img alt="" src="/webroot/filebrowser/upload/images/Untitled%20%2871%20x%2063%20px%29%20%282%29.png" style="width: 71px; height: 63px;" /> <img alt="" src="/webroot/filebrowser/upload/images/Untitled%20%2871%20x%2063%20px%29%20%283%29.png" style="width: 71px; height: 63px;" /> <img alt="" src="/img/hungary_glossy_round_icon_256.png" /> <img alt="" src="/img/canada_glossy_round_icon_640.png" /></div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-register" href="https://besaeg.com/education-fair/ief-form?location=alexandria">Register Now</a>
                </div>
            </div>
        </div>
    </div>


<?php
    echo $this->element('event-slider', ['event_images' => $event['event_images']]);
}
?>
<?php //} 
?>
<?= $event['text'] ?>

<?= $this->element('BecomeSponsorPopUp') ?>