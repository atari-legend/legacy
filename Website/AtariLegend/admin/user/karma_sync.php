<?php
/*******************************************************************************
*                                karma_sync.php
*                            -----------------------
*   begin                : 2005-11-13
*   copyright            : (C) 2005 Atari Legend
*   email                : atarizone@atarizone.com
*
*   Id: karma_sync.php,v 0.10 2005/11/13 23:30 Silver
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

// Include common files
include("../includes/common.php");

// Set values

$value_gamedownload = -5;
$value_gamecomment = 5;
$value_gamesubmission = 10;
$value_weblink = 3;
$value_news = 15;
$value_gamereview = 50;

$sql_user = mysql_query("SELECT user_id,userid,karma FROM users");

 while (list ($user_id,$user_name,$karma_value) = mysql_fetch_array($sql_user))
	{
	
	$nr_gamecomments = 0;
	$nr_gamereviews = 0;
	$nr_downloads = 0;
	$nr_gamesubmissions = 0;
	$nr_links = 0;
	$nr_news = 0;
	
	// gamecomments
	$sql_gamecomments = mysql_query("SELECT * FROM comments
					LEFT JOIN game_user_comments ON (comments.comments_id = game_user_comments.comment_id)
					LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
					WHERE comments.user_id = $user_id");
	
	$nr_gamecomments = mysql_num_rows($sql_gamecomments);
	
	mysql_free_result($sql_gamecomments);
	
	// reviews
	$sql_gamereview = mysql_query("SELECT * FROM review_main
					LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
					LEFT JOIN game ON ( review_game.game_id = game.game_id )
					WHERE review_main.member_id = $user_id");
	
	$nr_gamereviews = mysql_num_rows($sql_gamereview);
	mysql_free_result($sql_gamereview);
	
	// START - NUMBER OF DOWNLOADS BY USER
	$sql_downloads = mysql_query("SELECT COUNT(*) AS count FROM game_download_info WHERE user_id = $user_id");
	$gamecount = mysql_fetch_array($sql_downloads);
	$nr_downloads = $gamecount[count];
	mysql_free_result($sql_downloads);
	
	// gamesubmissions
	$sql_submissions = mysql_query("SELECT * FROM game_submitinfo 
				    LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
					WHERE user_id = $user_id");
					
	$nr_gamesubmissions = mysql_num_rows($sql_submissions);
	mysql_free_result($sql_submissions);
	
	// Submitted links
	$sql_links = mysql_query("SELECT * FROM website WHERE website_user_sub = $user_id");
	
	$nr_links = mysql_num_rows($sql_links);
	mysql_free_result($sql_links);
	
	// START - NUMBER OF NEWS POSTS BY USER
	$sql_news = mysql_query("SELECT * FROM news WHERE user_id = $user_id");
	
	$nr_news = mysql_num_rows($sql_news);
	mysql_free_result($sql_news);
	
	$karma_value = 0;
	
	$karma_value = $karma_value + ($nr_gamecomments*$value_gamecomment);
	$karma_value = $karma_value + ($nr_gamereviews*$value_gamereview);
	$karma_value = $karma_value + ($nr_gamesubmissions*$value_gamesubmission);
	$karma_value = $karma_value + ($nr_links*$value_weblink);
	$karma_value = $karma_value + ($nr_news*$value_news);
	$karma_value = $karma_value + ($nr_downloads*$value_gamedownload);
	
	$update = mysql_query("UPDATE users SET karma='$karma_value' WHERE user_id='$user_id'") or die("Failed to update karma");
	
	}
	
	$sql_user2 = mysql_query("SELECT user_id,userid,karma FROM users ORDER BY karma DESC");
	
	while ($user_info = mysql_fetch_assoc($sql_user2))
	{
	
	$smarty->append('sync',
			  array('user_id' => $user_info[user_id],
					'user_name' => $user_info[userid],
					'karma_value' => $user_info[karma]));
	
	}

$smarty->assign('user_karmasync_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();?>