<?php
class category_doc
{

	public  $cat_id;
	public  $cat_name;
	public  $pcat_id;
	public  $dislplay_order;
	public  $cat_pic;
	public  $cat_dsc;
	public  $tag1;

	var  $Errors;


	public function SetValues($_cat_id , $_cat_name , $_pcat_id , $_dislplay_order , $_cat_pic , $_cat_dsc , $_tag1)
	{	$this->cat_name=$_cat_name;
	$this->pcat_id=$_pcat_id;
	$this->dislplay_order=$_dislplay_order;
	$this->cat_pic=$_cat_pic;
	$this->cat_dsc=$_cat_dsc;
	$this->tag1=$_tag1;

	}


	public function SelectFromDB($_cat_id)
	{
		global $db;
		$this->cat_id=$_cat_id;
		$sql = 'SELECT * FROM `category_doc` WHERE `cat_id` = '.$_cat_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_cat_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->cat_name=$row['cat_name'];
		$this->pcat_id=$row['pcat_id'];
		$this->dislplay_order=$row['dislplay_order'];
		$this->cat_pic=$row['cat_pic'];
		$this->cat_dsc=$row['cat_dsc'];
		$this->tag1=$row['tag1'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `category_doc` (`cat_name`, `pcat_id`, `dislplay_order`, `cat_pic`, `cat_dsc`,  `tag1`) VALUES (\''.PreSql($this->cat_name).'\',  \''.PreSql($this->pcat_id).'\',  \''.PreSql($this->dislplay_order).'\',  \''.PreSql($this->cat_pic).'\',  \''.PreSql($this->cat_dsc).'\',  \''.PreSql($this->tag1).'\')';
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return $db->sql_nextid();
	}


	public function Add()
	{
		$op='Add';
		$parent_category_list=category_doc::ListParentCategorieselectOptions($pcat_id);
		include '../forms/fcategory_doc.php';

	}

	public function Delete()
	{
		global $db;

		global $images_upload_dir;
		//Delete Images
		$sql='SELECT  * FROM `category_doc`  WHERE `pcat_id`='.$this->cat_id;
		if(!$result = $db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)>0)
		{
			$this->Errors[]=_lang(cat_remove_docs_first);
			return false;

		}

		$sql='SELECT  count(*) FROM `doc`  WHERE `doc_cat_id`='.$this->cat_id;
		if(!$result = $db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		$row = $db->sql_fetchrow($result);
		if($row[0]>0)
		{
			$this->Errors[]=_lang(cat_remove_sub_cat_first);
			return false;

		}



		$sql='SELECT  `cat_pic` FROM `category_doc`  WHERE `cat_id`='.$this->cat_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if($row[0] != '') unlink('../'.$images_upload_dir.'/'.$row[0]);
		$sql = 'DELETE FROM `category_doc` WHERE `cat_id`='.$this->cat_id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update')
	{
		global $images_upload_dir;
		$cat_id=PreForm($this->cat_id);
		$cat_name=PreForm($this->cat_name);
		$pcat_id=PreForm($this->pcat_id);
		$dislplay_order=PreForm($this->dislplay_order);
		$cat_pic=PreForm($this->cat_pic);
		$cat_dsc=PreForm($this->cat_dsc);
		$tag1=PreForm($this->tag1);
		$parent_category_list=category_doc::ListParentCategorieselectOptions($pcat_id);
		$op=$_op;

		include '../forms/fcategory_doc.php';

	}

	public function Update()
	{
		global $db;
		global $images_upload_dir;
		//Delete Unused Images
		$sql='SELECT  `cat_pic` FROM `category_doc`  WHERE `cat_id`='.$this->cat_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if($row[0] != $this->cat_pic && $this->cat_pic!='' ) @unlink('../'.$images_upload_dir.'/'.$row[0]);

		$sql = 'UPDATE `category_doc` SET `cat_name` = \''.PreSql($this->cat_name).'\', `pcat_id` = \''.PreSql($this->pcat_id).'\', `dislplay_order` = \''.PreSql($this->dislplay_order).'\', `cat_pic` = \''.PreSql($this->cat_pic).'\', `cat_dsc` = \''.PreSql($this->cat_dsc).'\', `tag1` = \''.PreSql($this->tag1).'\' WHERE `cat_id` = '.$this->cat_id;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function FromForm()
	{
		global $images_upload_dir,$image_width,$image_height,$thumb_image_width,$thumb_image_height;
		$this->cat_id=PostForm($_POST['cat_id']);
		$this->cat_name=PostForm($_POST['cat_name']);
		$this->pcat_id=PostForm($_POST['pcat_id']);
		$this->dislplay_order=PostForm($_POST['dislplay_order']);
		$this->cat_dsc=PostForm($_POST['cat_dsc']);
		$this->tag1=PostForm($_POST['tag1']);

		if($_FILES['cat_pic']['name']) {
			list($file,$error) = UploadImage('cat_pic','../'.$images_upload_dir,'jpeg,gif,png,jpg,bmp',5000000,'',2,$image_width,$image_height,$thumb_image_width,$thumb_image_height);
			if($error) print "<div class=\"Error\"> Cannot Upload For Category Picture:".$error."</div><br>";
			else
			$this->cat_pic=$file;
		}
	}

	public static function ListParentCategorieselectOptions($selected="")
	{
		global $db;
		$sql = 'SELECT * FROM `category_doc` WHERE `pcat_id`=\'\' ';
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			if($row['cat_id']==$selected) $sel="selected"; else $sel="";
			$List.= "<option value=\"$row[cat_id]\" $sel>$row[cat_name]</option>\n";
		}
		return $List;
	}

	public static function AdminListCategories()
	{
		global $db;
		//$sql = 'SELECT concat(concat(`c2`.`cat_name`,">"),`c1`.`cat_name`) as `cat_name` , `c1`.`cat_id`  FROM `category_doc` as `c1`,`category_doc` as `c2` WHERE `c1`.`pcat_id`= `c2`.`cat_id` UNION SELECT `cat_name` , `cat_id` FROM `category_doc` WHERE `pcat_id`="" ORDER BY `cat_name`';
		$sql = 'SELECT `cat_name` , `cat_id`  FROM `category_doc` ORDER BY `cat_name`';
		$result = $db->sql_query($sql);

		$List= "<p class=\"admin_title\">"._lang(list_cats).":</p>" ;
		$List.= "<table class=\"adminlist\" width=400><tr class=\"header\"><td width=40%>"._lang(cat_name)."</td>
		<td width=30%>"._lang(no_doc)."</td><td width=30%>"._lang(delete)."</td></tr> ";
		while($row = $db->sql_fetchrow($result))
		{
			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;
			
			$List.= "<tr class=\"$class\"><td width=40%><a href=\"?cat_id=$row[cat_id]&op=Edit\">$row[cat_name]</a></td>".
			"<td width=30%><!--<a href=\"doc.php?for=Category&id=$row[cat_id]\">-->". category_doc::GetdocsCountFor( $row[cat_id])."<!--</a>--></td>".
			"<td width=30%><a href=\"javascript:if (confirm('"._lang(sure_delete_cat)."')) {document.location ='?cat_id=$row[cat_id]&op=Delete';}\">"._lang(delete)."</a></td></tr> ";
		}
		$List.= "</table>";

		return $List;
	}

	public static function ListCategorySelectOptions($selected="")
	{
		global $db;
		//$sql = 'SELECT concat(concat(`c2`.`cat_name`,">>"),`c1`.`cat_name`) as `cat_name` , `c1`.`cat_id`  FROM `category_doc` as `c1`,`category_doc` as `c2` WHERE `c1`.`pcat_id`= `c2`.`cat_id`  ORDER BY `cat_name`';
		$sql = 'SELECT `cat_name` , `cat_id`  FROM `category_doc` ORDER BY `cat_name`';
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			if($row['cat_id']==$selected) $sel="selected"; else $sel="";
			$List.= "<option value=\"$row[cat_id]\" $sel>$row[cat_name]</option>\n";
		}
		return $List;
	}
	
	public static function ListdocsCategories()
	{
		global $db;
		
		$sql = 'SELECT `cat_name` , `cat_id`,`cat_dsc`  FROM `category_doc` WHERE `cat_id`>0 ORDER BY `cat_name`';
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			
			$cat_id[]=$row['cat_id'];
			$cat_name[]=$row['cat_name'];
			$cat_desc[]=$row['cat_dsc'];
		}
		ListCategories($cat_name,$cat_id,$cat_desc);
		return $List;
		
		
	}
	
	public static function GetCategoryName($cat_id)
	{
		global $db;
		$sql = 'SELECT `cat_name` FROM `category_doc` WHERE `cat_id`='.$cat_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		return $row[0];
	}

	public static function GetParentId($cat_id)
	{
		global $db;
		$sql = 'SELECT `pcat_id` FROM `category_doc` WHERE `cat_id`='.$cat_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		return $row[0];
	}		
	
	//Go Deep e levels	
	public function GetdocsCount()
	{
		global $db;
		$sql = 'SELECT COUNT(DISTINCT `doc_id`) FROM `doc`, `category_doc` as `cat1`,`category_doc` as `cat2` WHERE (`doc_cat_id`='.$this->cat_id.' AND `cat1`.`cat_id`='.$this->cat_id.' AND `cat2`.`cat_id`='.$this->cat_id.' ) OR (`doc_cat_id`=`cat1`.`cat_id` AND `cat1`.`pcat_id`='.$this->cat_id.' AND `cat2`.`cat_id`='.$this->cat_id.') OR (`doc_cat_id`=`cat2`.`cat_id` AND `cat2`.`pcat_id`=`cat1`.`cat_id` AND `cat1`.`pcat_id`='.$this->cat_id.' )';
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		return $row[0];
	}
	
	public static function  GetdocsCountFor($id)
	{
		global $db;
		$sql = 'SELECT COUNT(DISTINCT `doc_id`) FROM `doc`, `category_doc` as `cat1`,`category_doc` as `cat2` WHERE (`doc_cat_id`='.$id.' AND `cat1`.`cat_id`='.$id.' AND `cat2`.`cat_id`='.$id.' ) OR (`doc_cat_id`=`cat1`.`cat_id` AND `cat1`.`pcat_id`='.$id.' AND `cat2`.`cat_id`='.$id.') OR (`doc_cat_id`=`cat2`.`cat_id` AND `cat2`.`pcat_id`=`cat1`.`cat_id` AND `cat1`.`pcat_id`='.$id.' )';
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		return $row[0];
	}	
	
	
	public function ShowMoreInfo($admin=false)
	{
		AdminCategoryMoreInfo($this->cat_id,$this->cat_name,$this->pcat_id,$this->GetdocsCount(),$admin);
	}	
	
	
	
	
	

}

?>