<?php

class send_email {

    public $id;
    public $msg_id;
    public $added_time;
    public $send_time;
    public $email_address;
    public $ref_id;
    public $is_sent;
    public $real_sent_time;
    public $sent_status;
    public $name;
    public $tag3;
    public static $SErrors;
    public static $rand_id;
    public static $press_ads_emails = array(
        0 => 231, //RANGE OF CARS
        1 => 222, //TESTI 1
        2 => 203, //191 point Inspection
        3 => 206, //Money back guarantee
        4 => 219, //7 days exchange
        5 => 202, //24 hrs test drive
        6 => 223, //TESTI 2
        7 => 204, //CAR FINDER
        8 => 205, //Deal Beater
        9 => 233, //Below Cost Cars
        10 => 224, //TESTI 3
        11 => 208, //ONLINE TRADE IN VALUATION
        12 => 209, //SELL YOUR CAR
        13 => 220, //Finance 4 u
        14 => 225, //Testi 4
        15 => 232, //Credit Doctor
        16 => 221, //SERVICE
        17 => 229, //THE PIT
        18 => 207, //FREE 4WD TRAINING DAY
        19 => 226, //TESTI 5
        20 => 228, //Win 10k
        21 => 230, //REFER A FRIEND
        22 => 227, //TESTi 6
    );
    var $Errors;

    public static function logme($str) {
        $more = '';
        if (!self::$rand_id) {
            self::$rand_id = rand(1, 31312312);
            $more = $_SERVER['PHP_SELF'];
        };
        $line = "\r\n " . self::$rand_id . ' ' . $more . ' ' . date('Y m d H i s') . ' ' . $str;
        file_put_contents($GLOBALS['predir'] . 'admin/send_email_log/' . date('Y-m-W') . '.txt', $line, FILE_APPEND);
    }

    public function NewAutoEmail($msg_id, $send_time, $email_address, $name, $ref_id, $is_sent = false, $real_sent_time = false) {
        global $db;
        $msg = new email_msg();
        $msg->SelectFromDB($msg_id);
        $minmum_gap_minutes = $msg->minmum_gab;
        $email_address = PreSql($email_address);
        $email_address = strtolower($email_address);
        //See if there is  a message which will be sent before the gap, so dont add this message
        $sql = "SELECT COUNT(*) FROM `send_email` WHERE lower(`email_address`)='$email_address' AND `msg_id`='$msg_id' AND `send_time` > " . ($send_time - $minmum_gap_minutes * 60) . "   ";

        if (!$result = $db->sql_query($sql))
            echo ($sql . " " . $db->sql_error_msg($result));
        $row = $db->sql_fetchrow($result);
        if ($row[0] > 100) {
            return true;
        } else {
            $this->SetValues(false, $msg_id, time(), $send_time, $email_address, $ref_id, $is_sent, false, $name, false, $real_sent_time);
            return $this->Insert();
        }
    }

    public function SetValues($_id = false, $_msg_id = false, $_added_time = false, $_send_time = false, $_email_address = false, $_ref_id = false, $_is_sent = false, $_sent_status = false, $_name = false, $_tag3 = false, $_real_sent_time = false) {
        $this->msg_id = $_msg_id;
        $this->added_time = $_added_time;
        $this->send_time = $_send_time;
        $this->email_address = $_email_address;
        $this->ref_id = $_ref_id;
        $this->sent_status = $_sent_status;
        $this->name = $_name;
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
        $sql = 'SELECT * FROM `send_email` WHERE `id` = ' . $_id;
        if (!($result = $db->sql_query($sql))) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        if ($db->sql_numrows($result) < 1) {
            $this->Errors[] = _lang(no_send_email_found);
            return false;
        }

        $row = $db->sql_fetchrow($result);
        $this->msg_id = $row['msg_id'];
        $this->added_time = $row['added_time'];
        $this->send_time = $row['send_time'];
        $this->email_address = $row['email_address'];
        $this->ref_id = $row['ref_id'];
        $this->is_sent = $row['is_sent'];
        $this->real_sent_time = $row['real_sent_time'];
        $this->sent_status = $row['sent_status'];
        $this->name = $row['name'];
        $this->tag3 = $row['tag3'];
        return true;
    }

    public function Insert() {
        global $db;
        $sql = 'INSERT INTO `send_email` (`msg_id`, `added_time`, `send_time`, `email_address`, `ref_id`, `is_sent`, `real_sent_time`, `sent_status`, `name`,  `tag3`) VALUES (\'' . PreSql($this->msg_id) . '\',  \'' . PreSql($this->added_time) . '\',  \'' . PreSql($this->send_time) . '\',  \'' . PreSql($this->email_address) . '\',  \'' . PreSql($this->ref_id) . '\',  \'' . PreSql($this->is_sent) . '\',  \'' . PreSql($this->real_sent_time) . '\',  \'' . PreSql($this->sent_status) . '\',  \'' . PreSql($this->name) . '\',  \'' . PreSql($this->tag3) . '\')';
        if (!$db->sql_query($sql)) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        return $db->sql_nextid();
    }

    public function Add() {
        $op = 'Add';
        include '../forms/fsend_email.php';
    }

    public function Delete() {
        global $db;

        $sql = 'DELETE FROM `send_email` WHERE `id`=' . $this->id;
        if (!$db->sql_query($sql)) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        return true;
    }

    public static function UnsubscribeMail($email, $SK) {
        global $db, $predir;

        $log = "\r\n-----------------------------------\r\n Time: " . date('Y-m-d H:i:s') . "\r\n";
        $log.="$email: Remove all future Croned Job for this email \r\n";

        if (false/* $SK!=MyMD5($email) */) {
            $log.="Error: Invalid SK!\r\n";
            file_put_contents($predir . 'admin/unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
            send_email::$SErrors[] = _lang(invalid_sec_code);
            return false;
        }

        $sql = 'DELETE FROM `send_email` WHERE lower(`email_address`)=\'' . strtolower($email) . '\' AND 	(is_sent IS NULL OR is_sent = false)';
        if (!$db->sql_query($sql)) {
            $log.="Error: SQL Error!\r\n" . $db->sql_error_msg($result) . "\r\n";
            file_put_contents($predir . 'admin/unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);

            send_email::$SErrors[] = $db->sql_error_msg($result);
            return false;
        }
        $affected = $db->sql_affectedrows();

        $log.="$affected Scheduled emails were Removed!\r\n";
        file_put_contents($predir . 'admin/unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);

        return 1 + $affected;
    }

    public function Edit($_op = 'Update') {
        $id = PreForm($this->id);
        $msg_id = PreForm($this->msg_id);
        $added_time = PreForm($this->added_time);
        $send_time = PreForm($this->send_time);
        $email_address = PreForm($this->email_address);
        $ref_id = PreForm($this->ref_id);
        $is_sent = PreForm($this->is_sent);
        $real_sent_time = PreForm($this->real_sent_time);
        $sent_status = PreForm($this->sent_status);
        $name = PreForm($this->name);
        $tag3 = PreForm($this->tag3);

        $op = $_op;

        include '../forms/fsend_email.php';
    }

    public function Update() {
        global $db;
        $sql = 'UPDATE `send_email` SET `msg_id` = \'' . PreSql($this->msg_id) . '\', `added_time` = \'' . PreSql($this->added_time) . '\', `send_time` = \'' . PreSql($this->send_time) . '\', `email_address` = \'' . PreSql($this->email_address) . '\', `ref_id` = \'' . PreSql($this->ref_id) . '\', `is_sent` = \'' . PreSql($this->is_sent) . '\', `real_sent_time` = \'' . PreSql($this->real_sent_time) . '\', `sent_status` = \'' . PreSql($this->sent_status) . '\', `name` = \'' . PreSql($this->name) . '\', `tag3` = \'' . PreSql($this->tag3) . '\' WHERE `id` = ' . $this->id;

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
        $this->email_address = PostForm($_POST['email_address']);
        $this->ref_id = PostForm($_POST['ref_id']);
        $this->is_sent = PostForm($_POST['is_sent']);
        $this->real_sent_time = PostForm($_POST['real_sent_time']);
        $this->sent_status = PostForm($_POST['sent_status']);
        $this->name = PostForm($_POST['name']);
        $this->tag3 = PostForm($_POST['tag3']);
    }

    public static function AdminListSendEmails() {
        global $db, $list_per_page;
        $per_page = 50;
        if (!isset($_GET['admin_page']) || $_GET['admin_page'] < 1)
            $_GET['admin_page'] = 1;
        $admin_page = $_GET['admin_page'];

        if ($_GET['email_address'])
            $where.=" AND lower(email_address) LIKE '%" . PreSql(trim(strtolower(($_GET['email_address'])))) . "%' ";

        if ($_GET['is_sent'] && $_GET['is_sent'] == 'TRUE')
            $where.=" AND is_sent = true ";
        if ($_GET['is_sent'] && $_GET['is_sent'] == 'FALSE1')
            $where.=" AND (is_sent = false OR is_sent IS NULL )";

        $sql = 'SELECT * FROM `send_email` WHERE 1=1 ' . $where . '  ORDER BY real_sent_time DESC , send_time DESC , `id` DESC LIMIT ' . (($admin_page - 1) * $per_page) . ',' . ($per_page + 1) . ' ';
        $result = $db->sql_query($sql) or die($sql . "<br/>" . $db->sql_error_msg($result));
        $no = $db->sql_numrows($result);

        $page_no = PageCount(GetUnlimitedCount($sql), $per_page);




        $List.= '<p class="admin_title">Email jobs:</p>';
        $List.='
		<form method="GET" action="">
		<table cellpadding="4"><tr>
		<td>Email:</td>
		<td><input name="email_address" value="' . $_GET['email_address'] . '" id="email_address" type="text"></td>
		<td>Is sent </td>
		<td><select name="is_sent">' . ListOptions(array('All', 'Yes', 'No'), array('', 'TRUE', 'FALSE1'), $_GET['is_sent'], true) . '</select></td>
		<td><input type="Submit" Value="GO" /></td>
		</tr></table>
		';
        $List.= '<table class="adminlist" width="1000px"><tr class="header">
		<td >ID</td>
		<td>Email</td>
		<td>Message</td>
		<td>Added time</td>
		<td>Time to send</td>
		<td>Is sent</td>
		<td>Real sent time</td>
		<td>Delete</td></tr> ';
        while (($row = $db->sql_fetchrow($result)) && $i < $per_page) {

            if ($i % 2.0 > 0)
                $class = "odd";
            else
                $class = "even";
            $i++;

            $List.= '<tr class="' . $class . '">
			<td>' . $row['id'] . '</td>' .
                    "<td>$row[email_address]</td>" .
                    "<td>" . email_msg::GetName($row[msg_id]) . "</td>" .
                    "<td>" . date('d-m-Y H:i:s', $row['added_time']) . "</td>" .
                    "<td>" . date('d-m-Y H:i:s', $row['send_time']) . "</td>" .
                    "<td>" . ($row['is_sent'] ? "Yes" : "No") . "</td>" .
                    "<td>" . ($row['is_sent'] ? date('d-m-Y H:i:s', $row['real_sent_time']) : "-") . "</td>" .
                    "<td >" . ($row['is_sent'] ? "-" : "<a href=\"javascript:if (confirm('" . _lang('sure_delete_send_email') . "')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a>") . "</td></tr> ";
        }
        $List.= '</table>';
        $List.="<div class=\"admin_list_control\">";
        $List.="<div class=\"admin_list_control\">";

        if ($admin_page > 1)
            $List.= "&laquo; <a href=\"?admin_page=" . ($admin_page - 1) . "&email_address={$_GET['email_address']}&is_sent={$_GET['is_sent']}\" >" . _lang('list_previous_page') . " $per_page </a>&nbsp;&nbsp; ";

        if ($no > $per_page)
            $List.= "&nbsp;<a href=\"?admin_page=" . ($admin_page + 1) . "&email_address={$_GET['email_address']}&is_sent={$_GET['is_sent']}\" > " . _lang('list_next_page') . " $per_page</a> &raquo;";

        $List.="</div><br/>";


        return $List;
    }

    public static function UpdateToSentStaus($id) {
        global $db;

        $sql = 'UPDATE `send_email` SET `is_sent` = \'true\',
		`real_sent_time` = \'' . time() . '\', `sent_status` = \'1\' 
		WHERE ' . (is_array($id) ? '`id` IN (' . implode(',', $id) . ') ' : ' `id` = ' . $id);

        if (!$db->sql_query($sql)) {
            $error = $db->sql_error_msg($result);
            mail('developer@silvertrees.net', 'AFS: cant update sent status', "$sql\n\n<br\>\n\n" . $error);
            self::logme('Cant UPDATE!!');
            return false;
        }
        self::logme('Updated');
        return true;
    }

    public static function ClearHistory($days_count = 5) {
        global $db;
        $sql = 'DELETE  FROM send_email WHERE is_sent=true AND send_time< ' . strtotime("-$days_count days");
        //echo $sql;
        if (!$result = $db->sql_query($sql)) {
            send_email::$SErrors[] = $db->sql_error_msg($result);
            return false;
        }
        return true;
    }

    public static function SendAllEmail($report = false, $only_autoresponse = true) {


        global $db, $site, $from_mail;


        $db->sql_query('DELETE FROM send_email WHERE (is_sent IS NULL OR is_sent=false) AND msg_id>3 AND msg_id<16  AND msg_id <> 15  AND msg_id <> 13 ');

        self::logme('----------------------------------------------------------------');
        self::logme('Start Send All Email Function, autreposneonly:' . ($only_autoresponse ? 'Yes' : 'No'));

        if ($only_autoresponse)
            $WHERE = " AND `send_email`.`msg_id`<100   ";
        else
            $WHERE = "  AND `send_email`.`msg_id`<>2 AND (`send_email`.`msg_id`<>3 OR `send_email`.`msg_id`<>1 ) ";
        /* if(!$only_autoresponse)
          {
          self::logme('Execute Delete Repeated Query ');
          $sql22="DELETE FROM send_email WHERE (is_sent IS NULL or is_sent=FALSE) AND lower(email_address) NOT IN
          (SELECT lower(email) from afs_form a1 WHERE a1.subscriberid IN (select max(a2.subscriberid) from afs_form a2 group by a2.email )
          AND (dont_send_mail IS NULL OR dont_send_mail = false) AND email IS NOT NULL)
          AND send_email.msg_id<>2 AND send_email.msg_id<>3 AND send_email.msg_id<>1";
          if(!$result=$db->sql_query($sql22))
          self::logme('Error with query!!');
          else
          self::logme('Executed!!');
          } */


        self::logme('Start the itrations loop');
        for ($i = 0; $i < 100; $i++) {

            self::logme('itration ' . $i);
            $sql = 'SELECT DISTINCT ON (id) `send_email`.*,`email_msg`.`msg_body`,`email_msg`.`msg_subject` FROM `send_email`,`email_msg` WHERE `send_time` <= ' . time() . ' AND (`is_sent`=false OR `is_sent` IS NULL)  AND `email_msg`.`msg_id`=`send_email`.`msg_id` ' . $WHERE . ' LIMIT 0, 500  ';


            $email_sender = new send_email();


            $result = $db->sql_query($sql);
            self::logme('Query Executed ');


            if (!$db->sql_numrows($result)) {
                self::logme('No Result found ');
                break;
            };

            $updated = 0;
            $updated_ids = array();

            while ($row = $db->sql_fetchrow($result)) {

                if (file_get_contents($GLOBALS['predir'] . 'admin/stop_me'))
                    return;

                $from = "Australian Fleet Sales <{$site['from_mail']}>";
                //mail('developer@silvertrees.net',$row['id'].":".$row['msg_subject'],send_email::PreSend($row['msg_body'],$row['email_address'],$row['name']),"From: $from\nReply-To: $from\nContent-Type: text/html");

                mail($row['email_address'], $row['msg_subject'], send_email::PreSend($row['msg_body'], $row['email_address'], $row['name'], array('subscriber_id' => $row['tag3'])), "From: $from\nReply-To: enquiry@austfleetsales.com.au\nContent-Type: text/html", '-f failedafsemail@silvertrees.net');
                self::logme('Send Email to: ' . $row['email_address'] . ' ID:' . $row['id'] . ' ++' . $updated);
                //echo send_email::PreSend($row['msg_body'],$row['email_address'],$row['name']);

                $updated++;
                $updated_ids[] = $row['id'];

                if ($updated >= 100) {
                    self::logme('Update sent status for ids: ' . implode(',', $updated_ids));
                    if (!self::UpdateToSentStaus($updated_ids))
                        return;
                    $updated = 0;
                    $updated_ids = array();
                }
            }

            if ($updated) {
                self::logme('Update sent status for ids: ' . implode(',', $updated_ids));
                self::UpdateToSentStaus($updated_ids);
                $updated = 0;
                $updated_ids = array();
            }
            self::logme('End itration ' . $i . '');
        }
        self::logme('End all itrations,Exit function');
        self::logme('----------------------------------------------------------------');
    }

    public function PreSend($msg, $email, $name, $data) {
        global $site;
        return str_replace('%%subscriber_id%%', $data['subscriber_id'], str_replace('%%name%%', $name, str_replace("%%unsubscribelink%%", $site['url'] . '/special.php?op=Unsubscribe&email=' . $email . '&SK=' . MyMD5($email), $msg)));
    }

    public static function AddFromSql($msg_id, $select_sql) {

        global $db;
        $email_msg1 = new email_msg();
        if (!$email_msg1->SelectFromDB($msg_id)) {
            send_email::$SErrors = $email_msg1->Errors;
            return false;
        }

        $insert_values = "DISTINCT on (email) '$msg_id','" . time() . "','" . time() . "',email,'" . PreSql($select_sql) . "', fname";

        $where = "WHERE email NOT IN(SELECT email_address FROM send_email WHERE msg_id=$msg_id AND lower(email_address)=lower(email) AND send_time+" . ($email_msg1->minmum_gab * 60) . " > " . time() . ") AND";


        $sql = "INSERT INTO send_email (msg_id, added_time, send_time, email_address, ref_id,  name) "
                . str_replace('WHERE', $where, str_replace("*", $insert_values, $select_sql));



        if (!$result = $db->sql_query($sql)) {
            send_email::$SErrors[] = $db->sql_error_msg($result);
            return false;
        }

        $total_added = $db->sql_affectedrows($result);

        if (!$total_added) {
            send_email::$SErrors[] = _lang(no_email_added_from_sql);
            return false;
        }

        return $total_added;
    }

    public static function ShowStatisticTable($from_date = false, $to_date = false, $per = "DY", $depth = 'send_email') {



        if ($per == "DY") {
            $period = "DD";
        } else
            $period = "WW";



        global $db;
        if ($from_date) {
            $from_date = date('Y-m-d', strtotime($from_date));
            $where.=" AND virtual_date >=  '$from_date' ";
        }

        if ($to_date) {
            $to_date = date('Y-m-d', strtotime($to_date));
            $where.=" AND virtual_date <=  '$to_date' ";
        }



        $email_sql = "SELECT count(DISTINCT id), to_char(virtual_date,'YYYY-MM $period ') AS \"date_week\"  ,
					SUM(case when $depth.msg_id='2'  then 1 else 0 end) AS email_msg1,
					SUM(case when $depth.msg_id='3'  then 1 else 0 end) AS email_msg2,
					SUM(case when $depth.msg_id='15'  then 1 else 0 end) AS email_msg3,
					SUM(case when $depth.msg_id>=4 AND  $depth.msg_id<=14 AND to_char(virtual_date,'D')IN ('2','3','4','5')   then 1 else 0 end) AS email_msg4,
					SUM(case when $depth.msg_id>=4 AND  $depth.msg_id<=14 AND to_char(virtual_date,'D') IN ('6','7','1')   then 1 else 0 end) AS email_msg5
					FROM virtual_date 
					LEFT JOIN $depth ON ( real_sent_time  > from_time AND real_sent_time < to_time  AND virtual_date <=now() $where) 
					WHERE virtual_date <=now() $where
					
					GROUP BY  to_char(virtual_date,'YYYY-MM $period ')";

        $sms_sql = "SELECT count(DISTINCT id), to_char(virtual_date,'YYYY-MM $period ') ,
					SUM(case when send_sms.msg_id='1'  then 1 else 0 end) AS sms_msg1,
					SUM(case when send_sms.msg_id='2'  then 1 else 0 end) AS sms_msg2,
					SUM(case when send_sms.msg_id='3'  then 1 else 0 end) AS sms_msg3,
					SUM(case when (substring(send_sms.ref_id from 1 for 3) <> 'WIN' OR  send_sms.ref_id IS NULL) AND  send_sms.msg_id='3'  then 1 else 0 end)AS sms_msg4,
					SUM(case when substring(send_sms.ref_id from 1 for 3) ='WIN' AND  send_sms.msg_id='3'  then 1 else 0 end) AS sms_msg5
					FROM virtual_date
					LEFT JOIN send_sms ON ( real_sent_time  > from_time AND real_sent_time < to_time  AND virtual_date <=now() $where ) 
					WHERE virtual_date <=now() $where
					GROUP BY  to_char(virtual_date,'YYYY-MM $period ')";


        $_10k_sql = "SELECT  to_char(virtual_date,'YYYY-MM $period ') ,
					SUM(DISTINCT(subscriberid))-SUM(DISTINCT(subscriberid-1)) AS _10_k_1,
					SUM(DISTINCT(id))-SUM(DISTINCT(id-1)) AS _10_k_2
					FROM virtual_date
					LEFT JOIN elist_form ON ( to_char(elist_form.stamp_time,'YYYY-MM $period ')=to_char(virtual_date,'YYYY-MM $period ')   AND virtual_date <=now() $where )
					LEFT JOIN enquiries ON (  to_char(enquiries.stamp_time ,'YYYY-MM $period ')=to_char(virtual_date,'YYYY-MM $period ') AND `type`='winner'  AND virtual_date <=now() $where ) 
					WHERE virtual_date <=now() $where
					GROUP BY  to_char(virtual_date,'YYYY-MM $period ')";




        $curr_year = date('Y');
        if ($depth != 'send_email')
            for ($i = 2008; $i <= $curr_year; $i++) {
                $min_time = strtotime("$i-01-01");
                $max_time = strtotime(($i + 1) . "-01-01");
                $year_email_queries[] = " SELECT count(DISTINCT id), '$i' AS \"date_week\"  ,
									SUM(case when $depth.msg_id>20 AND $depth.msg_id<33   then 1 else 0 end) AS email_msg1,
									SUM(case when $depth.msg_id='3' then 1 else 0 end) AS email_msg2,
									SUM(case when $depth.msg_id='15' then 1 else 0 end) AS email_msg3,
									SUM(case when $depth.msg_id>=4 AND  $depth.msg_id<=14 AND to_char(TIMESTAMP WITH TIME ZONE 'epoch'+  real_sent_time * interval '1 second' , 'D') IN ('2','3','4','5')   then 1 else 0 end) AS email_msg4,
									SUM(case when $depth.msg_id>=4 AND  $depth.msg_id<=14 AND to_char(TIMESTAMP WITH TIME ZONE 'epoch'+  real_sent_time * interval '1 second' , 'D') IN ('6','7','1')   then 1 else 0 end) AS email_msg5
									FROM  $depth 
									WHERE real_sent_time >=$min_time AND real_sent_time<$max_time  ";

                $sms_email_queries[] = " SELECT count(DISTINCT id),'$i' AS \"date_week\" ,
									SUM(case when send_sms.msg_id='1' then 1 else 0 end) AS sms_msg1,
									SUM(case when send_sms.msg_id='2' then 1 else 0 end) AS sms_msg2,
									SUM(case when send_sms.msg_id='3' then 1 else 0 end) AS sms_msg3,
									SUM(case when (substring(send_sms.ref_id from 1 for 3)<> 'WIN' OR  send_sms.ref_id IS NULL)  AND  send_sms.msg_id='3' then 1 else 0 end) AS sms_msg4,
									SUM(case when substring(send_sms.ref_id from 1 for 3) = 'WIN' AND  send_sms.msg_id='3' then 1 else 0 end)  AS sms_msg5	
									FROM send_sms
									WHERE real_sent_time >=$min_time AND real_sent_time<$max_time ";

                $year_10k_queries1[] = " SELECT  '$i' AS \"date_week\" ,
					COUNT(subscriberid) AS _10_k_1
					FROM
					elist_form
					WHERE to_char(stamp_time,'YYYY')='$i' ";

                $year_10k_queries2[] = " SELECT  '$i' AS \"date_week\" ,
					COUNT(id) AS _10_k_2
					FROM
					enquiries
					WHERE to_char(stamp_time,'YYYY')='$i' AND type='winner' ";
            }
        $year_email_sql = implode($year_email_queries, "UNION") . ' ORDER BY "date_week" DESC ';

        $year_sms_sql = implode($sms_email_queries, "UNION") . ' ORDER BY "date_week" DESC ';
        $year_10k_sql1 = implode($year_10k_queries1, "UNION") . ' ORDER BY "date_week" DESC ';


        $year_10k_sql2 = implode($year_10k_queries2, "UNION") . ' ORDER BY "date_week" DESC ';




        if (!$email_result = $db->sql_query($email_sql)) {

            send_email::$SErrors[] = $db->sql_error_msg($email_result) . '1';
            return false;
        }

        if (!$sms_result = $db->sql_query($sms_sql)) {

            send_email::$SErrors[] = $db->sql_error_msg($sms_result) . '2';
            return false;
        }

        if (!$_10k_result = $db->sql_query($_10k_sql)) {

            send_email::$SErrors[] = $db->sql_error_msg($_10k_result) . '3';
            return false;
        }


        if ($depth != 'send_email') {
            if (!$year_email_result = $db->sql_query($year_email_sql)) {
                die($year_email_sql);
                send_email::$SErrors[] = $db->sql_error_msg($year_email_result) . '4';
                return false;
            }


            if (!$year_sms_result = $db->sql_query($year_sms_sql)) {
                die($year_sms_sql) . '5';
                send_email::$SErrors[] = $db->sql_error_msg($year_sms_result) . '5' . "<pre>" . $year_sms_sql;
                return false;
            }



            if (!$year_10k_result1 = $db->sql_query($year_10k_sql1)) {
                die($year_10k_sql1);
                send_email::$SErrors[] = $db->sql_error_msg($year_10k_result1) . '6';
                return false;
            }


            if (!$year_10k_result2 = $db->sql_query($year_10k_sql2)) {
                die($year_10k_sql2);

                send_email::$SErrors[] = $db->sql_error_msg($year_10k_result2) . '7';
                return false;
            }
        }

        $x = $db->sql_query('sss');





        while (($email_row = $db->sql_fetchrow($email_result)) && ($sms_row = $db->sql_fetchrow($sms_result)) && ($_10k_row = $db->sql_fetchrow($_10k_result))) {
            $rows[] = array_merge($sms_row, $email_row, $_10k_row);
        }





        if ($depth != 'send_email') {
            while (($year_email_row = $db->sql_fetchrow($year_email_result)) && 1) {
                $year_sms_row = $db->sql_fetchrow($year_sms_result);
                $year_10k_row1 = $db->sql_fetchrow($year_10k_result1);
                $year_10k_row2 = $db->sql_fetchrow($year_10k_result2);
                $year_rows[] = array_merge($year_sms_row, $year_email_row, $year_10k_row1, $year_10k_row2);
            }
        }


        include('../templates/email_sms_statistics.php');

        return true;
    }

    public static function ShowStatisticTableNew($from_date = false, $to_date = false, $per = "DY", $depth = 'send_email') {



        if ($per == "DY") {
            $period = "DD";
        } else
            $period = "WW";



        global $db;
        if ($from_date) {
            $from_date = date('Y-m-d', strtotime($from_date));
            $where.=" AND virtual_date >=  '$from_date' ";
        }

        if ($to_date) {
            $to_date = date('Y-m-d', strtotime($to_date));
            $where.=" AND virtual_date <=  '$to_date' ";
        }



        $email_sql = "SELECT count(DISTINCT id), to_char(virtual_date,'YYYY-MM $period ') AS \"date_week\"  ,
					SUM(case when $depth.msg_id>20 AND $depth.msg_id<33  then 1 else 0 end) AS email_msg1,
					SUM(case when $depth.msg_id='3'  then 1 else 0 end) AS email_msg2,
					SUM(case when $depth.msg_id IN (" . implode(',', send_email::$press_ads_emails) . ")  then 1 else 0 end) AS email_msg3,
					SUM(case when $depth.msg_id=300  then 1 else 0 end) AS email_msg4,
					SUM(case when $depth.msg_id=301  then 1 else 0 end) AS email_msg5,
					SUM(case when $depth.msg_id=15 then 1 else 0 end) AS email_msg6
					FROM virtual_date 
					LEFT JOIN $depth ON ( real_sent_time  > from_time AND real_sent_time < to_time  AND virtual_date <=now() $where) 
					WHERE virtual_date <=now() $where
					
					GROUP BY  to_char(virtual_date,'YYYY-MM $period ')";

        $sms_sql = "SELECT count(DISTINCT id), to_char(virtual_date,'YYYY-MM $period ') ,
					SUM(case when send_sms.msg_id='1'  then 1 else 0 end) AS sms_msg1,
					SUM(case when send_sms.msg_id='2'  then 1 else 0 end) AS sms_msg2,
					SUM(case when send_sms.msg_id='3'  then 1 else 0 end) AS sms_msg3,
					SUM(case when (substring(send_sms.ref_id from 1 for 3) <> 'WIN' OR  send_sms.ref_id IS NULL) AND  send_sms.msg_id='3'  then 1 else 0 end)AS sms_msg4,
					SUM(case when substring(send_sms.ref_id from 1 for 3) ='WIN' AND  send_sms.msg_id='3'  then 1 else 0 end) AS sms_msg5
					FROM virtual_date
					LEFT JOIN send_sms ON ( real_sent_time  > from_time AND real_sent_time < to_time  AND virtual_date <=now() $where ) 
					WHERE virtual_date <=now() $where
					GROUP BY  to_char(virtual_date,'YYYY-MM $period ')";


        $_10k_sql = "SELECT  to_char(virtual_date,'YYYY-MM $period ') ,
					SUM(DISTINCT(subscriberid))-SUM(DISTINCT(subscriberid-1)) AS _10_k_1,
					SUM(DISTINCT(id))-SUM(DISTINCT(id-1)) AS _10_k_2
					FROM virtual_date
					LEFT JOIN elist_form ON ( to_char(elist_form.stamp_time,'YYYY-MM $period ')=to_char(virtual_date,'YYYY-MM $period ')   AND virtual_date <=now() $where )
					LEFT JOIN enquiries ON (  to_char(enquiries.stamp_time ,'YYYY-MM $period ')=to_char(virtual_date,'YYYY-MM $period ')  AND virtual_date <=now() AND `type`='winner' $where ) 
					WHERE virtual_date <=now() $where
					GROUP BY  to_char(virtual_date,'YYYY-MM $period ')";




        $curr_year = date('Y');
        if ($depth != 'send_email')
            for ($i = 2008; $i <= $curr_year; $i++) {
                $min_time = strtotime("$i-01-01");
                $max_time = strtotime(($i + 1) . "-01-01");
                $year_email_queries[] = " SELECT count(DISTINCT id), '$i' AS \"date_week\"  ,
									SUM(case when $depth.msg_id>20 AND $depth.msg_id<33 then 1 else 0 end) AS email_msg1,
									SUM(case when $depth.msg_id='3' then 1 else 0 end) AS email_msg2,
									SUM(case when $depth.msg_id IN (" . implode(',', send_email::$press_ads_emails) . ") then 1 else 0 end) AS email_msg3,
									SUM(case when $depth.msg_id=300  then 1 else 0 end) AS email_msg4,
									SUM(case when $depth.msg_id=301  then 1 else 0 end) AS email_msg5,
									SUM(case when $depth.msg_id=15  then 1 else 0 end) AS email_msg6
									FROM  $depth 
									WHERE real_sent_time >=$min_time AND real_sent_time<$max_time  ";

                $sms_email_queries[] = " SELECT count(DISTINCT id),'$i' AS \"date_week\" ,
									SUM(case when send_sms.msg_id='1' then 1 else 0 end) AS sms_msg1,
									SUM(case when send_sms.msg_id='2' then 1 else 0 end) AS sms_msg2,
									SUM(case when send_sms.msg_id='3' then 1 else 0 end) AS sms_msg3,
									SUM(case when (substring(send_sms.ref_id from 1 for 3)<> 'WIN' OR  send_sms.ref_id IS NULL)  AND  send_sms.msg_id='3' then 1 else 0 end) AS sms_msg4,
									SUM(case when substring(send_sms.ref_id from 1 for 3) = 'WIN' AND  send_sms.msg_id='3' then 1 else 0 end)  AS sms_msg5	
									FROM send_sms
									WHERE real_sent_time >=$min_time AND real_sent_time<$max_time ";

                $year_10k_queries1[] = " SELECT  '$i' AS \"date_week\" ,
					COUNT(subscriberid) AS _10_k_1
					FROM
					elist_form
					WHERE to_char(stamp_time,'YYYY')='$i' ";

                $year_10k_queries2[] = " SELECT  '$i' AS \"date_week\" ,
					COUNT(id) AS _10_k_2
					FROM
					enquiries
					WHERE to_char(stamp_time,'YYYY')='$i' AND `type`='winner' ";
            }
        $year_email_sql = implode($year_email_queries, "UNION") . ' ORDER BY "date_week" DESC ';

        $year_sms_sql = implode($sms_email_queries, "UNION") . ' ORDER BY "date_week" DESC ';
        $year_10k_sql1 = implode($year_10k_queries1, "UNION") . ' ORDER BY "date_week" DESC ';


        $year_10k_sql2 = implode($year_10k_queries2, "UNION") . ' ORDER BY "date_week" DESC ';




        if (!$email_result = $db->sql_query($email_sql)) {

            send_email::$SErrors[] = $db->sql_error_msg($email_result) . '1';
            return false;
        }

        if (!$sms_result = $db->sql_query($sms_sql)) {

            send_email::$SErrors[] = $db->sql_error_msg($sms_result) . '2';
            return false;
        }

        if (!$_10k_result = $db->sql_query($_10k_sql)) {

            send_email::$SErrors[] = $db->sql_error_msg($_10k_result) . '3';
            return false;
        }


        if ($depth != 'send_email') {
            if (!$year_email_result = $db->sql_query($year_email_sql)) {
                die($year_email_sql);
                send_email::$SErrors[] = $db->sql_error_msg($year_email_result) . '4';
                return false;
            }


            if (!$year_sms_result = $db->sql_query($year_sms_sql)) {
                die($year_sms_sql) . '5';
                send_email::$SErrors[] = $db->sql_error_msg($year_sms_result) . '5' . "<pre>" . $year_sms_sql;
                return false;
            }



            if (!$year_10k_result1 = $db->sql_query($year_10k_sql1)) {
                die($year_10k_sql1);
                send_email::$SErrors[] = $db->sql_error_msg($year_10k_result1) . '6';
                return false;
            }


            if (!$year_10k_result2 = $db->sql_query($year_10k_sql2)) {
                die($year_10k_sql2);

                send_email::$SErrors[] = $db->sql_error_msg($year_10k_result2) . '7';
                return false;
            }
        }

        $x = $db->sql_query('sss');





        while (($email_row = $db->sql_fetchrow($email_result)) && ($sms_row = $db->sql_fetchrow($sms_result)) && ($_10k_row = $db->sql_fetchrow($_10k_result))) {
            $rows[] = array_merge($sms_row, $email_row, $_10k_row);
        }





        if ($depth != 'send_email') {
            while (($year_email_row = $db->sql_fetchrow($year_email_result)) && 1) {
                $year_sms_row = $db->sql_fetchrow($year_sms_result);
                $year_10k_row1 = $db->sql_fetchrow($year_10k_result1);
                $year_10k_row2 = $db->sql_fetchrow($year_10k_result2);
                $year_rows[] = array_merge($year_sms_row, $year_email_row, $year_10k_row1, $year_10k_row2);
            }
        }


        include('../templates/email_sms_statistics_new.php');

        return true;
    }

    public function UnsubscribeForm() {
        include('../forms/funsubscribe.php');
    }

    public static function ResubcribeToPosters() {
        global $db;

        //Get the earlier monday or friday??
        $send_time = min(strtotime('next Monday'), strtotime('next Friday'));
        $sql = "INSERT INTO send_email
				(SELECT  DISTINCT on (lower(se.email_address))  nextval('send_email_id_seq'::regclass), CASE se.msg_id+1 WHEN 15  THEN 4 ELSE
				se.msg_id+1  END, lower(se.email_address) as email,'resubscribe_',NULL::bool,NULL,se.name,NULL,NULL,$send_time,NULL::integer,$send_time
			 	FROM send_email AS se ,poster_resubcribers pr WHERE pr.send_time=se.send_time AND lower(pr.email_address) = lower(se.email_address)
			 	UNION
			 	select DISTINCT on (lower(email)) nextval('send_email_id_seq'::regclass), 4, lower(email),'resubscribe_'||subscriberid::text
			 	,NULL, NULL ,fname,NULL,NULL,$send_time,NULL,$send_time  from afs_form a1 
			 	WHERE a1.subscriberid IN (select max(subscriberid) from afs_form a2 group by email ) AND 
			 	(dont_send_mail IS NULL OR dont_send_mail = false)  AND  
			 	lower(a1.email) NOT IN ( select lower(email_address) FROM send_email WHERE msg_id>=4 AND msg_id<=14 ) )
			 	
			 	 ";

        if (!$db->sql_query($sql)) {
            self::$SErrors[] = "Error: " . $db->sql_error_msg();
            return false;
        }
        return true;
    }

}

?>