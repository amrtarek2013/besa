<section class="main-banner servicesSec">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?=WEBSITE_URL?>img/hero-bg2.png" alt="" width="100%" height="100%">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" width="100%" height="100%" alt="" class="relative-dots-about">
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
    <!-- <div class="line-ellipse line-ellipse3col">
        <span></span>
        <span></span>
        <span></span>
    </div> -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridServices">

                    <div class="left-line line-ellipse-en">
                        <?php

                        use Cake\Routing\Router;

                        if (!empty($services)) {
                            $counter = 0;
                            $mid = round(sizeof($services)/2);
                            foreach ($services as $key => $service) {
                                $counter++;


                        ?>
                                <div class="box-icon" style="cursor: pointer;" onclick="openPage('<?= $service['permalink'] ?>')">

                                    <header>
                                        <div class="icon-circle">
                                            <img src="<?= $service['icon_path'] ?>" alt="">
                                        </div>
                                        <h4 class="title-icon"><?= strtoupper($service['title']) ?></h4>
                                        <!-- <h4 class="title-icon"><?= str_replace(' ', ' <br />', strtoupper($service['title'])) ?></h4> -->

                                    </header>

                                    <div class="descrip">
                                        <p>
                                            <?= substr($service['text'], 0, 120) ?>
                                            <!-- <strong>
                                                unsure on how to start a UCAS application? </strong> <br>
                                            our dedicated counselors will manage your application supporting you through your journey to study abroad. -->
                                        </p>
                                    </div>
                                </div>
                        <?php
                                if ($counter == $mid) {
                                    $counter = 0;
                                    echo '</div><div class="right-line line-ellipse-en">';
                                }
                            }
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


<?= $book_free_meeting ?>
<script>
    function openPage(link) {
        // window.location.replace("<?= Router::url('/service-details/') ?>" + link);
    }
</script>