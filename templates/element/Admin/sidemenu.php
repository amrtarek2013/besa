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
      <span class="brand-text font-weight-light"><?=__('Dashboard')?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=__($g_configs['general']['txt.site_name'].' System v 1.0 ')?></a>
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
            <?= $this->AdminSideMenu->render($sideMenus, $current_prefix); ?>
        </nav>
        <!-- /.sidebar-menu -->
        
    </div>
    <!-- /.sidebar -->
</aside>