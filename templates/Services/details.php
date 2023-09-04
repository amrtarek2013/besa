<section class="main-banner  inner-serv">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?=WEBSITE_URL?>img/hero-bg4.png" alt=""  width="">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <?php $tt = explode(' ', trim($service['title'])) ?>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text"><?= substr($tt[0], 0, 6) ?></h1>
                    <h2 class="title text-left"><?= $service['title'] ?><br><br></h2>
                </div>
            </div>

        </div>
    </div>
    <div style="background: #fff;">
        <div class="container ">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <div class="custome-text-en">
                            <p class="descrp">
                                <?= $service['text'] ?>
                            </p>
                            <p class="descrp">

                                <?= $service['left_text'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="line-ellipse">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

</section>

<?= $this->element('countries', ['serviceTitleList' => $tt]) ?>