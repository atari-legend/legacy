<?php
/***************************************************************************
*                                user_search.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: user_search.php,v 0.10 2005/05/01 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
User search script
***********************************************************************************
*/
// include common variables and functions
include("../includes/common.php");

	// Build the query for the user search
	if ($userbrowse == 'num' or empty($userbrowse) and empty($usersearch))
	{
	$userbrowse_select = "userid REGEXP '^[0-9].*'";
	}
	elseif ($userbrowse == 'a' or $userbrowse == 'b' or $userbrowse == 'c' or $userbrowse == 'd' or $userbrowse == 'e' or $userbrowse == 'f' or $userbrowse == 'g' or $userbrowse == 'h' or $userbrowse == 'i' or $userbrowse == 'j' or $userbrowse == 'k' or $userbrowse == 'l' or $userbrowse == 'm' or $userbrowse == 'n' or $userbrowse == 'o' or $userbrowse == 'p' or $userbrowse == 'q' or $userbrowse == 'r' or $userbrowse == 's' or $userbrowse == 't' or $userbrowse == 'u' or $userbrowse == 'v' or $userbrowse == 'w' or $userbrowse == 'x' or $userbrowse == 'y' or $userbrowse == 'z')
	{
	$userbrowse_select = "userid LIKE '$userbrowse%'";
	}
	elseif (isset($usersearch))
	{
	$userbrowse_select = "userid LIKE '%$usersearch%'";
	}
	
		$sql_users = $mysqli->query("SELECT * FROM users 
		  						  WHERE ". $userbrowse_select ." ORDER BY users.userid")
		 		   		 		  or die ("Couldn't query users Database");
	
	while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH))
	{
	
	if(empty($nr_users)) {$nr_users='';}
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
						  	  'user_website' => $query_users['user_website'],
							  'join_date' => $join_date,
							  'last_visit' => $last_visit,
							  'email' => $email));

		$smarty->assign('nr_users', $nr_users);
	}

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/user_search.html');
?>
