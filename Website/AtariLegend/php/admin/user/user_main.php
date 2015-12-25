<?php
/***************************************************************************
*                                user_main.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: user_main.php,v 0.10 2005/05/01 Silver Surfer
*	Id: user_main.php,v 0.20 2015/09/04 ST Graveyard
*
***************************************************************************/

/*
***********************************************************************************
User main
***********************************************************************************
*/
// Include common variables and functions
include("../../includes/common.php");
include("../../includes/admin.php");

if (isset($action) and $action == 'delete_user')
{
	//First we need to do a hell of a lot checks before we can delete an actual user.
	$sql = $mysqli->query("SELECT * FROM comments
						LEFT JOIN game_user_comments ON (comments.comments_id = game_user_comments.comment_id)
						LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
						WHERE comments.user_id = '$user_id_selected'") or die ("error selecting game comments");
						
	if ( get_rows($sql) > 0 )
	{
		$smarty->assign("message",'Deletion failed - This user has submitted game comments - Delete it in the appropriate section');
		
		$smarty->assign('user_id_selected', $user_id_selected);
	}
	else
	{
		$sql = $mysqli->query("SELECT * FROM review_main
							LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
							LEFT JOIN game ON ( review_game.game_id = game.game_id )
							WHERE review_main.member_id = '$user_id_selected'") or die ("error selecting game reviews");
		
		if ( get_rows($sql) > 0 )
		{
			$smarty->assign("message",'Deletion failed - This user has submitted game reviews - Delete it in the appropriate section');
		}
		else
		{
			$sql = $mysqli->query("SELECT * FROM game_submitinfo 
				   				LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
								WHERE user_id = '$user_id_selected'") or die ("error selecting game info");
			if ( get_rows($sql) > 0 )
			{
				$smarty->assign("message",'Deletion failed - This user has submitted game info - Delete it in the appropriate section');
			}
			else
			{
				$sql = $mysqli->query("SELECT * FROM website WHERE website_user_sub = '$user_id_selected'") or die ("error selecting links");
				
				if ( get_rows($sql) > 0 )
				{
					$smarty->assign("message",'Deletion failed - This user has submitted links - Delete it in the appropriate section');
				}
				else
				{
					$sql = $mysqli->query("SELECT * FROM news WHERE user_id = '$user_id_selected'") or die ("error selecting news");
				
					if ( get_rows($sql) > 0 )
					{
						$smarty->assign("message",'Deletion failed - This user has submitted news updates - Delete it in the appropriate section');
					}
					else
					{
					 	$sql = $mysqli->query("SELECT * FROM comments
						LEFT JOIN demo_user_comments ON (comments.comments_id = demo_user_comments.comments_id)
						LEFT JOIN demo ON ( demo_user_comments.demo_id = demo.demo_id )
						WHERE comments.user_id = $user_id_selected") or die ("error selecting demo comments");	
	
						if ( get_rows($sql) > 0 )
						{
							$smarty->assign("message",'Deletion failed - This user has submitted demo comments - Delete it in the appropriate section');
						}
						else
						{
							$mysqli->query("DELETE from users WHERE user_id='$user_id_selected'") or die ('deleting user failed');
	
							$smarty->assign('message', 'User deleted succesfully');
 						}
					}
				}
			}
		}
	}
}

//Do some stats
foreach (KarmaGood() as $key => $value)
{
	$smarty->append('karma_good',
	    			array('karma' => $value[0],
						  'user_name' => $value[1],
						  'user_id' => $value[2]));
   
}

foreach (KarmaBad() as $key => $value)
{
	$smarty->append('karma_bad',
	    			array('karma' => $value[0],
						  'user_name' => $value[1],
						  'user_id' => $value[2]));
   
}

$stack = statistics_stack();

// smack the stack into a smarty var and pray it works
foreach ($stack as $value) {
		$smarty->append('statistics',
				array('value' => $value));
		}

//get all the user accounts
$query_number = $mysqli->query("SELECT email FROM users") or die ("Couldn't get the total number of users");
$v_rows = $query_number->num_rows;
$smarty->assign('nr_users', $v_rows);

// Create dropdown values a-z
$az_value = az_dropdown_value(0);
$az_output = az_dropdown_output(0);
		   
$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);	

$smarty->assign('left_nav', 'leftnav_position_usermain');
$smarty->assign('main_stats', 'main_stats_position_usermain');			
		
//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/user_main.html');
?>
