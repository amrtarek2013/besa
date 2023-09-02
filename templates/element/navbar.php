<?php

use Cake\Routing\Router;
?>
<style>
    .search-list {
        font-family: "Poppins";
        font-weight: 400;
        font-size: 16px;
        line-height: 18px;
        letter-spacing: 0.20000000298023224px;
        padding: 20px 10px;
    }
</style>
<section class="navbar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridContainer-navbar">
                    <div class="logo">
                        <a href="<?= Router::url('/' . $g_dynamic_routes['pages.main']) ?>"><img src="<?= $g_configs['general']['file.main_logo'] ?>" alt="Logo"></a>
                    </div>
                    <ul class="links">

                        <li>
                            <a href="<?= Router::url('/' . $g_dynamic_routes['pages.wheretostudy']) ?>">Study</a>
                            <div class="menu-dropdown">
                                <ul>
                                    <li <?= (strtolower($current_controller) == 'services' && strtolower($current_action) != 'b2bservices') ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['services.index']) ?>">Services </a>
                                    </li>
                                    <li <?= (strtolower($current_controller) == 'destinations') ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['countries.index']) ?>">Destinations </a>
                                    </li>
                                    <li <?= (strtolower($current_controller) == 'pages' && strtolower($current_action) != 'pathwayprograms') ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['pathwayprograms.index']) ?>">Pathway Programs </a>
                                    </li>
                                    <li <?= (strtolower($current_controller) == 'pages' && strtolower($current_action) != 'universityplacements') ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['universityplacements.index']) ?>">University Placement </a>
                                    </li>
                                    <li <?= (strtolower($current_controller) == 'pages' && strtolower($current_action) != 'younglearners') ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['younglearners.index']) ?>">Young Learners </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <a href="<?= Router::url('/' . $g_dynamic_routes['pages.partnerinstitutions']) ?>">Partners</a>

                        </li>



                        <li <?= strtolower($current_controller) == 'events' ? 'class="active"' : '' ?>>
                            <a href="<?= Router::url('/' . $g_dynamic_routes['events.index']) ?>">Events</a>

                            <div class="menu-dropdown">
                                <ul>
                                    <?php
                                    foreach ($eventsMenuList as $key => $eventValue) {
                                    ?>
                                        <li>
                                            <a href="<?= Router::url('/' . $g_dynamic_routes['events.eventdetails']) ?>/<?= $eventValue['permalink'] ?>"><?= $eventValue['title'] ?></a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>
                        </li>

                        <li class="drop-down">
                            <div class="toggle">
                                <i class="fa-solid fa-bars fa-2x"></i>
                            </div>
                            <div class="menu-dropdown">
                                <ul>
                                    <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'view' ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['pages.aboutus']) ?>">About us</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'blogs' ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['blogs.index']) ?>">Blog</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'careers' ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['careers.index']) ?>">Careers</a>
                                    </li>

                                    <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) == 'b2bservices' ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['services.b2bservices']) ?>">B2B Services</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'contactus' ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['enquiries.contactus']) ?>">Contact Us</a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    </ul>

                    <div class="buttons apply-now-btn-header">

                        <div class="button li-search">
                            <!-- <a href="<?= Router::url('/' . $g_dynamic_routes['enquiries.contactus']) ?>" class="btn MainBtn">Apply Now</a> -->

                            <div class="search">
                                <input type="search" name="search" class="searchInput" id="searchInput" placeholder="Search">
                                <div class="search-list">
                                    <ul class="search-list-result">
                                        <li>
                                            <img src="<?= WEBSITE_URL ?>img/icon/search-blue.svg" alt="">
                                            <a href="#">search list</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['Auth']['User'])) { ?>


                            <a href="/user/logout" class="btn SecondaryBtn logout">Logout
                                <img src="<?= WEBSITE_URL ?>img/icon/login.png" alt="">
                            </a>

                            <a href="/user" class="btn MainBtn">Profile</a>
                        <?php } else if (isset($_SESSION['Auth']['Counselor'])) { ?>


                            <a href="/counselor/logout" class="btn SecondaryBtn logout">Logout
                                <img src="<?= WEBSITE_URL ?>img/icon/login.png" alt="">
                            </a>

                            <a href="/counselor/profile" class="btn MainBtn">Profile</a>
                        <?php } else { ?>
                            <a href="/user/register" class="btn MainBtn">Apply Now</a>

                        <?php } ?>


                    </div>
                    <div class="navbar-mobile">
                        <div class="toggle">
                            <i class="fa-solid fa-bars fa-2x"></i>
                        </div>
                        <div class="sidenav">
                            <div class="colse">
                                <i class="fa-solid fa-xmark fa-2x"></i>
                            </div>
                            <ul class="">


                                <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'main' ? 'class="active"' : '' ?>>
                                    <a href="/">Home</a>
                                </li>

                                <li class="<?= strtolower($current_controller) == 'pages' ? 'parent-menu active' : 'parent-menu' ?>">
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['pages.wheretostudy']) ?>">Study <i class="parent-icon right fas fa-angle-up" style="float:right"></i></a>
                                    <div class="mobile-menu-dropdown">
                                        <ul>

                                            <li <?= (strtolower($current_controller) == 'services' && strtolower($current_action) != 'wheretostudy') ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['pages.wheretostudy']) ?>">Where To Study </a>
                                            </li>
                                            <li <?= (strtolower($current_controller) == 'services' && strtolower($current_action) != 'b2bservices') ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['services.index']) ?>">Services </a>
                                            </li>
                                            <li <?= (strtolower($current_controller) == 'destinations') ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['countries.index']) ?>">Destinations </a>
                                            </li>
                                            <li <?= (strtolower($current_controller) == 'pages' && strtolower($current_action) != 'pathwayprograms') ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['pathwayprograms.index']) ?>">Pathway Programs </a>
                                            </li>
                                            <li <?= (strtolower($current_controller) == 'pages' && strtolower($current_action) != 'universityplacements') ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['universityplacements.index']) ?>">University Placement </a>
                                            </li>
                                            <li <?= (strtolower($current_controller) == 'pages' && strtolower($current_action) != 'younglearners') ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['younglearners.index']) ?>">Young Learners </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['pages.partnerinstitutions']) ?>">Partners</a>

                                </li>



                                <li class="<?= strtolower($current_controller) == 'events' ? 'parent-menu active' : 'parent-menu' ?>">
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['events.index']) ?>">Events <i class="parent-icon right fas fa-angle-up" style="float:right"></i></a>

                                    <div class="mobile-menu-dropdown">
                                        <ul>
                                            <li>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['events.index']) ?>">All Events</a>
                                            </li>
                                            <?php
                                            foreach ($eventsMenuList as $key => $eventValue) {
                                            ?>
                                                <li>
                                                    <a href="<?= Router::url('/' . $g_dynamic_routes['events.eventdetails']) ?>/<?= $eventValue['permalink'] ?>"><?= $eventValue['title'] ?></a>
                                                </li>
                                            <?php } ?>

                                        </ul>
                                    </div>
                                </li>


                                <li class="<?= strtolower($current_controller) == 'pages' ? 'parent-menu active' : 'parent-menu' ?>">
                                    <a href="#">Other Pages <i class="parent-icon right fas fa-angle-up" style="float:right"></i></a>
                                    <div class="mobile-menu-dropdown">
                                        <ul>
                                            <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'view' ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['pages.aboutus']) ?>">About us</a>
                                            </li>
                                            <li <?= strtolower($current_controller) == 'blogs' ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['blogs.index']) ?>">Blogs</a>
                                            </li>
                                            <li <?= strtolower($current_controller) == 'careers' ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['careers.index']) ?>">Careers</a>
                                            </li>

                                            <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) == 'b2bservices' ? 'class="active"' : '' ?>>
                                                <a href="<?= Router::url('/' . $g_dynamic_routes['services.b2bservices']) ?>">B2B Services</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <?php /* ?>
                                <!-- <li <?= strtolower($current_controller) == 'universities' && strtolower($current_action) == 'index' ? 'class="active"' : '' ?>>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['universities.index']) ?>">Partners</a>
                                </li>

                                <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'view' ? 'class="active"' : '' ?>>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['pages.aboutus']) ?>">About us</a>
                                </li>
                                <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'whereToStudy' ? 'class="active"' : '' ?>>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['pages.wheretostudy']) ?>">Study</a>
                                </li>
                                <?php if ($this->request->is('mobile')) : ?>
                                    <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) != 'b2bservices' ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['services.index']) ?>">Services</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'countries' ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['countries.index']) ?>">Destinations</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'events' ? 'class="active"' : '' ?>>
                                        <a href="<?= Router::url('/' . $g_dynamic_routes['events.index']) ?>">Events</a>
                                    </li>
                                <?php endif; ?> -->
                                <!-- <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) == 'b2bservices' ? 'class="active"' : '' ?>>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['services.b2bservices']) ?>">B2B Services</a>
                                </li> -->
                                
                                <?php */ ?>
                                <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'contactus' ? 'class="active"' : '' ?>>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['enquiries.contactus']) ?>">Contact Us</a>
                                </li>

                                <?php if (isset($_SESSION['Auth']['User'])) { ?>

                                    <li <?= strtolower($current_controller) == 'users' && strtolower($current_action) == 'profile' ? 'class="active"' : '' ?>>
                                        <a href="/user">Dashboard</a>
                                    </li>
                                <?php } ?>


                                <li class="buttons">
                                    <?php if (isset($_SESSION['Auth']['User'])) { ?>


                                        <a href="/user/logout" class="btn SecondaryBtn logout">Logout
                                            <img src="<?= WEBSITE_URL ?>img/icon/login.png" alt="">
                                        </a>

                                        <a href="/user" class="btn MainBtn">Profile</a>
                                    <?php } else { ?>
                                        <a href="/user/register" class="btn MainBtn">Apply Now</a>

                                    <?php } ?>
                                </li>

                            </ul>
                        </div>

                    </div>



                </div>


                <?php /* ?>
                <!-- <div class="buttons apply-now-btn-header mobile-search">

                    <div class="button li-search">

                        <div class="search">
                            <input type="search" name="search" class="searchInput" id="searchInput" placeholder="Search">
                            <div class="search-list">
                                <ul class="search-list-result">
                                    <li>
                                        <img src="<?= WEBSITE_URL ?>img/icon/search-blue.svg" alt="">
                                        <a href="#">search list</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
                

                <?php */ ?>
            </div>

        </div>
    </div>
</section>

<script>
    var studyCoursesList = <?= json_encode($studyCoursesList) ?>;

    $('.searchInput').on('keyup, keydown', function() {

        let obj = $(this);

        $('.search-list').removeClass('show');
        let obVal = obj.val();
        obVal = obVal.toLowerCase();

        let searchResult = '';
        searchResult = `<li> <img src = "img/icon/search-blue.svg" alt = "" >
            No Courses Found! </li>`;
        $('.search-list-result').html(searchResult);
        if (obVal.length >= 2) {

            let searchResult = '';
            $.each(studyCoursesList, function(key, val) {
                val1 = val.toLowerCase();

                var regex = new RegExp(obVal, 'i');
                if (val1.search(regex) != -1)
                    searchResult += `<li> <img src = "img/icon/search-blue.svg" alt = "" >
                <a target="_blank" href="/results?id=` + key + `">` + val + `</a></li>`;
            });
            if (searchResult.length > 0) {
                $('.search-list-result').html(searchResult);

            } else
                searchResult = `<li> <img src = "img/icon/search-blue.svg" alt = "" >
            No Courses Found! </li>`;

            $('.search-list').addClass('show');
        } else {
            $('.search-list').removeClass('show');
        }
    });
    $(document).on('click', function() {
        $('.search-list').removeClass('show');
    });

    $(function() {
        $(".mobile-menu-dropdown").hide();

        $(".parent-menu > a").click(function(e) {
            e.preventDefault();
            e.stopPropagation();

            // if (event.target === event.currentTarget) {
            // $(".mobile-menu-dropdown").hide();
            $(this).next("div.mobile-menu-dropdown").fadeToggle();

            if ($(".parent-icon", this).hasClass('fa-angle-up'))
                $(".parent-icon", this).removeClass('fa-angle-up').addClass('fa-angle-down');
            else
                $(".parent-icon", this).removeClass('fa-angle-down').addClass('fa-angle-up');
            // }
        });
    });
</script>