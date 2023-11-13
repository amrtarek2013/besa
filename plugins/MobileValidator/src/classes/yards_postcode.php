<?php
class yards_postcode
{

	public  $id;
	public  $state;
	public  $suburb;
	public  $postcode;
	public  $yard;
	public  $tag1;
	public  $tag2;

	var  $Errors;
	public static  $SErrors;


	public function SetValues($_id , $_state , $_suburb , $_postcode , $_yard , $_tag1 , $_tag2)
	{	$this->state=$_state;
	$this->suburb=$_suburb;
	$this->postcode=$_postcode;
	$this->yard=$_yard;
	$this->tag1=$_tag1;
	$this->tag2=$_tag2;

	}


	public function SelectFromDB($_id)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_id))
		{
			$this->Errors[]=_lang(invalid_id);
			return false;
		}
		$this->id=$_id;
		$sql = 'SELECT * FROM `yards_postcode` WHERE `id` = '.$_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang(no_yards_postcode_found);
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->state=$row['state'];
		$this->suburb=$row['suburb'];
		$this->postcode=$row['postcode'];
		$this->yard=$row['yard'];
		$this->tag1=$row['tag1'];
		$this->tag2=$row['tag2'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `yards_postcode` (`state`, `suburb`, `postcode`, `yard`, `tag1`,  `tag2`) VALUES (\''.PreSql($this->state).'\',  \''.PreSql($this->suburb).'\',  \''.PreSql($this->postcode).'\',  \''.PreSql($this->yard).'\',  \''.PreSql($this->tag1).'\',  \''.PreSql($this->tag2).'\')';
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
		include '../forms/fyards_postcode.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `yards_postcode` WHERE `id`='.$this->id;
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
		$state=PreForm($this->state);
		$suburb=PreForm($this->suburb);
		$postcode=PreForm($this->postcode);
		$yard=PreForm($this->yard);
		$tag1=PreForm($this->tag1);
		$tag2=PreForm($this->tag2);

		$op=$_op;

		include '../forms/fyards_postcode.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `yards_postcode` SET `state` = \''.PreSql($this->state).'\', `suburb` = \''.PreSql($this->suburb).'\', `postcode` = \''.PreSql($this->postcode).'\', `yard` = \''.PreSql($this->yard).'\', `tag1` = \''.PreSql($this->tag1).'\', `tag2` = \''.PreSql($this->tag2).'\' WHERE `id` = '.$this->id;

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
		$this->state=PostForm($_POST['state']);
		$this->suburb=PostForm($_POST['suburb']);
		$this->postcode=PostForm($_POST['postcode']);
		$this->yard=PostForm($_POST['yard']);
		$this->tag1=PostForm($_POST['tag1']);
		$this->tag2=PostForm($_POST['tag2']);
	}
	
	public static function GetYardFromPostCode($postcode)
	{
		
		global $db;
		$postcode=trim($postcode);
		$postcode=(int) $postcode;
		
		if(strpos(" ".$postcode,'4')==1) return 'Q';
		
		$sql = 'SELECT `yard` FROM `yards_postcode` WHERE `postcode` = \''.$postcode.'\' and yard is not null';
		
		if(! ($result=$db->sql_query($sql)))
		{
			yards_postcode::$SErrors[]=$db->sql_error_msg($result);
debug(yards_postcode::$SErrors[0]);
			return false;
		}
		if($row=$db->sql_fetchrow($result))
		return $row['yard'];
		
		yards_postcode::$SErrors[]=_lang('no_yards_postcode_found');
		return false;
		
	}
	
	
	public static function AdminListyards_postcodes()
	{
		global $db,$list_per_page;
		$per_page=200;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * FROM `yards_postcode`  WHERE 1=1 '.($_GET['yard']?' AND lower(yard)=\''.strtolower(trim($_GET['yard'])).'\'':'').' '.($_GET['postcode']?' AND lower(postcode)=\''.strtolower(trim($_GET['postcode'])).'\'':'').'	ORDER BY `postcode`  LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang(list_yards_postcode).':</p>' ;
		$List.= '<form action="?" method="get" ><table class="adminlist" width="600"><tr class="header"><td width="10%">ID</td>
		<td width="30%">State</td>
		<td width="30%">Suburb</td>
		<td width="5%">Postcode<br/><input style="width:60px;" type="text" name="postcode" id="postcode" value="'.$_GET['postcode'].'"/></td>
		<td width="15%">Yard<br/><input  style="width:60px;" type="text" name="yard" id="yard" value="'.$_GET['yard'].'"/></td>
		<td width="10%">'._lang(delete).'<br/><input value="GO" type="submit"/></td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td>'.
			"<td><a href=\"?id=$row[id]&op=Edit\">$row[state]</a></td>".
			"<td ><a href=\"?id=$row[id]&op=Edit\">$row[suburb]</a></td>".
			"<td ><a href=\"?id=$row[id]&op=Edit\">$row[postcode]</a></td>".
			"<td ><a href=\"?id=$row[id]&op=Edit\">$row[yard]</a></td>".
			"<td ><a href=\"javascript:if (confirm('"._lang(sure_delete_yards_postcode)."')) {document.location ='?yard=$_GET[yard]&postcode=$_GET[postcode]&id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
		}
		$List.= '</table></form>';
		$List.="<div class=\"admin_list_control\">";
		if($admin_page>1)
		$List.= "&laquo; <a href=\"?yard=$_GET[yard]&postcode=$_GET[postcode]&admin_page=".($admin_page-1)."\" >"._lang(list_previous_page)." $per_page </a>&nbsp;&nbsp; ";

		if($page_no>2)
		{
			$List.='<select onchange="document.location=\'?yard='.$_GET[yard].'&postcode='.$_GET[postcode].'&admin_page=\'+this.value;">';
			for($i=1;$i<=$page_no;$i++)
			{
				$sel="";
				if($admin_page==$i) $sel="selected";
				$List.='<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
			}
			$List.='</select>';
		}

		if($no>$per_page )
		$List.= "&nbsp;<a href=\"?yard=$_GET[yard]&postcode=$_GET[postcode]&admin_page=".($admin_page+1)."\" > "._lang(list_next_page)." $per_page</a> &raquo;";

		$List.="</div><br/>";
		/*$List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
		<label for="job_id">&nbsp;&nbsp;<b>'._lang(enter_id).':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang(sure_delete_yards_postcode).'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';*/
		return $List;


	}
	
	
	public static function AdminListUnassigendYards()
	{
		global $db,$list_per_page;
		$per_page=200;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * from afs_form WHERE postcode  NOT IN (SELECT postcode::text   from yards_postcode ) AND yard IS NULL ORDER by postcode  LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).'  ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">Forms which cannot be assigned to a yard:</p>' ;
		$List.= '<table class="adminlist" width="600"><tr class="header"><td width="10%">ID</td>
		<td width="30%">Source</td>
		<td width="30%">Postcode</td>
		<td width="15%">Yard</td>
		</tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row['subscriberid'].'</td>'.
			"<td><a title=\"".FormatTime($row[stamp_time])."\" href=\"elist_form.php?table_name=$row[table_name]&subscriberid=$row[subscriberid]&op=Edit\">$row[source]</a></td>".
			"<td ><a title=\"".FormatTime($row[stamp_time])."\" href=\"elist_form.php?table_name=$row[table_name]&subscriberid=$row[subscriberid]&op=Edit\">$row[postcode]</a></td>".
			"<td ><a title=\"".FormatTime($row[stamp_time])."\" href=\"elist_form.php?table_name=$row[table_name]&subscriberid=$row[subscriberid]&op=Edit\">$row[yard]</a></td>".
			"</tr> ";
		}
		$List.= '</table>';
		$List.="<div class=\"admin_list_control\">";
		if($admin_page>1)
		$List.= "&laquo; <a href=\"op=List2&admin_page=".($admin_page-1)."\" >"._lang(list_previous_page)." $per_page </a>&nbsp;&nbsp; ";

		if($page_no>2)
		{
			$List.='<select onchange="document.location=\'?op=List2&admin_page=\'+this.value;">';
			for($i=1;$i<=$page_no;$i++)
			{
				$sel="";
				if($admin_page==$i) $sel="selected";
				$List.='<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
			}
			$List.='</select>';
		}

		if($no>$per_page )
		$List.= "&nbsp;<a href=\"?op=List2&admin_page=".($admin_page+1)."\" > "._lang(list_next_page)." $per_page</a> &raquo;";
		
		
		$sql_exporter = 'SELECT * from afs_form WHERE postcode  NOT IN (SELECT postcode   from yards_postcode) AND yard IS NULL  ORDER BY postcode  ';
echo '<form action="exporttocsv.php" method="post" >
				Delimited:
				<select name="delimited"><option value="comma">Comma ( , )</option><option value="tab">Tab</option><option value="semi">Semicolon(;)</option></select>
					
				<input name="sql" type="hidden" value="'.PreForm($sql_exporter).'" />
				<input type="submit" value="Dump CSV File" /></form>
			</div>';
	
		return $List;


	}
	
	
	
	public static function UpdateAll()
	{
		global $db;
		$sql = elist_form::GenerateSqlForAllForms('UPDATE {table_name} SET yard=(SELECT yards_postcode.yard FROM yards_postcode WHERE yards_postcode.postcode::text = {table_name}.postcode::text  LIMIT 1) WHERE yard IS NULL OR yard=\'\' ');
		//$sql="";
		//die($sql);
		if(! $db->sql_query($sql))
		{
			self::$SErrors[]=$db->sql_error_msg($result);
			return false;
		}
		return true;
	}

}

?>