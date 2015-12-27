<?php
/*******************************************************************************
*                                karma_sync.php
*                            -----------------------
*   begin                : 2005-11-13
*   copyright            : (C) 2005 Atari Legend
*   email                : atarizone@atarizone.com
*
*   Id: karma_sync.php,v 0.10 2005/11/13 23:30 Silver
*   Id: karma_sync.php,v 0.20 2015/12/22 00:26 STG - Added right side
*
********************************************************************************

*********************************************************************************
*Exprimental Karma code
*********************************************************************************/

// Allowed $karma_action values:
//
// $karma_action = "game_downloads"
// $karma_action = "game_comment"
// $karma_action = "game_submission"
// $karma_action = "weblink"
// $karma_action = "news_update"
// $karma_action = "game_review"

/*
- 5pts / game downloads
+ 5pts / game comment
+ 10pts / game submission
+ 3pts / weblink
+ 15pts / news update
+ 50pts / game review
*/

ini_set('max_execution_time', 300); 

// Include common files
include("../../includes/common.php");
include("../../includes/admin.php");

// Set values
$value_gamedownload = -5;
$value_gamecomment = 5;
$value_gamesubmission = 10;
$value_weblink = 3;
$value_news = 15;
$value_gamereview = 50;

$sql_user = $mysqli->query("SELECT user_id,userid,karma FROM users");

 while (list ($user_id,$user_name,$karma_value) = $sql_user->fetch_array(MYSQLI_BOTH))
	{
	
	$nr_gamecomments = 0;
	$nr_gamereviews = 0;
	$nr_downloads = 0;
	$nr_gamesubmissions = 0;
	$nr_links = 0;
	$nr_news = 0;
	
	// gamecomments
	$sql_gamecomments = $mysqli->query("SELECT * FROM comments
					LEFT JOIN game_user_comments ON (comments.comments_id = game_user_comments.comment_id)
					LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
					WHERE comments.user_id = $user_id");
	
	$nr_gamecomments = $sql_gamecomments->num_rows;
	
	mysqli_free_result($sql_gamecomments);
	
	// reviews
	$sql_gamereview = $mysqli->query("SELECT * FROM review_main
					LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
					LEFT JOIN game ON ( review_game.game_id = game.game_id )
					WHERE review_main.member_id = $user_id");
	
	$nr_gamereviews = $sql_gamereview->num_rows;
	mysqli_free_result($sql_gamereview);
	
	// START - NUMBER OF DOWNLOADS BY USER
	$sql_downloads = $mysqli->query("SELECT COUNT(*) AS count FROM game_download_info WHERE user_id = $user_id");
	$gamecount = $sql_downloads->fetch_array(MYSQLI_BOTH);
	//$nr_downloads = $gamecount[count];
	$nr_downloads = $sql_downloads->num_rows;;
	mysqli_free_result($sql_downloads);
	
	// gamesubmissions
	$sql_submissions = $mysqli->query("SELECT * FROM game_submitinfo 
				    LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
					WHERE user_id = $user_id");
					
	$nr_gamesubmissions = $sql_submissions->num_rows;
	mysqli_free_result($sql_submissions);
	
	// Submitted links
	$sql_links = $mysqli->query("SELECT * FROM website WHERE website_user_sub = $user_id");
	
	$nr_links = $sql_links->num_rows;
	mysqli_free_result($sql_links);
	
	// START - NUMBER OF NEWS POSTS BY USER
	$sql_news = $mysqli->query("SELECT * FROM news WHERE user_id = $user_id");
	
	$nr_news = $sql_news->num_rows;
	mysqli_free_result($sql_news);
	
	$karma_value = 0;
	
	$karma_value = $karma_value + ($nr_gamecomments*$value_gamecomment);
	$karma_value = $karma_value + ($nr_gamereviews*$value_gamereview);
	$karma_value = $karma_value + ($nr_gamesubmissions*$value_gamesubmission);
	$karma_value = $karma_value + ($nr_links*$value_weblink);
	$karma_value = $karma_value + ($nr_news*$value_news);
	$karma_value = $karma_value + ($nr_downloads*$value_gamedownload);
	
	$update = $mysqli->query("UPDATE users SET karma='$karma_value' WHERE user_id='$user_id'") or die("Failed to update karma");
	
	}
	
	$sql_user2 = $mysqli->query("SELECT user_id,userid,karma FROM users ORDER BY karma DESC");
	
	while ($user_info = $sql_user2->fetch_array(MYSQLI_BOTH))
	{
	
	$smarty->append('sync',
			  array('user_id' => $user_info['user_id'],
					'user_name' => $user_info['userid'],
					'karma_value' => $user_info['karma']));
	
	}

$smarty->assign('left_nav', 'leftnav_position_karma');	
$smarty->assign('quick_search_games', 'quick_search_games_position_karma');	
	
//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/user_karmasync.html');

//close the connection
mysqli_close($mysqli);
?>
