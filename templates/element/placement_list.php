<?php

// print_r($placementList);
if (!empty($placementList)) : ?>
    <div class="FoundationProgramFAQs">
        <?php foreach ($placementList as $placementItem) :
        ?>
                <div class="itemFAQs">
                    <div class="box-item display-flex">
                        <img src="<?= $placementItem['image_path'] ?>" alt="<?= $placementItem['title'] ?>" loading="lazy">
                        <div class="content-blog">
                            <h4><?= $placementItem['title'] ?></h4>
                            <?= $placementItem['short_text'] ?>
                        </div>       
                    </div>
                </div>


        <?php endforeach; ?>
        
        </div>

    </div>
  
<?php endif; ?>