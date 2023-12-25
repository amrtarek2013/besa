<section class="countries-inner" <?= isset($showImageCountries) ? 'style=" padding: 50px 0"' : '' ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-countries">Choose <span>where</span> to study</h2>
                <?php if (isset($showImageCountries)) { ?>
                    <div class="image-contry">
                        <img src="<?=WEBSITE_URL?>img/new-desgin/earth-2.png" alt="">
                    </div>
                <?php } ?>

                <?php if (isset($serviceTitleList)) { ?>
                    <h2 class="title">COUNTRIES THAT OFFER <span class="green"><?= strtoupper($serviceTitleList[0]) ?></span>
                        <?php unset($serviceTitleList[0]);
                        echo strtoupper(implode(' ', $serviceTitleList));
                        ?>

                    </h2>

                <?php } ?>
                <div class="containerCountry">
                    <?php 
                    foreach ($continents as $key => $typeValue) {

                        if (1||$key == 'uk' || $key == 'na') {

                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                            if (!empty($countryList)) {
                                foreach ($countryList as $countryValue) {
                    ?>
                                    <div class="box-country">
                                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['countries.details']) ?>/<?= $countryValue['permalink'] ?>">
                                            <img src="<?= $countryValue['flag_path'] ?>" alt="" style="">
                                            <h4><?= $countryValue['country_name'] ?></h4>
                                        </a>
                                    </div>

                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </div>
                <?php if(false){?>
                <div class="containerCountry grid5country ">
                    <?php
                    foreach ($continents as $key => $typeValue) {
                    ?>
                        <?php
                        if ($key == 'eur') {
                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                            if (!empty($countryList)) {
                                foreach ($countryList as $countryValue) {
                        ?>
                                    <div class="box-country">
                                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['countries.details']) ?>/<?= $countryValue['permalink'] ?>">
                                            <img src="<?= $countryValue['flag_path'] ?>" alt="" style="">
                                            <h4><?= $countryValue['country_name'] ?></h4>
                                        </a>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="containerCountry grid2country">
                    <?php
                    foreach ($continents as $key => $typeValue) {
                        if ($key == 'other') {

                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                            if (!empty($countryList)) {
                                foreach ($countryList as $countryValue) {
                    ?>
                                    <div class="box-country">
                                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['countries.details']) ?>/<?= $countryValue['permalink'] ?>">
                                            <img src="<?= $countryValue['flag_path'] ?>" alt="" style="">
                                            <h4><?= $countryValue['country_name'] ?></h4>
                                        </a>
                                    </div>
                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </div>
               
                <?php  }?>

            </div>
        </div>
    </div>
</section>