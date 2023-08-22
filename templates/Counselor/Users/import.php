<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= ucfirst($this->getRequest()->getParam('action') . ' Users') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        echo $this->AdminForm->create($user, ['type' => 'file']); ?>
                        <?php echo $this->AdminForm->control('file', ['type' => 'file']);


                        ?>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><?= __('Save') ?> </button>
                    </div>
                    <?= $this->AdminForm->end() ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
