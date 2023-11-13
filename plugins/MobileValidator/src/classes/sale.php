<?php
class sale
{

	public  $sale_id;
	public  $sale_fname;
	public  $sale_lname;
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
	public  $stock_no;
	public  $added_date;

	var  $Errors;


	public function SetValues($_sale_id , $_sale_fname , $_sale_lname , $_desc , $_suburb , $_tel , $_email , $_tag5 , $_stock_no , $_added_date , $_dont_send_mail ,$_dont_send_sms , $_yard , $_home_phone , $_postcode , $_tag4)
	{
		$this->sale_fname=$_sale_fname;
		$this->sale_fname=$_sale_fname;
		$this->sale_lname=$_sale_lname;
		$this->desc=$_desc;
		$this->suburb=$_suburb;
		$this->tel=$_tel;
		$this->email=$_email;
		$this->tag5=$_tag5;
		$this->stock_no=$_stock_no;
		$this->added_date=$_added_date;
		$this->dont_send_mail=$_dont_send_mail;
		$this->dont_send_sms=$_dont_send_sms;
		$this->yard=$_yard;
		$this->home_phone=$_home_phone;
		$this->postcode=$_postcode;
		$this->tag4=$_tag4;

	}


	public function SelectFromDB($_sale_id)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_sale_id))
		{
			$this->Errors[]=_lang(invalid_sale_id);
			return false;
		}
		$this->sale_id=$_sale_id;
		$sql = 'SELECT * FROM `sale` WHERE `sale_id` = '.$_sale_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_sale_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->sale_fname=$row['sale_fname'];
		$this->sale_lname=$row['sale_lname'];
		$this->desc=$row['desc'];
		$this->suburb=$row['suburb'];
		$this->tel=$row['tel'];
		$this->email=$row['email'];
		$this->tag5=$row['tag5'];
		$this->stock_no=$row['stock_no'];
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
		$sql = 'INSERT INTO `sale` (`sale_fname`, `sale_lname`, `desc`, `suburb`, `tel`, `email`, `tag5`, `stock_no`, `added_date`, `dont_send_mail`, `dont_send_sms`, `inital_dont_send_mail`, `yard`, `home_phone`, `postcode`,  `tag4`) VALUES (\''.PreSql($this->sale_fname).'\',  \''.PreSql($this->sale_lname).'\',  \''.PreSql($this->desc).'\',  \''.PreSql($this->suburb).'\',  \''.PreSql($this->tel).'\',  \''.PreSql($this->email).'\',  \''.PreSql($this->tag5).'\',  \''.PreSql($this->stock_no).'\',  \''.date('Y-m-d').'\',  \''.PreSql($this->dont_send_mail).'\', \''.PreSql($this->dont_send_mail).'\', \''.PreSql($this->dont_send_mail).'\',  \''.$this->yard.'\',  \''.PreSql($this->home_phone).'\',  \''.PreSql($this->postcode).'\',  \''.PreSql($this->tag4).'\')';
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		$this->sale_id=$db->sql_nextid("subscriber_id");
		return $this->sale_id;
	}


	public function Add($stock_no,$admin=false)
	{
		global $predir;
		$op='Add';
		include $predir.'forms/fsale.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `sale` WHERE `sale_id`='.$this->sale_id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update',$admin=false)
	{
		$sale_id=PreForm($this->sale_id);
		$sale_fname=PreForm($this->sale_fname);
		$sale_lname=PreForm($this->sale_lname);
		$desc=PreForm($this->desc);
		$suburb=PreForm($this->suburb);
		$tel=PreForm($this->tel);
		$email=PreForm($this->email);
		$tag5=PreForm($this->tag5);
		$stock_no=PreForm($this->stock_no);
		$added_date=PreForm($this->added_date);
		$dont_send_mail=PreForm($this->dont_send_mail);
		$dont_send_sms=PreForm($this->dont_send_sms);
		$yard=PreForm($this->yard);
		$home_phone=PreForm($this->home_phone);
		$postcode=PreForm($this->postcode);
		$tag4=PreForm($this->tag4);
		global $predir;

		$op=$_op;

		include $predir.'forms/fsale.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `sale` SET `sale_fname` = \''.PreSql($this->sale_fname).'\', `sale_lname` = \''.PreSql($this->sale_lname).'\', `desc` = \''.PreSql($this->desc).'\', `suburb` = \''.PreSql($this->suburb).'\', `tel` = \''.PreSql($this->tel).'\', `email` = \''.PreSql($this->email).'\', `tag5` = \''.PreSql($this->tag5).'\', `stock_no` = \''.PreSql($this->stock_no).'\', `dont_send_mail` = \''.PreSql($this->dont_send_mail).'\', `dont_send_sms` = \''.PreSql($this->dont_send_sms).'\', `yard` = \''.PreSql($this->yard).'\', `home_phone` = \''.PreSql($this->home_phone).'\', `postcode` = \''.PreSql($this->postcode).'\', `tag4` = \''.PreSql($this->tag4).'\' WHERE `sale_id` = '.$this->sale_id;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}
	
	
	public function SendAutoResponseMail()
	{
		$from="info@austfleetsales.com.au";
		$msg .= _lang("enquery_id").": SAL$this->sale_id\n\n";
		$msg .='<div align="center"><b>Thank you. One of our team will contact you shortly. Print this and visit any one of our dealerships within 48 hours and we\'ll give you a free sun breaker for your car, even if you don\'t purchase a car from us. </b></div><br/>
		<a href="http://www.australianfleetsales.com.au/dealerships.php">click here</a> to view dealerships list<br/>';
		MyMail($this->email,"Thank you",nl2br($msg), "From: $from\nReply-To: $from\nContent-Type: text/html","Thank you");
	}


	public function SendEnquiryMail()
	{
		global $admin_mails;
		$msg .= "Suggest allocate this customer to yard {$this->yard} by their supplied postcode.\n\n";
		$msg .= _lang("enquery_id").": SAL$this->sale_id\n";
		//$msg .= _lang("enquery_date").": $this->added_date\n";
		$msg .= "Stock No.: $this->stock_no\n";
		$msg .= "First name: $this->sale_fname\n";
		$msg .= "Last Name: $this->sale_lname\n";
		$msg .= "Post code: $this->postcode\n";
		$msg .= "Mobile: $this->tel \n";
		$msg .= "Email: $this->email\n\n";
		$msg .= _lang("receive_mail").": ".(($this->dont_send_mail)?"No":"Yes") ."\n\n";
		$msg .= "Comment:\n $this->desc \n\n";



		$msg .= "\nThis email form was submitted from\n" . $_SERVER['HTTP_REFERER'] . "\n";
		
		MyMail($admin_mails,_lang(sale_mail_subject),nl2br($msg), "From: $this->email\nReply-To: $this->email\nContent-Type: text/html",_lang(sale_mail_subject));
	}

	public function FromForm()
	{
		$this->sale_id=PostForm($_POST['sale_id']);
		$this->sale_fname=PostForm($_POST['sale_fname'],50);
		$this->sale_lname=PostForm($_POST['sale_lname'],50);
		$this->desc=PostForm($_POST['desc'],255);
		$this->suburb=PostForm($_POST['suburb'],50);
		$this->tel=str_replace(" ","",PostForm( $_POST['tel'],50));
		$this->email=PostForm($_POST['email'],255);
		$this->tag5=PostForm($_POST['tag5'],255);
		$this->stock_no=PostForm($_POST['stock_no'],255);
		$this->dont_send_mail=PostForm($_POST['dont_send_mail']);
		$this->dont_send_sms=PostForm($_POST['dont_send_sms']);
		$this->yard=PostForm($_POST['yard']);
		$this->home_phone=PostForm($_POST['home_phone']);
		$this->postcode=PostForm($_POST['postcode']);
		$this->tag4=PostForm($_POST['tag4']);

	}
	public static function AdminListsales()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];

		if(isset($_GET['q_fname'])&&$_GET['q_fname']!="")
		$WHERE.=" AND lower(`sale_fname`) LIKE lower('".$_GET['q_fname']."%') ";

		if(isset($_GET['q_lname'])&&$_GET['q_lname']!="")
		$WHERE.=" AND lower(`sale_lname`) LIKE lower('".$_GET['q_lname']."%') ";

		if(isset($_GET['q_email'])&&$_GET['q_email']!="")
		$WHERE.=" AND lower(`email`) LIKE lower('".$_GET['q_email']."%') ";

		$sql = 'SELECT * FROM `sale` WHERE true '.$WHERE.'	ORDER BY `sale_id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';

		$export_sql ='SELECT `sale_id` as `'._lang(enquery_id).'` , `added_date` as `'._lang(enquery_date).'` ,  `sale_fname` as `First Name` ,`sale_lname` as `Surame`, `suburb` as `Suburb`, `email` as `Email Address`, `tel` as `Mobile`, `desc` as `Trade-In Description`,CASE WHEN `dont_send_mail` THEN \'no\' ELSE \'yes\' END as `'._lang(receive_mail).'` FROM `sale` WHERE true '.$WHERE.'	ORDER BY `sale_id` DESC ';



		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<h3 class="admin_title">'._lang(list_sale).':</h3>' ;

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

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[sale_id].'</td><td width="20%">'.
			"<a href=\"?sale_id=$row[sale_id]&op=Edit\">$row[sale_fname]</a></td>".
			"<td width=\"20%\"><a href=\"?sale_id=$row[sale_id]&op=Edit\">$row[sale_lname]</a></td>".
			"<td width=\"30%\"><a href=\"?sale_id=$row[sale_id]&op=Edit\">$row[email]</a></td>".
			"<td width=\"20%\"><a href=\"javascript:if (confirm('"._lang(sure_delete_sale)."')) {document.location ='?sale_id=$row[sale_id]&op=Delete';}\">Delete</a></td></tr> ";
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
		<label for="job_id">&nbsp;&nbsp;<b>'._lang(enter_sale_id).':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="sale_id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang(sure_delete_sale).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
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
			if(!$auto_mail->NewAutoEmail($i,$email_autoresponse_time[$i],$this->email,$this->sale_fname,'sale'.$this->sale_id))
			{
				$this->Errors=$auto_mail->Errors;
				return false;
			}
		}
		return true;
		
	}	

}

?>