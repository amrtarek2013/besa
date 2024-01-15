<style>
  div.error-message {
    font-size: 12px;
    padding: 5px;
    color: red;
    margin-top: 2px;
  }

  .input.tel div.error-message {
    position: absolute;
  }
</style>
<?php

use Cake\Routing\Router;
?>
<div class="overlay-img">
  <div class="logo">
    <a href="<?= Router::url('/') ?>"><img loading="lazy" src="<?= WEBSITE_URL ?>img/new-desgin/logo-footer.png" alt="main_logo" width="200"></a>
  </div>
</div>
<?php

$bd = $user['bd'] ? explode('-', $user['bd']) : []; ?>
<?= $this->Form->create($user, array('id' => 'FormRegister', 'class' => 'register')); ?>
<div class="sign-up">
  <?= $this->Html->css([
    '/css/new-css/timeline.css'
  ]) ?>
  <?= $this->Form->create(null, ['method' => 'get', 'action' => 'results', 'id' => 'search-courses-steps']); ?>
  <section class="steps-en">
    <div class="container">
      <div class="col-md-12">
        <div class="steps-background">

          <div class="step-container">
            <div id="step1" class="step active">
              <div class="form-step">
                <a href="<?= Router::url('/') ?>" class="back-link"> <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow-back.svg" alt=""> Back to home</a>
                <h4 class="title-step">Welcome to BESA</h4>
                <h5 class="title-small">Finish signing up</h5>
                <div class="grid-container">
                  <?= $this->Form->control('first_name', [
                    'placeholder' => 'Name',
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>'], 'label' => 'Name*', 'required' => true
                  ])
                  ?>

                  <?= $this->Form->control('last_name', [
                    'placeholder' => 'Last name*', 'label' => 'Last name*', 'required' => true,
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                  ])
                  ?>

                  <?= $this->Form->control('country_id', [
                    'placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence',
                    'options' => $countriesList, 'label' => 'Country of Residence*', 'required' => true,
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                  ])
                  ?>
                  <?= $this->Form->control('email', [
                    'type' => 'email',
                    'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                  ])
                  ?>
                  <?= $this->element('mobile_with_code', ['phone_name' => 'mobile', 'phone_label' => 'Mobile', 'phone_code' => 'mobile_code']) ?>

                  <!--
              <?= $this->Form->control('current_status', [
                'type' => 'text', 'placeholder' => 'Current/Previous-(School/University)', 'label' => 'Current/Previous-(School/University) *', 'required' => true,
                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
              ])
              ?>
           <?= $this->Form->control('nationality_id', [
              'placeholder' => 'Nationality*', 'label' => 'Nationality*', 'required' => true,
              'type' => 'select', 'empty' => 'Select Nationality*',
              'options' => $countriesList,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>

            <?= $this->Form->control('city', [
              'type' => 'text', 'placeholder' => 'City', 'label' => 'City*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?> -->


                  <?= $this->Form->control('current_status', [
                    'type' => 'text', 'placeholder' => 'Current School/University/Occupation', 'label' => 'Current School/University/Occupation *', 'required' => true,
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                  ]) ?>


                  <!-- <?= $this->Form->control('current_study_level', [
                          'placeholder' => 'Current/last Level of study*', 'type' => 'select', 'empty' => 'Select Current/last Level of study*',
                          'options' => $mainStudyLevels, 'label' => 'Current/last Level of study*', 'required' => true,
                          'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>



            <?= $this->Form->control('subject_area_id', [
              'placeholder' => 'Major/subject of your study', 'type' => 'select', 'empty' => 'Select Major/subject of your study',
              'options' => $subjectAreas, 'label' => 'Major/subject of your study', /*'required' => true,*/
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}" id="subject-area">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('destination_id', [
              'placeholder' => 'Country you study at', 'type' => 'select', 'empty' => 'Select Country you study at',
              'options' => $countriesList, 'label' => 'Country you study at*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            -->

                  <?= $this->Form->control('password', [
                    'type' => 'password',
                    'placeholder' => 'Password',
                    'label' => 'Password*',
                    'required' => true,
                    'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility(\'password\')"></i></div>']
                  ])
                  ?>
                  <?= $this->Form->control('passwd', [
                    'type' => 'password',
                    'placeholder' => 'Confirm Password',
                    'label' => 'Confirm Password*',
                    'required' => true,
                    'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility(\'passwd\')"></i></div>']
                  ])

                  ?>


                </div>
                <div class="container-checkboxes">
                  <div class="checkboxes">
                    <div class="terms-conditions">
                      <input type="checkbox" name="terms" id="terms" required="required">
                      <label for="">I agree to <a href="#"> &nbsp;terms & conditions</a> </label>
                    </div>
                    <div>
                      <input type="checkbox" name="is_subscribed" id="is_subscribed">
                      <label for="">Tick box to stay updated through BESA’s newsletter</label>
                    </div>
                  </div>
                </div>
                <button type="button" onclick="nextStep()" class="btn btn-primary btn-agree-step"> Agree and continue</button>
              </div>
            </div>
            <div id="step2" class="step">
              <!-- Step 1 content here -->
              <h2 class="title">What study level do you <br> wish to apply for ?</h2>

              <div class="form-area">
                <?php  /*if (!empty($servicesSearchList)){ ?>
                            <select name="service_id" id="service_id">
                                <option value="">Select an option</option>
                            <?php foreach ($servicesSearchList as $i => $service){?>
                                <option value="<?=$service['id']?>" data-degree="<?= $service['search_degree_options'] ?>"><?= $service['title'] ?></option>
                            <?php } ?>
                            </select>                                
                        <?php }*/ ?>
                <!-- Hidden Dropdown for Selecting Study Levels -->
                <?php if (!empty($studyLevels)) { ?>
                  <select hidden name="study_level_id" id="study_level_id">
                    <option value="">Select an option</option>
                    <?php foreach ($studyLevels as $studyLevel) { ?>
                      <option value="<?= $studyLevel['id'] ?>" data-degree="1"><?= $studyLevel['title'] ?></option>
                    <?php } ?>
                  </select>
                <?php } ?>

                <!-- Grid Format for Displaying Study Levels -->
                <?php if (!empty($studyLevels)) { ?>
                  <div class="subjects-container">
                    <p class="title-small">Select your preferred study level.</p>
                    <div class="grid-subjects">
                      <?php foreach ($studyLevels as $studyLevel) { ?>
                        <div class="subject" onclick="selectStudyLevel(<?= $studyLevel['id'] ?>, this)" data-selected="false" id="subject-<?= $studyLevel['id'] ?>">
                          <?= $studyLevel['title'] ?>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>

                <script>
                  function selectStudyLevel(id, element) {
                    // Clear previous selections in the grid
                    var subjects = document.getElementsByClassName('subject');
                    for (var i = 0; i < subjects.length; i++) {
                      subjects[i].setAttribute('data-selected', 'false');
                    }

                    // Highlight the selected element
                    element.setAttribute('data-selected', 'true');

                    // Update the hidden select element with the selected study level id
                    document.getElementById('study_level_id').value = id;
                  }
                </script>


                <script>
                  // JavaScript function to handle selection of study levels
                  function selectStudyLevel(id, element) {
                    // Clear previous selections
                    var subjects = document.getElementsByClassName('subject');
                    for (var i = 0; i < subjects.length; i++) {
                      subjects[i].setAttribute('data-selected', 'false');
                    }

                    // Set the clicked element as selected
                    element.setAttribute('data-selected', 'true');

                    // Update a hidden input field to store the selected study level id
                    document.getElementById('study_level_id').value = id;
                  }
                </script>

                <!-- Hidden input to store the selected study level id -->
                <input type="hidden" name="study_level_id" id="study_level_id" value="">
              </div>
            </div>

            <!-- <input type="hidden" name="degree" id="degree" value="1"> -->

            <div id="step3" class="step">
              <div class="common-services services-2 services-4">
                <h2 class="title">What do you want to study?</h2>
                <p class="title-small">Select the subject that you are interested in. <br> you can pick up to 5.</p>
                <!-- <input name="subject_area_id" id="subject_area_id" placeholder="Search for Subject Area" /> -->
                <div class="search search-step">
                  <input type="search" name="subject_area" id="subject_area" class="subject_area" placeholder="Search for Subject" />
                </div>
                <div class="subjects-container">
                  <h4>Popular Subject</h4>
                  <div class="grid-subjects">
                    <div class="subject">Business</div>
                    <?php if (!empty($subjectAreas)) { ?>
                      <?php foreach ($subjectAreas as $key => $subjectArea) { ?>
                        <div class="subject studyLevel-<?= $key ?>" title='<?= $subjectArea ?>' data-course='<?= $key ?>'>
                          <?= $subjectArea ?>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  </div>

                </div>
                <!-- <div class="grid-contaienr SubjectAreas">
                                <?php //if (!empty($subjectAreas)) { 
                                ?>
                                    <? php // foreach ($subjectAreas as $key => $subjectArea) { 
                                    ?>
                                        <div class="box course-box studyLevel-<php $key ?>" title='< $subjectArea ?>' data-course='< $key ?>'>
                                            <h4><? php // $subjectArea 
                                                ?></h4>
                                        </div>
                                    <? php // } 
                                    ?>
                                <?php //} 
                                ?>
                            </div> -->
                <!-- <input type="hidden" name="course_id" id="course_id" value=''> -->
                <input type="hidden" name="subject_area_id" id="subject_area_id" value=''>
              </div>

            </div>


            <div id="step4" class="step">
              <!-- Step 3 content here -->
              <div class="common-services services-2 services-4">
                <h2 class="title">Which countries do you want <br> to study in?</h2>
                <div class="selectors-container">
                  <div class="form-area">
                    <label for="">Option 1</label>
                    <select name="" id="">
                      <?php foreach ($countriesList as $country_key => $country_value) { ?>
                        <option value="<?= $country_value ?>"><?= $country_value ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-area">
                    <label for="">Option 2</label>
                    <select name="" id="">
                      <option value="Option">Option 1</option>
                    </select>
                  </div>
                  <div class="form-area">
                    <label for="">Option 3</label>
                    <select name="" id="">
                      <option value="Option">Option 1</option>

                    </select>
                  </div>
                  <div class="form-area">
                    <label for="">Option 4</label>
                    <select name="" id="">
                      <option value="Option">Option 1</option>
                    </select>
                  </div>
                </div>
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

            <div id="step5" class="step">
              <!-- Step 4 content here -->
              <h2 class="title">Budget?</h2>
              <div class="selectors-container">
                <div class="form-area">
                  <label for="">Budget </label>
                  <select name="" id="">
                    <option value="Option">5000 - 10,000 $</option>
                  </select>
                </div>
              </div>
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

            <div id="step6" class="step">
              <h2 class="title">Which year do you want <br>to study abroad ?</h2>
              <p class="title-small">Select your preferred year.</p>
              <div class="grid-2col">
                <div class="form-area ">
                  <select name="" id="" class="border-blue">
                    <option value="Option">2022</option>
                  </select>
                </div>
                <div class="form-area">
                  <select name="" id="" class="border-blue">
                    <option value="Option">November</option>
                  </select>
                </div>
              </div>

            </div>


            <!-- Buttons to navigate between steps -->
            <div id="buttons">
              <button id="prevBtn" class="back-link"><img src="<?= WEBSITE_URL ?>img/new-desgin/arrow-back.svg" alt="">Back</button>
              <button id="nextBtn">Next </button>
            </div>
          </div>
          <div class="timeline">
            <div class="timeline-item active">
            </div>
            <div class="timeline-item">
            </div>
            <div class="timeline-item">
            </div>
            <div class="timeline-item">
            </div>
            <div class="timeline-item">
            </div>
            <div class="timeline-item">
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

</div>
<?= $this->Form->end() ?>

<script>
  $('#current-study-level').on('change', function() {

    if ($(this).val() == 0) {
      $('#subject-area').hide();
      $('#subject-area').val('');
    } else
      $('#subject-area').show();
  });
</script>
<script src="<?= Router::url('/js/new-js/jquery.validate.js') ?>" async></script>
<script src="<?= Router::url('/js/new-js/multi-step.js') ?>" async></script>

<script type="text/javascript">
  var request_busy = false;
  $(function() {
    setInterval(function() {
      reLoadCaptchaV3();
    }, 2 * 60 * 1000);

    $('#FormRegister').validate({
      rules: {

        'first_name': {
          required: true,
        },
        'last_name': {
          required: true,
        },
        'mobile': {
          required: true,
          minlength: 7,
          maxlength: 13
        },
        'email': {
          required: true,
          email: true
        },
        'password': {
          required: true,
        },
        'passwd': {
          required: true,
        },
        // 'nationality_id': {
        //   required: true
        // },
        'country_id': {
          required: true,
        },
        'mobile': {
          required: true,
        },
        'mobile_code': {
          required: true,
        },
        'current_status': {
          required: true,
        },
        // 'current_study_level': {
        //   required: true,
        // },
        // 'destination_id': {
        //   required: true,
        // },
        // 'subject_area_id': {
        //   required: true,
        // },
        // 'city': {
        //   required: true,
        // },
      },
      messages: {

      },
      errorClass: "error-message",
      errorElement: "div",
      errorPlacement: function(error, element) {
        error.insertAfter(element, false);
      },
      submitHandler: function(form) {
        form.submit();
        // enquiriesSubmitForm(form)
      }
    });

    // enquiriesSubmitForm = function(form, register) {

    //   if (!request_busy) {

    //     $('body').LoadingOverlay("show");

    //     request_busy = true;
    //     // $('#registerbox .modalMsg').append("<div class='remodal-loading'></div>");
    //     $.ajax({
    //       type: "POST",
    //       url: $(form).prop('action'),
    //       data: $(form).serialize(),
    //       dataType: 'json',
    //     }).done(function(data) {
    //       request_busy = false;
    //       $('.remodal-loading').remove();
    //       console.log(data.status);
    //       if (data.status) {


    //         // notification('success', data.message, data.title);


    //         $('.error-message').remove();
    //         $(form)[0].reset();

    //         reLoadCaptchaV3();

    //       } else {

    //         $('body').LoadingOverlay("hide");

    //         // notification('error', data.message, data.title);


    //         var rmodal_id = 'modalMsg';

    //         reLoadCaptchaV3();
    //         $('.error-message').remove();
    //         if (data['validationErrors']) {
    //           for (i in data.validationErrors) {
    //             if (typeof(data.validationErrors[i]) === 'object') {
    //               var errors_array = data.validationErrors[i];
    //               for (j in errors_array) {
    //                 $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + errors_array[j] + '</div>');
    //               }
    //             } else {
    //               $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + data.validationErrors[i] + '</div>');
    //             }
    //           }
    //         }

    //       }

    //       $('.modalMsg #msgText').html(data.message);
    //       var inst = $('[data-remodal-id=modalMsg]').remodal();
    //       inst.open();
    //     });

    //     $('body').LoadingOverlay("hide");
    //   }
    // }

  });
</script>