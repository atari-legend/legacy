<?php
/***************************************************************************
*                                submission_demos.php
*                            -----------------------------
*   begin                : Sunday, December 04, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*							
*
*   Id: submission_demos.php,v 0.12 2005/04/28 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Display submissions
***********************************************************************************
*/

include("../includes/common.php");

// get the total nr of submissions in the DB
$query_total_number = mysql_query("SELECT count(*) FROM demo_submitinfo") or die ("Couldn't get the total number of submissions");
$v_rows_total = mysql_result($query_total_number,0,0) or die("Couldn't get the total number of submissions");
$smarty->assign('total_nr_submissions', $v_rows_total);

$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);
		
		if ($list=="done") 
		
		{
		$sql_submission =  mysql_query("SELECT * FROM demo_submitinfo
									 	LEFT JOIN demo ON (demo_submitinfo.demo_id = demo.demo_id)
									 	LEFT JOIN users ON (demo_submitinfo.user_id = users.user_id)
										WHERE demo_done = '1'
										ORDER BY demo_submitinfo.demo_submitinfo_id
										DESC LIMIT  " . $v_counter . ", 25");
										
				//check the number of comments
				$query_number = mysql_query("SELECT count(*) FROM demo_submitinfo 
											 WHERE demo_done = '1' 
											 ORDER BY demo_submitinfo_id DESC") 
											 or die("Couldn't get the number of demo submissions");
									 
				$v_rows = mysql_result($query_number,0,0) or die("Couldn't get the number of demo_submissions");
		}
		
		else
		
		{
		
		$sql_submission =  mysql_query("SELECT * FROM demo_submitinfo
									 	LEFT JOIN demo ON (demo_submitinfo.demo_id = demo.demo_id)
									 	LEFT JOIN users ON (demo_submitinfo.user_id = users.user_id)
										WHERE demo_done <> '1'
										ORDER BY demo_submitinfo.demo_submitinfo_id
										DESC LIMIT  " . $v_counter . ", 25");
										
				//check the number of comments
				$query_number = mysql_query("SELECT count(*) FROM demo_submitinfo 
											 WHERE demo_done <> '1' 
											 ORDER BY demo_submitinfo_id DESC") 
											 or die("Couldn't get the number of demo submissions");
									 
				$v_rows = mysql_result($query_number,0,0);

		}
		
										
		$number_sub = get_rows($sql_submission);
	
		while ($query_submission = mysql_fetch_array($sql_submission))  
		{
		
		
	if (isset($query_submission[demo_id])) 
	{
	
		//Select a random screenshot record
	$query_demo = mysql_query("SELECT 
							   screenshot_demo.demo_id,
							   screenshot_demo.screenshot_id,
							   screenshot_main.imgext
						   	   FROM screenshot_demo 
						       LEFT JOIN screenshot_main ON (screenshot_demo.screenshot_id = screenshot_main.screenshot_id) 
							   WHERE screenshot_demo.demo_id = $query_submission[demo_id]						   	   
						   	   ORDER BY RAND() LIMIT 1"); 
							   
	$sql_demo = mysql_fetch_array($query_demo);  
	}
	
	// Retrive userstats from database
	$query_user = mysql_query("SELECT count(*)
							   FROM demo_user_comments
							   LEFT JOIN comments ON ( demo_user_comments.comments_id = comments.comments_id )
							   WHERE user_id = '$query_submission[user_id]'");
	$usercomment_number = mysql_result($query_user,0,0);
	
	$query_submitinfo = mysql_query("SELECT count(*) FROM demo_submitinfo WHERE user_id = '$query_submission[user_id]'") 
						or die ("Could not count user submissions");
	$usersubmit_number = mysql_result($query_submitinfo,0,0);
	
	
			//Get the dataElements we want to place on screen
			$v_demo_image  = $demo_screenshot_path;
			$v_demo_image .= $sql_demo[screenshot_id];
			$v_demo_image .= '.';
			$v_demo_image .= $sql_demo[imgext];
	
			$converted_date = convert_timestamp($query_submission[timestamp]);
			$user_joindate = convert_timestamp($query_submission[join_date]);
				$comment = InsertALCode($query_submission[submit_text]);
				$comment = InsertSmillies($comment);
				$comment = nl2br($comment);
				$comment = stripslashes($comment);
		
					$smarty->append('submission',
	    			array('demo_id' => $query_submission['demo_id'],
						  'demo_name' => $query_submission['demo_name'],
						  'date' => $converted_date,
						  'image' => $v_demo_image,
						  'comment' => $comment,
						  'submit_id' => $query_submission['demo_submitinfo_id'],
						  'user_name' => $query_submission['userid'],
						  'user_id' => $query_submission[user_id],
						  'karma' => $query_submission[karma],
						  'user_joindate' => $user_joindate,
						  'user_comment_nr' => $usercomment_number,
						  'usersubmit_number' => $usersubmit_number,
						  'email' => $query_submission[email]));
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

			if ($list=='') {$list="current"; }
				 
				 $smarty->assign('structure',
	    			array('list' => $list,
						  'v_counter' => $v_counter,
						  'back_arrow' => $back_arrow,
						  'forward_arrow' => $forward_arrow,
						  'num_sub' => $number_sub));
 
$smarty->assign('submission_demos_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>
