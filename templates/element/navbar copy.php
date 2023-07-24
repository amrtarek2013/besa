<section class="navbar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridContainer-navbar">
                    <div class="logo">
                        <a href="/"><img src="<?= $g_configs['general']['file.main_logo'] ?>" alt="Logo"></a>
                    </div>
                    <ul class="links">
                        <li class="drop-down">
                            <div class="toggle">
                                <i class="fa-solid fa-bars fa-2x"></i>
                            </div>
                            <div class="menu-dropdown">
                                <ul>
                                    <!-- <li>
                                        <a href="./home.html">Home</a>
                                    </li>
                                    <li>
                                        <a href="#">About us</a>
                                    </li>
                                    <li class="">
                                        <a href="./Services.html">Services</a>
                                    </li> -->
                                    <!-- <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'main' ? 'class="active"' : '' ?>>
                                        <a href="/">Home</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'universitycourses' && strtolower($current_action) == 'study' ? 'class="active"' : '' ?>>
                                        <a href="/study">Search</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'universitycourses' && strtolower($current_action) == 'index' ? 'class="active"' : '' ?>>
                                        <a href="/courses">All Courses</a>
                                    </li>
                                   
                                    <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'whereToStudy' ? 'class="active"' : '' ?>>
                                        <a href="/where-to-study">Study</a>
                                    </li> -->
                                    <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'view' ? 'class="active"' : '' ?>>
                                        <a href="/about-us">About us</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'blogs' ? 'class="active"' : '' ?>>
                                        <a href="/blogs">Blog</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'careers' ? 'class="active"' : '' ?>>
                                        <a href="/careers">Careers</a>
                                    </li>
                                    <?php /* if ($this->request->is('mobile')) : ?>
                                        <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) != 'b2bservices' ? 'class="active"' : '' ?>>
                                            <a href="/services">Services</a>
                                        </li>
                                        <li <?= strtolower($current_controller) == 'countries' ? 'class="active"' : '' ?>>
                                            <a href="/universities">Destinations</a>
                                        </li>
                                        <li <?= strtolower($current_controller) == 'events' ? 'class="active"' : '' ?>>
                                            <a href="/events">Events</a>
                                        </li>
                                    <?php endif; */ ?>
                                    <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) == 'b2bservices' ? 'class="active"' : '' ?>>
                                        <a href="/b2b-services">B2B Services</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'contactus' ? 'class="active"' : '' ?>>
                                        <a href=" /contact-us">Contact Us</a>
                                    </li>

                                    <?php /* if (isset($_SESSION['Auth']['User'])) { ?>

                                        <li <?= strtolower($current_controller) == 'users' && strtolower($current_action) == 'profile' ? 'class="active"' : '' ?>>
                                            <a href="/user">Dashboard</a>
                                        </li>
                                    <?php }*/ ?>

                                    <!-- <li class="buttons">
                                        <?php if (isset($_SESSION['Auth']['User'])) { ?>


                                            <a href="/user/logout" class="btn SecondaryBtn">Logout
                                                <img src="<?=WEBSITE_URL?>img/icon/login.png" alt="">
                                            </a>

                                            <a href="/user" class="btn MainBtn">Profile</a>
                                        <?php } else { ?>
                                            <a href="/user/login" class="btn MainBtn">Apply Now</a>

                                        <?php } ?>
                                    </li> -->
                                </ul>
                            </div>
                        </li>
                        <!-- <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'main' ? 'class="active"' : '' ?>>
                            <a href="/">Home</a>
                        </li> -->
                        <?php if (false) { ?>
                            <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'view' ? 'class="active"' : '' ?>>
                                <a href="/content/about">About us</a>
                            </li>
                            <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'wheretostudy' ? 'class="active"' : '' ?>>
                                <a href="/where-to-study">Study</a>
                            </li>
                        <?php } ?>

                        <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'wheretostudy' ? 'class="active"' : '' ?>>
                            <a href="/where-to-study">Study</a>
                        </li>


                        <?php if (false) { ?>
                            <li <?= (strtolower($current_controller) == 'services' && strtolower($current_action) != 'b2bservices') ? 'class="active"' : '' ?>>
                                <a href="/services">Services <i class="fa-solid fa-chevron-down"></i> </a>
                                <div class="sub-menu">
                                    <div class="container">
                                        <div class="row">
                                            <?php
                                            foreach ($serviceTypes as $key => $typeValue) {
                                            ?>
                                                <div class="col-md-4">
                                                    <div class="box-links">
                                                        <h4>
                                                            <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="25" height="25">
                                                                <path d="M9.5 14.5H9a.5.5 0 00.8.4l-.3-.4zm2-1.5l.3-.4a.5.5 0 00-.6 0l.3.4zm2 1.5l-.3.4a.5.5 0 00.8-.4h-.5zm-2-3.5A2.5 2.5 0 019 8.5H8a3.5 3.5 0 003.5 3.5v-1zM14 8.5a2.5 2.5 0 01-2.5 2.5v1A3.5 3.5 0 0015 8.5h-1zM11.5 6A2.5 2.5 0 0114 8.5h1A3.5 3.5 0 0011.5 5v1zm0-1A3.5 3.5 0 008 8.5h1A2.5 2.5 0 0111.5 6V5zM9 10.5v4h1v-4H9zm.8 4.4l2-1.5-.6-.8-2 1.5.6.8zm1.4-1.5l2 1.5.6-.8-2-1.5-.6.8zm2.8 1.1v-4h-1v4h1zM15 5V1.5h-1V5h1zm-1.5-5h-12v1h12V0zM0 1.5v12h1v-12H0zM1.5 15H8v-1H1.5v1zM0 13.5A1.5 1.5 0 001.5 15v-1a.5.5 0 01-.5-.5H0zM1.5 0A1.5 1.5 0 000 1.5h1a.5.5 0 01.5-.5V0zM15 1.5A1.5 1.5 0 0013.5 0v1a.5.5 0 01.5.5h1zM3 5h5V4H3v1zm0 3h3V7H3v1z" fill="currentColor"></path>
                                                            </svg>
                                                            <?= $typeValue ?>
                                                        </h4>

                                                        <ul>
                                                            <?php
                                                            $serviceList = isset($servicesMenuList[$key]) ? $servicesMenuList[$key] : [];
                                                            if (!empty($serviceList)) {
                                                                foreach ($serviceList as $serviceValue) {
                                                            ?>
                                                                    <li>
                                                                        <i class="fa-solid fa-check"></i>
                                                                        <a href="/service-details/<?= $serviceValue['permalink'] ?>"> <?= $serviceValue['title'] ?></a>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li <?= strtolower($current_controller) == 'countries' ? 'class="active"' : '' ?> style="position: relative;">

                                <a href="#">Destinations <i class="fa-solid fa-chevron-down"></i></a>
                                <div class="sub-menu countries-menu">
                                    <div class="gridCountries-menu">


                                        <div class="box-left">
                                            <?php

                                            $left_box = '<div class="box-left">';
                                            if (isset($_GET['dk'])) {
                                                dd($countryList);
                                            }
                                            foreach ($continents as $key => $typeValue) {
                                            ?>

                                                <?php

                                                if ($key == 'uk' || $key == 'eur') {

                                                ?>

                                                    <?php
                                                    if ($key == 'uk') {
                                                        $countryList = isset($countries[$key]) ? $countries[$key] : [];
                                                        if (!empty($countryList)) {

                                                    ?>
                                                            <ul class="uk-ul">
                                                                <?php
                                                                foreach ($countryList as $countryValue) {
                                                                ?>
                                                                    <li>
                                                                        <img src="<?= $countryValue['flag_path'] ?>" alt="" style="width: 36px !important; height:36px !important;border-radius: 50%; -webkit-border-radius: 50%;-moz-border-radius: 50%;-o-border-radius: 50%;">
                                                                        <a href="/country-details/<?= $countryValue['permalink'] ?>"><?= $countryValue['country_name'] ?></a>
                                                                    </li>
                                                                <?php

                                                                    break;
                                                                } ?>
                                                            </ul>
                                                        <?php
                                                        }
                                                    } else if ($key == 'eur') {
                                                        ?>

                                                        <h4 class="title-cn-menu"><?= $typeValue ?></h4>
                                                        <ul>
                                                            <?php
                                                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                                                            if (!empty($countryList)) {
                                                                foreach ($countryList as $countryValue) {
                                                            ?>
                                                                    <li>
                                                                        <img src="<?= $countryValue['flag_path'] ?>" alt="" style="width: 36px !important; height:36px !important;border-radius: 50%; -webkit-border-radius: 50%;-moz-border-radius: 50%;-o-border-radius: 50%;">
                                                                        <a href="/country-details/<?= $countryValue['permalink'] ?>"><?= $countryValue['country_name'] ?></a>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>

                                        </div>


                                        <div class="box-right">
                                            <?php

                                            foreach ($continents as $key => $typeValue) {
                                                if ($key != 'uk' && $key != 'eur') {
                                            ?>
                                                    <h4 class="title-cn-menu"><?= $typeValue ?></h4>
                                                    <ul>
                                                        <?php
                                                        $countryList = isset($countries[$key]) ? $countries[$key] : [];
                                                        if (!empty($countryList)) {
                                                            foreach ($countryList as $countryValue) {
                                                        ?>
                                                                <li>
                                                                    <img src="<?= $countryValue['flag_path'] ?>" alt="" style="width: 36px !important; height:36px !important;border-radius: 50%; -webkit-border-radius: 50%;-moz-border-radius: 50%;-o-border-radius: 50%;">
                                                                    <a href="/country-details/<?= $countryValue['permalink'] ?>"><?= $countryValue['country_name'] ?></a>
                                                                </li>
                                                        <?php
                                                            }
                                                        }

                                                        ?>
                                                    </ul>
                                            <?php
                                                }
                                            }

                                            ?>
                                        </div>

                                    </div>

                                </div>
                            </li>

                        <?php } ?>
                        <li <?= strtolower($current_controller) == 'events' ? 'class="active"' : '' ?>>
                            <a href="/events">Events <i class="fa-solid fa-chevron-down"></i></a>
                            <div class="sub-menu events-sub-menu">
                                <div class="gridCountries-menu">
                                    <div class="left-box">
                                        <div class="box-links">
                                            <h4>
                                                <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="25" height="25">
                                                    <path d="M3.5 0v5m8-5v5m-10-2.5h12a1 1 0 011 1v10a1 1 0 01-1 1h-12a1 1 0 01-1-1v-10a1 1 0 011-1z" stroke="currentColor"></path>
                                                </svg>
                                                Education Fair
                                            </h4>
                                            <ul>
                                                <?php
                                                foreach ($eventsMenuList as $key => $eventValue) {
                                                ?>
                                                    <li>
                                                        <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="25" height="25">
                                                            <path d="M3.5 0v5m8-5v5m-10-2.5h12a1 1 0 011 1v10a1 1 0 01-1 1h-12a1 1 0 01-1-1v-10a1 1 0 011-1z" stroke="currentColor"></path>
                                                        </svg>
                                                        <a href="/event-details/<?= $eventValue['permalink'] ?>"><?= $eventValue['title'] ?></a>
                                                    </li>
                                                <?php } ?>
                                                <!-- <li>
                                                    <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="25" height="25">
                                                        <path d="M4.5 6.995H4v1h.5v-1zm6 1h.5v-1h-.5v1zm-6 1.998H4v1h.5v-1zm6 1.007h.5v-1h-.5v1zm-6-7.003H4v1h.5v-1zM8.5 5H9V4h-.5v1zm2-4.5l.354-.354L10.707 0H10.5v.5zm3 3h.5v-.207l-.146-.147-.354.354zm-9 4.495h6v-1h-6v1zm0 2.998l6 .007v-1l-6-.007v1zm0-5.996L8.5 5V4l-4-.003v1zm8 9.003h-10v1h10v-1zM2 13.5v-12H1v12h1zM2.5 1h8V0h-8v1zM13 3.5v10h1v-10h-1zM10.146.854l3 3 .708-.708-3-3-.708.708zM2.5 14a.5.5 0 01-.5-.5H1A1.5 1.5 0 002.5 15v-1zm10 1a1.5 1.5 0 001.5-1.5h-1a.5.5 0 01-.5.5v1zM2 1.5a.5.5 0 01.5-.5V0A1.5 1.5 0 001 1.5h1z" fill="currentColor"></path>
                                                    </svg>
                                                    <a href="#">Exhibitor's Form</a>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- <div class="right-box" style="justify-self: end;">
                                        <div class="box-links">
                                            <h4>
                                                <i class="fa-solid fa-futbol"></i>
                                                The British Trophy
                                            </h4>

                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </li>
                        <?php if (false) { ?>
                            <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) == 'b2bservices' ? 'class="active"' : '' ?>>
                                <a href="/b2b-services">B2B Services</a>
                            </li>
                            <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'contactus' ? 'class="active"' : '' ?>>
                                <a href="/contact-us">Contact Us</a>
                            </li>
                            <!-- <li class="buttons">
                                <a href="/contact-us" class="btn MainBtn">Apply Now</a>
                            </li> -->
                            <li class="buttons">
                                <?php if (isset($_SESSION['Auth']['User'])) { ?>


                                    <a href="/user/logout" class="btn SecondaryBtn">Logout
                                        <img src="<?=WEBSITE_URL?>img/icon/login.png" alt="">
                                    </a>

                                    <a href="/user" class="btn MainBtn">Profile</a>
                                <?php } else { ?>
                                    <a href="/user/login" class="btn MainBtn">Apply Now</a>

                                    <!-- <a href="/user/login" class="btn SecondaryBtn">Login
                                            <img src="<?=WEBSITE_URL?>img/icon/login.png" alt="">
                                        </a> -->
                                <?php } ?>
                            </li>

                        <?php } ?>
                        <!--<li class="buttons">
                                <a href="#" class="btn SecondaryBtn">Login
                                    <img src="<?=WEBSITE_URL?>img/icon/login.png" alt="" >
                                </a>
                            </li> -->
                    </ul>

                    <div class="buttons apply-now-btn-header">
                        <!-- <a href="/contact-us" class="btn MainBtn">Apply Now</a> -->

                        <div class="search">
                            <input type="search" name="" id="" value="Search">
                        </div>
                        <?php if (isset($_SESSION['Auth']['User'])) { ?>


                            <a href="/user/logout" class="btn SecondaryBtn">Logout
                                <img src="<?=WEBSITE_URL?>img/icon/login.png" alt="">
                            </a>

                            <a href="/user" class="btn MainBtn">Profile</a>
                        <?php } else { ?>
                            <a href="/user/login" class="btn MainBtn">Apply Now</a>

                            <!-- <a href="/user/login" class="btn SecondaryBtn">Login
                                            <img src="<?=WEBSITE_URL?>img/icon/login.png" alt="">
                                        </a> -->
                        <?php } ?>
                        <a href="#" class="btn SecondaryBtn">
                            <img src="<?=WEBSITE_URL?>img/apple.png" alt="">
                        </a>


                    </div>
                    <div class="navbar-mobile">
                        <div class="toggle">
                            <i class="fa-solid fa-bars fa-2x"></i>
                        </div>
                        <div class="sidenav">
                            <div class="colse">
                                <i class="fa-solid fa-xmark fa-2x"></i>
                            </div>
                            <ul>

                                <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'main' ? 'class="active"' : '' ?>>
                                    <a href="/">Home</a>
                                </li>
                                <li <?= strtolower($current_controller) == 'universitycourses' && strtolower($current_action) == 'study' ? 'class="active"' : '' ?>>
                                    <a href="/study">Search</a>
                                </li>
                                <li <?= strtolower($current_controller) == 'universitycourses' && strtolower($current_action) == 'index' ? 'class="active"' : '' ?>>
                                    <a href="/courses">All Courses</a>
                                </li>
                                <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'view' ? 'class="active"' : '' ?>>
                                    <a href="/about-us">About us</a>
                                </li>
                                <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'whereToStudy' ? 'class="active"' : '' ?>>
                                    <a href="/where-to-study">Study</a>
                                </li>
                                <?php if ($this->request->is('mobile')) : ?>
                                    <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) != 'b2bservices' ? 'class="active"' : '' ?>>
                                        <a href="/services">Services</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'countries' ? 'class="active"' : '' ?>>
                                        <a href="/universities">Destinations</a>
                                    </li>
                                    <li <?= strtolower($current_controller) == 'events' ? 'class="active"' : '' ?>>
                                        <a href="/events">Events</a>
                                    </li>
                                <?php endif; ?>
                                <li <?= strtolower($current_controller) == 'services' && strtolower($current_action) == 'b2bservices' ? 'class="active"' : '' ?>>
                                    <a href="/b2b-services">B2B Services</a>
                                </li>
                                <li <?= strtolower($current_controller) == 'pages' && strtolower($current_action) == 'contactus' ? 'class="active"' : '' ?>>
                                    <a href=" /contact-us">Contact Us</a>
                                </li>

                                <?php if (isset($_SESSION['Auth']['User'])) { ?>

                                    <li <?= strtolower($current_controller) == 'users' && strtolower($current_action) == 'profile' ? 'class="active"' : '' ?>>
                                        <a href="/user">Dashboard</a>
                                    </li>
                                <?php } ?>

                                <!-- <li class="buttons">
                                    <a href="/user/login" class="btn MainBtn">Apply Now</a>
                                </li> -->
                                <li class="buttons">
                                    <?php if (isset($_SESSION['Auth']['User'])) { ?>


                                        <a href="/user/logout" class="btn SecondaryBtn">Logout
                                            <img src="<?=WEBSITE_URL?>img/icon/login.png" alt="">
                                        </a>

                                        <a href="/user" class="btn MainBtn">Profile</a>
                                    <?php } else { ?>
                                        <a href="/user/login" class="btn MainBtn">Apply Now</a>

                                        <!-- <a href="/user/login" class="btn SecondaryBtn">Login
                                            <img src="<?=WEBSITE_URL?>img/icon/login.png" alt="">
                                        </a> -->
                                    <?php } ?>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>