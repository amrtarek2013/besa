<?
function SideImage($word,$pos='',$cat='',$width='520',$height='65') 
{
		//Determine font to write with
		$font ="HelveticaNeueLTPro-Lt.otf";
		
		/*Determine font size */
		$font_size = 40;
		$image = @imagecreate($width, $height) or die('Cannot initialize new Side Word Image');
		/* set the colours */
		//echo IsAllowView($cat);
		if($pos =='gallery' && $cat=='ok' )
		{
			
			$background_color = imagecolorallocate($image, 30, 30, 30);
		}
		else 
		{
			$background_color = imagecolorallocate($image, 64, 49, 62);
		}
		$text_color = imagecolorallocate($image, 0, 255, 255);
		$line_color = imagecolorallocate($image, 0, 255, 255);
		$angel=0;
		$textbox = imagettfbbox($font_size, $angel, $font, $word) or die('Error in imagettfbbox function');
		$x = 0;
		$y = ($height - $textbox[5])/2;

		imagettftext($image, $font_size, $angel, $x, $y, $text_color, $font , $word) ;
		//imagettftext($image,$font_size,$angel,)
		//imagettfbbox($image,$angel,$font,$word) or die('Error in imagettftext function');
		/* output  image to browser */
		//imagesetthickness($image,100);
		header('Content-Type: image/jpeg');
		imagejpeg($image,'',100);
		
		//imagedestroy($image);
	}
//$newpage=ConvertIdToMenu($_GET['page_id']);
SideImage($_GET['page_id'],$_GET['pos'],$_GET['cat']);
/*function drawboldtext($image, $size, $angle, $x_cord, $y_cord, $r, $g, $b, $fontfile, $text)
{
$color = ImageColorAllocate($image, $r, $g, $b);
/*$_x = array(1, 0, 1, 0, -1, -1, 1, 0, -1);
   		$_y = array(0, -1, -1, 0, 0, -1, 1, 1, 1);
  		 for($n=0;$n<=8;$n++)
   			{
    		  Imagettftext($image, $font_size, $angle, $x+$_x[$n], $y+$_y[$n], $text_color, $font, $word);
  			}
}*/
?>