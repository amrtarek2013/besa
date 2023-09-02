<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Study Levels List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('Study Levels') ?></li>
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
                        echo $this->List->filter_form($studyLevels, $filters, [], [], $parameters, $session) ?>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('Study Levels List') ?></h3>
                            <?= $this->element('admin_index_top_bottom_actions', ['permissionList' => $permissionList, 'parameters' => $parameters, 'current_controller' => $current_controller]) ?>
                        </div>
                        <?php

                        $fields = [
                            'basicModel' => 'studyLevels',
                            'id' => [],
                            'title' => [],
                            // 'permalink' => [],
                            // 'icon_path' => ['title' => 'Icon', 'format' => 'link'],
                            // 'image_path' => ['title' => 'Image', 'format' => 'link'],
                            // 'banner_image_path' => ['title' => 'Banner Image', 'format' => 'link'],

                            'main_study_level_id' => ['format' => 'get_from_array', 'options' => ['items_list' => $mainStudyLevels]],
                            'display_order' => [],
                            // 'dealerships'=>[],
                            'active' => ['format' => 'bool'],
                            // 'show_on_home' => ['format' => 'bool'],
                            // 'show_on_footer' => ['format' => 'bool'],
                            // 'show_in_search' => ['format' => 'bool'],
                        ];

                        $multi_select_actions = array(
                            // 'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );


                        $actions = [
                            // 'view'=>$this->Html->link(__('View'), ['action' => 'view', '%id%'], array('class' => 'btn btn-primary btn-flat','icon'=>'fas fa-binoculars')),
                            'edit' => $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),

                            // array(
                            //     'condition' => 'empty($row["show_in_search"])',
                            //     'value' => $this->Html->link(
                            //         __('Delete'),
                            //         ['action' => 'delete', '%id%'],
                            //         [
                            //             'confirm' => __('Are you sure you wish to reject this booking?'),
                            //             'class' => 'btn btn-danger btn-flat', 'icon' => 'fas fa-xmark'
                            //         ]
                            //     ),
                            // ),

                            // 'delete' => $this->Html->link(
                            //     __('Delete'),
                            //     ['action' => 'delete', '%id%'],
                            //     [
                            //         'confirm' => 'Are you sure you wish to delete this?',
                            //         'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
                            //     ]
                            // )
                        ];


                        echo $this->List->adminIndex($fields, $studyLevels, $actions, true, $multi_select_actions, $parameters);
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