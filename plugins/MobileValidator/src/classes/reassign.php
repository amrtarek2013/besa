<?
class reassign
{
	public $old_stock_no;
	public $new_stock_no;
	
	public $Errors;
	
	function ReassignForm()
	{
		$old_stock_no=PreForm($this->old_stock_no);
		$new_stock_no=PreForm($this->new_stock_no);		
		include('../forms/freassign.php');
		
	}
	
	public function FromForm()
	{
		$this->old_stock_no=PostForm($_POST['old_stock_no']);
		$this->new_stock_no=PostForm($_POST['new_stock_no']);
	}
	
	public function ConfirmReassigning()
	{
		global $db;
		
		//make sure that the stock no is on the db
		$sql="SELECT * FROM `afs_stock2` WHERE `stock_no`= '".$this->new_stock_no."'";

		if(!$result = $db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}


		if(!$row=$db->sql_fetchrow($result))
		{

			$this->Errors[]=_lang('reassign_no_stock_found');
			return false;
		}
		
		//get the image for the old stock 
		if(!file_exists('../image_uploads/' . $this->old_stock_no . '/image_1.jpg'))
		{
			$this->Errors[]=_lang('reassign_no_image_found');
			return false;
		}

		$car_desc=$row['year']." ".$row['make']." ".$row['model']." ".$row['colour'];
		
		include('../forms/freassign_confirm.php');
		return true;
		
	}
	
	public function ReassignNow()
	{
		$dir="../image_uploads/".$this->new_stock_no;
		if(!is_dir($dir))
		if(!mkdir($dir,0777,true))
		{

			$this->Errors[]=_lang("cant_make_dir");
			return  false;
		}
		
		for($i=1;$i<17;$i++)
		{

			if(file_exists('../image_uploads/' . $this->old_stock_no . "/image_{$i}_thumb.jpg"))
			{
				if(!rename('../image_uploads/' . $this->old_stock_no . "/image_{$i}_thumb.jpg",'../image_uploads/' . $this->new_stock_no . "/image_{$i}_thumb.jpg"))
				{
					$this->Errors[]=_lang(cant_move_image)." ".'image_uploads/' . $this->old_stock_no . "/image_{$i}_thumb.jpg";
				}
			}
			
			if(file_exists('../image_uploads/' . $this->old_stock_no . "/image_{$i}.jpg"))
			{
				if(!rename('../image_uploads/' . $this->old_stock_no . "/image_{$i}.jpg",'../image_uploads/' . $this->new_stock_no . "/image_{$i}.jpg"))
				{
					$this->Errors[]=_lang(cant_move_image)." ".'image_uploads/' . $this->old_stock_no . "/image_{$i}_thumb.jpg";
				}
			}			
		}
		
		@rmdir('../image_uploads/'.$this->old_stock_no);
		
		return (sizeof($this->Errors)==0);
		
		

	}
	
}

?>