<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?=$g_configs['general']['txt.site_name']?> App
    </title>
    <link rel="icon" type="image/x-icon" href="<?= FRONT_ASSETS ?>/salem-favicon.png">
    <?= $this->Html->css(['/Front/css/all.min.css', '/Front/css/bootstrap.min.css', '/Front/css/fontawesome.min.css', '/Front/css/style.css?v=2']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>


    <script src="<?= FRONT_ASSETS ?>/js/jquery-3.6.0.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!-- <script src="js/fontawesome.js"></script> -->
    <script src="<?= FRONT_ASSETS ?>/js/script.js"></script>

</body>

</html>