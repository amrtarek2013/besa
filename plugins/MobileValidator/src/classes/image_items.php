<?
// class to get items from array and edit/save to the same file of arrya
//
//	$var[key]        => is array of editable variable 
//	$type[key]       => is array of the vars type(image,textarea,file,text,hidden),default:text,
//	$width[key] =>   image width if the type is image
//	$height[key]      =>   image height if the type is image
//	$file_type[$key'] => file types if the type is file , default pdf
//  
//
//
//
/////////////////////////////////////////////////////////////////////////////////////////////

class items
{

	public static $SErrors;



	function EditItems($array_file)
	{
		global $predir,$images_upload_dir;

		include($predir.$array_file);
		?>    
		<form  class="extended" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
		<?
		
		foreach ($var as $key => $value)
		{
			echo "<label for='$key'>".ucfirst(str_replace("_"," ",$key))."</label>";
			if($type[$key]=='image'&&$width[$key]&&$height[$key])
			echo "<p class=\"hint\">{$width[$key]}px X {$height[$key]}px</p>";
			
			if($desc[$key])
			echo "<p class=\"hint\">{$desc[$key]}</p>";
			
			if(!isset($type[$key]))
			echo "<input type=\"text\" name=\"$key\"  id=\"$key\" value=\"".PreForm($value)."\">\n";
			if($type[$key]=='image'||$type[$key]=='pdf')
			{
			echo "<input type=\"file\" name=\"$key\"  id=\"$key\" > <span>".PreForm($value)."</span>\n&nbsp;&nbsp;&nbsp;";
			echo '<a target="_blank" class="download_file" href="../'.$images_upload_dir.'/'.$value.'">Download</a><br/><br/>';
			}
			else if($type[$key]=='textarea')
			echo "<textarea name=\"$key\"  id=\"$key\" >".PreForm($value)."</textarea>\n";



		}
	    ?>
	    <input type="hidden" name="array_file" value="<?=$array_file?>" />
	    <input type="hidden" name="op" value="SaveItem" />

		<?php
		$checked = '';
		$values = parse_ini_file(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'landing.ini');
		if (!empty($values['enable'])){
			$checked = 'checked="checked"';
		}
		?>
		<input type="checkbox" id="enableFrontImage" name="enable" value="1" <?php echo $checked; ?> /><label for="enableFrontImage">Enable front image</label>
		<input type="submit" name="submit" value="Save">
		</form>
	<?
	
	return true;
	}

	Function SaveItems()
	{
		global  $images_upload_dir,$predir;
		$array_file=$_POST['array_file'];
		
		
		include($predir.$array_file);

		
		$new_array="<?\n\n";
		foreach ($var as $key=>$value)
		{
			
			if($type[$key]=='image')
			{
				
				if($_FILES[$key]['name']) {
					//list($file,$error) = UploadImage($key,'../'.$images_upload_dir,'jpg,png,gif,jpeg',500000000,$key,(isset($width[$key])||isset($height[$key]))?1:0,isset($width[$key])?$width[$key]:10000,isset($height[$key])?$height[$key]:10000);
					list($file,$error) = Upload($key,'../'.$images_upload_dir,'jpg,png,gif,jpeg',$key=='image_1'?307200:500000000,$key);
					
					if($error)
					{
						self::$SErrors[]= "Cannot Upload For :$key ".$error."";
						return false;
					}
					else
					{
						
						$image=$file;
					}
				}
				else
				{
					
					$image=$value;
				}
				
				
				
				$new_array .= "\$var[\"$key\"] =  \"" . $image . "\";\n";
				$new_array .= "\$type[\"$key\"] =  \"image\";\n";
				if(isset($width[$key]))
				$new_array .= "\$width[\"$key\"] =  $width[$key];\n";
				if(isset($desc[$key]))
				$new_array .= "\$desc[\"$key\"] =  \"$desc[$key]\";\n";
				if(isset($height[$key]))
				$new_array .= "\$height[\"$key\"] =  $height[$key];\n\n";
			}
			else
			if($type[$key]=='file')
			{
				if($_FILES[$key]['name']) {
					list($file,$error) = Upload($key,'../'.$images_upload_dir,isset($file_type[$key])?$file_type[$key]:'pdf',500000000,$key);
					if($error)
					{
						$this->Errors[]= "Cannot Upload For :$key ".$error."";
						return false;
					}
					else
					$file_name=$file;
				}
				else
				{
					$file_name=$value;
				}
				
				$new_array .= "\$var[\"$key\"] =  \"" . $file_name . "\";\n";
				$new_array .= "\$type[\"$key\"] =  \"file\";\n";
				
				
				if(isset($$file_type[$key]))
				$new_array .= "\$file_type[\"$key\"] =  '$file_type[$key]';\n\n";
			}
			else
			$new_array .= "\$var[\"$key\"] =  \"" . trim(PreSql(PostForm($_POST[$key]))) . "\";\n\n";
		}



		$new_array.="\n\n?>";
		if (! ($fb = fopen($predir.$array_file, 'w')))
		{
			self::$SErrors[]="could not open $array_file for writing";
			return false;
		}
		if(! (fwrite($fb, $new_array)))
		{
			self::$SErrors[]="could not write on $array_file";
			return false;
		}

		$enable = 0;
		if (!empty($_POST['enable'])){
			$enable=1;
		}
		file_put_contents(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'landing.ini', "enable=$enable");
		return true;
	}


	public static function GetValue($array_file, $key)
	{
		global  $predir;
		include($predir.$array_file);
		return $var[$key];

	}


}



?>