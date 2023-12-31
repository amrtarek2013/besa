<section class="main-banner  whereToStudy-banner">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Where</h1>
                    <h2 class="title text-left">Where to Study</h2>
                    <p class="relative-textP">BESA Can Help You Study in Over 10 Countries</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg5.png" alt="" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->element('countries', [], ['cache' => ['key' => 'where_to_study_countries', 'config' => '_view_long_']]) ?>


<?php /*= $this->element("earth", [], ['cache' => ['key' => 'earth', 'config' => '_view_long_']])*/ ?>
<?= $this->element("choose-place-earth", ['colWidth' => '9', 'redirectUrl' => 'destination'], ['cache' => ['key' => 'choose_place_earth', 'config' => '_view_long_']]) ?>