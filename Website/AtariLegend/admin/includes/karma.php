<?php
/*******************************************************************************
*                                karma.php
*                            -----------------------
*   begin                : 2005-11-13
*   copyright            : (C) 2005 Atari Legend
*   email                : atarizone@atarizone.com
*
*   Id: karma.php,v 0.10 2005/11/13 23:30 Silver
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
// $karma_action = demo_submission


function UserKarma($user_id,$karma_action)
{
	
	if (empty($user_id)) {die("user_id wasn't passed properly");}
	if (empty($karma_action)) {die("karma values wasn't passed properly");}
	
	$sql_karma = mysql_query("SELECT karma FROM users WHERE user_id = '$user_id'") or die("failed to query users");
	list ($karma_value) = mysql_fetch_row($sql_karma);
	
	// For downloads
	if ($karma_action == "game_downloads")
	{
	 $karma_value = $karma_value-5;	
	}

	// For game comments
	if ($karma_action == "game_comment")
	{
	 $karma_value = $karma_value+5;	
	}

	// For game submissions
	if ($karma_action == "game_submission")
	{
	 $karma_value = $karma_value+10;	
	}
	
	// For submitting weblinks
	if ($karma_action == "weblink")
	{
	 $karma_value = $karma_value+3;	
	}

	// For submitting news
	if ($karma_action == "news_update")
	{
	 $karma_value = $karma_value+3;	
	}
	
	// For submitting game_reviews
	if ($karma_action == "game_review")
	{
	 $karma_value = $karma_value+3;	
	}
	
	// For submitting game_reviews
	if ($karma_action == "demo_submission")
	{
	 $karma_value = $karma_value+10;	
	}
	
	$update_karma = $mysqli->query("UPDATE users SET karma='$karma_value' WHERE user_id = '$user_id'");
	
return;
}

function KarmaGood()
{
	global $mysqli;
	$sql = $mysqli->query("SELECT karma,userid,user_id FROM users ORDER BY karma DESC LIMIT 17");
	while ($row = $sql->fetch_array(MYSQLI_BOTH)) {
		
							$result[]=$row;
							}
return $result;	
}

function KarmaBad()
{
	global $mysqli;
	$sql = $mysqli->query("SELECT karma,userid,user_id FROM users WHERE karma IS NOT NULL ORDER BY karma ASC LIMIT 17");
	while ($row = $sql->fetch_array(MYSQLI_BOTH)) {
	
						$result[]=$row;
						}
return $result;	
}
?>
