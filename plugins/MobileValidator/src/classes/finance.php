<?php
class finance
{

	public  $fnc_id;
	public  $fnc_fname;
	public  $fnc_lname;
	public  $desc;
	public  $suburb;
	public  $tel;
	public  $email;
	public  $dont_send_mail;
	public  $dont_send_sms;
	public  $yard;
	public  $home_phone;
	public  $postcode;
	public  $tag4;
	public  $tag5;
	public  $tag6;
	public  $added_date;

	var  $Errors;


	public function SetValues($_fnc_id , $_fnc_fname , $_fnc_lname , $_desc , $_suburb , $_tel , $_email , $_tag5 , $_tag6 , $_added_date , $_dont_send_mail , $_yard , $_home_phone , $_postcode , $_tag4)
	{
		$this->fnc_fname=$_fnc_fname;
		$this->fnc_fname=$_fnc_fname;
		$this->fnc_lname=$_fnc_lname;
		$this->desc=$_desc;
		$this->suburb=$_suburb;
		$this->tel=$_tel;
		$this->email=$_email;
		$this->tag5=$_tag5;
		$this->tag6=$_tag6;
		$this->added_date=$_added_date;
		$this->dont_send_mail=$_dont_send_mail;
		$this->dont_send_sms=$_dont_send_sms;
		$this->yard=$_yard;
		$this->home_phone=$_home_phone;
		$this->postcode=$_postcode;
		$this->tag4=$_tag4;

	}


	public function SelectFromDB($_fnc_id)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_fnc_id))
		{
			$this->Errors[]=_lang(invalid_fnc_id);
			return false;
		}
		$this->fnc_id=$_fnc_id;
		$sql = 'SELECT * FROM `finance` WHERE `fnc_id` = '.$_fnc_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_finance_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->fnc_fname=$row['fnc_fname'];
		$this->fnc_lname=$row['fnc_lname'];
		$this->desc=$row['desc'];
		$this->suburb=$row['suburb'];
		$this->tel=$row['tel'];
		$this->email=$row['email'];
		$this->tag5=$row['tag5'];
		$this->tag6=$row['tag6'];
		$this->added_date=$row['added_date'];
		$this->dont_send_mail=$row['dont_send_mail'];
		$this->dont_send_sms=$row['dont_send_sms'];
		$this->yard=$row['yard'];
		$this->home_phone=$row['home_phone'];
		$this->postcode=$row['postcode'];
		$this->tag4=$row['tag4'];
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
		
		
		
		$_SESSION['security_code']=md5(rand(0,1000));
		$this->yard=yards_postcode::GetYardFromPostCode($this->postcode);
		
		$sql = 'INSERT INTO `finance` (`fnc_fname`, `fnc_lname`, `desc`, `suburb`, `tel`, `email`, `tag5`, `tag6`, `added_date`, `dont_send_mail`, `dont_send_sms`, `inital_dont_send_mail`, `yard`, `home_phone`, `postcode`,  `tag4`) VALUES (\''.PreSql($this->fnc_fname).'\',  \''.PreSql($this->fnc_lname).'\',  \''.PreSql($this->desc).'\',  \''.PreSql($this->suburb).'\',  \''.PreSql($this->tel).'\',  \''.PreSql($this->email).'\',  \''.PreSql($this->tag5).'\',  \''.PreSql($this->tag6).'\',  \''.date('Y-m-d').'\',  \''.PreSql($this->dont_send_mail).'\', \''.PreSql($this->dont_send_mail).'\',  \''.PreSql($this->dont_send_mail).'\', \''.$this->yard.'\',  \''.PreSql($this->home_phone).'\',  \''.PreSql($this->postcode).'\',  \''.PreSql($this->tag4).'\')';
		if(!$db->sql_query($sql))
		{
			echo "<!-- $sql -->";
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		
		$this->fnc_id=$db->sql_nextid("subscriber_id");
		return $this->fnc_id;
	}


	public function Add($admin=false)
	{
		global $predir;
		$op='Add';
		include $predir.'forms/ffinance.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `finance` WHERE `fnc_id`='.$this->fnc_id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update',$admin=false)
	{
		$fnc_id=PreForm($this->fnc_id);
		$fnc_fname=PreForm($this->fnc_fname);
		$fnc_lname=PreForm($this->fnc_lname);
		$desc=PreForm($this->desc);
		$suburb=PreForm($this->suburb);
		$tel=PreForm($this->tel);
		$email=PreForm($this->email);
		$tag5=PreForm($this->tag5);
		$tag6=PreForm($this->tag6);
		$added_date=PreForm($this->added_date);
		$dont_send_mail=PreForm($this->dont_send_mail);
		$dont_send_sms=PreForm($this->dont_send_sms);
		$yard=PreForm($this->yard);
		$home_phone=PreForm($this->home_phone);
		$postcode=PreForm($this->postcode);
		$tag4=PreForm($this->tag4);
		global $predir;
		$op=$_op;
		
		include $predir.'forms/ffinance.php';
	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `finance` SET `fnc_fname` = \''.PreSql($this->fnc_fname).'\', `fnc_lname` = \''.PreSql($this->fnc_lname).'\', `desc` = \''.PreSql($this->desc).'\', `suburb` = \''.PreSql($this->suburb).'\', `tel` = \''.PreSql($this->tel).'\', `email` = \''.PreSql($this->email).'\', `tag5` = \''.PreSql($this->tag5).'\', `tag6` = \''.PreSql($this->tag6).'\', `dont_send_mail` = \''.PreSql($this->dont_send_mail).'\', `dont_send_sms` = \''.PreSql($this->dont_send_sms).'\', `yard` = \''.PreSql($this->yard).'\', `home_phone` = \''.PreSql($this->home_phone).'\', `postcode` = \''.PreSql($this->postcode).'\', `tag4` = \''.PreSql($this->tag4).'\' WHERE `fnc_id` = '.$this->fnc_id;

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
		$msg .= _lang("enquery_id").": FIN$this->fnc_id\n";
		//$msg .= _lang("enquery_date").": $this->added_date\n";
		$msg .= "First name: $this->fnc_fname\n";
		$msg .= "Surname: $this->fnc_lname\n";
		$msg .= "Postcode: $this->postcode\n";
		$msg .= "Mobile: $this->tel \n";
		$msg .= "Email: $this->email\n\n";
		$msg .= _lang("receive_mail").": ".($this->dont_send_mail)?"No":"Yes" ."\n\n";
		$msg .= "Type of finance required:\n $this->desc \n\n";



		$msg .= "\nThis email form was submitted from\n" . $_SERVER['HTTP_REFERER'] . "\n";
		
		MyMail($admin_mails,_lang(finance_mail_subject),nl2br($msg), "From: $this->email\nReply-To: $this->email\nContent-Type: text/html",_lang(finance_mail_subject));
	}

	public function FromForm()
	{
		$this->fnc_id=PostForm($_POST['fnc_id']);
		$this->fnc_fname=PostForm($_POST['fnc_fname'],50);
		$this->fnc_lname=PostForm($_POST['fnc_lname'],50);
		$this->desc=PostForm($_POST['desc'],255);
		$this->suburb=PostForm($_POST['suburb'],50);
		$this->tel=str_replace(" ","",PostForm( $_POST['tel'],50));
		$this->email=PostForm($_POST['email'],255);
		$this->tag5=PostForm($_POST['tag5'],255);
		$this->tag6=PostForm($_POST['tag6'],255);
		$this->dont_send_mail=PostForm($_POST['dont_send_mail']);
		$this->dont_send_sms=PostForm($_POST['dont_send_sms']);
		$this->yard=PostForm($_POST['yard']);
		$this->home_phone=PostForm($_POST['home_phone']);
		$this->postcode=PostForm($_POST['postcode']);
		$this->tag4=PostForm($_POST['tag4']);

	}
	public static function AdminListfinances()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];

		if(isset($_GET['q_fname'])&&$_GET['q_fname']!="")
		$WHERE.=" AND lower(`fnc_fname`) LIKE lower('".$_GET['q_fname']."%') ";

		if(isset($_GET['q_lname'])&&$_GET['q_lname']!="")
		$WHERE.=" AND lower(`fnc_lname`) LIKE lower('".$_GET['q_lname']."%') ";

		if(isset($_GET['q_email'])&&$_GET['q_email']!="")
		$WHERE.=" AND lower(`email`) LIKE lower('".$_GET['q_email']."%') ";

		$sql = 'SELECT * FROM `finance` WHERE true '.$WHERE.'	ORDER BY `fnc_id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';

		$export_sql ='SELECT `fnc_id` as `'._lang(enquery_id).'` , `added_date` as `'._lang(enquery_date).'` ,  `fnc_fname` as `First Name` ,`fnc_lname` as `Surame`, `suburb` as `Suburb`, `email` as `Email Address`, `tel` as `Mobile`, `desc` as `Trade-In Description`,CASE WHEN `dont_send_mail` THEN \'no\' ELSE \'yes\' END as `'._lang(receive_mail).'` FROM `finance` WHERE true '.$WHERE.'	ORDER BY `fnc_id` DESC ';



		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<h3 class="admin_title">'._lang(list_finance).':</h3>' ;

		$List.= '<form action="" method="get" name="Filter" id="Filter" >
		<table class="adminlist" width="600"><tr class="header">
		<td width="10%">ID</td><td width="20%">'._lang(fname).'<br/><input class="filter" name="q_fname" type="text" value="'.$_GET['q_fname'].'" /> </td>
		<td width="20%">'._lang(lname).'<br/><input class="filter" name="q_lname" type="text" value="'.$_GET['q_lname'].'" /> </td>
		<td width="30%">'._lang(email).'<br/><input class="filter" name="q_email" type="text" value="'.$_GET['q_email'].'" /></td>
		<td width="20%"><input name="go" type="submit" value="Go" />
		<input name="Reset" type="button" onclick="document.Filter.q_lname.value=\'\';document.Filter.q_fname.value=\'\';document.Filter.q_email.value=\'\';document.Filter.submit()" value="All" /> '._lang(delete).'<br/>
		</td>
		</tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[fnc_id].'</td><td width="20%">'.
			"<a href=\"?fnc_id=$row[fnc_id]&op=Edit\">$row[fnc_fname]</a></td>".
			"<td width=\"20%\"><a href=\"?fnc_id=$row[fnc_id]&op=Edit\">$row[fnc_lname]</a></td>".
			"<td width=\"30%\"><a href=\"?fnc_id=$row[fnc_id]&op=Edit\">$row[email]</a></td>".
			"<td width=\"20%\"><a href=\"javascript:if (confirm('"._lang(sure_delete_finance)."')) {document.location ='?fnc_id=$row[fnc_id]&op=Delete';}\">Delete</a></td></tr> ";
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
		<label for="job_id">&nbsp;&nbsp;<b>'._lang(enter_fnc_id).':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="fnc_id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang(sure_delete_finance).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';

		if($no>0)
		$List.='<input type="button" name="export" value="Export List To CSV" onclick="document.location=\'tocsv.php?file_name=trade_in_'.date('Y-m-d').'&sql='.str_replace("'","\'",$export_sql).'\'" />
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
			if(!$auto_mail->NewAutoEmail($i,$email_autoresponse_time[$i],$this->email,$this->fnc_fname,'fnc'.$this->fnc_id))
			{
				$this->Errors=$auto_mail->Errors;
				return false;
			}
		}
		return true;
		
	}		

}

?>