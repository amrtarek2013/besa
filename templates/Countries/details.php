<section class="main-banner  inner-serv unitedKingdom-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="ukslider owl-carousel owl-theme">
                    <?php if (sizeof($countryImages) > 0) : ?>
                        <?php foreach ($countryImages as $countryImage) : ?>
                            <div class="item">
                                <img src="<?= $countryImage['image_path'] ?>" alt="">
                                <div class="blue-qoute">
                                    <h4><?= $countryImage['title'] ?></h4>
                                    <p>
                                        <?= $countryImage['short_text'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="item">
                            <img src="/img/banner-45.png" alt="">
                            <div class="blue-qoute">
                                <h4>The <?= $country['country_name'] ?></h4>
                                <p>
                                    The <?= $country['country_name'] ?> of Great Britain and Northern Ireland,
                                    commonly known as the <?= $country['country_name'] ?> (<?= $country['country_code'] ?>) or Britain is a country in Western Europe,
                                    off the north-western coast of the continental mainland. It comprises England, Scotland,
                                    Wales and Northern Ireland.
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <div class="col-md-12">
                <a class="title-banner-blue greenish-teal" href="#">
                    <h3>APPLY TO STUDY IN <?= $country['country_code'] ?></h3>
                </a>
            </div>
        </div>
    </div>


</section>



<section class="whyStudy">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridWhyStudy">
                    <div class="image">
                        <img src="<?= $country['image_path'] ?>" alt="" class="circle-img">
                    </div>
                    <div class="text">
                        <h4 class="title">Why Study In The <?= $country['country_code'] ?>?</h4>
                        <?= $country['why_text'] ?>
                        <a href="#" class="btn MainBtn clear-blue ">
                            Apply Now
                            <img src="/img/icon/arrow-right.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $country['top_text'] ?>
<!--<section class="tabes">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridTabes">
                    <?php
                    $bgcolors = [
                        'clear-blue foundation',
                        'light-red pre-sessional',
                        'gold-tips bachelor',
                        'greenish-teal master',
                        'slate-grey phd',
                        'white vocational',
                    ];
                    if (!empty($countryServices)) {
                        foreach ($countryServices as $key => $service) {
                    ?>
                            <a href="/service-details/<?= $service['permalink'] ?>" class="btn <?= isset($bgcolors[$key]) ? $bgcolors[$key] : 'clear-blue foundation' ?>"><?= $service['title'] ?></a>

                    <?php
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>
    </section> -->