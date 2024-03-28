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
 
<?= $this->element('countries', [], ['cache' => ['key' => 'where_to_study_countries', 'config' => '_view_long_']]) ?>


<?php /*= $this->element("earth", [], ['cache' => ['key' => 'earth', 'config' => '_view_long_']])*/ ?>
<?php // $this->element("choose-place-earth_image", ['colWidth' => '9', 'redirectUrl' => 'destination'], ['cache' => ['key' => 'choose_place_earth', 'config' => '_view_long_']]) ?>
<?= $this->element("miniature-earth_image", ['colWidth' => '9', 'redirectUrl' => 'destination', 'pageType' => 'home'], ['cache' => ['key' => 'choose_place_earth_home', 'config' => '_view_long_']]) ?>
