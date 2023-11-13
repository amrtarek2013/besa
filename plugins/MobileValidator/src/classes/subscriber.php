<?php

function filter($input) {

    global $model_name;

    $string = stripslashes($input);

    $string = str_replace("'", '', $string);
    $string = str_replace("=", '', $string);
    $string = str_replace("body_types.", '', $string);
    $string = str_replace("%MAN%", 'Manual', $string);
    $string = str_replace("%AUT%", 'Auto', $string);
    $string = str_replace("ILIKE", '', $string);
    $string = str_replace("LIKE", '', $string);
    $string = str_replace(">=", '>= ', $string);
    $string = str_replace(">", '> ', $string);
    $string = str_replace("<=", '<= ', $string);
    $string = str_replace("<", '< ', $string);
//    $old_str = $string;
    $string = str_replace("make", "", $string);
    $string = str_replace("model", "", $string);
    $string = str_replace("body", "", $string);
    $string = str_replace("transmission", "", $string);
    $string = str_replace("colour", "", $string);
    $string = str_replace("year >", "", $string);


//	if ($old_str != $string)
//		$model_name = $string;
//	$string = str_replace("model is", "", $string);

    $string = str_replace("transmission is", "", $string);
    $string = str_replace("type is", "", $string);
    $string = str_replace("year less than is", "", $string);
    $string = str_replace("year greater than is", "", $string);
    $string = str_replace("rrp greater than is", "Price Range >", $string);
    $string = str_replace("rrp less than is", "Price Range <", $string);
    $string = str_replace("apl", "Series", $string);
    $string = str_replace("Series", "", $string);


    return $string;
}

//This function emails the filtered request to someone
function email($filter, $email) {
    global $model_name;

//    $body = "A customer with an email address of {$email} is interested in a:\r\n";

    $body = '';



    $request_query = explode(' AND ', $filter);
    foreach ($request_query as $request) {

        $request = trim(filter($request));

        if ((trim($request) != ', body_types WHERE stock_no IS NOT NULL') &&
                ($request != 'WHERE stock_no IS NOT NULL') &&
                ($request != 'body = afs_stock2.body') &&
                ($request != 'body is afs_stock2.body') &&
                ($request != 'body_types.body = afs_stock2.body') &&
                ($request != 'nvic IS NOT NULL')
        ) {

            $body .= "$request\n";
        }
    }
    return $body;
    //mail($email,'Request for search on '.$model_name.' car',$body, "From: AFS@autralianfleetsales.com.au");
}

function new_subscription($id, $filter) {

    //If the required data is present.
    if (isset($id) && isset($filter)) {

        $query = "INSERT INTO subscription (id,filter) VALUES ('$id','" . str_replace("\'", "''", addslashes($filter)) . "')";
//        echo $query;
        $result = pg_exec($query);

        if (pg_affected_rows($result) == 0) {

            return false;
        } else {

            return true;
        }
    }
}

function BuildFilter($data = array()) {
    if (empty($data)) {
        $data = $_POST;
    }
    $stock_number = $data['stock_number'];
    $price = $data['price'];

    $year_max = $data['year_max'];
    if (!is_numeric($year_max))
        unset($year_max);
    $year_min = $data['year_min'];
    if (!is_numeric($year_min))
        unset($year_min);

    $body = $data['body'];
    $body = $data['body'];

    $apl = $data['series'];

    if ($data['make2'])
        $make = $data['make2'];
    else if ($data['make'])
        $make = $data['make'];

    $transmission = $data['transmission'];

    if ($data['model'] == 'Any') {
        $model = NULL;
    } else {
        $model = $data['model'];
    }

    if ($data['model2'])
        $model = $data['model2'];

    $query = 'SELECT * FROM afs_stock2';

//	if (isset($body) && $body != 'any')
//		$query .= '  , body_types';

    $query .= ' WHERE stock_no IS NOT NULL';

    if (is_numeric($stock_number)) {

        $query .= " AND stock_no = '$stock_number'";
    } elseif (isset($_GET['sp'])) {

        if ($_GET['sp'] == 'qld') {

            $query .= ' AND nvic IS NULL';
        } elseif ($_GET['sp'] == 'nsw') {

            $query .= ' AND nvic IS NOT NULL';
        }
        $query .= ' AND km > 180000';
    } else {

        if (isset($data['state'])) {

            if ($data['state'] == 'qld') {

                $query .= ' AND nvic IS NULL';
            } elseif ($data['state'] == 'nsw') {

                $query .= ' AND nvic IS NOT NULL';
            }
        }

        if ($make)
            $query .= " AND LOWER(make) = '" . strtolower($make) . "'";
        if ($model)
            $query .= " AND LOWER(model) = '" . strtolower($model) . "'";
        if ($data['apl'])
            $query .= " AND (lower(apl) LIKE '%" . strtolower(PreSql($data['apl'])) . "%' OR '" . strtolower(PreSql($data['apl'])) . "' LIKE '%'||apl||'%') ";

        if (isset($body) && $body != 'any' && $body != '')
            $query .= " AND LOWER(body) = '" . strtolower($body) . "'";

        if ($transmission != 'any' && $transmission)
            $query .= " AND transmission ILIKE '%$transmission%'";
        if ($apl != 'any' && $apl)
            $query .= " AND LOWER(apl) LIKE '" . strtolower($apl) . "'";
        if ($year_max)
            $query .= " AND year <= '$year_max'";
        if ($year_min)
            $query .= " AND year >= '$year_min'";

        if (!empty($price)) {
            $price = explode(' - ', $price);
            if ($price[0] == '< 10,000') {
                $query .= " AND rrp <= '10000'";
            } elseif ($price[0] == '> 100,000') {
                $query .= " AND rrp >= '100000'";
            } else {
                $low = str_replace(',', '', $price[0]);
                $high = str_replace(',', '', $price[1]);
                $query .= " AND rrp >= '$low' AND rrp <= '$high'";
            }
        }


        if ($data['colour']) {
            $query .= " AND colour = '{$data['colour']}'";
        }

        if (!empty($data['kilometers_min'])) {
            $kilometers_min = intval(preg_replace('/\D/', '', $data['kilometers_min']));
            if ($kilometers_min) {
                $query .= " AND km >= $kilometers_min";
            }
        }

        if (!empty($data['kilometers_max'])) {
            $kilometers_max = intval(preg_replace('/\D/', '', $data['kilometers_max']));
            if ($kilometers_max) {
                $query .= " AND km <= $kilometers_max";
            }
        }
    }
//    echo $query;
    return substr($query, 24);
}

class subscriber {

    public $id;
    public $sub_fname;
    public $sub_lname;
    public $desc;
    public $suburb;
    public $tel;
    public $email;
    public $dont_send_mail;
    public $dont_send_sms;
    public $yard;
    public $home_phone;
    public $postcode;
    public $address;
    public $colour;
    public $kilometers_min;
    public $kilometers_max;
    public $comment;
    public $added_date;
    var $Errors;

    public static function UnsubscribeFromCarFinder($email) {
        global $db, $predir;
        $email = strtolower($email);
        $log = "\n-----------------------------------\n Time: " . date('Y-m-d H:i:s') . "\n";
        $log.="$email: Remove all from subscription (car finder)  \n";
        $sql = "DELETE FROM subscription WHERE id IN (SELECT id FROM enquiries WHERE lower(email)='{$email}')";
        if (!$db->sql_query($sql)) {
            $log.="Error: SQL Error!\n" . $db->sql_error_msg($result) . "\n";
            file_put_contents($predir . 'admin/unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);
            return false;
        }
        $affected = $db->sql_affectedrows();
        $log.=" $affected car finder subscriptions were removed!\n";

        file_put_contents($predir . 'admin/unsubscribe_log/' . date("Y-m") . '.log', $log, FILE_APPEND);


        return 1 + $affected;
    }

    public function SetValues($_id, $_sub_fname, $_sub_lname, $_desc, $_suburb, $_tel, $_email, $_colour, $_kilometers_min, $_kilometers_max, $_comment, $_added_date, $_dont_send_mail, $_dont_send_sms, $_yard, $_home_phone, $_postcode, $_address) {
        $this->sub_fname = $_sub_fname;
        $this->sub_fname = $_sub_fname;
        $this->sub_lname = $_sub_lname;
        $this->desc = $_desc;
        $this->suburb = $_suburb;
        $this->tel = $_tel;
        $this->email = $_email;
        $this->colour = $_colour;
        $this->kilometers_min = $_kilometers_min;
        $this->kilometers_min = $_kilometers_max;
        $this->comment = $_comment;
        $this->added_date = $_added_date;
        $this->dont_send_mail = $_dont_send_mail;
        $this->dont_send_sms = $_dont_send_sms;
        $this->yard = $_yard;
        $this->home_phone = $_home_phone;
        $this->postcode = $_postcode;
        $this->address = $_address;
    }

    public function SelectFromDB($_id) {
        global $db;
        if (!ereg("^([0-9]+)$", $_id)) {
            $this->Errors[] = _lang(invalid_id);
            return false;
        }
        $this->id = $_id;
        $sql = 'SELECT * FROM `enquiries` WHERE `id` = ' . $_id;
        if (!($result = $db->sql_query($sql))) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        if ($db->sql_numrows($result) < 1) {
            $this->Errors[] = _lang(no_subscriber_found);
            return false;
        }

        $row = $db->sql_fetchrow($result);
        $this->sub_fname = $row['sub_fname'];
        $this->sub_lname = $row['sub_lname'];
        $this->desc = $row['desc'];
        $this->suburb = $row['suburb'];
        $this->tel = $row['tel'];
        $this->email = $row['email'];
        $this->colour = $row['field4'];
        $this->kilometers_min = $row['field2'];
        $this->kilometers_min = $row['field3'];
        $this->kilometers_min = $row['field1'];
        $this->added_date = $row['added_date'];
        $this->dont_send_mail = $row['dont_send_mail'];
        $this->dont_send_sms = $row['dont_send_sms'];
        $this->yard = $row['yard'];
        $this->home_phone = $row['home_phone'];
        $this->postcode = $row['postcode'];
        $this->address = $row['field5'];
        return true;
    }

    public function Insert($admin = false) {
        global $db;
        if (blocked_number::IsBlocked($this->tel)) {
            $this->Errors[] = _lang(invlid_mobile_number);
            return false;
        }

        if (!$admin && strtolower($_POST['security_code']) != strtolower($_SESSION['security_code']) || true) {

            //$this->Errors[]=_lang(invalid_sec_code);
            //return false;
        }
        $_SESSION['security_code'] = md5(rand(0, 1000));


        $agent = 0;

        // Check enquires in last 30 mins
        $db->sql_query('SELECT sales_agent_id from enquiries where tel=\'' . $this->tel . '\' and type=\'register\'');
        $sales_agent = $db->sql_fetchrowset();
       // var_dump($sales_agent);
        if (count($sales_agent) > 0) {
            $agent = $sales_agent[0]["sales_agent_id"];
        }

        $datetime = new DateTime('yesterday');
        $yesterday = $datetime->format('Y-m-d');
        $datetime2 = new DateTime('today');
        $today = $datetime2->format('Y-m-d');
        $time = date("H:i:s");
        $phone = $this->tel;
        $last_30_minutes = date("Y-m-d H:i:s", strtotime('-2 days'));
        $last_48_hours = date("Y-m-d H:i:s", strtotime('-2 days'));

        // Check enquires in last 48 mins
        $db->sql_query('SELECT id from enquiries where tel=\'' . $this->tel . '\' and stamp_time BETWEEN \'' . $last_30_minutes . '\' AND \'' . $today . ' ' . $time . '\'');
        $tel_finder = $db->sql_fetchrowset();
      //  var_dump($tel_finder);

        if (count($tel_finder) > 0) {
            $agent = 119;
        }

        // Check enquires in last 30 mins
        $db->sql_query('SELECT id from enquiries where tel=\'' . $this->tel . '\' and stamp_time BETWEEN \'' . $last_48_hours . '\' AND \'' . $today . ' ' . $time . '\'');
        $last_48_hours_enq = $db->sql_fetchrowset();
       // var_dump($last_48_hours_enq);

        if (count($last_48_hours_enq) == 0) {
            $agent = 0;
        }


        $this->yard = yards_postcode::GetYardFromPostCode($this->postcode);
        // old
        // $sql = 'INSERT INTO `enquiries` (`type`, `fname`, `lname`, `desc`, `suburb`, `tel`, `email`, `field4`, `field2`, `field3`,`field1`,`added_date`, `dont_send_mail`, `dont_send_sms`, `inital_dont_send_mail`, `yard`, `home_phone`, `postcode`,  `field5`) VALUES (\'car-finder\', \'' . PreSql($this->sub_fname)['come_from_website'] = "OzCar"; . '\',  \'' . PreSql($this->sub_lname) . '\',  \'' . addslashes($this->desc) . ' \',  \'' . PreSql($this->suburb) . '\',  \'' . PreSql($this->tel) . '\',  \'' . PreSql($this->email) . '\',  \'' . PreSql($this->colour) . '\',  \'' . PreSql($this->kilometers_min) . '\',  \'' . PreSql($this->kilometers_max) . '\',  \'' . PreSql($this->comment) . '\',  \'' . date('Y-m-d') . '\',  \'' . PreSql($this->dont_send_mail) . '\', \'' . PreSql($this->dont_send_mail) . '\',  \'' . PreSql($this->dont_send_mail) . '\',  \'' . $this->yard . '\',  \'' . PreSql($this->home_phone) . '\',  \'' . PreSql($this->postcode) . '\',  \'' . PreSql($this->address) . '\')';
        $sql = 'INSERT INTO `enquiries` (`type`, `fname`, `lname`, `desc`, `suburb`, `tel`, `email`, `field4`, `field2`, `field3`,`field1`,`added_date`, `dont_send_mail`, `dont_send_sms`, `inital_dont_send_mail`, `yard`, `home_phone`, `postcode`,  `field5`,`modified`,`sales_agent_id`,`status`,`come_from_website`) VALUES (\'car-finder\', \'' . PreSql($this->sub_fname) . '\',  \'' . PreSql($this->sub_lname) . '\',  \'' . PreSql($this->desc, 0) . ' \',  \'' . PreSql($this->suburb) . '\',  \'' . PreSql($this->tel) . '\',  \'' . PreSql($this->email) . '\',  \'' . PreSql($this->colour) . '\',  \'' . PreSql($this->kilometers_min) . '\',  \'' . PreSql($this->kilometers_max) . '\',  \'' . PreSql($this->comment) . '\',  \'' . date('Y-m-d') . '\',  \'' . PreSql($this->dont_send_mail) . '\', \'' . PreSql($this->dont_send_mail) . '\',  \'' . PreSql($this->dont_send_mail) . '\',  \'' . $this->yard . '\',  \'' . PreSql($this->tel) . '\',  \'' . PreSql($this->postcode) . '\',  \'' . PreSql($this->address) . '\' ,now(),' . $agent . ',0,\'OzCar\')';
        $result = $db->sql_query($sql);
        if (!$result) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        $db->sql_query("SELECT currval('enquiries_id_seq') AS last_value");
        $last_value = $db->sql_fetchrowset();
        $this->id = $last_value[0]["last_value"];
        //var_dump($this->id );
        return $this->id;
    }

    public function Add($admin = false) {
        global $predir, $db;
        $op = 'Add';
        $db->sql_query('SELECT DISTINCT LOWER(colour) as clr from afs_stock2');
        $dbcolours = $db->sql_fetchrowset();
        $colours = array();
        foreach ($dbcolours as $clr) {
            if ($clr['clr']) {
                $colours[] = $clr['clr'];
            }
        }
        include $predir . 'forms/fsubscriber.php';
    }

    public function Delete() {
        global $db;

        $sql = 'DELETE FROM `enquiries` WHERE `id`=' . $this->id;
        if (!$db->sql_query($sql)) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        return true;
    }

    public function Subscribe($validate = true) {
        if ($validate) {
            if (!$admin && strtolower($_POST['security_code']) != strtolower($_SESSION['security_code'])) {
                $this->Errors[] = _lang(invalid_sec_code);
                return false;
            }
            $_SESSION['security_code'] = rand(0, 121);
            if (trim($this->desc) == "" || trim($this->desc) == "WHERE stock_no IS NOT NULL") {
                $this->Errors[] = _lang(should_specify_paramters);
                return false;
            }
        }

        if (0&&$id = subscriber::GetSubscriberID($this->email)) {
            $this->id = $id;

            $this->yard = yards_postcode::GetYardFromPostCode($this->postcode);


            if (!$this->Update()) {
                return false;
            }
            if (!new_subscription($id, $this->desc)) {
                return false;
            }

            return $id;
        } else {
            if (($id = $this->Insert(false))) {
                if (!new_subscription($id, $this->desc)) {
                    return false;
                }
                return $id;
            } else {
                return false;
            }
        }
    }

    public function Edit($_op = 'Update', $admin = false) {
        $id = PreForm($this->id);
        $sub_fname = PreForm($this->sub_fname);
        $sub_lname = PreForm($this->sub_lname);
        $desc = PreForm($this->desc);
        $suburb = PreForm($this->suburb);
        $tel = PreForm($this->tel);
        $email = PreForm($this->email);
        $colour = PreForm($this->colour);
        $kilometers_min = PreForm($this->kilometers_min);
        $kilometers_max = PreForm($this->kilometers_max);
        $comment = PreForm($this->comment);
        $added_date = PreForm($this->added_date);
        $dont_send_mail = PreForm($this->dont_send_mail);
        $dont_send_sms = PreForm($this->dont_send_sms);
        $yard = PreForm($this->yard);
        $home_phone = PreForm($this->home_phone);
        $postcode = PreForm($this->postcode);
        $address = PreForm($this->address);
        global $predir;

        $op = $_op;

        include $predir . 'forms/fsubscriber.php';
    }

    public function Update() {
        global $db;
//        echo $this->desc; 
        $sql = 'UPDATE `enquiries` SET `type` = \'car-finder\',`modified`=now(), `fname` = \'' . PreSql($this->sub_fname) . '\', `lname` = \'' . PreSql($this->sub_lname) . '\', `desc` = \'' . addslashes($this->desc) . '\', `suburb` = \'' . PreSql($this->suburb) . '\', `tel` = \'' . PreSql($this->tel) . '\', `email` = \'' . PreSql($this->email) . '\', `field4` = \'' . PreSql($this->colour) . '\', `field2` = \'' . PreSql($this->kilometers_min) . '\', `field3` = \'' . PreSql($this->kilometers_max) . '\', `field1` = \'' . PreSql($this->comment) . '\', `dont_send_mail` = \'' . PreSql($this->dont_send_mail) . '\',`dont_send_sms` = \'' . PreSql($this->dont_send_sms) . '\', `yard` = \'' . PreSql($this->yard) . '\', `home_phone` = \'' . PreSql($this->home_phone) . '\', `postcode` = \'' . PreSql($this->postcode) . '\', `field5` = \'' . PreSql($this->address) . '\' WHERE `id` = ' . $this->id;
//        echo $sql;
        if (!($result = $db->sql_query($sql))) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        return true;
    }

    public function get_messsage() {
        $msg = '';
        $date_sent = date('j/n/y');
        $time_sent = date('h.i a');
        $desc = email(preg_replace('/LOWER\(([^\)]+)\)/i', '$1', $this->desc), $this->email);
        $msg.=<<<MSG
            {$this->yard} {$date_sent} {$time_sent} {$this->postcode}\n
            CAR FINDER\n
            {$this->sub_fname} {$this->sub_lname} 
            M: {$this->tel}
            E: {$this->email}\n
            {$desc}          
MSG;
        return $msg;
    }

    public function SendEnquiryMail() {
        global $admin_mails;
//        $msg .= "Suggest allocate this customer to yard {$this->yard} by their supplied postcode.\n\n";
//        $msg .= email(preg_replace('/LOWER\(([^\)]+)\)/i', '$1', $this->desc), $this->email);
//        $msg .= "\n\n" . _lang("enquery_id") . ": SCRB$this->id\n";
//        //$msg .= _lang("enquery_date").": $this->added_date\n";
//        $msg .= "First name: $this->sub_fname\n";
//        $msg .= "Last Name: $this->sub_lname\n";
//        $msg .= "Post code: $this->postcode\n";
//        $msg .= "Mobile: $this->tel \n";
//        $msg .= "Email: $this->email\n\n";
//        $msg .= _lang("receive_mail") . ": " . (($this->dont_send_mail) ? "No" : "Yes") . "\n\n";
//        $msg .= "\nThis email form was submitted from\n" . $_SERVER['HTTP_REFERER'] . "\n";
        $msg = $this->get_messsage();


        MyMail($admin_mails, "Car Finder", nl2br($msg), "From: $this->email\nReply-To: $this->email\nContent-Type: text/html", "Subscription to Specific Car Search");

        //MyMail('developer@silvertrees.net',"Car Finder",nl2br($msg), "From: $this->email\nReply-To: $this->email\nContent-Type: text/html","Subscription to Specific Car Search");
        //MyMail('developer@silvertrees.net',"Car Finder",nl2br($msg), "From: $this->email\nReply-To: $this->email\nContent-Type: text/html","Subscription to Specific Car Search");
    }

    public function FromForm($data = array()) {
        if (empty($data)) {
            $data = $_POST;
        }

        $this->id = PostForm($data['id']);
        $this->sub_fname = PostForm($data['sub_fname'], 50);
        $this->sub_lname = PostForm($data['sub_lname'], 50);
        $this->desc = PostForm($data['desc'], 255);
        $this->suburb = PostForm($data['suburb'], 50);
        $this->tel = str_replace(" ", "", PostForm($data['tel'], 50));
        $this->email = PostForm($data['email'], 255);
        $this->colour = PostForm($data['colour'], 255);
        $this->kilometers_min = intval(PostForm($data['kilometers_min'], 255));
        $this->kilometers_max = intval(PostForm($data['kilometers_max'], 255));
        $this->comment = PostForm($data['comment'], 255);
        $this->dont_send_mail = intval(PostForm($data['dont_send_mail']));
        $this->dont_send_sms = intval(PostForm($data['dont_send_sms']));
        $this->yard = PostForm($data['yard']);
        $this->home_phone = PostForm($data['home_phone']);
        $this->postcode = PostForm($data['postcode']);
        $this->address = PostForm($data['address']);
        $this->desc = PostForm(BuildFilter($data));
//        echo $this->desc;
    }

    public static function AdminListsubscribers() {
        global $db, $list_per_page;
        $per_page = $list_per_page;
        if (!isset($_GET['admin_page']) || $_GET['admin_page'] < 1)
            $_GET['admin_page'] = 1;
        $admin_page = $_GET['admin_page'];

        if (isset($_GET['q_fname']) && $_GET['q_fname'] != "")
            $WHERE.=" AND lower(`sub_fname`) LIKE lower('" . $_GET['q_fname'] . "%') ";

        if (isset($_GET['q_lname']) && $_GET['q_lname'] != "")
            $WHERE.=" AND lower(`sub_lname`) LIKE lower('" . $_GET['q_lname'] . "%') ";

        if (isset($_GET['q_email']) && $_GET['q_email'] != "")
            $WHERE.=" AND lower(`email`) LIKE lower('" . $_GET['q_email'] . "%') ";

        $WHERE .= "	AND type='car-finder' ";
        $sql = 'SELECT * FROM `enquiries` WHERE true ' . $WHERE . ' ORDER BY `id` DESC LIMIT ' . (($admin_page - 1) * $per_page) . ',' . ($per_page + 1) . ' ';

        $export_sql = 'SELECT `id` as `' . _lang(enquery_id) . '` , `added_date` as `' . _lang(enquery_date) . '` ,  `sub_fname` as `First Name` ,`sub_lname` as `Surame`, `suburb` as `Suburb`, `email` as `Email Address`, `tel` as `home_phone`, `desc` as `Trade-In Description`,CASE WHEN `dont_send_mail` THEN \'no\' ELSE \'yes\' END as `' . _lang(receive_mail) . '` FROM `enquiries` WHERE true ' . $WHERE . ' ORDER BY `id` DESC ';



        $result = $db->sql_query($sql) or die($sql . "<br/>" . $db->sql_error_msg($result));
        $no = $db->sql_numrows($result);

        $page_no = PageCount(GetUnlimitedCount($sql), $per_page);
        $List = '<h3 class="admin_title">' . _lang(list_subscriber) . ':</h3>';

        $List.= '<form action="" method="get" name="Filter" id="Filter" >
		<table class="adminlist" width="600"><tr class="header">
		<td width="10%">ID</td><td width="20%">' . _lang(fname) . '<br/><input class="filter" name="q_fname" type="text" value="' . $_GET['q_fname'] . '" /> </td>
		<td width="20%">' . _lang(lname) . '<br/><input class="filter" name="q_lname" type="text" value="' . $_GET['q_lname'] . '" /> </td>
		<td width="30%">' . _lang(email) . '<br/><input class="filter" name="q_email" type="text" value="' . $_GET['q_email'] . '" /></td>
		<td width="20%"><input name="go" type="submit" value="Go" />
		<input name="Reset" type="button" onclick="document.Filter.q_lname.value=\'\';document.Filter.q_fname.value=\'\';document.Filter.q_email.value=\'\';document.Filter.submit()" value="All" /> ' . _lang(delete) . '<br/>
		</td>
		</tr> ';
        while (($row = $db->sql_fetchrow($result)) && $i < $per_page) {

            if ($i % 2.0 > 0)
                $class = "odd";
            else
                $class = "even";
            $i++;

            $List.= '<tr class="' . $class . '"><td width="10%">' . $row[id] . '</td><td width="20%">' .
                    "<a href=\"?id=$row[id]&op=Edit\">$row[sub_fname]</a></td>" .
                    "<td width=\"20%\"><a href=\"?id=$row[id]&op=Edit\">$row[sub_lname]</a></td>" .
                    "<td width=\"30%\"><a href=\"?id=$row[id]&op=Edit\">$row[email]</a></td>" .
                    "<td width=\"20%\"><a href=\"javascript:if (confirm('" . _lang(sure_delete_subscriber) . "')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
        }
        $List.= '</table></form>';
        $List.="<div class=\"admin_list_control\">";
        if ($admin_page > 1)
            $List.= "&laquo; <a href=\"?q_fname={$_GET[q_fname]}&q_lname={$_GET[q_lname]}&q_email={$_GET[q_email]}&admin_page=" . ($admin_page - 1) . "\" >" . _lang(list_previous_page) . " $per_page </a>&nbsp;&nbsp; ";

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
            $List.= "&nbsp;<a href=\"?q_fname={$_GET[q_fname]}&q_lname={$_GET[q_lname]}&q_email={$_GET[q_email]}&admin_page=" . ($admin_page + 1) . "\" > " . _lang(list_next_page) . " $per_page</a> &raquo;";

        $List.="</div><br/>";
        $List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
		<label for="job_id">&nbsp;&nbsp;<b>' . _lang(enter_id) . ':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\'' . _lang(sure_delete_subscriber) . '\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';

        if ($no > 0)
            $List.='<input type="button" name="export" value="Export List To CSV" onclick="document.location=\'tocsv.php?file_name=trade_in_' . date('Y-m-d') . '&sql=' . str_replace("'", "\'", $export_sql) . '\'" />
	<br/>';
        return $List;
    }

    public static function GetSubscriberID($email) {
        global $db;
        $sql = 'SELECT `id` FROM `enquiries` WHERE lower(`email`)=  lower(\'' . $email . '\') AND type = \'car-finder\'';
        $result = $db->sql_query($sql) or die($db->sql_error_msg($result));
        $row = $db->sql_fetchrow($result);
        return $row[0];
    }

    public function SetAutoResponses() {
        global $email_autoresponse_time;
        $auto_mail = new send_email();
        //immediate
        $emails_count = 15;

        if ($this->dont_send_mail)
            $emails_count = 4;

        for ($i = 2; $i < $emails_count; $i++) {
            if (!$auto_mail->NewAutoEmail($i, $email_autoresponse_time[$i], $this->email, $this->sub_fname, 'sub' . $this->id)) {
                $this->Errors = $auto_mail->Errors;
                return false;
            }
        }
        return true;
    }

}

?>