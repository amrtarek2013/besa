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



    <div class="container-formBox">
        <h4 class="title">Filters</h4>
        <?= $this->Form->create(null, ['method' => 'get', 'action' => 'results', 'id' => 'search-courses-steps']); ?>
        <div class="">
            <?= $this->Form->control('country_id', [
                'placeholder' => 'Destination', 'type' => 'select', 'empty' => 'Select Destination',
                'options' => $countriesList, 'label' => 'Destination*', 'required' => true,
                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <?= $this->Form->control('study_level_id', [
                'placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*',
                'options' => $studyLevels, 'label' => 'Level of study*', 'required' => true,
                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <?= $this->Form->control('subject_area_id', [
                'placeholder' => 'Subject Area', 'type' => 'select', 'empty' => 'Select Subject Area*',
                'options' => $subjectAreas, 'label' => 'Subject Area*', 'required' => true,
                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
            ]) ?>
            <!-- </nav> -->
            <!-- /.sidebar-menu -->
        </div>
        <div class="container-submit">

            <button type="submit" class="btn greenish-teal">FILTER</button>
        </div>

        <?= $this->Form->end() ?>
    </div>
    <!-- /.sidebar -->
</aside>