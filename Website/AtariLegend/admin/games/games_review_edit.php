<?
/***************************************************************************
*                                games_review_edit.php
*                            --------------------------
*   begin                : saturday, December 4, 2004
*   copyright            : (C) 2004 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: games_review_edit.php,v 0.10 2004/12/04 23:34 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
//This php file will get the info to generate the page of the review
//********************************************************************************************* 

//load all common functions
include("../includes/common.php"); 

if ($action == 'delete_comment')
{
	$REVIEWSHOT = mysql_query("SELECT * FROM screenshot_review
	   					   	   WHERE  review_id = $reviewid 
							   AND screenshot_id = $screenshot_id")
	     		  or die ("Database error - selecting screenshots review");
							  
	$reviewshotrow = mysql_fetch_row($REVIEWSHOT);
	$reviewshotid = $reviewshotrow[0];
	
	//delete the screenshot comment from the DB table
	$sdbquery = mysql_query("DELETE FROM review_comments WHERE screenshot_review_id = $reviewshotid") or die ("failed deleting review_comments");
	
	//delete the screenshot linked to the review
	$sdbquery = mysql_query("DELETE FROM screenshot_review WHERE review_id = $reviewid AND screenshot_id = $screenshot_id") or die ("failed deleting screenshot_review");
}

if ($action == 'delete_review')
{
	$sql = mysql_query("DELETE FROM review_main WHERE review_id = '$reviewid' ") or die ("deletion review_main failed");
	$sql = mysql_query("DELETE FROM review_game WHERE review_id = '$reviewid' AND game_id = '$gameid' ") or die ("deletion review_game failed");
	$sql = mysql_query("DELETE FROM review_score WHERE review_id = '$reviewid' ") or die ("deletion review_score failed");

	//delete the comments at every screenshot for this review
	$SCREENSHOT = mysql_query("SELECT * FROM screenshot_review where review_id = '$reviewid' ")
				  or die ("Database error - getting screenshots");
        
	while ( $screenshotrow=mysql_fetch_row($SCREENSHOT) )
	{
		$sql = mysql_query("DELETE FROM review_comments WHERE screenshot_review_id = $screenshotrow[0] ") or die ("deletion review_comments failed");
	}

	$sql = mysql_query("DELETE FROM screenshot_review WHERE review_id = '$reviewid' ") or die ("deletion screenshot failed");
	
	//get the name of the game
	$sql_game = mysql_query("SELECT * FROM game WHERE game_id='$gameid'")
				or die ("Database error - getting game name");

	while ($game=mysql_fetch_array($sql_game)) 
	{ 
		$smarty->assign('game',
	   		 	 array('game_id' => $gameid,
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
	   						   WHERE review_game.game_id='$gameid' ORDER BY review_game.review_id")
			 	 or die ("Database error - selecting review");

	while ($review=mysql_fetch_array($sql_review)) 
	{
		$i++;
	
		$smarty->append('review',
		    	 array('review_id' => $review[review_id],
					   'user_name' => $review['userid'],
					   'review_nr' => $i));
	}	

	//get the screenshots
	$sql_screenshots= mysql_query("SELECT * FROM screenshot_game WHERE game_id = '$gameid' ORDER BY screenshot_id ASC")
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
}

if ($action == 'edit_review')
{
	// first we have to convert the date vars into a time stamp to be inserted to review_date
	
	$date = date_to_timestamp($Date_Year,$Date_Month,$Date_Day);
	
	$sdbquery = mysql_query("UPDATE review_main set member_id = $members, review_text = '$textfield', review_date = '$date', review_edit = '0'
				 			 WHERE review_id = $reviewid") or die("Couldn't update review_main");

	//check if comment already exists for this shot
	$REVIEWSCORE = mysql_query("SELECT * FROM review_score where review_id = $reviewid")
	  		       or die ("Database error - selecting scores");
					
	$score = mysql_num_rows($REVIEWSCORE);
	
	if ($score > 0)
	{
		$sdbquery = mysql_query("UPDATE review_score SET review_graphics = $graphics, review_sound = $sound, review_gameplay = $gameplay, review_overall = $conclusion
				 				 WHERE review_id = $reviewid") or die("Couldn't update review_score");
	}
	else
	{
		$sdbquery = mysql_query("INSERT INTO review_score (review_id, review_graphics, review_sound, review_gameplay, review_overall) VALUES ($reviewid, '$graphics', '$sound', '$gameplay', '$overall')")
					or die("Couldn't insert the update of the review_score");
	}
	
	//we're gonna add the screenhots into the screenshot_review table and fill up the review_comment table.
	//We need to loop on the screenshot table to check the shots used. If a comment field is filled,
	//the screenshot was used!
		$SCREEN = mysql_query("SELECT * FROM screenshot_game where game_id = '$game_id' ORDER BY screenshot_id ASC")
	    		  or die ("Database error - getting screenshots");
				
    	$i=0;
		
		while ( $screenrow=mysql_fetch_row($SCREEN) )
		{
			
			if($inputfield[$i] != "")
			{
				//fill the review_screenshot table 
				
				$screenid = $screenrow[2];
				$comment = $inputfield[$i];
				
				$REVIEWSCREEN = mysql_query("SELECT * FROM screenshot_review WHERE review_id = '$reviewid' AND 
											 screenshot_id = '$screenid'")
	    					    or die ("Database error - getting review - screenshots");
					
				//check if shot exists
				$number = mysql_num_rows($REVIEWSCREEN);
				
				if ($number > 0)
				{
				}
				//else insert it
				else
				{
					$sdbquery = mysql_query("INSERT INTO screenshot_review (review_id, screenshot_id) VALUES ('$reviewid', '$screenid')")
								or die("Couldn't insert into screenshot_review");
				}
				
				$REVIEWSHOT = mysql_query("SELECT * FROM screenshot_review where review_id = '$reviewid' AND
										   screenshot_id = '$screenid'")
							  or die ("Database error - selecting screenshots review");
								  			   
				$reviewshotrow = mysql_fetch_row($REVIEWSHOT);
				
			  	$reviewshotid = $reviewshotrow[0];
				
				//check if comment already exists for this shot
				$REVIEWCOMMENT = mysql_query("SELECT * FROM review_comments where screenshot_review_id = '$reviewshotid'")
							     or die ("Database error - selecting screenshot review comment");
				
				$number = mysql_num_rows($REVIEWCOMMENT);
				
				if ($number > 0)
				{
					$sdbquery = mysql_query("UPDATE review_comments SET comment_text = '$comment'
											 WHERE screenshot_review_id = '$reviewshotid'")
								 or die("Couldn't update review_comments");
				}
				//else insert it
				else
				{	  			   
					$sdbquery = mysql_query("INSERT INTO review_comments (screenshot_review_id, comment_text) VALUES ('$reviewshotid', '$comment')")
								or die("Couldn't insert into review_comments");
				}
			}
			$i++;
		}
}

if ($action != 'delete_review')
{
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
	
	
	$smarty->append('review',
	    	 array('review_id' => $review['review_id'],
				   'user_name' => $review['userid'],
				   'review_nr' => $i));
$i++;
}

//get the actual edit review data
$sql_edit_REVIEW = mysql_query("SELECT 
							   member_id, 
							   review_text, 
							   review_date, 
							   review_score_id, 
							   review_graphics, 
							   review_sound, 
							   review_gameplay, 
							   review_overall
 							   FROM review_game
							   LEFT JOIN review_main ON ( review_game.review_id = review_main.review_id ) 
							   LEFT JOIN review_score ON ( review_main.review_id = review_score.review_id ) 
					   	       WHERE review_game.review_id = $reviewid 
							   AND review_game.game_id='$game_id' 
							   ORDER BY review_game.review_id")
				   or die ("Database error - selecting review data");

while ($edit_review=mysql_fetch_array($sql_edit_REVIEW)) 
{
	$smarty->assign('edit_review',
	    	  array('member_id' => $edit_review['member_id'],
				    'review_text' => $edit_review['review_text'],
				    'review_date' => $edit_review['review_date'],
					'review_score_id' => $edit_review['review_score_id'],
					'review_graphics' => $edit_review['review_graphics'],
					'review_sound' => $edit_review['review_sound'],
					'review_gameplay' => $edit_review['review_gameplay'],
					'review_overall' => $edit_review['review_overall']));
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
	
	$sql_COMMENTS = mysql_query("SELECT review_comments.comment_text FROM screenshot_review
								 LEFT JOIN review_comments on (screenshot_review.screenshot_review_id = review_comments.screenshot_review_id)
			    				 WHERE screenshot_review.screenshot_id = '$screenshots[2]' AND screenshot_review.review_id = '$reviewid'")
				    or die ("Database error - getting screenshots comments");
				
	$screencomment=mysql_fetch_array($sql_COMMENTS);

	$smarty->append('screenshots',
	    	 array('screenshot_id' => $screenshots['screenshot_id'],
				   'screenshot_link' => $v_screenshot,
				   'screenshot_comment' => $screencomment['comment_text'],
				   'screenshot_id' => $screenshots[2]));
}

$smarty->assign("screenshots_nr",$i);
$smarty->assign("reviewid",$reviewid);

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('games_review_edit_html', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
}
