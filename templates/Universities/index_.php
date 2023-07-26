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
                            Universities
                        </h2>
                        <!-- <div class="custome-text-en">
                            <p>
                                <?= $university['text'] ?>
                            </p>
                            <div class="text">
                                <p class="descrp">

                                    <?= $university['left_text'] ?>
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

                    if (!empty($universities)) {
                        foreach ($universities as $key => $university) {

                    ?>
                            <div class="box">
                                <a href="/university-details/<?= $university['permalink'] ?>">
                                    <img src="<?= $university['image_path'] ?>" alt="">
                                    <h5 class="title-university"><?= $university['university_name'] ?></h5>
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