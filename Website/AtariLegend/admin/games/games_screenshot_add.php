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

//If we are uploading new screenshots
if (isset($action) and $action == 'add_screens' )
{

//Here we'll be looping on each of the inputs on the page that are filled in with an image!
$image = $_FILES['image'];

foreach($image['tmp_name'] as $key=>$tmp_name)
{
	if ($tmp_name!=='none')
	
	{
	// Check what extention the file has and if it is allowed.
	
		$ext="";
		$type_image = $image['type'][$key];
		
		// set extension
		if ( $type_image=='image/png')
			{
				$ext='png';
			}
			
		if ( $type_image=='image/x-png')
			{
				$ext='png';
			}
		
		elseif ( $type_image=='image/gif')
			{
				$ext='gif';
			} 
		elseif ( $type_image=='image/pjpeg')
			{
				$ext='jpg';
			} 
		
		 if ($ext!=="")
		 	{
			
		// First we insert the directory path of where the file will be stored... this also creates an autoinc number for us.
		
		$sdbquery = mysql_query("INSERT INTO screenshot_main (screenshot_id,imgext) VALUES ('','$ext')")
					or die ("Database error - inserting screenshots");

		//select the newly entered screenshot_id from the main table
		$SCREENSHOT = mysql_query("SELECT screenshot_id FROM screenshot_main
	   					   		   ORDER BY screenshot_id desc")
					  or die ("Database error - selecting screenshots");
		
		$screenshotrow = mysql_fetch_row($SCREENSHOT);
		$screenshot_id = $screenshotrow[0];
		
		$sdbquery = mysql_query("INSERT INTO screenshot_game (game_id, screenshot_id) VALUES ($game_id, $screenshot_id)")
					or die ("Database error - inserting screenshots2");
		
		// Rename the uploaded file to its autoincrement number and move it to its proper place.
		$file_data = rename($image['tmp_name'][$key], "$game_screenshot_path$screenshotrow[0].$ext");
		
		chmod("$game_screenshot_path$screenshotrow[0].$ext", 0777);
		
		}
	}
}
}

//If we pressed the delete screenshot link
if ( isset($action) and $action == 'delete_screen' )
{
	$sql_gameshot = mysql_query("SELECT * FROM screenshot_game
	   					   			  WHERE game_id = $game_id 
									  AND screenshot_id = $screenshot_id")
	     		  or die ("Database error - selecting screenshots game");
						
	$gameshot = mysql_fetch_row($sql_gameshot);
	$gameshotid = $gameshot[0];
	
	//get the extension 
	$SCREENSHOT = mysql_query("SELECT * FROM screenshot_main
	   					  	  WHERE screenshot_id = '$screenshot_id'")
				  or die ("Database error - selecting screenshots");
		
	$screenshotrow = mysql_fetch_array($SCREENSHOT);
	$screenshot_ext = $screenshotrow[imgext];

	$sql = mysql_query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
	$sql = mysql_query("DELETE FROM screenshot_game WHERE screenshot_id = '$screenshot_id' ");

	$new_path = $game_screenshot_path;;
	$new_path .= $screenshot_id;
	$new_path .= ".";
	$new_path .= $screenshot_ext;

	unlink ("$new_path");
	
	$message = 'Screenshot deleted succesfully';
	$smarty->assign("message",$message);
}

//Get the screenshots for this game, if they exist
$sql_screenshots = mysql_query("SELECT * FROM screenshot_game
			   		  			LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
								WHERE screenshot_game.game_id = '$game_id' ORDER BY screenshot_game.screenshot_id")
				   or die ("Database error - selecting screenshots");

$count = 1;
$v_screenshots =1;
while ( $screenshots=mysql_fetch_array ($sql_screenshots)) 
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
$sql_game = mysql_query("SELECT * FROM game WHERE game_id = '$game_id'")
			   	   or die ("Database error - selecting game");

while ( $game=mysql_fetch_array ($sql_game)) 
{
	$smarty->assign("game_id",$game['game_id']);
	$smarty->assign("game_name",$game['game_name']);
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('games_screenshot_add_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
