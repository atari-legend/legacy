<?php
/*******************************************************************************
*                                common.php
*                            -----------------------
*   begin                : Tuesday, february 11, 2004
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: common.php,v 0.10 2004/02/11 23:30 Gatekeeper
*
********************************************************************************

*********************************************************************************
*In here we call all comon includes and variables ... We also check on sessions!
*********************************************************************************/

//D.Wetherilt
//20140915
// No longer valid
//import_request_variables('GPC'); 
// will replace with this for now:
extract($_REQUEST);

include("connect.php"); 
include("config_smarty.php");
include("functions.php"); 
include("functions_session.php");
include("constants.php");
include("config.php");

//Check if the user is logged on to the site
if(!session_id())
{
	session_start();
}

$logged_in = checkLogin();

if (SITESTATUS=="offline") {

		if ($_SESSION['permission']!=="1"){
			
			header("Location: ".SITEURL."blank.php");
			
			}
}

//Send the var to the template files
$smarty->assign('logged_in', $logged_in);
if(isset($_SESSION['username']))
{ 
	$smarty->assign('username', $_SESSION['username']);
}
?>
