<?php
/********************************************************************************
 *                                games_screenshots_add.php
 *                            ---------------------------------
 *   begin                : Tuesday, november 9, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *	 actual update        : Creation of file
 *
 *   Id: games_screenshots_add.php,v 0.10 2005/11/09 23:02 ST Gravedigger
 *
 *********************************************************************************/

//****************************************************************************************
// This is the image selection/upload screen for the games
//**************************************************************************************** 

include("../includes/common.php");

//Get the screenshots for this game, if they exist
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_game
			   		LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
					WHERE screenshot_game.game_id = '$game_id' ORDER BY screenshot_game.screenshot_id")
				   		or die ("Database error - selecting screenshots");

$count = 1;
$v_screenshots =1;
while ( $screenshots=$sql_screenshots->fetch_array(MYSQLI_BOTH)) 
{

	//Ready screenshots path and filename
	$screenshot_image  = $game_screenshot_path;
	$screenshot_image .= $screenshots['screenshot_id'];
	$screenshot_image .= '.';
	$screenshot_image .= $screenshots['imgext'];
				
	$smarty->append('screenshots',
	    	 array('count' => $count,
				   'path' => $game_screenshot_path,
				   'screenshot_image' => $screenshot_image,
				   'id' => $screenshots['screenshot_id']));

	$count++;
	$v_screenshots++;
}

$smarty->assign("screenshots_nr",$v_screenshots);

//Get the game data
$sql_game = $mysqli->query("SELECT * FROM game WHERE game_id = '$game_id'")
			   	   or die ("Database error - selecting game");

while ( $game=$sql_game->fetch_array(MYSQLI_BOTH)) 
{
	$smarty->assign("game_id",$game['game_id']);
	$smarty->assign("game_name",$game['game_name']);
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('games_screenshot_add_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.html');

//close the connection
mysqli_close($mysqli);
?>
