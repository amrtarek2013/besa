<?php
// $image_path = 'uploads' . DS . 'courses' . DS . $course['image'];
// debug(WWW_ROOT . $image_path);
// debug($course);

// debug(file_exists(WWW_ROOT . $image_path));
?>
<section class="main-banner british-banner <?= $course['style'] ?>">
    <div class="container">
        <div class="row">
            <!-- <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= $course['image_path'] ?>" alt="" style="z-index: 2;">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div> -->
            <div class="col-md-6">
                <div class="relative-box-about ">

                    <?php $tt = explode(' ', trim($course['course_name'])) ?>
                    <h1 class="relative-text"><?= substr($tt[0], 0, 6) ?></h1>
                    <h2 class="title text-left"><?= $course['course_name'] ?></h2>
                    <h4 class="title-result"><?= $course['course_name'] ?></h4>

                    <p class="education"><?= $course['university']['university_name'] ?></p>
                    <p class="address">
                        <span class="underline">
                            <a href="#">
                                <?= $course['university']['address'] ?>
                            </a>
                        </span>
                        <span class="normal">THE world university rank: <?= $course['university']['rank'] ?></span>
                    </p>
                    <div class="courses">
                        <div class="left">
                            <p>Course Qualification</p>
                            <p class="green"><?= $course['service']['title'] ?></p>
                        </div>
                        <div class="right">
                            <p>Total course fee</p>
                            <p class="green">USD <?= $course['fees'] ?></p>
                        </div>

                    </div>
                    <p class="relative-textP">
                        <?= $course['description'] ?>
                    </p>

                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="text">
                    <p class="descrp">

                        <?= $course['description'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="youtube-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridContainerYoutube">
                    <div class="video">
                        <?php
                        $course['video'] = !empty($course['video']) ? $course['video'] : 'https://www.youtube.com/v/D0UnqGm_miAF';
                        ?>
                        <object width="767" height="432" data="<?= $course['video'] ?>" type="application/x-shockwave-flash">
                            <param name="src" value="<?= $course['video'] ?>" />
                        </object>
</div>
<div class="text">

    <?= $course['video_right_text'] ?>
</div>
</div>
</div>
</div>
</div>
</section> -->
<!-- <?php if (sizeof($courseImages) > 0) : ?>
    <section class="slider-photoGalley">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title-photoGalley">Photo Galley</h2>
                </div>
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme photoGalley-slider">
                        <?php
                        foreach ($courseImages as $courseImage) {
                        ?>
                            <div class="item">
                                <div class="image">
                                    <img src="<?= $courseImage['image_path'] ?>" alt="<?= $courseImage['title'] ?>">
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?> -->
<!-- 
<section class="tabes british-tabes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title" style="color: #fff;">To know more about <?= $course['title'] ?>, guidelines and <br> registration, contact our office for more details.</h3>
                <div class="gridTabes">
                    <a href="#" class="btn clear-blue foundation">Course Subscription</a>
                    <a href="#" class="btn greenish-teal master">Become a Sponsor</a>

                </div>
            </div>
        </div>
    </div>
</section> -->