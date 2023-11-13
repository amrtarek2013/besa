<?php
class stocks_group {

	public  $id;
	public  $name;
	public  $stock_numbers;
	public  $tag1;
	public  $tag2;
	public $yards;

	var  $Errors;
	public static   $SErrors;


	public function SetValues($_id , $_name , $_stock_numbers , $_tag1 , $_tag2) {
		$this->name=$_name;
		$this->stock_numbers=$_stock_numbers;
		$this->tag1=$_tag1;
		$this->tag2=$_tag2;

	}


	public function SelectFromDB($_id) {
		global $db;
		if (!ereg("^([0-9]+)$",$_id)) {
			$this->Errors[]=_lang('invalid_id');
			return false;
		}
		$this->id=$_id;
		$sql = 'SELECT * FROM `stocks_group` WHERE `id` = '.$_id;
		if(! ($result=$db->sql_query($sql))) {
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1) {
			$this->Errors[]=_lang('no_stocks_group_found');
			return false;
		}


		$row = $db->sql_fetchrow($result);
		$this->name=$row['name'];
		$this->stock_numbers=$row['stock_numbers'];
		$this->tag1=$row['tag1'];
		$this->tag2=$row['tag2'];

		$sql = 'SELECT * FROM `yards_stocks_group` WHERE `stocks_group_id` = '.$_id;
		$yards=array();
		if($result=$db->sql_query($sql)) {
			while($row = $db->sql_fetchrow($result)) {
				$yards[$row['yard_id']]=$row['stock_numbers'];
			}
		}
		$this->yards=$yards;
		return true;
	}
	public function preview_template_stock($_id,$return=false) {
		global $db;

		if (!ereg("^([0-9]+)$",$_id)) {
			$this->Errors[]=_lang('invalid_id');
			return false;
		}
		$this->id=$_id;
		$sql = 'SELECT `yards_stocks_group`.* FROM `yards_stocks_group` WHERE `stocks_group_id` = '.$_id.' ';
		if(! ($result=$db->sql_query($sql))) {
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		if($db->sql_numrows($result)<1) {
			$this->Errors[]=_lang('no_stocks_group_found');
			return false;
		}
		$counter=0;
		$stocks=array();
		while($row=$db->sql_fetchrow($result)) {
			$numbers2=$numbers=explode(',',$row['stock_numbers']);
			foreach($numbers2 as $i=>$stock_num) {
				$numbers2[$i]="'{$stock_num}'";
			}
			$numbers2=implode(',', $numbers2);
			if(!empty ($numbers[0])) {
				//$numbers2['stock'][$counter]="'{$numbers[0]}'";
				$sql = "SELECT stock_no,make,model,rrp FROM afs_stock2 WHERE afs_stock2.stock_no = '{$numbers[0]}'";

				$result2=$db->sql_query($sql);
				$row2=$db->sql_fetchrow($result2);
				if(empty ($row2['stock_no'])) {
					$sql = "SELECT stock_no,make,model,rrp FROM afs_stock2 WHERE afs_stock2.stock_no IN ({$numbers2})";
					$result2=$db->sql_query($sql);
					$row2=$db->sql_fetchrow($result2);
				}
				if(!empty ($row2['stock_no'])) {
					$stocks['Stock'][$counter]=$row2;
					$stocks['Yard'][$counter++]="{$row['yard_id']}";
				}
			}
		}
		//print_r($numbers2);exit();
		//$row['stock_numbers']=implode(',', $numbers2['stock']);

		//$sql = "SELECT stock_no,make,model,rrp FROM afs_stock2 WHERE afs_stock2.stock_no IN ({$row['stock_numbers']})";
		//echo "<br />".$sql."<br />";
//		$result2=$db->sql_query($sql);
//		$stocks=array();
//		$counter=0;
//		while($row2=$db->sql_fetchrow($result2)) {
//			$stocks[$counter++]=$row2;
//		}
		//print_r($stocks);exit();

		$file=$GLOBALS['predir']."templates/template_{$this->id}.html.php";
		ob_start();
		include $file;
		$content = ob_get_clean();
		if($return) {
			return $content;
		}
		echo $content;
		exit();
	}
	public function Add_Email_Message($template_id,$id=NULL) {
		global $db,$site;

		$udpate=false;
		if(!empty ($id)) {
			$sql = 'SELECT `email_msg`.* FROM `email_msg` WHERE `msg_id` = '.$id.' ';
			if( ($result=$db->sql_query($sql))) {
				$udpate=true;
			}
		}
		
		$sql = 'SELECT `stocks_group`.* FROM `stocks_group` WHERE `id` = '.$template_id.' ';
		if(! ($result=$db->sql_query($sql))) {
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		if($db->sql_numrows($result)<1) {
			$this->Errors[]=_lang('no_stocks_group_found');
			return false;
		}
		$row=$db->sql_fetchrow($result);
		$message_name=$row['name'].' (Updated Automatically, don\'t amend)';
		$subject="{$site['name']} - {$row['name']}";
		$html=$this->preview_template_stock($template_id, true);
		if($udpate){
			$sql = 'UPDATE `email_msg` SET `msg_name` = \''.PreSql($message_name).'\',`msg_subject` = \''.PreSql($subject).'\',`msg_body` = \''.PreSql($html,0).'\' WHERE `msg_id`='.$id;
		}elseif(!empty ($id)){
			$sql = 'INSERT INTO `email_msg` (`msg_id`,`msg_name`, `msg_subject`, `msg_body`) VALUES (\''.$id.'\',\''.PreSql($message_name).'\',  \''.PreSql($subject).'\',  \''.PreSql($html,0).'\')';
		}
		else{
			$sql = 'INSERT INTO `email_msg` (`msg_name`, `msg_subject`, `msg_body`) VALUES (\''.PreSql($message_name).'\',  \''.PreSql($subject).'\',  \''.PreSql($html,0).'\')';
		}
		
		if(!$db->sql_query($sql)) {
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		return true;
	}
	public function Insert() {
		global $db;
//		print_r($_POST);exit();
		$sql = 'INSERT INTO `stocks_group` (`name`, `tag1`,  `tag2`) VALUES (\''.PreSql($this->name).'\',  \''.PreSql($this->tag1).'\',  \''.PreSql($this->tag2).'\')';
		if(!$db->sql_query($sql)) {
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}
		$stock_id=$db->sql_nextid();

		foreach($this->yards as $yard=>$stock) {
			$stocks_num=explode(',', $stock['stock_numbers']);
			foreach($stocks_num as $i=>$value) {
				$stocks_num[$i]=trim($value);
			}
			$stock['stock_numbers']=implode(',',$stocks_num);

			$sql = 'INSERT INTO `yards_stocks_group` (`yard_id`, `stock_numbers`,  `stocks_group_id`) VALUES (\''.PreSql($yard).'\',  \''.PreSql($stock['stock_numbers']).'\',  \''.$stock_id.'\')';
			if(!$db->sql_query($sql)) {
				$this->Errors[]=$db->sql_error_msg($result);
				return false;
			}
		}
		return $stock_id;
	}


	public function Add() {
		$op='Add';
		$yards=$this->get_yards();
		include '../forms/fstocks_group.php';
	}

	public function Delete() {
		global $db;

		$sql = 'DELETE FROM `stocks_group` WHERE `id`='.$this->id;
		if(!$db->sql_query($sql)) {
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update') {
		$id=PreForm($this->id);
		$name=PreForm($this->name);
		$stock_numbers=PreForm($this->stock_numbers);
		$tag1=PreForm($this->tag1);
		$tag2=PreForm($this->tag2);

		$yards=$this->get_yards();

		$yards_stocks=$this->yards;

		$op=$_op;
		include '../forms/fstocks_group.php';
	}

	public function Update() {
		global $db;
		$sql = 'UPDATE `stocks_group` SET `name` = \''.PreSql($this->name).'\', `tag1` = \''.PreSql($this->tag1).'\', `tag2` = \''.PreSql($this->tag2).'\' WHERE `id` = '.$this->id;

		if(!$db->sql_query($sql)) {
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		foreach($this->yards as $yard=>$stock) {
			$stocks_num=explode(',', $stock['stock_numbers']);
			foreach($stocks_num as $i=>$value) {
				$stocks_num[$i]=trim($value);
			}
			$stock['stock_numbers']=implode(',',$stocks_num);
			$sql = 'UPDATE `yards_stocks_group` SET `stock_numbers` = \''.PreSql($stock['stock_numbers']).'\' WHERE `stocks_group_id` = '.$this->id .' AND `yard_id` = '.$yard;
			if(!$db->sql_query($sql)) {
				$this->Errors[]=$db->sql_error_msg($result);
				return false;
			}
		}
		return true;

	}

	public function FromForm() {
		$this->yards=$_POST['yard'];
		$this->id=PostForm($_POST['id']);
		$this->name=PostForm($_POST['name']);
		//$this->stock_numbers=PostForm($_POST['stock_numbers']);
		$this->tag1=PostForm($_POST['tag1']);
		$this->tag2=PostForm($_POST['tag2']);

	}
	public static function AdminListstocks_groups() {
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
			$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * FROM `stocks_group`  	ORDER BY `id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang('list_stock_group').':</p>' ;
		$List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang('name').'</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page) {
			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;
			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td><td width="60%">'.
					"<a href=\"?id=$row[id]&op=Edit\">$row[name]</a></td>".
					"</tr> ";
		}
		$List.= '</table>';
		$List.="<div class=\"admin_list_control\">";
		if($admin_page>1)
			$List.= "&laquo; <a href=\"?admin_page=".($admin_page-1)."\" >"._lang('list_previous_page')." $per_page </a>&nbsp;&nbsp; ";

		if($page_no>2) {
			$List.='<select onchange="document.location=\'?admin_page=\'+this.value;">';
			for($i=1;$i<=$page_no;$i++) {
				$sel="";
				if($admin_page==$i) $sel="selected";
				$List.='<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
			}
			$List.='</select>';
		}

		if($no>$per_page )
			$List.= "&nbsp;<a href=\"?admin_page=".($admin_page+1)."\" > "._lang('list_next_page')." $per_page</a> &raquo;";

		$List.="</div><br/>";
		$List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
		<label for="job_id">&nbsp;&nbsp;<b>'._lang('enter_id').':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		
	</form>
	<br/>';
		return $List;


	}


	function BuildStocksForm() {
		include($GLOBALS['predir'].'forms/build_stocks.php');

	}

	function BurnEmailForSubscribersFromForm() {
		global $db;
		if(!($html=self::BuildStocksFromForm()))
			return false;

		$email_msg1= new email_msg();
		$email_msg1->msg_name=$_POST['name'];
		$email_msg1->msg_subject=$_POST['email_subject'];
		$email_msg1->msg_body=$html;

		if(!($msg_id=$email_msg1->Insert())) {
			self::$SErrors=$email_msg1->Errors;
			return false;
		}

		if($_POST['date_to_send']) {
			$tmp=explode('-',$_POST['date_to_send']);
			if(sizeof($tmp)!=3) {
				self::$SErrors[]='Invalide date';
				return false;
			}
			$date="{$tmp[2]}-{$tmp[1]}-{$tmp[0]}";
		}
		else
			$date='now';

		if(!special::SendMailToSubscribers($msg_id,$date)) {
			self::$SErrors=special::$SErrors;
			return false;
		}

		return $msg_id;

	}


	function SendTestEmail($html,$subject) {
		global $site;
		$from=$site['from_mail'];
		if(mail($_POST['test_email_address'],$subject,$html,"From: $from\nReply-To: enquiry@austfleetsales.com.au\nContent-Type: text/html"))
			return true;

		self::$SErrors[]='Can\'t Send Email To "'.$_POST['test_email_address'].'" ';
		return false;
	}

	function BuildStocksFromForm($temp=false) {
		global $db;

		$upload_dir= $GLOBALS['predir'].$GLOBALS['images_upload_dir'];


		if($_FILES['header_image']['name']) {
			list($file,$error)= UploadImage('header_image',$upload_dir,'jpg,gif,png',50000000,'',1,598,1000);
			$image_file=$GLOBALS['images_upload_dir'].'//'.$file;
		}

		if($error) {
			self::$SErrors[]=  " Cannot Upload For Image:".$error;
			return false;
		}


		if(!sizeof($_POST['group_ids'])) {
			self::$SErrors[]=  "No group is selected";
			return false;
		}
		$groups=array();

		foreach ($_POST['group_ids'] as $group_id) {
			if($group_id<0) {
				$groups[$group_id]='-';
				continue;
			}
			$group1= new stocks_group();
			$group1->SelectFromDB($group_id);
			$groups[$group1->name]= array();
			$stocks=explode(',',$group1->stock_numbers);
			if(!sizeof($stocks)) {
				self::$SErrors[]=  "Group '{$group1->name}' has no stock numbers !";
				return false;
			}
			$row='';
			$j=0;
			$featured=array();
			foreach ($stocks as $stock_no) {

				$afs_stock2=new afs_stock2();

				if(!$afs_stock2->SelectFromDB(trim($stock_no),$row)) {
					self::$SErrors[]="Error with stock number:#{$stock_no} in group '{$group1->name}'";
					array_push(self::$SErrors[],$afs_stock2->Errors);
					return false;
				}

				//Car image
				if(file_exists($GLOBALS['predir'].'image_uploads/'.$stock_no.'/image_1_thumb.jpg'))
					$row['image']= 'image_uploads/'.$stock_no.'/image_1_thumb.jpg';
				else
					$row['image']='image_uploads/default_thumb.jpg';
				if($j==0)
					$featured[]=$row;
				else
					$groups[$group1->name][]=$row;

				$j++;
			}
			//if(sizeof($groups[$group1->name]))
			//print_r($groups[$group1->name]);
			multi2dSortAsc($groups[$group1->name],'rrp');
			//print_r($groups[$group1->name]);

			$groups[$group1->name]=array_merge($featured,$groups[$group1->name]);

		}
		return self::BuildStocksHTML($_POST['email_subject'],$groups,$image_file);
	}


	function BuildStocksHTML($email_subject,$groups,$header_image) {

		global $site;
		ob_start();
		include($GLOBALS['predir'].'templates/stocks.html');
		$html_email =ob_get_contents();
		ob_clean();
		return $html_email;
	}

	public static function ListOptions() {
		global $db;
		$sql = 'SELECT `id`,`name` FROM `stocks_group`  ORDER BY `name`  ';

		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		while($row = $db->sql_fetchrow($result)) {
			$items[]=$row['name'];
			$items_values[]=$row['id'];
		}
		return ListOptions($items,$items_values,"",true);
	}

	function get_yards() {
		global $db;
		$sql = 'SELECT id,name,code FROM yard';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$i=0;
		while($row = $db->sql_fetchrow($result)) {
			$yards[$i]['id']=$row['id'];
			$yards[$i]['name']=$row['name'];
			$yards[$i++]['code']=$row['code'];
		}
		return $yards;
	}

}

?>