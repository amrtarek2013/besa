<?php
$predir='../';
include '../config.php';
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/theme.php';
include '../classes/send_email.php';
include '../classes/email_msg.php';
include '../classes/special.php';
include '../fck_editor/fckeditor.php';


if(isset($_GET['op'])) $op=$_GET['op'];
else if(isset($_POST['op'])) $op=$_POST['op'];


if(!isset($op))
{
	admin_head(_lang(send_perss_ad));

	TreeMenu(array(_lang(admin_home),_lang(send_perss_ad)),array("index.php","#"),"");
	
	if($count=special::GetSubscribersCount())
	{
		MSG($count." "._lang('subscribers_count'));
		special::SendMailToSubscribersForm();
	}
	else 
	{
		PrintErrors(special::$SErrors);
	}
	

}

else if($op=='SendMail')
{
	admin_head(_lang(send_perss_ad));
	
	TreeMenu(array(_lang(admin_home),_lang(send_perss_ad)),array("index.php","#"),"");
	if($count = special::SendMailToSubscribers())
	{
		MSG($count." "._lang('perss_ad_sent'));
	}
	else 
	
	PrintErrors(special::$SErrors);
	
}


admin_foot();
