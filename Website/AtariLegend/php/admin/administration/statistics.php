<?php
/***************************************************************************
*                                statistics.php
*                            -----------------------
*   begin                : Friday, Oct 03, 2003
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	Website images added, 
*							 
*							
*
*   Id: statistics.php,v 0.10 2003/10/03 23:00 Silver Surfer
*	Update: 2015/05/29 23:38 ST Graveyard 
*			- Added logged on user details
*
***************************************************************************/

include("../../includes/common.php"); 
include("../administration/main_stats.php");

//*******************************
// Get the user stats		
//*******************************
//Lets get all the date of the selected user
$sql_users = $mysqli->query("SELECT * FROM users 
						  WHERE user_id = '" . $_SESSION['user_id'] . "' ")
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


/* //****************************************
// Get the data for the quick game search		
//****************************************
//Get publisher values to fill the searchfield
$sql_publisher = $mysqli->query("SELECT pub_dev.pub_dev_id,
									 pub_dev.pub_dev_name
									 FROM game_publisher
									 LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
									 GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
									 ORDER BY pub_dev.pub_dev_name ASC") 
								or die("Problems retriving values from publishers.");

while ($company_publisher = $sql_publisher->fetch_array(MYSQLI_BOTH))
{

	$smarty->append('company_publisher',
		 array('comp_id' => $company_publisher['pub_dev_id'],
			   'comp_name' => $company_publisher['pub_dev_name']));

}

//Get Developer values to fill the searchfield
$sql_developer = $mysqli->query("SELECT pub_dev.pub_dev_id,
									 pub_dev.pub_dev_name
									 FROM game_developer
									 LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
									 GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
									 ORDER BY pub_dev.pub_dev_name ASC") 
								or die("Problems retriving values from developers.");

while ($company_developer = $sql_developer->fetch_array(MYSQLI_BOTH))
{

	$smarty->append('company_developer',
		 array('comp_id' => $company_developer['pub_dev_id'],
			   'comp_name' => $company_developer['pub_dev_name']));

}

// Create dropdown values a-z
$az_value = az_dropdown_value(0);
$az_output = az_dropdown_output(0);
		   
$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);	 */



//Create the id's for dynamic positioning of the tiles
$smarty->assign('left_nav', 'left_nav_position_front');
$smarty->assign('main_stats', 'main_stats_position_front');
		
//Send all smarty variables to the templates
$smarty->display('extends:../../../templates/html/admin/main.html|../../../templates/html/admin/frontpage.html|../../../templates/html/admin/user_stats.html|../../../templates/html/admin/welcome.html|../../../templates/html/admin/left_nav.html|../../../templates/html/admin/main_stats.html');
?>
