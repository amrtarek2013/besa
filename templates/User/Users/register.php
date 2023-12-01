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
<section class="main-banner register-banner Create-account-banner">

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="background-banner-color">
          <img src="<?= WEBSITE_URL ?>img/hero-bg3.png" alt="" style="z-index: 2;" width="">
          <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
        </div>
      </div>
      <div class="col-md-6">
        <div class="relative-box-about ">
          <h1 class="relative-text">Create</h1>
          <h2 class="title text-left">Create an account</h2>
        </div>
      </div>

      <?php $bd = $user['bd'] ? explode('-', $user['bd']) : []; ?>
      <div class="col-md-8 mr">
        <?= $this->Form->create($user, array('id' => 'FormRegister', 'class' => 'register')); ?>

        <div class="container-formBox">
          <h4 class="title">Create an account to apply</h4>
          <div class="grid-container">

            <?= $this->Form->control('first_name', [
              'placeholder' => 'Name',
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>'], 'label' => 'Name*', 'required' => true
            ]) ?>

            <?= $this->Form->control('last_name', [
              'placeholder' => 'Last name*', 'label' => 'Last name*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>

            <div class=" form-area">
              <label for="">Date of Birth*</label>
              <div class="grid-3col">
                <select name="day" id="day" placeholder="Day" required="required">
                  <option value="">Day</option>

                  <?php

                  use Cake\Routing\Router;

                  for ($i = 1; $i <= 31; $i++) {
                    $d = $i; //date('M', strtotime("last day of +$i month"));
                    echo "<option value='$d' " . ((isset($bd[2]) && $bd[2] == $d) ? 'selected' : '') . ">$d</option>";
                  }
                  ?>

                </select>
                <select name="month" id="month" placeholder="Month" required="required">
                  <option value="">Month</option>
                  <?php
                  for ($i = 1; $i <= 12; $i++) {
                    $month = $i; // date('M', strtotime("last day of +$i month"));
                    echo "<option value='$month' " . ((isset($bd[1]) && $bd[1] == $month) ? 'selected' : '') . ">$month</option>";
                  }
                  ?>
                </select>
                <select name="year" id="year" placeholder="Year" required="required">
                  <option value="">Year</option>
                  <?php
                  for ($i = 1980; $i <= 2015; $i++) {
                    $year = $i; //date('Y', strtotime("last day of +$i year"));
                    echo "<option value='$year' " . ((isset($bd[0]) && $bd[0] == $year) ? 'selected' : '') . ">$year</option>";
                  }
                  ?>
                </select>
              </div>
            </div>


            <?= $this->Form->control('gender', [
              'placeholder' => 'Gender*', 'label' => 'Gender*', 'required' => true,
              'type' => 'select', 'empty' => 'Gender', 'options' => ['0' => 'Male', '1' => 'Female'],
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <?= $this->Form->control('nationality_id', [
              'placeholder' => 'Nationality*', 'label' => 'Nationality*', 'required' => true,
              'type' => 'select', 'empty' => 'Select Nationality*',
              'options' => $countriesList,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('country_id', [
              'placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence',
              'options' => $countriesList, 'label' => 'Country of Residence*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <?= $this->element('mobile_with_code', ['phone_name' => 'mobile', 'phone_label' => 'Mobile', 'phone_code' => 'mobile_code']) ?>



            <?= $this->Form->control('city', [
              'type' => 'text', 'placeholder' => 'City', 'label' => 'City*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('current_status', [
              'type' => 'text', 'placeholder' => 'Current/Previous-(School/University)', 'label' => 'Current/Previous-(School/University) *', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('current_study_level', [
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



            <?= $this->Form->control('email', [
              'type' => 'email',
              'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('password', [
              'type' => 'password',
              'placeholder' => 'Password',
              'label' => 'Password*',
              'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility(\'password\')"></i></div>']
            ]) ?>
            <?= $this->Form->control('passwd', [
              'type' => 'password',
              'placeholder' => 'Confirm Password',
              'label' => 'Confirm Password*',
              'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility(\'passwd\')"></i></div>']
            ]) ?>


            <?= $this->element('security_code', ['show_label' => 1, 'showCaptchCountriesList' => $showCaptchCountriesList]) ?>
          </div>
          <p class="light-para">For the purpose of applying regulation, your details are required.</p>

          <div class="container-submit">

            <div class="checkboxes">
              <div class="terms-conditions">
                <input type="checkbox" name="terms" id="terms" required="required">
                <label for="">I agree to <a href="#">terms & conditions</a> </label>
              </div>
              <div>
                <input type="checkbox" name="is_subscribed" id="is_subscribed">
                <label for="">Tick box to stay updated through BESA’s newsletter</label>
              </div>
            </div>

            <button type="submit" class="btn greenish-teal">REGISTER</button>
          </div>
        </div>
        <?= $this->Form->end() ?>

      </div>
      <div class="col-md-4 ml">
        <div class="container-formBox blue-border ">
          <?= $this->Form->create($user, array('url' => '/user/login', 'id' => 'FormLogin1', 'class' => 'login')); ?>


          <h4 class="title">Log in</h4>
          <div class="grid-container">

            <?= $this->Form->control('email', [
              'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>

            <?= $this->Form->control('password', [
              'type' => 'password',
              'placeholder' => 'Password',
              'label' => 'Password*',
              'required' => true,
              'id' => 'login-password',
              'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility(\'login-password\')"></i></div>']
            ]) ?>
            <div class="form-area">
              <a href="/user/forgot-password" class="forgot-link">Forgot Password?</a>
              <br />
              <button type="submit" class="btn clear-blue">LOG IN</button>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
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
        'nationality_id': {
          required: true
        },
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
        'current_study_level': {
          required: true,
        },
        'destination_id': {
          required: true,
        },
        'subject_area_id': {
          required: true,
        },
        'city': {
          required: true,
        },
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