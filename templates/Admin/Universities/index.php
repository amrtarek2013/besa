<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Universities List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('Universities') ?></li>
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
                        echo $this->List->filter_form($universities, $filters, [], [], $parameters, $session) ?>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('Universities List') ?></h3>
                            <?= $this->element('admin_index_top_bottom_actions', ['permissionList' => $permissionList, 'parameters' => $parameters, 'current_controller' => $current_controller]) ?>
                        </div>
                        <?php

                        $fields = [
                            'basicModel' => 'universities',
                            'id' => [],
                            'university_name' => [],
                            // 'code' => [],
                            'country_id' => ['title' => 'Country', 'format' => 'get_from_array', 'options' => ['items_list' => $countries]],
                            // 'country_name' => ['title' => 'Country Name'],

                            // 'email' => [],
                            // 'telephone' => [],
                            // 'permalink' => [],
                            'logo_path' => ['title' => 'Logo', 'format' => 'image'],
                            'is_partner' => ['format' => 'bool'],
                            'show_on_destination' => ['format' => 'bool'],
                            'active' => ['format' => 'bool'],
                        ];

                        $multi_select_actions = array(
                            'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );


                        $actions = [
                            // 'view'=>$this->Html->link(__('View'), ['action' => 'view', '%id%'], array('class' => 'btn btn-primary btn-flat','icon'=>'fas fa-binoculars')),
                            // 'edit' => $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),

                            // 'delete' => $this->Html->link(

                            //     __('Delete'),
                            //     ['action' => 'delete', '%id%'],
                            //     [
                            //         'confirm' => 'Are you sure you wish to delete this?',
                            //         'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
                            //     ]
                            // )
                        ];
                        // $actions = $this->element('check_actions', ['actions' => ['edit' => 'universities', 'delete' => 'universities', 'view' => 'universities'], 'permissionList' => $permissionList]);
                        if (isset($permissionList[strtolower($current_controller) . '.edit'])) {
                            $actions['edit'] = $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt'));
                        }
                        if (isset($permissionList[strtolower($current_controller) . '.delete'])) {
                            $actions['delete'] = $this->Html->link(

                                __('Delete'),
                                ['action' => 'delete', '%id%'],
                                [
                                    'confirm' => 'Are you sure you wish to delete this?',
                                    'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
                                ]
                            );
                        }

                        echo $this->List->adminIndex($fields, $universities, $actions, false, $multi_select_actions, $parameters, false);
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