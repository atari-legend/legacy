<?php
/***************************************************************************
*                                user_management.php
*                            -----------------------
*   begin                : 2016-02-20
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: user_management.php,v 0.10 2016-02-20 Silver Surfer
*
***************************************************************************/

include("../../includes/common.php");
include("../../includes/admin.php"); 

$start = microtime(true);

$sql_users = $mysqli->query("SELECT * FROM users 
						  WHERE userid REGEXP '^[0-9].*' ORDER BY users.userid")
						  or die ("Couldn't query users Database");	
	
while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH))
{
	if(empty($nr_users)) 
	{
		$nr_users='';
	}
	
	$nr_users++;
	$email = trim($query_users['email']);

	if ($query_users['join_date']!=='')
	{
		$join_date = convert_timestamp($query_users['join_date']);
	}
	else
	{
	$join_date = "Unknown";
	}

	if ($query_users['last_visit']!=='')
	{
		$last_visit = convert_timestamp($query_users['last_visit']);
	}
	else
	{
		$last_visit = "Unknown";
	}

	$smarty->append('users',
				array('user_id' => $query_users['user_id'],
					  'user_name' => $query_users['userid'],
					  'join_date' => $join_date,
					  'last_visit' => $last_visit,
					  'email' => $email));

	$smarty->assign('nr_users', $nr_users);
}

// Create dropdown values a-z
$az_value = az_dropdown_value(0);
$az_output = az_dropdown_output(0);
		   
$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);
$smarty->assign('az_select', "num");

$time_elapsed_secs = microtime(true) - $start;
$smarty->assign("query_time",$time_elapsed_secs);	

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."user_management.html");
?>
