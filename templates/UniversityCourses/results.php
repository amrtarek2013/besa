<style>
    .addingwish {
        cursor: pointer;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="results-section">
                <h4 class="title-results">Search results for: <span>Universities</span></h4>
                <div class="header-results">
                    <div class="tabs">
                        <div class="tab active"><?= $this->Paginator->counter(__('{{count}}')) ?> Resuls</div>
                        <div class="tab"><?= $this->Paginator->counter(__('{{count}}')) ?> Courses</div>
                        <div class="tab"><?= $this->Paginator->counter(__('{{count}}')) ?> Universities</div>
                    </div>
                    <div class="filter">
                        <button class="btn btn-primary btn-filter">Filter <img src="<?= WEBSITE_URL ?>img/new-desgin/filter.svg" alt=""> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->element('filters-side', ['filterParams' => $filterParams]); ?>
<div id="pageOverlay" class="overlay"></div>

<div class="universities-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container-universities">
                    <div class="header-box">
                        <div class="title-left">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                            <h4>Universities </h4>
                        </div>
                        <a href="#" class="link-see-more">
                            See All <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow right.svg" alt="Arrow Icon">
                        </a>
                    </div>
                    <div class="grid-universities">
                        <?php for ($i = 0; $i < 6; $i++) : ?>
                            <div class="university">
                                <div class="header-box">
                                    <div class="logo">
                                        <img src="<?= WEBSITE_URL ?>img/new-desgin/logo-university.png" alt="University of Essex Logo">
                                        <h5>University of Essex</h5>
                                    </div>
                                    <div class="icon-favorite">
                                        <i class="fa-regular fa-heart fa-lg"></i>
                                    </div>
                                </div>
                                <div class="university-info">
                                    <p>United Kingdom</p>
                                </div>
                                <a href="#" class=" btn apply-now-btn">Check Courses</a>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$this->element('courses_list', ['courses' => $courses, 'pagging' => 1, 'gridContainerCols' => 2]); ?>

<?php 
/*
<section class="main-banner register-banner study1-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="relative-about ">
                    <h2 class="title text-left">
                        
                        <span class="green-small"><?= $this->Paginator->counter(__('{{count}}')) ?> international courses
                            found</span>
                    </h2>
                    <!-- <h2 class="title text-left">
                        <span class=" green-small"><?= !empty($courses) && isset($courses[0]['course']['course_name']) ? $courses[0]['course']['course_name'] : '' ?></span>
                        <span class="blue-para"><?= sizeof($courses) ?> international courses
                            found</span>
                    </h2> -->
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row user-dashboard">

        <div class="col-md-3">
            <?php echo $this->element('filters-side', ['filterParams' => $filterParams]); ?>
        </div>
        <div class="col-md-9">

            

        </div>

    </div>
</div>
*/ 
?>