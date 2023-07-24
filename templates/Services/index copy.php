<section class="main-banner servicesSec">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?=WEBSITE_URL?>img/hero-bg2.png" alt="">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Services</h1>
                    <h2 class="title text-left">Services</h2>
                </div>
            </div>

            <!-- <div class="col-md-12">
                <div class="page_texts text-Services">

                    <?= $services_page_text ?>
                    
                </div>
            </div> -->
        </div>
    </div>
</section>

<section class="services-rendered">
    <div class="line-ellipse line-ellipse3col">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridServices">
                    <?php

                    use Cake\Routing\Router;

                    if (!empty($services)) {
                        foreach ($services as $key => $service) {

                    ?>
                            <div class="box-icon" style="cursor: pointer;" onclick="openPage('<?= $service['permalink'] ?>')">
                                <div class="icon-circle">
                                    <img src="<?= $service['icon_path'] ?>" alt="">
                                </div>
                                <h4 class="title-icon"><?= str_replace(' ', ' <br />', strtoupper($service['title'])) ?></h4>
                            </div>
                    <?php
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>

</section>
<script>
    function openPage(link) {
        window.location.replace("<?= Router::url('/service-details/') ?>" + link);
    }
</script>