<?= $this->Html->css([
    '/css/new-css/timeline.css'
]) ?>
<section class="main-banner banner-about-us aboutUs2-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg1.png" alt="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="100%" height="100%" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-5">
                <div class="relative-box-about ">
                    <h1 class="relative-text">About</h1>
                    <h2 class="title text-left">About Us</h2>
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
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button class="next" id="nextTimeline">
                        <i class="fa-solid fa-chevron-right"></i>
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
    });
</script>