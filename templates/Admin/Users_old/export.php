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
                    <h1 class="m-0"><?=__('Export Users')?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>"><?=__('Home')?></a></li>
                        <li class="breadcrumb-item active"><?=__('Export Users')?></li>
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
                            <div class="col-lg-4">
                            <div class="form-group text">
                                <label for="name"><?=__('From Date')?></label>
                                <input type="text" name="from_date" class="form-control hasDate" id="from_date" autocomplete="off" value="<?=!empty($from_date)?$from_date:''?>">
                            </div>          
                            </div>          
                            <div class="col-lg-4">
                            <div class="form-group password">
                                <label><?=__('To Date')?></label>
                                <input type="text" name="to_date" class="form-control hasDate" id="to_date" autocomplete="off"  value="<?=!empty($to_date)?$to_date:''?>">
                            </div>                        
                            </div> 

                            <div class="col-lg-4">
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

                            <div class="col-lg-4">
                            <div class="form-group password">
                                <label><?=__('Operating System Type')?></label><br>
                                
                                
                                <input type="checkbox" name="" value="" id="all_os"> <?=__("All")?><br>
                                <?php foreach ($os_list as $key => $value) { ?>
                                    <input type="checkbox" name="os[]" value="<?=$key?>" class="os_item" <?=!empty($os) && in_array($key,$os)?'checked':''?> > <?=$value?><br>
                                <?php } ?>
                                
                            </div>                        
                            </div>

                            <input type="hidden" name="export" value="" id="export_value">      
                        </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="filter_submit"><?=__('Export')?></button>
                    </div>
                <?= $this->AdminForm->end() ?>

                </div>
                </div>
            </div>

            
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
















