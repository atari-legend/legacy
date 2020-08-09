<?php
/***************************************************************************
*                                admin_rights.php
*                            --------------------------
*   copyright            : (C) 2017 Atari Legend
*   date                 :  02/09/2017
*
*
***************************************************************************/

//Include this file if you want a page to require admin permission level
//I'm using this file to check if the user has the rights to update the DB (only used in CPANEL)
if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
} else {
    $_SESSION['edit_message'] = "You do not have the necessary authorizations to perform this action";
    //header("Location: ../administration/statistics.php");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die('');
}
