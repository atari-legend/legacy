<?php
extract($_REQUEST);

require_once('../includes/phpthumb/ThumbLib.inc.php');

$thumb = PhpThumbFactory::create($file);

$thumb->cropFromCenter($w, $h);

$thumb->show();
?>