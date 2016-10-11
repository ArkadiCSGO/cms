<?php
session_start();

	header("Content-type: image/png");
	
	$img = imagecreate (50,15) or die ("Problème de création GD");
	$background_color = imagecolorallocate ($img, 221, 221, 221);
	$ecriture_color = imagecolorallocate($img, 0, 0, 0);
	imagestring ($img, 20, 4, 0, $_SESSION['captcha'] , $ecriture_color);
	imagepng($img);

?>
