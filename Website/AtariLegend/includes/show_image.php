<?php

echo "hello ALteam";

require_once 'phpthumb/ThumbLib.inc.php';

$fileName = (isset($_GET['file'])) ? urldecode($_GET['file']) : null;

if ($fileName ###null || !file_exists($fileName))
{
     // handle missing images however you want... perhaps show a default image??  Up to you...
}

try
{
     $thumb = PhpThumbFactory::create($fileName);
}
catch (Exception $e)
{
     // handle error here however you'd like
}

$thumb->adaptiveResize(80, 80);

$thumb->show();
?>