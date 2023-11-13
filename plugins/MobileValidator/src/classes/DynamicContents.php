<? 

class DynamicContents
{
	public static $Errors= array();

	public static function ListPages()
	{
		global $dynamic_pages,$predir;
		$i=0;
		foreach ($dynamic_pages as $page_id=>$page)
		{
			
			$ArrMn1[]=$page[0];
			$ArrMn2[]="editor.php?page_id=$page_id&op=Edit";
			$i++;
		}
		Menu($ArrMn1,$ArrMn2);
	}

	public static function EditPage($page_id)
	{
		global $dynamic_pages,$predir,$script_url;

		$myFile = $predir.$dynamic_pages[$page_id][1];
		$fh = fopen($myFile, 'r');
		if(!$fh)
		{
			DynamicContents::$Errors[]="$filename";
			return false;
		}
		else
		{
		?>
		<form action="editor.php" method="post">
		<?

		$theData = fread($fh, filesize($myFile));
		fclose($fh);
		$sBasePath = $predir."fck_editor/" ;
		
		
		
		$oFCKeditor = new FCKeditor('FCKeditor1') ;
		$oFCKeditor->Config['BaseHref']=$script_url.'/';
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Height="500";
		$oFCKeditor->Value		= $theData ;
		$oFCKeditor->Create() ;


		?>
		<input type="hidden" name="op"	value="Save" />
		<input type="hidden" name="page_id"	value="<?=$page_id?>"	/>
		
		<input type="submit" value="Update File" />
		</form>
		
		<?		
		return true;
		}
	}

	public Static function SavePage($page_id)
	{
		global $dynamic_pages,$predir;


		$filename=$predir.$dynamic_pages[$page_id][1];
		if (is_writable($filename))
		{
			if (!$handle = fopen($filename, 'w'))
			{
				DynamicContents::$Errors[]="Cannot open file ($filename)";
				return false;
			}
			if (fwrite($handle, stripslashes($_POST['FCKeditor1'] )) === FALSE)
			{
				DynamicContents::$Errors[]="Cannot write to file ($filename)";
				return false;				
			}
			
			return true;
			fclose($handle);

		}
		else
		{
			DynamicContents::$Errors[]="The file $filename is not writable";
			return false;	

		}
	}


}



?>
