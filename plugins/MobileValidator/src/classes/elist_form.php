<?php
session_name('CAKEPHP');
@session_start();


class elist_form
{

	public static $form_tables=array('fnc_id'=>'finance','fwd_id'=>'f4wd','offer_id'=>'offer','cash_id'=>'cash','sale_id'=>'sale','spc_id'=>'special','trd_id'=>'trader','win_id'=>'winner','subscriberid'=>'elist_form','id!'=>'enquiries');
//	public static $form_tables=array('fnc_id'=>'finance','fwd_id'=>'f4wd','offer_id'=>'offer','cash_id'=>'cash','sale_id'=>'sale','spc_id'=>'special','id'=>'subscriber','trd_id'=>'trader','win_id'=>'winner','subscriberid'=>'elist_form','id!'=>'enquiries');

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
	public  $owner;
	public  $yard;
	public  $comp_id;
	public  $rep_code;
	public  $dont_send_sms;
	public  $table_name;
	public  $added_date;


	public $type;
	public $form_obj;

	function elist_form($type=false)
	{
		if(!$type || $type=="internet" || $type=="walkin")
		{
			$this->type="elist_form";
			//$this->form_obj=$this;
		}
		else
		{

			$this->type=$type;
			$code='$this->form_obj=new '.$type.'();';
			eval($code);

		}



	}


	var  $Errors;

	public static  $SErrors;

	public static  $sources=array("Walkin","TV","Radio","Newspaper","Drive By",  "Previous Owner", "Friend", "Yellow Pages", "Direct Mail","Internet", "Unknown", "Car Enquire","F4wd","Finance","Offer","Cash","Special","Subscriber","Trade-in","10k comp");
	public static  $sources_values=array("walkin","tv",'radio','newspaper','drive by',"previous owner", "friend", "yellow pages", "direct mail", "internet", "unknown","car enquire","f4wd","finance","offer","cash","special","subscriber","trade-in","10k comp");


	public static  $enquiry_types=array
	(
		
		
		"finance"=>"finance",
		"offer"=>"Offer",
		"cash"=>"Cash",
		"special"=>"Hot Stock & One Offs",
		"subscriber"=>"Subscriber",
		"trade-in"=>"Trade-in",
		"10k comp"=>"10k comp"
	);
	
	public static  $come_froms=array(
		"walkin"=>"Walkin",
		"tv"=>"Tv",
		"radio"=>"Radio",
		"newspaper"=>"Newspaper",
		"drive by"=>"Drive by" ,  
		"previous owner"=>"Previous owner", 
		"friend"=>"Friend", 
		"yellow pages"=> "Yellow pages", 
		"direct mail"=>"Direct mail",
		"internet"=> "Internet", 
		"unknown"=>"Unknown"
	);
	

	public static $yards=array("A","B","C","D","F","G","I","K","L","N","P","Q",'R', 'T', 'Y');
	public static $yard_names=array("A"=>'Albury','B'=>'Burwood',"C"=>'Campbelltown',"D"=>'Dubbo',"F"=>'Penrith',"G"=>'Gosford',"I"=>'Windsor',"K"=>'Blacktown',"L"=>'Lansvale',"N"=>'Cardiff',"P"=>'Parramatta',"Q"=>'Woodridge','R' => 'Wagga', 'T' => 'Tamworth', 'Y'=>'Y');

	public static function init() {
		global $db;
		/* @var $db sql_db */
		self::$yards = array(); self::$yard_names = array();
		if ($db->sql_query('SELECT * FROM yard ORDER BY code')){
			while (($row = $db->sql_fetchrow()) !== false){
				self::$yards[] = $row['code'];
				self::$yard_names[$row['code']] = $row['name'];
			}
		}
	}


	public function SetValues($_subscriberid = false,  $_fname = false,  $_lname = false,  $_suburb = false,$_address = false,$_postcode = false,  $_tel = false,  $_email = false,  $_source = false,  $_yard = false,  $_comp_id = false,  $_rep_code = false,  $_dont_send_mail = false, $_table_name = false,  $_added_date = false,$_home_phone=false , $_dont_send_sms=false,$_owner = false )
	{
		$this->fname=$_fname;
		$this->lname=$_lname;
		$this->suburb=$_suburb;
		$this->address=$_address;
		$this->postcode=$_postcode;
		$this->tel=$_tel;
		$this->email=$_email;
		$this->source=$_source;
		$this->owner=$_owner;
		$this->yard=$_yard;
		$this->comp_id=$_comp_id;
		$this->rep_code=$_rep_code;
		$this->dont_send_mail=$_dont_send_mail;
		$this->table_name=$_table_name;
		$this->added_date=$_added_date;
		$this->home_phone=$_home_phone;
		$this->dont_send_sms=$_dont_send_sms;

	}



	public function SelectFromDB($_subscriberid)
	{
		if($this->type!="elist_form")
		return $this->form_obj->SelectFromDB($_subscriberid);

		global $db;
		if (!ereg("^([0-9]+)$",$_subscriberid))
		{
			$this->Errors[]=_lang(invalid_subscriberid);
			return false;
		}
		$this->subscriberid=$_subscriberid;
		$sql = 'SELECT * FROM `elist_form` WHERE `subscriberid` = '.$_subscriberid;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_elist_form_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->fname=$row['fname'];
		$this->lname=$row['lname'];
		$this->suburb=$row['suburb'];
		$this->address=$row['address'];
		$this->postcode=$row['postcode'];
		$this->tel=$row['tel'];
		$this->email=$row['email'];
		$this->source=$row['source'];
		$this->owner=$row['owner'];
		$this->yard=$row['yard'];
		$this->comp_id=$row['comp_id'];
		$this->rep_code=$row['rep_code'];
		$this->dont_send_mail=$row['dont_send_mail'];
		$this->added_date=$row['added_date'];
		$this->home_phone=$row['home_phone'];
		$this->dont_send_sms=$row['dont_send_sms'];
		return true;



	}

	public function Insert($subscriberid=false)
	{
		if($this->type!="elist_form")
		return $this->form_obj->Insert(true);

		global $db;

		if (empty($this->yard)){
			$this->yard=yards_postcode::GetYardFromPostCode($this->postcode);
		}
                if(!$this->dont_send_sms)
                        $this->dont_send_sms="0";

                if(!$this->dont_send_mail)
                        $this->dont_send_mail="0";

                
		$sql = 'INSERT INTO `elist_form` (`fname`, `lname`, `suburb`, `address`, `postcode`, `tel`, `home_phone`, `dont_send_sms`, `email`, `source`, `owner`,`yard`, `comp_id`, `rep_code`, `dont_send_mail`, `inital_dont_send_mail`,  `added_date`) VALUES (\''.PreSql($this->fname).'\',  \''.PreSql($this->lname).'\',  \''.PreSql($this->suburb).'\',  \''.PreSql($this->address).'\',  \''.PreSql($this->postcode).'\',  \''.PreSql($this->tel).'\',  \''.PreSql($this->home_phone).'\',  \''.PreSql($this->dont_send_sms).'\',  \''.PreSql($this->email).'\',  \''.PreSql($this->source).'\', \''.PreSql($this->owner).'\', \''.PreSql($this->yard).'\',  \''.PreSql($this->comp_id).'\',  \''.PreSql($this->rep_code).'\',  \''.PreSql($this->dont_send_mail).'\', \''.PreSql($this->dont_send_mail).'\',  \''.date('Y-m-d').'\')';
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return $db->sql_nextid("subscriber_id");
	}


	public function Add()
	{
		$op='Add';
		include '../forms/felist_form.php';

	}

	public function Delete()
	{
		if($this->type!="elist_form")
		return $this->form_obj->Delete();

		global $db;

		$sql = 'DELETE FROM `elist_form` WHERE `subscriberid`='.$this->subscriberid;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update',$type="elist_form")
	{
		if($this->type!="elist_form")
		return $this->form_obj->Edit($_op,true);

		$subscriberid=PreForm($this->subscriberid);
		$fname=PreForm($this->fname);
		$lname=PreForm($this->lname);
		$suburb=PreForm($this->suburb);
		$address=PreForm($this->address);
		$postcode=PreForm($this->postcode);
		$tel=PreForm($this->tel);
		$email=PreForm($this->email);
		$source=PreForm($this->source);
		$owner=PreForm($this->owner);
		$yard=PreForm($this->yard);
		$comp_id=PreForm($this->comp_id);
		$rep_code=PreForm($this->rep_code);
		$home_phone=PreForm($this->home_phone);
		$dont_send_sms=PreForm($this->dont_send_sms);
		$dont_send_mail=PreForm($this->dont_send_mail);
		$added_date=PreForm($this->added_date);

		$op=$_op;
		include '../forms/felist_form.php';
	}

	public function Update()
	{

		if($this->type!="elist_form")
		return $this->form_obj->Update(true);

		global $db;
                 if(!$this->dont_send_sms)
                        $this->dont_send_sms="0";

                if(!$this->dont_send_mail)
                        $this->dont_send_mail="0";

		$sql = 'UPDATE `elist_form` SET `fname` = \''.PreSql($this->fname).'\', `lname` = \''.PreSql($this->lname).'\', `suburb` = \''.PreSql($this->suburb).'\', `address` = \''.PreSql($this->address).'\', `home_phone` = \''.PreSql($this->home_phone).'\', `dont_send_sms` = \''.PreSql($this->dont_send_sms).'\',`postcode` = \''.PreSql($this->postcode).'\', `tel` = \''.PreSql($this->tel).'\', `email` = \''.PreSql($this->email).'\', `source` = \''.PreSql($this->source).'\', `owner` = \''.PreSql($this->owner).'\', `yard` = \''.PreSql($this->yard).'\', `comp_id` = \''.PreSql($this->comp_id).'\', `rep_code` = \''.PreSql($this->rep_code).'\', `dont_send_mail` = \''.PreSql($this->dont_send_mail).'\' WHERE `subscriberid` = '.$this->subscriberid;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;
	}

	public function FromForm()
	{
		if($this->type!="elist_form")
		return $this->form_obj->FromForm();
		$this->subscriberid=PostForm($_POST['subscriberid']);
		$this->fname=PostForm(trim($_POST['fname']));
		$this->lname=PostForm(trim($_POST['lname']));
		$this->address=PostForm(trim($_POST['address']));
		$this->suburb=PostForm(trim($_POST['suburb']));
		$this->postcode=PostForm(trim($_POST['postcode']));
		$this->tel=PostForm(trim($_POST['tel']));
		$this->email=PostForm(trim($_POST['email']));
		$this->owner=PostForm(trim($_POST['owner']));
		$this->source=PostForm(trim($_POST['source']));
		$this->yard=PostForm(trim($_POST['yard']));
		$this->comp_id=PostForm(trim($_POST['comp_id']));
		$this->rep_code=PostForm(trim($_POST['rep_code']));
		$this->dont_send_mail=PostForm(trim($_POST['dont_send_mail']));
		$this->home_phone=PostForm(trim($_POST['home_phone']));
		$this->dont_send_sms=PostForm(trim($_POST['dont_send_sms']));

	}

	public function GetErrors()
	{
		if($this->type!="elist_form")
		$errs=$this->form_obj->Errors;
		else
		$errs=$this->Errors;

		if(sizeof($errs)==0)
		$errs=array("Unkonwn Error:10921");
		return $errs;
	}


	public static function AdminListelist_forms()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		if(isset($_POST['admin_page']) && $_POST['admin_page']>=1)
		$_GET['admin_page']=$_POST['admin_page'];

		if($_GET['email'])
		{
			$_POST['email']=$_GET['email'];
			$_GET['filter']=="clear";
		}



		$admin_page =$_GET['admin_page'];

		if(isset($_POST['id'])) $_SESSION['ef_id']=intval($_POST['id']);
		if(isset($_POST['email'])) $_SESSION['ef_email']=strtolower(trim($_POST['email']));
		if(isset($_POST['fname'])) $_SESSION['ef_fname']=strtolower(trim($_POST['fname']));
		if(isset($_POST['lname'])) $_SESSION['ef_lname']=strtolower(trim(($_POST['lname'])));
		if(isset($_POST['tel'])) $_SESSION['ef_tel']=strtolower(trim($_POST['tel']));
		if(isset($_POST['comp_id'])) $_SESSION['ef_comp_id']=strtolower(trim($_POST['comp_id']));
		if(isset($_POST['rep_code'])) $_SESSION['ef_rep_code']=strtolower(trim($_POST['rep_code']));
		if(isset($_POST['come_from'])) $_SESSION['ef_come_from']=trim($_POST['come_from']);
		if(isset($_POST['enquiry_type'])) $_SESSION['ef_enquiry_type']=trim($_POST['enquiry_type']);
		if(isset($_POST['from_date'])) $_SESSION['ef_from_date']=$_POST['from_date'];
		if(isset($_POST['to_date'])) $_SESSION['ef_to_date']=$_POST['to_date'];
		if(isset($_POST['yard'])) $_SESSION['ef_yard']=$_POST['yard'];
		if(isset($_POST['postcode'])) $_SESSION['ef_postcode']=trim($_POST['postcode']);
		if(isset($_POST['is_weekly_subscriber'])) $_SESSION['ef_is_weekly_subscriber']=$_POST['is_weekly_subscriber'];
		if(isset($_POST['is_sms_subscriber'])) $_SESSION['ef_is_sms_subscriber']=$_POST['is_sms_subscriber'];

		if(isset($_POST['order_by'])) $_SESSION['ef_order_by']=$_POST['order_by'];

		$WHERE =" WHERE 1=1 ";

		if(isset($_GET['filter'])&&$_GET['filter']=="clear")
		{
			session_destroy();
			$_SESSION=null;
		}

		if(isset($_SESSION['ef_id']) && $_SESSION['ef_id']!="" ) $WHERE.=" AND `subscriberid` = {$_SESSION['ef_id']}";
		if(isset($_SESSION['ef_email'])&& $_SESSION['ef_email']!="" ) $WHERE.=" AND lower(`email`) LIKE '{$_SESSION['ef_email']}%' ";
		if(isset($_SESSION['ef_fname']) && $_SESSION['ef_fname']!="" ) $WHERE.=" AND lower(`fname`) LIKE '{$_SESSION['ef_fname']}%' ";
		if(isset($_SESSION['ef_lname']) && $_SESSION['ef_lname']!="" ) $WHERE.=" AND lower(`lname`) LIKE '{$_SESSION['ef_lname']}%' ";

		//if(isset($_SESSION['ef_tel']) && $_SESSION['ef_tel']!="" && $_SESSION['ef_tel']!="999") $WHERE.=" AND (`tel` IS NULL OR lower(`tel`) = '999' )";
		/*else*/ if(isset($_SESSION['ef_tel']) && $_SESSION['ef_tel']!="" ) $WHERE.=" AND lower(`tel`) LIKE '{$_SESSION['ef_tel']}%' ";

		if(isset($_SESSION['ef_comp_id']) && $_SESSION['ef_comp_id']!="" ) $WHERE.=" AND lower(`comp_id`) LIKE '{$_SESSION['ef_comp_id']}%' ";
		if(isset($_SESSION['ef_rep_code']) && $_SESSION['ef_rep_code']!="" ) $WHERE.=" AND lower(`rep_code`) LIKE '{$_SESSION['ef_rep_code']}%' ";
		if(isset($_SESSION['ef_come_from']) && $_SESSION['ef_come_from']!="") $WHERE.=" AND `come_from` LIKE '{$_SESSION['ef_come_from']}%' ";
		if(isset($_SESSION['ef_enquiry_type']) && $_SESSION['ef_enquiry_type']!="") $WHERE.=" AND `enquiry_type` LIKE '{$_SESSION['ef_enquiry_type']}%' ";

		if(isset($_SESSION['ef_from_date']) && $_SESSION['ef_from_date']!="" && strtotime($_SESSION['ef_from_date'])!="" ) $WHERE.=" AND date_part('epoch', `stamp_time`)  >= ".strtotime($_SESSION['ef_from_date'])." ";
		if(isset($_SESSION['ef_to_date']) && $_SESSION['ef_to_date']!=""  && strtotime($_SESSION['ef_to_date'])!="" ) $WHERE.=" AND date_part('epoch', stamp_time) <= ".(strtotime($_SESSION['ef_to_date'])+24*60*60)." ";

		if(isset($_SESSION['ef_yard']) && $_SESSION['ef_yard']!="" && $_SESSION['ef_yard']=="-") $WHERE.=" AND `yard` IS NULL  ";
		else if(isset($_SESSION['ef_yard']) && $_SESSION['ef_yard']!="" ) $WHERE.=" AND `yard` LIKE '{$_SESSION['ef_yard']}%' ";

		if(isset($_SESSION['ef_postcode']) && $_SESSION['ef_postcode']!="" && $_SESSION['ef_postcode']=="-") $WHERE.=" AND (`postcode` IS NULL OR postcode='' )";
		else if(isset($_SESSION['ef_postcode']) && $_SESSION['ef_postcode']!="" ) $WHERE.=" AND `postcode` LIKE '{$_SESSION['ef_postcode']}' ";

		if(isset($_SESSION['ef_is_weekly_subscriber']) && $_SESSION['ef_is_weekly_subscriber']!="" && $_SESSION['ef_is_weekly_subscriber']=="yes" ) $WHERE.=" AND  subscriberid IN (select max(subscriberid) from afs_form a group by email ) AND (dont_send_mail IS NULL OR dont_send_mail = false) ";

		if(isset($_SESSION['ef_is_sms_subscriber']) && $_SESSION['ef_is_sms_subscriber']!="" && $_SESSION['ef_is_sms_subscriber']=="yes" ) $WHERE.=" AND  subscriberid IN (select max(subscriberid) from afs_form a2 group by tel ) AND (dont_send_sms IS NULL OR dont_send_sms = false) ";


		if(isset($_SESSION['ef_order_by']) && $_SESSION['ef_order_by']!="" ) $ORDER_BY.="  ORDER BY {$_SESSION['ef_order_by']} ";
		else $ORDER_BY.="  ORDER BY stamp_time DESC ";



		if(($_SESSION['ef_yard']!="") || ($_SESSION['ef_postcode']!="") || ($_SESSION['ef_to_date']!="") || ($_SESSION['ef_to_date']!="") || ($_SESSION['ef_is_weekly_subscriber']=="yes") || ($_SESSION['ef_is_sms_subscriber']=="yes") )
		$display="block";
		else
		$display="none";




		if($_SESSION['ef_from_date']!="" && strtotime($_SESSION['ef_from_date'])=="")
		{
			$errors[]="Invalide From Date";

		}

		if($_SESSION['ef_to_date']!="" && strtotime($_SESSION['ef_to_date'])=="")
		{
			$errors[]="Invalide To Date";
		}

		if(sizeof($errors))
		PrintErrors($errors);




		$sql = 'SELECT * FROM `afs_form` a0 '.$WHERE.$ORDER_BY.'  LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
	


		$sql_exporter = 'SELECT subscriberid AS "Ref", fname AS "First Name" , lname AS "Last Name", postcode AS "Postcode", \' \'||tel AS "Mobile",  home_phone AS "Home Phone", email AS "Email Address",
       come_from AS "Source",enquiry_type AS "Enquiry Type", yard AS "Yard", rep_code AS "Rep Code", comp_id AS "Comp ID",(case when dont_send_mail then \'No\' else \'Yes\' end)  AS "Send Email",(case when dont_send_sms then \'No\' else \'Yes\' end)  AS "Send SMS",  stamp_time::date AS "Added Date"
       
       from `afs_form` '.$WHERE.' And `type` not in (\'registration_expiry\',\'post_delivery\',\'service\',\'customer_birthday\',\'customer_birthday\') ';
		//       from `afs_form` '.$WHERE.' ';

		$sql_email_sender = 'SELECT * from `afs_form` '.$WHERE.'  ';


		$result = $db->sql_query($sql) or die(session_destroy(). $sql."<br/>".$db->sql_error_msg($result)) ;

		$no=$db->sql_numrows($result);

		$page_no=PageCount($total_found=GetUnlimitedCount($sql),$per_page);

		//$List= '<p class="admin_title">'._lang(list_elist_form).':</p>' ;

		$List.= '
		
<script type="text/javascript" src="../scripts/calendar/calendar.js"></script>
<script type="text/javascript" src="../scripts/calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="../scripts/calendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../scripts/calendar/calendar-blue.css" title="win2k-cold-1" />		
		<form method="post" action="?" > 
		
		<!--<h4><a href="javascript:void(0);" onclick="if(document.getElementById(\'more_options\').style.display==\'none\') document.getElementById(\'more_options\').style.display=\'block\'; else document.getElementById(\'more_options\').style.display=\'none\';  "> More Options</a> </h4>-->
		
		<div  style="display:'./*$display*/"block".';" id="more_options">
		
		From: <input style="width:75px;" type="from_date" id="from_date" value="'.$_SESSION['ef_from_date'].'" name="from_date" />  
		<button class="calender_trigger" type="reset" id="f_trigger_a">...</button>
		&nbsp;To:<input style="width:75px;" type="to_date" id="to_date" value="'.$_SESSION['ef_to_date'].'" name="to_date" />
		<button class="calender_trigger" type="reset" id="f_trigger_b">...</button>
		
		
		&nbsp;
			Subscribers only:
			<select name="is_weekly_subscriber" id="is_weekly_subscriber" >
			'.ListOptions(array("No","Yes"),array("no","yes"),$_SESSION['ef_is_weekly_subscriber'],true) .'
			</select>
		
		&nbsp;	
			SMS Subscribers only:
			<select name="is_sms_subscriber" id="is_sms_subscriber" >
			'.ListOptions(array("No","Yes"),array("no","yes"),$_SESSION['ef_is_sms_subscriber'],true) .'
			</select>
			
		
		&nbsp;
			Yard: 
			<select name="yard" id="yard" >
			<option value="">All</option>
			<option value="-">Empty</option>
			'.ListOptions(elist_form::$yards,elist_form::$yards,$_SESSION['ef_yard'],true) .'
			</select>
			
		&nbsp;
			Postcode: 
			<input style="width:75px;" type="text" name="postcode" id="postcode" value="'.$_SESSION['ef_postcode'].'" >
			
			
			<input type="submit" styel="float:left;clear:none;" value="GO" />
			<input type="button" onclick="document.location.href=\'?filter=clear\';" styel="float:leftclear:none;" value="Clear" />
		</div>		

		<div id="afs_list" style="overflow: scroll;width:100%">
		<table class="adminlist" width="600">
		<tr class="header"> 
		<td width="10%">ID</td>
		<td width="10%">Send Email</td>
		<td width="10%">Send SMS</td>
		<td width="15%">'._lang(email).'</td>
		<td width="15%">First Name</td>
		<td width="15%">Last Name</td>
		<td width="15%">Mobile</td>
		<td width="10%">Comp ID</td>		
		<td width="10%">Rep Code</td>		
		<td width="15%">Source</td>
		<td width="15%">Type</td>
		<td width="15%">Date</td>
		<td width="30%">Order By</td></tr> 
		
		<tr class="header">
			<td width="10%"><input value="'.$_SESSION['ef_id'].'" type="text" style="width:50px;" name="id" />
			<input value="1" type="hidden" style="width:50px;" name="admin_page" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			
			<td width="15%"><input value="'.$_SESSION['ef_email'].'" type="text" style="width:100px;" name="email" /></td>
			<td width="15%"><input value="'.$_SESSION['ef_fname'].'" type="text" style="width:100px;" name="fname" /></td>
			<td width="15%"><input value="'.$_SESSION['ef_lname'].'" type="text" style="width:100px;" name="lname" /></td>
			<td width="15%"><input value="'.$_SESSION['ef_tel'].'" type="text" style="width:100px;" name="tel" />
			<td width="10%"><input value="'.$_SESSION['ef_comp_id'].'" type="text" style="width:100px;" name="comp_id" />			
			<td width="10%"><input value="'.$_SESSION['ef_rep_code'].'" type="text" style="width:100px;" name="rep_code" />			
			</td>
			<td width="15%"><select name="come_from" id="come_from" >
			<option value="">Any</option>
			'.OptionsList(elist_form::$come_froms,$_SESSION['ef_come_from'],true) .'
			</select></td>
			<td width="15%"><select name="enquiry_type" id="enquiry_type" >
			<option value="">Any</option>
			'.OptionsList(elist_form::GetTypes(),$_SESSION['ef_enquiry_type'],true) .'
			</select></td>
			<td width="15%">&nbsp;</td>
			<td width="15%">
			<select name="order_by" >
			'.ListOptions(array("Order by","Date","First Name","Last Name","Email","Mobile","Comp ID","Rep Code"),array("","stamp_time DESC","fname","lname","email","tel","comp_id","rep_code"),$_SESSION['ef_order_by'],true).'
			</select><input type="submit" value="GO" />
			</td>
		</tr>		
		
		';
		
		$enquiry_types=self::GetTypes();

		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{


			if($i%2.0>0) $class="odd";

			else $class="even";
			$i++;
			
			$delete_url=
			$row[table_name]=='enquiries'?
			"javascript:if (confirm('"._lang(sure_delete_elist_form)."')) {document.location ='/admin/enquiries/delete/$row[subscriberid]';}":
			"javascript:if (confirm('"._lang(sure_delete_elist_form)."')) {document.location ='?table_name=$row[table_name]&subscriberid=$row[subscriberid]&op=Delete';}";
			
			$edit_url=
			$row[table_name]=='enquiries'?
			"/admin/enquiries/edit/$row[subscriberid]":
			"?table_name=$row[table_name]&subscriberid=$row[subscriberid]&op=Edit";


			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[subscriberid].
			"<a href=\"$delete_url\"><img src=\"images/delete.png\" alt=\"Delete\" /></a>".
			'</td>'.
			"<td width=\"10%\"  ><a title=\"".FormatTime($row[stamp_time])."\" href=\"$edit_url\">".(((!$row['dont_send_mail']) || $row['dont_send_mail']=='f')?'Yes':'No')."</a></td>".
			"<td width=\"10%\"  ><a title=\"".FormatTime($row[stamp_time])."\" href=\"$edit_url\">".(((!$row['dont_send_sms']) || $row['dont_send_sms']=='f')?'Yes':'No')."</a></td>".
			"<td width=\"15%\"  ><a title=\"".FormatTime($row[stamp_time])."\" href=\"$edit_url\">".$row[email]."</a></td>".
			"<td width=\"15%\"><a title=\"".FormatTime($row[stamp_time])."\" href=\"$edit_url\">$row[fname]</a></td>".
			"<td width=\"15%\"><a href=\"$edit_url\">$row[lname]</a></td>".
			"<td width=\"15%\"><a title=\"$row[yard] \" href=\"$edit_url\">$row[tel]</a></td>".
			"<td width=\"10%\"><a href=\"$edit_url\">$row[comp_id]</a></td>".
			"<td width=\"10%\"><a href=\"$edit_url\">$row[rep_code]</a></td>".
			"<td width=\"15%\"><a title=\"[$row[yard]]\" href=\"$edit_url\">".elist_form::$come_froms[$row['come_from']]."</a></td>".
			"<td width=\"15%\"><a title=\"[$row[yard]]\" href=\"$edit_url\">".$enquiry_types[$row['enquiry_type']]."</a></td>".
			"<td width=\"15%\">"  . FormatTime($row['stamp_time']) . "</td>" .		
			

			"<td width=\"15%\">
			".($_SESSION['ef_is_weekly_subscriber']=="yes"?"<a href=\"?op=Unsubscribe&email=$row[email]\">Unsubscribe</a>":"")."
			</td></tr> ";

		}

		$List.= '</form></table>
		
		
		</div><br/><br/>	';
		$List.="<div class=\"admin_list_control\">
		<b>Total Found:</b> $total_found&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		";
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





		if($i>0)
		{

			$List.=
			'
			<h3 class="more_option" >
			<a href="javascript:void(0)" onclick="
			document.getElementById(\'sms_sender\').style.display=\'none\';
			document.getElementById(\'email_sender\').style.display=\'none\';
			document.getElementById(\'exporter\').style.display=\'block\';
			document.getElementById(\'unsubscriber\').style.display=\'none\';
			" >
			Export to csv<a/></h3>
			
			
			<div id="exporter" class="more_option_box">
				<form action="/admin/exporttocsv.php" method="post" >
				Delimited:
				<select name="delimited"><option value="comma">Comma ( , )</option><option value="tab">Tab</option><option value="semi">Semicolon(;)</option></select>
					
				<input name="sql" type="hidden" value="'.PreForm($sql_exporter).'" />
				<input type="submit" value="Dump CSV File" /></form>
			</div>
			
			 
			
			
			<div id="xlsexporter" class="more_option_box">
				<form action="/admin/exporttoxls.php" method="post" >
				<input name="sql" type="hidden" value="'.PreForm($sql_exporter).'" />
				<input type="submit" value="Dump XLS File" /></form>
			</div>	
			
			 	
			<div id="email_sender" class="more_option_box">
				<form action="/admin/email_msg.php" method="post" >
				<input type="hidden" name="op" value="SendFromSql" />
				Email Message:
				<select name="msg_id">
				<option></option>
				'.email_msg::ListManuallMessages().'
				</select>
				<input name="sql" type="hidden" value="'.$sql_email_sender.'" />
				<input type="submit" value="Send Message" /></form>
			</div> 

			
	 					
			<div id="sms_sender" class="more_option_box">
				<form action="/admin/sms_msg.php" method="post" >
				<input type="hidden" name="op" value="SendFromSql" />
				SMS Message: 
				<select name="msg_id">
				<option></option>
				'.sms_msg::ListManuallMessages().'
				</select>
				<input name="sql" type="hidden" value="'.$sql_email_sender.'" />
				<input type="submit" value="Send Message" /></form>
			</div>

				<h3 class="more_option" >
			<a href="javascript:void(0)" onclick="
			document.getElementById(\'sms_sender\').style.display=\'none\';
			document.getElementById(\'email_sender\').style.display=\'none\';
			document.getElementById(\'exporter\').style.display=\'none\';
			document.getElementById(\'unsubscriber\').style.display=\'block\';
			" >
			
						Unsubscribe<a/>		</h3>	
			<div id="unsubscriber" class="more_option_box">
				<form action="?" method="get" >
				<input type="hidden" name="op" value="Unsubscribe" />
				Email Address:
				<input name="email" style="width:100px;" value="" id="" type="text" />
				
				Or subsciber id:
				<input name="subscriber_id" style="width:40px;" value="" id="" type="text" />
	
				<input type="submit" value="Unsubscribe" /></form>
			</div>
			
			';
		}

		$List.='
		
			<script type="text/javascript">
			//calender script
		    Calendar.setup({
		        inputField     :    "from_date",      // id of the input field
		        ifFormat       :    "%d-%m-%Y",       // format of the input field
		        showsTime      :    false,            // will display a time selector
		        button         :    "f_trigger_a",   // trigger for the calendar (button ID)
		        singleClick    :    true,           // double-click mode
		        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
		    });
		    
		    Calendar.setup({
		        inputField     :    "to_date",      // id of the input field
		        ifFormat       :    "%d-%m-%Y",       // format of the input field
		        showsTime      :    false,            // will display a time selector
		        button         :    "f_trigger_b",   // trigger for the calendar (button ID)
		        singleClick    :    true,           // double-click mode
		        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
		    });		    
		    
		    
		    
		</script> 	
		
	
		';

		return $List;



	}


	public static function GetTotalCountOf($source="",$yard="",$where='')
	{
		global $db;
		$sql = "SELECT COUNT(*) from afs_form WHERE 1=1  ".($where?' AND '.$where:'');



		if($source) $sql.=" AND (source= '".$source."' OR enquiry_type='".$source."' )";

		if($yard) $sql.=" AND yard= '".$yard."'";



		if(!$result= $db->sql_query($sql) )
		{
			special::$SErrors[]=$db->sql_error_msg($result);
			return false;
		}
		$row=$db->sql_fetchrow($result);
		if(!$row[0])
		{
			special::$SErrors[]=_lang(no_subcibers_found);
			return false;

		}

		return $row[0];

	}

	public static function GetContactEmail($id)
	{
		global $db;
		$sql = 'SELECT email FROM afs_form WHERE subscriberid=\''.$id.'\'';

		$result = $db->sql_query($sql);
		if(!$row = $db->sql_fetchrow($result));
		self::$SErrors[]='Cant find this subscriber id';
		if($row2== $db->sql_fetchrow($result))
		self::$SErrors[]='Cant find this subscriber id';
		return $row[0];
	}

	public static function GetContactEmailFromMobile($mobile)
	{
		global $db;
		$sql = 'SELECT email FROM afs_form WHERE tel=\''.$mobile.'\'';
		

		$result = $db->sql_query($sql) or die($db->sql_error_msg());
		
		if(!($row = $db->sql_fetchrow($result)))
		{
			self::$SErrors[]='Cant find subscriber with this mobile';
			return  false;
		}

		return $row[0];
	}



	public static function IsExist($email,$mobile=false,$fname=false,$exclude_id=falsem,$comp_id=false)
	{
		global $db;

		if($mobile==999) return false;

		if($exclude_id) $WHERE = " AND subscriberid <> ".$exclude_id;

		if($comp_id) $WHERE .= " AND comp_id = '$comp_id' ";

		if(!$email && !$mobile && !$fname) return false;


		$sql= 'SELECT `subscriberid` from `elist_form` WHERE  (`email`=\''.PreSql($email).'\' AND `tel`=\''.PreSql($mobile).'\' AND `fname`=\''.PreSql($fname).'\' )  '.$WHERE ;
		if(!$email)
		$sql= 'SELECT `subscriberid` from `elist_form` WHERE `tel`=\''.PreSql($mobile).'\' AND `fname`=\''.PreSql($fname).'\'  '.$WHERE ;
		if(!$mobile)
		$sql= 'SELECT `subscriberid` from `elist_form` WHERE `email`=\''.PreSql($email).'\' AND `fname`=\''.PreSql($fname).'\'  '.$WHERE ;
		if(!$email && !$mobile)
		$sql= 'SELECT `subscriberid` from `elist_form` WHERE `email` IS NULL AND `tel` IS NULL AND  `fname`=\''.PreSql($fname).'\' AND  `lname`=\''.PreSql($lanme).'\'  '.$WHERE ;



		$result = $db->sql_query($sql) or die($db->sql_error_msg($result));
		if($row=$db->sql_fetchrow($result))
		return $row[0];
		else
		return false;
	}

	public static  function UnsubscribLogDB($subscriberid,$form_type,$email,$ref=false, $elist=false)
	{
		global $db;
		if(!$ref) $ref=curPageUrl()." ".$_SERVER['REMOTE_ADDR'];
		$unsubscrped_time= date('Y-m-d H:i:s');
		$elistBool = $elist? 'true' : 'false';
		$sql="INSERT INTO unsubscribed(subscriberid, unsubscrped_time, form_type,email, ref, elist) VALUES ('$subscriberid', '$unsubscrped_time', '$form_type', '$email', '$ref', $elistBool);";
		if ($elist) {
			echo $sql;
		}

		$db->sql_query($sql);

	}


	public static function UnsubscribeReport($from_date=false,$to_date=false)
	{


		global $db;


		if($from_date)
		{
			$from_date = date('Y-m-d',strtotime($from_date));
			$where.=" AND virtual_date >=  '$from_date' ";

		}

		if($to_date)
		{
			$to_date = date('Y-m-d',strtotime($to_date));
			$where.=" AND virtual_date <=  '$to_date' ";
		}

		$sql=<<<END1
			SELECT to_char(virtual_date,'DD/MM/YYYY') as day, 
			SUM(CASE WHEN form_type='trade-in' then 1 else 0 end) AS trade_in,
			SUM(CASE WHEN form_type='10k comp' then 1 else 0 end) AS k_comp,
			SUM(CASE WHEN form_type='book_your_free_4wd_training_day' then 1 else 0 end) AS f4wd,
			SUM(CASE WHEN form_type='finance' then 1 else 0 end) AS finance,
			SUM(CASE WHEN form_type='offer' then 1 else 0 end) AS offer,
			SUM(CASE WHEN form_type='cash' then 1 else 0 end) AS cash,
			SUM(CASE WHEN form_type='special' then 1 else 0 end) AS special,
			SUM(CASE WHEN form_type='subscriber' then 1 else 0 end) AS subscriber,
			SUM(CASE WHEN form_type='car'  then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS car_enquire,
			to_char(virtual_date ,'YYYY WW' )||'0' AS order_by,
			to_char(virtual_date ,'YYYY WW' ) AS week

		    FROM  virtual_date LEFT JOIN unsubscribed ON (virtual_date::text=to_char(unsubscrped_time ,'YYYY-MM-DD' ) )
			WHERE virtual_date <=now()   $where
			GROUP by virtual_date
			UNION 
			SELECT  'WEEK', 
			SUM(CASE WHEN form_type='trade-in' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS trade_in,
			SUM(CASE WHEN form_type='10k comp' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS k_comp,
			SUM(CASE WHEN form_type='book_your_free_4wd_training_day' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS f4wd,
			SUM(CASE WHEN form_type='finance' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS finance,
			SUM(CASE WHEN form_type='offer' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS offer,
			SUM(CASE WHEN form_type='cash' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS cash,
			SUM(CASE WHEN form_type='special' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS special,
			SUM(CASE WHEN form_type='subscriber' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS subscriber,
			SUM(CASE WHEN form_type='car' then 1 else 0 end)/COUNT(DISTINCT virtual_date) AS car_enquire,
			to_char(virtual_date ,'YYYY WW')||'1' AS order_by,
			to_char(virtual_date ,'YYYY WW') AS week
			FROM  virtual_date LEFT JOIN unsubscribed ON (to_char(virtual_date,'YYYY WW')=to_char(unsubscrped_time ,'YYYY WW' ) )
			WHERE virtual_date <=now()  $where
			GROUP BY to_char(virtual_date,'YYYY WW') 
			ORDER BY order_by ,day
END1;

		//echo $sql;
		if(!$result=$db->sql_query($sql))
		{
			self::$SErrors[]="Error in DB $sql <br/> ".$db->sql_error_msg($result);
			return false;
		}
		$report_data=$db->sql_fetchrowset($result);



		header('Pragma: public');
		header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
		header ("Pragma: no-cache");
		header('Content-Transfer-Encoding: none');
		header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera
		header("Content-type: application/x-msexcel");                    // This should work for the rest
		header('Content-Disposition: attachment; filename="unsubscribe_report_'.Date('Y-m-d').'.xls"');

		include('templates/unsubscribe_report.php');
		return true;

	}



	/**
	 * Generates SQL query with table name ={table_name} and id field ={id} to multi joined quries for all Contacts form tables of AFS
	 *
	 * @param string $sql
	 * @return string
	 */
	public static function GenerateSqlForAllForms($sql)
	{
		foreach (self::$form_tables  as $id=>$table)
		{
			$id=str_replace('!','',$id);
			$joined_sql.=str_replace('{id}',$id,str_replace('{table_name}',$table,$sql)).";";
		}

		return $joined_sql;


	}


	public function ShowSubscriberDetailsForm()
	{
		$op="ShowSubscriberDetails";
		include('../forms/funsubscribe.php');
	}

	public static function GetSubscriberEmailAddress($subscriber_id,$email=false,$tel=false)
	{
		if($email) return trim($email);
		else if($subscriber_id)
		{
			$email_address=elist_form::GetContactEmail(trim($subscriber_id));
			if($email_address) return $email_address;
		}
		else if($tel)
		{
			$email_address=self::GetContactEmailFromMobile(trim($tel));
			if($email_address) return $email_address;
		}
	}


	public static function GetSubscriberTel($email)
	{

		global $db;
		$email=trim(strtolower(	$email	));
		$sql = 'SELECT tel FROM afs_form WHERE lower(email)=\''.$email.'\'';

		$result = $db->sql_query($sql);
		if(!$row = $db->sql_fetchrow($result));
		self::$SErrors[]='Cant find subscriber with this email Address';

		return $row[0];
	}

	public static function ShowSubscriberDetails($subscriber_id=false,$email=false,$tel=false)
	{
		global $db;
		$email_address=self::GetSubscriberEmailAddress($subscriber_id,$email,$tel);
		if(!$email_address)
		{
			self::$SErrors[]=_lang('no_subscriber_found');
			return false;
		}
		$email_address=strtolower($email_address);
		//Get the forms for thay user has filled
		$sql="SELECT subscriberid,	source, dont_send_mail, table_name FROM afs_form WHERE  (lower(email)='".strtolower($email_address)."' ) ORDER by  subscriberid DESC ";



		if(!$result=$db->sql_query($sql))
		{
			self::$SErrors[]=$db->sql_error_msg($result);
			return false;
		}
		while($row=$db->sql_fetchrow($result))
		{
			$forms[]=$row;

			if(!$row['dont_send_mail']||$row['dont_send_mail']=='f')
			{
				$subscribed_forms[]=$row;
			}
		}

		$forms_count=sizeof($forms);
		$subscribed_forms_count=sizeof($subscribed_forms);

		$sql="SELECT s_id,id FROM subscription WHERE id IN (SELECT id from subscriber WHERE lower(email)='".strtolower($email_address)."')";

		if(!$result=$db->sql_query($sql))
		{
			self::$SErrors[]=$db->sql_error_msg($result);
			return false;
		}
		while($row=$db->sql_fetchrow($result))
		{
			$car_finder_subscriptions[]=$row;
		}
		$car_finder_subscriptions_count=sizeof($car_finder_subscriptions);

		$sql = 'SELECT * FROM `send_email` WHERE lower(`email_address`)=\''.strtolower($email_address).'\' AND 	(is_sent IS NULL OR is_sent = false)';
		if(!$result=$db->sql_query($sql))
		{
			self::$SErrors[]=$db->sql_error_msg($result);
			return false;
		}

		while($row=$db->sql_fetchrow($result))
		{
			$scheduled_emails[]=$row;
		}
		$scheduled_emails_count=sizeof($scheduled_emails);



		include($GLOBALS['predir'].'templates/show_subscriber_details.html');
		return true;

	}
	
	public static function GetTypes()
	{
		//Get Other types from the eqnuiries cakePHP model
		 $APP=dirname(dirname(dirname(__FILE__)));
                 $types=array();
		 $types= require($APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'enquiries.php');
		 
		 
		 
		 $cake_types=array();
		 foreach ($types as $k=>$type)
		 {
		 	$cake_types[$k]=$type['label'];
		 }
		 
		 
		
		
		return $cake_types;
	}

	function DeleteAllSubscribers()
	{
		global  $db;

		$sqls=explode(';',self::GenerateSqlForAllForms("DELETE FROM {table_name} WHERE (dont_send_mail=true AND dont_send_sms=true AND (comp_id<>'10k2010' OR comp_id IS NULL) ) AND {id} NOT IN (SELECT id from subscription) "));

		foreach ($sqls as $sql)
		{
			if(!$result=$db->sql_query($sql))
			{
				$sql=str_replace("AND (comp_id<>'10k2010' OR comp_id IS NULL)",'',$sql);
				if(!$result=$db->sql_query($sql))
				{
					self::$SErrors[]=$db->sql_error_msg($result);
				}

			}
		}
		
		if(sizeof(self::$SErrors)) return false;
		return true;

	}
	
	
	function stats_filter()
	{
		include($GLOBALS['predir'].'templates/10_stats_filter.html');
	}
	
	
	function show_stats_from_form()
	{
		foreach ($_GET['fields'] as $i=>$f)
		{
			if(empty($_GET['fields'][$i])) unset($_GET['fields'][$i]);
			else 
			$_GET['fields'][$i]=PostForm($_GET['fields'][$i]);
		}
		
		global $db;
		$sql='SELECT 
		'.implode(',',$_GET['fields']).',COUNT(*) as total
		FROM 
		afs_form 
		WHERE 1=1';
		if($_GET['from_date'])
		$sql.=' AND added_date>=\''.PostForm($_GET['from_date']).'\'';
		if($_GET['to_date'])
		$sql.=' AND added_date<=\''.PostForm($_GET['to_date']).' 23:59:59\'' ;
		
		foreach ($_GET['filters']  as $field=>$values)
			if(is_array($values)&&sizeof($values)&&in_array($field,$_GET['fields']))
			$sql.=' AND '.$field.' IN (\''.implode('\',\'',$values).'\')';
		$sql.=' Group BY '
		.implode(',',$_GET['fields']);	
		
		
		if(strpos(implode('',$_GET['fields']),'to_char')!==false) 
		$sql.=' ORDER BY to_char ASC';
		else 
		$sql.=' ORDER BY total DESC ';
		
		if(!$result=$db->sql_query($sql))
		{
			self::$SErrors[]=$db->sql_error_msg($result);
			//echo  $sql;
			return false;
			
		}
		
		
		
		$rows = $db->sql_fetchrowset($result);
		
		foreach ($rows as $row)
		$total+=$row['total'];
		
		
		
		
		
		
		include($GLOBALS['predir'].'templates/10_stats.html');
	}
}

elist_form::init();

?>
