<?
/***************************************************************************
*                                games_comment_edit.php
*                            -----------------------
*   begin                : Sunday, sept 18, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: games_comment_edit,v 0.10 2005/09/18 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
This will compile the games comment edit page
***********************************************************************************
*/

include("../includes/common.php"); 


	$sql_build = "SELECT *	FROM game_user_comments
							LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
							LEFT JOIN users ON ( comments.user_id = users.user_id )
							LEFT JOIN game ON ( game_user_comments.game_id = game.game_id ) 
							WHERE game_user_comments_id = '$game_user_comments_id'";

$sql_comment = mysql_query($sql_build) or die("couldn't build query");
$query_comment = mysql_fetch_array($sql_comment) or die("couldn't build query");

$date = convert_timestamp($query_comment['timestamp']);
	
		$smarty->assign('comments',
	    array('comment' => $query_comment['comment'],
			  'date' => $date,
			  'game' => $query_comment['game_name'],
			  'game_id' => $query_comment['game_id'],
			  'view' => $view,
			  'user_name' => $query_comment['userid'],
			  'users_id' => $query_comment['user_id'],
			  'game_user_comments_id' => $game_user_comments_id,
			  'c_counter' => $c_counter,
			  'comment_id' => $query_comment['comment_id'],
			  'v_counter' => $v_counter));

$smarty->assign('games_comment_edit_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>
