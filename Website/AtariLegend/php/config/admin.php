<?php
/***************************************************************************
*                                admin.php
*                            --------------------------
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*						   
*
***************************************************************************/

//Include this file if you want a page to require admin permission level
//Needs to be included after common.php is included.

if (login_check($mysqli) == false) 
{    
    $_SESSION['edit_message'] = "Please log in to use this functionality";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die('');
}

//if ($_SESSION['permission']==1 or $_SESSION['permission']=='1')
//{
//}else{
//	echo $_SESSION['permission']; echo "<br>";
//	exit("You don't have permission to enter the control panel");
//}
?>
