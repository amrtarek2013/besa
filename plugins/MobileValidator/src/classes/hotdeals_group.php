<?php
class hotdeals_group
{

	public  $id;
	public  $name;
	public  $stock_numbers;
	public  $tag1;
	public  $tag2;

	var  $Errors;
	public static   $SErrors;


	public function SetValues($_id , $_name , $_stock_numbers , $_tag1 , $_tag2)
	{
		$this->name=$_name;
		$this->stock_numbers=$_stock_numbers;
		$this->tag1=$_tag1;
		$this->tag2=$_tag2;

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
		$sql = 'SELECT * FROM `hotdeals_group` WHERE `id` = '.$_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang('no_hotdeals_group_found');
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->name=$row['name'];
		$this->stock_numbers=$row['stock_numbers'];
		$this->tag1=$row['tag1'];
		$this->tag2=$row['tag2'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `hotdeals_group` (`name`, `stock_numbers`, `tag1`,  `tag2`) VALUES (\''.PreSql($this->name).'\',  \''.PreSql($this->stock_numbers).'\',  \''.PreSql($this->tag1).'\',  \''.PreSql($this->tag2).'\')';
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
		include '../forms/fhotdeals_group.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `hotdeals_group` WHERE `id`='.$this->id;
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
		$stock_numbers=PreForm($this->stock_numbers);
		$tag1=PreForm($this->tag1);
		$tag2=PreForm($this->tag2);

		$op=$_op;

		include '../forms/fhotdeals_group.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `hotdeals_group` SET `name` = \''.PreSql($this->name).'\', `stock_numbers` = \''.PreSql($this->stock_numbers).'\', `tag1` = \''.PreSql($this->tag1).'\', `tag2` = \''.PreSql($this->tag2).'\' WHERE `id` = '.$this->id;

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
		$this->stock_numbers=PostForm($_POST['stock_numbers']);
		$this->tag1=PostForm($_POST['tag1']);
		$this->tag2=PostForm($_POST['tag2']);

	}
	public static function AdminListhotdeals_groups()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * FROM `hotdeals_group`  	ORDER BY `id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang('list_hotdeals_group').':</p>' ;
		$List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang('name').'</td><td width="30%">'._lang('delete').'</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td><td width="60%">'.
			"<a href=\"?id=$row[id]&op=Edit\">$row[name]</a></td>".
			"<td width=\"30%\"><a href=\"javascript:if (confirm('"._lang('sure_delete_hotdeals_group')."')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
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


	function BuildHotdealsForm()
	{
		include($GLOBALS['predir'].'forms/build_hotdeals.php');

	}
	
	function BurnEmailForSubscribersFromForm()
	{
		global $db;
		if(!($html=self::BuildHotdealsFromForm()))
		return false;
		
		$email_msg1= new email_msg();
		$email_msg1->msg_name=$_POST['name'];
		$email_msg1->msg_subject=$_POST['email_subject'];
		$email_msg1->msg_body=$html;
		
		if(!($msg_id=$email_msg1->Insert()))
		{
			self::$SErrors=$email_msg1->Errors;
			return false;
		}
		
		if($_POST['date_to_send'])
		{
			$tmp=explode('-',$_POST['date_to_send']);
			if(sizeof($tmp)!=3) {self::$SErrors[]='Invalide date'; return false; }
			$date="{$tmp[2]}-{$tmp[1]}-{$tmp[0]}";
		}
		else 
		$date='now';
		
		if(!special::SendMailToSubscribers($msg_id,$date))
		{
			self::$SErrors=special::$SErrors;
			return false;
		}
		
		return $msg_id;
		
	}
	
	
	function SendTestEmail()
	{
		global $site;
		
		$from=$site['from_mail'];
		
		if(!($html=self::BuildHotdealsFromForm()))
		return false;
		
		if(mail($_POST['test_email_address'],$_POST['email_subject'],$html,"From: $from\nReply-To: enquiry@austfleetsales.com.au\nContent-Type: text/html"))
		return true;
		
		self::$SErrors[]='Can\'t Send Email To "'.$_POST['test_email_address'].'" ';
		return false;
		
		
	}

	function BuildHotdealsFromForm($temp=false)
	{
		global $db;

		$upload_dir= $GLOBALS['predir'].$GLOBALS['images_upload_dir'];


		if($_FILES['header_image']['name'])
		{
			list($file,$error)= UploadImage('header_image',$upload_dir,'jpg,gif,png',50000000,'',1,598,1000);
			$image_file=$GLOBALS['images_upload_dir'].'//'.$file;
		}

		if($error) {self::$SErrors[]=  " Cannot Upload For Image:".$error;  return false;}


		if(!sizeof($_POST['group_ids']))
		{
			self::$SErrors[]=  "No group is selected";
			return false;
		}
		$groups=array();
	
		foreach ($_POST['group_ids'] as $group_id)
		{
			if($group_id<0)
			{
				$groups[$group_id]='-';
				continue;
			}
			$group1= new hotdeals_group();
			$group1->SelectFromDB($group_id);
			$groups[$group1->name]= array();
			$stocks=explode(',',$group1->stock_numbers);
			if(!sizeof($stocks))
			{
				self::$SErrors[]=  "Group '{$group1->name}' has no stock numbers !";
				return false;
			}
			$row='';
			$j=0;
				$featured=array();
			foreach ($stocks as $stock_no)
			{
				
				$afs_stock2=new afs_stock2();

				if(!$afs_stock2->SelectFromDB(trim($stock_no),$row))
				{
					self::$SErrors[]="Error with stock number:#{$stock_no} in group '{$group1->name}'";
					array_push(self::$SErrors[],$afs_stock2->Errors);
					return false;
				}

				//Car image
				if(file_exists($GLOBALS['predir'].'image_uploads/'.$stock_no.'/image_1_thumb.jpg'))
				$row['image']= 'image_uploads/'.$stock_no.'/image_1_thumb.jpg';
				else
				$row['image']='image_uploads/default_thumb.jpg';
				if($j==0)
				$featured[]=$row;
				else 
				$groups[$group1->name][]=$row;
				
				$j++;
			}
			//if(sizeof($groups[$group1->name]))
			//print_r($groups[$group1->name]);
			multi2dSortAsc($groups[$group1->name],'rrp');
			//print_r($groups[$group1->name]);
			
			$groups[$group1->name]=array_merge($featured,$groups[$group1->name]);
			
		}
		return self::BuildHotdealsHTML($_POST['email_subject'],$groups,$image_file);
	}


	function BuildHotdealsHTML($email_subject,$groups,$header_image)
	{

		global $site;
		ob_start();
		include($GLOBALS['predir'].'templates/hotdeals.html');
		$html_email =ob_get_contents();
		ob_clean();
		return $html_email;
	}

	public static function ListOptions()
	{
		global $db;
		$sql = 'SELECT `id`,`name` FROM `hotdeals_group`  ORDER BY `name`  ';

		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		while($row = $db->sql_fetchrow($result))
		{
			$items[]=$row['name'];
			$items_values[]=$row['id'];
		}
		return ListOptions($items,$items_values,"",true);
	}

}

?>