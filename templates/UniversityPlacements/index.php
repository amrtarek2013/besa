<section class="main-banner banner-about-us university-Placement-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" style="position: relative;">
                <div class="relative-box-about ">
                    <h1 class="relative-text">University <br> Placement</h1>
                    <h2 class="title text-left">University <br> Placement</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?=WEBSITE_URL?>img/hero-bg44.png" alt="" width="100%" height="100%">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" width="100%" height="100%" alt="" class="relative-dots-about">
                </div>
            </div>

        </div>
    </div>

    <?=$this->element('placement_list', ['placementList' => $universityPlacements]); ?>
</section>
<?= $book_free_meeting ?>