<?php

use Cake\Routing\Router;
?>
<section class="hero-country hero-slider-countries">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="image-container">
                    <?php if (!empty($countryImages->toArray())) : ?>
                        <!-- If there are images, display the first one -->
                        <?php //$firstImage = $countryImages->first(); 
                        ?>
                        <?= $this->element('destination_slider', ['sliders' => $countryImages->toArray(), 'g_dynamic_routes' => $g_dynamic_routes]) ?>
                    <?php else : ?>
                        <!-- Default image if there are no country images -->
                        <!-- <img src="<?= WEBSITE_URL ?>img/banner-45.png" alt="Default banner"> -->
                    <?php endif; ?>
                    <div class="text-container">
                        <a class="" href="<?= Router::url('/register') ?>">
                            <h4>Apply to Study </h4>
                            <h5>in <?= $country['country_name'] ?></h5>
                            <!-- <h3><?= isset($country['green_section']) ? $country['green_section'] : '' ?></h3> -->
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="whyStudy">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridWhyStudy">

                    <div class="text">
                        <h4 class="title"><?= $country['text_header'] ?></h4>
                        <?= $country['why_text'] ?>

                    </div>
                    <div class="image">
                        <img src="<?= $country['image_path'] ?>" alt="" class="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $country['top_text'] ?>
<?php
/*
<div class="tuition-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-container">
                    <h2 class="title">What is the average tuition fee for international students studying in Canada?</h2>
                    <p>
                        Students can work on and off-campus while studying, with on-campus jobs conveniently available within the university or college. Off-campus work permits allow them to work up to 20 hours per week during regular academic sessions and full-time during breaks.
                    </p>
                    <p>
                        Co-op and internship programs offer practical work experience, enhancing employability. After graduation, students may be eligible for a Post-Graduation Work Permit (PGWP), allowing them to work in Canada and gain valuable Canadian work experience for up to three years.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
*/ ?>

<?php echo $this->element('universities_list', ['universitiesResults' => $countryPartners, 'countriesList' => [$country['id'] => $country['country_name']], 'seeAllLink' => Router::url('/' . $g_dynamic_routes['universities.index'] . '/') . $country['id'] . "/" . $country['permalink'],'sectionTitle' => 'Universities in ' . $country['country_name']]); ?>

<?php
/*
if (!empty($countryPartners)) : ?>

    <div class="universities-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-universities">
                        <div class="header-box">
                            <div class="title-left">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                                <h4>Universities in Canada</h4>
                            </div>
                            <a href="<?= Router::url('/' . $g_dynamic_routes['universities.index'] . '/') . $country['id'] . "/" . $country['permalink'] ?>" class="link-see-more">
                                See All <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow right.svg" alt="Arrow Icon">
                            </a>
                        </div>
                        <div class="grid-universities">
                            <?php
                            foreach ($countryPartners as $countryPartner) :
                            ?>
                                <div class="university">
                                    <div class="header-box">
                                        <div class="logo">
                                            <?php //= WEBSITE_URL . 'img/new-desgin/logo-university.png'
                                            ?>
                                            <img src="<?= $countryPartner['logo_path'] ?>" alt="<?= $countryPartner['university_name'] ?> Logo">
                                            <h5><a class="link" href="<?= Router::url('/' . $g_dynamic_routes['universities.details'] . '/') . $countryPartner['permalink'] ?>"><?= $countryPartner['university_name'] ?></a></h5>

                                        </div>
                                        <div class="icon-favorite">
                                            <i class="fa-regular fa-heart fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="university-info">
                                        <p><?= $country['country_name'] ?></p>
                                    </div>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['universities.details'] . '/') . $countryPartner['permalink'] ?>" class=" btn apply-now-btn">Apply now</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php endif; */ ?>

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
                    <h2>FAQS</h2>

                    <?php if (!empty($countryQuestions->toArray())) : ?>
                        <?php foreach ($countryQuestions as $countryQuestion) : ?>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <h3> <img class="faq-icon" width="24px" src="<?= WEBSITE_URL ?>img/new-desgin/plus-icon.svg" alt="icon plus"> <?= $countryQuestion['question'] ?></h3>
                                </div>

                                <div class="faq-answer">
                                    <p><?= $countryQuestion['answer'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php /*if (!isset($_SESSION['Auth.User'])) : ?>
                            <a class="btn clear-blue foundation" href="/user/register">REGISTER NOW TO APPLY</a>
                        <?php endif;*/ ?>

                        <a class="btn MainBtn explore-now" href="<?= Router::url('/' . $g_dynamic_routes['universitycourses.index'] . '/') . $country['id'] . "/" . $country['permalink'] ?>" style="width: max-content;margin: 30px auto ;">Explore Studying in <?= strtoupper($country['country_name']) ?> <img alt="" src="/webroot/filebrowser/upload/images/arrow%20right.svg" style="width: 24px; height: 24px;    margin-left: 5px;"></a>
                    <?php endif; ?>
                    <a class="detalis" href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['enquiries.contactus']) ?>">CONTACT ADVISOR FOR MORE DETAILS</a>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php
/* 
<section class="our-partner">
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

<?php  $this->element('testimonials', ['testimonials' => $testimonials, 'testiTitle' => "Hear about the experiences of some of our international students studying in " . strtoupper($country['country_code'])]) 
?>
<section class="tabes tabes2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridTabes">

                    <?php // if (!isset($_SESSION['Auth.User'])) : 
                    ?>
                        <a class="btn clear-blue foundation" href="/user/register">REGISTER NOW TO APPLY</a>
                    <?php //endif; 
                    ?>
                    <a class="btn greenish-teal master" href="<?php // Router::url('/' . $g_dynamic_routes['universitycourses.index'] . '/') . $country['id'] . "/" . $country['permalink'] 
                                                                ?>">EXPLORE STUDYING IN <?= strtoupper($country['country_code']) ?></a>
                </div>
            </div>
        </div>
    </div>
</section> */ ?>