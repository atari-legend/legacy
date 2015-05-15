<?php
/***************************************************************************
*                                db_games_submissions.php
*                            -----------------------
*   begin                : Sunday, Sept 18, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*						  
*							
*
*   Id: db_games_submissions.php,v 1.10 2005/09/19 Silver Surfer
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../includes/common.php"); 

if($action=="update_submission")

{

//****************************************************************************************
// This is where the submissions get "sent" to "done"
//**************************************************************************************** 

if (isset($submit_id))
{
		$commentquery = mysql_query("UPDATE game_submitinfo SET game_done = '1' WHERE game_submitinfo_id='$submit_id'");
		
		$sql_user = mysql_query("SELECT user_id FROM game_submitinfo WHERE game_submitinfo_id='$submit_id'");
		
		list($user_id) = mysql_fetch_array($sql_user);
		$karma_action = "game_submission";
		
		UserKarma($user_id,$karma_action);
}

header("Location: ../games/submission_games.php?v_counter=$v_counter");
}



// Delete
if($action=="delete_submission")

{

//****************************************************************************************
// This is the game comment edit place
//**************************************************************************************** 

	if (isset($submit_id))
	{
		$sql = mysql_query("DELETE FROM game_submitinfo WHERE game_submitinfo_id = '$submit_id'") or die("couldn't delete game_submissions quote");
	}


if ($list == "done")
{
header("Location: ../games/submission_games.php?v_counter=$v_counter&list=$list");
}
else
{
header("Location: ../games/submission_games.php?v_counter=$v_counter");
}
}

// Move
if($action=="move_submission_tocomment")

{

//****************************************************************************************
// This is the move to comments place
//**************************************************************************************** 

	if (isset($submit_id))
	{
		
		$query_submit = $mysqli->query("SELECT * FROM game_submitinfo WHERE game_submitinfo_id = ".$submit_id."") or die("something is wrong with mysqli");
		$sql_submit = $query_submit->fetch_array(MYSQLI_BOTH) or die("something is wrong with mysqli2");
		
		$submit_text = $sql_submit['submit_text'];
		$submit_text = mysql_real_escape_string($submit_text);
		$sub_timestamp = $sql_submit['timestamp']; 
		$sub_user_id = $sql_submit['user_id'];
		$sub_game_id = $sql_submit['game_id'];


		$sql = mysql_query("INSERT INTO comments (comment,timestamp,user_id) VALUES ('$submit_text','$sub_timestamp','$sub_user_id')") or die("something is wrong with INSERT mysql3");
		$sql = mysql_query("INSERT INTO game_user_comments (game_id,comment_id) VALUES ('$sub_game_id',LAST_INSERT_ID())") or die("something is wrong with INSERT mysql4");

		$sql = mysql_query("DELETE FROM game_submitinfo WHERE game_submitinfo_id = ".$submit_id."") or die("couldn't delete game_submissions quote");
	}


if ($list == "done")
{
header("Location: ../games/submission_games.php?v_counter=$v_counter&list=$list");
}
else
{
header("Location: ../games/submission_games.php?v_counter=$v_counter");
}
}
?>
