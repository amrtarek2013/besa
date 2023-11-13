<?php
class email_msg
{

	public  $msg_id;
	public  $msg_name;
	public  $msg_subject;
	public  $msg_body;
	public  $minmum_gab;
	public  $tag1;
	public  $tag2;
	public  $tag3;
	public  $tag4;
	public  $tag5;

	var  $Errors;
	public  static  $SErrors;


	public function SetValues($_msg_id , $_msg_name , $_msg_subject , $_msg_body , $_minmum_gab , $_tag1 , $_tag2 , $_tag3 , $_tag4 , $_tag5)
	{
		$this->msg_name=$_msg_name;
		$this->msg_subject=$_msg_subject;
		$this->msg_body=$_msg_body;
		$this->minmum_gab=$_minmum_gab;
		$this->tag1=$_tag1;
		$this->tag2=$_tag2;
		$this->tag3=$_tag3;
		$this->tag4=$_tag4;
		$this->tag5=$_tag5;

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
		$sql = 'SELECT * FROM `email_msg` WHERE `msg_id` = '.$_msg_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_email_msg_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->msg_name=$row['msg_name'];
		$this->msg_subject=$row['msg_subject'];
		
		$this->msg_body=  stripslashes($row['msg_body']);
		
		$this->minmum_gab=$row['minmum_gab'];
		$this->tag1=$row['tag1'];
		$this->tag2=$row['tag2'];
		$this->tag3=$row['tag3'];
		$this->tag4=$row['tag4'];
		$this->tag5=$row['tag5'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `email_msg` (`msg_name`, `msg_subject`, `msg_body`, `minmum_gab`, `tag1`, `tag2`, `tag3`, `tag4`,  `tag5`) VALUES (\''.PreSql($this->msg_name).'\',  \''.PreSql($this->msg_subject).'\',  \''.PreSql($this->msg_body,0).'\',  \''.PreSql($this->minmum_gab).'\',  \''.PreSql($this->tag1).'\',  \''.PreSql($this->tag2).'\',  \''.PreSql($this->tag3).'\',  \''.PreSql($this->tag4).'\',  \''.PreSql($this->tag5).'\')';
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
		include '../forms/femail_msg.php';
	}

	public function Delete()
	{
		global $db;
		
		$sql = 'DELETE FROM `send_email` WHERE `msg_id`=\''.$this->msg_id.'\' AND 	(is_sent IS NULL OR is_sent = false)';
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		
		$sql = 'DELETE FROM `email_msg` WHERE `msg_id`='.$this->msg_id;
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
		$msg_name=PreForm($this->msg_name);
		$msg_subject=PreForm($this->msg_subject);
		$msg_body= $this->msg_body;
		$minmum_gab=PreForm($this->minmum_gab);
		$tag1=PreForm($this->tag1);
		$tag2=PreForm($this->tag2);
		$tag3=PreForm($this->tag3);
		$tag4=PreForm($this->tag4);
		$tag5=PreForm($this->tag5);

		$op=$_op;

		include '../forms/femail_msg.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `email_msg` SET `msg_name` = \''.PreSql($this->msg_name).'\', `msg_subject` = \''.PreSql($this->msg_subject).'\', `msg_body` = \''.PreSql($this->msg_body,0).'\', `minmum_gab` = \''.PreSql($this->minmum_gab).'\', `tag1` = \''.PreSql($this->tag1).'\', `tag2` = \''.PreSql($this->tag2).'\', `tag3` = \''.PreSql($this->tag3).'\', `tag4` = \''.PreSql($this->tag4).'\', `tag5` = \''.PreSql($this->tag5).'\' WHERE `msg_id` = '.$this->msg_id;

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
		$this->msg_name=PostForm($_POST['msg_name']);
		$this->msg_subject=PostForm($_POST['msg_subject']);
		$this->msg_body=PostForm($_POST['msg_body']);
		$this->minmum_gab=PostForm($_POST['minmum_gab']);
		$this->tag1=PostForm($_POST['tag1']);
		$this->tag2=PostForm($_POST['tag2']);
		$this->tag3=PostForm($_POST['tag3']);
		$this->tag4=PostForm($_POST['tag4']);
		$this->tag5=PostForm($_POST['tag5']);

	}
	
	
	public function Send($to_email)
	{
		global  $site;
		$from=$site['from_mail'];
		mail($to_email,$this->msg_subject,send_email::PreSend($this->msg_body,$to_email,'Tester'),"From: $from\nReply-To: $from\nContent-Type: text/html");
	}
	
	public static function AdminListemail_msgs($autoresponse=true)
	{
		global $db,$list_per_page;
		$per_page=50;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		
		if($autoresponse) $where=" WHERE msg_id < 100 ";
		else
		$where=" WHERE msg_id >= 100 ";
		
		$sql = 'SELECT * FROM `email_msg` '.$where.' ORDER BY `msg_id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		
		
		
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang(list_email_msg).':</p>' ;
		$List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang(msg_name).'</td><td>Delete</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[msg_id].'</td><td width="60%">'.
			"<a href=\"?msg_id=$row[msg_id]&op=Edit\">$row[msg_name]</a></td>
			<td><a href=\"javascript:if (confirm('Are You sure')) {document.location ='?msg_id=$row[msg_id]&op=Delete';}\">Delete</a></td>
			".
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
		<input onclick="if (confirm(\''._lang(sure_delete_email_msg).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
		</form>
		<br/>';
		
		
		return $List;


	}
	
	
	public static function ListManuallMessages()
	{
		global $db;
		$sql = 'SELECT `msg_id`,`msg_name` FROM `email_msg` WHERE `msg_id` >= 100  ORDER BY `msg_name`  ';
		
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		while($row = $db->sql_fetchrow($result))
		{
			$items[]=$row['msg_name'];
			$items_values[]=$row['msg_id'];
		}		
		return ListOptions($items,$items_values,"",true);
	}
	
	public static function GetName($msg_id)
	{
		global $db;
		$sql = 'SELECT msg_name FROM email_msg WHERE msg_id=\''.$msg_id.'\'';
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		return $row[0];
	}
	


}

?>