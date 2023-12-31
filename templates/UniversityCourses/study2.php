<?= $this->Html->css([
    '/css/new-css/timeline.css'
]) ?>
<?= $this->Form->create(null, ['method' => 'get', 'action' => 'results', 'id' => 'search-courses-steps']); ?>
<section class="steps-en">
    <div class="container">
        <div class="col-md-12">
            <div class="steps-background">
                <div class="timeline">
                    <div class="timeline-item active">
                        <span>LEVEL</span>
                    </div>
                    <div class="timeline-item">
                        <span>COURSE</span>

                    </div>
                    <div class="timeline-item">
                        <span>WHERE</span>
                    </div>
                    <div class="timeline-item">
                        <span>BUDGET</span>
                    </div>
                </div>
                <div class="step-container">
                    <div id="step1" class="step active">
                        <!-- Step 1 content here -->
                        <h2 class="title">WHAT TO STUDY?</h2>
                        <div class="form-area">
                            <?php  /*if (!empty($servicesSearchList)){ ?>
                            <select name="service_id" id="service_id">
                                <option value="">Select an option</option>
                            <?php foreach ($servicesSearchList as $i => $service){?>
                                <option value="<?=$service['id']?>" data-degree="<?= $service['search_degree_options'] ?>"><?= $service['title'] ?></option>
                            <?php } ?>
                            </select>                                
                        <?php }*/ ?>
                            <?php if (!empty($studyLevels)) { ?>
                                <select name="study_level_id" id="study_level_id">
                                    <option value="">Select an option</option>
                                    <?php foreach ($studyLevels as $studyLevel) { ?>
                                        <option value="<?= $studyLevel['id'] ?>" data-degree="1"><?= $studyLevel['title'] ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </div>
                    </div>

                    <input type="hidden" name="degree" id="degree" value="1">

                    <div id="step2" class="step">
                        <div class="common-services services-2 services-4">
                            <h2 class="title">WHAT COURSE DO YOU WANT TO STUDY?</h2>
                            <div class="form-area">

                                <!-- <input name="subject_area_id" id="subject_area_id" placeholder="Search for Subject Area" /> -->
                                <div class="search">
                                    <input type="search" name="subject_area" id="subject_area" class="subject_area" placeholder="Search for Subject Area" style="width: 40%;height: 64px; background-image: url(../img/icon-search.png);
background-repeat: no-repeat;
background-position-x: 7px;
background-position-y: 50%;;" />
                                </div>
                            </div>
                            <div class="grid-contaienr SubjectAreas">
                                <?php if (!empty($subjectAreas)) { ?>
                                    <?php foreach ($subjectAreas as $key => $subjectArea) { ?>
                                        <div class="box course-box studyLevel-<?= $key ?>" title='<?= $subjectArea ?>' data-course='<?= $key ?>'>
                                            <h4><?= $subjectArea ?></h4>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <!-- <input type="hidden" name="course_id" id="course_id" value=''> -->
                            <input type="hidden" name="subject_area_id" id="subject_area_id" value=''>
                        </div>

                        <!-- <div class="common-services services-2 services-4">
                            <h2 class="title">WHAT COURSE DO YOU WANT TO STUDY?</h2>
                            <div class="grid-contaienr">
                                <?php if (!empty($studyCourses)) { ?>
                                    <?php foreach ($studyCourses as $studyCourse) { ?>
                                        <div class="box course-box studyLevel-<?= $studyCourse['study_level_id'] ?>" title='<?= $studyCourse['course_name'] ?>' data-course='<?= $studyCourse['id'] ?>'>
                                            <h4><?= words_slice($studyCourse['course_name'], 4) ?></h4>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="course_id" id="course_id" value=''>
                        </div> -->
                        <!-- <div class="common-services services-6 services-7 hide">
                            <h2 class="title">What is the student study level?</h2>
                            <div class="grid-contaienr">
                                <?php if (!empty($studyLevels)) { ?>
                                    <?php foreach ($studyLevels as $studyLevel) { ?>
                                        <div class="box level-box center-text" title='<?= $studyLevel['title'] ?>' data-level='<?= $studyLevel['id'] ?>'>
                                            <h4><?= words_slice($studyLevel['title'], 4) ?></h4>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="study_level_id" id="study_level_id" value=''>
                        </div> -->
                    </div>


                    <div id="step3" class="step">
                        <!-- Step 3 content here -->
                        <div class="common-services services-2 services-4">
                            <h2 class="title">WHERE DO YOU WANT TO STUDY?</h2>
                            <div class="grid-contaienr contaienr-checkbox">
                                <?php foreach ($countriesList as $country_key => $country_value) { ?>
                                    <div class="checkbox-green">
                                        <input type="checkbox" name="country_id[]" value="<?= $country_key ?>" id="country-<?= $country_key ?>">
                                        <label for="country-<?= $country_key ?>"><?= $country_value ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="common-services services-6 services-7 hide">
                            <div class="form-area">
                                <h2 class="title">Curriculum</h2>
                                <select name="curriculum" id="curriculum">
                                    <option value="">Select Curriculum</option>
                                    <option value="1">Curriculum 1</option>
                                    <option value="2">Curriculum 2</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="step4" class="step">
                        <!-- Step 4 content here -->
                        <h2 class="title">WHAT’S YOUR BUDGET?</h2>
                        <div class="range-wrapper">
                            <div class="output-range">
                                <span id="slider-value">$1000 </span>
                                <span id="max-val">$100,000 </span>

                            </div>
                            <div id="slider_range_blue"></div>
                            <div class="minAndMax">
                                <span class="min-name">Min </span>
                                <span class="max-name">Max </span>
                            </div>
                            <input type="hidden" name="min_budget" id="min-budget" value="1000">
                            <input type="hidden" name="max_budget" id="max-budget" value="100000">
                            <script>
                                var slider = document.getElementById('slider_range_blue');
                                var sliderValueElement = document.getElementById('slider-value');
                                var maxValElement = document.getElementById('max-val');
                                var minBudgetElement = document.getElementById('min-budget');
                                var maxBudgetElement = document.getElementById('max-budget');

                                noUiSlider.create(slider, {
                                    start: [500, 85000],
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
                        <div class="common-services services-6 services-7 hide">
                            <label for="age">What is the student age?</label>
                            <span id="age-value">12 Year</span>

                            <input type="range" id="age" value="12" min="12" max="100" name="age">
                            <script>
                                var slider = document.getElementById("age");
                                var output = document.getElementById("age-value");
                                output.innerHTML = slider.value;
                                slider.oninput = function() {
                                    output.innerHTML = this.value + ' Year';
                                }
                            </script>

                            <br><br><br>
                            <label for="stay">How long will the student stay?</label>
                            <span id="stay-value">1 Year</span>
                            <input type="range" id="stay" value="1" min="1" max="10" name="stay">
                            <script>
                                var sliderStay = document.getElementById("stay");
                                var outputStay = document.getElementById("stay-value");
                                outputStay.innerHTML = sliderStay.value;
                                sliderStay.oninput = function() {
                                    outputStay.innerHTML = this.value + ' Year';
                                }
                            </script>
                        </div>

                    </div>
                    <!-- Buttons to navigate between steps -->
                    <div id="buttons">
                        <button id="prevBtn">Previous</button>
                        <button id="nextBtn">Next <img src="<?= WEBSITE_URL ?>img/new-images/chevron-left.png" alt=""> </button>
                    </div>
                </div>
            </div>
        </div>
</section>
<?= $this->Form->end() ?>

<?= $this->Html->script([
    '/js/new-js/timeline.js'
]) ?>
<?= $this->Html->script([
    '/js/new-js/script-steps-en.js?v=' . time()
]) ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#service_id").change(function() {
            var selected_service = $(this).val();
            $('.common-services').hide();
            $('.services-' + selected_service).show();

            var degree = $(this).data('degree');
            $('#degree').val(degree);
        });
        $('.course-box').on('click', function() {
            var selected_course = $(this).data("course");
            $('.course-box').removeClass('active');
            $(this).addClass('active');
            $("#subject_area_id").val(selected_course);
        });
        $('.level-box').on('click', function() {
            var selected_level = $(this).data("level");
            $('.level-box').removeClass('active');
            $(this).addClass('active');
            // $("#study_level_idstudy_level_id").val(selected_level);
        });
        // $('#study_level_id').on('change', function() {
        //     var selected_level = $(this).val();

        //     $(".course-box").hide();
        //     $(".studyLevel-" + selected_level).show();
        // });

        $("#subject_area").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".SubjectAreas h4").each(function() {
                if ($(this).text().toLowerCase().search(value) > -1) {
                    $(this).parent('div.course-box').show();
                } else {
                    $(this).parent('div.course-box').hide();
                }
            });
        });
    });
</script>