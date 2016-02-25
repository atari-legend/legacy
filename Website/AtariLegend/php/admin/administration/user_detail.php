<?php
/***************************************************************************
*                                user_detail.php
*                            -----------------------
*   begin                : 2016-02-25
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: user_detail.php,v 0.10 2016-02-25 Silver Surfer
*
***************************************************************************/

include("../../includes/common.php");
include("../../includes/admin.php"); 

$start = microtime(true);


//Lets get all the data of the selected user
	$sql_users = $mysqli->query("SELECT * FROM users 
							  WHERE user_id = $user_id_selected")
				 or die ("Couldn't query users Database");
	
	while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH))
	{
		$email = trim($query_users['email']);
		
		if ($query_users['join_date']!=='')
		{
		$join_date = convert_timestamp($query_users['join_date']);
		}
		if ($query_users['last_visit']!=='')
		{
		$last_visit = convert_timestamp($query_users['last_visit']);
		}
		$smarty->assign('users',
						array('user_id' => $query_users['user_id'],
							  'user_name' => $query_users['userid'],
							  'user_pwd' => $query_users['password'],
							  'user_email' => $query_users['email'],
							  'user_permission' => $query_users['permission'],
							  'user_website' => $query_users['user_website'],
							  'user_icq' => $query_users['user_icq'],
							  'user_msnm' => $query_users['user_msnm'],
							  'avatar_ext' => $query_users['avatar_ext'],
							  'image' => "$user_avatar_path$query_users[user_id].$query_users[avatar_ext]",
							  'user_aim' => $query_users['user_aim']));
	}
				$time_elapsed_secs = microtime(true) - $start;
				$smarty->assign("query_time",$time_elapsed_secs);

		
//Send all smarty variables to the templates

$smarty->display("file:".$cpanel_template_folder."user_detail_pop.html");
?>
