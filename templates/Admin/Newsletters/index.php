<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Newsletters List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('Newsletters') ?></li>
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
                        echo $this->List->filter_form($newsletters, $filters, [], [], $parameters, $session) ?>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('Newsletters List') ?></h3>
                            <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= Cake\Routing\Router::url(['action' => 'add']) ?>">
                                <?= __('Add new') ?>
                            </a>
                        </div>
                        <?php

                        $fields = [
                            'basicModel' => 'newsletters',
                            'id' => [],
                            'email' => [],
                            'subscribed' => ['format' => 'bool'],
                            'created' => [],
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

                            'delete' => $this->Html->link(
                                __('Delete'),
                                ['action' => 'delete', '%id%'],
                                [
                                    'confirm' => 'Are you sure you wish to delete this?',
                                    'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
                                ]
                            )
                        ];


                        echo $this->List->adminIndex($fields, $newsletters, $actions, true, $multi_select_actions, $parameters);
                        ?>

                    </div>
                </div>
            </div>
    </section>
</div>