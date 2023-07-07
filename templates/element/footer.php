<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridContainer-footer">
                    <div class="logo">
                        <img src="<?= $g_configs['general']['file.main_logo'] ?>" alt="" width="165">
                        <div class="icons">
                            <a href="<?= $g_configs['social_links']['txt.facebook_link'] ?>" class="facebook" target="_blank">
                                <img src="/img/icon/facebook.svg" alt="">
                            </a>
                            <a href="<?= $g_configs['social_links']['txt.instagram_link'] ?>" class="instagram">
                                <img src="/img/icon/instagram.svg" alt="" target="_blank">
                            </a>
                            <a href="<?= $g_configs['social_links']['txt.youtube_link'] ?>" class="youtube" target="_blank">
                                <img src="/img/icon/youtube.svg" alt="">
                            </a>
                            <a href="<?= $g_configs['social_links']['txt.linkedin_link'] ?>" class="linkedin" target="_blank">
                                <img src="/img/icon/linkedin.svg" alt="">
                            </a>
                            <a href="<?= $g_configs['social_links']['txt.twitter_link'] ?>" class="twitter" target="_blank">
                                <img src="/img/icon/twitter.svg" alt="">
                            </a>
                        </div>
                    </div>


                    <div class="list1">
                        <h4 class="titleFootar">RESOURCES</h4>
                        <div class="list-des">
                            <ul>
                                <li>
                                    <a href="/blogs"> Blogs</a>
                                </li>

                                <li>
                                    <a href="#"> Newsletter</a>
                                </li>
                                <li>
                                    <a href="#"> App Support</a>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="list2">
                        <h4 class="titleFootar">CONNECT WITH BESA</h4>
                        <div class="list">
                            <ul>
                                <li>
                                    <a href="#"><?= __('Book an appointment') ?></a>
                                </li>
                                <li>
                                    <a href="/contact-us"><?= __('Contact us') ?></a>
                                </li>
                                <li>
                                    <a href="/content/book-free-counselling-session"><?= __('Schools councillors portal') ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="list2">
                        <h4 class="titleFootar">ABOUT</h4>
                        <div class="list">
                            <ul>
                                <li>
                                    <a href="/about-us"><?= __('About Us') ?></a>
                                </li>
                                <li>
                                    <a href="#"><?= __('Partnerships') ?></a>
                                </li>
                                <li>
                                    <a href="/careers"><?= __('Careers') ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php if (false) { ?>
                        <div class="list1">
                            <h4 class="titleFootar">SERVICES</h4>
                            <div class="list-des">
                                <ul>
                                    <?php
                                    foreach ($servicesList as $key => $serviceValue) {
                                    ?>
                                        <li>
                                            <a href="/service-details/<?= $serviceValue['permalink'] ?>"> <?= strtoupper($serviceValue['title']) ?></a>
                                        </li>
                                    <?php
                                        if ($key == 4) {
                                            echo '</ul><ul>';
                                        }
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>
                        <div class="list2">
                            <h4 class="titleFootar">DESTINATIONS</h4>
                            <div class="list-des">
                                <ul>
                                    <?php

                                    $left_box = '<div class="box-left">';
                                    foreach ($continents as $key => $typeValue) {
                                    ?>

                                        <?php

                                        if ($key == 'uk' || $key == 'eur') {

                                        ?>
                                            <li><a href="#" class="bold"><?= $typeValue ?></a></li>
                                            <?php

                                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                                            if (!empty($countryList)) {

                                                foreach ($countryList as $countryValue) {
                                            ?>
                                                    <li><a href="/country-details/<?= $countryValue['permalink'] ?>"><?= $countryValue['country_name'] ?></a></li>
                                                <?php
                                                    if ($key == 'uk')
                                                        break;
                                                } ?>
                                    <?php

                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                                <ul>
                                    <?php

                                    foreach ($continents as $key => $typeValue) {
                                    ?>

                                        <?php

                                        if ($key != 'uk' && $key != 'eur') {

                                        ?>
                                            <li><a href="#" class="bold"><?= $typeValue ?></a></li>
                                            <?php

                                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                                            if (!empty($countryList)) {

                                                foreach ($countryList as $countryValue) {
                                            ?>
                                                    <li><a href="/country-details/<?= $countryValue['permalink'] ?>"><?= $countryValue['country_name'] ?></a></li>
                                                <?php

                                                } ?>
                                    <?php

                                            }
                                        }
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>
                        <div class="list2">
                            <h4 class="titleFootar">EVENTS</h4>
                            <div class="list">
                                <ul>
                                    <?php
                                    foreach ($eventsMenuList as $key => $eventValue) {
                                    ?>
                                        <li>
                                            <a href="/event-details/<?= $eventValue['permalink'] ?>"><?= strtoupper($eventValue['title']) ?></a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>
                        </div>

                        <div class="list2">
                            <h4 class="titleFootar">BESA Resources</h4>
                            <div class="list">
                                <ul>
                                    <li>
                                        <a href="/content/about"><?= __('About Us') ?></a>
                                    </li>
                                    <li>
                                        <a href="/content/careers"><?= __('Careers') ?></a>
                                    </li>
                                    <li>
                                        <a href="/content/blog"><?= __('Blog') ?></a>
                                    </li>
                                    <li>
                                        <a href="/contact-us"><?= __('Contact Us') ?></a>
                                    </li>
                                    <li>
                                        <a href="/content/book-free-counselling-session"><?= __('Book A FREE Counselling Session') ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="list2">
                            <h4 class="titleFootar">Partners</h4>
                            <div class="list">
                                <ul>
                                    <li>

                                        <a href="/b2b-services"><?= __('B2B Services') ?></a>
                                    </li>
                                    <li>
                                        <a href="/content/partnerships"><?= __('Partnerships') ?></a>
                                    </li>
                                    <li>
                                        <a href="/content/school-counselling-portal"><?= __('School Counselling Portal') ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <?= $g_configs['general']['txt.footer_copy_right_text'] ?>
    </div>
</section>
<div class="go-up">
    <span class="up " id="scrollToTop" style="display: none;">
        <img src="/img/red-arrow-top.svg" alt="">
    </span>
</div>