<section class="main-banner register-banner study1-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg-study-01.png" alt="" style="z-index: 2;" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Courses</h1>
                    <h2 class="title text-left">
                        <!-- <span class=" green-small"><?= $courses[0]['course']['course_name'] ?></span> -->
                        <span class="blue-para"><?= sizeof($courses) ?> international courses
                            found</span>
                    </h2>
                </div>
            </div>



        </div>
    </div>
</section>

<?php


// if (isset($_GET['dk']))
//     dd($wishLists);
echo $this->element('courses_list', ['courses' => $courses, 'wishLists' => $wishLists, 'pagging' => 1, 'gridContainerCols' => 3]); ?>