<?php
$current_controller = $this->request->getParam('controller');
$current_action = $this->request->getParam('action');

$dashboard_menu_open = $dashboard_active = '';
$users_menu_open = $users_active = '';
$admins_menu_open = $admins_active = '';
$roles_menu_open = $roles_active = '';
$GeneralConfigurations_stats_menu_open = $GeneralConfigurations_stats_active = '';


if($current_controller=="Admins" && in_array($current_action, ["index","add"]) ){
    $admins_menu_open = 'menu-open';
    $admins_active = 'active';
}elseif($current_controller=="Admins" && in_array($current_action, ["dashboard"]) ){
    $dashboard_menu_open = 'menu-open';
    $dashboard_active = 'active';
}elseif($current_controller=="GeneralConfigurations" && in_array($current_action, ["index","edit"]) ){
    $GeneralConfigurations_stats_menu_open = 'menu-open';
    $GeneralConfigurations_stats_active = 'active';
}elseif($current_controller=="Roles" && in_array($current_action, ["index","add"]) ){
    $roles_menu_open = 'menu-open';
    $roles_active = 'active';
}else{

}
?>
<style type="text/css">
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active, 
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus, 
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover{
        background-color: #676767;
        color: #fff;
    }
    .nav-sidebar .nav-link>.right, .nav-sidebar .nav-link>p>.right{
        top: 0.8rem;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">    
    <a href="<?=ADMIN_LINK?>" class="brand-link">
      <img src="<?=ADMIN_ASSETS?>/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?=__('Admin Dashboard')?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=__('Admin Dashboard for <?=$g_configs['general']['txt.site_name']?>')?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="<?=__('Search')?>" aria-label="<?=__('Search')?>">
                <div class="input-group-append">
                    <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php if(true){ ?>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header"><?=__('Dashboard')?></li>

                <?php if(in_array("Admins_dashboard", $permissions_list) ){ ?>
                <li class="nav-item <?=$dashboard_menu_open?>">
                    <a href="<?=ADMIN_LINK?>" class="nav-link nav-link2 <?=$dashboard_active?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p><?=__('Dashboard1')?></p>
                    </a>
                </li>
                <?php } ?>






                <?php if( in_array("GeneralConfigurations_index", $permissions_list) 
                       // || in_array("GeneralConfigurations_edit", $permissions_list)
                 ){ ?>
                <li class="nav-item <?=$GeneralConfigurations_stats_menu_open?>">
                    <a href="#" class="nav-link <?=$GeneralConfigurations_stats_active?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p><?=__('General Configurations')?><i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                       
                        <?php if(in_array("GeneralConfigurations_index", $permissions_list) ){ ?>
                        <li class="nav-item">
                            <a href="<?=ADMIN_LINK?>/general-configurations/index" class="nav-link nav-link2">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?=__('Configurations List')?></p>
                            </a>
                        </li>
                        <?php } ?>

                      

                    </ul>
                </li>
                <?php } ?>



                <?php if(in_array("Admins_index", $permissions_list) ){ ?>
                <li class="nav-item <?=$admins_menu_open?>">
                    <a href="#" class="nav-link <?=$admins_active?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p><?=__('Admins')?><i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if(in_array("Admins_index", $permissions_list) ){ ?>
                        <li class="nav-item">
                            <a href="<?=ADMIN_LINK?>/admins" class="nav-link nav-link2">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?=__('Admins list')?></p>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if(in_array("Admins_add", $permissions_list) ){ ?>
                        <li class="nav-item">
                            <a href="<?=ADMIN_LINK?>/admins/add" class="nav-link nav-link2">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?=__('Add new')?></p>
                            </a>
                        </li>
                        <?php } ?>

                    </ul>
                </li>
                <?php } ?>



                <?php if($is_super_admin){ ?>
                    <li class="nav-item <?=$roles_menu_open?>">
                        <a href="#" class="nav-link <?=$roles_active?>">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p><?=__('Roles')?><i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?=ADMIN_LINK?>/roles" class="nav-link nav-link2">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?=__('Roles list')?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?=ADMIN_LINK?>/roles/add" class="nav-link nav-link2">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?=__('Add new')?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>


                <li class="nav-item">
                    <a href="<?=ADMIN_LINK?>/admins/logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p><?=__('Log out')?></p>
                    </a>
                </li>

            </ul>
            <?php } ?>
            <?= $this->AdminSideMenu->render($sideMenus, $current_prefix); ?>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>