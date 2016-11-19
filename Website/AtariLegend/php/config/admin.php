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

if (login_check($mysqli) == false) {

	header("Location: ../../main/front/front.php");
}

if ($_SESSION['permission']!==1)
{
	
	echo $_SESSION['permission']; echo "<br>";
	exit("You don't have permission to enter the control panel");
}

?>
