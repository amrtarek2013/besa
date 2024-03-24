<!-- <section class="header ">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> -->

<div class="main-slider owl-carousel owl-theme">
    <?php

    use Cake\Routing\Router;

    if (!empty($sliders)) {
        foreach ($sliders as $key => $slider) {
           

    ?>
            <div class="item">

                <div class="background-image-slider">
                    <?php
                    if (isset($slider['image_path'])) {
                    ?>

                        <img class="<?php echo $slider['title'] ?>" src="<?php echo $slider['image_path'] ?>"></img>';

                    <?php
                    }
                    ?>
                </div>
            </div>
    <?php
        }
    } ?>
</div>
<!-- </div>
        </div>
    </div>
</section> -->