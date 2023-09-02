<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $admin_title_prefix ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" as="style">
    <!-- Font Awesome -->
    <link rel="preload" href="<?= ADMIN_ASSETS ?>/plugins/fontawesome-free/css/all.min.css" as="style">
    <!-- icheck bootstrap -->
    <link rel="preload" href="<?= ADMIN_ASSETS ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css" as="style">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_css.css?v=<?= time() ?>">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>Dashboard</a>
        </div>

        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <?= $this->Flash->render() ?>
                <?= $this->Form->create() ?>
                <div class="input-group mb-3">
                    <?= $this->Form->control('name', ['placeholder' => 'Username / Email', 'class' => 'form-control login-fields', 'label' => false, 'required' => true]) ?>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <?= $this->Form->control('password', ['placeholder' => 'Password', 'class' => 'form-control login-fields', 'label' => false, 'required' => true]) ?>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <!-- <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label> -->
                        </div>
                    </div>

                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>

                </div>
                <?= $this->Form->end() ?>


                <p class="mb-1">
                    <!-- <a href="forgot-password.html">I forgot my password</a> -->
                </p>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

</body>

</html>