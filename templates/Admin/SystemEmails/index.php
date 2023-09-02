<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('System Emails List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('System Emails') ?></li>
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
                        echo $this->List->filter_form($systemEmails, $filters, [], [], $parameters, $session) ?>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('System Emails List') ?></h3>
                            <!-- <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= ADMIN_LINK ?>/SystemEmails/add">
                                <?= __('Add new') ?>
                            </a> -->
                        </div>
                        <?php

                        $fields = [
                            'basicModel' => 'system_emails',
                            'id' => [],
                            'title' => [],
                            'name' => [],
                            'active' => ['format' => 'bool'],

                        ];

                        $multi_select_actions = array();

                        $actions = [
                            'edit' => $this->Html->link('Edit', array('action' => 'edit', '%name%'), array('class' => 'btn btn-info btn-flat', 'icon' => 'fas fa-pencil-alt')),
                        ];


                        echo $this->List->adminIndex($fields, $systemEmails, $actions, true, $multi_select_actions, $parameters);
                        ?>
                    </div>
                </div>
            </div>
    </section>
</div>