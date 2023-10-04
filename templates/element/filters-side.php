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
        background: #8692A6;
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
    });
</script>