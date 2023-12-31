<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" ></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Seo List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('Seo') ?></li>
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
                        echo $this->List->filter_form($seo, $filters, [], [], $parameters, $session) ?>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('Seo List') ?></h3>
                            <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= ADMIN_LINK ?>/seo/add">
                                <?= __('Add new') ?>
                            </a>
                        </div>

                        <?php

                        $fields = [
                            'basicModel' => 'seo',
                            'criteria' => [],
                            'title' => [],
                            // 'keywords'=>[],
                            // 'description'=>[]
                        ];

                        $multi_select_actions = array(
                            'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );



                        $actions = [
                            // 'view'=>$this->Html->link(__('View'), ['action' => 'view', '%id%'],array('class' => 'btn btn-primary btn-flat','icon'=>'fas fa-binoculars')),
                            // 'edit' => $this->Html->link('Edit', array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-flat', 'icon' => 'fas fa-pencil-alt')),
                            // 'delete' => $this->Html->link(
                            //     'Delete',
                            //     ['action' => 'delete', '%id%'],
                            //     [
                            //         'confirm' => 'Are you sure you wish to delete this?',
                            //         'class' => 'btn btn-danger btn-flat', 'icon' => 'fas fa-trash'
                            //     ]
                            // ),
                        ];

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


                        echo $this->List->adminIndex($fields, $seo, $actions, false, $multi_select_actions, $parameters);
                        ?>
                        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>