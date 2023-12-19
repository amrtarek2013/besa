
<div class="hero-section hero-services">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-services.png" alt="hero services">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Services </h1>
        </div>
    </div>

</div>


<!-- <section class=" servicesSec" >
    <div class="container">
        <div class="row">
          

             <div class="col-md-12">
                <div class="page_texts text-Services">

                    <?php // $services_page_text ?>
                    
                </div>
            </div> 
        </div>
    </div>
</section> -->

<section class="services-rendered">
   
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridServices">

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
                                
                            }
                        } ?>

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