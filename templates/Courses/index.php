<!-- add This File (range slider)-->
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.js" as="script">
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.css" as="style">

<section class="main-banner register-banner study1-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg-study-01.png" alt="" style="z-index: 2;">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="100%" height="100%" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Courses</h1>
                    <h2 class="title text-left">
                        <!-- <span class=" green-small"><?= $courses[0]['course_name'] ?></span> -->
                        <span class="blue-para"><?= sizeof($courses) ?> international courses
                            found</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="result">
    <div class=" row-result">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid-container-3col">
                        <?php if (!empty($courses)) : ?>
                            <?php foreach ($courses as $course) : ?>
                                <div class="box-result">
                                    <h4 class="title-result"><?= $course['course_name'] ?></h4>
                                    <!-- <p class="education"><?= $course['university']['university_name'] ?></p> -->
                                    <!-- <p class="address">
                                        <span class="underline">
                                            <a href="#">
                                                <?= $course['university']['address'] ?>
                                            </a>
                                        </span>
                                        <span class="normal">THE world university rank: <?= $course['university']['rank'] ?></span>
                                    </p> -->
                                    <div class="courses">
                                        <div class="left">
                                            <p>Course Qualification</p>
                                            <p class="green"><?= $course['service']['title'] ?></p>
                                        </div>
                                        <!-- <div class="right">
                                            <p>Total course fee</p>
                                            <p class="green">USD <?= $course['fees'] ?></p>
                                        </div> -->

                                    </div>
                                    <div class="icons">
                                        <div>
                                            <div class="circle-icon">
                                                <img src="<?= WEBSITE_URL ?>img/icon/wish-list.svg" alt="">
                                            </div>
                                            <span class="green">Wish List</span>
                                        </div>

                                        <div>
                                            <div class="circle-icon">
                                                <img src="<?= WEBSITE_URL ?>img/icon/more-details.svg" alt="">
                                            </div>
                                            <span class="green">More Details</span>
                                        </div>

                                        <div>
                                            <div class="circle-icon">
                                                <img src="<?= WEBSITE_URL ?>img/icon/aplly-now-green.svg" alt="">
                                            </div>
                                            <span class="green">Apply Now</span>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="button-next-prev">
        <a href="#">
            <img src="<?= WEBSITE_URL ?>img/icon/chevron-circle-prev.svg" alt="">
        </a>
        <a href="#">
            <img src="<?= WEBSITE_URL ?>img/icon/chevron-circle-next.svg" alt="">

        </a>

    </div> -->
</section>