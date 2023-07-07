<?=$this->element('home_header_slider');?>
<?php 
if(!empty($_GET['testA'])){
	echo $this->element('categories_slider');
}else{
	echo $this->element('all_items_categories_slider');
}
?>
	
<?php //$this->element('sessions_slider');?>