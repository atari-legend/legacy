<?php
/***************************************************************************
*                                demos_comment_edit.php
*                            -----------------------------
*   begin                : Sunday, november 13, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: demos_comment_edit.php,v 0.10 2005/11/13 Silver Surfer
*
***************************************************************************/
/*
***********************************************************************************
This will compile the demos comment edit page
***********************************************************************************
*/

include("../includes/common.php"); 


	$sql_build = "SELECT *	FROM demo_user_comments
							LEFT JOIN comments ON ( demo_user_comments.comments_id = comments.comments_id )
							LEFT JOIN users ON ( comments.user_id = users.user_id )
							LEFT JOIN demo ON ( demo_user_comments.demo_id = demo.demo_id ) 
							WHERE demo_user_comments_id = '$demo_user_comments_id'";

$sql_comment = $mysqli->query($sql_build) or die("couldn't build query");
$query_comment = $sql_comment->fetch_array(MYSQLI_BOTH) or die("couldn't build query");

$date = convert_timestamp($query_comment['timestamp']);
	
		$smarty->assign('comments',
	    array('comment' => $query_comment['comment'],
			  'date' => $date,
			  'demo' => $query_comment['demo_name'],
			  'demo_id' => $query_comment['demo_id'],
			  'view' => $view,
			  'user_name' => $query_comment['userid'],
			  'users_id' => $query_comment['user_id'],
			  'demo_user_comments_id' => $demo_user_comments_id,
			  'c_counter' => $c_counter,
			  'comment_id' => $query_comment['comments_id'],
			  'v_counter' => $v_counter));

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/demos_comment_edit.html');
?>
