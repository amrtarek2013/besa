<?php
class sms_msg
{

	public  $msg_id;
	public  $msg_title;
	public  $msg_text;
	public  $minimum_gab;
	public  $tag1;
	public  $tag2;
	public  $tag3;

	var  $Errors;




	public function SetValues($_msg_id , $_msg_title , $_msg_text , $_minimum_gab , $_tag1 , $_tag2 , $_tag3)
	{	$this->msg_title=$_msg_title;
	$this->msg_text=$_msg_text;
	$this->minimum_gab=$_minimum_gab;
	$this->tag1=$_tag1;
	$this->tag2=$_tag2;
	$this->tag3=$_tag3;

	}


	public function SelectFromDB($_msg_id)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_msg_id))
		{
			$this->Errors[]=_lang(invalid_msg_id);
			return false;
		}
		$this->msg_id=$_msg_id;
		$sql = 'SELECT * FROM `sms_msg` WHERE `msg_id` = '.$_msg_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_sms_msg_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->msg_title=$row['msg_title'];
		$this->msg_text=$row['msg_text'];
		$this->minimum_gab=$row['minimum_gab'];
		$this->tag1=$row['tag1'];
		$this->tag2=$row['tag2'];
		$this->tag3=$row['tag3'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `sms_msg` (`msg_title`, `msg_text`, `minimum_gab`, `tag1`, `tag2`,  `tag3`) VALUES (\''.PreSql($this->msg_title).'\',  \''.PreSql($this->msg_text).'\',  \''.PreSql($this->minimum_gab).'\',  \''.PreSql($this->tag1).'\',  \''.PreSql($this->tag2).'\',  \''.PreSql($this->tag3).'\')';
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
		include '../forms/fsms_msg.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `sms_msg` WHERE `msg_id`='.$this->msg_id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update')
	{
		$msg_id=PreForm($this->msg_id);
		$msg_title=PreForm($this->msg_title);
		$msg_text=PreForm($this->msg_text);
		$minimum_gab=PreForm($this->minimum_gab);
		$tag1=PreForm($this->tag1);
		$tag2=PreForm($this->tag2);
		$tag3=PreForm($this->tag3);

		$op=$_op;

		include '../forms/fsms_msg.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `sms_msg` SET `msg_title` = \''.PreSql($this->msg_title).'\', `msg_text` = \''.PreSql($this->msg_text).'\', `minimum_gab` = \''.PreSql($this->minimum_gab).'\', `tag1` = \''.PreSql($this->tag1).'\', `tag2` = \''.PreSql($this->tag2).'\', `tag3` = \''.PreSql($this->tag3).'\' WHERE `msg_id` = '.$this->msg_id;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function FromForm()
	{
		$this->msg_id=PostForm($_POST['msg_id']);
		$this->msg_title=PostForm($_POST['msg_title']);
		$this->msg_text=PostForm($_POST['msg_text']);
		$this->minimum_gab=PostForm($_POST['minimum_gab']);
		$this->tag1=PostForm($_POST['tag1']);
		$this->tag2=PostForm($_POST['tag2']);
		$this->tag3=PostForm($_POST['tag3']);

	}


	public static function AdminListsms_msgs($autoresponse=true)
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];

		if($autoresponse) $where=" WHERE msg_id < 100 ";
		else
		$where=" WHERE msg_id >= 100 ";

		$sql = 'SELECT * FROM `sms_msg`  '.$where.'	ORDER BY `msg_id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang(list_sms_msg).':</p>' ;
		$List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang(msg_title).'</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[msg_id].'</td><td width="60%">'.
			"<a href=\"?msg_id=$row[msg_id]&op=Edit\">$row[msg_title]</a></td>".
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
		
		if(!$autoresponse)
		$List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
		<label for="job_id">&nbsp;&nbsp;<b>'._lang(enter_msg_id).':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="msg_id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang(sure_delete_sms_msg).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
		</form>
		<br/>';
		
		return $List;


	}


	public static function ListManuallMessages()
	{
		global $db;
		$sql = 'SELECT `msg_id`,`msg_title` FROM `sms_msg` WHERE `msg_id` >= 100  ORDER BY `msg_title`  ';

		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		while($row = $db->sql_fetchrow($result))
		{
			$items[]=$row['msg_title'];
			$items_values[]=$row['msg_id'];
		}
		return ListOptions($items,$items_values,"",true);
	}


}

?>