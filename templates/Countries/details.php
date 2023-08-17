<?php

use Cake\Routing\Router;
?>
<section class="main-banner  inner-serv unitedKingdom-banner">
    <div class="container-fluid">
        <div class="row">

            <?php if (!empty($countryImages->toArray())) { ?>
                <div class="col-md-12">
                    <div class="ukslider owl-carousel owl-theme">
                        <?php

                        if (sizeof($countryImages->toArray()) > 0) : ?>
                            <?php foreach ($countryImages as $countryImage) : ?>
                                <div class="item">
                                    <img src="<?= $countryImage['image_path'] ?>" alt="">
                                    <!-- <div class="blue-qoute">
                                    <h4><?= $countryImage['title'] ?></h4>
                                    <p>
                                        <?= $countryImage['short_text'] ?>
                                    </p>
                                </div> -->
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="item">
                                <img src="<?= WEBSITE_URL ?>img/banner-45.png" alt="">
                                <!-- <div class="blue-qoute">
                                <h4>The <?= $country['country_name'] ?></h4>
                                <p>
                                    The <?= $country['country_name'] ?> of Great Britain and Northern Ireland,
                                    commonly known as the <?= $country['country_name'] ?> (<?= strtoupper($country['country_code']) ?>) or Britain is a country in Western Europe,
                                    off the north-western coast of the continental mainland. It comprises England, Scotland,
                                    Wales and Northern Ireland.
                                </p>
                            </div> -->
                            </div>
                        <?php endif; ?>

                    </div>
                </div>


            <?php } ?>
            <div class="col-md-12">
                <a class="title-banner-blue greenish-teal" href="<?= Router::url('/user/register') ?>">
                    <h3><?= isset($country['green_section']) ? $country['green_section'] : '' ?></h3>
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
                        <h4 class="title"><?= $country['text_header'] ?></h4>
                        <?= $country['why_text'] ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $country['top_text'] ?>
<?php if (!empty($countryBenefits->toArray())) { ?>
    <section class="tabes benefits ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>BENEFITS OF STUDYING IN <?= strtoupper($country['country_code']) ?></h2>

                    <div class="gridTabes">
                        <?php if (!empty($countryBenefits->toArray())) : ?>
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

<?php } ?>
<?php if (!empty($countryQuestions->toArray())) { ?>
    <section class="questions">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>FREQUENTLY ASKED QUESTIONS</h2>

                    <?php if (!empty($countryQuestions->toArray())) : ?>
                        <?php foreach ($countryQuestions as $countryQuestion) : ?>
                            <div class="faq-item">
                                <h3 class="faq-question"><?= $countryQuestion['question'] ?></h3>

                                <div class="faq-answer">
                                    <p><?= $countryQuestion['answer'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <a class="detalis" href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['enquiries.contactus']) ?>">CONTACT ADVISOR FOR MORE DETAILS</a>
                </div>
            </div>
        </div>
    </section>
<?php } ?>


<?php if (!empty($countryPartners)) : ?>
<section class="our-uk">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>OUR PARTNER UNIVERSITIES IN <?= strtoupper($country['country_code']) ?></h2>

                <div class="gridOuruk">

                    <?php if (!empty($countryPartners)) : ?>
                        <?php foreach ($countryPartners as $countryPartner) : ?>
                            <img alt="<?= $countryPartner['title'] ?>" src="<?= $countryPartner['logo_path'] ?>" />

                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (2).png" /> <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (1).png" /> <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (6).png" /> <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (5).png" /> <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (4).png" /> -->
                </div>
                <a class="link" href="<?= Router::url('/' . $g_dynamic_routes['universities.index'] . '/') . $country['id'] . "/" . $country['permalink'] ?>">EXPLORE UNIVERSITIES IN <?= strtoupper($country['country_code']) ?></a>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>

<!-- <section class="our-partner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Hear about the experiences of some of our international students studying in <?= strtoupper($country['country_code']) ?></h2>


                <div class="d-flex images">
                    <?php if (!empty($countryPartnersVideos)) : ?>
                        <?php foreach ($countryPartnersVideos as $countryPartnersVideo) : ?>
                            <div class="image">
                                <div class="box-video">
                                    <video controls poster="<?= $countryPartnersVideo['video_thumb_path'] ?>">
                                        <source src="<?= $countryPartnersVideo['video_url'] ?>" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
    </div>
</section> -->

<?= $this->element('testimonials', ['testimonials' => $testimonials, 'testiTitle' => "Hear about the experiences of some of our international students studying in " . strtoupper($country['country_code'])]) ?>

<section class="tabes tabes2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridTabes">

                    <?php if (!isset($_SESSION['Auth.User'])) : ?>
                        <a class="btn clear-blue foundation" href="/user/register">REGISTER NOW TO APPLY</a>
                    <?php endif; ?>
                    <a class="btn greenish-teal master" href="<?= Router::url('/' . $g_dynamic_routes['universitycourses.index'] . '/') . $country['id'] . "/" . $country['permalink'] ?>">EXPLORE STUDYING IN <?= strtoupper($country['country_code']) ?></a>
                </div>
            </div>
        </div>
    </div>
</section>