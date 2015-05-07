<?
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

include("../includes/common.php"); 

if($action=="delete_from_series")

{

//****************************************************************************************
// This is delete from series place
//**************************************************************************************** 

if(isset($game_series_cross_id)) 
{

	foreach($game_series_cross_id as $game_series_cross_id_sql) 
	{
		mysql_query("DELETE FROM game_series_cross WHERE game_series_cross_id='$game_series_cross_id_sql'"); 
	}

	mysql_close(); 
}

header("Location: ../games/games_series_main.php?series_page=$series_page&game_series_id=$game_series_id");

}


if($action=="addnew_series")

{

//****************************************************************************************
// Add new series
//**************************************************************************************** 

if(isset($new_series)) 
{
	$sql = mysql_query("INSERT INTO game_series (game_series_name) VALUES ('$new_series')");  
	mysql_close(); 
}

header("Location: ../games/games_series_main.php");

}


if($action=="edit_series")

{

//****************************************************************************************
// Edit series
//**************************************************************************************** 

if(isset($game_series_name)) 
{
	$sql = mysql_query("UPDATE game_series SET game_series_name='$game_series_name' 
					    WHERE game_series_id='$game_series_id'");  
	mysql_close(); 
}

header("Location: ../games/games_series_main.php?series_page=series_editor&game_series_id=$game_series_id");

}

if($action=="delete_gameseries")

{

//****************************************************************************************
// delete serie
//**************************************************************************************** 

if(isset($game_series_id)) 
{

	mysql_query("DELETE FROM game_series WHERE game_series_id='$game_series_id'"); 
	mysql_query("DELETE FROM game_series_cross WHERE game_series_id='$game_series_id'"); 
	mysql_close(); 
}

header("Location: ../games/games_series_main.php");

}

if($action=="add_to_series")

{

//****************************************************************************************
// add_to_series
//**************************************************************************************** 

if(isset($game_id)) 
{

	foreach($game_id as $game) 
	{
		mysql_query("INSERT INTO game_series_cross (game_id,game_series_id) VALUES ('$game','$game_series_id')"); 
	}

	mysql_close(); 
}

header("Location: ../games/games_series_main.php?game_series_id=$game_series_id&series_page=$series_page");

}