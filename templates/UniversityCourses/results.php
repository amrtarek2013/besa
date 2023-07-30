<style>
    .addingwish {
        cursor: pointer;
    }
</style>

<section class="main-banner register-banner study1-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg-study-01.png" alt="" style="z-index: 2;">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Result</h1>
                    <h2 class="title text-left">
                        <span class=" green-small"><?= !empty($courses) && isset($courses[0]['course']['course_name']) ? $courses[0]['course']['course_name'] : '' ?></span>
                        <span class="blue-para"><?= sizeof($courses) ?> international courses
                            found</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="container">
    <div class="row user-dashboard">

        <div class="col-md-3">
            <?php echo $this->element('filters-side', []); ?>
        </div>
        <div class="col-md-9">

            <?php echo $this->element('courses_list', ['courses' => $courses, 'gridContainerCols'=>2]); ?>

        </div>

    </div>
</div>