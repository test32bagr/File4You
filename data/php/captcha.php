<?php
	session_start();
	$_SESSION['code'] = substr(sha1(md5(rand(0,999))), 15, 5);
	$width = (int)150;
	$height = (int)25;
	
	$img = ImageCreate($width, $height);

	$black = ImageColorAllocate($img, 0, 0, 0); 
	$gray = ImageColorAllocate($img, 204, 204, 204); 
	
	ImageFill($img, 0, 0, $black);
	ImageString($img, 5, $width / 2.9, 4, $_SESSION["code"], ImageColorAllocate($img, 255, 255, 255));
	ImageRectangle($img,0,0,$width-1,$height-1, $gray);
	imageline($img, 35, 0, $width - 100, $height, $gray);
	imageline($img, $width - 20, 0, $width - 70, $height, $gray);
	
	header("Content-Type: img/jpeg"); 
	ImageJpeg($img); 
	ImageDestroy($img); 
?>