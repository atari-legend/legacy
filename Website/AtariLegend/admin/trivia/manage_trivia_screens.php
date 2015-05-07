<?
/***************************************************************************
*                                manage_trivia_screens.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: manage_trivia_screens.php.php,v 1.10 2005/08/12 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Manage our trivia screens!
***********************************************************************************
*/

include("../includes/common.php");
include("../includes/config.php");

		$sql_trivia_screen =  mysql_query("SELECT * FROM trivia_screens") or die ("Database error - selecting screenshot");
		
		while (list($trivia_screens_id,$imgext,$skin_id) = mysql_fetch_row($sql_trivia_screen))
		
		{
					$imginfo = getimagesize("$trivia_screenshot_path$trivia_screens_id.$imgext");
					$width = $imginfo[0]+20;
					$height = $imginfo[1]+25;
		
		
					$smarty->append('trivia',
	    			array('trivia_screens_id' => $trivia_screens_id,
						  'imgext' => $imgext,
						  'width' => $width,
						  'height' => $height));
		} 
		
 
$smarty->assign('manage_trivia_screens_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>