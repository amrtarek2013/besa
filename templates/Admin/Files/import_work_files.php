<div class="content-wrapper">
    
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('Import Work files')?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Files</li>
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
                    <h3 class="card-title"><?= __("Import Work files") ?></h3>
                </div>

                 <?= $this->AdminForm->create(null, ['type' => 'file']) ?>
                    <div class="card-body">
                        <?php echo $this->AdminForm->control('import_latest_files', ['type' => 'hidden','value' => 1]); ?>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Import Latest Files</button>
                    </div>
                <?= $this->AdminForm->end() ?>
            </div>
            <!-- /.card -->

        </div>
        </div>
    </div>
</section>
</div>



