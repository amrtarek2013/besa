<section class="main-banner register-banner study1-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="./img/hero-bg-study-01.png" alt="" style="z-index: 2;" width="">
                    <img src="./img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Study</h1>
                    <h2 class="title text-left">Study</h2>
                </div>
            </div>

            <!-- <form action=""> -->

            <?= $this->Form->create(null, ['method' => 'get', 'action' => 'results']); ?>
            <div class="col-md-12">
                <div class="container-formBox">
                    <h4 class="title text-align title-study">What to Study</h4>
                    <div class="radio-container">

                        <?php if (!empty($servicesSearchList)) : ?>
                            <?php foreach ($servicesSearchList as $i => $service) :
                            ?>

                                <div class="radio-label">
                                    <input type="radio" class="radio-input searchDegreeOption" <?= $i == 0 ? 'checked="checked"' : '' ?> data-degree="<?= $service['search_degree_options'] ?>" name="service_id" id="service-<?= $service['id'] ?>" value="<?= $service['id'] ?>">
                                    <label for="service-<?= $service['id']  ?>" class="radio-label-text"><?= $service['title'] ?></label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <input type="hidden" name="degree" id="degree" value="1">
                        <!-- <div class="radio-label">
                            <input type="radio" class="radio-input" name="degree" id="postgraduate" value="postgraduate">
                            <label for="postgraduate" class="radio-label-text">Postgraduate Degree</label>
                        </div>
                        <div class="radio-label">
                            <input type="radio" class="radio-input" name="degree" id="boarding" value="boarding">
                            <label for="boarding" class="radio-label-text">Boarding School</label>
                        </div>
                        <div class="radio-label">
                            <input type="radio" class="radio-input" name="degree" id="summer" value="summer">
                            <label for="summer" class="radio-label-text">Summer School</label>
                        </div> -->
                    </div>
                    <div class="grid-towCol searchDegreeOption-1">
                        <div class="form-area">
                            <!-- <label for="Major">What course/major do you want to study?</label>
                                <select name="Major" id="Major" placeholder="Major">
                                    <option value="1">Major 1</option>
                                    <option value="2">Major 2</option>
                                </select> -->
                            <!-- <?php echo $this->Form->control('major_id', ['label' => 'What course/major do you want to study?', 'type' => 'select', 'empty' => 'Select Course/Major', 'options' => $courseMajors, 'class' => 'INPUT required']); ?> -->
                            <?php echo $this->Form->control('course_id', ['label' => 'What course/major do you want to study?', 'type' => 'select', 'empty' => 'Select Course/Major', 'options' => $studyCourses, 'class' => 'INPUT required']); ?>
                        </div>
                        <div class="form-area">
                            <!-- <label for="where">Where do you want to study?</label>
                                <select name="where" id="where" placeholder="Where">
                                    <option value="1">Where 1</option>
                                    <option value="2">Where 2</option>
                                </select> -->
                            <?php echo $this->Form->control('country_id', ['label' => 'Where do you want to study?', 'type' => 'select', 'empty' => 'Select Country', 'options' => $countriesList, 'class' => 'INPUT required']); ?>
                        </div>
                    </div>
                    <div class="grid-towCol searchDegreeOption-2" style="display:none;">
                        <div class="form-area">
                            <!-- <label for="level">What is the student study level?</label>
                            <select name="level" id="level" placeholder="Level">
                                <option value="1">Level 1</option>
                                <option value="2">Level 2</option>
                            </select> -->
                            <?php echo $this->Form->control('study_level_id', ['label' => 'What is the student study level?', 'type' => 'select', 'empty' => 'Select Level', 'options' => $studyLevels, 'class' => 'INPUT required']); ?>
                        </div>
                        <div class="form-area">
                            <label for="curriculum">Curriculum</label>
                            <select name="curriculum" id="curriculum" placeholder="Curriculum">
                                <option value="">Select Curriculum</option>
                                <option value="1">Curriculum 1</option>
                                <option value="2">Curriculum 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="range-container">


                        <div class="range-wrapper">
                            <label for="budget">What is your budget?</label>
                            <div class="output-range">
                                <span id="slider-value">$1000 </span>
                                <span id="max-val">$100,000 </span>

                            </div>
                            <div id="slider_range"></div>
                            <span style="font-size: 10px;">Average $50,000 per year </span>

                            <input type="hidden" name="min_budget" id="min-budget" value="1000">
                            <input type="hidden" name="max_budget" id="max-budget" value="100000">
                            <script>
                                var slider = document.getElementById('slider_range');
                                var sliderValueElement = document.getElementById('slider-value');
                                var minBudgetElement = document.getElementById('min-budget');
                                var maxBudgetElement = document.getElementById('max-budget');
                                var maxValElement = document.getElementById('max-val');

                                noUiSlider.create(slider, {
                                    start: [40000, 60000],
                                    connect: true,
                                    range: {
                                        min: 1000,
                                        max: 100000
                                    }
                                });

                                slider.noUiSlider.on('update', function(values, handle) {
                                    sliderValueElement.innerHTML = "$" + Math.round(values[0]);
                                    minBudgetElement.value = Math.round(values[0]);
                                    maxBudgetElement.value = Math.round(values[1]);
                                    maxValElement.innerHTML = "$" + Math.round(values[1]);
                                });
                            </script>
                            <!-- 
                                  <div class="output-range">
                                      <span id="budget-value">$1000 </span>
                                      <span id="">$100,000 </span>

                                  </div>
                                <input type="range" id="budget" min="1000" max="100000">
                                <span style="font-size: 10px;">Average $50,000 per year </span>
                                -->
                        </div>

                        <div class="range-wrapper searchDegreeOption-2" style="display:none;">
                            <label for="age">What is the student age?</label>
                            <span id="age-value">12 Year</span>

                            <input type="range" id="age" value="12" min="12" max="100">
                            <script>
                                var slider = document.getElementById("age");
                                var output = document.getElementById("age-value");
                                output.innerHTML = slider.value; // Display the default slider value

                                // Update the current slider value (each time you drag the slider handle)
                                slider.oninput = function() {
                                    output.innerHTML = this.value + ' Year';
                                }
                            </script>
                        </div>
                        <div class="range-wrapper searchDegreeOption-2" style="display:none;">
                            <label for="stay">How long will the student stay?</label>
                            <span id="stay-value">1 Year</span>

                            <input type="range" id="stay" value="1" min="1" max="10">

                            <script>
                                var sliderStay = document.getElementById("stay");
                                var outputStay = document.getElementById("stay-value");
                                outputStay.innerHTML = sliderStay.value; // Display the default slider value

                                // Update the current slider value (each time you drag the slider handle)
                                sliderStay.oninput = function() {
                                    outputStay.innerHTML = this.value + ' Year';
                                }
                            </script>
                        </div>
                        <div class="radio-wrapper">
                            <label for="visa">Need help in visa issuing?</label>
                            <div class="display-flex">
                                <div class="radio-label">
                                    <input type="radio" class="radio-input" name="visa" id="visa-yes" value="visa" checked="checked">
                                    <label for="visa-yes" class="radio-label-text">Yes</label>

                                </div>
                                <div class="radio-label">
                                    <input type="radio" class="radio-input" name="visa" id="visa-no" value="visa">
                                    <label for="visa-no" class="radio-label-text">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="radio-wrapper">
                            <label for="accommodation">Need help in accommodation?</label>
                            <div class="display-flex">
                                <div class="radio-label">
                                    <input type="radio" class="radio-input" name="accommodation" id="accommodation-yes" value="accommodation" checked="checked">
                                    <label for="accommodation-yes" class="radio-label-text">Yes</label>

                                </div>
                                <div class="radio-label">
                                    <input type="radio" class="radio-input" name="accommodation" id="accommodation-no" value="accommodation">
                                    <label for="accommodation-no" class="radio-label-text">No</label>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="checkbox-course searchDegreeOption" style="display:none;">
                        <label for="academic-course" class="have-style-label">Academic Course:</label>
                        <div id="checkbox-group-1">
                            <div class="form-area">
                                <input type="checkbox" id="junior" name="junior">
                                <label for="junior">Junior</label>
                            </div>
                            <div class="form-area">
                                <input type="checkbox" id="intensive-english-1" name="intensive-english-1">
                                <label for="intensive-english-1">Intensive English 1</label>
                            </div>
                            <div class="form-area">
                                <input type="checkbox" id="intensive-english-2" name="intensive-english-2">
                                <label for="intensive-english-2">Intensive English 2</label>
                            </div>
                            <div class="form-area">
                                <input type="checkbox" id="short-courses" name="short-courses">
                                <label for="short-courses">Short Courses</label>
                            </div>


                        </div>

                        <div id="checkbox-group-2">
                            <div class="form-area">
                                <input type="checkbox" id="a-level" name="a-level">
                                <label for="a-level">A Level</label>
                            </div>
                            <div class="form-area">
                                <input type="checkbox" id="ib" name="ib">
                                <label for="ib">IB</label>
                            </div>
                            <div class="form-area">
                                <input type="checkbox" id="ufc" name="ufc">
                                <label for="ufc">UFC</label>
                            </div>
                            <div class="form-area">
                                <input type="checkbox" id="custom-color" name="custom-color">
                                <label for="custom-color">#696F79</label>
                            </div>
                            <div class="form-area">
                                <input type="checkbox" id="igcse" name="igcse">
                                <label for="igcse">IGCSE</label>
                            </div>
                        </div>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn btn-green"><?= __('Find') ?></button>
                        <!-- <a href="#" class="btn btn-green">Find</a> -->
                        <a href="<?= Cake\Routing\Router::url('/'.$g_dynamic_routes['enquiries.contactus']) ?>" class="btn btn-blue">
                            <span class="big">Need Help?</span>
                            <span class="small">Schedule a FREE session with our Counsellors </span>
                        </a>

                    </div>
                </div>
            </div>

            <?= $this->Form->end() ?>
            <!-- </form> -->

        </div>
    </div>
</section>
<script>
    $(document).ready(function() {


        $('.searchDegreeOption').on('click', function() {

            degree = $(this).data('degree');
            if (degree == 1) {
                $('.searchDegreeOption-' + degree).show();
                $('.searchDegreeOption-2').hide();
            } else {

                $('.searchDegreeOption-' + degree).show();
                $('.searchDegreeOption-1').hide();
            }
            $('#degree').val(degree);
        });
    });
</script>