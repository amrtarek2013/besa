<?

class docs
{

	public static $order_by_list=array("added_date.DESC","added_date.ASC","counter.DESC","title.ASC","title.DESC");
	
public static function order_by_titles()
	{
		return array(_lang("date.DESC"),_lang("date.ASC"),_lang("counter"),_lang("title.ASC"),_lang("title.DESC"));
	}
	
	
	public static function ListFeaturedItems()
	{
		global $db;
		$sql = 'SELECT * FROM `doc` WHERE `active`=1 AND `featured` = \'1\'';
		$result = $db->sql_query($sql);
		$i=0;
		$no=$db->sql_numrows($result);
		if($no>0)
			FeaturedItemsHead();
		while($row = $db->sql_fetchrow($result))
		{
			if($i==$no-1&&$i!=0) $i="last";
			DocBlock($i,$row['doc_id'] , $row['title'] , $row['desc'] , $row['added_date'] , $row['doc_cat_id'] , $row['file1'] , $row['file2'] , $row['file3'] , $row['thumb_pic'] , $row['featured'] , $row['counter'] , $row['active'] , $row['keywords'] , $row['tag3']);
			$i++;
		}		
	}


	public function GenerateSearchQuery($keywords,$match="any",$cat_id="",$page_no=1,$docs_per_page=1000,$order_by="added_date.DESC",$added_after="",$year="",$month="")
	{
		$order=explode(".",$order_by);
		$sql_keywords=PreSql($keywords);
		
		$sql_keywords=strtolower($sql_keywords);

		if($match=="any")
		$where = '  AND (lower(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\' \'||`title`||\' \'||COALESCE(`keywords`,\' \')||\' \'||\' \',\',\',\' \'),\'.\',\' \'),\'-\',\' \'),\'+\',\' \'),\'&\',\' \'),\')\',\' \'),\'(\',\' \'),\']\',\' \'),\'[\',\' \'))
		 LIKE \'% '.str_replace(" ",' %\' OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\' \'||`title`||\' \'||COALESCE(`keywords`,\'\')||\' \'||\' \',\',\',\' \'),\'.\',\' \'),\'-\',\' \'),\'+\',\' \'),\'&\',\' \'),\')\',\' \'),\'(\',\' \'),\']\',\' \'),\'[\',\' \') LIKE \'% ',$sql_keywords).' %\')';
		else
		$where = '  AND (lower(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\' \'||`title`||\' \'||COALESCE(`keywords`,\' \')||\' \'||\' \',\',\',\' \'),\'.\',\' \'),\'-\',\' \'),\'+\',\' \'),\'&\',\' \'),\')\',\' \'),\'(\',\' \'),\']\',\' \'),\'[\',\' \'))
		 LIKE \'% '.str_replace(" ",' %\' AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\' \'||`title`||\' \'||COALESCE(`keywords`,\'\')||\' \'||\' \',\',\',\' \'),\'.\',\' \'),\'-\',\' \'),\'+\',\' \'),\'&\',\' \'),\')\',\' \'),\'(\',\' \'),\']\',\' \'),\'[\',\' \') LIKE \'% ',$sql_keywords).' %\')';



		if($cat_id!="")	$where.=" AND `cat1`.`cat_id`=$cat_id";
		
		if($year!="")
			$where.=" AND  DATE_FORMAT( `added_date` , '%Y' )='$year' ";
			
		if($month!="")
			$where.=" AND  DATE_FORMAT( `added_date` , '%m' )='$month' ";			

		if($added_after!="")	$where.=" AND `doc`.`added_date`>='$added_after' ";

		$sql = 'SELECT * FROM `doc`,category_doc as `cat1` WHERE `doc`.`active`=true AND `doc`.`doc_cat_id`=`cat1`.`cat_id` '.$where.' ORDER BY `'.$order[0].'` '.$order[1].' LIMIT '.($page_no-1)*$docs_per_page .", $docs_per_page ";
		//echo $sql;
		return $sql;


	}

	public static function Searchdocs($keywords,$match="any",$cat_id="",$page_no=1,$docs_per_page=1000,$order_by="added_date.DESC",$year="",$month="")
	{
		global $db;

		$sql=docs::GenerateSearchQuery($keywords,$match,$cat_id,$page_no,$docs_per_page,$order_by,"",$year,$month);
		

		//Calculate all results and pages count
		$result = $db->sql_query(str_replace("*",'COUNT(*)',substr($sql,0,strpos($sql,"ORDER"))  ) );
		$row = $db->sql_fetchrow($result);
		$result_count=$row[0];
		$page_count=$result_count/$docs_per_page;
		if($page_count!=floor($page_count)) $page_count=floor($page_count)+1;


		
		$result = $db->sql_query($sql) or PrintErrors(array($db->sql_error_msg(),$sql));
		$i=10;
		$no=$db->sql_numrows($result);
		if($no>0)
		DocSearchHead($keywords,$result_count,$page_no,$page_count,$cat_id, $order_by);
		else
		NoDocResult($usr_id,$no);

		while($row = $db->sql_fetchrow($result))
		{

			if($i==$no-1) $i="last";
			DocBlock($i,$row['doc_id'] , $row['title'] , $row['desc'] , $row['added_date'] , $row['doc_cat_id'] , $row['file1'] , $row['file2'] , $row['file3'] , $row['thumb_pic'] , $row['featured'] , $row['counter'] , $row['active'] , $row['keywords'] , $row['tag3']);
			$i++;

		}
		if($no>0)
		DocSearchFoot($keywords,$result_count,$page_no,$page_count,$cat_id,$order_by );

	}
	
	


	
	public static function GetPageCountForCategory($cat_id,$docs_per_page=1000)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM `doc` WHERE `active`=1 AND  `doc_cat_id` = '.$cat_id;
		$result = $db->sql_query($sql);
		$row=$db->sql_fetchrow($result);
		
		if(($row[0]/$docs_per_page)==floor($row[0]/$docs_per_page) )
		$ret=floor($row[0]/$docs_per_page);
		else
		$ret=floor($row[0]/$docs_per_page)+1;
		return $ret;
	}
	
	
	public static function CategoryListDocs($cat_id,$page_no=1,$docs_per_page=1000,$order_by="date.DESC")
	{
		global $db;
		
		$order=explode(".",$order_by);
		$sql = 'SELECT * FROM `doc` WHERE `active`=1 AND '."`doc_cat_id`=".$cat_id." ORDER BY `$order[0]` $order[1] LIMIT ".($page_no-1)*$docs_per_page .", $docs_per_page ";
		
		$result = $db->sql_query($sql);
		$i=0;
		$no=$db->sql_numrows($result);
		
		while($row = $db->sql_fetchrow($result))
		{
			if($i==$no-1&&$i!=0) $i="last";
			DocBlock($i,$row['doc_id'] , $row['title'] , $row['desc'] , $row['added_date'] , $row['doc_cat_id'] , $row['file1'] , $row['file2'] , $row['file3'] , $row['thumb_pic'] , $row['featured'] , $row['counter'] , $row['active'] , $row['keywords'] , $row['tag3']);
			$i++;
		}
	}	
	
	
	public static function ListYearSelectOptions($selected="")
	{
		global $db;
		$sql = 'SELECT DISTINCT DATE_FORMAT(`added_date`,\'%Y\') AS `year`  FROM `doc` ' or die($db->sql_error_msg($result) );;
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			if($row['year']==$selected)
			$sel=' selected="selected" ';
			else
			$sel='';
			$List.= "<option value=\"$row[year]\" $sel >$row[year]</option>\n";
		}
		return $List;
	}	
	
	public static function ListMonthOptions($selected="")
	{
		global $db;
		$sql = 'SELECT DISTINCT DATE_FORMAT(`added_date`,\'%m\') AS `year`  FROM `doc` ' or die($db->sql_error_msg($result) );;
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			if($row['year']==$selected)
			$sel=' selected="selected" ';
			else
			$sel='';
			$List.= "<option value=\"$row[year]\" $sel >$row[year]</option>\n";
		}
		return $List;
	}	


}





?>
