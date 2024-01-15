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




