<?php

/*******************************************************************************
*                                user_process_login.php
*                            -----------------------
*   begin                : 2015-04-28
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*
*   Id: user_process_login.php,v 0.10 2015-04-28
*
********************************************************************************

*********************************************************************************
* User login process
*********************************************************************************/

include("../includes/common.php"); 

//Do the md5 stuff first
if (isset($_POST['userid'], $_POST['pmd5'])) {
    $userid = $_POST['userid'];
    $md5_password = $_POST['pmd5']; // The md5 hashed password.
    $password = $_POST['p']; // The hashed password.

	if(md5_test($userid, $md5_password, $password, $mysqli) == true) {
        // md5 success 
        //echo "<br>All went good";
    	} else {
        // md5 failed 
        //echo "<br>Something went wrong";
    	}
}

if (isset($_POST['userid'], $_POST['p'])) {
    $userid = $_POST['userid'];
    $password = $_POST['p']; // The hashed password.
 
    if (login($userid, $password, $mysqli) == true) {
        // Login success 
        header('Location: ../front/front.php');
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}
?>
