<style>
    .form-group{
        margin-bottom: 20px;
    }
</style>
<section class="main-banner register-banner">

    <div class="container" style="width:100%">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title text-left title-dash">Import Students</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="container-formBox">

                    <h4 class="title"></h4>

                    <?= $this->AdminForm->create($user, ['type' => 'file']); ?>
                    <!-- <div class="grid-container"> -->

                    <div class="form-group">
                        <a class=" <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= Cake\Routing\Router::url(['action' => 'export', 1]) ?>">
                            <i class="nav-icon fas fa-file-csv"></i> <?= __('Export Smaple') ?>
                        </a>
                    </div>
                    <?= $this->AdminForm->control('file', ['type' => 'file']);  ?>
                    <!-- </div> -->

                    <div class="form-group">
                        <button type="submit" class="btn clear-blue">Import</button>
                    </div>
                    <!-- </div> -->


                    <?= $this->Form->end() ?>
                </div>

            </div>
        </div>
    </div>
</section>