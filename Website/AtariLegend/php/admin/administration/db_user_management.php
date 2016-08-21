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
*   Id: db_user_management.php,v 0.11 2016-08-21 STG
*			- added change log
*
***************************************************************************/

include("../../includes/common.php");
include("../../includes/admin.php"); 

// Ajax driven delete user query
if (isset($action) and $action=="delete_user") {
	if (isset($user_id))
	{
		$start = microtime(true);
		$i=0;
		foreach($user_id as $user)
		{
			create_log_entry('Users', $user, 'User', $user, 'Delete', $_SESSION['user_id']);
			
			$sql = $mysqli->query("DELETE FROM users WHERE user_id = '$user' ") or die ("error deleting user");			
			$i++;
		}	
		$time_elapsed_secs = microtime(true) - $start;	
		$_SESSION['edit_message'] = 'User(s) deleted succesfully';
	}
	else
	{
		$_SESSION['edit_message'] = 'Please SELECT a user you want to delete';
	}
}

if ((isset($action) and $action=="deactivate_user") OR (isset($action) and $action=="email_user")) {
	$_SESSION['edit_message'] = 'This action is still under construction';
}

header("Location: ../administration/user_management.php");

?>
