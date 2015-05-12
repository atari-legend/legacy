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

if (isset($action) and $action == 'delete_comment')
{
	$REVIEWSHOT = mysql_query("SELECT * FROM screenshot_review
	   					   	   WHERE review_id = $reviewid 
							   AND screenshot_id = $screenshot_id")
	     		  or die ("Database error - selecting screenshots review");
							  
	$reviewshotrow = mysql_fetch_row($REVIEWSHOT);
	$reviewshotid = $reviewshotrow[0];
	
	//delete the screenshot comment from the DB table
	$sdbquery = mysql_query("DELETE FROM review_comments WHERE screenshot_review_id = $reviewshotid") or die ("failed deleting review_comments");
	
	//delete the screenshot linked to the review
	$sdbquery = mysql_query("DELETE FROM screenshot_review WHERE review_id = $reviewid AND screenshot_id = $screenshot_id") or die ("failed deleting screenshot_review");

header("Location: ../games/games_review_edit.php?reviewid=$reviewid&game_id=$game_id");
}

if (isset($action) and $action == 'delete_review')
{
	$sql = mysql_query("DELETE FROM review_main WHERE review_id = '$reviewid' ") or die ("deletion review_main failed");
	$sql = mysql_query("DELETE FROM review_game WHERE review_id = '$reviewid' AND game_id = '$game_id' ") or die ("deletion review_game failed");
	$sql = mysql_query("DELETE FROM review_score WHERE review_id = '$reviewid' ") or die ("deletion review_score failed");

	//delete the comments at every screenshot for this review
	$SCREENSHOT = mysql_query("SELECT * FROM screenshot_review where review_id = '$reviewid' ")
				  or die ("Database error - getting screenshots");
        
	while ( $screenshotrow=mysql_fetch_row($SCREENSHOT) )
	{
		$sql = mysql_query("DELETE FROM review_comments WHERE screenshot_review_id = $screenshotrow[0] ") or die ("deletion review_comments failed");
	}

	$sql = mysql_query("DELETE FROM screenshot_review WHERE review_id = '$reviewid' ") or die ("deletion screenshot failed");

header("Location: ../games/games_review_add.php?game_id=$game_id");
}

if ($action == 'edit_review')
{
	// first we have to convert the date vars into a time stamp to be inserted to review_date
	
	$date = date_to_timestamp($Date_Year,$Date_Month,$Date_Day);

	$textfield = addslashes($textfield);

	$sdbquery = mysql_query("UPDATE review_main set member_id = '$members', review_text = '$textfield', review_date = '$date', review_edit = '0'
				 			 WHERE review_id = '$reviewid'") or die("Couldn't update review_main");

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
				
				$comment = addslashes($comment);
				
					$sdbquery = mysql_query("UPDATE review_comments SET comment_text = '$comment'
											 WHERE screenshot_review_id = '$reviewshotid'")
								 or die("Couldn't update review_comments");
				}
				//else insert it
				else
				{
				$comment = addslashes($comment);	  			   
					$sdbquery = mysql_query("INSERT INTO review_comments (screenshot_review_id, comment_text) VALUES ('$reviewshotid', '$comment')")
								or die("Couldn't insert into review_comments");
				}
			}
			$i++;
		}
header("Location: ../games/games_review_edit.php?reviewid=$reviewid&game_id=$game_id");
}

if (isset($action) and $action == 'move_to_comment')
{

$sql_edit_REVIEW = mysql_query("SELECT * FROM review_main WHERE review_id = $reviewid")
				   or die ("Database error - selecting review data");

	$edit_review=mysql_fetch_array($sql_edit_REVIEW); 

	
	$review_text = mysql_real_escape_string($edit_review['review_text']);
	$review_timestamp = $edit_review['review_date'];
	$review_user_id = $edit_review['member_id'];

		$sql = mysql_query("INSERT INTO comments (comment,timestamp,user_id) VALUES ('$review_text','$review_timestamp','$review_user_id')") 
					or die("something is wrong with INSERT mysql3");
		$sql = mysql_query("INSERT INTO game_user_comments (game_id,comment_id) VALUES ('$game_id',LAST_INSERT_ID())") 
					or die("something is wrong with INSERT mysql4");

	$sql = mysql_query("DELETE FROM review_main WHERE review_id = '$reviewid' ") or die ("deletion review_main failed");
	$sql = mysql_query("DELETE FROM review_game WHERE review_id = '$reviewid' AND game_id = '$game_id' ") or die ("deletion review_game failed");
	$sql = mysql_query("DELETE FROM review_score WHERE review_id = '$reviewid' ") or die ("deletion review_score failed");

	//delete the comments at every screenshot for this review
	$SCREENSHOT = mysql_query("SELECT * FROM screenshot_review where review_id = '$reviewid' ")
				  or die ("Database error - getting screenshots");
        
	while ( $screenshotrow=mysql_fetch_row($SCREENSHOT) )
	{
		$sql = mysql_query("DELETE FROM review_comments WHERE screenshot_review_id = $screenshotrow[0] ") or die ("deletion review_comments failed");
	}

	$sql = mysql_query("DELETE FROM screenshot_review WHERE review_id = '$reviewid' ") or die ("deletion screenshot failed");

header("Location: ../games/games_review_add.php?game_id=$game_id");
}

?>
