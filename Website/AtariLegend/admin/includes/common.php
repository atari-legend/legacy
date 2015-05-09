<?php
/*******************************************************************************
*                                common.php
*                            -----------------------
*   begin                : 2005-01-06
*   copyright            : (C) 2005 Atari Legend
*   email                : atarizone@atarizone.com
*
*   Id: common.php,v 0.10 2005/01/06 23:30 Silver
*
********************************************************************************

*********************************************************************************
*In here we call all common includes and variables ... We also check on sessions!
*********************************************************************************/

extract($_REQUEST);
date_default_timezone_set('UTC');

include("../includes/connect.php");
include("../includes/config.php");
include("../includes/config_smarty.php");
include("../includes/functions.php"); 
include("../includes/user_functions.php");
include("../includes/constants.php");
include("../includes/karma.php");

//Check if the user is logged on to the site
sec_session_start();

if (login_check($mysqli) == false) {

	header("Location: ../../front/front.php");
}

if ($_SESSION['permission']!==1)
{
	
	echo $_SESSION['permission']; echo "<br>";
	exit("You don't have permission to enter the control panel");
}

$time_users = time() - (5*60);	

	$query_onlineusers = mysql_query("SELECT userid, user_id FROM users WHERE last_visit > '$time_users'");

while ($fetch_onlineusers = mysql_fetch_array($query_onlineusers))
{

$smarty->append('onlineusers',
	      array('user_name' => $fetch_onlineusers['userid'],
		  		'user_id' => $fetch_onlineusers['user_id']));
}

//Send the var to the template files
//$smarty->assign('logged_in', $logged_in); comment this out, don't know what it is for.
$smarty->assign('username', $_SESSION['userid']);
?>
