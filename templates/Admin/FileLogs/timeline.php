<?php
if(!empty($dir)){
    if($dir=="asc"){
        $dir = "desc";
    }else{
        $dir = "asc";
    }
}
?>
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?=__('Timeline reporting')?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>"><?=__('Home')?></a></li>
                        <li class="breadcrumb-item active"><?=__('Timeline reporting')?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <?php
                        $session = $this->getRequest()->getSession();
                        echo $this->List->filter_form(null, $filters, [], ["filter_title"=>"Filter"], $parameters, $session);
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title card-title-report"><?=__('Timeline reporting')?></h3>
                                <!-- <a href="javascript:void(0);">View Report</a> -->
                                <div class="card-tools">
                                    <!-- <a href="#" class="btn btn-tool btn-sm export_btn" ><i class="fas fa-download"></i></a> -->
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">&nbsp;</span>
                                    <span><?=__('Number of files')?></span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> <?=$total_files_number?>
                                    </span>
                                    <span class="text-muted"><?=__('Total Number of files')?></span>
                                </p>
                                <!-- <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> <?=$total_users_number?>
                                    </span>
                                    <span class="text-muted">Total Number of users</span>
                                </p> -->
                            </div>

                            <div class="position-relative mb-4">
                                <canvas id="users-per-country" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> <?=__('Classification')?>
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-red"></i> <?=__('Annotation')?>
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-green"></i> <?=__('Review')?>
                                </span>
                                <!-- <span>
                                    <i class="fas fa-square text-gray"></i> Last Week
                                </span> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">        
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title"><?=__('Files per day Report')?></h3>
                            <div class="card-tools card-title-report">
                                <a href="#" class="btn btn-tool btn-sm export_btn" ><i class="fas fa-download"></i></a>
                            </div>
                            <!-- <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-sm"><i class="fas fa-download"></i></a>
                                <a href="#" class="btn btn-tool btn-sm"><i class="fas fa-bars"></i></a>
                            </div> -->
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                    <th>
                                        <a href="#" data-sort="cdate" data-dir="<?=$dir?>" class="datatable_sorting custom_sorting">
                                            <?=__('Day')?> <i class="fas fa-sort"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" data-sort="files_count" data-dir="<?=$dir?>" class="datatable_sorting custom_sorting">
                                            <?=__('Number of files')?> <i class="fas fa-sort"></i>
                                        </a>
                                    </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($files_count_per_day as $key => $value) { ?>
                                        <tr>
                                            <td><?=$value->cdate?></td>
                                            <td><?=$value->files_count?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                 </div>
                <!-- /.col-md-6 -->


          
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<link href="https://rdidt.com/annotation/webroot/css/select2.css" rel="stylesheet" />
<script src="https://rdidt.com/annotation/webroot/js/select2.js" defer></script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#filterform').show('fast');void(0);
        $('#admin-id').select2({
            // multiple: false,
            width: 'style',
            closeOnSelect:false
        });
        $('#admin-id').val(<?=$admin_ids?>);
        // $('#admin-id').multiSelect()
        $('#admin-id').trigger('change'); 
    });
</script>


        
<style type="text/css">
    .select2.select2-container{
        display: block;
    }
    .select2-selection{
        /*height: calc(2.25rem + 2px);*/
    }
    .select2-container--default .select2-selection--multiple{
        border: 1px solid #ced4da !important;
    }
</style>













