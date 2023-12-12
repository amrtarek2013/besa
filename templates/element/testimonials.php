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
                    <div class="owl-blogs">
                        <div id="wrap">
                            <div class="carousel-wrap">
                                <ul class="carousel carousel-testimonials" >
                                    <li class="items left-pos" id="1">
                                        <div class="card">
                                            <h4 class="title">
                                                <a href="#" class="read-anchor">Subject Depth for Diverse Dreams</a>
                                            </h4>
                                            <p class="description">
                                                Your IGCSE qualification is your ticket to global recognition. With IGCSE, 
                                                you're equipped with an internationally accepted qualification that's recognized by 
                                                top universities in the UK and abroad.
                                            </p>
                                        </div>
                                    </li>

                                    <li class="items main-pos " id="2">
                                        <h4 class="title">
                                                <a href="#" class="read-anchor">Global Recognition with a Local Touch</a>
                                            </h4>
                                            <p class="description">
                                                Your IGCSE qualification is your ticket to global recognition. With IGCSE, 
                                                you're equipped with an internationally accepted qualification that's recognized by 
                                                top universities in the UK and abroad.
                                            </p>
                                    </li>
                                    <li class="items right-pos" id="3">
                                        <div class="card">
                                            <h4 class="title">
                                                <a href="#" class="read-anchor">Language Proficiency and Cultural Empowerment</a>
                                            </h4>
                                            <p class="description">
                                                Your IGCSE qualification is your ticket to global recognition. With IGCSE, 
                                                you're equipped with an internationally accepted qualification that's recognized by 
                                                top universities in the UK and abroad.
                                            </p>
                                        </div>
                                        
                                    </li>
                                    <li class="items back-pos" id="4">
                                        <div class="card">
                                            <h4 class="title">
                                                <a href="#" class="read-anchor">Language Proficiency and Cultural Empowerment</a>
                                            </h4>
                                            <p class="description">
                                                Your IGCSE qualification is your ticket to global recognition. With IGCSE, 
                                                you're equipped with an internationally accepted qualification that's recognized by 
                                                top universities in the UK and abroad.
                                            </p>
                                        </div>
                                        
                                    </li>
                                    
                                </ul>
                                <span class="slider">
                                <a href="javascript:void(0);" value="Prev" id="prev"><img src="<?= WEBSITE_URL ?>img/new-desgin/prev-arrow.svg"></a>
                                <a href="javascript:void(0);" value="Next" id="next"><img src='<?= WEBSITE_URL ?>img/new-desgin/next-arrow.svg'></a>
                                </span>
                             </div>
                        </div>
                          

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>