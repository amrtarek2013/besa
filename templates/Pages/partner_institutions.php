<?php

use Cake\Routing\Router;
?>

<div class="hero-section hero-partner">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-partner.png" alt="hero partner">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Partner <span>Institutions</span> </h1>
        </div>
    </div>

</div>

<div class="frames">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex item-frame">
                    <div class="text">
                        <h4>BESA is proud to work with over 400 institutions worldwide</h4>
                    </div>
                    <div class="image">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/frame-1.png" alt="" loading="lazy">
                    </div>
                </div>
                <div class="d-flex item-frame">
                    <div class="image">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/frame-2.png" alt="" loading="lazy">
                    </div>
                    <div class="text">
                        <h4>Our global presence allows you to access international universities, schools and programs.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class=" partner-banner ">

    <?= $this->element("choose-place-earth", ['left_html' => $partner_institutions_left_boxs, 'colWidth' => '8', 'redirectUrl' => 'unvertsities']) ?>

    <?= $partner_institutions_bottom_section ?>
</section>

<section class="tabes tabes2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridTabes">
                    <a href="<?= Router::url('/'.$g_dynamic_routes['countries.index']) ?>" class="btn clear-blue foundation">EXPLORE STUDYING ABROAD</a>

                    <a href="<?= Router::url('/user/register') ?>" class="btn greenish-teal master">REGISTER NOW</a>


                </div>
            </div>
        </div>
    </div>
</section>