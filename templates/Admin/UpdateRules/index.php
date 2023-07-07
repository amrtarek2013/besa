<?php
$list_fields = ["id"=>__('ID'),"os"=>__('OS'),"current_version"=>__('Current Version'),"update_url"=>__('Update URL'),"must_update"=>__('Must Update')];
?>
<div class="content-wrapper">

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('Update Rules List')?></h1>
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

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                    

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?=__('Update Rules List')?></h3>
                        <a class="btn btn-primary <?=$currLang=='en'?'float-right':'float-left'?>" href="<?=ADMIN_LINK?>/update-rules/add">
                            <?=__('Add new')?>
                        </a>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php
                                    foreach ($list_fields as $field_name => $field_label) { 
                                        echo '<th>'.$field_label.'</th>';
                                    } 
                                    ?>
                                    <th><?=__('Actions')?></th>
                                </tr>
                            </thead>
                                    
                            <tbody>
                                <?php foreach ($datalist as $dk => $dv) { ?>
                                    <tr>
                                        <td><?=$dv->id?></td>
                                        <td><?=$os_list[$dv->os]?></td>
                                        <td><?=$dv->current_version?></td>
                                        <td><?=$dv->update_url?></td>
                                        <td><?=$dv->must_update==1?'Yes':'No'?></td>
                                        <td>
                                           <a class="btn btn-info btn-sm" href="<?=ADMIN_LINK?>/update-rules/edit/<?=$dv->id?>">
                                                <i class="fas fa-pencil-alt"></i><?=__('Edit')?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                 
                            <tfoot>
                                <tr>
                                    <?php
                                    foreach ($list_fields as $field_name => $field_label) { 
                                        echo '<th>'.$field_label.'</th>';
                                    } 
                                    ?>
                                    <th><?=__('Actions')?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>

