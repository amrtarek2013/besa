<section class="main-banner register-banner Create-account-banner">

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="background-banner-color">
          <img src="<?= WEBSITE_URL ?>img/hero-bg3.png" alt="" style="z-index: 2;">
          <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
        </div>
      </div>
      <div class="col-md-6">
        <div class="relative-box-about ">
          <h1 class="relative-text">Create</h1>
          <h2 class="title text-left">Create an account</h2>
        </div>
      </div>


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
              'placeholder' => 'Surname*', 'label' => 'Surname*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>

            <div class=" form-area">
              <label for="">Date of Birth*</label>
              <div class="grid-3col">
                <select name="day" id="day" placeholder="Day" required="required">
                  <option value="">Day</option>

                  <?php
                  for ($i = 1; $i <= 31; $i++) {
                    $d = $i; //date('M', strtotime("last day of +$i month"));
                    echo "<option value='$d'>$d</option>";
                  }
                  ?>

                </select>
                <select name="month" id="month" placeholder="Month" required="required">
                  <option value="">Month</option>
                  <?php
                  for ($i = 1; $i <= 12; $i++) {
                    $month = $i; // date('M', strtotime("last day of +$i month"));
                    echo "<option value='$month'>$month</option>";
                  }
                  ?>
                </select>
                <select name="year" id="year" placeholder="Year" required="required">
                  <option value="">Year</option>
                  <?php
                  for ($i = 1980; $i <= 2015; $i++) {
                    $year = $i; //date('Y', strtotime("last day of +$i year"));
                    echo "<option value='$year'>$year</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class=" form-area">
              <label for="">Mobile*</label>
              <div class="grid-2col-mobile">
                <?= $this->Form->control('mobile_code', [
                  'placeholder' => 'Code', 'class' => 'form-control', 'label' => false, 'required' => true,
                  'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                ]) ?>

                <?= $this->Form->control('mobile', [
                  'placeholder' => 'Mobile', 'class' => 'form-control', 'label' => false, 'required' => true,
                  'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                ]) ?>
              </div>
            </div>

            <?= $this->Form->control('email', [
              'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            

            <?= $this->Form->control('password', [
                'type' => 'password',
                'placeholder' => 'Password',
                'label' => 'Password*',
                'required' => true,
                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility()"></i></div>']
            ]) ?>

            <?= $this->Form->control('passwd', [
                'type' => 'password',
                'placeholder' => 'Confirm Password',
                'label' => 'Confirm Password*',
                'required' => true,
                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility()"></i></div>']
            ]) ?>


            <?= $this->Form->control('gender', [
              'placeholder' => 'Gender*', 'label' => 'Gender*', 'required' => true,
              'type' => 'select', 'empty' => 'Gender', 'options' => ['0' => 'Male', '1' => 'Female'],
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>

            <!-- <?= $this->Form->control('student_type', [
                    'label' => 'I am a*', 'required' => true,
                    'type' => 'select', 'options' => ['0' => 'Student', '1' => 'Student2'],
                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                  ]) ?> -->


            <?= $this->Form->control('country_id', [
              'placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence',
              'options' => $countriesList, 'label' => 'Country of Residence*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('city', [
              'type' => 'text', 'placeholder' => 'City', 'label' => 'City*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('current_status', [
              'type' => 'text', 'placeholder' => 'Current/Previous-(School/University)', 'label' => 'Current/Previous-(School/University) *', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('study_level_id', [
              'placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*',
              'options' => $mainStudyLevels, 'label' => 'Level of study*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>

            <?= $this->Form->control('subject_area_id', [
              'placeholder' => 'Subject Area', 'type' => 'select', 'empty' => 'Select Subject Area*',
              'options' => $subjectAreas, 'label' => 'Subject Area*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('destination_id', [
              'placeholder' => 'Destination', 'type' => 'select', 'empty' => 'Select Destination',
              'options' => $destinationsList, 'label' => 'Destination*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>

            <!-- <?= $this->Form->control('mobile', ['placeholder' => 'Mobile', 'label' => 'Mobile*', 'required' => true]) ?>

            <?= $this->Form->control('password', ['type' => 'password', 'placeholder' => 'Password', 'label' => 'Password*']) ?>
            <?= $this->Form->control('passwd', ['type' => 'password', 'placeholder' => 'Confirm Password', 'label' => 'Confirm Password*']) ?>

            <?= $this->Form->control('gender', ['placeholder' => 'Gender', 'type' => 'select', 'empty' => 'Select Gender', 'options' => [0 => 'Male', 1 => 'Female'], 'label' => 'Gender*', 'required' => true]) ?>

            <?= $this->Form->control('nationality', ['placeholder' => 'Nationality', 'label' => 'Nationality*', 'required' => true]) ?>

            <?= $this->Form->control('country_id', ['placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence', 'options' => $countriesList, 'label' => 'Country of Residence*', 'required' => true]) ?>

            <?= $this->Form->control('address', ['type' => 'text', 'placeholder' => 'Address', 'label' => 'Address*', 'required' => true]) ?> -->

          </div>
          <p class="light-para">For the purpose of applying regulation, your details are required.</p>

          <div class="container-submit">

            <div class="checkboxes">
              <div>
                <input type="checkbox" name="terms" id="terms" required="required">
                <label for="">I agree to <a href="#">terms & conditions</a> </label>
              </div>
              <div>
                <input type="checkbox" name="is_subscribed" id="is_subscribed">
                <label for="">Tick box to stay updated through BESA’s newsletter</label>
              </div>
            </div>
            <!-- <a href="#" class="btn greenish-teal">SUBMIT</a> -->

            <button type="submit" class="btn greenish-teal">LOG IN</button>
          </div>
        </div>
        <?= $this->Form->end() ?>

      </div>
      <div class="col-md-4 ml">
        <div class="container-formBox blue-border ">
          <?= $this->Form->create($user, array('url' => '/user/login', 'id' => 'FormLogin', 'class' => 'login')); ?>


          <h4 class="title">Log in</h4>
          <div class="grid-container">
            <div class="form-area">
              <label for="email">Email*</label>
              <input type="email" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-area">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" placeholder="password">
            </div>
            <div class="form-area">
              <!-- <a href="#" class="btn clear-blue">LOG IN</a> -->
              <button type="submit" class="btn clear-blue">LOG IN</button>
            </div>
          </div>
          </form>
        </div>
      </div>
      <!-- <div class="col-md-12">
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
      </div> -->
    </div>
  </div>
</section>