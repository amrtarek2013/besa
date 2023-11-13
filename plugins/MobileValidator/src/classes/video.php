<?php
class video
{


	public  $id;
	public  $title;
	public  $desc;
	public  $video_file;
	public  $thumb_image;
	public  $duration;
	public  $cat_id;
	public  $active;
	public  $featured;
	public  $display_order;

	var  $Errors;

	public static $uploads_dir='uploads';
	public static $video_width=512;
	public static $video_height=288;
	public static $thumb_width=100;
	public static $thumb_height=75;






	public function SetValues($_id , $_title , $_desc , $_video_file , $_thumb_image , $_duration , $_cat_id , $_active , $_featured, $_display_order)
	{	$this->title=$_title;
	$this->desc=$_desc;
	$this->video_file=$_video_file;
	$this->thumb_image=$_thumb_image;
	$this->duration=$_duration;
	$this->cat_id=$_cat_id;
	$this->active=$_active;
	$this->featured=$_featured;
	$this->display_order=$_display_order;

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
		$sql = 'SELECT * FROM `video` WHERE `id` = '.$_id;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang('no_video_found');
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->FromRow($row);
		return true;


	}

	function FromRow($row)
	{
		$this->id=$row['id'];
		$this->title=$row['title'];
		$this->desc=$row['desc'];
		$this->video_file=$row['video_file'];
		$this->thumb_image=$row['thumb_image'];
		$this->duration=$row['duration'];
		$this->cat_id=$row['cat_id'];
		$this->active=$row['active'];
		$this->featured=$row['featured'];
		$this->display_order=$row['display_order'];
	}

	public function Insert()
	{
		if(sizeof($this->Errors)>0) return false;
		global $db;
		$sql = 'INSERT INTO `video` (`title`, `desc`, `video_file`, `thumb_image`, `duration`, `cat_id`, `active`,  `featured`,  `display_order`) VALUES (\''.PreSql($this->title).'\',  \''.PreSql($this->desc).'\',  \''.PreSql($this->video_file).'\',  \''.PreSql($this->thumb_image).'\',  \''.PreSql($this->duration).'\',  \''.PreSql($this->cat_id).'\',  \''.PreSql($this->active).'\',  \''.PreSql($this->featured).'\',  \''.PreSql($this->display_order).'\')';
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
		include '../forms/fvideo.php';

	}

	public function Delete()
	{
		global $db;


		//Delete Images
		$sql='SELECT  `video_file`,  `thumb_image` FROM `video`  WHERE `id`='.$this->id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		for($i=0;$i<2;$i++)
		if($row[$i] != '') unlink('../'.self::$uploads_dir.'/'.$row[$i]);

		$sql = 'DELETE FROM `video` WHERE `id`='.$this->id;
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
		$title=PreForm($this->title);
		$desc=PreForm($this->desc);
		$video_file=PreForm($this->video_file);
		$thumb_image=PreForm($this->thumb_image);
		$duration=PreForm($this->duration);
		$cat_id=PreForm($this->cat_id);
		$active=PreForm($this->active);
		$featured=PreForm($this->featured);
		$display_order=PreForm($this->display_order);

		$op=$_op;

		include '../forms/fvideo.php';

	}

	public function Update()
	{
		global $db;
		if(sizeof($this->Errors)>0) return false;
		//Delete Unused Images
		$pics[0]= $this->video_file;
		$pics[1]= $this->thumb_image;
		$sql='SELECT  `video_file`,  `thumb_image` FROM `video`  WHERE `id`='.$this->id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		for($i=0;$i<2;$i++)
		if($row[$i] != $pics[$i] && $pics[$i]!='' ) @unlink('../'.self::$uploads_dir.'/'.$row[$i]);

		$sql = 'UPDATE `video` SET `title` = \''.PreSql($this->title).'\', `desc` = \''.PreSql($this->desc).'\', `video_file` = \''.PreSql($this->video_file).'\', `thumb_image` = \''.PreSql($this->thumb_image).'\', `duration` = \''.PreSql($this->duration).'\', `cat_id` = \''.PreSql($this->cat_id).'\', `active` = \''.PreSql($this->active).'\', `featured` = \''.PreSql($this->featured).'\', `display_order` = \''.PreSql($this->display_order).'\' WHERE `id` = '.$this->id;

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
		$this->title=PostForm($_POST['title']);
		$this->desc=PostForm($_POST['desc']);
		$this->duration=PostForm($_POST['duration']);
		$this->cat_id=PostForm($_POST['cat_id']);
		$this->active=PostForm($_POST['active']);
		$this->featured=PostForm($_POST['featured']);
		$this->display_order=PostForm($_POST['display_order']);
		//$this->video_file=PostForm($_POST['video_file']);
		//$this->thumb_image=PostForm($_POST['thumb_image']);

		if($_FILES['video_file']['name']) {
		list($file,$error) = Upload('video_file','../'.self::$uploads_dir,'flv',5000000000,'');
		if($error) $this->Errors[]= "Cannot Upload For Video file:".$error;
		else
		$this->video_file=$file;
		}

		if($_FILES['thumb_image']['name']) {
			list($file,$error) = UploadImage('thumb_image','../'.self::$uploads_dir,'jpeg,gif,png,jpg,bmp',5000000,'',2,self::$video_width,self::$video_height,self::$thumb_width,self::$thumb_height);
			if($error) $this->Errors[]=  " Cannot Upload For Image:".$error;
			else
			$this->thumb_image=$file;
		}

	}

	public function ShowVideo()
	{

		self::ListVideos($this->cat_id,1,$this);
	}




	public static function AdminListvideos()
	{
		global $db,$list_per_page;
		$per_page=100;
		if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
		$_GET['admin_page']=1;
		$admin_page=$_GET['admin_page'];
		$sql = 'SELECT  video.id as id , title, video_file ,video_category.name AS cat_name  FROM `video` LEFT JOIN video_category ON(video_category.id=video.cat_id) ORDER BY cat_id  LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
		
		$result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
		$no=$db->sql_numrows($result);

		$page_no=PageCount(GetUnlimitedCount('SELECT * FROM video LIMIT 0,10'),$per_page);
		$List= '<p class="admin_title">'._lang('list_video').':</p>' ;
		$List.= '<table class="adminlist" width="600"><tr class="header"><td width="10%">ID</td><td>'._lang('title').'</td><td>File</td><td>Category</td><td>'._lang('delete').'</td></tr> ';
		while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
		{

			if($i%2.0>0) $class="odd";
			else $class="even";
			$i++;

			$List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td><td width="60%">'.
			"<a href=\"?id=$row[id]&op=Edit\">$row[title]</a></td>".
			"<td><a href=\"?id=$row[id]&op=Edit\">$row[video_file]</a></td>".
			"<td><a href=\"?id=$row[id]&op=Edit\">$row[cat_name]</a></td>".
			"<td ><a href=\"javascript:if (confirm('"._lang('sure_delete_video')."')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
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


	public static function GetVideos($cat_id,$page=1,$per_page=5,&$pages_count)
	{
		global $db;
		$total_videos_count=0;
		$videos = $db->get_array('video',false,'active=true AND cat_id = '.$cat_id,'display_order',$page,$per_page,$total_videos_count);
		$pages_count=PageCount($total_videos_count,$per_page);

		return $videos ;
	}


	public static  function ListVideos($cat_id,$page=1,$video=false)
	{
		global $site;
		$pages_count=1;



		$videos = self::GetVideos($cat_id,$page,5,$pages_count);

		if($video===false)
		{
			$video= new video();
			$video->FromRow($videos[0]);
		}




		include('templates/tv.php');

	}


	public static function GetHomeVideo()

	{
		global $db;
		$video = $db->get_array('video',false,'active=true AND featured = true','RAND()',1,1);
		//if(!$video) die($db->sql_error_msg());

		return $video[0];
	}






}

?>