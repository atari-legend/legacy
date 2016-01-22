<?php
/***************************************************************************
*                                skin_switcher.php
*                            --------------------------
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*						   
*
***************************************************************************/

//Skin Switching functions

extract($_REQUEST);
date_default_timezone_set('UTC');

// Report all PHP errors
error_reporting(-1);

include("../../includes/connect.php"); 
include("../../includes/config_smarty.php");
include("../../includes/functions.php"); 
include("../../includes/user_functions.php");
include("../../includes/constants.php");
include("../../includes/config.php");

//Check if the user is logged on to the site
sec_session_start();

//create skin switch links dynamically with called page
//using the filter command, this should be a safe way of using PHP_SELF

//Let's see if the user has choosen a skin and set the skin in session
if (isset($action) and $action == "skinswitch")
{
	if (isset($skin))
	{
		$_SESSION['skin'] = $skin;
	}
}

?>
