<?php
/***************************************************************************
*                                showscreens.php
*                            --------------------------
*   begin                : Sunday, Aug 24, 2003
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : gallery addon
*
*   Id: showscreens.php,v 0.30 2003/10/21 16:44 Silver
*
***************************************************************************/

//*************************************************************************
// Show the screenshot
//*************************************************************************

//D.Wetherilt
//20140915
// No longer valid
//import_request_variables('GPC'); 
// will replace with this for now:
extract($_REQUEST);

if ( isset($screenshot_id) )
{
	$filename="../data/images/game_screenshots/$screenshot_id.$ext";	
	
	$fp=fopen($filename, "rb");

	header("Content-Type: image/$ext");
	header("Content-Length: ".filesize($filename));
	
	fpassthru($fp);
	exit;
}

if ( isset($boxscan_id) )
{
	$filename="../data/images/game_boxscans/$boxscan_id.$ext";

	$fp=fopen($filename, "rb");

	header("Content-Type: image/jpeg");
	header("Content-Length: ".filesize($filename));
	
	fpassthru($fp);
	exit;
}

if ( isset($publisher_id) )
{
	$filename="../data/images/company_logos/$publisher_id.$ext";

	$fp=fopen($filename, "rb");

	header("Content-Type: image/$ext");
	header("Content-Length: ".filesize($filename));
	
	fpassthru($fp);
	exit;
}

if ( isset($trivia_id) )
{
	$filename="../data/images/trivia_screens/$trivia_id.$ext";
	
	$fp=fopen($filename, "rb");

	header("Content-Type: image/$ext");
	header("Content-Length: ".filesize($filename));
	
	fpassthru($fp);
	exit;
}

if ( $interview_screenshot_id != "" )
{
	$SCREEN2 = mysql_query("SELECT * FROM screenshot_main WHERE screenshot_id='$interview_screenshot_id'") 
		   or die ("Database error - couldn't get screenshots"); 
	$screenrow2=mysql_fetch_array($SCREEN2);

	$filename="$interview_screenshot_path$screenrow2[screenshot_id].$screenrow2[imgext]";
	
	$fp=fopen($filename, "rb");

	header("Content-Type: image/$screenrow2[imgext]");
	header("Content-Length: ".filesize($filename));
	
	fpassthru($fp);
	exit;
}

if ( $website_id != "" )
{
	$SCREEN2 = mysql_query("SELECT website_imgext FROM website WHERE website_id='$website_id'") 
		   or die ("Database error - couldn't get website images"); 
	$screenrow2=mysql_fetch_array($SCREEN2);

	$filename="$website_image_path$website_id.$screenrow2[website_imgext]";

	header("Content-Type: image/$screenrow2[imgext]");
	header("Content-Length: ".filesize($filename));
	
	$fp=fopen($filename, "rb");

	fpassthru($fp);
	exit;
}

if ( $ind_id != "" )
{
	$SCREEN2 = mysql_query("SELECT ind_imgext FROM individual_text WHERE ind_id='$ind_id'") 
		   or die ("Database error - couldn't get individual image"); 
	$screenrow2=mysql_fetch_array($SCREEN2);

	$filename="$individual_screenshot_path$ind_id.$screenrow2[ind_imgext]";

	header("Content-Type: image/$screenrow2[ind_imgext]");
	header("Content-Length: ".filesize($filename));
	
	$fp=fopen($filename, "rb");

	fpassthru($fp);
	exit;
}

if ( $news_image_id != "" )
{
	$SCREEN2 = mysql_query("SELECT news_image_ext FROM news_image WHERE news_image_id='$news_image_id'") 
		   or die ("Database error - couldn't get website images"); 
	$screenrow2=mysql_fetch_array($SCREEN2);

	$filename="$news_images_path$news_image_id.$screenrow2[news_image_ext]";

	header("Content-Type: image/$screenrow2[news_image_ext]");
	header("Content-Length: ".filesize($filename));
	
	$fp=fopen($filename, "rb");

	fpassthru($fp);
	exit;
}

if ( $game_gallery_id != "" )
{
	$SCREEN2 = mysql_query("SELECT image_ext FROM game_gallery WHERE game_gallery_id='$game_gallery_id'") 
		   or die ("Database error - couldn't get website images"); 
	$screenrow2=mysql_fetch_array($SCREEN2);

	$filename="$game_gallery_path$game_gallery_id.$screenrow2[image_ext]";

	header("Content-Type: image/$screenrow2[image_ext]");
	header("Content-Length: ".filesize($filename));
	
	$fp=fopen($filename, "rb");

	fpassthru($fp);
	exit;
}
?>
