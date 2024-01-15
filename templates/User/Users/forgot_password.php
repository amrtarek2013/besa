<div class="background-login-page background-forgot-password-page">
  <div class="logo">
      <a href=""><img loading="lazy" src="<?= WEBSITE_URL ?>img/new-desgin/logo-footer.png" alt="main_logo" width="200"></a>
    </div>
    <?= $this->Form->create(null, array('id' => 'FormForgot')); ?>
    
        <div class="container-formBox login-tab">
          <a  href="<?= $this->Url->Build('/user/register') ?>"  class="back-link"> <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow-back.svg" alt=""> Back to home</a>
          <h4 class="title">Reset Password</h4>
          <p class="description">Add your registered email address and we will send an email with a link to reset your password</p>
          <div class="grid-container" style="display: block;">
            <?= $this->Form->control('email', ['placeholder' => 'Your Email', 'class' => 'form-control', 'label' => 'Email', 'required' => true]) ?>
          </div>
          <div class="container-submit">
            <button type="submit" class="btn clear-blue">Reset</button>
          </div>
        </div>
      <?= $this->Form->end() ?>

</div>




<section class="main-banner register-banner">

  <div class="container">
 

    <div class="row">
      <?= $this->Form->create(null, array('id' => 'FormForgot')); ?>
    
        <div class="container-formBox">
          <h4 class="title">Reset Password</h4>
          <div class="grid-container" style="display: block;">

            <?= $this->Form->control('email', ['placeholder' => 'Email address', 'class' => 'form-control', 'label' => 'Email address*', 'required' => true]) ?>
          </div>
          <div class="container-submit">
            <div class="checkboxes">
              <div>

                <a href="<?= $this->Url->Build('/user/register') ?>"> Register?</a>
              </div>
              <div>

                <a href="<?= $this->Url->Build('/user/register') ?>"> Login</a>
              </div>
            </div>

            <button type="submit" class="btn clear-blue">Reset</button>
          </div>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</section>