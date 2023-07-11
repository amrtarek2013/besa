<?php

// print_r($placementList);
if (!empty($placementList)) : ?>
    <?php foreach ($placementList as $placementItem) :

    ?>

        <div class="FoundationProgramFAQs">

            <div class="itemFAQs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-item display-flex">
                                <img src="<?= $placementItem['image_path'] ?>" alt="<?= $placementItem['title'] ?>" loading="lazy">
                                <div class="content-blog">
                                    <p><?= $placementItem['title'] ?></p>
                                    <?= $placementItem['short_description'] ?>
                                    <!-- <ul>
                                        <li>What is pre sessional English?</li>
                                        <li>What is the entry requirement for pre-sessional English?</li>
                                        <li>How will a pre-sessional English course support my further studies?</li>
                                        <li>Which countries offer pre-sessional English?</li>
                                        <li>How long is a pre-sessional English course?</li>
                                    </ul> -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    <?php endforeach; ?>
<?php endif; ?>