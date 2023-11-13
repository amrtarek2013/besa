<?php
class winner
{

	public  $win_id;
	public  $win_fname;
	public  $win_lname;
	public  $address;
	public  $suburb;
	public  $tel;
	public  $email;
	public  $vehicle;
	public  $trade_vehicle;
	public  $finance;
	public  $dont_send_mail;
	public  $dont_send_sms;
	public  $yard;
	public  $home_phone;
	public  $postcode;
	public  $comp_id;
	public  $source;
	
	
	public  $added_date;

	var  $Errors;


	public function SetValues($_win_id , $_win_fname , $_win_lname , $_address , $_suburb , $_tel , $_email , $_vehicle , $_trade_vehicle , $_finance , $_dont_send_mail ,$_dont_send_sms , $_yard , $_home_phone , $_postcode , $_comp_id , $_added_date)
	{
		$this->win_fname=$_win_fname;
		$this->win_lname=$_win_lname;
		$this->address=$_address;
		$this->suburb=$_suburb;
		$this->tel=$_tel;
		$this->email=$_email;
		$this->vehicle=$_vehicle;
		$this->trade_vehicle=$_trade_vehicle;
		$this->finance=$_finance;
		$this->dont_send_mail=$_dont_send_mail;
		$this->dont_send_sms=$_dont_send_sms;
		$this->yard=$_yard;
		$this->home_phone=$_home_phone;
		$this->postcode=$_postcode;
		$this->comp_id=$_comp_id;
		$this->added_date=$_added_date;

	}


	public function SelectFromDB($_win_id)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_win_id))
		{
			$this->Errors[]=_lang(invalid_win_id);
			return false;
		}
		$this->win_id=$_win_id;
		$sql = 'SELECT * FROM `winner` WHERE `win_id` = '.$_win_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_winner_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->win_fname=$row['win_fname'];
		$this->win_lname=$row['win_lname'];
		$this->address=$row['address'];
		$this->suburb=$row['suburb'];
		$this->tel=$row['tel'];
		$this->email=$row['email'];
		$this->vehicle=$row['vehicle'];
		$this->trade_vehicle=$row['trade_vehicle'];
		$this->finance=$row['finance'];
		$this->dont_send_mail=$row['dont_send_mail'];
		$this->dont_send_sms=$row['dont_send_sms'];
		$this->yard=$row['yard'];
		$this->home_phone=$row['home_phone'];
		$this->postcode=$row['postcode'];
		$this->comp_id=$row['comp_id'];
		$this->source=$row['source'];
		$this->added_date=$row['added_date'];
		return true;


	}

	public function Insert($admin=false)
	{

		global $db;
		
		if(blocked_number::IsBlocked($this->tel))
		{
			$this->Errors[]=_lang(invlid_mobile_number);
			return false;
		}

		if(!$admin && strtolower($_POST['security_code'])!=strtolower($_SESSION['security_code']))
		{
			$this->Errors[]=_lang(invalid_sec_code);
			return false;
		}
                if(!$admin && empty ($_POST['agree_terms_conditions']))
		{
			$this->Errors[]=_lang(not_agree_terms);
			return false;
		}
		$_SESSION['security_code']=md5(rand(0,1000));

		
		$this->yard=yards_postcode::GetYardFromPostCode($this->postcode);
		
		
		$sql = 'INSERT INTO `winner` (`win_fname`, `win_lname`, `address`, `suburb`, `tel`, `email`, `vehicle`, `trade_vehicle`, `finance`, `dont_send_mail`, `dont_send_sms`, `inital_dont_send_mail`, `yard`, `home_phone`, `postcode`, `comp_id`, `source`, `added_date`) VALUES (\''.PreSql($this->win_fname).'\',  \''.PreSql($this->win_lname).'\',  \''.PreSql($this->address).'\',  \''.PreSql($this->suburb).'\',  \''.PreSql($this->tel).'\',  \''.PreSql($this->email).'\',  \''.PreSql($this->vehicle).'\',  \''.PreSql($this->trade_vehicle).'\',  \''.PreSql($this->finance).'\',  \''.PreSql($this->dont_send_mail).'\', \''.PreSql($this->dont_send_mail).'\',  \''.PreSql($this->dont_send_mail).'\',  \''.$this->yard.'\',  \''.PreSql($this->home_phone).'\',  \''.PreSql($this->postcode).'\', \''.PreSql($this->comp_id).'\',  \''.PreSql($this->source).'\',  \''.date('Y-m-d').'\')';
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			if(strpos("  ".$this->Errors[0],"violates"))
			$this->Errors[0]=_lang("duplicate_entry");
			return false;
		}

		$this->win_id =  $db->sql_nextid("subscriber_id");
		return $this->win_id;
	}


	public function Add($admin=false)
	{
		global $predir;
		$op='Add';
		include $predir.'forms/fwinner.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `winner` WHERE `win_id`='.$this->win_id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update',$admin=false)
	{
		$win_id=PreForm($this->win_id);
		$win_fname=PreForm($this->win_fname);
		$win_lname=PreForm($this->win_lname);
		$address=PreForm($this->address);
		$suburb=PreForm($this->suburb);
		$tel=PreForm($this->tel);
		$email=PreForm($this->email);
		$vehicle=PreForm($this->vehicle);
		$trade_vehicle=PreForm($this->trade_vehicle);
		$finance=PreForm($this->finance);
		$dont_send_mail=PreForm($this->dont_send_mail);
		$dont_send_sms=PreForm($this->dont_send_sms);
		$yard=PreForm($this->yard);
		$home_phone=PreForm($this->home_phone);
		$postcode=PreForm($this->postcode);
		$comp_id=PreForm($this->comp_id);
		$source=PreForm($this->source);
		$added_date=PreForm($this->added_date);
		global $predir;

		$op=$_op;

		include $predir.'forms/fwinner.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `winner` SET `win_fname` = \''.PreSql($this->win_fname).'\', `win_lname` = \''.PreSql($this->win_lname).'\', `address` = \''.PreSql($this->address).'\', `suburb` = \''.PreSql($this->suburb).'\', `tel` = \''.PreSql($this->tel).'\', `email` = \''.PreSql($this->email).'\', `vehicle` = \''.PreSql($this->vehicle).'\', `trade_vehicle` = \''.PreSql($this->trade_vehicle).'\', `finance` = \''.PreSql($this->finance).'\', `dont_send_mail` = \''.PreSql($this->dont_send_mail).'\', `dont_send_sms` = \''.PreSql($this->dont_send_sms).'\', `yard` = \''.PreSql($this->yard).'\', `home_phone` = \''.PreSql($this->home_phone).'\', `postcode` = \''.PreSql($this->postcode).'\',  `comp_id` = \''.PreSql($this->comp_id).'\', `source` = \''.PreSql($this->source).'\' WHERE `win_id` = '.$this->win_id;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function SendEnquiryMail()
	{
		global $admin_mails;
		$msg .= "Suggest allocate this customer to yard {$this->yard} by their supplied postcode.\n\n";
		$msg .= _lang("enquery_id").": WIN$this->win_id\n";
		//$msg .= _lang("enquery_date").": $this->added_date\n";
		$msg .= "Heared about us source: $this->source\n";
		$msg .= "First name: $this->win_fname\n";
		$msg .= "Last Name: $this->win_lname\n";
		$msg .= "Postcode: $this->postcode\n";
		
		$msg .= "Mobile: $this->tel \n";
		$msg .= "Email: $this->email\n";
		$msg .= "Vehicle Required: $this->vehicle \n";
		$msg .= "Trade IN Vehicle: $this->trade_vehicle\n";
		$msg .= "Finance: $this->finance\n";

		$msg .= _lang("receive_mail").": ".(($this->dont_send_mail)?"No":"Yes") ."\n\n";
		$msg .= "\nThis email form was submitted from\n" . $_SERVER['HTTP_REFERER'] . "\n";

		MyMail(/*$admin_mails.",info@austfleetsales.com.au"*/'rebeccam@austfleetsales.com.au,sales@austfleetsales.com.au',_lang(winner_mail_subject),nl2br($msg), "From: rebeccam@austfleetsales.com.au\nReply-To: rebeccam@austfleetsales.com.au\nContent-Type: text/html",_lang(winner_mail_subject));
	}

	public function FromForm()
	{
		$this->win_id=PostForm($_POST['win_id']);
		$this->win_fname=PostForm($_POST['win_fname'],50);
		$this->win_lname=PostForm($_POST['win_lname'],50);
		$this->address=PostForm($_POST['address'],255);
		$this->suburb=PostForm($_POST['suburb'],50);
		$this->tel=str_replace(" ","",PostForm( $_POST['tel'],50));
		$this->email=PostForm($_POST['email'],255);
		$this->vehicle=PostForm($_POST['vehicle'],255);
		$this->trade_vehicle=PostForm($_POST['trade_vehicle'],255);
		$this->finance=PostForm($_POST['finance'],255);
		$this->dont_send_mail=PostForm($_POST['dont_send_mail']);
		$this->dont_send_sms=PostForm($_POST['dont_send_sms']);
		$this->yard=PostForm($_POST['yard']);
		$this->home_phone=PostForm($_POST['home_phone']);
		$this->postcode=PostForm($_POST['postcode']);
		$this->comp_id=PostForm($_POST['comp_id']);
		$this->source=PostForm($_POST['source']);

	}
	public static function AdminListwinners()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];

		if(isset($_GET['q_fname'])&&$_GET['q_fname']!="")
		$WHERE.=" AND lower(`win_fname`) LIKE lower('".$_GET['q_fname']."%') ";

		if(isset($_GET['q_lname'])&&$_GET['q_lname']!="")
		$WHERE.=" AND lower(`win_lname`) LIKE lower('".$_GET['q_lname']."%') ";

		if(isset($_GET['q_email'])&&$_GET['q_email']!="")
		$WHERE.=" AND lower(`email`) LIKE lower('".$_GET['q_email']."%') ";

		$sql = 'SELECT * FROM `winner` WHERE true '.$WHERE.'	ORDER BY `win_id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';


		$export_sql ='SELECT `win_id` as `'._lang(enquery_id).'` ,`added_date` as `'._lang(enquery_date).'` , `win_fname` as `First Name` ,`win_lname` as `Surame`, `address` as `Address`, `suburb` as `Suburb`, `email` as `Email Address`, `tel` as `home_phone`, `vehicle` as `Vehicle Required`,`trade_vehicle` as `Trade Vehicle`, `finance` as `Finance`,CASE WHEN `dont_send_mail` THEN \'no\' ELSE \'yes\' END as `'._lang(receive_mail).'` FROM `winner` WHERE true '.$WHERE.'	ORDER BY `win_id` DESC ';


		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<h3 class="admin_title">'._lang(list_winner).':</h3>' ;

		$List.= '<form action="" method="get" name="Filter" id="Filter" >
		<table class="adminlist" width="600"><tr class="header">
		<td width="10%">ID</td><td width="20%">'._lang(fname).'<br/><input class="filter" name="q_fname" type="text" value="'.$_GET['q_fname'].'" /> </td>
		<td width="20%">'._lang(lname).'<br/><input class="filter" name="q_lname" type="text" value="'.$_GET['q_lname'].'" /> </td>
		<td width="30%">'._lang(email).'<br/><input class="filter" name="q_email" type="text" value="'.$_GET['q_email'].'" /></td>
		<td width="20%">'._lang(delete).'<br/><input name="go" type="submit" value="Go" />
		<input name="Reset" type="button" onclick="document.Filter.q_lname.value=\'\';document.Filter.q_fname.value=\'\';document.Filter.q_email.value=\'\';document.Filter.submit()" value="All" /> 
		</td>
		</tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[win_id].'</td><td width="20%">'.
			"<a href=\"?win_id=$row[win_id]&op=Edit\">$row[win_fname]</a></td>".
			"<td width=\"20%\"><a href=\"?win_id=$row[win_id]&op=Edit\">$row[win_lname]</a></td>".
			"<td width=\"30%\"><a href=\"?win_id=$row[win_id]&op=Edit\">$row[email]</a></td>".
			"<td width=\"20%\"><a href=\"javascript:if (confirm('"._lang(sure_delete_winner)."')) {document.location ='?win_id=$row[win_id]&op=Delete';}\">Delete</a></td></tr> ";
		}
		$List.= '</table></form>';
		$List.="<div class=\"admin_list_control\">";
		if($admin_page>1)
		$List.= "&laquo; <a href=\"?q_fname={$_GET[q_fname]}&q_lname={$_GET[q_lname]}&q_email={$_GET[q_email]}&admin_page=".($admin_page-1)."\" >"._lang(list_previous_page)." $per_page </a>&nbsp;&nbsp; ";

		if($page_no>2)
		{
			$List.='<select onchange="document.location=\'?q_fname='.$_GET[q_fname].'&q_lname='.$_GET[q_lname].'&q_email='.$_GET[q_email].'&admin_page=\'+this.value;">';
			for($i=1;$i<=$page_no;$i++)
			{
				$sel="";
				if($admin_page==$i) $sel="selected";
				$List.='<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
			}
			$List.='</select>';
		}

		if($no>$per_page )
		$List.= "&nbsp;<a href=\"?q_fname={$_GET[q_fname]}&q_lname={$_GET[q_lname]}&q_email={$_GET[q_email]}&admin_page=".($admin_page+1)."\" > "._lang(list_next_page)." $per_page</a> &raquo;";

		$List.="</div><br/>";
		$List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
		<label for="job_id">&nbsp;&nbsp;<b>'._lang(enter_win_id).':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="win_id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang(sure_delete_winner).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';

		if($no>0)

		$List.='<input type="button" name="export" value="Export List To CSV" onclick="document.location=\'tocsv.php?file_name=register_to_win_users_'.date('Y-m-d').'&sql='.str_replace("'","\'",$export_sql).'\'" />
	<br/>';

		return $List;


	}

	public function SetAutoResponses()
	{
		global $email_autoresponse_time;
		$auto_mail= new send_email();
		//immediate
		$emails_count=15;

		if($this->dont_send_mail) $emails_count=4;

		for ($i=2;$i<$emails_count;$i++)
		{
			if(!$auto_mail->NewAutoEmail($i,$email_autoresponse_time[$i],$this->email,$this->win_fname,'win'.$this->win_id))
			{
				$this->Errors=$auto_mail->Errors;
				return false;
			}
		}
		return true;

	}
}

?>