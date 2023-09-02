<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">
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
                    <h1><?= __('Countries List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('Countries') ?></li>
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
                        echo $this->List->filter_form($countries, $filters, [], [], $parameters, $session) ?>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('Countries List') ?></h3>
                            <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= Cake\Routing\Router::url(['action' => 'add']) ?>">
                                <?= __('Add new') ?>
                            </a>
                        </div>
                        <?php

                        $fields = [
                            'basicModel' => 'countries',
                            'id' => [],

                            'code' => [],
                            'country_name' => [],
                            'permalink' => [],
                            'use_country_currency' => ['format'=>'bool'],
                            'currency' => [],
                            'symbol' => ['title'=>'$'],

                            'is_destination' => ['format' => 'bool'],
                            // 'continent' => [],
                            // 'continent' => ['format' => 'get_from_array', 'options' => ['items_list' => $continents]],
                            'flag_path' => ['title' => 'Flag', 'format' => 'img'],
                            // 'image_path' => ['title' => 'Image', 'format' => 'link'],
                            // 'banner_image_path' => ['title' => 'Banner Image', 'format' => 'link'],
                            // 'dealerships'=>[],
                            'display_order' => [],
                            'active' => ['format' => 'bool'],
                        ];

                        $multi_select_actions = array(
                            'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );


                        $actions = [
                            'images' => $this->Html->link(__('Images'), ['controller' => 'CountryImages', 'action' => 'index', '%id%'], array('class' => 'btn btn-primary btn-sm', 'icon' => 'fas fa-images')),
                            'Partners' => $this->Html->link(__('Partners'), ['controller' => 'Universities', 'action' => 'index', '%id%'], array('class' => 'btn btn-secondary btn-sm', 'icon' => 'fas fa-users')),

                            'Benefits' => $this->Html->link(__('Benefits'), ['controller' => 'CountryBenefits', 'action' => 'index', '%id%'], array('class' => 'btn btn-success btn-sm', 'icon' => 'fas fa-binoculars')),
                            'Questions' => $this->Html->link(__('Questions'), ['controller' => 'CountryQuestions', 'action' => 'index', '%id%'], array('class' => 'btn btn-warning btn-sm', 'icon' => 'fas fa-question-circle')),
                            'Testimonials' => $this->Html->link(__('Testimonials'), ['controller' => 'testimonials', 'action' => 'index', '%id%'], array('class' => 'btn btn-secondary btn-sm', 'icon' => 'fas fa-users')),
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


                        echo $this->List->adminIndex($fields, $countries, $actions, true, $multi_select_actions, $parameters);
                        ?>

                    </div>
                </div>
            </div>
    </section>
</div>