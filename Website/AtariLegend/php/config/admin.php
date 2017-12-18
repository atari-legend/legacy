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


//this include is a shortcut. I wanted to visitors also to be able to do bugreports at cpanel level.
//But I did not want to include this file in every single page, so I placed the include here.
include("../../common/tiles/tile_bug_report.php");


//This is the actual authorization check
if (login_check($mysqli) == false) {
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
