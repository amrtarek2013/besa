<?php
class contact_us
{

public  $id;
public  $name;
public  $email;
public  $phone;
public  $enquiry;
public  $submit_date;
public  $dealership;

var  $Errors;


public function SetValues($_id , $_name , $_email , $_phone , $_enquiry , $_submit_date)
{	$this->name=$_name;
	$this->email=$_email;
	$this->phone=$_phone;
	$this->enquiry=$_enquiry;
	$this->submit_date=$_submit_date;

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
	$sql = 'SELECT * FROM `contact_us` WHERE `id` = '.$_id;
	if(! ($result=$db->sql_query($sql)))
	{
		$this->Errors[]=$db->sql_error_msg($result);
		return false;
	}

	if($db->sql_numrows($result)<1)
	{
		$this->Errors[]=_lang('no_contact_us_found');
		return false;
	}

	$row = $db->sql_fetchrow($result);
	$this->name=$row['name'];
	$this->email=$row['email'];
	$this->phone=$row['phone'];
	$this->enquiry=$row['enquiry'];
	$this->submit_date=$row['submit_date'];
	$this->dealership=$row['dealership'];
		return true;


}

public function Insert()
{
	global $db;
	$sql = 'INSERT INTO `contact_us` (`name`, `email`, `phone`, `enquiry`,  `submit_date`,  `dealership`) VALUES (\''.PreSql($this->name).'\',  \''.PreSql($this->email).'\',  \''.PreSql($this->phone).'\',  \''.PreSql($this->enquiry).'\',  \''.PreSql($this->submit_date).'\',  \''.PreSql($this->dealership).'\')';
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
	include '../forms/fcontact_us_2.php';

}

public function Delete()
{
	global $db;

	$sql = 'DELETE FROM `contact_us` WHERE `id`='.$this->id;
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
	$email=PreForm($this->email);
	$phone=PreForm($this->phone);
	$enquiry=PreForm($this->enquiry);

	$op=$_op;

	include '../forms/fcontact_us_2.php';

}

public function Update()
{
	global $db;
	$sql = 'UPDATE `contact_us` SET `name` = \''.PreSql($this->name).'\', `email` = \''.PreSql($this->email).'\', `phone` = \''.PreSql($this->phone).'\', `enquiry` = \''.PreSql($this->enquiry).'\', `submit_date` = \''.PreSql($this->submit_date).'\', `dealership` = \''.PreSql($this->dealership).'\' WHERE `id` = '.$this->id; 

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
	$this->email=PostForm($_POST['email']);
	$this->phone=PostForm($_POST['phone']);
	$this->enquiry=PostForm($_POST['enquiry']);

}
public static function AdminListcontact_uss()
{
	global $db,$list_per_page;
	$per_page=$list_per_page;
	if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
	$_GET['admin_page']=1;
	$admin_page=$_GET['admin_page'];
	
		if(isset($_GET['q_name'])&&$_GET['q_name']!="")
		$WHERE.=" AND lower(`name`) LIKE lower('".trim(PreSql($_GET['q_name']))."%') ";
		
		if(isset($_GET['q_email'])&&$_GET['q_email']!="")
		$WHERE.=" AND lower(`email`) LIKE lower('".trim(PreSql($_GET['q_email']))."%') ";
		
		if(isset($_GET['from_date']) && $_GET['from_date']!="" && strtotime($_GET['from_date'])!="" ) $WHERE.=" AND submit_date  >= '".date('Y-m-d',strtotime($_GET['from_date']))."' ";
		if(isset($_GET['to_date']) && $_GET['to_date']!="" && strtotime($_GET['to_date'])!="" ) $WHERE.=" AND submit_date  <= '".date('Y-m-d 23:59:59',strtotime($_GET['to_date']))."' ";
		
		

		

	$export_sql ='SELECT id,name,email,phone,enquiry,submit_date  FROM `contact_us` WHERE true '.$WHERE.'	ORDER BY `id` DESC ';
		
		
	$sql = 'SELECT * FROM `contact_us`  WHERE true '.$WHERE.'	ORDER BY `id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
	$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
	$no=$db->sql_numrows($result);

	$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
	$List= '<script type="text/javascript" src="../scripts/calendar/calendar.js"></script>
<script type="text/javascript" src="../scripts/calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="../scripts/calendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../scripts/calendar/calendar-blue.css" title="win2k-cold-1" />		


<p class="admin_title">'._lang('list_contact_us').':</p>' ;
	$List.= '
	
	
	<form action="" method="get" name="Filter" id="Filter" >
	<table class="adminlist" width="700"><tr class="header"><td width="5%">ID</td>
	<td width="15%">'._lang('name').'<br/><input class="filter" name="q_name" type="text" value="'.$_GET['q_name'].'" /></td>
	<td width="15%">Email<br/><input class="filter" name="q_email" type="text" value="'.$_GET['q_email'].'" /></td>
	<td width="30%">Date<br/>
		From: <input style="width:75px;" type="from_date" id="from_date" value="'.$_GET['from_date'].'" name="from_date" />  
			<button class="calender_trigger" type="reset" id="f_trigger_a">...</button>
			<br/>To: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="width:75px;" type="to_date" id="to_date" value="'.$_GET['to_date'].'" name="to_date" />
			<button class="calender_trigger" type="reset" id="f_trigger_b">...</button>
	
	</td>
	<td width="15%">'._lang('delete').'<br/>	<input name="go" type="submit" value="Filter" /></td></tr> ';
	while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
	{

		if($i%2.0>0) $class="odd";
		else $class="even";
		$i++;

		$List.= '<tr class="'.$class.'"><td >'.$row[id].'</td><td >'.
		"<a href=\"?id=$row[id]&op=Edit\">$row[name]</a></td>".
		'<td><a href="?id='.$row[id].'&op=Edit">'.$row[email].'</a></td>'.
		"<td><a href=\"?id=$row[id]&op=Edit\">".date('d-m-Y',strtotime($row['submit_date']))."</a></td>".
		"<td ><a href=\"javascript:if (confirm('"._lang('sure_delete_contact_us')."')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
	}
	$List.= '</table></form>';
	
	$List.='<input type="button" name="export" value="Export List To CSV" onclick="document.location=\'tocsv.php?file_name=Contact_us_'.date('Y-m-d').'&sql='.str_replace("'","\'",$export_sql).'\'" />
	<br/>';
	
	$List.='<input type="button" name="export" value="Export List To Excel" onclick="document.location=\'exporttoxls.php?file_name=Contact_us_'.date('Y-m-d').'&sql='.str_replace("'","\'",$export_sql).'\'" />
	<br/>';
	
	
	
	
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

}

?>