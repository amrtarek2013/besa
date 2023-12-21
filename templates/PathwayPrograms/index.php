<div class="hero-section hero-placement hero-pathway-Programs">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-Pathway-Programs.png" alt="hero Young learners">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Pathway  <span>Programs</span> </h1>
        </div>
    </div>
</div>

    <?php //$this->element('placement_list', ['placementList' => $pathwayPrograms]); ?>
    <?php

    // print_r($placementList);
    if (!empty($pathwayPrograms)) : ?>
        <div class="FoundationProgramFAQs list-Pathway-Programs">
            <?php
            $i=0;
            
             foreach ($pathwayPrograms as $placementItem) :
                $i++;
            ?>
                    <div class="itemFAQs">
                        <div class="box-item ">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/<?php echo $i."icon_flag" ?>.png" alt="" class="flag-screenM">

                             <!-- <img  class="flag-screenM" 
                             src="<?php// $placementItem['image_path'] ?>" 
                             alt="<?php// $placementItem['title'] ?>" loading="lazy"> -->

                            <div class="content-blog">
                                <div class="title-box">
                                    <h4><?= $placementItem['title'] ?></h4>
                                </div>
                                <?= $placementItem['short_text'] ?>
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/<?php echo $i."icon_flag_desktop" ?>.png" alt="" class="flag-screenD">

                            </div>       
                        </div>
                    </div>


            <?php endforeach; ?>
            
            </div>

        </div>
    
    <?php endif; ?>



<?= $book_free_meeting ?>