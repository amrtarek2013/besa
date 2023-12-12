<?php if (!empty($testimonials)) { ?>
    <section class="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title"><?= isset($testiTitle) ? $testiTitle : "Students' Testimonials" ?></h2>
                    <div class="slider-testimonials owl-carousel owl-theme" id="slider-testimonials">

                        <?php

                        if (!empty($testimonials)) {
                            foreach ($testimonials as $key => $testimonial) {

                        ?>
                                <div class="item">
                                    <p class="description">
                                        <?= $testimonial['text'] ?>
                                    </p>
                                    <div class="personal-data">
                                        <div class="circle-img">
                                            <img src="<?= $testimonial['image_path'] ?>" width="" alt="" loading="lazy">
                                        </div>
                                        <div class="text">
                                            <p><?= $testimonial['client_name'] ?></p>
                                            <p><?= $testimonial['university'] ?></p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } ?>

                    </div>
                    
                </div>
            </div>
        </div>
    </section>
<?php } ?>