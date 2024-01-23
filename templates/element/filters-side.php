<style type="text/css">
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
        background-color: #676767;
        color: #fff;
    }

    .nav-sidebar .nav-link>.right,
    .nav-sidebar .nav-link>p>.right {
        top: 0.8rem;
    }

    .nav-sidebar {
        white-space: nowrap;
    }

    .nav-link .nav-icon {

        float: left !important;
    }

    .nav-link p {
        float: left !important;
        margin-left: 10px;
    }

    .sidebar {
        margin-top: 20px;
        padding: 5px;
    }

    .sidebar {
        background: #FFFFFF;
        border-radius: 10px;
        padding: 25px;
        border-top: 14px solid #33CA94;
    }

    .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .nav li {
        width: 100%;
        clear: both;
        padding-bottom: 15px;
    }

    #slider_range_blue {
        width: 100%;
        margin-bottom: 15px;
        border: none;
        height: 4px;
        background: #eceff1;
    }

    .noUi-connect {
        background: #2575FC;
    }

    .range-wrapper .min-name,
    .range-wrapper .max-name,
    .output-range span {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 18px;
        letter-spacing: 0.2px;
        color: #696F79;
        display: block;
        margin-bottom: 15px;
    }

    aside {
        margin-bottom: 20px;
    }
</style>
<div id="sideFilter" class="side-filter">
    <div class="header-side-filter">
        <h4 class="title-filter">Filters</h4>
        <div class="close">
            <i class="fas fa-lg fa-times"></i>
        </div>
    </div>

    <div class="body-content">
        <div class="">
            <?= $this->Form->create(null, ['type' => 'get', 'action' => 'results', 'id' => 'search-courses-steps']); ?>
            <input type="hidden" value="<?=$stype?>" name="stype" id="stype"/>
            <div class="">


                <div class="subjects-container">

                    <label class="">Countries</label>
                    <div class="grid-subjects">
                        <?php if (!empty($countriesList)) { ?>
                            <?php foreach ($countriesList as $key => $country) { ?>
                                <div class="subject country country-<?= $key ?> <?= (isset($filterParams) && isset($filterParams['country_id']) && $filterParams['country_id'] == $key ? 'active' : '') ?>" title='<?= $country ?>' data-country='<?= $key ?>'>
                                    <?= $country ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <hr>

                    <input type="hidden" name="country_id" id="country_id" value='<?= (isset($filterParams) && isset($filterParams['country_id']) ? $filterParams['country_id'] : '') ?>'>
                </div>

                <?php

                // if (isset($has_university)) {
                echo $this->Form->control('university_id', [
                    'placeholder' => 'University', 'type' => 'select',
                    'empty' => 'Select University',
                    'class' => 'select-single',
                    'options' => $allUniversities, 'label' => 'University',
                    'value' => (isset($filterParams) && isset($filterParams['university_id']) ? $filterParams['university_id'] : ''),
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                ]);
                // }
                ?>
                    <hr>

                <div class="range-wrapper">
                    <label class="">Fees range</label>
                    
                    <div class="d-flex container-range">
                        <div class="form-area d-flex">
                        USD <input type="number" name="min_budget" id="min-budget" value="<?= (isset($filterParams) && isset($filterParams['min_budget']) ? $filterParams['min_budget'] : '1000') ?>"></div>
                        <div class="form-area d-flex">
                            USD<input type="number" name="max_budget" id="max-budget" value="<?= (isset($filterParams) && isset($filterParams['max_budget']) ? $filterParams['max_budget'] : '100,000') ?>"></div>
                    </div>


                    <div class="output-range">
                        <span id="slider-value">$<?= (isset($filterParams) && isset($filterParams['min_budget']) ? $filterParams['min_budget'] : '1000') ?> </span>
                        <span id="max-val">$<?= (isset($filterParams) && isset($filterParams['max_budget']) ? $filterParams['max_budget'] : '100,000') ?> </span>

                    </div>
                    <div id="slider_range_blue"></div>
                    <!-- <div class="minAndMax">
                        <span class="min-name">Min </span>
                        <span class="max-name">Max </span>
                    </div> -->
                    <!-- <input type="hidden" name="min_budget" id="min-budget" value="<?= (isset($filterParams) && isset($filterParams['min_budget']) ? $filterParams['min_budget'] : '1000') ?>">
                    <input type="hidden" name="max_budget" id="max-budget" value="<?= (isset($filterParams) && isset($filterParams['max_budget']) ? $filterParams['max_budget'] : '100,000') ?>"> -->
                    <script>
                        var slider = document.getElementById('slider_range_blue');
                        var sliderValueElement = document.getElementById('slider-value');
                        var maxValElement = document.getElementById('max-val');
                        var minBudgetElement = document.getElementById('min-budget');
                        var maxBudgetElement = document.getElementById('max-budget');

                        noUiSlider.create(slider, {
                            start: ['<?= (isset($filterParams) && isset($filterParams['min_budget']) ? $filterParams['min_budget'] : '500') ?>', '<?= (isset($filterParams) && isset($filterParams['max_budget']) ? $filterParams['max_budget'] : '85000') ?>'],
                            connect: true,
                            range: {
                                min: 0,
                                max: 100000
                            }
                        });

                        slider.noUiSlider.on('update', function(values, handle) {
                            sliderValueElement.innerHTML = "£ " + Math.round(values[0]);
                            minBudgetElement.value = Math.round(values[0]);
                            maxBudgetElement.value = Math.round(values[1]);
                            maxValElement.innerHTML = "£" + Math.round(values[1]);
                        });
                    </script>
                </div>

                <div class="subjects-container">

                    <label class="">Study Level</label>
                    <div class="grid-subjects">
                        <?php if (!empty($studyLevels)) { ?>
                            <?php foreach ($studyLevels as $key => $studyLevel) { ?>
                                <div class="subject studyLevel studyLevel-<?= $key ?> <?= (isset($filterParams) && isset($filterParams['study_level_id']) && $filterParams['study_level_id'] == $key ? 'active' : '') ?>" title='<?= $studyLevel ?>' data-studylevel='<?= $key ?>'>
                                    <?= $studyLevel ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <input type="hidden" name="study_level_id" id="study_level_id" value='<?= (isset($filterParams) && isset($filterParams['study_level_id']) ? $filterParams['study_level_id'] : '') ?>'>
                </div>

                <?= $this->Form->control('subject_area_id', [
                    'placeholder' => 'Subject Area', 'type' => 'select',
                    'empty' => 'Select Subject Area',
                    'options' => $subjectAreas, 'label' => 'Subject Area',
                    'class' => 'select-single',
                    'value' => (isset($filterParams) && isset($filterParams['subject_area_id']) ? $filterParams['subject_area_id'] : ''),
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                ]) ?>

                <div class="subjects-container">

                    <label class="">Intake Year</label>
                    <div class="grid-subjects">
                        <?php for ($i = date('Y') - 1; $i < date('Y') + 3; $i++) { ?>
                            <div class="subject intakeYear intakeYear-<?= $i ?> <?= (isset($filterParams) && isset($filterParams['intake'])  && $filterParams['intake'] == $i ? 'active' : '') ?>" title='<?= $i ?>' data-intake='<?= $i ?>'>
                                <?= $i ?>
                            </div>
                        <?php } ?>
                    </div>

                    <input type="hidden" name="intake" id="intake" value='<?= (isset($filterParams) && isset($filterParams['intake']) ? $filterParams['intake'] : '') ?>'>
                </div>

                <div class="subjects-container">

                    <label class="">Rank</label>
                    <div class="grid-subjects">
                        <?php
                        $j = 1;
                        for ($i = 50; $i <= 350; $i = $i + 50) { ?>
                            <div class="subject rank rank-<?= $i ?> <?= (isset($filterParams) && isset($filterParams['rank'])  && $filterParams['rank'] == $j ? 'active' : '') ?>" title='<?= $i ?>' data-rank='<?= $i ?>'>
                                <?= $j . ' - ' . $i ?>
                            </div>
                        <?php
                            $j = $i;
                        } ?>
                    </div>

                    <input type="hidden" name="rank" id="rank" value='<?= (isset($filterParams) && isset($filterParams['rank']) ? $filterParams['rank'] : '') ?>'>
                </div>

                <div class="subjects-container">

                    <label class="">Course Duration</label>
                    <div class="grid-subjects">
                        <?php
                        $j = 0;
                        for ($i = 1; $i <= 6; $i = $i + 1) { ?>
                            <div class="subject duration duration-<?= $i ?> <?= (isset($filterParams) && isset($filterParams['duration'])  && $filterParams['duration'] == $j ? 'active' : '') ?>" title='<?= $i ?>' data-duration='<?= $i ?>'>
                                <?= $i == 1 ? 'Less than 1 year' : ($i == 6 ? 'More than 5 years' : $j . '-' . $i . ' years') ?>
                            </div>
                        <?php
                            $j = $i;
                        } ?>
                    </div>

                    <input type="hidden" name="duration" id="duration" value='<?= (isset($filterParams) && isset($filterParams['duration']) ? $filterParams['duration'] : '') ?>'>
                </div>
                <!-- <?= $this->Form->control('duration', [
                            'placeholder' => 'Duration in Year', 'type' => 'number', 'label' => 'Duration in Year',
                            'value' => (isset($filterParams) && isset($filterParams['duration']) ? $filterParams['duration'] : ''),
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?> -->
            </div>
            <div class="container-submit">

                <button class="btn  btn-secondary btn-reset" id="FilterClear">Reset</button>
                <button type="submit" class="btn greenish-teal btn-black">Show results</button>
            </div>

            <?= $this->Form->end() ?>
        </div>

    </div>


</div>

<?php /*
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= USER_LINK ?>" class="brand-link">
        <!-- <img src="<?= ADMIN_ASSETS ?>/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-light"><?= __('User Dashboard') ?></span>
    </a>



    <div class="container-formBox">
        <h4 class="title">Filters</h4>
        <?= $this->Form->create(null, ['method' => 'get', 'action' => 'results', 'id' => 'search-courses-steps']); ?>
        <div class="">
            <?= $this->Form->control('country_id', [
                'placeholder' => 'Destination', 'type' => 'select', 'empty' => 'Select Destination',
                'options' => $countriesList, 'label' => 'Destination',
                'value' => (isset($filterParams) && isset($filterParams['country_id']) ? $filterParams['country_id'] : ''),
                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <?php

            if (isset($has_university)) {
                echo $this->Form->control('university_id', [
                    'placeholder' => 'University', 'type' => 'select', 'empty' => 'Select University',
                    'options' => $allUniversities, 'label' => 'University',
                    'value' => (isset($filterParams) && isset($filterParams['university_id']) ? $filterParams['university_id'] : ''),
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                ]);
            }
            ?>
            <?= $this->Form->control('study_level_id', [
                'placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study',
                'options' => $studyLevels, 'label' => 'Level of study',
                'value' => (isset($filterParams) && isset($filterParams['study_level_id']) ? $filterParams['study_level_id'] : ''),
                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <?= $this->Form->control('subject_area_id', [
                'placeholder' => 'Subject Area', 'type' => 'select', 'empty' => 'Select Subject Area',
                'options' => $subjectAreas, 'label' => 'Subject Area',
                'value' => (isset($filterParams) && isset($filterParams['subject_area_id']) ? $filterParams['subject_area_id'] : ''),
                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <?= $this->Form->control('duration', [
                'placeholder' => 'Duration in Year', 'type' => 'number', 'label' => 'Duration in Year',
                'value' => (isset($filterParams) && isset($filterParams['duration']) ? $filterParams['duration'] : ''),
                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <!-- </nav> -->
            <!-- /.sidebar-menu -->
            <div class="range-wrapper">
                <div class="output-range">
                    <span id="slider-value">$<?= (isset($filterParams) && isset($filterParams['min_budget']) ? $filterParams['min_budget'] : '1000') ?> </span>
                    <span id="max-val">$<?= (isset($filterParams) && isset($filterParams['max_budget']) ? $filterParams['max_budget'] : '100,000') ?> </span>

                </div>
                <div id="slider_range_blue"></div>
                <div class="minAndMax">
                    <span class="min-name">Min </span>
                    <span class="max-name">Max </span>
                </div>
                <input type="hidden" name="min_budget" id="min-budget" value="<?= (isset($filterParams) && isset($filterParams['min_budget']) ? $filterParams['min_budget'] : '1000') ?>">
                <input type="hidden" name="max_budget" id="max-budget" value="<?= (isset($filterParams) && isset($filterParams['max_budget']) ? $filterParams['max_budget'] : '100,000') ?>">
                <script>
                    var slider = document.getElementById('slider_range_blue');
                    var sliderValueElement = document.getElementById('slider-value');
                    var maxValElement = document.getElementById('max-val');
                    var minBudgetElement = document.getElementById('min-budget');
                    var maxBudgetElement = document.getElementById('max-budget');

                    noUiSlider.create(slider, {
                        start: ['<?= (isset($filterParams) && isset($filterParams['min_budget']) ? $filterParams['min_budget'] : '500') ?>', '<?= (isset($filterParams) && isset($filterParams['max_budget']) ? $filterParams['max_budget'] : '85000') ?>'],
                        connect: true,
                        range: {
                            min: 0,
                            max: 100000
                        }
                    });

                    slider.noUiSlider.on('update', function(values, handle) {
                        sliderValueElement.innerHTML = "£ " + Math.round(values[0]);
                        minBudgetElement.value = Math.round(values[0]);
                        maxBudgetElement.value = Math.round(values[1]);
                        maxValElement.innerHTML = "£" + Math.round(values[1]);
                    });
                </script>
            </div>

        </div>
        <div class="container-submit">

            <button class="btn clear-blue" id="FilterClear">CLEAR</button>
            <button type="submit" class="btn greenish-teal">FILTER</button>
        </div>

        <?= $this->Form->end() ?>
    </div>
    <!-- /.sidebar -->
</aside>

*/ ?>

<?php

echo $this->Html->script('select2');
echo $this->Html->css('select2');
?>
<script>
    $(document).ready(function() {
        $('.select-single').select2();
        $('.select-multiple').select2();
    });
</script>
<script>
    var currentUrl = '<?= $_SERVER['REQUEST_URI'] ?>';
    $(function() {
        $('#FilterClear').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: '/university-courses/reset-filter/results',
                success: function(data, status) {
                    window.location = 'results';
                }
            });
        });

        // $("#service_id").change(function() {
        //     var selected_service = $(this).val();
        //     $('.common-services').hide();
        //     $('.services-' + selected_service).show();

        //     var degree = $(this).data('degree');
        //     $('#degree').val(degree);
        // });
        $(".country").click(function() {
            let selected_val = $(this).data('country');

            console.log(selected_val);
            $('#country_id').val(selected_val);
        });
        $(".studyLevel").click(function() {
            let selected_val = $(this).data('studylevel');

            $('#study_level_id').val(selected_val);
        });
        $(".intakeYear").click(function() {
            let selected_val = $(this).data('intake');

            $('#intake').val(selected_val);
        });
        $(".rank").click(function() {
            let selected_val = $(this).data('rank');

            $('#rank').val(selected_val);
        });
        $(".duration").click(function() {
            let selected_val = $(this).data('duration');

            $('#duration').val(selected_val);
        });
    });
</script>