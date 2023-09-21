<div class="step-back-slider">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title_28">Step Back in Time: Our Unforgettable Fair Memories!</h2>

                <div class="slider">
                    <div class="owl-carousel owl-step-back ">
                        <?php

                        foreach ($event_images as $img) {
                        ?>
                            <div class="item">
                                <div class="image-box">
                                    <img src="<?= $img['image_path'] ?>" alt="">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>