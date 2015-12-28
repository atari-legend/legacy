<?php
/***************************************************************************
*                                db_games_comment.php
*                            -----------------------
*   begin                : Sunday, Sept 18, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*						  
*							
*
*   Id: db_games_comment.php,v 1.10 2005/09/19 Silver Surfer
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../includes/common.php");
include("../../includes/admin.php");

if($action=="edit_games_comment")
{
	//****************************************************************************************
	// This is the game comment edit place
	//**************************************************************************************** 

	if (isset($comment_text) and isset($comment_id))
	{
		$commentquery = $mysqli->query("UPDATE comments SET comment='$comment_text' WHERE comments_id='$comment_id'");
		$_SESSION['edit_message'] = "Comment edited";
	}

	if ($view == "users_comments")
	{
		header("Location: ../games/games_comment.php?v_counter=$v_counter&c_counter=$c_counter&users_id=$users_id&view=$view");
	}
	else
	{
		header("Location: ../games/games_comment.php?v_counter=$v_counter");
	}
}


// Delete
if($action=="delete_comment")
{
	//****************************************************************************************
	// This is the game comment edit place
	//**************************************************************************************** 

	if (isset($comment_id))
	{
		$sql = $mysqli->query("DELETE FROM game_user_comments WHERE comment_id = '$comment_id'") or die("couldn't delete game_comment quote");
		$sql = $mysqli->query("DELETE FROM comments WHERE comments_id = '$comment_id'") or die("couldn't delete comment quote");
		$_SESSION['edit_message'] = "Comment deleted";
	}

	if ($view == "users_comments")
	{
	header("Location: ../games/games_comment.php?v_counter=$v_counter&c_counter=$c_counter&users_id=$users_id&view=$view");
	}
	else
	{
	header("Location: ../games/games_comment.php?v_counter=$v_counter");
	}
}
