<?php
/***************************************************************************
*                                db_games_box.php
*                            -----------------------
*   begin                : Sunday, Sept 18, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*						  
*							
*
*   Id: db_games_box.php,v 1.10 2005/11/19 Silver Surfer
*
***************************************************************************/

// This document contain all the code needed to operate the boxscans.


include("../includes/common.php");

$filename = $_FILES['image'];

$filename=$filename['tmp_name'][1];

// Debug
//echo "$filename";
//print_r($image);
//exit;

if(isset($action) and $action=="boxscan_upload")

{

//****************************************************************************************
// This is where the boxscans get their upload treatment
//****************************************************************************************

//Here we'll be looping on each of the inputs on the page that are filled in with an image!
for($i=1; $i <= 1; $i++)
{
	if($image[$i] != 'none')
	{
		$file_data = $image[$i];

		if ($mode == "back")
		{
		$sdbquery = $mysqli->query("INSERT INTO game_boxscan (game_id, game_boxscan_side,imgext) VALUES ('$game_id', '1','jpg')");
			 
			 //get the id of the inserted back cover 
			 $boxback = $mysqli->query("SELECT game_boxscan_id FROM game_boxscan
	   					   		     order by game_boxscan_id desc")
					    or die ("Database error - selecting back box scan");
		
			 $backbox = $boxback->fetch_row();
			 $backbox_id = $backbox[0];
			 
			 //insert the id of the front box
			 
			 $sdbquery = $mysqli->query("INSERT INTO game_box_couples (game_boxscan_id, game_boxscan_cross) VALUES ('$frontscan_id', '$backbox_id')");
			 // @Dal, notice I use $filename instead of $file_data
			 // Rename the uploaded file to its autoincrement number and move it to its proper place.
			 $file_data = rename("$filename", "$game_boxscan_path$backbox[0].jpg");
	
			chmod("$game_boxscan_path$backbox[0].jpg", 0777);
		}
		else
		{


			$sdbquery = $mysqli->query("INSERT INTO game_boxscan (game_id,game_boxscan_side,imgext) VALUES ('$game_id','0','jpg')") or die ("Whats wrong???");
		
			//get the id of the inserted front cover 
			$box = $mysqli->query("SELECT game_boxscan_id FROM game_boxscan
	   				   		    order by game_boxscan_id desc")
				   or die ("Database error - selecting front box scan");
			
			$boxCover = $box->fetch_row();
			$box_id = $boxCover[0];
			// @Dal, notice I use $filename instead of $file_data
			 // Rename the uploaded file to its autoincrement number and move it to its proper place.
			 $file_data = rename("$filename", "$game_boxscan_path$boxCover[0].jpg");
			 
			 chmod("$game_boxscan_path$boxCover[0].jpg", 0777);
	
		}
	}
}
mysqli_free_result();
header("Location: ../games/games_box.php?game_id=$game_id");
}

if(isset($action) and $action=="boxscan_delete")

{

//****************************************************************************************
// This is where the boxscans get deleted
//****************************************************************************************



$sql = $mysqli->query("DELETE FROM game_boxscan WHERE game_boxscan_id = '$game_boxscan_id'");

if ($mode == "back") 
{
	$sql = $mysqli->query("DELETE FROM game_box_couples WHERE game_boxscan_cross = '$game_boxscan_id'");
}
else
{
	$sql = $mysqli->query("DELETE FROM game_box_couples WHERE game_boxscan_id = '$game_boxscan_id'");
}

unlink ("$game_boxscan_path$game_boxscan_id.jpg");

mysqli_free_result(); 
header("Location: ../games/games_box.php?game_id=$game_id");
}
?>
