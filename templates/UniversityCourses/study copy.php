<section class="main-banner inner-serv">
    <div class="background-banner background-services">
        <div id="overlay_header-bottom"></div>

    </div>
    <div class="custome-background-serv-inner">
        <div class="container ">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h2 class="title-banner">
                            Courses
                        </h2>
                        <!-- <div class="custome-text-en">
                            <p>
                                <?= $course['text'] ?>
                            </p>
                            <div class="text">
                                <p class="descrp">

                                    <?= $course['left_text'] ?>
                                </p>
                                <div class="right-dots-img">
                                    <img src="<?=WEBSITE_URL?>img/icon/dots-bakground.svg" alt="">

                                </div>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
        <div class="line-ellipse">
            <span></span>
            <span></span>
            <span></span>
            <span></detailsspan>
        </div>
    </div>

</section>

<section class="countries-inner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">COUNTRIES THAT OFFER <span class="green">BACHELOR</span> DEGREE </h2>
                <div class="gridUniversities">

                    <?php

                    use Cake\Routing\Router;

                    if (!empty($courses)) {
                        foreach ($courses as $key => $course) {

                    ?>
                            <div class="box">
                                <a href="/course-details/<?= $course['permalink'] ?>">
                                    <img src="<?= $course['image_path'] ?>" alt="">
                                    <h5 class="title-course"><?= $course['course_name'] ?></h5>
                                </a>
                            </div>
                    <?php
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>

</section>