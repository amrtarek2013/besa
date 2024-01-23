<style>
    .addingwish {
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="results-section">
                <h4 class="title-results">Search results <?= isset($stype) && $stype == 'c' ? ' for <span>Courses</span>' : ($stype == 'u' ? 'for <span>Universities</span>' : '') ?></h4>
                <div class="header-results">
                    <div class="tabs">
                        <a href="#" class="tab search-type <?= isset($stype) && $stype == 'a' ? 'active' : '' ?>" data-stype="a"><?= $totalCount ?> Resuls</a>
                        <a href="#" class="tab search-type <?= isset($stype) && $stype == 'c' ? 'active' : '' ?>" data-stype="c"><?= $coursesCount ?> Courses</a>
                        <a href="#" class="tab search-type <?= isset($stype) && $stype == 'u' ? 'active' : '' ?>" data-stype="u"><?= $uniCount ?> Universities</a>
                    </div>
                    <div class="filter">
                        <button class="btn btn-primary btn-filter">Filter <img src="<?= WEBSITE_URL ?>img/new-desgin/filter.svg" alt=""> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.search-type', function(e) {

        e.preventDefault();

        $('#stype').val($(this).data('stype'))
        $('#search-courses-steps').submit();
    });
</script>
<?php
echo $this->element('filters-side', ['filterParams' => $filterParams]); ?>
<div id="pageOverlay" class="overlay"></div>


<?php
if ($stype != 'c')
    echo $this->element('universities_list', ['universitiesResults' => $universitiesResults, 'pagging' => 1, 'gridContainerCols' => 2]); ?>

<?php

if ($stype != 'u')
    echo $this->element('courses_list', ['courses' => $courses, 'pagging' => 1, 'gridContainerCols' => 2]); ?>

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