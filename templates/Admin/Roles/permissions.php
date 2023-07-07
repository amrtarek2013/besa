<div class="content-wrapper">
    
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('Permission Permissions')?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>/permissions">Permissions</a></li>
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
                    <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) ) ?></h3>
                </div>

                 <?= $this->AdminForm->create(null, ['type' => 'file']) ?>
                    <div class="card-body">
                        
                        <?php
                        $current_group = "";
                        foreach ($all_cer_permissions as $key => $value) {
                            if(empty($current_group) || $value->permission_group != $current_group){
                                $current_group = $value->permission_group;
                                ?>
                                <div class="form-group">
                                    <input type="checkbox" name="<?=$current_group?>" value="<?=$current_group?>" class="main_group">
                                    <label for="title"><?=__($current_group)?></label>
                                </div>
                                <?php
                            }
                        ?>
                            <div class="form-group mg-<?=$currLang=='en'?'left':'right'?>-40">
                                <input type="checkbox" name="permissions[<?=$value->id?>]" class="" data-permission-group="<?=$current_group?>" value="<?=$value->id?>" <?=in_array($value->id,$saved_perm)?'checked':''?> >
                                <label for="title"><?=$currLang=='en'?$value->title:$value->title_ar?></label>
                            </div>
                        <?php } ?>
                        
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



