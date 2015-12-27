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
*	Id: user_main.php,v 0.30 2015/12/21 ST Graveyard - added right side 
*													 - changed message variable
*													 - Moved SQL statements to DB file
*
***************************************************************************/

/*
***********************************************************************************
User main
***********************************************************************************
*/
// Include common variables and functions
include("../../includes/common.php");
include("../../includes/quick_search_games.php");
include("../../includes/admin.php");

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

$smarty->assign('left_nav', 'leftnav_position_usermain');
$smarty->assign('quick_search_games', 'quick_search_position_usermain');
$smarty->assign('main_stats', 'main_stats_position_usermain');			
		
//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/user_main.html');
?>
