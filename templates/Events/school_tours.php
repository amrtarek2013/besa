<section class="main-banner british-banner fair-banner <?= $event['style'] ?>" style="padding-bottom:0 !important;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="/img/31098 [Converted] 1.png" alt="" style="z-index: 2;" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">

                    <?php $tt = explode(' ', trim($event['title'])) ?>
                    <h1 class="relative-text"><?= substr($tt[0], 0, 6) ?></h1>
                    <h2 class="title text-left"><?= $event['title'] ?></h2>

                </div>
            </div>
        </div>
    </div>
</section>