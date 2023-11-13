<?php
class mail_failure
{

	public  $id;
	public  $email;
	public  $repeated;
	public  $unsubscribed;
	public  $last_modified;

	var  $Errors;


	public function SetValues($_id , $_email , $_repeated , $_unsubscribed , $_last_modified)
	{	$this->email=$_email;
	$this->repeated=$_repeated;
	$this->unsubscribed=$_unsubscribed;
	$this->last_modified=$_last_modified;

	}


	public static function IsExisted($email)
	{
		global $db;
		$sql = 'SELECT * FROM `mail_failure` WHERE `email` = \''.trim(strtolower(PreSql($email))).'\'';
		if(! ($result=$db->sql_query($sql)))
		{
			return false;
		}
		if($db->sql_numrows($result)<1)
		{
			return false;
		}
		$row = $db->sql_fetchrow($result);
		return $row['id'];
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
		$sql = 'SELECT * FROM `mail_failure` WHERE `id` = '.$_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang('no_mail_failure_found');
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->email=$row['email'];
		$this->repeated=$row['repeated'];
		$this->unsubscribed=$row['unsubscribed'];
		$this->last_modified=$row['last_modified'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `mail_failure` (`email`, `repeated`, `unsubscribed`,  `last_modified`) VALUES (\''.PreSql(strtolower($this->email)).'\',  \''.PreSql($this->repeated).'\',  \''.PreSql($this->unsubscribed).'\',  \''.date('Y-m-d H:i:s').'\')';
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
		include '../forms/fmail_failure.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `mail_failure` WHERE `id`='.$this->id;
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
		$email=PreForm($this->email);
		$repeated=PreForm($this->repeated);
		$unsubscribed=PreForm($this->unsubscribed);
		$last_modified=PreForm($this->last_modified);

		$op=$_op;

		include '../forms/fmail_failure.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `mail_failure` SET `email` = \''.PreSql(strtolower($this->email)).'\', `repeated` = \''.PreSql($this->repeated).'\', `unsubscribed` = \''.PreSql($this->unsubscribed).'\', `last_modified` = \''.date('Y-m-d H:i:s').'\' WHERE `id` = '.$this->id;


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
		$this->email=PostForm($_POST['email']);
		$this->repeated=PostForm($_POST['repeated']);
		$this->unsubscribed=PostForm($_POST['unsubscribed']);
		$this->last_modified=PostForm($_POST['last_modified']);

	}
	public static function AdminListmail_failures()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * FROM `mail_failure`  	ORDER BY `last_modified` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		
		$List.= '<table class="adminlist" width="600">
		<tr class="header">
		<td width="10%">ID</td>
		<td width="30%">Email</td>
		<td width="20%">Repeated</td>
		<td width="20%">Unsubscribed</td>
		<td width="20%">Last modification</td>
		</tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'">
			<td width="10%">'.$row[id].'</td>'
			.'<td>'.$row['email'].'</a></td>'
			.'<td>'.$row['repeated'].'</a></td>'
			.'<td>'.($row['unsubscribed']&&$row['unsubscribed']!='f'?'Yes':'No').'</a></td>'
			.'<td>'.date('d-m-Y',strtotime($row['last_modified'])).'</a></td>'
			.'</tr>';
			
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
		
		return $List;


	}
	
	static function UnsubscribeRepeated($min_repeated=6)
	{
		global $db;
		$sql = 'SELECT * FROM `mail_failure`  WHERE unsubscribed=false AND 	repeated >= '.$min_repeated;
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$mailure_failure1= new mail_failure();
		while($row = $db->sql_fetchrow($result))
		{
			special::Unsubscribe(trim($row['email']),MyMD5($row['email']));
			send_email::UnsubscribeMail(trim($row['email']),MyMD5($row['email']));
			subscriber::UnsubscribeFromCarFinder(trim($row['email']));
			$mailure_failure1->SelectFromDB($row['id']);
			$mailure_failure1->unsubscribed=true;
			$mailure_failure1->Update();
		}
		
	}

}

?>