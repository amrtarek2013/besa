<div class="hero-section hero-placement hero-destinations">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-destinations.png" alt="hero destinations">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Destinations </h1>
        </div>
    </div>
</div>




<?= $this->element('countries', ['showImageCountries' => true]) ?>

<?php // $this->element("choose-place-earth", ['colWidth' => '9', 'redirectUrl' => 'destination']) ?>

<!-- <section class="countries-inner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">COUNTRIES THAT OFFER <span class="green">BACHELOR</span> DEGREE </h2>
                <div class="gridCountries">

                    <?php

                    use Cake\Routing\Router;

                    if (!empty($countriesData)) {
                        foreach ($countriesData as $key => $country) {

                    ?>
                            <div class="box">
                                <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['countries.details']) ?>/<?= $country['permalink'] ?>">
                                    <img src="<?= $country['flag_path'] ?>" alt="">
                                    <h5 class="title-country"><?= $country['country_name'] ?></h5>
                                </a>
                            </div>
                    <?php
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>

</section> -->