<?php
/***************************************************************************
*                                db_games_series.php
*                            -----------------------
*   begin                : Saturday, Sept 24, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*						  
*							
*
*   Id: db_games_series.php,v 1.10 2005/09/24 Silver Surfer
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../includes/common.php");
include("../../includes/admin.php");

//****************************************************************************************
// This is delete from series place
//**************************************************************************************** 
if($action=="delete_from_series")
{
if(isset($game_series_cross_id)) 
{

	foreach($game_series_cross_id as $game_series_cross_id_sql) 
	{
		$mysqli->query("DELETE FROM game_series_cross WHERE game_series_cross_id='$game_series_cross_id_sql'"); 
	}

	mysqli_free_result(); 
}

header("Location: ../games/games_series_editor.php?series_page=$series_page&game_series_id=$game_series_id");

}

//****************************************************************************************
// Add new series
//**************************************************************************************** 

if($action=="addnew_series")
{
if(isset($new_series)) 
{
	$sql = $mysqli->query("INSERT INTO game_series (game_series_name) VALUES ('$new_series')");  
	mysqli_free_result(); 
}

header("Location: ../games/games_series_main.php");

}

//****************************************************************************************
// Edit series
//**************************************************************************************** 

if($action=="edit_series")
{
if(isset($game_series_name)) 
{
	$sql = $mysqli->query("UPDATE game_series SET game_series_name='$game_series_name' 
					    WHERE game_series_id='$game_series_id'");  
	mysqli_free_result(); 
}

header("Location: ../games/games_series_editor.php?series_page=series_editor&game_series_id=$game_series_id");

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
