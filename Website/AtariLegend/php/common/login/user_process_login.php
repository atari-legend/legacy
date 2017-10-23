<?php

/*******************************************************************************
*                                user_process_login.php
*                            ------------------------------
*   begin                : 2015-04-28
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*
*   Id: user_process_login.php, v 0.10 2015-04-28 Silver Surfer
*
********************************************************************************

*********************************************************************************
* User login process
*********************************************************************************/

include("../../config/common.php");

//Do the md5/sha512 stuff first - check if the password is correct
//I don't think this is relevant anymore
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

//Check the password, log in and add cookie if person has 'remember me' function active
if (isset($_POST['userid'], $_POST['p'])) {
    $userid = $_POST['userid'];
    $password = $_POST['p']; // The hashed password.

    //fill the session vars
    if (login($userid, $password, $mysqli) == true) {
        // Login success     
        if (isset($remember_me) && $remember_me == '1')
        {
            // get session parameters
            //$params = session_get_cookie_params();

            // Delete the actual cookie.
            //setcookie("cooksession", session_id(), time()+60*60*24*100, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            setcookie("cooksession", session_id(), time()+60*60*24*100, "/");
			$session_id = session_id();
            
            //update the table with the session id
            $sdbquery = $mysqli->query("UPDATE users SET session = '$session_id' WHERE userid = '$userid'") or die("Couldn't Update user table with session id");; 
        }    
        //header('Location: ../../main/front/front.php');
        $_SESSION['edit_message'] = "Log in succesfull";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        // Login failed
        // check the cause - is the user inactive?
        $sql_inactive = $mysqli->query("SELECT * FROM users WHERE userid = '$userid'");
        $query_inactive = $sql_inactive->fetch_array(MYSQLI_BOTH);
        if ($query_inactive['inactive'] == 1 )
        {    
            //header('Location: ../../main/front/front.php?error=2');
            $_SESSION['edit_message'] = 'User is set inactive - contact admin';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else
        {
            $_SESSION['edit_message'] = 'Usn or pwd incorrect - Please try again';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            //header('Location: ../../main/front/front.php?error=1');
        }       
    }
} else {
    // The correct POST variables were not sent to this page.
   //header('Location: ../../main/front/front.php?error=1');
   $_SESSION['edit_message'] = 'Usn or pwd incorrect - Please try again';
   header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
