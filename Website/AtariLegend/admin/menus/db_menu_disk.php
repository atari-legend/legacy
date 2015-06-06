<?php
/***************************************************************************
*                                db_menu_disk.php
*                            -----------------------
*   begin                : june 06, 2015
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*
***************************************************************************/

// We are using the action var to separate all the queries.

include("../includes/common.php"); 




//****************************************************************************************
// Add new menu set
//**************************************************************************************** 

if($action=="menu_set_new")
{
if(isset($menu_sets_name)) 
{
	$sql = $mysqli->query("INSERT INTO menu_set (menu_sets_name) VALUES ('$menu_sets_name')");  
	mysqli_free_result($sql); 
}

header("Location: ../menus/menus_list.php");

}
//****************************************************************************************
// Edit menu_set name
//**************************************************************************************** 

if($action=="menu_set_name_update")
{
if(isset($menu_sets_id) and $menu_sets_name!=="") 
{
	$sql = $mysqli->query("UPDATE menu_set SET menu_sets_name='$menu_sets_name' 
					    WHERE menu_sets_id='$menu_sets_id'");  
	mysqli_free_result($sql); 
}
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}


//****************************************************************************************
// Connect crew to menu set
//**************************************************************************************** 

if($action=="menu_set_crew_set")
{
if(isset($crew_id) and isset($menu_sets_id)) 
{
	$sql = $mysqli->query("INSERT INTO crew_menu_prod (crew_id,menu_sets_id) VALUES ('$crew_id','$menu_sets_id')");  
	mysqli_free_result($sql); 
}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Quick add new crew
//**************************************************************************************** 

if($action=="menu_set_crew_add")
{
if(isset($new_crew_name) and isset($menu_sets_id)) 
{
	$sql = $mysqli->query("INSERT INTO crew (crew_name) VALUES ('$new_crew_name')");  
	mysqli_free_result($sql); 
}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}
//****************************************************************************************
// This is delete crew from menu series
//**************************************************************************************** 
if($action=="delete_crew_from_menu_set")
{
if(isset($crew_id) and isset($menu_sets_id)) 
{
		$mysqli->query("DELETE FROM crew_menu_prod WHERE crew_id='$crew_id' AND menu_sets_id='$menu_sets_id'"); 
}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}



//****************************************************************************************
// delete serie
//**************************************************************************************** 

if($action=="delete_gameseries")
{
if(isset($game_series_id)) 
{
	$mysqli->query("DELETE FROM game_series WHERE game_series_id='$game_series_id'"); 
	$mysqli->query("DELETE FROM game_series_cross WHERE game_series_id='$game_series_id'"); 
	mysqli_free_result(); 
}

header("Location: ../games/games_series_main.php");

}

//****************************************************************************************
// add_to_series
//**************************************************************************************** 

if($action=="add_to_series")
{
if(isset($game_id)) 
{
	foreach($game_id as $game) 
	{
		$mysqli->query("INSERT INTO game_series_cross (game_id,game_series_id) VALUES ('$game','$game_series_id')"); 
	}
	mysqli_free_result(); 
}
header("Location: ../games/games_series_editor.php?game_series_id=$game_series_id&series_page=$series_page");

}
