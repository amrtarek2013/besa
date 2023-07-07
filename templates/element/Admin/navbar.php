<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=ADMIN_LINK?>" class="nav-link"><?=__('Home')?></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Navbar Search -->

         <!-- <section id="navbar" class="if-lang-switch-<?= $switchLang ?>"> -->
        <!--     <li class="nav-item">
        <a href="<?= $this->Url->build('/admin/locale/' . $switchLang) ?>" class="nav-link">
            <i class="fa fa-language" aria-hidden="true"></i>
            <?= __($switchLang) ?>
        </a>
    </li> -->
    <!-- </section> -->

        <!--<li class="nav-item">
            <?php //echo $this->element('Admin/layout/navbar_search'); ?>
        </li>-->

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <?php //echo $this->element('Admin/layout/messages_dropdown'); ?>
        </li>
        
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <?php //echo $this->element('Admin/layout/notifications'); ?>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link">Hello, <?=$logged_user_info['name']?></a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
        </li> -->
    </ul>
</nav>
<!-- /.navbar -->

<style type="text/css">
    .fa.fa-language{
            font-size: 18px;
    }
</style>