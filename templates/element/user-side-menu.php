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

        /* float: left !important; */
        margin-left: 10px;
    }

    .nav-link p {
        float: left !important;
        /* margin-left: 10px; */
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
<aside class="main-sidebar sidebar-dark-primary elevation-4 counselor-sidebar">
    <a href="<?= USER_LINK ?>" class="brand-link">
        <span class="brand-text font-weight-light"><?= __('Student Dashboard') ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="left-box">
                <div class=" circle-img-center">
                    <img class="circle-img" src="<?= $_SESSION['Auth']['User']['image_path'] ?>?v=1" alt="" style="width: 128px;height: 128px;">
                </div>
                <?php

                use Cake\Routing\Router;

                ?>
                <span class="online-status"><?= true ? 'ONLINE' : 'OFFLINE' ?></span>

            </div>
        </div> -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= $this->AdminSideMenu->render($sideMenus, $current_prefix, false); ?>

            <li class="nav-item ">
                <a href="<?= Router::url('/user/logout') ?>" class="nav-link nav-link2 ">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Log Out</p>
                </a>
            </li>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
</aside>