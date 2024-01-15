<div class="background-login-page">
  <div class="logo">
      <a href=""><img loading="lazy" src="<?= WEBSITE_URL ?>img/new-desgin/logo-footer.png" alt="main_logo" width="200"></a>
    </div>
  <div class="">
    <?= $this->Form->create(null, array('id' => 'FormLogin')); ?>
      <div class="container-formBox login-tab">
      <a href="#" class="back-link"> <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow-back.svg" alt=""> Back to home</a>

        <h4 class="title">Login to BESA</h4>
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
        <div class="container-submit login-box-links" style="">
          <a href="<?= $this->Url->Build('/user/forgot-password') ?>"> Forget Password?</a>
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </div>
    <?= $this->Form->end() ?>
  </div>
</div>



<section class="main-banner register-banner">

  <div class="container">

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