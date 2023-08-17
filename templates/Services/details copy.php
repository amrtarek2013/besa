<section class="main-banner inner-serv">
    <div class="background-banner background-services" style="background: url(<?= $service['banner_image_path'] ?>) !important">
        <div id="overlay_header-bottom"></div>

    </div>
    <div class="custome-background-serv-inner">
        <div class="container ">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h2 class="title-banner">
                            <?= $service['title'] ?>
                        </h2>
                        <div class="custome-text-en">
                            <p>
                                <?= $service['text'] ?>
                            </p>
                            <div class="text">
                                <p class="descrp">

                                    <?= $service['left_text'] ?>
                                </p>
                                <div class="right-dots-img">
                                    <img src="<?=WEBSITE_URL?>img/icon/dots-bakground.svg" alt="">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="line-ellipse">
            <span></span>
            <span></span>
            <span></span>
            <span></detailsspan>
        </div>
    </div>

</section>

<section class="countries-inner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">COUNTRIES THAT OFFER <span class="green">BACHELOR</span> DEGREE </h2>
                <div class="gridCountries">
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/UK.png" alt="">
                            <h5 class="title-country">United Kingdom</h5>
                        </a>
                    </div>
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/USA.png" alt="">
                            <h5 class="title-country">USA</h5>
                        </a>
                    </div>
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/Canada.png" alt="">
                            <h5 class="title-country">Canada</h5>
                        </a>
                    </div>
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/Lithuania.png" alt="">
                            <h5 class="title-country"> Lithuania</h5>
                        </a>
                    </div>
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>" id="">
                            <img src="<?=WEBSITE_URL?>img/Malaysia.png" alt="">
                            <h5 class="title-country">Malaysia</h5>
                        </a>
                    </div>

                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/Spain.png" alt="">
                            <h5 class="title-country">Spain</h5>
                        </a>
                    </div>
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/Germany.png" alt="">
                            <h5 class="title-country">Germany</h5>
                        </a>
                    </div>
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/Netherlands.png" alt="">
                            <h5 class="title-country">Netherlands</h5>
                        </a>
                    </div>
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/Switzerland.png" alt="">
                            <h5 class="title-country">SWITZERLAND</h5>
                        </a>
                    </div>
                    <div class="box">
                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['services.details']) ?>">
                            <img src="<?=WEBSITE_URL?>img/Russia.png" alt="">
                            <h5 class="title-country">Russia</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>