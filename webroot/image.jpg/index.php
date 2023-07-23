<?php
// session_name('CAKEPHP');
// session_start();


// session_id('ros2ehmub25o3jsn56gcnh1cpl');
session_name('PHPSESSID');

session_start();
function generateCode($characters)
{
	/* list all possible characters, similar looking characters and vowels have been removed */
	$possible = '2345789ABCDEFGHKMNPQRSTUVWXZY';
	$code = '';
	$i = 0;
	while ($i < $characters) {
		$code .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
		$i++;
	}
	return $code;
}

function CaptchaSecurityImages($width = '120', $height = '30', $characters = '6')
{
	$font = dirname(__FILE__) . '/Helvetica_Greek.ttf';
	$code = generateCode($characters);

	$rnd = isset($_GET['rnd']) ? $_GET['rnd'] : $_GET['code'];
	$time_rnd = isset($_SESSION['time_rnd']) ? $_SESSION['time_rnd'] : 0;
	if (time() - $time_rnd < 60)
		$code = isset($_SESSION['last_security_code']) ? $_SESSION['last_security_code'] : '';
	else
		$_SESSION['time_rnd'] = time();

	//file_put_contents('log.txt',$code.' - '.date('Y-m-d').' - '.$rnd.' - '.$_SESSION['sec_rnd'].' - '.time().' - '.$_SESSION['time_rnd'].' - '.$_SERVER['REMOTE_ADDR']."\n", FILE_APPEND);

	/* font size will be 75% of the image height */
	$font_size = 16;
	$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
	/* set the colours */
	$background_color = imagecolorallocate($image, 255, 255, 255);
	$text_color = imagecolorallocate($image, 50, 104, 154);
	//$line_color = imagecolorallocate($image, 20, 40, 100);
	//$noise_color = imagecolorallocate($image, 100, 180, 255);
	$noise_color = null;
	/* generate random dots in background */
	for ($i = 0; $i < (0.3 * $width * $height) / 3; $i++) {
		imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $noise_color);
	}
	//generate random lines in background 
	// for ($i = 0; $i < (0.3 * $width * $height) / 150; $i++) {
	// 	imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $line_color);
	// }
	/* create textbox and add text */
	imagefill($image,0,0,0x7fff0000);
	$angel = rand(-8, 8);
	$textbox = imagettfbbox($font_size, $angel, $font, $code) or die('Error in imagettfbbox function');
	$x = ($width - $textbox[4]) / 2;
	$y = ($height - $textbox[5]) / 2;
	imagettftext($image, $font_size, $angel, $x, $y, $text_color, $font, $code) or die('Error in imagettftext function');
	/* output captcha image to browser */
	header('Content-Type: image/jpeg');
	imagejpeg($image);
	imagedestroy($image);
	$_SESSION['security_code'] = $code;
	$_SESSION['last_security_code'] = $code;
	$_SESSION['sec_rnd'] = $rnd;



	$_SESSION['security_code'] = $code;
}

CaptchaSecurityImages();
