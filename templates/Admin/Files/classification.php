<div class="content-wrapper">

<section class="content-header">
  	<div class="container-fluid">
    	<div class="row mb-2">
      		<div class="col-sm-6">
        		<h1><?=__('Files Classification')?></h1>
      		</div>
      		<div class="col-sm-6">
        		<ol class="breadcrumb float-sm-right">
          			<li class="breadcrumb-item"><a href="/"><?=__('Home')?></a></li>
          			<li class="breadcrumb-item active"><?=__('Classification')?></li>
        		</ol>
      		</div>
    	</div>

		<div class="row mt-5">
			<div class="col-md-6 center-block">
				<button type="button" class="btn btn-primary load-files-btn" id="load-files"><i class="fa fa-download"></i> <?=__('Load Files')?></button>
			</div>
            <div class="col-md-6 center-block">
                <button type="button" class="btn btn-dark files_submition_btn submit_classified_files"><i class="fa fa-check-circle"></i> <?=__('Submit Classified Files')?></button>
            </div>
		</div>


  	</div>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  	<div class="card card-solid">
    	<div class="card-body pb-0">
    		
            <!-- Progress bar -->
            <div class="row">
                <div class="col-md-12" id="files_progress">
                    <div class="skill">
                        <p><?=__('Progress')?></p>
                        <div class="skill-bar skill3 prog_percentage1" style="width: <?=isset($done_percentage)?$done_percentage:'0'?>%">
                            <span class="skill-count3 prog_percentage2"><?=isset($done_percentage)?$done_percentage:'0'?>%</span>
                        </div>
                    </div>
                    <p>You finished (<span class="prog_percentage3"><?=$total_done_count?></span>) files from (<?=$total_loaded_files?>) loaded files.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <div class="playlist_menu">
                        <?=!empty($playlist_menu_html)?$playlist_menu_html:''?>
                    </div>    
                </div>

                <div class="col-sm-9">
            		<div id="classification-files">
            			<?php 
            			if(!empty($files_to_classify)){
        					echo $this->element('../Files/classification_boxes', array($files_to_classify));
        		      	}else{
        			      	echo '<p>'.__('There is no pending files, please click the above button to load new files.').'</p>';
        			    }
        			    ?>
            		</div>
                </div>
            </div>
    			

    	</div>
    	<div class="card-footer">
      		<!-- <a href="#" class="btn btn-lg btn-dark float-sm-right submit_classified_files" >Submit</a> -->
    	</div>
    	<!-- /.card-footer -->
  	</div>
  	<!-- /.card -->

</section>
</div>
<script type="text/javascript">
    // window.onbeforeunload = function() {
        // return "Are you sure you want to leave?";
    // }
</script>

<script type="text/javascript">
    if ('serviceWorker' in navigator) {
        console.log('CLIENT: service worker registration in progress.');
        navigator.serviceWorker.register(WEBSITE_PATH.'/sw.js?v=21').then(function() {
            console.log('CLIENT: service worker registration complete.');
        }, function() {
            console.log('CLIENT: service worker registration failure.');
        });
    } else {
    console.log('CLIENT: service worker is not supported.');
    }
</script>

