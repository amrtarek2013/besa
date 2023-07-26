<section class="countries-inner" <?= isset($showImageCountries) ? 'style=" padding: 50px 0"' : '' ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-countries">EXPLORE STUDYING ABROAD</h2>

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

                        if ($key == 'UK' || $key == 'North America') {

                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                            if (!empty($countryList)) {
                                foreach ($countryList as $countryValue) {
                    ?>
                                    <div class="box-country">
                                        <a href="/country-details/<?= $countryValue['permalink'] ?>">
                                            <img src="<?= $countryValue['flag_path'] ?>" alt="" style="width: 92px !important; height:92px !important;border-radius: 50%; -webkit-border-radius: 50%;-moz-border-radius: 50%;-o-border-radius: 50%;">
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
                <div class="containerCountry grid5country ">
                    <?php
                    foreach ($continents as $key => $typeValue) {
                    ?>
                        <?php
                        if ($key == 'Europe') {
                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                            if (!empty($countryList)) {
                                foreach ($countryList as $countryValue) {
                        ?>
                                    <div class="box-country">
                                        <a href="/country-details/<?= $countryValue['permalink'] ?>">
                                            <img src="<?= $countryValue['flag_path'] ?>" alt="" style="width: 92px !important; height:92px !important;border-radius: 50%; -webkit-border-radius: 50%;-moz-border-radius: 50%;-o-border-radius: 50%;">
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
                        if ($key == 'ASIA') {

                            $countryList = isset($countries[$key]) ? $countries[$key] : [];
                            if (!empty($countryList)) {
                                foreach ($countryList as $countryValue) {
                    ?>
                                    <div class="box-country">
                                        <a href="/country-details/<?= $countryValue['permalink'] ?>">
                                            <img src="<?= $countryValue['flag_path'] ?>" alt="" style="width: 92px !important; height:92px !important;border-radius: 50%; -webkit-border-radius: 50%;-moz-border-radius: 50%;-o-border-radius: 50%;">
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
                <?php if (isset($showImageCountries)) { ?>
                    <div class="image-contry">
                        <img src="<?=WEBSITE_URL?>img/1603.m00.i125.n038.S.c12 1.png" alt="">
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</section>