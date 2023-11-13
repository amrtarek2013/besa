<?php

class send_sms {

	public $id;
	public $msg_id;
	public $added_time;
	public $send_time;
	public $mobile_no;
	public $ref_id;
	public $is_sent;
	public $real_sent_time;
	public $sent_status;
	public $tag2;
	//has exported
	public $tag3;
	var $Errors;
	public static $SErrors;

	public function NewAutoSms($msg_id, $send_after_minutes, $mobile_no, $ref_id, $is_sent = false, $real_sent_time = false) {
		global $db;

		$msg = new sms_msg();
		$msg->SelectFromDB($msg_id);
		
//		if (!$msg->tag1) {
//			return false;
//		}
		$minmum_gap_minutes = $msg->minimum_gab;


		//See if there is  a message which will be sent before the gap, so dont add this message
		$sql = "SELECT COUNT(*) FROM `send_sms` WHERE `mobile_no`='$mobile_no' AND `msg_id`='$msg_id' AND `send_time`+" . ($minmum_gap_minutes * 60) . " > " . (time() + $send_after * 60) . "   ";
		$result = $db->sql_query($sql) or die($db->sql_error_msg($result));
		$row = $db->sql_fetchrow($result);
		if ($row[0] > 0) {
			return false;
		} else {
			$this->SetValues(false, $msg_id, time(), time() + $send_after_minutes * 60, $mobile_no, $ref_id, $is_sent, false, false, false, $real_sent_time);
			return $this->Insert();
		}
	}

	public function SetValues($_id = false, $_msg_id = false, $_added_time = false, $_send_time = false, $_mobile_no = false, $_ref_id = false, $_is_sent = false, $_sent_status = false, $_tag2 = false, $_tag3 = false, $_real_sent_time = false) {
		$this->msg_id = $_msg_id;
		$this->added_time = $_added_time;
		$this->send_time = $_send_time;
		$this->mobile_no = $_mobile_no;
		$this->ref_id = $_ref_id;
		$this->sent_status = $_sent_status;
		$this->tag2 = $_tag2;
		$this->tag3 = $_tag3;
		$this->is_sent = $_is_sent;
		$this->real_sent_time = $_real_sent_time;
	}

	public function SelectFromDB($_id) {
		global $db;
		if (!ereg("^([0-9]+)$", $_id)) {
			$this->Errors[] = _lang(invalid_id);
			return false;
		}
		$this->id = $_id;
		$sql = 'SELECT * FROM `send_sms` WHERE `id` = ' . $_id;
		if (!($result = $db->sql_query($sql))) {
			$this->Errors[] = $db->sql_error_msg($result);
			return false;
		}

		if ($db->sql_numrows($result) < 1) {
			$this->Errors[] = _lang(no_send_sms_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->msg_id = $row['msg_id'];
		$this->added_time = $row['added_time'];
		$this->send_time = $row['send_time'];
		$this->mobile_no = $row['mobile_no'];
		$this->ref_id = $row['ref_id'];
		$this->is_sent = $row['is_sent'];
		$this->real_sent_time = $row['real_sent_time'];
		$this->sent_status = $row['sent_status'];
		$this->tag2 = $row['tag2'];
		$this->tag3 = $row['tag3'];
		return true;
	}

	public function Insert() {
		global $db;
		$sql = 'INSERT INTO `send_sms` (`msg_id`, `added_time`, `send_time`, `mobile_no`, `ref_id`, `is_sent`, `real_sent_time`, `sent_status`, `tag2`,  `tag3`) VALUES (\'' . PreSql($this->msg_id) . '\',  \'' . PreSql($this->added_time) . '\',  \'' . PreSql($this->send_time) . '\',  \'' . PreSql($this->mobile_no) . '\',  \'' . PreSql($this->ref_id) . '\',  \'' . PreSql($this->is_sent) . '\',  \'' . PreSql($this->real_sent_time) . '\',  \'' . PreSql($this->sent_status) . '\',  \'' . PreSql($this->tag2) . '\',  \'' . PreSql($this->tag3) . '\')';
		if (!$db->sql_query($sql)) {
			$this->Errors[] = $db->sql_error_msg($result);
			return false;
		}

		return $db->sql_nextid();
	}

	public function Add() {
		$op = 'Add';
		include '../forms/fsend_sms.php';
	}

	public function Delete() {
		global $db;

		$sql = 'DELETE FROM `send_sms` WHERE `id`=' . $this->id;
		if (!$db->sql_query($sql)) {
			$this->Errors[] = $db->sql_error_msg($result);
			return false;
		}

		return true;
	}

	public function Edit($_op = 'Update') {
		$id = PreForm($this->id);
		$msg_id = PreForm($this->msg_id);
		$added_time = PreForm($this->added_time);
		$send_time = PreForm($this->send_time);
		$mobile_no = PreForm($this->mobile_no);
		$ref_id = PreForm($this->ref_id);
		$is_sent = PreForm($this->is_sent);
		$real_sent_time = PreForm($this->real_sent_time);
		$sent_status = PreForm($this->sent_status);
		$tag2 = PreForm($this->tag2);
		$tag3 = PreForm($this->tag3);

		$op = $_op;

		include '../forms/fsend_sms.php';
	}

	public function Update() {
		global $db;
		$sql = 'UPDATE `send_sms` SET `msg_id` = \'' . PreSql($this->msg_id) . '\', `added_time` = \'' . PreSql($this->added_time) . '\', `send_time` = \'' . PreSql($this->send_time) . '\', `mobile_no` = \'' . PreSql($this->mobile_no) . '\', `ref_id` = \'' . PreSql($this->ref_id) . '\', `is_sent` = \'' . PreSql($this->is_sent) . '\', `real_sent_time` = \'' . PreSql($this->real_sent_time) . '\', `sent_status` = \'' . PreSql($this->sent_status) . '\', `tag2` = \'' . PreSql($this->tag2) . '\', `tag3` = \'' . PreSql($this->tag3) . '\' WHERE `id` = ' . $this->id;

		if (!$db->sql_query($sql)) {
			$this->Errors[] = $db->sql_error_msg($result);
			return false;
		}

		return true;
	}

	public function FromForm() {
		$this->id = PostForm($_POST['id']);
		$this->msg_id = PostForm($_POST['msg_id']);
		$this->added_time = PostForm($_POST['added_time']);
		$this->send_time = PostForm($_POST['send_time']);
		$this->mobile_no = PostForm($_POST['mobile_no']);
		$this->ref_id = PostForm($_POST['ref_id']);
		$this->is_sent = PostForm($_POST['is_sent']);
		$this->real_sent_time = PostForm($_POST['real_sent_time']);
		$this->sent_status = PostForm($_POST['sent_status']);
		$this->tag2 = PostForm($_POST['tag2']);
		$this->tag3 = PostForm($_POST['tag3']);
	}

	public static function AdminListsend_smss() {
		global $db, $list_per_page;
		$per_page = $list_per_page;
		if (!isset($_GET['admin_page']) || $_GET['admin_page'] < 1)
			$_GET['admin_page'] = 1;
		$admin_page = $_GET['admin_page'];
		$sql = 'SELECT * FROM `send_sms`,`sms_msg` WHERE `send_sms`.`msg_id`=`sms_msg`.`msg_id`  ORDER BY `send_time` DESC LIMIT ' . (($admin_page - 1) * $per_page) . ',' . ($per_page + 1) . ' ';

		$result = $db->sql_query($sql) or die($sql . "<br/>" . $db->sql_error_msg($result));
		$no = $db->sql_numrows($result);

		$page_no = PageCount(GetUnlimitedCount($sql), $per_page);
		//$List= '<p class="admin_title">'._lang(list_send_sms).':</p>' ;
		$List.= '<table class="adminlist" width="700">
		<tr class="header">
		<!--<td width="10%">ID</td>-->
		<td width="15%">' . _lang(mobile_no) . '</td>
		<td width="20%">Added Time</td>
		<td width="20%">Time To Be Sent</td>
		<td width="20%">Real Sent Time</td>
		<td width="15%">MSG</td>
		<td width="20%">Ref</td>
		<td width="20%">Sent</td>
		</tr> ';
		while (($row = $db->sql_fetchrow($result)) && $i < $per_page) {

			if ($i % 2.0 > 0)
				$class = "odd";
			else
				$class = "even";
			$i++;

			$List.= '<tr class="' . $class . '">
			<!--<td width="10%">' . $row[id] . '</td>-->' .
					"<td width=\"15%\">{$row[mobile_no]}</td>" .
					"<td width=\"20%\">" . date("d-m-Y H:i", $row[added_time]) . "</td>" .
					"<td width=\"20%\">" . ($row[send_time] ? date("d-m-Y H:i", $row[send_time]) : "-") . "</td>" .
					"<td width=\"20%\">" . ($row[real_sent_time] ? date("d-m-Y H:i", $row[real_sent_time]) : "-") . "</td>" .
					"<td width=\"15%\">{$row[msg_title]}</td>" .
					"<td width=\"20%\">" . CutLongerThan($row[ref_id], 15) . "</td>" .
					"<td width=\"20%\">" . (($row[is_sent] && $row[is_sent] != "f" && $row[is_sent] != "false") ? "Yes" : "No") . "</td>" .
					(!($row[is_sent] && $row[is_sent] != "f" && $row[is_sent] != "false") ?
							"<td width=\"20%\"><a href=\"javascript:if (confirm('" . _lang(sure_delete_finance) . "')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td>" : "") .
					"</tr> ";
		}
		$List.= '</table>';
		$List.="<div class=\"admin_list_control\">";
		if ($admin_page > 1)
			$List.= "&laquo; <a href=\"?admin_page=" . ($admin_page - 1) . "\" >" . _lang(list_previous_page) . " $per_page </a>&nbsp;&nbsp; ";

		if ($page_no > 2) {
			$List.='<select onchange="document.location=\'?admin_page=\'+this.value;">';
			for ($i = 1; $i <= $page_no; $i++) {
				$sel = "";
				if ($admin_page == $i)
					$sel = "selected";
				$List.='<option value="' . $i . '" ' . $sel . '>' . $i . '</option>';
			}
			$List.='</select>';
		}

		if ($no > $per_page)
			$List.= "&nbsp;<a href=\"?admin_page=" . ($admin_page + 1) . "\" > " . _lang(list_next_page) . " $per_page</a> &raquo;";

		$List.="</div><br/>";

		return $List;
	}

	public static function SendAllSMSs($report = false, $only_autoresponse = true) {
		$log.= "\r\n\r\n---------------------------------------------------------\r\n " . date('Y-m-d H:i:s') . "\r\n";

		global $db, $site, $predir;
		$i = 0;

		//Delete all blocked numbers
		$sql = "DELETE FROM send_sms WHERE (mobile_no IN (SELECT '04'||blocked_number from blocked_number )OR mobile_no='0400000001') AND (is_sent IS NULL OR is_sent=false) ";
		if (!$result = $db->sql_query($sql)) {
			$log.= "\nError To remove blocked Numbers-\n";
		}
		else
			$log.= "\nDeleting blocked numbers (if existing)... \n";

		if ($only_autoresponse)
			$WHERE = " AND `send_sms`.`msg_id`<100 ";

		$sql = 'SELECT `send_sms`.*,`sms_msg`.`msg_text`,`msg_title` FROM `send_sms`,`sms_msg` WHERE  `send_time` <= ' . time() . ' AND (`is_sent`=false OR `is_sent` IS NULL)  AND `sms_msg`.`msg_id`=`send_sms`.`msg_id` ' . $WHERE . '  ';

		$result = $db->sql_query($sql);

		$si = new SmsInterface(false, false);

		while ($row = $db->sql_fetchrow($result)) {


			$si->addMessage($row['mobile_no'], $row['msg_text'], $row['id'], 0, 169, false);

			$i++;
			if ($report)
				$log.= "$i - SEND({$row['id']}) " . $row['msg_title'] . " To: " . $row['mobile_no'] . " \r\n";
		}
		if ($i == 0)
			$log.="No SMS to be sent\n";
		else if (strpos($site['url'], "localhost") > 0) {
			$sql = 'UPDATE `send_sms` SET is_sent=true, real_sent_time=' . time() . '   WHERE `send_time` <= ' . time() . ' AND (`is_sent`=false OR `is_sent` IS NULL)   ' . $WHERE . '  ';
			$db->sql_query($sql);
			if ($report)
				$log.= "  OK.\r\n";
		}
		else

		if (!$si->connect($site["sms_user"], $site["sms_pass"], true, false)) {

			$log.= "failed. Could not contact server.\r\n";
			mail("developer@silvertrees.net,gerard@silvertrees.net", "AFS: Can't connect to the SMS server", "please check", "From: developer@silvertrees.net\nReply-To: developer@silvertrees.net\nContent-Type: text/html");
		} elseif (!$si->sendMessages()) {
			mail("developer@silvertrees.net,gerard@silvertrees.net", "AFS: failed. Could not send message to server", "please check ", "From: developer@silvertrees.net\nReply-To: developer@silvertrees.net\nContent-Type: text/html");
			$log.= "failed. Could not send message to server.\r\n";
			if ($si->getResponseMessage() !== NULL)
				$log.= "\nReason: " . $si->getResponseMessage() . "\r\n";
		}
		else {
			$sql = 'UPDATE `send_sms` SET is_sent=true, real_sent_time=' . time() . '   WHERE `send_time` <= ' . time() . ' AND (`is_sent`=false OR `is_sent` IS NULL)   ' . $WHERE . '  ';
			$db->sql_query($sql);
			if ($report)
				$log.= " $i Messages Has Been Sent.\r\n";
		}


		file_put_contents($predir . 'admin/sms_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
	}

	public static function ClearHistory($days_count = 5) {
		global $db;
		$sql = 'DELETE  FROM send_sms WHERE is_sent=true AND send_time< ' . strtotime("-$days_count days");
		//echo $sql;
		if (!$result = $db->sql_query($sql)) {
			send_sms::$SErrors[] = $db->sql_error_msg($result);
			return false;
		}
		return true;
	}

	public static function GetResponse() {
		global $db, $site;
		?>

		<?php

		$si = new SmsInterface ();
		if (!$si->connect($site["sms_user"], $site["sms_pass"], true, false))
			echo "<P> Unable to connect to the SMS server.\n";
		elseif (($srl = $si->checkReplies(false)) === NULL) {
			echo "Unable to read messages from the SMS server.\n";
			if ($si->getResponseMessage() !== NULL)
				echo "<BR>Reason: " . $si->getResponseMessage() . "\n";
		}
		elseif (count($srl) == 0)
			echo "No messages waiting on the SMS server.\n";
		else {
			echo "<TABLE><TR>";
			echo "<TH> Message ID <TH> Phone number <TH> Message\n";
			foreach ($srl as $sr) {

				echo "<TR><TD> $sr->messageID <TD> $sr->phoneNumber <TD> ";
				if ($sr->status == MessageStatus::none())
					echo "$sr->message\n";
				elseif ($sr->status == MessageStatus::pending())
					$status = "pending\n";
				elseif ($sr->status == MessageStatus::delivered())
					$status = "delivered\n";
				elseif ($sr->status == MessageStatus::failed())
					$status = "failed\n";
				else
					$status = "unknown'$sr->status'\n";

				$send_sms1 = new send_sms();
				if ($send_sms1->SelectFromDB($sr->messageID)) {
					$send_sms1->sent_status = $status;
					$send_sms1->Update();
				}
			}


			echo "</TABLE>\n";
			mail("developer@silvertrees.net", "Staus Updated", "Staus Updated", "From: developer@silvertrees.net\nReply-To: developer@silvertrees.net\nContent-Type: text/html");
		}
		?>

		<?

	}

	public static function AddFromSql($msg_id, $select_sql) {

		global $db;
		$sms_msg1 = new sms_msg();
		if (!$sms_msg1->SelectFromDB($msg_id)) {
			send_sms::$SErrors = $sms_msg1->Errors;
			return false;
		}

		$insert_values = "DISTINCT on (tel) '$msg_id','" . time() . "','" . time() . "',tel,'" . (PreSql($select_sql)) . "'";

		$where = "WHERE tel NOT IN(SELECT mobile_no FROM send_sms WHERE msg_id=$msg_id AND mobile_no=tel AND send_time+" . ($sms_msg1->minimum_gab * 60) . " > " . time() . ") AND tel NOT IN(SELECT e1.tel FROM elist_form e1  WHERE e1.dont_send_sms=true AND e1.tel IS NOT NULL ) AND " . blocked_number::GetBlockedWhereSql() . " AND";


		$sql = "INSERT INTO send_sms (msg_id, added_time, send_time, mobile_no, ref_id) "
				. str_replace("*", $insert_values, str_replace('WHERE', $where, $select_sql));




		if (!$result = $db->sql_query($sql)) {
			send_sms::$SErrors[] = $db->sql_error_msg($result);
			return false;
		}

		$total_added = $db->sql_affectedrows($result);

		if (!$total_added) {
			send_sms::$SErrors[] = _lang(no_sms_added_from_sql);
			return false;
		}

		return $total_added;
	}

	public static function ExportUnsentFiles() {
		$exporter = new csv_exporter();
		global $db, $site;

		$WHERE = " (is_sent=false OR is_sent IS NULL) AND send_time<=" . time() . "";
		$sql = "SELECT  id AS \"SMS ID\" ,mobile_no AS \"Mobile No\",to_char(timestamp '1970-01-01'+  send_time * interval '1 second' , 'YYYY-MM-DD HH24:MI:SS') AS \"Time to be sent\",msg_text AS \"Message Body\",ref_id AS \"Ref ID\"  FROM send_sms,sms_msg WHERE send_sms.msg_id=sms_msg.msg_id AND $WHERE  ORDER by send_time ";




		$csv = $exporter->dump($sql, date('ymmdd'), "txt", $site["dbname"], $site["dblogin"], $site["dbpass"], $site["dbhost"], true, ',');



		if (sizeof(explode("\n", $csv)) > 2) {
			file_put_contents('unsent_sms.txt', $csv);
		}

		$sql = "UPDATE  send_sms SET tag3='exported',send_time=" . time() . ",is_sent=true WHERE $WHERE   ";

		if (!$result = $db->sql_query($sql)) {
			die("ERROR , the sent status hasn't been updated!!! " . $sql . " " . $db->sql_error_msg($result));
		}
	}

	public static function DownloadLastExportedUnsent() {
		header('Content-Type: text/comma-separated-values');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Disposition: attachment; filename="return.txt"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		echo file_get_contents('unsent_sms.txt');
	}

	public function UnsubscribeForm() {
		include('forms/funsubscribe_bulk_sms.php');
	}

}
?>