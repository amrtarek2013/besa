<section class="main-banner register-banner">

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="background-banner-color">
          <img src="<?=WEBSITE_URL?>img/hero-bg3.png" alt="" style="z-index: 2;"  width="">
          <img src="<?=WEBSITE_URL?>img/dots-153.png" width="" alt="" class="relative-dots-about">
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
        Add your registered email address.</br>BESA will send an email with a link to reset your password
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

            <?= $this->Form->control('email', ['placeholder' => 'Email address', 'class' => 'form-control', 'label' => 'Email address*', 'required' => true]) ?>
          </div>
          <div class="container-submit">
            <div class="checkboxes">
              <div>

                <a href="<?= $this->Url->Build('/counselor/register') ?>"> Register?</a>
              </div>
              <div>

                <a href="<?= $this->Url->Build('/counselor/login') ?>"> Login</a>
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