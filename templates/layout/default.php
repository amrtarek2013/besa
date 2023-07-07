<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $g_configs['general']['txt.site_name'] ?> - British educational services agency</title>
    <link rel="icon" type="image/x-icon" href="<?= FRONT_ASSETS ?>/favicon.ico">
    <!-- add This File (range slider)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.css" />
    <?= $this->Html->css([

        '/css/new-css/all.min.css',
        '/css/new-css/normalize.min.css',
        '/css/new-css/owl.carousel.min.css',
        '/css/new-css/grid.css',
        '/css/new-css/style.css?v=' . time(),
        '/css/new-css/responsive.css',
        '/css/new-css/animations.css',
        '/css/new-css/timeline.css'
    ]) ?>

    <?= $this->Html->script([
        '/js/new-js/jquery-3.6.3.min.js',
        '/js/new-js/fontawesome.min.js',
        '/js/new-js/owl.carousel.min.js',
        '/js/new-js/pana-accordion.js',
        '/js/new-js/timeline.js',
        '/js/new-js/script.js?v=' . time(),
    ]) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<?php $bodyClass = isset($bodyClass) ? $bodyClass : '' ?>

<body cz-shortcut-listen="true" class="<?= $bodyClass ?>">

    <?= $this->element('UserPopUp'); ?>
    <?php //= $header 
    ?>
    <?php echo $this->element('navbar'); ?>
    <!-- Start Content -->
    <?php if ($prefix == 'User') {

    ?>

        <?php

        if ((isset($_SESSION['Auth']['User']) || isset($_SESSION['Auth']['Councillor'])) && $this->request->getParam('action') != 'dashboard') { ?>


            <div class="container">
                <div class="row user-dashboard">

                    <div class="col-md-3">
                        <?php echo $this->element('user-side-menu', array('sideMenus' => $sideMenus, 'urlPrefixText' => $urlPrefixText, "pageHead" => $pageHead)); ?>
                    </div>
                    <div class="col-md-9">


                        <?= $this->Flash->render() ?>
                        <?= $this->fetch('content') ?>
                    </div>

                </div>
            </div>

        <?php } else { ?>

            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        <?php } ?>
    <?php } else { ?>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>

    <?php }
    ?>

    <?php // $footer 
    ?>
    <?= $this->element('footer'); ?>

</body>

</html>