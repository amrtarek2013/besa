<section class="main-banner  inner-serv unitedKingdom-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <!-- <img src="/img/hero-bg6.png" alt=""> -->
                    <img src="<?= $country['image_path'] ?>" alt="">
                    <img src="/img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">
                        <?= substr($country['country_name'],0,6) ?>
                    </h1>
                    <h2 class="title text-left">
                        <?= $country['country_name'] ?>
                    </h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="title-banner-blue">
                    <h3>
                        <?= $country['title'] ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>


</section>

<section class="just-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="descrp">
                    <?= $country['top_text'] ?>

                </p>
                <!-- <p class="descrp">
                        On the other hand, studying in Northern parts of the UK is always beneficial in many ways. For example, the Scottish system of education is quite distinct from other education systems in the UK. Higher education courses in Scotland are usually one year
                        longer than in other parts of the country. The UK in fact has rich opportunities for international students with all kinds of interest.
                    </p> -->
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
                        <img src="<?= $country['image_why_study_path'] ?>" alt="" class="circle-img">
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


<section class="tabes">
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
                            <!-- <a href="#" class="btn clear-blue foundation">Foundation</a>
                        <a href="#" class="btn light-red pre-sessional ">Pre-sessional </a>
                        <a href="#" class="btn gold-tips bachelor">Bachelor</a>

                        <a href="#" class="btn greenish-teal master">Master</a>
                        <a href="#" class="btn slate-grey phd">PhD</a>
                        <a href="#" class="btn white vocational">Vocational</a> -->
                    <?php
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>
</section>