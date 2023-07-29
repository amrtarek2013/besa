<section class="main-banner banner-about-us careers-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="background-banner-color">
                    <img src="<?=WEBSITE_URL?>img/hero-bg47.png" alt="">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-5">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Careers</h1>
                    <h2 class="title text-left">Careers</h2>
                </div>
            </div>

        </div>
    </div>

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
                                    <a href="/career-apply/<?= $career['id'] ?>/<?= $career['title'] ?>" class="btn">Apply Now</a>
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

<section class="lifeBesaSlider">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Life at <span> BESA </span> </h2>
                <div class="owl-carousel owl-theme owl-lifeBesa">

                    <?php if (!empty($careerImages)) : ?>
                        <?php foreach ($careerImages as $careerImage) : ?>
                            <div class="item">
                                <div class="image">
                                    <img src="<?= $careerImage['image_path'] ?>" alt="">
                                </div>
                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>