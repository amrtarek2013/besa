<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" ></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('General Configurations List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('General Configurations') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <?php
                        $session = $this->getRequest()->getSession();
                        echo $this->List->filter_form($generalConfigurations, $filters, [], [], $parameters, $session);
                        ?>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('General Configurations List') ?></h3>
                            <!-- <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= ADMIN_LINK ?>/general-configurations/add">
                            <?= __('Add new') ?>
                        </a> -->
                        </div>

                        <!-- <script type="text/javascript">
                        var _csrfToken = '<?= $this->request->getAttribute('csrfToken') ?>';
                    </script>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="enable_random_selection" <?= !empty($enableRandomSelection) && $enableRandomSelection == 1 ? 'checked' : '' ?> >
                            <label class="custom-control-label" for="enable_random_selection">Enable random selection</label>
                        </div>
                    </div> -->

                        <?php
                        $fields = [
                            'basicModel' => 'GeneralConfigurations',
                            'id' => [],
                            'label' => ['title' => __('Label')],
                            'value' => ['title' => __('Value')],
                        ];

                        $multi_select_actions = array();

                        $actions = [
                            'edit' => $this->Html->link('Edit', array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),
                        ];
                        echo $this->List->adminIndex($fields, $generalConfigurations, $actions, false, $multi_select_actions, $parameters);
                        ?>
                    </div>


                </div>
            </div>
        </div>
    </section>

</div>