<?php
class seo_metatag
{

	public  $id;
	public  $page_name;
	public  $keywords;
	public  $decsription;
	public  $key_query;
	public  $desc_query;
	public  $typical;

	var  $Errors;


	public function SetValues($_id , $_page_name , $_keywords , $_decsription , $_key_query , $_desc_query , $_typical)
	{	$this->page_name=$_page_name;
	$this->keywords=$_keywords;
	$this->decsription=$_decsription;
	$this->key_query=$_key_query;
	$this->desc_query=$_desc_query;
	$this->typical=$_typical;

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
		$sql = 'SELECT * FROM `seo_metatag` WHERE `id` = '.$_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang('no_seo_metatag_found');
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->page_name=$row['page_name'];
		$this->keywords=$row['keywords'];
		$this->decsription=$row['decsription'];
		$this->key_query=$row['key_query'];
		$this->desc_query=$row['desc_query'];
		$this->typical=$row['typical'];
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `seo_metatag` (`page_name`, `keywords`, `decsription`, `key_query`, `desc_query`,  `typical`) VALUES (\''.PreSql($this->page_name).'\',  \''.PreSql($this->keywords).'\',  \''.PreSql($this->decsription).'\',  \''.PreSql($this->key_query).'\',  \''.PreSql($this->desc_query).'\',  \''.PreSql($this->typical).'\')';
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
		include '../forms/fseo_metatag.php';

	}

	public function Delete()
	{
		global $db;

		global $images_upload_dir;
		//Delete Images
		$sql='SELECT  `typical` FROM `seo_metatag`  WHERE `id`='.$this->id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if($row[0] != '') unlink('../'.$images_upload_dir.'/'.$row[0]);
		$sql = 'DELETE FROM `seo_metatag` WHERE `id`='.$this->id;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update')
	{
		global $images_upload_dir;
		$id=PreForm($this->id);
		$page_name=PreForm($this->page_name);
		$keywords=PreForm($this->keywords);
		$decsription=PreForm($this->decsription);
		$key_query=PreForm($this->key_query);
		$desc_query=PreForm($this->desc_query);
		$typical=PreForm($this->typical);

		$op=$_op;

		include '../forms/fseo_metatag.php';

	}

	public function Update()
	{
		global $db;
		global $images_upload_dir;
		//Delete Unused Images
		$sql='SELECT  `typical` FROM `seo_metatag`  WHERE `id`='.$this->id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if($row[0] != $this->typical && $this->typical!='' ) @unlink('../'.$images_upload_dir.'/'.$row[0]);

		$sql = 'UPDATE `seo_metatag` SET `page_name` = \''.PreSql($this->page_name).'\', `keywords` = \''.PreSql($this->keywords).'\', `decsription` = \''.PreSql($this->decsription).'\', `key_query` = \''.PreSql($this->key_query).'\', `desc_query` = \''.PreSql($this->desc_query).'\', `typical` = \''.PreSql($this->typical).'\' WHERE `id` = '.$this->id;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function FromForm()
	{
		global $images_upload_dir,$image_width,$image_height,$thumb_image_width,$thumb_image_height;
		$this->id=PostForm($_POST['id']);
		$this->page_name=PostForm($_POST['page_name']);
		$this->keywords=PostForm($_POST['keywords']);
		$this->decsription=PostForm($_POST['decsription']);
		$this->key_query=PostForm($_POST['key_query']);
		$this->desc_query=PostForm($_POST['desc_query']);
		$this->typical=PostForm($_POST['typical']);


	}
	public static function AdminListseo_metatags()
	{
		global $db,$list_per_page;
		$per_page=$list_per_page;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT * FROM `seo_metatag`  	ORDER BY `id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount($sql),$per_page);
		$List= '<p class="admin_title">'._lang('list_seo_metatag').':</p>' ;
		$List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang('page_name').'</td><td width="30%">'._lang('delete').'</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td><td width="60%">'.
			"<a href=\"?id=$row[id]&op=Edit\">$row[page_name]</a></td>".
			"<td width=\"30%\"><a href=\"javascript:if (confirm('"._lang('sure_delete_seo_metatag')."')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
		}
		$List.= '</table>';
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
		$List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
		<label for="job_id">&nbsp;&nbsp;<b>'._lang('enter_id').':</b></label>
		<input type="hidden" name="op" value="Edit" />
		<input type="text" name="id" />
		<input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
		<input onclick="if (confirm(\''._lang('sure_delete_prod').'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
	</form>
	<br/>';
		return $List;


	}
	static function GetMeta()
	{
		global $$site,$db;
		//echo $_SERVER['REQUEST_URI']."<br/>";
		$curr_page= str_replace($site["url"].'/','',$_SERVER['REQUEST_URI']);
		
		/*if($_SERVER['REMOTE_ADDR']=='41.152.41.208')
		echo ''.$curr_page.'<br/>';*/
		if($_SERVER['QUERY_STRING'])
		{
		$curr_page=str_replace('?'.$_SERVER['QUERY_STRING'],'',$curr_page);
		//echo $curr_page;
		}
	
		$sql='SELECT * FROM `seo_metatag` WHERE `page_name` = \''.$curr_page.'\'';
		$result=$db->sql_query($sql);
		$row=$db->sql_fetchrow($result);
		$retv[0]='';
		$retv[1]='';
		if($row != '')
		{
			if($row[4] != '')
			{
				eval("\$ksql =\"$row[4]\";");
				$kresult=$db->sql_query($ksql);
				$krow=$db->sql_fetchrow($kresult);
				$retv[0]=$krow[0];
			}
			if($row[5] != '')
			{
				eval("\$dsql =\"$row[5]\";");
				$dresult=$db->sql_query($dsql);
				$drow=$db->sql_fetchrow($dresult);
				$retv[1]=$drow[0];
			}
			if($row[2]!='')
			{
				$retv[0].=$row[2];
			}
			if($row[3]!='')
			{
				$retv[1].=$row[3];
			}
		}
		else
		{
			$sql='SELECT * FROM `seo_metatag` WHERE `page_name` = \'default\'  ';
			
			$result=$db->sql_query($sql);
			$row=$db->sql_fetchrow($result);
			$retv[0]=$row[2];
			$retv[1]=$row[3];
		}
		return $retv;

	}
}

?>