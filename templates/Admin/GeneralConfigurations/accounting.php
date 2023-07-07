<div class="content-wrapper">
    
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('General Configurations')?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>"><?=__('Home')?></a></li>
                    <li class="breadcrumb-item active"><?=__('General Configurations')?></li>
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
                        
                        <div class="accounting_conf_group">
                            <?php  echo $this->AdminForm->control('classification_files', ['value'=>$classification_files,'class' => 'form-control','label'=>__("Number of Classified Files")]); ?>
                        </div>
                        <div class="accounting_conf_group">
                            <?php echo $this->AdminForm->control('classification_cost', ['value'=>$classification_cost,'class' => 'form-control','label'=>__("Cost")]); ?>
                        </div>
                        <div class="clear"></div>

                        <div class="accounting_conf_group">
                            <?php  echo $this->AdminForm->control('annotation_files', ['value'=>$annotation_files,'class' => 'form-control','label'=>__("Number of Annotated Files")]); ?>
                        </div>
                        <div class="accounting_conf_group">
                            <?php echo $this->AdminForm->control('annotation_cost', ['value'=>$annotation_cost,'class' => 'form-control','label'=>__("Cost")]); ?>
                        </div>
                        <div class="clear"></div>

                        <div class="accounting_conf_group">
                            <?php  echo $this->AdminForm->control('review_files', ['value'=>$review_files,'class' => 'form-control','label'=>__("Number of Reviewed Files")]); ?>
                        </div>
                        <div class="accounting_conf_group">
                            <?php echo $this->AdminForm->control('review_cost', ['value'=>$review_cost,'class' => 'form-control','label'=>__("Cost")]); ?>
                        </div>
                        <div class="clear"></div>

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



