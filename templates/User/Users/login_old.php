<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Users | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <?php
  $cssArr = array(
    'adminlte.min.css',
    'admin.css',
    'all.min.css'
  );
  ?>
  <?= $this->Html->css($cssArr) ?>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b>User </b>login</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?= $this->Flash->render() ?>
        <?= $this->Form->create() ?>
        <div class="input-group mb-3">
          <?= $this->Form->control('email', ['placeholder' => 'Email address', 'class' => 'form-control', 'label' => false, 'required' => true]) ?>
          <span class="fas fa-user"></span>
        </div>
        <div class="input-group mb-3">
          <?= $this->Form->control('password', ['placeholder' => 'Password', 'class' => 'form-control', 'label' => false, 'required' => true]) ?>
          <span class="fas fa-lock"></span>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <a href="<?= $this->Url->Build('/user/forgot-password') ?>" lass="ForgotP">Forgot Password?</a>
        </div>
        <?= $this->Form->end() ?>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <?php
  $jsArr = array();

  echo $this->Html->script($jsArr);
  ?>

</body>

</html>