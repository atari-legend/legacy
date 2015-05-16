<?php
/***************************************************************************
*                                games_review_add.php
*                            --------------------------
*   begin                : Sunday, November 27, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id: games_review_add.php,v 0.10 2005/11/27 Gatekeeper
*
***************************************************************************/

/*
***********************************************************************************
This is the game review page where you add a review to the db
***********************************************************************************
*/

//load all common functions
include("../includes/common.php"); 

//get the name of the game
$sql_game = mysql_query("SELECT * FROM game WHERE game_id='$game_id'")
		or die ("Database error - getting game name");

while ($game=mysql_fetch_array($sql_game)) 
{ 
	$smarty->assign('game',
	    	 array('game_id' => $game_id,
				   'game_name' => $game['game_name']));
}

//Get the authors
$sql_author = mysql_query("SELECT user_id,userid FROM users")
			  or die ("Database error - getting members name");

while ( $authors=mysql_fetch_array($sql_author) )
{
	$smarty->append('authors',
	   		 array('user_id' => $authors['user_id'],
				   'user_name' => $authors['userid']));
}

//get the reviews of the game	
$sql_review = mysql_query("SELECT * FROM review_game 
 					  	   LEFT JOIN review_main ON (review_game.review_id = review_main.review_id)
	   					   LEFT JOIN users ON (review_main.member_id = users.user_id)
	   					   WHERE review_game.game_id='$game_id' ORDER BY review_game.review_id")
			  or die ("Database error - selecting review");
$i=1;
while ($review=mysql_fetch_array($sql_review)) 
{
	$i++;
	
	$smarty->append('review',
	    	 array('review_id' => $review['review_id'],
				   'user_name' => $review['userid'],
				   'review_nr' => $i));
}

//get the screenshots
$sql_screenshots= mysql_query("SELECT * FROM screenshot_game WHERE game_id = '$game_id' ORDER BY screenshot_id ASC")
				  or die ("Database error - getting screenshots");

$i=0;

while ($screenshots=mysql_fetch_array($sql_screenshots)) 
{
	$i++;
	
	$v_screenshot  = $game_screenshot_path;
	$v_screenshot .= $screenshots['screenshot_id'];
	$v_screenshot .= '.';
	$v_screenshot .= 'png';

	$smarty->append('screenshots',
	    	 array('screenshot_id' => $screenshots['screenshot_id'],
				   'screenshot_link' => $v_screenshot));
}

$smarty->assign("screenshots_nr",$i);

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('games_review_add_html', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
