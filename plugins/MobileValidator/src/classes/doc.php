<?php
class doc
{

	public  $doc_id;
	public  $title;
	public  $desc;
	public  $added_date;
	public  $doc_cat_id;
	public  $file1;
	public  $file2;
	public  $file3;
	public  $thumb_pic;
	public  $featured;
	public  $counter;
	public  $active;
	public  $keywords;
	public  $tag3;

	var  $Errors;


	public function SetValues($_doc_id , $_title , $_desc , $_added_date , $_doc_cat_id , $_file1 , $_file2 , $_file3 , $_thumb_pic , $_featured , $_counter , $_active , $_keywords , $_tag3)
	{
		$this->title=$_title;
		$this->desc=$_desc;
		$this->added_date=$_added_date;
		$this->doc_cat_id=$_doc_cat_id;
		$this->file1=$_file1;
		$this->file2=$_file2;
		$this->file3=$_file3;
		$this->thumb_pic=$_thumb_pic;
		$this->featured=$_featured;
		$this->counter=$_counter;
		$this->active=$_active;
		$this->keywords=$_keywords;
		$this->tag3=$_tag3;

	}


	public function SelectFromDB($_doc_id)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_doc_id))
		{
			$this->Errors[]=_lang(invalid_doc_id);
			return false;
		}
		$this->doc_id=$_doc_id;
		$sql = 'SELECT * FROM `doc` WHERE `doc_id` = '.$_doc_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_doc_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->title=$row['title'];
		$this->desc=$row['desc'];
		$this->added_date=$row['added_date'];
		$this->doc_cat_id=$row['doc_cat_id'];
		$this->file1=$row['file1'];
		$this->file2=$row['file2'];
		$this->file3=$row['file3'];
		$this->thumb_pic=$row['thumb_pic'];
		$this->featured=$row['featured'];
		$this->counter=$row['counter'];
		$this->active=$row['active'];
		$this->keywords=$row['keywords'];
		$this->tag3=$row['tag3'];
		return true;


	}

	public function Insert()
	{
		global $db;
		if(sizeof($this->Errors)) return  false;
		$sql = 'INSERT INTO `doc` (`title`, `desc`, `added_date`, `doc_cat_id`, `file1`, `file2`, `file3`, `thumb_pic`, `featured`, `counter`, `active`, `keywords`,  `tag3`) VALUES (\''.PreSql($this->title).'\',  \''.PreSql($this->desc).'\',  \''.date('Y-m-d').'\',  \''.PreSql($this->doc_cat_id).'\',  \''.PreSql($this->file1).'\',  \''.PreSql($this->file2).'\',  \''.PreSql($this->file3).'\',  \''.PreSql($this->thumb_pic).'\',  \''.PreSql($this->featured).'\',  \''.PreSql($this->counter).'\',  \''.PreSql($this->active).'\',  \''.PreSql($this->keywords).'\',  \''.PreSql($this->tag3).'\')';
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
		$active="1";
		include '../forms/fdoc.php';

	}

	public function Delete()
	{
		global $db;

		global $file_upload_dir,$images_upload_dir;
		//Delete Images
		$sql='SELECT  `file1`,  `file2`,  `file3`,  `thumb_pic` FROM `doc`  WHERE `doc_id`='.$this->doc_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		for($i=0;$i<4;$i++)
		{
			if($row[$i] != '') @unlink('../'.$images_upload_dir.'/'.$row[$i]);
			if($row[$i] != '') @unlink('../'.$images_upload_dir.'/thumb_'.$row[$i]);
			if($row[$i] != '') @unlink('../'.$file_upload_dir.'/'.$row[$i]);
		}

		$sql = 'DELETE FROM `doc` WHERE `doc_id`='.$this->doc_id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update')
	{
		global $images_upload_dir,$file_upload_dir;
		$doc_id=PreForm($this->doc_id);
		$title=PreForm($this->title);
		$desc=PreForm($this->desc);
		$added_date=PreForm($this->added_date);
		$doc_cat_id=PreForm($this->doc_cat_id);
		$file1=PreForm($this->file1);
		$file2=PreForm($this->file2);
		$file3=PreForm($this->file3);
		$thumb_pic=PreForm($this->thumb_pic);
		$featured=PreForm($this->featured);
		$counter=PreForm($this->counter);
		$active=PreForm($this->active);
		$keywords=PreForm($this->keywords);
		$tag3=PreForm($this->tag3);

		$op=$_op;

		include '../forms/fdoc.php';

	}

	public function Update()
	{
		global $db;
		global $images_upload_dir,$file_upload_dir;
		if(sizeof($this->Errors)) return  false;
		//Delete Unused Images
		$pics[0]= $this->file1;
		$pics[1]= $this->file2;
		$pics[2]= $this->file3;
		$pics[3]= $this->thumb_pic;
		$sql='SELECT  `file1`,  `file2`,  `file3`,  `thumb_pic` FROM `doc`  WHERE `doc_id`='.$this->doc_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		for($i=0;$i<4;$i++)
		{
			//Delete all possible
			if($row[$i] != $pics[$i] && $pics[$i]!='' ) @unlink('../'.$images_upload_dir.'/'.$row[$i]);
			if($row[$i] != $pics[$i] && $pics[$i]!='' ) @unlink('../'.$images_upload_dir.'/thumb_'.$row[$i]);
			if($row[$i] != $pics[$i] && $pics[$i]!='' ) @unlink('../'.$file_upload_dir.'/'.$row[$i]);
		}

		$sql = 'UPDATE `doc` SET `title` = \''.PreSql($this->title).'\', `desc` = \''.PreSql($this->desc).'\', `doc_cat_id` = \''.PreSql($this->doc_cat_id).'\', `file1` = \''.PreSql($this->file1).'\', `file2` = \''.PreSql($this->file2).'\', `file3` = \''.PreSql($this->file3).'\', `thumb_pic` = \''.PreSql($this->thumb_pic).'\', `featured` = \''.PreSql($this->featured).'\', `counter` = \''.PreSql($this->counter).'\', `active` = \''.PreSql($this->active).'\', `keywords` = \''.PreSql($this->keywords).'\', `tag3` = \''.PreSql($this->tag3).'\' WHERE `doc_id` = '.$this->doc_id;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function HitPlus()
	{
		global $db;
		$this->counter++;
		$sql = 'UPDATE `doc` SET `counter` = `counter`+1 WHERE `doc_id` = '.$this->doc_id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		return true;

	}

	public function FromForm()
	{
		global $images_upload_dir,$image_width,$image_height,$thumb_image_width,$thumb_image_height,$file_upload_dir;
		$this->doc_id=PostForm($_POST['doc_id']);
		$this->title=PostForm($_POST['title']);
		$this->desc=PostForm($_POST['desc']);
		$this->added_date=PostForm($_POST['added_date']);
		$this->doc_cat_id=PostForm($_POST['doc_cat_id']);
		$this->featured=PostForm($_POST['featured']);
		$this->active=PostForm($_POST['active']);
		$this->keywords=PostForm($_POST['keywords']);
		$this->tag3=PostForm($_POST['tag3']);

		if($_FILES['file1']['name']) {
			list($file,$error) = Upload('file1','../'.$file_upload_dir,'zip,rar,doc,pdf,mpeg,avi,asf,wmv,avi,mpg,wav,mp3',15000000,'');
			if($error)
			$this->Errors[] .= " Cannot Upload For File1:".$error."<br>";
			else
			$this->file1=$file;
		}

		if($_FILES['file2']['name']) {
			list($file,$error) = Upload('file2','../'.$file_upload_dir,'zip,rar,doc,pdf,avi,wmv,',5000000,'');
			if($error)
			$this->Errors[] .= " Cannot Upload For File2:".$error."<br>";
			else
			$this->file2=$file;
		}

		if($_FILES['file3']['name']) {
			list($file,$error) = Upload('file3','../'.$file_upload_dir,'zip,rar,doc,pdf',5000000,'');
			if($error) 
			$this->Errors[] .= " Cannot Upload For File3:".$error."<br>";
			else
			$this->file3=$file;
		}

		if($_FILES['thumb_pic']['name']) {
			list($file,$error) = UploadImage('thumb_pic','../'.$file_upload_dir,'jpeg,gif,png,jpg,bmp',5000000,'',1,$image_width,$image_height);
			if($error) 
			$this->Errors[] .= " Cannot Upload  Image:".$error."<br>";
			else
			$this->thumb_pic=$file;
		}

	}
	public static function AdminListdocs()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * FROM `doc` ORDER BY `doc_id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang(list_doc).':</p>' ;
		$List.= '<table class="adminlist" width="600"><tr class="header"><td width="5%">ID</td>
		<td width="30%">'._lang(title).'</td>
		<td width="15%">Active</td>
		<td width="15%">Featured</td>
		<td width="15%">#Downloded</td>
		<td width="15%">'._lang(delete).'</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="5%">'.$row[doc_id].'</td><td width="30%">'.
			"<a href=\"?doc_id=$row[doc_id]&op=Edit\">$row[title]</a></td>".
			"<td width=\"15%\">".($row['active']?"Yes":"No")."</td>".
			"<td width=\"15%\">".($row['featured']?"<b><a href=\"?doc_id=$row[doc_id]&op=UnsetFeatured\">Unset<a/></b>":"<a href=\"?doc_id=$row[doc_id]&op=SetFeatured\">Set<a/>")."</td>".
			"<td width=\"15%\">".($row['counter'])."</td>".
			"<td width=\"15%\"><a href=\"javascript:if (confirm('"._lang(sure_delete_doc)."')) {document.location ='?doc_id=$row[doc_id]&op=Delete';}\">Delete</a></td>".

			"</tr> ";
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
		<label for="job_id">&nbsp;&nbsp;<b>'._lang(enter_doc_id).':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="doc_id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang(sure_delete_prod).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';
		return $List;


	}
	
	public function Preview($show_controls="0")
	{
		global $file_upload_dir,$tvc_width,$tvc_height,$predir;
		
	
		echo VideoPlayer($predir.$file_upload_dir."/".$this->file1,$tvc_width,$tvc_height,$show_controls);
	}
	
	public function Play()
	{
		TvcPage($this->doc_id,$this->title,$this->desc,$this->file1);
	}



}

?>