<?
/***************************************************************************
*                               user_statistics.php
*                            -----------------------
*   begin                : friday, November 11, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : file creation
*							
*
*   Id: user_statistics.php.php,v 0.10 2005/05/01 ST Graveman
*
***************************************************************************/

/*
***********************************************************************************
This is the user statistics page
***********************************************************************************
*/
// include common variables and functions
include("../includes/common.php");

// START - NUMBER OF USERCOMMENTS
$sql = mysql_query("SELECT * FROM comments
					LEFT JOIN game_user_comments ON (comments.comments_id = game_user_comments.comment_id)
					LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
					WHERE comments.user_id = $user_id_selected");

while ($query = mysql_fetch_array($sql))
{
    $nr_comments++;
	
	$smarty->append('users_comments',
				array('game_id' => $query[game_id],
					  'game_name' => $query[game_name]));
}

$smarty->assign('nr_comments', $nr_comments);

mysql_free_result($sql);


// START - NUMBER OF reviews
$sql = mysql_query("SELECT * FROM review_main
					LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
					LEFT JOIN game ON ( review_game.game_id = game.game_id )
					WHERE review_main.member_id = $user_id_selected");

while ($query = mysql_fetch_array($sql))
{
    $nr_reviews++;
	
	$smarty->append('users_reviews',
				array('game_id' => $query[game_id],
					  'game_name' => $query[game_name],
					  'review_id' => $query[review_id]));
}

$smarty->assign('nr_reviews', $nr_reviews);

mysql_free_result($sql);


// START - NUMBER OF DOWNLOADS BY USER
$sql = "SELECT COUNT(*) AS count FROM game_download_info WHERE user_id = $user_id_selected";
$query = mysql_query($sql);
$gamecount = mysql_fetch_array($query);
$gamecount = $gamecount[count];

$smarty->assign('nr_downloads', $gamecount);

mysql_free_result($query);


// START - NUMBER OF SUBMISSIONS BY USER
$sql = mysql_query("SELECT * FROM game_submitinfo 
				    LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
					WHERE user_id = $user_id_selected");

while ($query = mysql_fetch_array($sql))
{
	$nr_submission++;
	
	$smarty->append('users_submission',
				array('game_id' => $query[game_id],
					  'game_name' => $query[game_name]));
}

$smarty->assign('nr_submission', $nr_submission);

mysql_free_result($sql);


// START - NUMBER OF LINKS BY USER
$sql = mysql_query("SELECT * FROM website WHERE website_user_sub = $user_id_selected");
	
while ($query = mysql_fetch_array($sql))
{
	$nr_links++;
	
	$smarty->append('users_website',
			  array('website_id' => $query[website_id],
					'website_name' => $query[website_name]));
}

$smarty->assign('nr_links', $nr_links);

mysql_free_result($sql);

// START - NUMBER OF NEWS POSTS BY USER
$sql = mysql_query("SELECT * FROM news WHERE user_id = $user_id_selected");
	
while ($query = mysql_fetch_array($sql))
{
	$nr_news++;
	
	$smarty->append('users_news',
			  array('news_id' => $query[news_id],
					'news_headline' => $query[news_headline]));
}

//get user info
// START - NUMBER OF NEWS POSTS BY USER
$sql = mysql_query("SELECT * FROM users WHERE user_id = $user_id_selected") or die ('problem getting user data');
	
while ($query = mysql_fetch_array($sql))
{
	$smarty->assign('user',
			  array('user_id' => $query[user_id],
					'username' => $query[userid],
					'user_email' => $query[email]));
}

$smarty->assign('nr_news', $nr_news);

mysql_free_result($sql);

$smarty->assign('user_id_selected', $user_id_selected);
$smarty->assign('user_statistics_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>