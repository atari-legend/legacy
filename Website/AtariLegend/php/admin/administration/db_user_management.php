<?php
/***************************************************************************
*                                db_user_management.php
*                            -----------------------
*   begin                : 2016-02-24
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: db_user_management.php,v 0.10 2016-02-24 Silver Surfer
*
***************************************************************************/

include("../../includes/common.php");
include("../../includes/admin.php"); 

// Ajax driven delete user query
if (isset($action) and $action=="delete_user") {
$start = microtime(true);

				$time_elapsed_secs = microtime(true) - $start;
				$smarty->assign("query_time",$time_elapsed_secs);

		
//Send all smarty variables to the templates

echo "Lots of users deleted";

}
?>
