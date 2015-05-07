<?php

/*******************************************************************************
*                                user_logout.php
*                            -----------------------
*   begin                : 2015-04-28
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*
*   Id: user_logout.php,v 0.10 2015-04-28
*
********************************************************************************

*********************************************************************************
* user logout script
*********************************************************************************/

include_once("../includes/user_functions.php");

sec_session_start();
 
// Unset all session values 
$_SESSION = array();
 
// get session parameters 
$params = session_get_cookie_params();
 
// Delete the actual cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// Destroy session 
session_destroy();
header('Location: ../front/front.php');
?>
