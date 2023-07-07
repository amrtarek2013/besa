<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User | Reset Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <?php
    $cssArr = array(
        'adminlte.min.css',
        'admin.css',
        // 'ionicons.min.css',
        'all.min.css',
        // 'tempusdominus-bootstrap-4.min.css',
        // 'icheck-bootstrap.min.css',
        // 'jqvmap.min.css',
        // 'OverlayScrollbars.min.css',
        // 'daterangepicker.css',
        // 'summernote-bs4.css',
    );
    ?>
  <?= $this->Html->css($cssArr) ?>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>Reset Password</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Add your registered email address.</br>OzCar will send an email with a link to reset your password</p>
      <?= $this->Flash->render() ?>
      <?= $this->Form->create() ?>
      <!-- <form action="../../index3.html" method="post"> -->
        <div class="input-group mb-3">
        <?= $this->Form->control('email', ['placeholder'=>'Email address','class'=>'form-control','label'=>false,'required' => true]) ?>
          <!-- <input type="email" class="form-control" placeholder="Email"> -->
          <span class="fas fa-envelope"></span>
          <!-- <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div> -->
        </div>
        <div class="row">
          <div class="col-8">
            <!-- <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div> -->
          </div>
         <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Reset</button>
          </div>
          
         </div>
        <?= $this->Form->end() ?>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="#" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<?php
$jsArr = array(
    // 'jquery.min',
    // 'jquery-ui.min',
    // 'bootstrap.bundle.min',
    // 'Chart.min',
    // 'sparkline',
    // 'jquery.vmap.min',
    // 'jquery.vmap.usa',
    // 'jquery.knob.min',
    // 'moment.min',
    // 'daterangepicker',
    // 'tempusdominus-bootstrap-4.min',
    // 'summernote-bs4.min',
    // 'jquery.overlayScrollbars.min',
    // 'adminlte',
    // 'dashboard',
    // 'demo',

);

echo $this->Html->script($jsArr);
?>

</body>
</html>
