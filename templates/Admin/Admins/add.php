<div class="content-wrapper">
    
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('Users')?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
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
                    <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' User') ?></h3>
                </div>

                 <?= $this->AdminForm->create($admin, ['type' => 'file']) ?>
                    <div class="card-body">
                        <?php echo $this->AdminForm->control('name', ['class' => 'form-control','label'=>__('Username')]); ?>
                        <?php echo $this->AdminForm->control('password', ['class' => 'form-control','label'=>__('Password')]); ?>
                        <?php echo $this->AdminForm->control('repeat_password', ['class' => 'form-control','type'=>'password','label'=>__('Repeat Password')]); ?>
                        <?php echo $this->AdminForm->control('role_id', ['class' => 'form-control','type'=>'select','label'=>__('Role')]); ?>
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



