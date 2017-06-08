<?php
/*******************************************************************************
*                                user_process_logout.php
*                            ------------------------------
*   begin                : 2017-06-02
*   copyright            : (C) 2017 Atari Legend
*
*   Id: user_process_logout.php, v 0.10 2017-06-02 Gatekeeper
*
********************************************************************************

*********************************************************************************
* User logout process
*********************************************************************************/
//************************************************************************
// This is the logout code - kill the sessionvars and undo the cookie
//************************************************************************

include_once("../../lib/user_functions.php");

sec_session_start();

// Unset all session values
$_SESSION = array();

// get session parameters
//$params = session_get_cookie_params();

// Delete the actual cookie.
//setcookie("cooksession", session_id(), time()-60*60*24*100, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
setcookie("cooksession", session_id(), time()-60*60*24*100, "/");

// Destroy session
session_destroy();

header('Location: ../../main/front/front.php');

mysql_close();
?>
