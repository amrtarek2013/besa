<?php if (!empty($testimonials)) { ?>
    <section class="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title"><?= isset($testiTitle) ? $testiTitle : "Students' Testimonials" ?></h2>
                    <div class="owl-blogs">
                        <div id="wrap2">
                            <div class="carousel-wrap">
                                <ul class="carousel carousel-testimonials" >
                                    <?php 
                                    $counter = 1;
                                    foreach ($testimonials as $testimonial) {
                                        // Assign a class based on the counter
                                        $positionClass = '';
                                        switch ($counter) {
                                            case 1:
                                                $positionClass = 'left-pos';
                                                break;
                                            case 2:
                                                $positionClass = 'main-pos';
                                                break;
                                            case 3:
                                                $positionClass = 'right-pos';
                                                break;
                                            case 4:
                                                $positionClass = 'back-pos';
                                                break;
                                            default:
                                                $positionClass = 'back-pos';
                                                break;
                                        }
                                    ?>
                                    <li class="items <?= $positionClass ?>" id="<?= $counter ?>">
                                        <div class="card">
                                            <div class="personal-data">
                                                <div class="circle-img">
                                                    <img src="<?= $testimonial['image_path'] ?>" width="" alt="" loading="lazy">
                                                </div>
                                                <div class="text">
                                                    <p><?= $testimonial['client_name'] ?></p>
                                                    <p><?= $testimonial['university'] ?></p>
                                                </div>
                                            </div>
                                            <p class="description">
                                                <?= $testimonial['text'] ?>
                                                <p></p>
                                            </p>
                                        </div>
                                    </li>
                                    <?php 
                                        $counter++;
                                        // Reset counter to loop through classes again
                                        if ($counter > 5) {
                                            $counter = 1;
                                        }
                                    }
                                    ?>                    
                                </ul>
                                <span class="slider">
                                <a href="javascript:void(0);" value="Prev" id="prev"><img src="<?= WEBSITE_URL ?>img/new-desgin/prev-arrow-white.svg"></a>
                                <a href="javascript:void(0);" value="Next" id="next"><img src='<?= WEBSITE_URL ?>img/new-desgin/next-arrow-white.svg'></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>