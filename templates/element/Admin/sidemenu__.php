<?php
$current_controller = $this->request->getParam('controller');
$current_action = $this->request->getParam('action');

$dashboard_menu_open = $dashboard_active = '';
$admins_menu_open = $admins_active = '';
$stats_menu_open = $stats_active = '';
if($current_controller=="Admins" && in_array($current_action, ["index","add"]) ){
    $admins_menu_open = 'menu-open';
    $admins_active = 'active';
}elseif($current_controller=="Admins" && in_array($current_action, ["dashboard"]) ){
    $dashboard_menu_open = 'menu-open';
    $dashboard_active = 'active';
}elseif($current_controller=="Users" && in_array($current_action, ["usersPerCountry","usersPerLesson"]) ){
    $stats_menu_open = 'menu-open';
    $stats_active = 'active';
}else{

}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">    
    <a href="/admin" class="brand-link">
      <img src="<?=ADMIN_ASSETS?>/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin Dashboard for <?=$g_configs['general']['txt.site_name']?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header">Dashboard</li>
                <li class="nav-item <?=$dashboard_menu_open?>">
                    <a href="<?=ADMIN_LINK?>" class="nav-link <?=$dashboard_active?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item <?=$stats_menu_open?>">
                    <a href="#" class="nav-link <?=$stats_active?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Statistics<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=ADMIN_LINK?>/users/users-per-country" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users Per Country</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=ADMIN_LINK?>/users/users-per-lesson" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users Per Lesson</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?=$admins_menu_open?>">
                    <a href="#" class="nav-link <?=$admins_active?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Admins<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=ADMIN_LINK?>/admins" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admins list</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=ADMIN_LINK?>/admins/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add new</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?=ADMIN_LINK?>/admins/logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Log out</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>