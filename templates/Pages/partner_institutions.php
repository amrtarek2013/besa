<?php

use Cake\Routing\Router;
?>
<section class="main-banner partner-banner university-Placement-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-b99.png" alt="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6" style="position: relative;">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Partner <br> Institutions</h1>
                    <h2 class="title text-left">Partner <br> Institutions</h2>
                </div>
            </div>
        </div>
    </div>


    <?= $this->element("choose-place-earth", ['left_html' => $partner_institutions_left_boxs, 'colWidth' => '8', 'redirectUrl' => 'unvertsities']) ?>

    <?= $partner_institutions_bottom_section ?>
</section>

<section class="tabes tabes2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridTabes">
                    <a href="<?= Router::url('/destinations') ?>" class="btn clear-blue foundation">EXPLORE STUDYING ABROAD</a>

                    <a href="<?= Router::url('/user/register') ?>" class="btn greenish-teal master">REGISTER NOW</a>


                </div>
            </div>
        </div>
    </div>
</section>