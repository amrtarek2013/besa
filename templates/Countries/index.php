<section class="main-banner  whereToStudy-banner destinations-banner">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Destinations</h1>
                    <h2 class="title text-left">Destinations</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/Destinations 1.png" alt="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
        </div>
    </div>
</section>



<?= $this->element('countries', ['showImageCountries' => true]) ?>

<?= $this->element("choose-place-earth", ['colWidth' => '9', 'redirectUrl' => 'destination']) ?>

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