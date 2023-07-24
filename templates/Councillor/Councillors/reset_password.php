<section class="main-banner register-banner">

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="background-banner-color">
          <img src="<?=WEBSITE_URL?>img/hero-bg3.png" alt="" style="z-index: 2;">
          <img src="<?=WEBSITE_URL?>img/dots-153.png" alt="" class="relative-dots-about">
        </div>
      </div>
      <div class="col-md-6">
        <div class="relative-box-about ">
          <h1 class="relative-text">Reset Password</h1>
          <h2 class="title text-left">Reset Password</h2>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <p class="descrpReg">
        Add your new Password
      </p>
    </div>

    <div class="row">
      <?= $this->Form->create(null, array('id' => 'FormForgot')); ?>
      <div class="col-md-2">

        &nbsp;
      </div>
      <div class="col-md-8">
        <div class="container-formBox">
          <h4 class="title">Reset Password</h4>
          <div class="grid-container" style="display: block;">

            <?= $this->Form->control('password', ['type' => 'password', 'placeholder' => 'New Password', 'class' => 'form-area', 'value' => '', 'autocomplete' => false, 'label' => 'New Password*']) ?>
            <?= $this->Form->control('passwd', ['type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*']) ?>


          </div>
          <div class="container-submit">
            <div class="checkboxes">
              <div>

                <a href="<?= $this->Url->Build('/councillor/register') ?>"> Register?</a>
              </div>
              <div>

                <a href="<?= $this->Url->Build('/councillor/login') ?>"> Login</a>
              </div>
            </div>

            <button type="submit" class="btn clear-blue">Reset</button>
          </div>
        </div>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</section>