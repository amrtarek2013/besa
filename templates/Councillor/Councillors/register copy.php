<section class="main-banner register-banner">

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="background-banner-color">
          <img src="/img/hero-bg3.png" alt="" style="z-index: 2;">
          <img src="/img/dots-153.png" alt="" class="relative-dots-about">
        </div>
      </div>
      <div class="col-md-6">
        <div class="relative-box-about ">
          <h1 class="relative-text">Register</h1>
          <h2 class="title text-left">Register</h2>
        </div>
      </div>
      <div class="col-md-12">
        <p class="descrpReg">For the purpose of applying regulation, your details are required.</p>
      </div>

      <?= $this->Form->create($councillor, array('id' => 'FormRegister')); ?>
      <div class="col-md-12">
        <div class="container-formBox">
          <h4 class="title">Basic Information</h4>
          <div class="grid-container">

            <?= $this->Form->control('first_name', ['placeholder' => 'First Name', 'class' => 'form-area', 'label' => 'First Name*', 'required' => true]) ?>
            <?= $this->Form->control('middle_name', ['placeholder' => 'Middle Name', 'class' => 'form-area', 'label' => 'Middle Name', 'required' => false]) ?>
            <?= $this->Form->control('last_name', ['placeholder' => 'Last Name', 'class' => 'form-area', 'label' => 'Last Name*', 'required' => true]) ?>
            <?= $this->Form->control('email', ['placeholder' => 'Email address', 'class' => 'form-control', 'label' => 'Email address*', 'required' => true]) ?>

            <?= $this->Form->control('mobile', ['placeholder' => 'Mobile', 'class' => 'form-area', 'label' => 'Mobile*', 'required' => true]) ?>

            <?= $this->Form->control('password', ['type' => 'password', 'placeholder' => 'Password', 'class' => 'form-area', 'label' => 'Password*']) ?>
            <?= $this->Form->control('passwd', ['type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*']) ?>

            <?= $this->Form->control('gender', ['placeholder' => 'Gender', 'type' => 'select', 'empty' => 'Select Gender', 'options' => [0 => 'Male', 1 => 'Female'], 'class' => 'form-area', 'label' => 'Gender*', 'required' => true]) ?>

            <?= $this->Form->control('nationality', ['placeholder' => 'Nationality', 'class' => 'form-area', 'label' => 'Nationality*', 'required' => true]) ?>

            <?= $this->Form->control('country_id', ['placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence', 'options' => $countriesList, 'class' => 'form-area', 'label' => 'Country of Residence*', 'required' => true]) ?>

            <?= $this->Form->control('address', ['type' => 'text', 'placeholder' => 'Address', 'class' => 'form-area', 'label' => 'Address*', 'required' => true]) ?>

          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="container-formBox blue-border">
          <h4 class="title">Education Information</h4>
          <div class="grid-container">
            <?= $this->Form->control('study_level_id', ['placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*', 'options' => $services, 'class' => 'form-area', 'label' => 'Level of study*', 'required' => true]) ?>

            <?= $this->Form->control('course_interest_id', ['placeholder' => 'Course of Interest', 'type' => 'select', 'empty' => 'Select Course of Interest*', 'options' => $services, 'class' => 'form-area', 'label' => 'Course of Interest*', 'required' => true]) ?>

            <?= $this->Form->control('current_status', ['type' => 'text', 'placeholder' => 'Current status', 'class' => 'form-area', 'label' => 'Current status*', 'required' => true]) ?>

            <?= $this->Form->control('high_school_grade', ['type' => 'text', 'placeholder' => 'High school grade', 'class' => 'form-area', 'label' => 'High school grade*', 'required' => true]) ?>

            <?= $this->Form->control('how_hear_about_us', ['type' => 'text', 'placeholder' => 'How did you hear about us?', 'class' => 'form-area', 'label' => 'How did you hear about us?', 'required' => true]) ?>

          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="container-submit">
          <div class="checkboxes">
            <div>
              <input type="checkbox" name="agree" id="agree">
              <label for="agree">I agree to <a href="#">terms & conditions</a> </label>
            </div>
            <div>
              <input type="checkbox" name="news_subscribe" id="news_subscribe">
              <label for="news_subscribe">I’d like being informed about latest news and tips</label>
            </div>
          </div>
          <button type="submit" class="btn clear-blue">Sign Up</button>
        </div>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</section>