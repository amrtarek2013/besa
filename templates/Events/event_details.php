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

<?php if (isset($_GET['test'])) { ?>
    <?php
    if (!empty($event['left_text']))
        echo $event['left_text'];
    if (!empty($event['event_images']) && $event['id'] == 7)
        echo $this->element('event-slider', ['event_images' => $event['event_images']]);
    ?>
<?php } ?>
<?= $event['text'] ?>

<?= $this->element('BecomeSponsorPopUp') ?>