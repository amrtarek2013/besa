<style type="text/css">
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
        background-color: #676767;
        color: #fff;
    }

    .nav-sidebar .nav-link>.right,
    .nav-sidebar .nav-link>p>.right {
        top: 0.8rem;
    }

    .nav-sidebar {
        white-space: nowrap;
    }

    .nav-link .nav-icon {

        float: left !important;
    }

    .nav-link p {
        float: left !important;
        margin-left: 10px;
    }

    .sidebar {
        margin-top: 20px;
        padding: 5px;
    }

    .sidebar {
        background: #FFFFFF;
        border-radius: 10px;
        padding: 25px;
        border-top: 14px solid #33CA94;
    }

    .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .nav li {
        width: 100%;
        clear: both;
        padding-bottom: 15px;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= USER_LINK ?>" class="brand-link">
        <!-- <img src="<?= ADMIN_ASSETS ?>/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-light"><?= __('User Dashboard') ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- <div class="image"> -->
            <div class="left-box">
                <div class="circle-img">
                    <img src="<?= $counselor['image_path'] ?>" alt="" style="width: 128px;height: 128px;">
                </div>
                <h3 class="name-profile"><?= strtoupper($auth->user('first_name') . ' ' . $auth->user('last_name')) ?></h3>
                <span class="status"><?= $counselor['email_confirmed'] ? 'APPROVED' : 'PENDING' ?></span>

            </div>
            <!-- </div> -->
            <!-- <div class="info">
                <a href="#" class="d-block"><?= __($g_configs['general']['txt.site_name'] . ' System v 1.0 ') ?></a>
            </div> -->
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="<?= __('Search') ?>" aria-label="<?= __('Search') ?>">
                <div class="input-group-append">
                    <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= $this->AdminSideMenu->render($sideMenus, $current_prefix, true); ?>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
</aside>