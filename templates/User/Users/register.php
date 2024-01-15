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
  <a href="<?=Router::url('/')?>"><img loading="lazy" src="<?= WEBSITE_URL ?>img/new-desgin/logo-footer.png" alt="main_logo" width="200"></a>
  </div>
</div>
<?php

 $bd = $user['bd'] ? explode('-', $user['bd']) : []; ?>
<?= $this->Form->create($user, array('id' => 'FormRegister', 'class' => 'register')); ?>
<div class="sign-up">
  <div class="form-step">
        <a href="<?=Router::url('/')?>" class="back-link"> <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow-back.svg" alt=""> Back to home</a>
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
<?= $this->Form->end() ?>


<section class="main-banner register-banner study1-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="/img/hero-bg-study-01.png" alt="" style="z-index: 2;" width="">
                    <img src="/img/dots-153.png" width="" alt="" class="relative-dots-about">
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