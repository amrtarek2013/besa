<?php
class video_category
{

	public  $id;
	public  $name;
	public  $display_order;

	var  $Errors;


	public function SetValues($_id , $_name , $_display_order)
	{	$this->name=$_name;
	$this->display_order=$_display_order;

	}


	public function SelectFromDB($_id)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_id))
		{
			$this->Errors[]=_lang('invalid_id');
			return false;
		}
		$this->id=$_id;
		$sql = 'SELECT * FROM `video_category` WHERE `id` = '.$_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang('no_video_category_found');
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->name=$row['name'];
		$this->display_order=$row['display_order'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `video_category` (`name`,  `display_order`) VALUES (\''.PreSql($this->name).'\',  \''.PreSql($this->display_order).'\')';
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
		include '../forms/fvideo_category.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `video_category` WHERE `id`='.$this->id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update')
	{
		$id=PreForm($this->id);
		$name=PreForm($this->name);
		$display_order=PreForm($this->display_order);

		$op=$_op;

		include '../forms/fvideo_category.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `video_category` SET `name` = \''.PreSql($this->name).'\', `display_order` = \''.PreSql($this->display_order).'\' WHERE `id` = '.$this->id;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function FromForm()
	{
		$this->id=PostForm($_POST['id']);
		$this->name=PostForm($_POST['name']);
		$this->display_order=PostForm($_POST['display_order']);

	}
	public static function AdminListvideo_categorys()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * FROM `video_category`  	ORDER BY `display_order` LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang('list_video_category').':</p>' ;
		$List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang('name').'</td><td width="30%">'._lang('delete').'</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td><td width="60%">'.
			"<a href=\"?id=$row[id]&op=Edit\">$row[name]</a></td>".
			"<td width=\"30%\"><a href=\"javascript:if (confirm('"._lang('sure_delete_video_category')."')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
		}
		$List.= '</table>';
		$List.="<div class=\"admin_list_control\">";
		if($admin_page>1)
		$List.= "&laquo; <a href=\"?admin_page=".($admin_page-1)."\" >"._lang('list_previous_page')." $per_page </a>&nbsp;&nbsp; ";

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
		$List.= "&nbsp;<a href=\"?admin_page=".($admin_page+1)."\" > "._lang('list_next_page')." $per_page</a> &raquo;";

		$List.="</div><br/>";
		$List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
		<label for="job_id">&nbsp;&nbsp;<b>'._lang('enter_id').':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang('sure_delete_prod').'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';
		return $List;


	}
	
	
	
	public static function ListSelectOptions($selected="",$type=_article)
	{
		global $db;
		
		$sql = 'SELECT `name` , `id`  FROM `video_category` ORDER BY `name`';
		
		
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			if($row['id']==$selected) $sel="selected"; else $sel="";
			$List.= "<option value=\"$row[id]\" $sel>$row[name]</option>\n";
		}
		return $List;
	}
	
	public static  function GetCategories()
	{
		global $db;
		return $db->get_array('video_category',false,false,'display_order');
		
		
	}
	

}

?>