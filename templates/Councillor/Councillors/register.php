<section class="main-banner register-banner Create-account-banner">

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
          <h1 class="relative-text">Create</h1>
          <h2 class="title text-left">Create an account</h2>
        </div>
      </div>


      <div class="col-md-8 mr">
        <?= $this->Form->create($councillor, array('id' => 'FormRegister', 'class' => 'register')); ?>

        <div class="container-formBox">
          <h4 class="title">Create an account to apply</h4>
          <div class="grid-container">

            <?= $this->Form->control('name', [
              'placeholder' => 'Name',
              'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>'], 'label' => 'Name*', 'required' => true
            ]) ?>
            <!-- <?= $this->Form->control('middle_name', ['placeholder' => 'Middle Name', 'class' => 'form-area', 'label' => 'Middle Name', 'required' => false]) ?> -->
            <?= $this->Form->control('surname', [
              'placeholder' => 'Surname*', 'label' => 'Surname*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
            ]) ?>

            <div class=" form-area">
              <label for="">Date of Birth*</label>
              <div class="grid-3col">
                <select name="day" id="day" placeholder="Day">
                  <option value="1">Day</option>
                  <option value="2">2</option>
                </select>
                <select name="month" id="month" placeholder="Month">
                  <option value="1">Month</option>
                  <option value="2">2</option>
                </select>
                <select name="year" id="year" placeholder="Year">
                  <option value="2000">Year</option>
                  <option value="2001">2001</option>
                </select>
              </div>
            </div>
            <?= $this->Form->control('email', [
              'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
            ]) ?>


            <?= $this->Form->control('gender', [
              'placeholder' => 'Gender*', 'label' => 'Gender*', 'required' => true,
              'type' => 'select', 'empty' => 'Gender', 'options' => ['0' => 'Male', '1' => 'Female'],
              'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
            ]) ?>

            <?= $this->Form->control('student_type', [
              'label' => 'I am a*', 'required' => true,
              'type' => 'select', 'options' => ['0' => 'Student', '1' => 'Student2'],
              'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
            ]) ?>

            <!-- <?= $this->Form->control('mobile', ['placeholder' => 'Mobile', 'class' => 'form-area', 'label' => 'Mobile*', 'required' => true]) ?>

            <?= $this->Form->control('password', ['type' => 'password', 'placeholder' => 'Password', 'class' => 'form-area', 'label' => 'Password*']) ?>
            <?= $this->Form->control('passwd', ['type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*']) ?>

            <?= $this->Form->control('gender', ['placeholder' => 'Gender', 'type' => 'select', 'empty' => 'Select Gender', 'options' => [0 => 'Male', 1 => 'Female'], 'class' => 'form-area', 'label' => 'Gender*', 'required' => true]) ?>

            <?= $this->Form->control('nationality', ['placeholder' => 'Nationality', 'class' => 'form-area', 'label' => 'Nationality*', 'required' => true]) ?>

            <?= $this->Form->control('country_id', ['placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence', 'options' => $countriesList, 'class' => 'form-area', 'label' => 'Country of Residence*', 'required' => true]) ?>

            <?= $this->Form->control('address', ['type' => 'text', 'placeholder' => 'Address', 'class' => 'form-area', 'label' => 'Address*', 'required' => true]) ?> -->

          </div>
          <p class="light-para">For the purpose of applying regulation, your details are required.</p>

          <div class="container-submit">

            <div class="checkboxes">
              <div>
                <input type="checkbox" name="" id="">
                <label for="">I agree to <a href="#">terms & conditions</a> </label>
              </div>
              <div>
                <input type="checkbox" name="" id="">
                <label for="">Tick box to stay updated through BESA’s newsletter</label>
              </div>
            </div>
            <a href="#" class="btn greenish-teal">SUBMIT</a>
          </div>
        </div>
        <?= $this->Form->end() ?>

      </div>
      <div class="col-md-4 ml">
        <div class="container-formBox blue-border ">
          <form action="/councillor/login" class="login" method="post">

            <?= $this->Form->create($councillor, array('url' => '/councillor/login', 'id' => 'FormLogin', 'class' => 'login')); ?>
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