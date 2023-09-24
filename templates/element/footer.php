<?php

use Cake\Routing\Route\Route;
use Cake\Routing\Router;

?>
<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridContainer-footer">
                    <div class="logo">
                        <img loading="lazy" src="<?= $g_configs['general']['file.main_logo'] ?>" alt="main_logo" width="165">
                        <div class="icons">
                            <a href="<?= $g_configs['social_links']['txt.facebook_link'] ?>" class="facebook" target="_blank">
                                <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/facebook.svg" width="" alt="facebook">
                            </a>
                            <a href="<?= $g_configs['social_links']['txt.instagram_link'] ?>" class="instagram">
                                <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/instagram.svg" width="" alt="instagram" target="_blank">
                            </a>
                            <a href="<?= $g_configs['social_links']['txt.youtube_link'] ?>" class="youtube" target="_blank">
                                <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/youtube.svg" width="" alt="youtube">
                            </a>
                            <a href="<?= $g_configs['social_links']['txt.linkedin_link'] ?>" class="linkedin" target="_blank">
                                <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/linkedin.svg" width="" alt="linkedin">
                            </a>
                            <a href="<?= $g_configs['social_links']['txt.twitter_link'] ?>" class="twitter" target="_blank">
                                <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/twitter.svg" width="" alt="twitter">
                            </a>
                        </div>
                    </div>


                    <div class="list1">
                        <h4 class="titleFootar">RESOURCES</h4>
                        <div class="list-des">
                            <ul>
                                <li>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['blogs.index']) ?>"> Blogs</a>
                                </li>

                                <li>
                                    <a href="#newsletter"> Newsletter</a>
                                </li>
                                <li>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['pages.appsupport']) ?>"> App Support</a>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="list2">
                        <h4 class="titleFootar">CONNECT WITH BESA</h4>
                        <div class="list">
                            <ul>
                                <li>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['enquiries.bookappointment']) ?>"><?= __('Book an appointment') ?></a>
                                </li>
                                <li>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['enquiries.contactus']) ?>"><?= __('Contact us') ?></a>
                                </li>
                                <li>
                                    <a href="<?= Router::url('/counselor') ?>"><?= __('School counselors portal') ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="list2">
                        <h4 class="titleFootar">ABOUT</h4>
                        <div class="list">
                            <ul>
                                <li>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['pages.aboutus']) ?>"><?= __('About Us') ?></a>
                                </li>
                                <li>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['pages.partnershipwithbesa']) ?>"><?= __('Partnerships') ?></a>
                                </li>
                                <li>
                                    <a href="<?= Router::url('/' . $g_dynamic_routes['careers.index']) ?>"><?= __('Careers') ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
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
        <img loading="lazy" src="<?= WEBSITE_URL ?>img/red-arrow-top.svg" width="" alt="">
    </span>
</div>


<script>
    (function(w, d, u) {
        var s = d.createElement('script');
        s.async = true;
        s.src = u + '?' + (Date.now() / 60000 | 0);
        var h = d.getElementsByTagName('script')[0];
        h.parentNode.insertBefore(s, h);
    })(window, document, 'https://cdn.bitrix24.com/b16120715/crm/site_button/loader_3_d2o61u.js');
</script>