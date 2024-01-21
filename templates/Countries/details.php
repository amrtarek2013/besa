<?php

use Cake\Routing\Router;
?>
<section class="hero-country">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="image-container">
                    <?php if (!empty($countryImages->toArray())) : ?>
                        <!-- If there are images, display the first one -->
                        <?php $firstImage = $countryImages->first(); ?>
                        <img src="<?= $firstImage['image_path'] ?>" alt="<?= $firstImage['title'] ?>">
                        <?= $this->element('destination_slider', ['sliders' => $countryImages->toArray(), 'g_dynamic_routes' => $g_dynamic_routes], ['cache' => ['key' => 'destination_slider', 'config' => '_view_long_']]) ?>
                    <?php else : ?>
                        <!-- Default image if there are no country images -->
                        <img src="<?= WEBSITE_URL ?>img/banner-45.png" alt="Default banner">
                    <?php endif; ?>
                    <div class="text-container">
                        <a class="" href="<?= Router::url('/user/register') ?>">
                            <h3><?= isset($country['green_section']) ? $country['green_section'] : '' ?></h3>
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
if (false) { ?>
    <div class="study-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex work-life-info">
                        <div class="image-container">
                            <img src="path-to-graduation-image.jpg" alt="Student celebrating graduation" class="graduation-image" loading="lazy">
                        </div>
                        <div class="text-container">
                            <h4>WORK LIFE</h4>
                            <p>
                                Students can work on and off-campus while studying, with on-campus jobs conveniently available within the
                                university or college. Off-campus work permits allow them to work up to 20 hours per week during regular
                                academic sessions and full-time during breaks. Co-op and internship programs offer practical work experience,
                                enhancing employability.
                            </p>
                            <p>
                                After graduation, students may be eligible for a Post-Graduation Work Permit (PGWP),
                                allowing them to work in Canada and gain valuable Canadian work experience for up to three years.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex study-duration-info">
                        <div class="text-container">
                            <h4>STUDY LENGTH IN CANADA</h4>
                            <p>
                                The study length for international students varies based on the level of education.
                                Bachelor's degrees typically take 3 to 4 years, master's degrees require 1 to 2 years,
                                and doctoral programs generally last 4 to 6 years. However, the actual duration may depend
                                on the specific program and the student's progress.
                            </p>
                        </div>
                        <div class="image-container">
                            <img src="path-to-academic-image.jpg" alt="Academic institution in Canada" class="academic-image" loading="lazy">
                        </div>
                    </div>

                    <div class="d-flex explore-culture-info">
                        <div class="image-container">
                            <img src="path-to-culture-image.jpg" alt="Canadian cultural elements" class="culture-image" loading="lazy">
                        </div>
                        <div class="text-container">
                            <h4>EXPLORE A VIBRANT LIFE & CULTURE</h4>
                            <p>
                                Canada provides international students with a vibrant and diverse cultural experience.
                                The country's inclusive environment offers various cultural events and festivals to participate in.
                                Thriving cities with vibrant art, music, and entertainment scenes,
                            </p>
                            <p>
                                coupled with breathtaking natural landscapes, create a balanced and exciting lifestyle.
                                Canadians' friendly and welcoming nature makes it easy for international
                                students to make friends and form connections.
                            </p>
                        </div>
                    </div>
                    <a class="btn MainBtn explore-now" href="#" style="width: max-content;margin: 0 auto 20px;">Explore Studying in canda <img alt="" src="/webroot/filebrowser/upload/images/arrow%20right.svg" style="width: 24px; height: 24px;    margin-left: 5px;"></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

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
                        <a href="#" class="link-see-more">
                            See All <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow right.svg" alt="Arrow Icon">
                        </a>
                    </div>
                    <div class="grid-universities">
                        <?php for ($i = 0; $i < 6; $i++) : ?>
                            <div class="university">
                                <div class="header-box">
                                    <div class="logo">
                                        <img src="<?= WEBSITE_URL ?>img/new-desgin/logo-university.png" alt="University of Essex Logo">
                                        <h5>University of Essex</h5>
                                    </div>
                                    <div class="icon-favorite">
                                        <i class="fa-regular fa-heart fa-lg"></i>
                                    </div>
                                </div>
                                <div class="university-info">
                                    <p>United Kingdom</p>
                                </div>
                                <a href="#" class=" btn apply-now-btn">Apply now</a>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





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
                        <a class="btn MainBtn explore-now" href="#" style="width: max-content;margin: 30px auto ;">Explore Studying in canda <img alt="" src="/webroot/filebrowser/upload/images/arrow%20right.svg" style="width: 24px; height: 24px;    margin-left: 5px;"></a>
                    <?php endif; ?>
                    <a class="detalis" href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['enquiries.contactus']) ?>">CONTACT ADVISOR FOR MORE DETAILS</a>
                </div>
            </div>
        </div>
    </section>
<?php } ?>


<?php if (!empty($countryPartners)) : ?>
    <!-- <section class="our-uk">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>OUR PARTNER UNIVERSITIES IN <?= strtoupper($country['country_code']) ?></h2>

                <div class="gridOuruk">

                    <?php //if (!empty($countryPartners)) : 
                    ?>
                        <? php // foreach ($countryPartners as $countryPartner) : 
                        ?>
                            <img alt="<?php // $countryPartner['title'] 
                                        ?>" src="<?= $countryPartner['logo_path'] ?>" />

                        <?php //endforeach; 
                        ?>
                    <?php //endif; 
                    ?>
                   <img alt="" src="<? php // WEBSITE_URL 
                                    ?>img/part-logo (2).png" /> <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (1).png" /> <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (6).png" /> <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (5).png" /> <img alt="" src="<?= WEBSITE_URL ?>img/part-logo (4).png" /> 
                </div>
                <a class="link" href="<?php // Router::url('/' . $g_dynamic_routes['universities.index'] . '/') . $country['id'] . "/" . $country['permalink'] 
                                        ?>">EXPLORE UNIVERSITIES IN <?= strtoupper($country['country_code']) ?></a>
            </div>
        </div>
    </div>
</section> -->

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
<!-- 
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
</section> -->