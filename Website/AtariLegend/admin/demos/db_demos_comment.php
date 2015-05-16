<?php
/***************************************************************************
*                                db_demos_comment.php
*                            -----------------------
*   begin                : Sunday, november 13, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: db_demos_comment.php,v 0.10 2005/11/13 Silver Surfer
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../includes/common.php"); 

echo $action;

if($action=="edit_demos_comment")

{

//****************************************************************************************
// This is the game comment edit place
//**************************************************************************************** 

if (isset($comment_text) and isset($comment_id))
{
	$commentquery = mysql_query("UPDATE comments SET comment='$comment_text' WHERE comments_id='$comment_id'") or die ('no working');
}

if ($view == "users_comments")
{
header("Location: ../demos/demos_comment.php?v_counter=$v_counter&c_counter=$c_counter&users_id=$users_id&view=$view");
}
else
{
header("Location: ../demos/demos_comment.php?v_counter=$v_counter");
}
}


// Delete
if($action=="delete_comment")

{

//****************************************************************************************
// This is the demo comment edit place
//**************************************************************************************** 

	if (isset($comment_id))
	{
		$sql = mysql_query("DELETE FROM demo_user_comments WHERE comments_id = '$comment_id'") or die("couldn't delete demo_comment quote");
		$sql = mysql_query("DELETE FROM comments WHERE comments_id = '$comment_id'") or die("couldn't delete comment quote");
	}


if ($view == "users_comments")
{
header("Location: ../demos/demos_comment.php?v_counter=$v_counter&c_counter=$c_counter&users_id=$users_id&view=$view");
}
else
{
header("Location: ../demos/demos_comment.php?v_counter=$v_counter");
}
}
