<?php
session_name('CAKEPHP');
session_start();
class elist_form
{

	//mailing list Id from the db
	const LIST_ID="22";

	public  $subscriberid;
	public  $fname;
	public  $lname;
	public  $suburb;
	public  $address;
	public  $postcode;
	public  $tel;
	public  $email;
	public  $source;
	public  $yard;
	public  $comp_id;
	public  $dont_send_mail;
	public  $added_date;

	var  $Errors;

	public static  $sources=array("walkin","internet","car enquire","f4wd","finance","offer","special","subscriber","trade-in","10k comp");
	public static  $sources_values=array("walkin","internet","car enquire","f4wd","finance","offer","special","subscriber","trade-in","10k comp");


	public function SetValues($_subscriberid = false,  $_fname = false,  $_lname = false,  $_suburb = false,$_address = false,$_postcode = false,  $_tel = false,  $_email = false,  $_source = false,  $_yard = false,  $_comp_id = false,  $_dont_send_mail = false,  $_added_date = false)
	{	$this->fname=$_fname;
	$this->lname=$_lname;
	$this->suburb=$_suburb;
	$this->address=$_address;
	$this->postcode=$_postcode;
	$this->tel=$_tel;
	$this->email=$_email;
	$this->source=$_source;
	$this->yard=$_yard;
	$this->comp_id=$_comp_id;
	$this->dont_send_mail=$_dont_send_mail;
	$this->added_date=$_added_date;

	}


	public function SelectFromDB($_subscriberid)
	{
		global $mysql_db;
		if (!ereg("^([0-9]+)$",$_subscriberid))
		{
			$this->Errors[]=_lang(invalid_subscriberid);
			return false;
		}
		$this->subscriberid=$_subscriberid;
		$sql = 'SELECT `emailaddress` AS "email", `unsubscribed` AS "dont_send_mail"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=1 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "fname"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=2 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "lname"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=5 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "suburb"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=4 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "address"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=7 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "postcode"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=24 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "tel"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=26 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "source"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=27 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "yard"
				,(SELECT `data` FROM `ss_subscribers_data` WHERE `fieldid`=28 AND `ss_subscribers_data`.`subscriberid`='.$_subscriberid.'   ) AS "comp_id"
	 FROM `ss_list_subscribers`  WHERE `ss_list_subscribers`.`subscriberid` = '.$_subscriberid;
		if(! ($result=$mysql_db->sql_query($sql)))
		{
			$this->Errors[]=$mysql_db->sql_error_msg($result);
			return false;
		}

		if($mysql_db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_elist_form_found);
			return false;
		}

		$row = $mysql_db->sql_fetchrow($result);
		$this->fname=$row['fname'];
		$this->lname=$row['lname'];
		$this->suburb=$row['suburb'];
		$this->address=$row['address'];
		$this->postcode=$row['postcode'];
		$this->tel=$row['tel'];
		$this->email=$row['email'];
		$this->source=$row['source'];
		$this->yard=$row['yard'];
		$this->comp_id=$row['comp_id'];
		$this->dont_send_mail=$row['dont_send_mail'];
		$this->added_date=$row['added_date'];
		return true;


	}

	public function Insert($subscriberid=false)
	{
		global $mysql_db;
		$sql = 'INSERT INTO `ss_list_subscribers` ('.($subscriberid?"`subscriberid`, ":"").' `emailaddress`, `unsubscribed`,`format`,`confirmed`,`confirmcode`,`requestip`,`requestdate`,`subscribedate`, `listid`,`unsubscribeconfirmed`)
			VALUES ( '.($subscriberid?" $subscriberid, ":"").' \''.PreSql($this->email).'\',  \''.PreSql($this->dont_send_mail).'\',"h","1"," 	74458b450361fe0c6964aee13a2bc5cb","'.$_SERVER['REMOTE_ADDR'].'","'.time().'","'.time().'","'.elist_form::LIST_ID.'",\''.PreSql($this->dont_send_mail).'\')';

		if(!$mysql_db->sql_query($sql))
		{
			$this->Errors[]=$mysql_db->sql_error_msg($result);
			return false;
		}

		$this->subscriberid= $mysql_db->sql_nextid();

		$sql = 'INSERT INTO `ss_subscribers_data` (`subscriberid`, `fieldid`, `data`) VALUES
	('.$this->subscriberid.', 1,  \''.PreSql($this->fname).'\'),
	('.$this->subscriberid.', 2,  \''.PreSql($this->lname).'\'),
	('.$this->subscriberid.', 5,  \''.PreSql($this->suburb).'\'),
	('.$this->subscriberid.', 4,  \''.PreSql($this->address).'\'),
	('.$this->subscriberid.', 7,  \''.PreSql($this->postcode).'\'),
	('.$this->subscriberid.', 24,  \''.PreSql($this->tel).'\'),
	('.$this->subscriberid.', 26,  \''.PreSql($this->source).'\'),
	('.$this->subscriberid.', 27,  \''.PreSql($this->yard).'\'),
	('.$this->subscriberid.', 28,  \''.PreSql($this->comp_id).'\')';

		if(!$mysql_db->sql_query($sql))
		{
			$this->Errors[]=$mysql_db->sql_error_msg($result);
			return false;
		}

		$sql = 'UPDATE `ss_lists` SET `subscribecount` = `subscribecount`+1 WHERE `ss_lists`.`listid` ='.elist_form::LIST_ID.' LIMIT 1' ;
		if(!$mysql_db->sql_query($sql))
		PrintErrors($this->Errors);


		$sql = 'INSERT INTO ss_queues (queueid, queuetype, ownerid, recipient, processed) SELECT queueid, \'autoresponder\', ownerid, \''.$this->subscriberid.'\', 0 FROM ss_autoresponders WHERE listid=\''.elist_form::LIST_ID.'\'' ;
		$mysql_db->sql_query($sql);


		return $this->subscriberid;
	}


	public function Add()
	{
		$op='Add';
		include '../forms/felist_form.php';

	}

	public function Delete()
	{
		global $mysql_db;

		$sql = 'DELETE FROM `ss_list_subscribers` WHERE `subscriberid`='.$this->subscriberid;
		if(!$mysql_db->sql_query($sql))
		{
			$this->Errors[]=$mysql_db->sql_error_msg($result);
			return false;
		}


		$sql = 'DELETE FROM `ss_subscribers_data` WHERE `subscriberid`='.$this->subscriberid;

		if(!$mysql_db->sql_query($sql))
		{
			$this->Errors[]=$mysql_db->sql_error_msg($result);
			return false;
		}

		$sql = 'UPDATE `ss_lists` SET `subscribecount` = `subscribecount`-1 WHERE `ss_lists`.`listid` ='.elist_form::LIST_ID.' LIMIT 1' ;
		if(!$mysql_db->sql_query($sql))
		PrintErrors($this->Errors);

		return true;

	}

	public function Edit($_op='Update')
	{
		$subscriberid=PreForm($this->subscriberid);
		$fname=PreForm($this->fname);
		$lname=PreForm($this->lname);
		$suburb=PreForm($this->suburb);
		$address=PreForm($this->address);
		$postcode=PreForm($this->postcode);
		$tel=PreForm($this->tel);
		$email=PreForm($this->email);
		$source=PreForm($this->source);
		$yard=PreForm($this->yard);
		$comp_id=PreForm($this->comp_id);

		$dont_send_mail=PreForm($this->dont_send_mail);
		$added_date=PreForm($this->added_date);

		$op=$_op;

		include '../forms/felist_form.php';

	}

	public function Update()
	{
		return $this->Delete()&&$this->Insert($this->subscriberid);
	}

	public function FromForm()
	{
		$this->subscriberid=PostForm($_POST['subscriberid']);
		$this->fname=PostForm($_POST['fname']);
		$this->lname=PostForm($_POST['lname']);
		$this->address=PostForm($_POST['address']);
		$this->suburb=PostForm($_POST['suburb']);
		$this->postcode=PostForm($_POST['postcode']);
		$this->tel=PostForm($_POST['tel']);
		$this->email=PostForm($_POST['email']);
		$this->source=PostForm($_POST['source']);
		$this->yard=PostForm($_POST['yard']);
		$this->comp_id=PostForm($_POST['comp_id']);
		$this->dont_send_mail=PostForm($_POST['dont_send_mail']);
		$this->added_date=PostForm($_POST['added_date']);

	}
	public static function AdminListelist_forms()
	{
		global $mysql_db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];




		if(isset($_POST['id'])) $_SESSION['ef_id']=$_POST['id'];
		if(isset($_POST['email'])) $_SESSION['ef_email']=$_POST['email'];
		if(isset($_POST['fname'])) $_SESSION['ef_fname']=$_POST['fname'];
		if(isset($_POST['lname'])) $_SESSION['ef_lname']=$_POST['lname'];
		if(isset($_POST['tel'])) $_SESSION['ef_tel']=$_POST['tel'];
		if(isset($_POST['source'])) $_SESSION['ef_source']=$_POST['source'];
		if(isset($_POST['order_by'])) $_SESSION['ef_order_by']=$_POST['order_by'];

		$WHERE =" WHERE 1=1 ";
		if(isset($_SESSION['ef_id']) && $_SESSION['ef_id']!="" ) $WHERE.=" AND `subscriberid` LIKE '{$_SESSION['ef_id']}%' ";
		if(isset($_SESSION['ef_email'])&& $_SESSION['ef_email']!="" ) $WHERE.=" AND `email` LIKE '{$_SESSION['ef_email']}%' ";
		if(isset($_SESSION['ef_fname']) && $_SESSION['ef_fname']!="" ) $WHERE.=" AND `fname` LIKE '{$_SESSION['ef_fname']}%' ";
		if(isset($_SESSION['ef_lname']) && $_SESSION['ef_lname']!="" ) $WHERE.=" AND `lname` LIKE '{$_SESSION['ef_lname']}%' ";
		if(isset($_SESSION['ef_tel']) && $_SESSION['ef_tel']!="" ) $WHERE.=" AND `tel` LIKE '{$_SESSION['ef_tel']}%' ";
		if(isset($_SESSION['ef_source']) && $_SESSION['ef_source']!="" ) $WHERE.=" AND `source` LIKE '{$_SESSION['ef_source']}%' ";
		if(isset($_SESSION['ef_order_by']) && $_SESSION['ef_order_by']!="" ) $WHERE.="  ORDER BY `{$_SESSION['ef_order_by']}` ";




		$sql = 'SELECT * from `afs_form` '.$WHERE.'  LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';

		$sql_exporter = 'SELECT * from `afs_form` '.$WHERE.'  ';


		//echo $sql;
		$result = $mysql_db->sql_query($sql) or die($sql."<br/>".$mysql_db->sql_error_msg($result)) ;
		$no=$mysql_db->sql_numrows($result);

		$page_no=PageCount(MysqlGetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang(list_elist_form).':</p>' ;
		$List.= '<form method="post" action="" > <table class="adminlist" width="600">
		<tr class="header">
		<td width="10%">ID</td>
		<td width="15%">'._lang(email).'</td>
		<td width="15%">First Name</td>
		<td width="15%">Last Name</td>
		<td width="15%">Mobile</td>
		<td width="15%">Source</td>
		<td width="30%">'._lang(delete).'</td></tr>

		<tr class="header">
			<td width="10%"><input value="'.$_SESSION['ef_id'].'" type="text" style="width:50px;" name="id" />  </td>
			<td width="15%"><input value="'.$_SESSION['ef_email'].'" type="text" style="width:100px;" name="email" /></td>
			<td width="15%"><input value="'.$_SESSION['ef_fname'].'" type="text" style="width:100px;" name="fname" /></td>
			<td width="15%"><input value="'.$_SESSION['ef_lname'].'" type="text" style="width:100px;" name="lname" /></td>
			<td width="15%"><input value="'.$_SESSION['ef_tel'].'" type="text" style="width:100px;" name="tel" />
			<input type="submit" value="GO" /></td>
			<td width="15%"><select name="source" id="source" >
			<option value="">Any</option>
			'.ListOptions(elist_form::$sources,elist_form::$sources_values,$_SESSION['ef_source'],true) .'
			</select></td>
			<td width="15%">
			<select name="order_by" >
			'.ListOptions(array("Order by","ID/Date","First Name","Last Name","Email","Mobile"),array("","subscriberid","fname","lname","email","tel"),$_SESSION['ef_order_by'],true).'
			</select>
			</td>
		</tr>

		';
		while(($row = $mysql_db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[subscriberid].'</td>'.
			"<td width=\"15%\"><a href=\"?subscriberid=$row[subscriberid]&op=Edit\">$row[email]</a></td>".
			"<td width=\"15%\"><a href=\"?subscriberid=$row[subscriberid]&op=Edit\">$row[fname]</a></td>".
			"<td width=\"15%\"><a href=\"?subscriberid=$row[subscriberid]&op=Edit\">$row[lname]</a></td>".
			"<td width=\"15%\"><a href=\"?subscriberid=$row[subscriberid]&op=Edit\">$row[tel]</a></td>".
			"<td width=\"15%\"><a href=\"?subscriberid=$row[subscriberid]&op=Edit\">$row[source]</a></td>".
			"<td width=\"15%\"><a href=\"javascript:if (confirm('"._lang(sure_delete_elist_form)."')) {document.location ='?subscriberid=$row[subscriberid]&op=Delete';}\">Delete</a></td></tr> ";
		}
		$List.= '</form></table>';
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
		<label for="job_id">&nbsp;&nbsp;<b>'._lang(enter_subscriberid).':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="subscriberid" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang(sure_delete_elist_form).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';


		if($i>0)
		{

			$List.=
			'<div class="exporter">
				<form action="exporttocsv.php" method="post" >
				Delimited:
				<select name="delimited"><option value="comma">Comma ( , )</option><option value="tab">Tab</option><option value="semi">Semicolon(;)</option></select>

				<input name="sql" type="hidden" value="'.$sql_exporter.'" />
				<input type="submit" value="Dump CSV File" /></form>
				</div>';
		}
		return $List;


	}

	public static function IsExist($email)
	{
		global $mysql_db;
		$sql= 'SELECT `subscriberid` from `ss_list_subscribers` WHERE `emailaddress`="'.$email.'" AND  `listid`='.elist_form::LIST_ID ;
		$result = $mysql_db->sql_query($sql);
		if($row=$mysql_db->sql_fetchrow($result))
		return $row[0];
			else
		return false;
	}

}

?>