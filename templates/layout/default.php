<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $g_configs['general']['txt.site_name'] . ' - ' . $title : $g_configs['general']['txt.site_name'] . ' - British Educational Services Group' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= FRONT_ASSETS ?>/favicon.ico">
    <!-- add This File (range slider)-->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.js" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.css" as="style">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.2/nouislider.min.css" />
    <?= $this->Html->css([

        '/css/new-css/remodal.css',
        '/css/new-css/remodal-default-theme.css',
        '/css/new-css/all.min.css',
        '/css/new-css/normalize.min.css',
        '/css/new-css/owl.carousel.min.css',
        '/css/new-css/grid.css',
        '/css/new-css/style.css?v=' . time(),
        '/css/new-css/responsive.css?v=' . time(),
        '/css/new-css/animations.css',
        // '/css/new-css/timeline.css'
    ]) ?>

    <?= $this->Html->script([
        '/js/new-js/jquery-3.6.3.min.js',
        '/js/new-js/fontawesome.min.js',
        '/js/new-js/remodal.js',
        '/js/new-js/overlay.js',
        '/js/new-js/owl.carousel.min.js',
        // '/js/new-js/pana-accordion.js',
        // '/js/new-js/timeline.js',
        '/js/new-js/script.js?v=' . time(),
    ]) ?>
    <?php

    echo $g_configs['general']['txt.facebook_pixels'];
    echo $g_configs['general']['txt.google_analytics'];
    echo $g_configs['general']['txt.tiktok_pixels'];
    echo $g_configs['general']['txt.google_tag_manager'];

    if (!empty($metaRobots)) {
        echo $this->Html->meta('robots', $metaRobots);
    }
    if (!empty($metaKeywords)) {
        echo $this->Html->meta('keywords', $metaKeywords);
    }
    if (!empty($metaDescription)) {
        echo $this->Html->meta('description', $metaDescription);
    }

    ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <link rel="preload" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" as="style" />

    <link rel="preload" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" as="script" />
</head>
<?php $bodyClass = isset($bodyClass) ? $bodyClass : '' ?>

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.message').hide();
        toastr.options.closeButton = true;
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 500;
        toastr.options.closeEasing = 'swing';
        if ($(".message.success").length) {
            toastr.success($(".message.success").text());
        }
        if ($(".message.error").length) {
            toastr.error($(".message.error").text());
        }
    });
</script>

<body cz-shortcut-listen="true" class="<?= $bodyClass ?>">
    <div class="overlay"></div>

    <?= $this->element('UserPopUp'); ?>
    <?php //= $header 

    if (!in_array($this->request->getParam('action'), ['login', 'register']) && $this->request->getParam('controller') != 'users') : ?>

        <?php echo $this->element('navbar', ['cache' => ['key' => 'navbar', 'config' => '_view_long_']]); ?>
    <?php endif; ?>
    <!-- Start Content -->
    <?php if (in_array($prefix, ['User', 'Counselor'])) {

    ?>

        <?php
        // debug((isset($_SESSION['Auth']['User']) && strtolower($prefix) == 'user') || (isset($_SESSION['Auth']['Counselor']) && strtolower($prefix) == 'counselor')  && $this->request->getParam('action') != 'dashboard');
        if ((isset($_SESSION['Auth']['User']) && strtolower($prefix) == 'user' && $this->request->getParam('action') != 'dashboard') || (isset($_SESSION['Auth']['Counselor']) && strtolower($prefix) == 'counselor'  && $this->request->getParam('action') != 'dashboard' && $this->request->getParam('action') != 'points')) { ?>

            <div class="hero-counselor">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-card">
                                <?php
                                if (isset($_SESSION['Auth']['Counselor']) && strtolower($prefix) == 'counselor') {
                                ?>
                                    <div class="profile-picture">
                                        <img src="<?= $counselor['image_path'] ?>" alt="User Avatar">
                                    </div>
                                    <div class="profile-info">
                                        <h3 class="user-name"><?= strtoupper($auth->user('first_name') . ' ' . $auth->user('last_name')) ?></h3>
                                        <div class="user-points"><?= !empty($counselor['total_points']) && $counselor['total_points'] > 0 ? $counselor['total_points'] : '0' ?> Points</div>
                                    </div>
                                <?php } else {
                                ?>
                                    <div class="profile-picture">
                                        <img src="<?= $user['image_path'] ?>" alt="User Avatar">
                                    </div>
                                    <div class="profile-info">
                                        <h3 class="user-name"><?= strtoupper($auth->user('first_name') . ' ' . $auth->user('last_name')) ?></h3>
                                        <div class="user-points"><?= $_SESSION['Auth']['User']['active'] == 1 ? 'Approved' : '--' ?> Points</div>
                                        
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row user-dashboard">
                    <?php
                    if (isset($_SESSION['Auth']['Counselor']) && strtolower($prefix) == 'counselor') {

                        $Counselors = Cake\ORM\TableRegistry::getTableLocator()->get('Counselors');

                        $counselor = $Counselors->find()->select(['total_points', 'total_points_reward'])->where(['id' => $_SESSION['Auth']['Counselor']['id']])->first();

                    ?>

                        <div class="col-md-3">

                            <?php echo $this->element('counselor-side-menu', array('sideMenus' => $sideMenus, 'urlPrefixText' => $urlPrefixText, "pageHead" => $pageHead, 'counselor' => $counselor)); ?>
                        </div>

                    <?php } else if (isset($_SESSION['Auth']['User']) && strtolower($prefix) == 'user') { ?>

                        <div class="col-md-3">
                            <?php echo $this->element('user-side-menu', array('sideMenus' => $sideMenus, 'urlPrefixText' => $urlPrefixText, "pageHead" => $pageHead)); ?>

                        </div>
                    <?php } ?>
                    <div class="col-md-9 pl30" style="">


                        <?= $this->Flash->render() ?>
                        <?= $this->fetch('content') ?>


                    </div>



                </div>

            </div>
            <?php if (isset($_SESSION['Auth']['Counselor']) && strtolower($prefix) == 'counselor') {
                if ($this->request->getParam('action') == 'index' && $this->request->getParam('controller') == 'Applications') : ?>
                    <?php echo $this->element('counselor/students-app-stats', array('counselor' => $counselor)); ?>
                <?php endif; ?>
            <?php } ?>

        <?php } else { ?>

            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        <?php } ?>
    <?php } else { ?>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>

    <?php }

    if (!in_array($this->request->getParam('action'), ['login', 'register']) && $this->request->getParam('controller') != 'users') : ?>

        <?= $this->element('footer', ['cache' => ['key' => 'footer', 'config' => '_view_long_']]); ?>
    <?php endif; ?>
</body>

</html>