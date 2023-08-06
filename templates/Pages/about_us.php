<section class="main-banner banner-about-us aboutUs2-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg1.png" alt="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-5">
                <div class="relative-box-about ">
                    <h1 class="relative-text">About</h1>
                    <h2 class="title text-left">About Us</h2>
                </div>
            </div>
            <?= $aboutusSnippet ?>
        </div>
    </div>
</section>

<section class="sectionTimeline">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="timeline-container timeline-theme-1">
                    <div class="timeline js-timeline custome-timeline">


                        <?php if (!empty($aboutusSlidersList)) : ?>
                            <?php foreach ($aboutusSlidersList as $aboutSlider) : ?>
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
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-nav">
                <div class="nav-timeline">
                    <button class="prev" id="prevTimeline">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button class="next" id="nextTimeline">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>