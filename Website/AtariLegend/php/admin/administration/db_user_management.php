<?php
/***************************************************************************
*                                db_user_management.php
*                            -----------------------
*   begin                : 2016-02-24
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*   Id: db_user_management.php,v 0.10 2016-02-24 Silver Surfer
*
***************************************************************************/

include("../../includes/common.php");
include("../../includes/admin.php"); 

// Ajax driven delete user query
// if (isset($action) and $action=="delete_user") {
// $start = microtime(true);
// $i=0;
//	foreach($user_id as $user)
//	{
//	$sql = $mysqli->query("DELETE FROM users WHERE user_id = '$user' ") or die ("error deleting user");
				
//	$i++;
//	}	
	
//	$time_elapsed_secs = microtime(true) - $start;
	
//  $_SESSION['edit_message'] = 'User(s) deleted succesfully';

$_SESSION['edit_message'] = 'This action is still under construction';

header("Location: ../administration/user_management.php");

//}
?>
