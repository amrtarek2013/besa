<section class="main-banner register-banner">

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
          <h1 class="relative-text">Login</h1>
          <h2 class="title text-left">Login</h2>
        </div>
      </div>
    </div>
    <!-- <div class="col-md-12">
        <p class="descrpReg">For the purpose of applying regulation, your details are required.</p>
      </div> -->

    <div class="row">
      <?= $this->Form->create(null, array('id' => 'FormLogin')); ?>
      <div class="col-md-2">

        &nbsp;
      </div>
      <div class="col-md-8">
        <div class="container-formBox">
          <h4 class="title">Login Details</h4>
          <div class="grid-container" style="display: block;">


            <?= $this->Form->control('email', [
              'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
              'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>


          </div>
          <br /><br />
          <div class="grid-container" style="display: block;">

            <?= $this->Form->control('password', [
              'type' => 'password',
              'placeholder' => 'Password',
              'class' => 'form-area',
              'value' => '',
              'autocomplete' => false,
              'label' => 'Password*',
              'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility(\'password\')"></i></div>']
            ]) ?>

          </div>
          <div class="container-submit login-box-links" style="padding: 0 20px;">
            <div class="checkboxes links">
              <div>

                <a href="<?= $this->Url->Build('/user/register') ?>"> Register?</a>
              </div>
              <div>

                <a href="<?= $this->Url->Build('/user/forgot-password') ?>"> Forget Password?</a>
              </div>
            </div>

            <button type="submit" class="btn clear-blue">Sign In</button>
          </div>
        </div>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</section>