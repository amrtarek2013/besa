<?= $this->Html->css([
    '/css/new-css/timeline.css'
]) ?>

<div class="hero-section hero-about-us">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-aboutus.png" alt="hero about us">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">About Us</h1>
        </div>
    </div>

</div>
<section class="bottom-hero-section ">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="">
                <div class="title-bottom-hero">
                    <h4>BESA <span> ( British Educational Service Group  ) </span></h4>
                    <p class="description">
                        is an international organization with branches in egypt, sudan,kuwait and the UK its 
                        deliciated to is an international organization with branches in egypt, sudan,kuwait and the UK its deliciated to    
                    </p>
                </div>
            </div>

            

            
            <?= $aboutusSnippet ?>
        </div>
    </div>
</section>

<section class="sectionTimeline">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">We have a great  journey through many years of experience</h2>
                <div class="timeline-container timeline-theme-1">
                    <div class="timeline js-timeline custome-timeline">


                        <?php if (!empty($aboutusSlidersList)) : ?>
                            <?php foreach ($aboutusSlidersList as $aboutSlider) : ?>
                                <div data-time="<?= $aboutSlider['year'] ?>">
                                    <div class="container-item-data">
                                        <div class="text">
                                            <h4 class="title"><?= $aboutSlider['title'] ?></h4>
                                            <p class="descrp"><?= $aboutSlider['short_description'] ?></p>

                                        </div>
                                        <div class="image">
                                            <img src="<?= $aboutSlider['image_path'] ?>" alt="">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?= $this->element('aboutus_slider', ['aboutusSlidersList' => $aboutusSlidersList]) ?>

                </div>
            </div>
            <div class="col-md-12 col-nav">
                <div class="nav-timeline">
                    <button class="prev" id="prevTimeline">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/prev-arrow.svg" alt="">
                    </button>
                    <button class="next" id="nextTimeline">
                        <img src="<?= WEBSITE_URL ?>img/new-desgin/next-arrow.svg" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->Html->script([
    '/js/new-js/timeline.js'
]) ?>

<script>
   $(document).ready(function() {
        "use strict";
        // Triger  timeline slider
        $(".custome-timeline").Timeline({
            itemClass: "timeline-item",
            dotsPosition: "top",
            autoplaySpeed: 20,
        });
        var $cols = $(".timeline-horizontal .timeline-dots li");
        var numberOfCols = $cols.length;
        $cols.css("width", 100 / numberOfCols + "%");

        // On next click, if the slide-next element exists, trigger the click event on it
        $(".nav-timeline .next").click(function(e) {
            e.preventDefault();
            if ($(".slide-next").length) {
                $(".slide-next").trigger("click");
            }
        });

        // Attach a click event listener to elements with the class "nav-timeline" and "prev"
        $(".nav-timeline .prev").click(function(e) {
            // Prevent the default behavior of the click event (i.e. following a link, submitting a form, etc.)
            e.preventDefault();

            // Check if there is an element on the page with the class "slide-prev"
            if ($(".slide-prev").length) {
                // If such an element exists, trigger a click event on it
                $(".slide-prev").trigger("click");
            }
        });

        // $(window).resize(function() {
        //     var $cols = $(".timeline-horizontal .timeline-dots li");
        //     var numberOfCols = $cols.length;
        //     $cols.css("width", 100 / numberOfCols + "%");
        // }). resize(); // Trigger resize to set initial width

    });
</script>