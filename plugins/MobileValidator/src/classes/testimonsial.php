<?php
class testimonsial
{

	public  $tst_id;
	public  $added_date;
	public  $tst_name;
	public  $tst_comment;
	public  $tst_pic1;
	public  $tst_pic2;
	public  $approved;
	public  $tag1;
	public  $tag2;
	public  $tag3;

	var  $Errors;


	public function SetValues($_tst_id , $_added_date , $_tst_name , $_tst_comment , $_tst_pic1 , $_tst_pic2 , $_approved , $_tag1 , $_tag2 , $_tag3)
	{	$this->added_date=$_added_date;
	$this->tst_name=$_tst_name;
	$this->tst_comment=$_tst_comment;
	$this->tst_pic1=$_tst_pic1;
	$this->tst_pic2=$_tst_pic2;
	$this->approved=$_approved;
	$this->tag1=$_tag1;
	$this->tag2=$_tag2;
	$this->tag3=$_tag3;

	}


	public function SelectFromDB($_tst_id)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_tst_id))
		{
			$this->Errors[]=_lang(invalid_tst_id);
			return false;
		}
		$this->tst_id=$_tst_id;
		$sql = 'SELECT * FROM `testimonsial` WHERE `tst_id` = '.$_tst_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_testimonsial_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->added_date=$row['added_date'];
		$this->tst_name=$row['tst_name'];
		$this->tst_comment=$row['tst_comment'];
		$this->tst_pic1=$row['tst_pic1'];
		$this->tst_pic2=$row['tst_pic2'];
		$this->approved=$row['approved'];
		$this->tag1=$row['tag1'];
		$this->tag2=$row['tag2'];
		$this->tag3=$row['tag3'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `testimonsial` (`added_date`, `tst_name`, `tst_comment`, `tst_pic1`, `tst_pic2`, `approved`, `tag1`, `tag2`,  `tag3`) VALUES (\''.date('Y-m-d').'\',  \''.PreSql($this->tst_name).'\',  \''.PreSql($this->tst_comment).'\',  \''.PreSql($this->tst_pic1).'\',  \''.PreSql($this->tst_pic2).'\',  \''.PreSql($this->approved).'\',  \''.PreSql($this->tag1).'\',  \''.PreSql($this->tag2).'\',  \''.PreSql($this->tag3).'\')';
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return $db->sql_nextid();
	}


	public function Add($is_admin=false)
	{
		$op='Add';
		include '../forms/ftestimonsial.php';

	}

	public function Delete()
	{
		global $db;

		global $images_upload_dir;
		//Delete Images
		$sql='SELECT  `tst_pic1`,  `tst_pic2` FROM `testimonsial`  WHERE `tst_id`='.$this->tst_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		for($i=0;$i<2;$i++)
		if($row[$i] != '') unlink('../'.$images_upload_dir.'/'.$row[$i]);

		$sql = 'DELETE FROM `testimonsial` WHERE `tst_id`='.$this->tst_id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}
	
	
	

	public function Edit($_op='Update',$is_admin=false)
	{
		global $images_upload_dir;
		$tst_id=PreForm($this->tst_id);
		$added_date=PreForm($this->added_date);
		$tst_name=PreForm($this->tst_name);
		$tst_comment=PreForm($this->tst_comment);
		$tst_pic1=PreForm($this->tst_pic1);
		$tst_pic2=PreForm($this->tst_pic2);
		$approved=PreForm($this->approved);
		$tag1=PreForm($this->tag1);
		$tag2=PreForm($this->tag2);
		$tag3=PreForm($this->tag3);

		$op=$_op;

		include '../forms/ftestimonsial.php';

	}

	public function Update()
	{
		global $db;
		global $images_upload_dir;
		//Delete Unused Images
		$pics[0]= $this->tst_pic1;
		$pics[1]= $this->tst_pic2;
		$sql='SELECT  `tst_pic1`,  `tst_pic2` FROM `testimonsial`  WHERE `tst_id`='.$this->tst_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		for($i=0;$i<2;$i++)
		if($row[$i] != $pics[$i] && $pics[$i]!='' ) @unlink('../'.$images_upload_dir.'/'.$row[$i]);

		$sql = 'UPDATE `testimonsial` SET `tst_name` = \''.PreSql($this->tst_name).'\', `tst_comment` = \''.PreSql($this->tst_comment).'\', `tst_pic1` = \''.PreSql($this->tst_pic1).'\', `tst_pic2` = \''.PreSql($this->tst_pic2).'\', `approved` = \''.PreSql($this->approved).'\', `tag1` = \''.PreSql($this->tag1).'\', `tag2` = \''.PreSql($this->tag2).'\', `tag3` = \''.PreSql($this->tag3).'\' WHERE `tst_id` = '.$this->tst_id;

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
		$this->tst_id=PostForm($_POST['tst_id']);
		$this->added_date=PostForm($_POST['added_date']);
		$this->tst_name=PostForm($_POST['tst_name']);
		$this->tst_comment=PostForm($_POST['tst_comment']);
		$this->approved=PostForm($_POST['approved']);
		$this->tag1=PostForm($_POST['tag1']);
		$this->tag2=PostForm($_POST['tag2']);
		$this->tag3=PostForm($_POST['tag3']);

		if($_FILES['tst_pic1']['name']) {
			list($file,$error) = UploadImage('tst_pic1','../'.$images_upload_dir,'jpeg,gif,png,jpg,bmp',5000000,'',1,500,110);
			if($error) print "<div class=\"Error\"> Cannot Upload For Tst Picture1:".$error."</div><br>";
			else
			$this->tst_pic1=$file;
		}

		if($_FILES['tst_pic2']['name']) {
			list($file,$error) = UploadImage('tst_pic2','../'.$images_upload_dir,'jpeg,gif,png,jpg,bmp',5000000,'',2,$image_width,$image_height,$thumb_image_width,$thumb_image_height);
			if($error) print "<div class=\"Error\"> Cannot Upload For Tst Picture2:".$error."</div><br>";
			else
			$this->tst_pic2=$file;
		}

	}
	
	
	public static function PrintRandomOne()
	{
		global $db;
		$sql = 'SELECT * FROM `testimonsial` WHERE `approved`=\'1\' ORDER BY RAND() LIMIT 0,1 ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$row = $db->sql_fetchrow($result);
		TestimosialBlock($row['tst_name'],$row['tst_pic1'],$row['tst_comment']);
		
	}
	
	public function Show()
	{
		TestimosialBlock($this->tst_name,$this->tst_pic1,$this->tst_comment);
	}
	
	public static function AdminListtestimonsials()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * FROM `testimonsial` ORDER BY `tst_id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang(list_testimonsial).':</p>' ;
		$List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="40%">'._lang(tst_name).'</td>
		<td>Active</td>
		<td width="30%">'._lang(delete).'</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[tst_id].'</td><td width="40%">'.
			"<a href=\"?tst_id=$row[tst_id]&op=Edit\">$row[tst_name]</a></td>".
			"<td>".($row['approved']?"Yes":"No")."</td>".
			"<td width=\"30%\"><a href=\"javascript:if (confirm('"._lang(sure_delete_testimonsial)."')) {document.location ='?tst_id=$row[tst_id]&op=Delete';}\">Delete</a></td></tr> ";
		}
		$List.= '</table>';
		$List.="<div class=\"admin_list_control\">";
		if($admin_page>1)
		$List.= "&laquo; <a href=\"?admin_page=".($admin_page-1)."\" >"._lang(list_previous_page)." $per_page </a>&nbsp;&nbsp; ";

		if($page_no>2)
		{
			$List.='<select onchange="document.location=\'?admin_page=\'+this.value;">';
			for($i=1;$i<=$page_no;$i++)
			{
				$sel="";
				if($admin_page==$i) $sel="selected";
				$List.='<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
			}
			$List.='</select>';
		}

		if($no>$per_page )
		$List.= "&nbsp;<a href=\"?admin_page=".($admin_page+1)."\" > "._lang(list_next_page)." $per_page</a> &raquo;";

		$List.="</div><br/>";
		$List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
		<label for="job_id">&nbsp;&nbsp;<b>'._lang(enter_tst_id).':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="tst_id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang(sure_delete_testimonsial).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';
		return $List;


	}

}

?>