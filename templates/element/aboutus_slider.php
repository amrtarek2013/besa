<?php if (!empty($aboutusSlidersList)) { ?>
    <section class="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title"><?= isset($testiTitle) ? $testiTitle : "Students' Testimonials" ?></h2>
                    <div class="slider-testimonials owl-carousel owl-theme" id="slider-testimonials">

                        <?php


                        foreach ($aboutusSlidersList as $aboutSlider) {

                        ?>
                            <div class="item">
                                <div data-time="<?= $aboutSlider['year'] ?>">
                                    <div class="container-item-data">
                                        <div class="text">
                                            <h4 class="title"><?= $aboutSlider['title'] ?></h4>
                                            <p class="descrp"><?= $aboutSlider['short_description'] ?></p>

                                        </div>
                                        <div class="image">
                                            <img src="<?= $aboutSlider['image_path'] ?>" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php

                        } ?>

                    </div>

                </div>
            </div>
        </div>
    </section>
<?php } ?>