<div class="hero-section hero-learners">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-learners.png" alt="hero Young learners">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Young Learners </h1>
        </div>
    </div>

</div>

<section class="main-banner banner-about-us university-Placement-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" style="position: relative;">
                <div class="relative-box-about ">
                    <h1 class="relative-text">v</h1>
                    <h2 class="title text-left">YOUNG <br> LEARNERS</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg44.png" alt="" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>

        </div>
    </div>

    <?= $this->element('placement_list', ['placementList' => $youngLearners]); ?>
</section>
<?= $book_free_meeting ?>