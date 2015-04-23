<?php
extract($_REQUEST);

require_once('../includes/phpthumb/ThumbLib.inc.php');

$thumb = PhpThumbFactory::create($file);

If ( $mode == 'adapt' )
{	
	$thumb->adaptiveResize($w, $h);
}

$thumb->show();
?>