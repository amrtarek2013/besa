<?php

class special {

	public $spc_id;
	public $spc_fname;
	public $spc_lname;
	public $desc;
	public $suburb;
	public $tel;
	public $email;
	public $dont_send_mail;
	public $dont_send_sms;
	public $yard;
	public $home_phone;
	public $postcode;
	public $tag4;
	public $tag5;
	public $tag6;
	public $added_date;
	var $Errors;
	public static $SErrors = [];

	public function SetValues($_spc_id, $_spc_fname, $_spc_lname, $_desc, $_suburb, $_tel, $_email, $_tag5, $_tag6, $_added_date, $_dont_send_mail, $_dont_send_sms, $_yard, $_home_phone, $_postcode, $_tag4) {
		$this->spc_fname = $_spc_fname;
		$this->spc_fname = $_spc_fname;
		$this->spc_lname = $_spc_lname;
		$this->desc = $_desc;
		$this->suburb = $_suburb;
		$this->tel = $_tel;
		$this->email = $_email;
		$this->tag5 = $_tag5;
		$this->tag6 = $_tag6;
		$this->added_date = $_added_date;
		$this->dont_send_mail = $_dont_send_mail;
		$this->dont_send_sms = $_dont_send_sms;
		$this->yard = $_yard;
		$this->home_phone = $_home_phone;
		$this->postcode = $_postcode;
		$this->tag4 = $_tag4;
	}

	public function SelectFromDB($_spc_id) {
		global $db;
		if (!ereg("^([0-9]+)$", $_spc_id)) {
			$this->Errors[] = _lang('invalid_spc_id');
			return false;
		}
		$this->spc_id = $_spc_id;
		$sql = 'SELECT * FROM `special` WHERE `spc_id` = ' . $_spc_id;
		if (!($result = $db->sql_query($sql))) {
			$this->Errors[] = $db->sql_error_msg($result);
			return false;
		}

		if ($db->sql_numrows($result) < 1) {
			$this->Errors[] = _lang('no_special_found');
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->spc_fname = $row['spc_fname'];
		$this->spc_lname = $row['spc_lname'];
		$this->desc = $row['desc'];
		$this->suburb = $row['suburb'];
		$this->tel = $row['tel'];
		$this->email = $row['email'];
		$this->tag5 = $row['tag5'];
		$this->tag6 = $row['tag6'];
		$this->added_date = $row['added_date'];
		$this->dont_send_mail = $row['dont_send_mail'];
		$this->dont_send_sms = $row['dont_send_sms'];
		$this->yard = $row['yard'];
		$this->home_phone = $row['home_phone'];
		$this->postcode = $row['postcode'];
		$this->tag4 = $row['tag4'];
		return true;
	}

	public function Insert($admin=false) {
		global $db;
		if (blocked_number::IsBlocked($this->tel)) {
			$this->Errors[] = _lang('invlid_mobile_number');
			return false;
		}

		if (!$admin && strtolower($_POST['security_code']) != strtolower($_SESSION['security_code'])) {
			$this->Errors[] = _lang('invalid_sec_code');
			return false;
		}
		$_SESSION['security_code'] = md5(rand(0, 1000));


		$this->yard = yards_postcode::GetYardFromPostCode($this->postcode);
		$sql = 'INSERT INTO `special` (`spc_fname`, `spc_lname`, `desc`, `suburb`, `tel`, `email`, `tag5`, `tag6`, `added_date`, `dont_send_mail`, `dont_send_sms`, `inital_dont_send_mail`, `yard`, `home_phone`, `postcode`,  `tag4`) VALUES (\'' . PreSql($this->spc_fname) . '\',  \'' . PreSql($this->spc_lname) . '\',  \'' . PreSql($this->desc) . '\',  \'' . PreSql($this->suburb) . '\',  \'' . PreSql($this->tel) . '\',  \'' . PreSql($this->email) . '\',  \'' . PreSql($this->tag5) . '\',  \'' . PreSql($this->tag6) . '\',  \'' . date('Y-m-d') . '\',  \'' . PreSql($this->dont_send_mail) . '\', \'' . PreSql($this->dont_send_mail) . '\',  \'' . PreSql($this->dont_send_mail) . '\', \'' . $this->yard . '\',  \'' . PreSql($this->home_phone) . '\',  \'' . PreSql($this->postcode) . '\',  \'' . PreSql($this->tag4) . '\')';
		if (!$db->sql_query($sql)) {
			$this->Errors[] = $db->sql_error_msg($result);
			return false;
		}

		$this->spc_id = $db->sql_nextid("subscriber_id");
		return $this->spc_id;
	}

	public function Add($admin=false) {
		global $predir;
		$op = 'Add';
		include $predir . 'forms/fspecial.php';
	}

	public function Delete() {
		global $db;

		$sql = 'DELETE FROM `special` WHERE `spc_id`=' . $this->spc_id;
		if (!$db->sql_query($sql)) {
			$this->Errors[] = $db->sql_error_msg($result);
			return false;
		}

		return true;
	}

	public function Edit($_op='Update', $admin=false) {
		$spc_id = PreForm($this->spc_id);
		$spc_fname = PreForm($this->spc_fname);
		$spc_lname = PreForm($this->spc_lname);
		$desc = PreForm($this->desc);
		$suburb = PreForm($this->suburb);
		$tel = PreForm($this->tel);
		$email = PreForm($this->email);
		$tag5 = PreForm($this->tag5);
		$tag6 = PreForm($this->tag6);
		$added_date = PreForm($this->added_date);
		$dont_send_mail = PreForm($this->dont_send_mail);
		$dont_send_sms = PreForm($this->dont_send_sms);
		$yard = PreForm($this->yard);
		$home_phone = PreForm($this->home_phone);
		$postcode = PreForm($this->postcode);
		$tag4 = PreForm($this->tag4);
		global $predir;

		$op = $_op;

		include $predir . 'forms/fspecial.php';
	}

	public function Update() {
		global $db;
		$sql = 'UPDATE `special` SET `spc_fname` = \'' . PreSql($this->spc_fname) . '\', `spc_lname` = \'' . PreSql($this->spc_lname) . '\', `desc` = \'' . PreSql($this->desc) . '\', `suburb` = \'' . PreSql($this->suburb) . '\', `tel` = \'' . PreSql($this->tel) . '\', `email` = \'' . PreSql($this->email) . '\', `tag5` = \'' . PreSql($this->tag5) . '\', `tag6` = \'' . PreSql($this->tag6) . '\', `dont_send_mail` = \'' . PreSql($this->dont_send_mail) . '\', `dont_send_sms` = \'' . PreSql($this->dont_send_sms) . '\', `yard` = \'' . PreSql($this->yard) . '\', `home_phone` = \'' . PreSql($this->home_phone) . '\', `postcode` = \'' . PreSql($this->postcode) . '\', `tag4` = \'' . PreSql($this->tag4) . '\' WHERE `spc_id` = ' . $this->spc_id;

		if (!$db->sql_query($sql)) {
			$this->Errors[] = $db->sql_error_msg($result);
			return false;
		}

		return true;
	}

	public function SendEnquiryMail() {
		global $admin_mails;
		$msg .= "Suggest allocate this customer to yard {$this->yard} by their supplied postcode.\n\n";
		$msg .= _lang("enquery_id") . ": SPC$this->spc_id\n";
		//$msg .= _lang("enquery_date").": $this->added_date\n";
		$msg .= "First name: $this->spc_fname\n";
		$msg .= "Surname: $this->spc_lname\n";
		$msg .= "Post code: $this->postcode\n";
		$msg .= "Mobile: $this->tel \n";
		$msg .= "Email: $this->email\n\n";
		$msg .= _lang("receive_mail") . ": " . (($this->dont_send_mail) ? "No" : "Yes") . "\n\n";
		$msg .= "Comments:\n $this->desc \n\n";



		$msg .= "\nThis email form was submitted from\n" . $_SERVER['HTTP_REFERER'] . "\n";

		MyMail($admin_mails, "Subscription to Weekly Specials List", nl2br($msg), "From: $this->email\nReply-To: $this->email\nContent-Type: text/html", "Subscription to Weekly Specials List");
	}

	public function FromForm() {
		$this->spc_id = PostForm($_POST['spc_id']);
		$this->spc_fname = PostForm($_POST['spc_fname'], 50);
		$this->spc_lname = PostForm($_POST['spc_lname'], 50);
		$this->desc = PostForm($_POST['desc'], 255);
		$this->suburb = PostForm($_POST['suburb'], 50);
		$this->tel = str_replace(" ", "", PostForm($_POST['tel'], 50));
		$this->email = PostForm($_POST['email'], 255);
		$this->tag5 = PostForm($_POST['tag5'], 255);
		$this->tag6 = PostForm($_POST['tag6'], 255);
		$this->dont_send_mail = PostForm($_POST['dont_send_mail']);
		$this->dont_send_sms = PostForm($_POST['dont_send_sms']);
		$this->yard = PostForm($_POST['yard']);
		$this->home_phone = PostForm($_POST['home_phone']);
		$this->postcode = PostForm($_POST['postcode']);
		$this->tag4 = PostForm($_POST['tag4']);
	}

	public static function AdminListspecials() {
		global $db, $list_per_page;
		$per_page = $list_per_page;
		if (!isset($_GET['admin_page']) || $_GET['admin_page'] < 1)
			$_GET['admin_page'] = 1;
		$admin_page = $_GET['admin_page'];

		if (isset($_GET['q_fname']) && $_GET['q_fname'] != "")
			$WHERE.=" AND lower(`spc_fname`) LIKE lower('" . $_GET['q_fname'] . "%') ";

		if (isset($_GET['q_lname']) && $_GET['q_lname'] != "")
			$WHERE.=" AND lower(`spc_lname`) LIKE lower('" . $_GET['q_lname'] . "%') ";

		if (isset($_GET['q_email']) && $_GET['q_email'] != "")
			$WHERE.=" AND lower(`email`) LIKE lower('" . $_GET['q_email'] . "%') ";

		$sql = 'SELECT * FROM `special` WHERE true ' . $WHERE . '	ORDER BY `spc_id` DESC LIMIT ' . (($admin_page - 1) * $per_page) . ',' . ($per_page + 1) . ' ';

		$export_sql = 'SELECT `spc_id` as `' . _lang(enquery_id) . '` , `added_date` as `' . _lang(enquery_date) . '` ,  `spc_fname` as `First Name` ,`spc_lname` as `Surame`, `suburb` as `Suburb`, `email` as `Email Address`, `tel` as `home_phone`, `desc` as `Trade-In Description`,CASE WHEN `dont_send_mail` THEN \'no\' ELSE \'yes\' END as `' . _lang(receive_mail) . '` FROM `special` WHERE true ' . $WHERE . '	ORDER BY `spc_id` DESC ';



		$result = $db->sql_query($sql) or die($sql . "<br/>" . $db->sql_error_msg($result));
		$no = $db->sql_numrows($result);

		$page_no = PageCount(GetUnlimitedCount($sql), $per_page);
		$List = '<h3 class="admin_title">' . _lang('list_special') . ':</h3>';

		$List.= '<form action="" method="get" name="Filter" id="Filter" >
			<table class="adminlist" width="600"><tr class="header">
			<td width="10%">ID</td><td width="20%">' . _lang('fname') . '<br/><input class="filter" name="q_fname" type="text" value="' . $_GET['q_fname'] . '" /> </td>
			<td width="20%">' . _lang('lname') . '<br/><input class="filter" name="q_lname" type="text" value="' . $_GET['q_lname'] . '" /> </td>
			<td width="30%">' . _lang('email') . '<br/><input class="filter" name="q_email" type="text" value="' . $_GET['q_email'] . '" /></td>
			<td width="20%"><input name="go" type="submit" value="Go" />
			<input name="Reset" type="button" onclick="document.Filter.q_lname.value=\'\';document.Filter.q_fname.value=\'\';document.Filter.q_email.value=\'\';document.Filter.submit()" value="All" /> ' . _lang('delete') . '<br/>
			</td>
			</tr> ';
		while (($row = $db->sql_fetchrow($result)) && $i < $per_page) {

			if ($i % 2.0 > 0)
				$class = "odd";
			else
				$class = "even";
			$i++;

			$List.= '<tr class="' . $class . '"><td width="10%">' . $row[spc_id] . '</td><td width="20%">' .
					"<a href=\"?spc_id=$row[spc_id]&op=Edit\">$row[spc_fname]</a></td>" .
					"<td width=\"20%\"><a href=\"?spc_id=$row[spc_id]&op=Edit\">$row[spc_lname]</a></td>" .
					"<td width=\"30%\"><a href=\"?spc_id=$row[spc_id]&op=Edit\">$row[email]</a></td>" .
					"<td width=\"20%\"><a href=\"javascript:if (confirm('" . _lang('sure_delete_special') . "')) {document.location ='?spc_id=$row[spc_id]&op=Delete';}\">Delete</a></td></tr> ";
		}
		$List.= '</table></form>';
		$List.="<div class=\"admin_list_control\">";
		if ($admin_page > 1)
			$List.= "&laquo; <a href=\"?q_fname={$_GET[q_fname]}&q_lname={$_GET[q_lname]}&q_email={$_GET[q_email]}&admin_page=" . ($admin_page - 1) . "\" >" . _lang('list_previous_page') . " $per_page </a>&nbsp;&nbsp; ";

		if ($page_no > 2) {
			$List.='<select onchange="document.location=\'?q_fname=' . $_GET[q_fname] . '&q_lname=' . $_GET[q_lname] . '&q_email=' . $_GET[q_email] . '&admin_page=\'+this.value;">';
			for ($i = 1; $i <= $page_no; $i++) {
				$sel = "";
				if ($admin_page == $i)
					$sel = "selected";
				$List.='<option value="' . $i . '" ' . $sel . '>' . $i . '</option>';
			}
			$List.='</select>';
		}

		if ($no > $per_page)
			$List.= "&nbsp;<a href=\"?q_fname={$_GET[q_fname]}&q_lname={$_GET[q_lname]}&q_email={$_GET[q_email]}&admin_page=" . ($admin_page + 1) . "\" > " . _lang('list_next_page') . " $per_page</a> &raquo;";

		$List.="</div><br/>";
		$List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
			<label for="job_id">&nbsp;&nbsp;<b>' . _lang('enter_spc_id') . ':</b></label>
			<input type="hidden" name="op" value="Edit" />
			<input type="text" name="spc_id" />
			<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
			<input onclick="if (confirm(\'' . _lang('sure_delete_special') . '\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
			</form>
			<br/>';

		if ($no > 0)
			$List.='<input type="button" name="export" value="Export List To CSV" onclick="document.location=\'tocsv.php?file_name=trade_in_' . date('Y-m-d') . '&sql=' . str_replace("'", "\'", $export_sql) . '\'" />
			<br/>';
		return $List;
	}

	public function SetAutoResponses() {
		global $email_autoresponse_time;
		$auto_mail = new send_email();
		//immediate
		for ($i = 2; $i < 15; $i++) {
			if (!$auto_mail->NewAutoEmail($i, $email_autoresponse_time[$i], $this->email, $this->spc_fname, 'SPC' . $this->spc_id)) {
				$this->Errors = $auto_mail->Errors;
				return false;
			}
		}
		return true;
	}

	public static function SendMailToSubscribers($msg_id=15, $time='now') {

		global $db, $site;

		$auto_mail = new send_email();

		$ref = date('Ymd') . 'AD';
		//if($msg_id!=15) $ref=$msg_id.date('Ymd');
		$time = strtotime($time);


		$sql = '
			INSERT INTO send_email

			select  Distinct ON (lower("email"))
			nextval(\'send_email_id_seq\'::regclass), ' . $msg_id . ', email,
				\'' . $ref . '\',NULL,NULL,fname,a1.subscriberid,NULL,
				' . $time . ' , NULL, ' . strtotime('now') . ' from afs_form a1 
				WHERE a1.subscriberid IN (select max(subscriberid) from afs_form a2 group by lower("email") ) 
				AND (dont_send_mail IS NULL OR dont_send_mail = false) 
				AND email NOT IN (select email_address from send_email WHERE ref_id=\'' . $ref . '\')  order by lower("email")';

		//$sql = "select  Distinct ON (\"email\") email,fname,dont_send_mail,stamp_time,table_name,subscriberid  from afs_form a1 WHERE a1.subscriberid IN (select max(subscriberid) from afs_form a2 group by email ) AND (dont_send_mail IS NULL OR dont_send_mail = false)  order by email";

		if (!$result = $db->sql_query($sql)) {
			special::$SErrors[] = $db->sql_error_msg($result);
			return false;
		}

		/* $i=0;
		  $sent=0;

		  $from=$site['from_mail'];
		  while($row=$db->sql_fetchrow($result))
		  {


		  if(!$id=$auto_mail->NewAutoEmail(15,strtotime('now'),$row['email'],$row['fname'],'SPC_PRESSAD'))
		  {
		  echo $row['subscriberid']."- ".$auto_mail->Errors."<br/>";
		  //return false;
		  }
		  if($id!=1)
		  $i++;
		  }

		  if(!$i)
		  {
		  special::$SErrors[]=_lang('no_subcibers_found');
		  } */



		return true;
	}

	public static function SendMailToSubscribersFromForm() {

		return special::SendMailToSubscribers(PostForm($_POST['msg_subject']), PostForm($_POST['msg_body']));
	}

	public static function SendMailToSubscribersForm() {
		global $predir;
		include($predir . 'forms/fsend_press_ad.php');
	}

	public static function GetSubscribersCount($source=false, $yard=false, $where='') {

		global $db;
		$sql = "SELECT COUNT(*) from afs_form a1 WHERE a1.subscriberid IN (select max(a2.subscriberid) from afs_form a2 group by a2.email ) AND (dont_send_mail IS NULL OR dont_send_mail = false)  " . ($where ? ' AND ' . $where : '');
		


		if ($source)
			$sql.=" AND (source= '" . $source . "' OR enquiry_type='" . $source . "' ) ";

		if ($yard)
			$sql.=" AND yard= '" . $yard . "'";



		if (!$result = $db->sql_query($sql)) {
			special::$SErrors[] = $db->sql_error_msg($result);
			return false;
		}
		$row = $db->sql_fetchrow($result);
		if (!$row[0]) {
			special::$SErrors[] = _lang('no_subcibers_found');

			return false;
		}

		return $row[0];
	}

	public static function Unsubscribe($email, $SK, &$unsubscribed_froms=null, &$first_id=null) {
		global $db, $predir;

		$email = strtolower(trim($email));

		$log = "\r\n-----------------------------------\r\n Time: " . date('Y-m-d H:i:s') . "\r\n";
		$log.="SET $email to don't receive the special emails\r\n";

		if (false/* $SK!=MyMD5($email) */) {
			$log.="Error: Invalid SK!\r\n";
			file_put_contents($predir . 'unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
			special::$SErrors[] = _lang('invalid_sec_code');

			return false;
		}
		$sql = "SELECT Distinct ON (\"email\") email,dont_send_mail,stamp_time,table_name,subscriberid,source  from afs_form a1 WHERE a1.subscriberid=(select max(subscriberid) from afs_form where lower(email) ='" . $email . "') AND (dont_send_mail IS NULL OR dont_send_mail = false) AND lower(email)='$email' ";
		if (!$result = $db->sql_query($sql)) {
			$log.="Error: SQL Error!\r\n" . $db->sql_error_msg($result) . "\r\n";
			special::$SErrors[] = $db->sql_error_msg($result);
			//file_put_contents($predir.'unsubscribe_log/'.date("Y-m").'.log',$log,FILE_APPEND);
			//return false;
		}




		if (!$row = $db->sql_fetchrow($result)) {
			$log.="Warning: The LAST found form for this user has disabled 'please send me special' !!\r\n";
		} else {
			elist_form::UnsubscribLogDB($row['subscriberid'], $row['source'], $email, false, isset($_GET['src']) && $_GET['src'] == 'elist');
		}

		$sql2 = "SELECT subscriberid,	source FROM afs_form WHERE  (lower(email)='$email' ) AND (dont_send_mail = false OR dont_send_mail IS NULL) ORDER by  subscriberid DESC ";
		$result = $db->sql_query($sql2);
		$affected = 0;
		while ($row = $db->sql_fetchrow($result)) {
			$unsubscribed_froms.=("<br/> {$row['source']} #" . $row['subscriberid']);
			$first_id = $row['subscriberid'];
			$affected++;
		}
		$log.="Found subscibed froms $unsubscribed_froms  \r\n";


		if (!$affected) {
			$affected = 0;
			
			special::$SErrors[] = _lang('not_subscribed');
		}




		$sql = elist_form::GenerateSqlForAllForms("UPDATE `{table_name}` SET dont_send_mail=true WHERE  (lower(email)='$email' ) AND (dont_send_mail = false OR dont_send_mail IS NULL)  ");
		$log.="Update all forms for this user set dont send mail = Yes  \r\n";


		if (!$result = $db->sql_query($sql)) {
			$log.="Error: SQL Error!\r\n $sql - " . $db->sql_error_msg($result) . "\r\n";
			file_put_contents($predir . 'unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
			special::$SErrors[] = $db->sql_error_msg($result);
			return false;
		}


		$log.="$affected forms were updated \r\n";
		file_put_contents($predir . 'unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
		return 1 + $affected;
	}

	public function UnsubscribeSMS($tel, &$unsubscribed_froms=null) {
		global $db, $predir;

		$tel = strtolower(trim($tel));

		$log = "\r\n-----------------------------------\r\n Time: " . date('Y-m-d H:i:s') . "\r\n";
		$log.="SET $tel to don't receive the special SMSs\r\n";


		$sql = "SELECT Distinct ON (\"tel\") tel,dont_send_sms,stamp_time,table_name,subscriberid,source  from afs_form a1 WHERE a1.subscriberid=(select max(subscriberid) from afs_form where lower(tel) ='" . $tel . "') AND (dont_send_sms IS NULL OR dont_send_sms = false) AND lower(tel)='$tel' ";
		if (!$result = $db->sql_query($sql)) {
			$log.="Error: SQL Error!\r\n" . $db->sql_error_msg($result) . "\r\n";
			special::$SErrors[] = $db->sql_error_msg($result);
			//file_put_contents($predir.'unsubscribe_log/'.date("Y-m").'.log',$log,FILE_APPEND);
			//return false;
		}




		if (!$row = $db->sql_fetchrow($result)) {
			$log.="Warning: The LAST found form for this user has disabled 'please send me special' !!\r\n";
		}
		else
			elist_form::UnsubscribLogDB($row['subscriberid'], $row['source'], $tel);


		$sql2 = "SELECT subscriberid,	source FROM afs_form WHERE  (lower(tel)='$tel' ) AND (dont_send_sms = false OR dont_send_sms IS NULL) ORDER by  subscriberid DESC ";
		$result = $db->sql_query($sql2);
		$affected = 0;
		while ($row = $db->sql_fetchrow($result)) {
			$unsubscribed_froms.=("<br/> {$row['source']} #" . $row['subscriberid']);

			$affected++;
		}
		$log.="Found subscibed froms $unsubscribed_froms  \r\n";


		if (!$affected) {
			$affected = 0;
			special::$SErrors[] = _lang('sms_not_subscribed');
		}




		$sql = elist_form::GenerateSqlForAllForms("UPDATE `{table_name}` SET dont_send_sms=true WHERE  (lower(tel)='$tel' ) AND (dont_send_sms = false OR dont_send_sms IS NULL)  ");
		$log.="Update all forms for this user set dont send sms = Yes  \r\n";


		if (!$result = $db->sql_query($sql)) {
			$log.="Error: SQL Error!\r\n $sql - " . $db->sql_error_msg($result) . "\r\n";
			file_put_contents($predir . 'unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
			special::$SErrors[] = $db->sql_error_msg($result);
			return false;
		}


		$log.="$affected forms were updated \r\n";
		file_put_contents($predir . 'unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
		return 1 + $affected;
	}

	public static function UnsubscribeEmail($email, $SK) {
		global $predir;
		//
		$email_to = "enquiry@austfleetsales.com.au";

		$log = "\r\n-----------------------------------\r\n Time: " . date('Y-m-d H:i:s') . "\r\n";
		$log.="$email ask for unsubscription\r\n";
		global $db, $site;
		if (false/* $SK!=MyMD5($email) */) {
			$log.="Error: invalide SK!!\r\n";
			special::$SErrors[] = _lang('invalid_sec_code');
			file_put_contents($predir . 'unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
			return false;
		}

		$sql = "select  Distinct ON (\"email\") email,dont_send_mail,stamp_time,table_name,subscriberid  from afs_form a1 WHERE a1.subscriberid=(select max(subscriberid) from afs_form where lower(email) ='" . strtolower($email) . "') AND (dont_send_mail IS NULL OR dont_send_mail = false) AND lower(email)='" . strtolower($email) . "' ";
		if (!$result = $db->sql_query($sql)) {
			$log.="Error: SQL Error!\r\n" . $db->sql_error_msg($result) . "\r\n";
			special::$SErrors[] = $db->sql_error_msg($result);
			//file_put_contents($predir.'unsubscribe_log/'.date("Y-m").'.log',$log,FILE_APPEND);
			//return false;
		}
		if (!$row = $db->sql_fetchrow($result)) {
			$log.="Warning: The LAST found form for this user has disabled 'please send me special' !!\r\n";
			send_email::UnsubscribeMail($email, $SK);
			self::Unsubscribe($email, $SK);

			//echo "!";
			MyMail($email_to, "Unsubscribe #" . $row['subscriberid'], 'User with email ' . $email . ' would like to unsubscribe. <br/> and he seems to be already ubsubscribed  ', "From: info@austfleetsales.com.au\nReply-To: info@austfleetsales.com.au\nContent-Type: text/html");

			//return true;
			//special::$SErrors[]=_lang(not_subscribed);
			//return false; 
			file_put_contents($predir . 'unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
			return true;
		}
		$email = $row['email'];

		$unsub_url = $site['url'] . '/admin/elist_form.php?op=Unsubscribe&email=' . $email . '&SK=' . MyMD5($email);

		MyMail($email_to, "Unsubscribe #" . $row['subscriberid'], 'User# ' . $row['subscriberid'] . ' would like to unsubscribe. <br/>  ' . $email . '<br/><a href="' . $unsub_url . '">Click Here To Unsubscribe</a>"', "From: info@austfleetsales.com.au\nReply-To: info@austfleetsales.com.au\nContent-Type: text/html");
		$log.="Email Sent to admin ($email_to) ask for unsubscribe\r\n";

		file_put_contents($predir . 'unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);

		return true;
	}

	public static function ShowStatitsTable() {
		global $db;
		$sql = "
			SELECT to_char(stamp_time, 'YYYY-MM') AS \"month_year\"   , COUNT(distinct email), 
		SUM(case when enquiry_type='book_your_free_4wd_training_day'  then 1 else 0 end )AS \"book_your_free_4wd_training_day\" , 
		SUM(case when enquiry_type='finance' then 1 else 0 end )AS \"finance\",
		SUM(case when enquiry_type='trade-in' then 1 else 0 end )AS \"trade-in\",
		SUM(case when enquiry_type='10k comp' then 1 else 0 end )AS \"10k comp\",
		SUM(case when enquiry_type='offer' then 1 else 0 end )AS \"offer\",
		SUM(case when enquiry_type='car' then 1 else 0 end )AS \"car\",
		SUM(case when enquiry_type='special' and added_date <='2010-08-03' then 1 else 0 end )AS \"special\",
		SUM(case when enquiry_type='special' and added_date >'2010-08-03' then 1 else 0 end )AS \"hot_stock\",
		SUM(case when enquiry_type='subscriber' then 1 else 0 end )AS \"subscriber\",
		SUM(case when enquiry_type='book_service' then 1 else 0 end )AS \"book_service\",
		SUM(case when enquiry_type='discounted_cars' then 1 else 0 end )AS \"discounted_cars\",
		SUM(case when enquiry_type='deal_beater' then 1 else 0 end )AS \"deal_beater\",
		SUM(case when enquiry_type='online-trade-in-valuation' then 1 else 0 end )AS \"online-trade-in-valuation\",
		SUM(case when enquiry_type='credit_doctor' then 1 else 0 end )AS \"credit_doctor\",
		SUM(case when enquiry_type='service-warranty' then 1 else 0 end )AS \"service-warranty\",
		SUM(case when enquiry_type='customer_relations' then 1 else 0 end )AS \"customer_relations\",
		SUM(case when enquiry_type='service-quote' then 1 else 0 end ) AS \"service-quote\",
		SUM(case when enquiry_type='car_offer' then 1 else 0 end ) AS \"car_offer\",
		";

		foreach (elist_form::$yards as $y) {
			$sql .= "SUM(case when table_name='elist_form' AND yard='$y' then 1 else 0 end )AS \"$y\",";
		}

		$sql .= "SUM(case when enquiry_type='internet' then 1 else 0 end )AS \"internet\"

			from afs_form a1 WHERE (inital_dont_send_mail=false OR inital_dont_send_mail IS NULL)
			AND a1.subscriberid IN (select max(subscriberid) from afs_form a2 WHERE inital_dont_send_mail=false OR inital_dont_send_mail IS NULL GROUP BY a2.email)  group by to_char(stamp_time, 'YYYY-MM') 		

			";
		/* @var $db sql_db */
		if (!$result = $db->sql_query($sql)) {
			special::$SErrors[] = $db->sql_error_msg($result);
			echo $sql . "<br/>";
			return false;
		}

		while ($row = $db->sql_fetchrow($result)) {
			$rows[$row['month_year']] = $row;
		}
		
		$db->sql_freeresult();

		$searchCount = "SELECT count(*) as c, to_char(created, 'YYYY-MM') AS month_year FROM search_records GROUP BY month_year ORDER BY month_year";
		$searchResult = $db->sql_query($searchCount);
		$searchRows = array();
		$totalCount = 0;
		
		while ($searchRow = $db->sql_fetchrow($searchResult)) {
			$searchRows[$searchRow['month_year']] = $searchRow;
			$totalCount += $searchRow['c'];
		}
		$db->sql_freeresult();
		
		$monthsResult = $db->sql_query("SELECT to_char(virtual_date, 'YYYY-MM-01') as vdate FROM virtual_date WHERE to_char(virtual_date, 'YYYY-MM-01') <= to_char(NOW(), 'YYYY-MM-01')");
		$monthes = array();
		while ($monthRow = $db->sql_fetchrow($monthsResult)){
			$vdate = date("Y-m", strtotime($monthRow['vdate']));
			$monthes[$vdate] = date("M\nY", strtotime($monthRow['vdate']));
		}

		include('../templates/subscriber_statistics.php');
		return true;
	}

	public static function GetAdStatus($type) {
		global $predir;
		return file_get_contents($predir . 'admin/' . $type . '_ad_status.ini');
	}

	public static function SetAdStatus($type, $thursday_ad_status) {
		global $predir;
		if (!file_put_contents($predir . 'admin/' . $type . '_ad_status.ini', $thursday_ad_status)) {
			special::$SErrors[] = _lang('thursday_ad_status_error');
			return false;
		}
		return true;
	}

	public function UpdateAdStatus() {
		return /* special::SetAdStatus('monday',$_POST['monday_ad_status']) */ special::SetAdStatus('thursday', $_POST['thursday_ad_status']) &&
				special::SetAdStatus('hotdeals', $_POST['hotdeals_ad_status']) &&
				special::SetAdStatus('belowcars', $_POST['belowcars_ad_status']);
	}

	public function EditAdStatus() {
		$thursday_ad_status = special::GetAdStatus('thursday');
		$hotdeals_ad_status = special::GetAdStatus('hotdeals');
		$belowcars_ad_status = special::GetAdStatus('belowcars');
		include($GLOBALS['predir'] . 'forms/fthursday_ad_status.php');
	}

}

?>
