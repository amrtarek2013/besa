<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('General Configurations') ?></h1>
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' configuration') ?></h3>
                        </div>

                        <?= $this->AdminForm->create($generalConfiguration, ['type' => 'file']) ?>
                        <div class="card-body">
                            <?php
                            echo $this->AdminForm->control('config_group', ['class' => 'form-control', 'label' => __("Configuration Group")]);
                            echo $this->AdminForm->control('field', ['class' => 'form-control', 'label' => __("Field Name")]);
                            echo $this->AdminForm->control('label', ['class' => 'form-control', 'label' => __("Label")]);
                            echo $this->AdminForm->control('value', ['class' => 'form-control', 'label' => __("Value")]);
                            ?>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Submit') ?></button>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>