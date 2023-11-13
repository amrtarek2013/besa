<?php

// session_name('CAKEPHP');
ini_set("memory_limit", "2000M");
// Enable session support
//session_start();
//die('site under development...try in five minutes');
// Global database definitions
global $site;
$site["name"] = 'Ozcar';
$site["short_name"] = 'Ozcar';
$site["email"] = '';
$site["site_path"] = dirname(__FILE__); //'/var/www/html/australianfleetsales/webroot';
$site["dbhost"] = '127.0.0.1';
$site["dbname"] = 'ozcar-live';
$site["dblogin"] = 'admin';
$site["dbpass"] = 'adm1n';
$site["dbport"] = '5432';
$site["sdate"] = 'dmy';   # date format
$site["dsep"] = '/';  # date separator
$site["url"] = "http://www.ozcar.com.au/"; 

global $admin_mails;

$admin_mails = "sales@austfleetsales.com.au";
//$admin_mails="drpxdev@gmail.com";
//$admin_mails="developer7@silvertrees.net";  
//Mysql Db Info for elist
$site["mysql_dbhost"] = 'localhost';
$site["mysql_dbname"] = 'ElistOne';
$site["mysql_dblogin"] = 'admin';
$site["mysql_dbpass"] = 'adm1n';

// $site["sms_user"] = 'Australianfle004';
// $site["sms_pass"] = 'afS2166';

$site["sms_user"] = 'OzcarWebsiteS003';
$site["sms_pass"] = 'z3KLYnFB';

if (isset($_SERVER['REMOTE_ADDR'])) {
	if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1' && strstr($_SERVER['REMOTE_ADDR'], '192.168.1') === false && strstr($_SERVER['REMOTE_ADDR'], '196.202.83') === false) {
		// $site["sms_user"] = 'Australianfle004';
		// $site["sms_pass"] = 'afS2166';

		$site["sms_user"] = 'OzcarWebsiteS003';
		$site["sms_pass"] = 'z3KLYnFB';    
	}
}

$site['from_mail'] = "info@ozcar.com.au";

global $images_upload_dir, $file_upload_dir;
$images_upload_dir = "uploads/";


$file_upload_dir = "uploads";
global $no_docs_per_page;
$no_docs_per_page = 20;

// Misc PostgreSQL used by all PHP scripts
if (!function_exists('dbconnect')) {

	function dbconnect() {
		global $site;
		pg_connect("host={$site['dbhost']} port={$site['dbport']} dbname={$site['dbname']} user={$site['dblogin']} password={$site['dbpass']}") || print "Cannot connect to your Database ({$site[dbname]}@{$site[dbhost]})";
	}

	function dbquery($sql) {
		//echo $sql;
		return pg_exec($sql);
	}

	function dbnext($res) {
		return pg_fetch_array($res);
	}

	$images_upload_dir = "uploads/";

	function escape_data($data) {

		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		$data = mysql_escape_string(trim($data));
		return $data;
	}

	function WriteCombo($vals, $name, $selected) {
		$res = "<select name='$name'>
\n";
		while (list($val, $opt) = each($vals)) {
			$res .= "<option value='$val'" . (($val == $selected) ? ' selected' : '') . ">$opt</option>\n";
		}
		$res .= "</select>\n";
		return $res;
	}

	function WriteLookupArray($valname, $titlename, $table) {
		global $db;
		$ret = array();
		$reslt = dbquery("select $valname, $titlename from $table");
		while ($row = dbnext($reslt)) {
			$ret[$row[0]] = $row[1];
		}
		return $ret;
	}

	function WriteLookupCombo($name, $valname, $titlename, $table, $selected) {
		return WriteCombo(WriteLookupArray($valname, $titlename, $table), $name, $selected);
	}

	function toGlobals($row) {
		while (list($f, $v) = each($row)) {
			if (!is_int($f)) {
				$GLOBALS[$f] = $v;
			}
		}
	}

}
global $list_per_page;
$list_per_page = 15;


if (strtotime('next Monday') < strtotime('next Friday')) {
	$odd = "Monday";
	$even = "Friday";
} else {
	$odd = "Friday";
	$even = "Monday";
}
global $email_autoresponse_time;
$email_autoresponse_time[2] = time();
$email_autoresponse_time[3] = strtotime('+24 hours');
$email_autoresponse_time[4] = strtotime('next ' . $odd);
$email_autoresponse_time[5] = strtotime('next ' . $even, $email_autoresponse_time[4]);
$email_autoresponse_time[6] = strtotime('next ' . $odd, $email_autoresponse_time[5]);
$email_autoresponse_time[7] = strtotime('next ' . $even, $email_autoresponse_time[6]);
$email_autoresponse_time[8] = strtotime('next ' . $odd, $email_autoresponse_time[7]);
$email_autoresponse_time[9] = strtotime('next ' . $even, $email_autoresponse_time[8]);
$email_autoresponse_time[10] = strtotime('next ' . $odd, $email_autoresponse_time[9]);
$email_autoresponse_time[11] = strtotime('next ' . $even, $email_autoresponse_time[10]);
$email_autoresponse_time[12] = strtotime('next ' . $odd, $email_autoresponse_time[11]);
$email_autoresponse_time[13] = strtotime('next ' . $even, $email_autoresponse_time[12]);
$email_autoresponse_time[14] = strtotime('next ' . $odd, $email_autoresponse_time[13]);
//$email_autoresponse_time[16]=strtotime('next Friday',$email_autoresponse_time[13]);

$email_autoresponse_time[15] = strtotime('1000 days');

include("includes/lang_english.php");
//error_reporting(E_ERROR | E_WARNING);
