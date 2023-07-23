<section class="main-banner  inner-serv unitedKingdom-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="ukslider owl-carousel owl-theme">
                    <?php 
                                                    debug($country);

                    if (sizeof($countryImages) > 0) : ?>
                        <?php foreach ($countryImages as $countryImage) : ?>
                            <div class="item">
                                <img src="<?= $countryImage['image_path'] ?>" alt="">
                                <div class="blue-qoute">
                                    <h4><?= $countryImage['title'] ?></h4>
                                    <p>
                                        <?= $countryImage['short_text'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="item">
                            <img src="/img/banner-45.png" alt="">
                            <div class="blue-qoute">
                                <h4>The <?= $country['country_name'] ?></h4>
                                <p>
                                    The <?= $country['country_name'] ?> of Great Britain and Northern Ireland,
                                    commonly known as the <?= $country['country_name'] ?> (<?= $country['country_code'] ?>) or Britain is a country in Western Europe,
                                    off the north-western coast of the continental mainland. It comprises England, Scotland,
                                    Wales and Northern Ireland.
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <div class="col-md-12">
                <a class="title-banner-blue greenish-teal" href="#">
                    <h3>APPLY TO STUDY IN <?= $country['country_code'] ?></h3>
                </a>
            </div>
        </div>
    </div>


</section>



<section class="whyStudy">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridWhyStudy">
                    <div class="image">
                        <img src="<?= $country['image_path'] ?>" alt="" class="circle-img">
                    </div>
                    <div class="text">
                        <h4 class="title">Why Study In The <?= $country['country_code'] ?>?</h4>
                        <?= $country['why_text'] ?>
                        <a href="#" class="btn MainBtn clear-blue ">
                            Apply Now
                            <img src="/img/icon/arrow-right.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $country['top_text'] ?>
<section class="tabes benefits ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>BENEFITS OF STUDYING IN THE <?=$country['country_code']?></h2>

                <div class="gridTabes">
                    <?php if (!empty($countryBenefits)) : ?>
                        <?php foreach ($countryBenefits as $countryBenefit) : ?>
                            <div class="card">
                                <div class="card-head"><img alt="" src="<?= $countryBenefit['image_path'] ?>" /></div>

                                <div class="card-body">
                                    <h4><?= $countryBenefit['title'] ?></h4>

                                    <p><?= $countryBenefit['short_text'] ?></p>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="questions">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>FREQUENTLY ASKED QUESTIONS</h2>

                <?php if (!empty($countryQuestions)) : ?>
                    <?php foreach ($countryQuestions as $countryQuestion) : ?>
                        <div class="faq-item">
                            <h3 class="faq-question"><?= $countryQuestion['question'] ?></h3>

                            <div class="faq-answer">
                                <p><?= $countryQuestion['answer'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <a class="detalis" href="#">CONTACT ADVISOR FOR MORE DETAILS</a>
            </div>
        </div>
    </div>
</section>

<section class="our-uk">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>OUR <?=$country['country_code']?> PARTNER UNIVERSITIES</h2>

                <div class="gridOuruk">

                    <?php if (!empty($countryPartners)) : ?>
                        <?php foreach ($countryPartners as $countryPartner) : ?>
                            <img alt="<?= $countryPartner['title'] ?>" src="<?= $countryPartner['image_path'] ?>" />

                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- <img alt="" src="/img/part-logo (2).png" /> <img alt="" src="/img/part-logo (1).png" /> <img alt="" src="/img/part-logo (6).png" /> <img alt="" src="/img/part-logo (5).png" /> <img alt="" src="/img/part-logo (4).png" /> -->
                </div>
                <a class="link" href="#">EXPLORE <?=$country['country_code']?> UNIVERSITIES</a>
            </div>
        </div>
    </div>
</section>

<section class="our-partner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>OUR <?=$country['country_code']?> PARTNER UNIVERSITIES</h2>

                <p>HEAR FROM SOME OF OUR INTERNATIONAL STUDENT&rsquo;S EXPERIENCE ON STUDYING IN <?=$country['country_code']?></p>

                <div class="d-flex images">
                    <?php if (!empty($countryPartnersVideos)) : ?>
                        <?php foreach ($countryPartnersVideos as $countryPartnersVideo) : ?>
                            <div class="image">
                                <!-- <img alt="<?= $countryPartnersVideo['title'] ?>" src="<?= $countryPartnersVideo['video_url'] ?>" /> -->
                                <div class="box-video">
                                    <video controls poster="<?= $countryPartnersVideo['video_thumb_path'] ?>">
                                        <source src="<?= $countryPartnersVideo['video_url'] ?>" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- <img alt="" src="/img/pers (1).png" /> -->
                </div>

                <!-- <div class="image"><img alt="" src="/img/pers (1).png" /></div> -->
            </div>
        </div>
    </div>
    </div>
</section>

<section class="tabes tabes2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridTabes"><a class="btn clear-blue foundation" href="#">REGISTER NOW TO APPLY</a> <a class="btn greenish-teal master" href="#">EXPLORE STUDYING IN <?=$country['country_code']?></a></div>
            </div>
        </div>
    </div>
</section>