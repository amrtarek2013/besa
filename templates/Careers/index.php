<div class="hero-section hero-careers">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-careers.png" alt="hero careers ">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Careers </h1>
        </div>
    </div>

</div>
<section class="besa-careers-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Join our BESA team</h2>
                <p>and empower students around the world</p>
                <?php if (!empty($careers)) : ?>
                        <?php $counter = 0; ?>
                    <div class="job-cards">
                        <?php foreach ($careers as $career) : ?>
                            <div class="job-card">
                                <h3><?= $career['title'] ?></h3>
                                <p><?= $career['country'] ?> - <?= $career['state'] ?></p>
                                <a href="<?= Cake\Routing\Router::url('/career-details/' . $career['permalink'] . '/' . $career['id'].'/1') ?>" class="btn btn-primary">Learn More</a>
                                <?php
                                    if (false) { ?>
                                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['pages.careerapply'] . '/' .  $career['id'] . '/' . $career['title']) ?>" class="btn btn-primary">Apply Now</a>
                                    <?php } ?>
                            </div>
                        <?php endforeach; ?>

                    
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="career-opportunity-section">
                <div class="opportunity-image">
                    <img src="https://dummyimage.com/1024x1024/d9d9d9/000000.png" alt="Happy person holding a book">
                </div>
                <div class="opportunity-content">
                    <h2>We have great opportunities for you <br> you can join us now</h2>
                    <a href="#" class="btn btn-primary">Join with us</a>
                </div>   
            </section>
        </div>
        <div class="col-md-12">
            <section class="benefits-section">
            <h2 class="title">Benefits</h2>

                <div class="benefits-container">
                    <div class="benefit">
                    <div class="icon ">
                            <img alt="" src="/img/men-22.png" />
                        </div>
                        <p>Professional development</p>
                    </div>
                    <div class="benefit">
                    <div class="icon ">
                            <img alt="" src="/img/men-22.png" />
                        </div>
                        <p>Performance bonuses</p>
                    </div>
                    <div class="benefit">
                        <div class="icon ">
                            <img alt="" src="/img/men-22.png" />
                        </div>
                        <p>Exceptional in house training and support</p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>


<section class="main-banner banner-about-us careers-banner">


    <div class="careers">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h4>JOIN OUR <span> BESA TEAM </span> AND EMPOWER <br> STUDENTS AROUND THE WORLD</h4>

                    <?php if (!empty($careers)) : ?>
                        <?php $counter = 0; ?>
                        <div class="grid3col">
                            <?php foreach ($careers as $career) : ?>
                                <div class="item">
                                    <h5><?= $career['title'] ?></h5>
                                    <p><?= $career['country'] ?> - <?= $career['state'] ?></p>
                                    <a href="<?= Cake\Routing\Router::url('/career-details/' . $career['permalink'] . '/' . $career['id'].'/1') ?>" class="btn">Learn More</a>
                                    <?php
                                    if (false) { ?>
                                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['pages.careerapply'] . '/' .  $career['id'] . '/' . $career['title']) ?>" class="btn">Apply Now</a>
                                    <?php } ?>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    <?php endif; ?>

                    <?= $besa_careers_benefits ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($careerImages->toArray())) : ?>
    <section class="lifeBesaSlider">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Life at <span> BESA </span> </h2>
                    <div class="owl-carousel owl-theme owl-lifeBesa">

                        <?php foreach ($careerImages as $careerImage) : ?>
                            <div class="item">
                                <div class="image">
                                    <img src="<?= $careerImage['image_path'] ?>" alt="">
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>