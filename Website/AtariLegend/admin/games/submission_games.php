<?php
/***************************************************************************
*                                submission_games.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Fixed counting bug
						   Fixed switch bug
*							
*
*   Id: submission_games.php,v 0.12 2005/04/28 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Display submissions
***********************************************************************************
*/

include("../includes/common.php");

// get the total nr of submissions in the DB
$query_total_number = $mysqli->query("SELECT * FROM game_submitinfo") or die ("Couldn't get the total number of submissions");
$v_rows_total = $query_total_number->num_rows;
$smarty->assign('total_nr_submissions', $v_rows_total);

//$v_counter = (isset($_GET['v_counter']) ? $_GET['v_counter'] : 0);
		if (empty($v_counter)) {$v_counter = 0;}
		if (!isset($list)) {$list="current"; }
		if ($list=="done") 
		
		{
		$sql_submission =  $mysqli->query("SELECT * FROM game_submitinfo
									 	LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
									 	LEFT JOIN users ON (game_submitinfo.user_id = users.user_id)
										WHERE game_done = '1'
										ORDER BY game_submitinfo.game_submitinfo_id
										DESC LIMIT  " . $v_counter . ", 25");
										
				//check the number of comments
				$query_number = $mysqli->query("SELECT * FROM game_submitinfo 
											 WHERE game_done = '1' 
											 ORDER BY game_submitinfo_id DESC") 
											 or die("Couldn't get the number of game submissions");
									 
				$v_rows = $query_number->num_rows;
		}
		
		else
		
		{
		
		$sql_submission =  $mysqli->query("SELECT * FROM game_submitinfo
									 	LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
									 	LEFT JOIN users ON (game_submitinfo.user_id = users.user_id)
										WHERE game_done <> '1'
										ORDER BY game_submitinfo.game_submitinfo_id
										DESC LIMIT  " . $v_counter . ", 25");
										
				//check the number of comments
				$query_number = $mysqli->query("SELECT * FROM game_submitinfo 
											 WHERE game_done <> '1' 
											 ORDER BY game_submitinfo_id DESC") 
											 or die("Couldn't get the number of game submissions");
									 
				$v_rows = $query_number->num_rows;

		}
		
										
		$number_sub = $sql_submission->num_rows;
	
		while ($query_submission = $sql_submission->fetch_array(MYSQLI_BOTH))  
		{
		
		
	if (isset($query_submission['game_id'])) 
	{
	
		//Select a random screenshot record
	$query_game = $mysqli->query("SELECT 
							   screenshot_game.game_id,
							   screenshot_game.screenshot_id,
							   screenshot_main.imgext
						   	   FROM screenshot_game 
						       LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id) 
							   WHERE screenshot_game.game_id = " .$query_submission['game_id']. "						   	   
						   	   ORDER BY RAND() LIMIT 1"); 
							   
	$sql_game = $query_game->fetch_array(MYSQLI_BOTH);  
	}
	
	// Retrive userstats from database
	$query_user = $mysqli->query("SELECT *
							   FROM game_user_comments
							   LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
							   WHERE user_id = " .$query_submission['user_id']."");
	$usercomment_number = $query_user->num_rows;
	
	$query_submitinfo = $mysqli->query("SELECT * FROM game_submitinfo WHERE user_id = ".$query_submission['user_id']."") 
						or die ("Could not count user submissions");
	$usersubmit_number = $query_submitinfo->num_rows;
	
	
			//Get the dataElements we want to place on screen
			$v_game_image  = $game_screenshot_path;
			$v_game_image .= $sql_game['screenshot_id'];
			$v_game_image .= '.';
			$v_game_image .= $sql_game['imgext'];
	
			$converted_date = convert_timestamp($query_submission['timestamp']);
			$user_joindate = convert_timestamp($query_submission['join_date']);
				$comment = InsertALCode($query_submission['submit_text']);
				$comment = InsertSmillies($comment);
				$comment = nl2br($comment);
				$comment = stripslashes($comment);
		
			if ($query_submission['avatar_ext']!=="")
			{
			$avatar_image  = $user_avatar_path;
			$avatar_image .= $query_submission['user_id'];
			$avatar_image .= '.';
			$avatar_image .= $query_submission['avatar_ext'];
			}
			else {
			$avatar_image ="";
			}
					$smarty->append('submission',
	    				    array('game_id' => $query_submission['game_id'],
						  'game_name' => $query_submission['game_name'],
						  'date' => $converted_date,
						  'image' => $v_game_image,
						  'comment' => $comment,
						  'submit_id' => $query_submission['game_submitinfo_id'],
						  'user_name' => $query_submission['userid'],
						  'user_id' => $query_submission['user_id'],
						  'avatar_ext' => $query_submission['avatar_ext'],
			  			  'avatar_image' => $avatar_image,
						  'karma' => $query_submission['karma'],
						  'user_joindate' => $user_joindate,
						  'user_comment_nr' => $usercomment_number,
						  'usersubmit_number' => $usersubmit_number,
						  'email' => $query_submission['email']));
		} 
		
		//Check if back arrow is needed 
		if($v_counter > 0)
			{
				$back_arrow = $v_counter - 25;
			}


		//Check if we need to place a next arrow
		if($v_rows > ($v_counter + 25))
			{
				$forward_arrow = ($v_counter + 25);
			}

			if (!isset($list)) {$list="current"; }
			if (empty($back_arrow)) {$back_arrow='';}	 
				 $smarty->assign('structure',
	    			array('list' => $list,
						  'v_counter' => $v_counter,
						  'back_arrow' => $back_arrow,
						  'forward_arrow' => $forward_arrow,
						  'num_sub' => $number_sub));

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/submission_games.html');
?>
