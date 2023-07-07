<?php
if(!empty($dir)){
    if($dir=="asc"){
        $dir = "desc";
    }else{
        $dir = "asc";
    }
}
?> 
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?=__('Uploads Per Day')?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>"><?=__('Home')?></a></li>
                        <li class="breadcrumb-item active"><?=__('Uploads Per Day')?></li>
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
                    <?= $this->AdminForm->create($user, ['type' => 'file','id'=>'filter_form']) ?>
                        
                        <div class="card-body row">
                            <div class="col-lg-3">
                            <div class="form-group text">
                                <label for="name"><?=__('From Date')?></label>
                                <input type="text" name="from_date" class="form-control hasDate" id="from_date" autocomplete="off" value="<?=!empty($from_date)?$from_date:''?>">
                            </div>          
                            </div>          
                            <div class="col-lg-3">
                            <div class="form-group password">
                                <label><?=__('To Date')?></label>
                                <input type="text" name="to_date" class="form-control hasDate" id="to_date" autocomplete="off"  value="<?=!empty($to_date)?$to_date:''?>">
                            </div>                        
                            </div> 

                            <div class="col-lg-3">
                            <div class="form-group password">
                                <label><?=__('Country')?></label>
                                <select name="country" class="form-control" id="country">
                                    <option value="">Choose a country</option>
                                    <?php foreach ($countries_list as $key => $value) { ?>
                                        <option value="<?=$value?>" <?=!empty($country) && $country==$value?'selected':''?> ><?=$value?></option>
                                    <?php } ?>
                                </select>
                            </div>                        
                            </div>

                            <div class="col-lg-3">
                            <div class="form-group password">
                                <label><?=__('Operating System Type')?></label>
                                <select name="os" class="form-control" id="os">
                                    <option><?=__("All")?></option>
                                    <?php foreach ($os_list as $key => $value) { ?>
                                        <option value="<?=$key?>" <?=!empty($os) && $os==$key?'selected':''?> ><?=$value?></option>
                                    <?php } ?>
                                </select>
                            </div>                        
                            </div>

                            <input type="hidden" name="export" value="" id="export_value">
                            <input type="hidden" name="sort" value="cdate" id="sort_value">
                            <input type="hidden" name="dir" value="asc" id="dir_value">
                        </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="filter_submit"><?=__('Filter')?></button>
                    </div>
                <?= $this->AdminForm->end() ?>

                </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title card-title-report"><?=__('Total uploads per day')?></h3>
                                <!-- <a href="javascript:void(0);">View Report</a> -->
                                <div class="card-tools">
                                    <a href="#" class="btn btn-tool btn-sm export_btn" ><i class="fas fa-download"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">&nbsp;</span>
                                    <span><?=__('Number of uploads')?></span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> <?=$total_uploads_number?>
                                    </span>
                                    <span class="text-muted"><?=__('Total Number of uploads')?></span>
                                </p>
                                <!-- <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> <?=$total_uploads_number?>
                                    </span>
                                    <span class="text-muted">Total Number of uploads</span>
                                </p> -->
                            </div>

                            <div class="position-relative mb-4">
                                <canvas id="users-per-country" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> <?=__('Uploads per day')?>
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
                            <h3 class="card-title card-title-report"><?=__('Uploads per day Report')?></h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-sm export_btn" ><i class="fas fa-download"></i></a>
                            </div>
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
                                        <a href="#" data-sort="uploads_count" data-dir="<?=$dir?>" class="datatable_sorting custom_sorting">
                                            <?=__('Number of uploads')?> <i class="fas fa-sort"></i>
                                        </a>
                                    </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($uploads_count_per_day as $key => $value) { ?>
                                        <tr>
                                            <td><?=$value->cdate?></td>
                                            <td><?=$value->uploads_count?></td>
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
















