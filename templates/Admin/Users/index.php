<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">
<style>
    .btn-sm {
        margin-top: 5px;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Students List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('Students') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <?php
                        $session = $this->getRequest()->getSession();
                        echo $this->List->filter_form($users, $filters, [], [], $parameters, $session) ?>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('Students List') ?></h3>
                            <?= $this->element('admin_index_top_bottom_actions', ['permissionList' => $permissionList, 'parameters' => $parameters, 'current_controller' => $current_controller]) ?>
                        </div>
                        <?php

                        $fields = [
                            'basicModel' => 'users',
                            'id' => [],
                            'first_name' => ['title' => 'Name'],
                            // 'country_id' => ['title' => 'Country', 'format' => 'get_from_array', 'options' => ['items_list' => $countries]],
                            'country.country_name' => ['title' => 'Country'],

                            'email' => [],
                            'mobile' => [],
                            'display_order' => [],
                            'active' => ['format' => 'bool'],
                            'confirmed' => ['format' => 'bool'],
                        ];

                        $multi_select_actions = array(
                            'confirm & Activate' => array('action' => $this->Url->build(['action' => 'confirm_multi', 'Admin' => true]), 'confirm' =>'Are you sure you wish to confirm and activate all selected data?'),
                            'delete' => array('action' => $this->Url->build(['action' => 'delete_multi', 'Admin' => true]), 'confirm' => true)
                            
                        );

                        $actions = [
                            'view' => $this->Html->link(__('View'), ['action' => 'view', '%id%'], array('class' => 'btn btn-primary btn-sm', 'icon' => 'fas fa-binoculars')),
                            'edit' => $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),

                            'delete' => $this->Html->link(

                                __('Delete'),
                                ['action' => 'delete', '%id%'],
                                [
                                    'confirm' => 'Are you sure you wish to delete this?',
                                    'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
                                ]
                            )
                        ];
                        echo $this->List->adminIndex($fields, $users, $actions, true, $multi_select_actions, $parameters);
                        ?>
                        <div class="card-footer clearfix">
                            <?= $this->element('admin_index_top_bottom_actions', ['permissionList' => $permissionList, 'parameters' => $parameters, 'current_controller' => $current_controller]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>