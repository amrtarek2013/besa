<div class="row">

    <?php
    $starter = 1;
    foreach ($files_to_review as $key => $value) { 
    		if(file_exists(UPLOAD_PATH.'/files/'.$value->file)){
    	?>        
		<div class="col-12 col-sm-6 col-md-12 d-flex align-items-stretch flex-column audio-box file_box_<?=$value->id?> <?=$starter==1?'show-box':'hide-box'?>" data-review-type="<?=$value->status==9?1:''?>" data-file-id="<?=$value->id?>">
		  	<div class="card bg-light d-flex flex-fill">
		    	<div class="card-header border-bottom-0 lead">
		      		<b><?=$value->file?></b>
		    	</div>
		    	<div class="card-body pt-0">
		      		<div class="row">
		        		<div class="col-12">
		          
		          			<audio class="audio-elm" controls>
							  	<source src="<?=UPLOAD_LINK.'/files/'.$value->file?>" type="audio/mpeg">
								Your browser does not support the audio element.
							</audio>
							<textarea class="form-control mg-btm-10 annotation_note" rows="3" placeholder="<?=__('Annotation')?>" ><?=!empty($value->annotation_note)?$value->annotation_note:''?></textarea>
							<textarea class="form-control review_note" rows="3" placeholder="<?=__('Your Review....')?>" ><?=!empty($value->review_note)?$value->review_note:''?></textarea>
		    			</div>

		      		</div>
		    	</div>
		    	<div class="card-footer">
		      		<div class="review-actions">
		    			<!-- <a href="#" class="btn btn-sm btn-danger col-md-4 " data-review-type="2" data-file-id="<?=$value->id?>">
		          			<i class="fas fa-ban"></i> <?=__("Reject")?>
		    			</a> -->
		        		<a href="#" class="btn btn-sm btn-success col-md-4 float-right" style="display: initial;" data-review-type="1" data-file-id="<?=$value->id?>">
		          			<i class="fas fa-check"></i> <?=__("Save")?>
		    			</a>

		      		</div>
		    	</div>
		  	</div>
		</div>
	<?php
	$starter = 0; 
		}
	} ?>

</div>

<div class="row">
	<div class="col-md-6">
		<a href="#" class="load_prev_file"><i class="fas fa-arrow-left"></i> <?=__('Previous File')?></a>
	</div>
	<div class="col-md-6">
		<a href="#" class="float-sm-right load_next_file"><?=__('Next File')?> <i class="fas fa-arrow-right"></i></a>
	</div>
</div>