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
                            <div class="country-tag">United Kingdom</div>
                            <div class="country-tag">United States</div>
                            <div class="country-tag">Lithuania</div>
                            <div class="country-tag">United Kingdom</div>
                            <div class="country-tag">United States</div>
                            <div class="country-tag">Lithuania</div>
                        </div>
                        <div class="country-list">
                            <div class="country-tag">Canada</div>
                            <div class="country-tag">Spain</div>
                            <div class="country-tag">Germany</div>
                            <div class="country-tag">Netherlands</div>
                            <div class="country-tag">Canada</div>
                            <div class="country-tag">Spain</div>
                            <div class="country-tag">Germany</div>
                            <div class="country-tag">Netherlands</div>
                        </div>
                        <div class="country-list">
                            <div class="country-tag">Hungary</div>
                            <div class="country-tag">Australia</div>
                            <div class="country-tag">Malaysia</div>
                            <div class="country-tag">Hungary</div>
                            <div class="country-tag">Australia</div>
                            <div class="country-tag">Malaysia</div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="universities-section facilities">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container-universities">
                    <div class="header-box">
                        <div class="title-left">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                            <h4>Facilities</h4>
                        </div>

                    </div>
                    <div class="tabs-container">
                        <div class="tab-buttons">
                            <button class="tab-button " data-tab-target="#overview">Over View</button>
                            <button class="tab-button active" data-tab-target="#accommodation">Accommodation</button>
                            <button class="tab-button" data-tab-target="#campus_life">Campus Life</button>
                        </div>
                        <div id="overview" class="tab-content ">
                            <div class="content">
                                <p>Overview content...</p>
                            </div>

                        </div>
                        <div id="accommodation" class="tab-content active">
                            <div class="content">
                                <p>Students can work on and off-campus while studying, with on-campus jobs conveniently available within the university or college. Off-campus work permits allow them to work up to 20 hours per week during regular academic sessions and full-time during breaks. Co-op and internship programs offer practical work experience, enhancing employability. After graduation, students may be eligible for a Post-Graduation Work Permit (PGWP), allowing them to work in Canada and gain valuable Canadian work experience for up to three years.</p>

                            </div>
                        </div>
                        <div id="campus_life" class="tab-content">
                            <div class="content">
                                <p>Campus Life content...</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="universities-section city-life">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container-universities">
                    <div class="header-box">
                        <div class="title-left">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                            <h4>City Life</h4>
                        </div>

                    </div>
                    <div class="content-container">
                        <div class="content">
                            <p>
                                Students can work on and off-campus while studying,
                                with on-campus jobs conveniently available within the university or college.
                                Off-campus work permits allow them to work up to 20 hours per week during regular
                                academic sessions and full-time during breaks. Co-op and internship programs offer practical
                                work experience, enhancing employability. After graduation, students may be
                                eligible for a Post-Graduation Work Permit (PGWP),
                                allowing them to work in Canada and gain valuable Canadian work
                                experience for up to three years.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="gallary">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-gallary">Gallary</h2>
                <div class=" owl-school-tour owl-carousel owl-theme" id="owl_gallary">
                    <?php for ($i = 0; $i < 3; $i++) : ?>

                        <div class="item">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/gallary1.png" alt="First Image In Gallary">

                        </div>

                    <?php endfor ?>

                </div>

                <a href="#" class="btn MainBtn">View all course <img alt="" src="/webroot/filebrowser/upload/images/arrow%20right.svg" style="width: 24px; height: 24px;    margin-left: 5px;"></a>
            </div>
        </div>
    </div>
</div>