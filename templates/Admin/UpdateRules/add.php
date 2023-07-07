<div class="content-wrapper">
    
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('Update Rules')?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>"><?=__('Home')?></a></li>
                    <li class="breadcrumb-item active"><?=__('Update Rules')?></li>
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
                    <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' update rule') ?></h3>
                </div>

                 <?= $this->AdminForm->create($updateRule, ['type' => 'file']) ?>
                    <div class="card-body">
                        <?php echo $this->AdminForm->control('os', ['class' => 'form-control','label'=>__('os'),'type'=>'select','options'=>$os_list]); ?>
                        <?php echo $this->AdminForm->control('current_version', ['class' => 'form-control','label'=>__('Current Version')]); ?>
                        <?php echo $this->AdminForm->control('update_url', ['class' => 'form-control','label'=>__('Update URL')]); ?>
                        <?php echo $this->AdminForm->control('must_update', ['label'=>__(' Must update')]); ?>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><?=__('Submit')?></button>
                    </div>
                <?= $this->AdminForm->end() ?>
            </div>
            <!-- /.card -->

        </div>
        </div>
    </div>
</section>
</div>



