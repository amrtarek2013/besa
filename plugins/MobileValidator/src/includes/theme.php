<?php

function head($page_title="",$style_name="grn",$long_title="",$sub_title="",$banner_id="",$use_pngfix=true,$head_extra='')
{
	return '';
	global $predir;
include_once($predir.'classes/seo_metatag.php');
 $meta=seo_metatag::GetMeta();    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?if(strpos($page_title,'|')){echo $page_title;}else {?>Australian Fleet Sales - <?=$page_title?><?}?></title>
<meta name="keywords" content="<?=$meta[0]?>" />
<meta name="description" content="<?=$meta[1]?>" />
<link rel="stylesheet" href="theme/common.css" type="text/css" />
<link rel="stylesheet" href="theme/<?=$style_name?>/style.css" type="text/css" />
<?=$head_extra?>

 <style type="text/css">
   img, div { behavior: url(theme/iepngfix.htc) }
 </style>
</head>
<body>
<table id="main_table" class=""  cellpadding="0" cellspacing="0">
	<tr>
		<td id="banner<?=$banner_id?>" colspan="2">
        <div id="home_btn" ><a  href="index.php" > <img src="theme/<?=$style_name?>/images/home_btn.gif" alt="Home" /> </a> </div>
        <? if ($long_title) { ?>
        <h1> <?=$long_title?> </h1>
        <? } ?>
        <? if ($sub_title) { ?>
        <h2> <?=$sub_title?> </h2>
        <? } ?>
        
        </td>
  </tr>
	<tr>
		<td id="left_column">


<?
}


$ad_urls=array(
	"trader.php",
	"finance.php",
	"subscriber.php",
	"special.php",
	"winner.php",
	"f4wd.php",
	"dealerships.php"
	);



function foot($advs_arry=array())
{
	return '';
global 	$ad_urls;
	
?>

	</td>
<td id="right_column">
         <a id="home_url" href="index.php">Home</a>
         <div class="right_advs" >
         
         <?
         
         	foreach ($advs_arry as $adv_no) 
         	{
         		?>
         		<div class="adv_button">
                <a href="<?=$ad_urls[$adv_no-1]?>"> <img src="theme/images/adv_<?=str_pad($adv_no,2,"0",0)?>.gif" alt="" /></a>
                </div> 
         		<?
         	}
         ?>
         </div>
         
	  </td>
	</tr>
	<tr>
		<td id="footer" colspan="2">
		<img src="theme/images/foot_ad.gif" alt="ad" />
			   	 <script type="text/javascript">
                      addthis_url    = location.href;   
                      addthis_title  = document.title;  
                      addthis_pub    = 'Australian Fleet Sales';     
                    
                  </script>
             <p style="float:left;margin-left:0px;margin-right:0px;">
            &copy; Australian Fleet Sales <?=date('Y'); ?>
            &nbsp; | &nbsp;  <a title="silvertrees web development" href="http://www.silvertrees.net"> the silvertrees partnership</a>
            &nbsp; | &nbsp;  <a title="Business Links" href="business_links.php">Business Links</a>
            </p>
            
			<p style="float:right;padding-right:0px;margin-left:0px;margin-right:10px;">
			<script type="text/javascript" src="http://s7.addthis.com/js/addthis_widget.php?v=12" ></script>
			</p>            
            
             <p style="float:right;padding-right:0px;">
             <a href="sitemap.php">sitemap</a>
            &nbsp; | &nbsp;
			<a href="privacypolicy.php">privacy</a>   
			</p>
			<br/>
			<br/>		
		
		</td>
  </tr>
</table>
<!-- End ImageReady Slices -->
</body>
</html>
<?
}


function admin_head($page_title, $user_header = false, $showHeaderOnly = false, $salesAgentSearch = false)
{   global $predir;
    if($user_header){
        include $predir.'templates/sales_agent_header.tpl.html';
        return;
    }
    if($salesAgentSearch){
        include $predir.'templates/sales_agent_search_header.tpl.html';
        return;
    }
	?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Australian Fleet Sales - <?=$page_title?> </title>
		<meta http-equiv="content-type" content="text/ html;charset=utf-8" />
		<link rel="stylesheet" href="default.css" type="text/css" media="screen" />
		<style type="text/css" media="screen"> @import url("default.css"); </style>
		<link rel="stylesheet" href="../theme/admin.css" type="text/css" />
	
		<script language="JavaScript">
		<!--
		function Delete_nvic(def_nvic) {
			var msg="You are about to permanently delete code " + def_nvic + "\r\nAre you SURE ?";
			if(confirm(msg)) {
				window.location=("edit_nvic.php?Delete_nvic=" + def_nvic);
			} else {
				alert("Reprieve granted!");
			}
		}
		//-->
		</script>
		</head>
		<body>
     <?php  if($showHeaderOnly){
        return;
    }?>
		<div id="container">
		
		<div id="tree_menu_container"></div>	
		<div id="content">
	
	<?
	
}

function admin_foot($user_footer = false, $salesAgentSearch = false)
{   global $predir;
    if($user_footer){
        include $predir.'templates/sales_agent_footer.tpl.html';
        return;
    }
    if($salesAgentSearch){
        include 'templates/sales_agent_search_footer.tpl.html';
        return;
    }
	?>
	</div>
	<p><br /></p>
</div>
</body>
</html>
<?
}



function search_head($page_title="",$head_more="",$menu=true,$show_search_block=false)
{

	global $predir;
include_once($predir.'classes/seo_metatag.php');

	//Get Counter Data
	$d = array();
	$n = file_get_contents( 'dynamic/cars-sold.txt' );
	for( $i = 0; $i < strlen( $n ); $i++ ){
		array_push( $d, substr( $n, $i, 1 ) );
	}


	//SelectBoxes Data
	dbconnect($site["dbhost"], $site["dblogin"], $site["dbpass"], $site["dbname"], $site["dbport"]);

	$makes = array();
	$sql="SELECT /*COUNT(*), */make FROM afs_stock2 GROUP BY make ORDER BY make";
	$result=dbquery($sql);
	while (list($make) = dbnext($result)) {
		array_push($makes, $make);
	}
	//$row = pg_fetch_array ($result, NULL, PGSQL_NUM);
	//$num_records = $row[0];

	$bodies = array();
	$sql="SELECT type FROM body_types GROUP BY type ORDER BY type";
	$result=dbquery($sql);
	while (list($body) = dbnext($result)) {
		array_push($bodies, $body);
	}

	$stock_numbers = array();
	$sql="SELECT stock_no FROM afs_stock2 GROUP BY stock_no ORDER BY stock_no";
	$result=dbquery($sql);
	while (list($stock_number) = dbnext($result)) {
		array_push($stock_numbers, $stock_number);
	}

	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Australian Fleet Sales - <?=$page_title?></title>
<link rel="stylesheet" href="<?=$predir; ?>theme/common.css" type="text/css" />
<link rel="stylesheet" href="<?=$predir; ?>theme/home.css" type="text/css" />

<? require('includes/meta.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require('dropdown_js.php')?>
<script type="text/javascript">  
	//<![CDATA[
	
var slideShowSpeed = 5000;
var crossFadeDuration = 3;

var Pic = new Array(); 
var Url = new Array(); 

var Pic2 = new Array(); 
var Url2 = new Array(); 

Pic[0] = 'theme/images/center_top_2.gif';
Pic[1] = 'theme/images/center_top_3.gif';
Pic[2] = 'theme/images/center_top_4.gif';

Pic2[0] = 'theme/images/win_match.jpg';
Pic2[1] = 'theme/images/chat_disabled.jpg';

Url[0]="valuation.php";
Url[1]="finance_draw.php";
Url[2]="finance.php";

Url2[0]="match.php";
Url2[1]="#";

var t;
var j = 0;
var p = Pic.length;
var preLoad = new Array();

var t2;
var j2 = 0;
var p2 = Pic2.length;
var preLoad2 = new Array();

for (i = 0; i < p; i++){
   preLoad[i] = new Image();
   preLoad[i].src = Pic[i];
}


for (i = 0; i < p2; i++){
   preLoad2[i] = new Image();
   preLoad2[i].src = Pic2[i];
}


function runSlideShow(){
   document.getElementById('center_top_ad').src = preLoad[j].src;
   document.getElementById('center_top_ad_url').href = Url[j];
   
	document.getElementById('left_top_ad').src = preLoad2[j2].src;
   document.getElementById('left_top_ad_url').href = Url2[j2];   
   
   j = j + 1;
   if (j > (p-1)) j=0;
   
   
   j2 = j2 + 1;
   if (j2 > (p2-1)) 
   {
   		j2=0;   
   		document.getElementById('left_ad_1_more').style.display = 'none';   
   		
   }
   else
   document.getElementById('left_ad_1_more').style.display = 'block';   
   
   t = setTimeout('runSlideShow()', slideShowSpeed);
   
   
}



	function reset()
	{
		document.myform.make.selectedIndex =0;
		document.myform.year_min.selectedIndex =0;
		document.myform.year_max.selectedIndex =0;
		document.myform.body.selectedIndex =0;
		document.myform.price.selectedIndex =0;
		document.myform.transmission.selectedIndex =0;
		document.myform.stock_number.selectedIndex =0;
		document.myform.state.selectedIndex =0;
		document.myform.model.selectedIndex =0;
		setOptions("any");
	
	}
	
//]]>
</script>	

</head>

<body bgcolor="#FFFFFF">

<!-- ImageReady Slices (AFS_HomePageFinal.psd - Slices: bnaner_search, body, counter, footer, left_top) -->

	<table id="Table_01" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
        	<td>
        	 <? if($show_search_block) { ?>
        	<form onsubmit="if(document.myform.keyword.value=='e.g. XR8') document.myform.keyword.value='' " name="myform" action="search_results.php" id="myform" method="post">
        	<? } ?>
            <table cellspacing="0" cellpadding="0">
            	<tbody>
                <tr>
				<td id="left_top">
					<!--<script language="JavaScript" src="http://www.tralianfleetsales.com.au/chat/javascript.php?html=1"></script><a href="javascript:void(0);" onClick="javascript:startchat('', '');"><img src="http://www.australianfleetsales.com.au/chat/onlinestatus_html.php?dep=" border="0"></a>
					<a id="center_top_ad_url" href="#"><img id="center_top_ad" src="theme/images/center_top_1.gif" alt="" /></a>-->
					<a id="left_top_ad_url" href="match.php" ><img id="left_top_ad" src="theme/images/win_match.jpg" alt="Match the number & Win 1000 Click here" /></a>
					<p style="margin-left:175px;margin-top:-60px;margin-left:expression('-85px');margin-top:expression('40px');" id="left_ad_1_more"><?include_once('classes/winning_number.php' ); echo winning_number::GetWinningNumber(); ?></p>
					<a id="center_top_ad_url" href="#"><img id="center_top_ad" src="theme/images/center_top_1.gif" alt="" /></a>
				</td>
				<td id="counter">
	 	    	     <div class="counter_item"><?=$d[0]?></div>
	            	 <div class="counter_item"><?=$d[1]?></div>
		             <div class="counter_item"><?=$d[2]?></div>
	    	         <div class="counter_item"><?=$d[3]?></div>
	        	     <div class="counter_item"><?=$d[4]?></div>
	            	 <div class="counter_item"><?=$d[5]?></div>
		             <div class="counter_item"><?=$d[6]?></div>    	        
	           	</td>
                </tr>
            </tbody>
           </table>        </td>
		</tr>
	  <? if($show_search_block) { ?>
		<tr>
		  <td id="bnaner_search_">
		  

		  <table id="search_table">
            <tbody>
              <tr>
                <td colspan="4" class="head">SEARCH OVER 1000 CARS</td>
              </tr>
              <tr>
                <td width="74">Make:</td>
                <td width="159">
              <select size="1" name="make" id="make" onchange="setOptions(document.myform.make.options[document.myform.make.selectedIndex].value);">
                <option value='' selected>any</option>
				<?php
				for($x=0; $x < sizeof($makes); $x++) 
				{
					echo '<option value="' . $makes[$x] . '">' . $makes[$x] . '</option>';
				}
				?> 
              </select>
                </td>
                <td width="40">Model:</td>
                <td width="137">
              <select name="model" id="model" size="1">
                <option value="" selected></option>
              </select>            
              </td>
              </tr>
              <tr>
                <td>Year Range:</td>
                <td>
                
              <select name="year_min" id="year_min" size="1">
                <option value="">Min</option>
                <?php
					$years = range (1991, date('Y'));
					$years = array_reverse($years);
					foreach ($years as $value) {
						echo "<option value=\"$value\">$value</option>\n";
					}
				?> 
                <option value="<= 1990">&lt; 1990</option>
              </select>
              
              
              <select name="year_max" id="year_max" size="1">
                <option value="">Max</option>
                <?php
				$years = range (1991, date('Y'));
				$years = array_reverse($years);
				foreach ($years as $value) {
					echo "<option value=\"$value\">$value</option>\n";
				}
				?> 
                <option value="<= 1990">&lt; 1990</option>
              </select>
              
             
                  </td>
                <td>Body:</td>
                <td>
                <select name="body" id="body" size="1">
                <option selected>any</option>
                <?php
				for($x=0; $x < sizeof($bodies); $x++) {							
				echo '<option value="' . $bodies[$x] . '">' . $bodies[$x] . '</option>';
				}
				?> 
              </select>
                  </td>
              </tr>
              <tr>
                <td>Price Range:</td>
                <td>
	              <select name="price" id="price" size="1">
	                <option value="x">Select</option>
	                <option value="10000">Under $10000</option>
	                <option value="10001">$10,001 - $15,000</option>
	                <option value="15001">$15,001 - $20,000</option>
	                <option value="20001">$20,001 - $25,000</option>
	                <option value="25001">$25,001 - $30,000</option>
	                <option value="30001">$30,001 - $35,000</option>
	                <option value="35001">$35,001 - $40,000</option>
	                <option value="40001">$40,001 - $45,000</option>
	                <option value="45001">$45,001 - $50,000</option>
	                <option value="50001">$50,001 - $60,000</option>
	                <option value="60001">$60,001 - $70,000</option>
	                <option value="70001">$70,001 - $80,000</option>
	                <option value="80001">$80,001 - $90,000</option>
	                <option value="90001">$90,001 - $100,000</option>
	                <option value="100001">Over $100,001</option>
	              </select>             
                </td>
                <td>Transm:</td>
                <td>
	             <select name="transmission" id="transmission" size="1">
	                <option value="any">any</option>
	                <option value="_MAN">Manual</option>
	                <option value="_AUT">Automatic</option>
	                <option value="_SEQ">Semi-Automatic</option>
	              </select>
                 </td>
              </tr>
              <tr>
                <td colspan="4">Stock No:
	              <select name="stock_number" id="stock_number" size="1">
	                <option value='' selected>Select</option>
	                <?php
						for($x=0; $x < sizeof($stock_numbers); $x++) {							
							echo '<option value="' . $stock_numbers[$x] . '">' . $stock_numbers[$x] . '</option>';
						}
					?> 
	              </select>
                  &nbsp;&nbsp;&nbsp;State:
                  
	              <select name="state" id="state" size="1">
	                <option value=''>Any</option>
	                <option value='qld'>Qld</option>
	                <option value='nsw'>NSW</option>
	              </select>
					&nbsp;&nbsp;&nbsp;Series:
	              <input type="text" id="keyword" name="keyword" value=""  style="width:30px;" />&nbsp;&nbsp; <p style="display:inline;position:absolute;color:#FFFFFF;">e.g. XR8 </span>
               
                  </td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align:right;direction:rtl;"><div  style="position:absolute; margin-top:-10px;margin-rigth:-15px;"><a href="javascript:if(document.myform.keyword.value=='e.g. XR8') document.myform.keyword.value='';document.myform.submit();"> <img style="margin-top:-10px;"  src="theme/images/transparent.gif" alt="Go" width="62" height="61" /></a><a onclick="reset();" href="#"><img style="margin-top:-10px;" src="theme/images/transparent.gif" alt="Reset" width="62" height="66" /></a></div></td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" value="submitted" name="submitted" />	
          </form>
          </td>
		</tr>
		<? } ?>
		<tr>
		<td id="main_body" style="padding-left:15px;padding-right:10px">
	
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr><td colspan="2">
		<table class="top_bar_table" cellspacing="0" cellpadding="0" ><tr>
		<td class="top_bar_end"></td>
		<td class="top_bar"><?=$page_title?></td>
		<td class="tob_par_home"><a href="<?=$predir?>index.php" ><img src="theme/images/home_btn.gif" alt="Home Page" /></a> </td>
		</tr></table>
		</td></tr>
              <tr>
              <td <?($menu)?'class="main_left"':''?>>
              

<?
}






function search_foot($menu=true,$call_now=false)
{
global 	$ad_urls;
$advs_arry=mrand(1,7,4,false);

?>				</div>
   				</td>
   			<? if($menu) { ?>
                <td class="main_right">
            <?
         	foreach ($advs_arry as $adv_no) 
         	{
         		?>
         		<div class="adv_button">
                <a href="<?=$ad_urls[$adv_no-1]?>"> <img src="theme/images/adv_<?=str_pad($adv_no,2,"0",0)?>.gif" alt="" /></a>
                </div> 
         		<?
         	}                  
            ?>    
            </td>
            <? } ?>
            </tr></table>
            
<?	

	//Get Testimonial
	$max = 0;
	if( $handle = opendir( 'dynamic' ) )
	{
		while( false !== ( $file = readdir( $handle ) ) )
		{
			if( preg_match( "/^testimonial(\d+).txt$/", $file, $m ) )
			{
				if( $m[1] > $max )
				$max = $m[1];
			}
		}
		closedir( $handle );
	}
	$n = rand( 1, $max );



?>

            <tr><td>
            <? if($call_now) { ?>
            <img src="theme/images/ad_girl.gif" style="position:absolute;margin-top:-35px;margin-left:70px;" alt="Call Now On 1300 559 322" />
            <img src="theme/images/ad_foot.gif" style="margin-left:155px;margin-bottom:3px;margin-bottom:expression('0px');" alt="Call Now On 1300 559 322" />
            <? }?> 
            <div id="what_customer_say">
            <div class="left_part">
			Look what our customers are saying...            </div>
            <div class="right_part">
			  <p style="padding:0px;margin:0px;"><? if( file_exists( "dynamic/testimonial{$n}.txt" ) ) {ob_start();  include( "dynamic/testimonial{$n}.txt" ); $output = ob_get_contents(); ob_end_clean();  echo ucfirst(strtolower($output));} ?></p>
              <p class="person_name" style="padding:0px;margin:0px;"><? if( file_exists( "dynamic/client{$n}.txt" ) ) {ob_start();  include( "dynamic/client{$n}.txt" ); $output = ob_get_contents(); ob_end_clean(); echo ucfirst(strtolower($output));} ?></p>
            </div>
            </div>
            </td></tr>
		
		<tr >
			<td id="footerindex" >
			   	 <script type="text/javascript">
                      addthis_url    = location.href;   
                      addthis_title  = document.title;  
                      addthis_pub    = 'Australian Fleet Sales';     
                    	auto();runSlideShow();
                  </script>
             <p style="float:left; padding:40px 0 30px 0; " >
            &copy; Australian Fleet Sales <?=date('Y'); ?>
            &nbsp; | &nbsp;  <a title="silvertrees web development" href="http://www.silvertrees.net"> the silvertrees partnership</a>
            &nbsp; | &nbsp;  <a title="Business Links" href="business_links.php">Business Links</a>
            
            </p>
            
			<p style="float:right; padding:40px 10px 30px 0;">
			<script type="text/javascript" src="http://s7.addthis.com/js/addthis_widget.php?v=12" ></script>
			</p>            
            
             <p style="float:right; padding:40px 10px 30px 0;">
             <a href="sitemap.php">sitemap</a>
             &nbsp; | &nbsp;
			<a href="privacypolicy.php">privacy</a> &nbsp;   
			</p>
	
            </td>
		</tr>
	</tbody>
	</table>



</body>

</html>	
<?

}










function ThankBlock($title="",$text="")
{
	?>
	  <div id="thank_block">
        <div id="thank_block_head"></div>
        <h2><?=$title?></h2>
        <p><?=$text?></p>
        <div id="thank_block_foot">
          <div class="keda"></div>
        </div>
      </div>
	
	<?
	
}

function Error($error)
{
	?>
	<div class="Error"><?=$error?></div>
	<?
}

function TreeMenu($arritem,$arrlink,$pre="",$post="")
{

	$ret.= $pre."<a href=\"../index.php\">"._lang(home_page)."</a> ";
	$i=0;
	foreach ($arritem as $it)
	{

		if($arrlink[$i]=="#")
		{
			echo '<h1>'.$it.'</h1>';

		}
		else
		{
			
			$ret.= ' &raquo; <a href="'.$arrlink[$i].'">'.$it.'</a>';
		}

		$i++;
	}
	$ret.="<div class='clear'></div>";
	$ret.=$post;
	
	echo
	'
	<script type="text/javascript">
	//<![CDATA[
		document.getElementById("tree_menu_container").innerHTML= "'.addslashes($ret).'";
	//]]>
	</script>
	';
}

function TestimosialBlock($name,$pic,$comment)
{
	global $images_upload_dir;
	?>
	<div class="testimonsial_block">
		<table cellspacing="0" cellpadding="0">
			<tr><td>
			<img class="testimonsial_image_mask" src="theme/images/testimonsilas_mask.gif" alt="" />
			<img class="testimonsial_img" src="<?=$images_upload_dir.$pic?>" alt="<?=$name?>" />
			</td><td>
			<p>	<?=$comment?></p>
			<p class="testimonsial_name"><?=$name?></p>
			</td></tr>
		</table>
	</div>
	<?
}


function MailHead($title="")
{
	
}

function MailFoot($title="")
{
	
}

function MSG($msg,$return=false)
{
	$ret= "<div class=\"msg\">".$msg."</div>";
	if($return) return  $ret;
	echo   $ret;
}


function PrintErrors($errors,$pre=":<br/>")
{
	if(is_array($errors)){
	if($pre=":<br/>") $pre=_lang("error_prefix").":<br/>";
	echo '<div class="Error">'.$pre."<ul>";
	foreach ($errors as $error)
	{
		echo "<li>".$error."</li>";
	}
	echo '</ul></div>';
	}
	else Msg(_lang('seo_metatag_added'));
}


function Menu($arritem,$arrlink,$pre="")
{
	//echo "<div align=\"center\"><br/><b>".$pre." </b>[ ";
	echo '<div id="menu">';
	$i=0;
	foreach ($arritem as $it)
	{
		//if($i!=0) echo " - ";
		echo '<br/><b>&nbsp;&nbsp;<a href="'.$arrlink[$i].'">&raquo;&nbsp;'.$it.'</a></b><br/>';
		$i++;
	}
	echo "</div>";

	//echo " ]<br/></div>";
}




function CategoryDocListPageHead($page_count="",$page_no="",$cat_id="",$cat_name="",$cat_dsc="",$cat_pic="",$pcat_id="",$order_by="date.DESC")
{
	global $site_name;
?><? 
    $pcat_name=category::GetCategoryName($pcat_id);
    TreeMenu(array($pcat_name,$cat_name),array("","#"),"");
    ?>
    <p class="normal"><?=$cat_dsc ?></p>
	
	<div class="page_bar" >
	<form id="order_by" action="category.php" method="GET">
	<?=_lang(order_by) ?> &nbsp;
	<select onchange="document.getElementById('order_by').submit();" name="order_by" >
	<? ListOptions(docs::order_by_titles() , docs::$order_by_list,$order_by); ?>
	</select> 	
	<input type="hidden" name="cat_id" value="<?=$cat_id?>" />
	</form>
	</div>
<?

}



function CategoryDocListPageFoot($page_count="",$page_no="",$cat_id="",$cat_name="",$order_by="date.DESC")
{
	//page bar
	$next_url=" "._lang(list_next_page)." &raquo;";
	$prev_url="&laquo; "._lang(list_previous_page)."";
	if($page_no<$page_count)
	$next_url= "<a href=\"category.php?cat_id=$cat_id&page=".($page_no+1)."&order_by=$order_by\"> "._lang(list_next_page)." &raquo; </a>"  ;
	if($page_no>1)
	$prev_url="<a href=\"category.php?cat_id=$cat_id&page=".($page_no-1)."&order_by=$order_by\"> &laquo; "._lang(list_previous_page)." </a>";

	
	echo "<br/><div class=\"page_bar\">"._lang(page)." $page_no "._lang(of)." $page_count <br/> $prev_url";

	$list_links=10;
	$i2=0;

	for($i=$page_no-floor($list_links/2);$i<=$page_count&&$i2<$list_links;$i++)
	{
		if($i>=1)
		{
			$i2++;
			if($i!=$page_no)
			echo "&nbsp;&nbsp;<a href=\"category.php?cat_id=$cat_id&page=$i&order_by=$order_by\">$i</a>&nbsp;&nbsp;";
			else
			echo "&nbsp;&nbsp;<strong>$i</strong>&nbsp;&nbsp;";
			if($i!=$page_count&&$i2<$list_links) echo "|";
		}
		
	}

	echo "$next_url </div>";

}

function NoDocResult($shop_id,$no)
{
	MSG(_lang(no_doc_search_result));
}


/*function DocBlock($block_no,$doc_id , $title , $desc , $added_date , $doc_cat_id , $file1 , $file2 , $file3 , $thumb_pic , $featured , $counter , $active , $keywords , $tag3)
{
	global $images_upload_dir,$file_upload_dir;
	?>
	<div class="doc_block">
		<h3><a class="download_file1" href="doc.php?doc_id=<?=$doc_id?>&op=Download&file_id=file1" ><?=$title?></a></h3><?=in_array(substr($file1,-3),array("peg","avi","asf","wmv","avi","mpg","wav","mp3"))?"(<a href=\"doc.php?doc_id=$doc_id&op=Download&file_id=file1\">Download</a> | <a href=\"doc.php?doc_id=$doc_id&op=Play&file_id=file1\">Play</a>)":"(<a href=\"doc.php?doc_id=$doc_id&op=Download&file_id=file1\">Download</a>)" ?> 
		<?if($desc) { ?>
		<div class="doc_block_content">
			<p><?=nl2br($desc)?></p>
		</div>
		<? }?>
		
	</div>
	<?
}*/

function DocBlock($block_no,$doc_id , $title , $desc , $added_date , $doc_cat_id , $file1 , $file2 , $file3 , $thumb_pic , $featured , $counter , $active , $keywords , $tag3)
{
	global $images_upload_dir,$file_upload_dir;
	?>
	<div class="doc_block">
		<h3><a class="download_file1" href="doc.php?doc_id=<?=$doc_id?>&op=Download&file_id=file1" ><?=$title?></a></h3>
		
		[
		<a href="doc.php?doc_id=<?=$doc_id?>&op=Download&file_id=file1">Download</a> | 
		<a href="doc.php?doc_id=<?=$doc_id?>&op=Edit&file_id=file1">Edit</a> |
		<a href="javascript:if (confirm('<?=_lang(sure_delete_doc)?>')) {document.location ='?doc_id=<?=$doc_id?>&op=Delete';}">Delete</a>
		
		 <?=in_array(substr($file1,-3),array("peg","avi","asf","wmv","avi","mpg","wav","mp3"))?" | <a href=\"doc.php?doc_id=$doc_id&op=Play&file_id=file1\">Play</a>":"" ?>]
		<?if($desc) { ?>
		<div class="doc_block_content">
			<p><?=nl2br($desc)?></p>
		</div>
		<? }?>
		
	</div>
	<?

}


function DocSearchHead($kewords,$result_count,$page_no,$page_count,$cat_id,$order_by)
{
	?>
	<div class="page_bar">
	<table style="width:100%"><tr><td>
	<b><?=$result_count."</b> "._lang(item_found)."" ?>
	</td>
	<td style="text-align:right;padding-right:10px;"> 
	<?=_lang(page)." $page_no "._lang(of)." ".$page_count ?>
	</td>
	<tr><td colspan="2">
	<hr/>
	</td></tr>
	
	<tr><td>
	<form id="order_by" action="doc.php" method="GET">
	<?=_lang(order_by) ?> &nbsp;
	<select onchange="document.getElementById('order_by').submit();" name="order_by" >
	<? ListOptions(docs::order_by_titles() , docs::$order_by_list,$order_by); ?>
	</select></td>
	<td style="text-align:right;padding-right:10px;">
	<!--<a href="user/search.php?op=SaveSearch&keywords=<?=$kewords?>&cat_id=<?=$cat_id?>&order_by=<?=$order_by?>" > <?=_lang(save_search) ?></div></a>-->
	</td>
	</table>
	<input type="hidden" name="keywords" value="<?=$kewords?>" />
	<input type="hidden" name="cat_id" value="<?=$cat_id?>" />
	</form>
	
	
	</div>

	<?
}


function VideoPlayer($file_name,$width=false,$height=false,$show_controls="0")
{
	global $tvc_width,$tvc_height;
	if(!$width) $width= $tvc_width;
	if(!$height) $height= $tvc_height;

	$ret=<<<End1
					<div class="tvc">
                    <object id="MediaPlayer1" CLASSID="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
					standby="Loading Microsoft Windows® Media Player components..." type="application/x-oleobject" width="$width" height="$height">
					<param name="fileName" value="$file_name">

					<param name="animationatStart" value="true">
					<param name="transparentatStart" value="false">
					<param name="autoStart" value="true">
					<param name="loop" value="false">
					<param name="showControls" value="$show_controls">
					<param name="Volume" value="-450">
					<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" src="$file_name" name="MediaPlayer1" width=$width height=$height autostart=1 showcontrols=$show_controls volume=-450></object>	
					</div>
End1;

	return $ret;
}

function TvcPage($tvc_id,$tvc_name,$tvc_desc,$video_url,$thumb_image=false)
{
	$tvc2=new  doc();
	$tvc2->SelectFromDB($tvc_id);
	
	//TreeMenu(array(_lang(docs),$tvc_name),array("docs.php","#"));
	?>
	<h1><?=$tvc_name?></h1>
	<table class="tvc" ><tr><td>
	<?
	
	$tvc2->Preview(1);
	?>
	</td><td valign="top">
	<p><?=$tvc_desc?></p>
	</td>
	</table>
	
	<?
	
	
}

function DocSearchFoot($kewords,$result_count,$page_no,$page_count,$cat_id="",$order_by="date.DESC")
{
	//page bar
	$next_url=" "._lang(list_next_page)." &raquo;";
	$prev_url="&laquo; "._lang(list_previous_page)."";
	if($page_no<$page_count)
	$next_url= "<a href=\"doc.php?keywords=$kewords&cat_id=$cat_id&page=".($page_no+1)."&order_by=$order_by\"> "._lang(list_next_page)." &raquo; </a>"  ;
	if($page_no>1)
	$prev_url="<a href=\"doc.php?keywords=$kewords&cat_id=$cat_id&page=".($page_no-1)."&order_by=$order_by\"> &laquo; "._lang(list_previous_page)." </a>";

	echo "<div class=\"page_bar\">"._lang(page)." $page_no "._lang(of)." $page_count <br/> $prev_url";

	$list_links=10;
	$i2=0;

	for($i=$page_no-floor($list_links/2);$i<=$page_count&&$i2<$list_links;$i++)
	{
		if($i>=1)
		{
			$i2++;
			if($i!=$page_no)
			echo "&nbsp;&nbsp;<a href=\"doc.php?keywords=$kewords&cat_id=$cat_id&page=$i&order_by=$order_by\">$i</a>&nbsp;&nbsp;";
			else
			echo "&nbsp;&nbsp;<strong>$i</strong>&nbsp;&nbsp;";
			if($i!=$page_count&&$i2<$list_links) echo "|";
		}
		
	}

	echo "$next_url </div>";
}


function FeaturedItemsHead()
{
	?><h2><?=_lang(featured_doc)?></h2><?
}


function FormatTime($str)
{
	
	
	$time=strtotime($str);
	
	if(date("H:i:s",$time)=="00:00:00")
	{
		
		return date("d-m-Y",$time);
	}
	else 
	{
		return date("d-m-Y H:i:s",$time);
		
	}
	
}


?>