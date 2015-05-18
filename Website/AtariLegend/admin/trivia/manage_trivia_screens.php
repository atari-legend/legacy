<?php
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

		$sql_trivia_screen = $mysqli->query("SELECT * FROM trivia_screens");

		while ($query_trivia_screen = $sql_trivia_screen->fetch_array(MYSQLI_BOTH))  	
		{
					$imginfo = getimagesize("$trivia_screenshot_path$query_trivia_screen[trivia_screens_id].$query_trivia_screen[imgext]");
					$width = $imginfo[0]+20;
					$height = $imginfo[1]+25;
		
		
					$smarty->append('trivia',
	    			array('trivia_screens_id' => $query_trivia_screen['trivia_screens_id'],
						  'imgext' => $query_trivia_screen['imgext'],
						  'width' => $width,
						  'height' => $height));
		} 
		
 
$smarty->assign('manage_trivia_screens_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.html');
?>
