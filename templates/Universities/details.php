<section class="hero-country hero-acadia-university">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="image-container">
                    <img src="<?= $university['banner_image_path'] ?>" alt="hero Universities">
                    <div class="text-container">
                        <a class="" href="<?php // Router::url('/user/register') 
                                            ?>">
                            <h3> <span class="bold-name"> </span> <?= $university['university_name']  ?></h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="universities-section acadia-university">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container-universities">
                    <div class="header-box">
                        <div class="title-left">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                            <h4><?= $university['university_name']  ?> <span> <?= $university['country']['country_name']  ?></span></h4>

                        </div>
                        <div class="right-rank">
                            Rank
                            <span><?= $university['rank']  ?></span>
                        </div>

                    </div>
                    <div class="content-container">
                        <div class="content">
                            <p>
                                <?= $university['short_description']  ?>
                                <!-- Acadia University is known for its small class sizes, strong academic reputation, and vibrant campus life. 
                            It offers programs in a variety of disciplines, including arts, sciences, business, education, and nursing -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo $this->element('courses_list', [
    'courses' => $uniCourses,
    // 'seeAllLink' => Cake\Routing\Router::url('/' . $g_dynamic_routes['universities.index'] . '/') . $country['id'] . "/" . $country['permalink'],
    'pagging' => 1
]); ?>

<!-- <div class="universities-section">
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
                        <?php for ($i = 0; $i < 3; $i++) : ?>
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
</div> -->
<?php if (!empty($popularSubjectAreas)) {
?>
    <div class="universities-section trending-subject">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-universities">
                        <div class="header-box">
                            <div class="title-left">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                                <h4>Trending Subject</h4>
                            </div>
                            <a href="#" class="link-see-more">
                                See All <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow right.svg" alt="Arrow Icon">
                            </a>
                        </div>
                        <div class="country-container">
                            <div class="country-list">

                                <?php foreach ($popularSubjectAreas as $key => $subjectArea) { ?>
                                    <div class="country-tag studyLevel-<?= $key ?>" title='<?= $subjectArea ?>' data-course='<?= $key ?>'>
                                        <?= $subjectArea ?>
                                    </div>
                                <?php } ?>

                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} ?>


<?php if ($university['show_facilities_section']) {
?>
    <div class="universities-section facilities">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-universities">
                        <div class="header-box">
                            <div class="title-left">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                                <h4><?= !empty($university['facilities_title']) ? $university['facilities_title'] : 'Facilities' ?></h4>
                            </div>

                        </div>
                        <div class="tabs-container">
                            <div class="tab-buttons">
                                <button class="tab-button active" data-tab-target="#overview"><?= !empty($university['facilities_tab1_title']) ? $university['facilities_tab1_title'] : 'Over View' ?></button>
                                <button class="tab-button" data-tab-target="#accommodation"><?= !empty($university['facilities_tab2_title']) ? $university['facilities_tab2_title'] : 'Accommodation' ?></button>
                                <button class="tab-button" data-tab-target="#campus_life"><?= !empty($university['facilities_tab3_title']) ? $university['facilities_tab3_title'] : 'Campus Life' ?></button>
                            </div>
                            <div id="overview" class="tab-content active">
                                <div class="content">
                                    <p><?= !empty($university['facilities_tab1_content']) ? $university['facilities_tab1_content'] : '...' ?></p>
                                </div>

                            </div>
                            <div id="accommodation" class="tab-content">
                                <div class="content">
                                    <p><?= !empty($university['facilities_tab2_content']) ? $university['facilities_tab2_content'] : '...' ?></p>

                                </div>
                            </div>
                            <div id="campus_life" class="tab-content">
                                <div class="content">
                                    <p><?= !empty($university['facilities_tab3_content']) ? $university['facilities_tab3_content'] : '...' ?></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<?php if ($university['show_city_life_section']) {
?>
    <div class="universities-section city-life">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-universities">
                        <div class="header-box">
                            <div class="title-left">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                                <h4><?= !empty($university['city_life_title']) ? $university['city_life_title'] : 'City Life' ?></h4>
                            </div>

                        </div>
                        <div class="content-container">
                            <div class="content">
                                <p>
                                    <?php

                                    if (!empty($university['city_life_section_content']))
                                        echo $university['city_life_section_content'];
                                    else
                                        echo `Students can work on and off-campus while studying,
                                            with on-campus jobs conveniently available within the university or college.
                                            Off-campus work permits allow them to work up to 20 hours per week during regular
                                            academic sessions and full-time during breaks. Co-op and internship programs offer practical
                                            work experience, enhancing employability. After graduation, students may be
                                            eligible for a Post-Graduation Work Permit (PGWP),
                                            allowing them to work in Canada and gain valuable Canadian work
                                            experience for up to three years.`;
                                    ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



<?php if ($university['show_gallary_section'] && !empty($university['university_images'])) {
?>

    <div class="gallary">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title-gallary">Gallary</h2>
                    <div class=" owl-school-tour owl-carousel owl-theme" id="owl_gallary">

                        <?php foreach ($university['university_images'] as $image) { ?>

                            <div class="item">
                                <img src="<?= $image['image_path'] ?>" alt="First Image In Gallary">

                            </div>
                        <?php } ?>
                    </div>

                    <a href="#" class="btn MainBtn">View all course <img alt="" src="/webroot/filebrowser/upload/images/arrow%20right.svg" style="width: 24px; height: 24px;    margin-left: 5px;"></a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>