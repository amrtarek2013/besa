<div class="sec-upcoming">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php foreach ($event['fair_events'] as $fairEvent) { ?>
                    <div class="content">

                        <h4 class="location-center">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/location.svg" alt="">
                            <?= $fairEvent['locations'] ?>
                        </h4>
                        <div class="grid-3col">
                            <div class="box date-time">
                                <?= $fairEvent['dates'] ?>
                            </div>

                            <div class="box">
                                <h3>Attending countries</h3>
                                <?php
                                if (!empty($fairEvent['countries'])) {
                                ?>
                                    <div class="step-back-slider small-slider">
                                        <div class="image-gallery">
                                            <?php foreach ($fairEvent['countries'] as $img) { ?>
                                                <div class="image-box" style="display: inline-block; margin: 5px; ">
                                                    <img src="<?= $img['flag_path'] ?>" alt="" style="width: 41.469px;height: 25.613px;">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                        $fairEventImages = $fairEvent['universities'];
                                        $fairEventTitle = "Attending Universities";
                                        $fieldName = 'logo_path';
                                        if ($fairEvent['event_id'] == 4) {

                                            $fairEventTitle = "Sponsored By";
                                        } else if ($fairEvent['event_id'] == 6) {


                                            $fairEventImages = $fairEvent['schools'];
                                            $fairEventTitle = "Schools";

                                            // $fieldName = 'image_path';
                                        }
                                        ?>
                                        <h3><?= $fairEventTitle ?></h3>
                                        <div class="grid-logos">
                                            <?php
                                            if (!empty($fairEventImages)) {

                                                foreach ($fairEventImages as $img) {
                                            ?>
                                                    <img src="<?= $img[$fieldName] ?>" alt="">

                                            <?php }
                                            }
                                            ?>
                                            <?php /* <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                            <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                            <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                            <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                            <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt=""> */ ?>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                    <a class="btn btn-register MainBtn" href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['enquiries.visitorsapplication'] . '?location=' . strtolower($fairEvent['title'])) ?>">Register Now</a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>