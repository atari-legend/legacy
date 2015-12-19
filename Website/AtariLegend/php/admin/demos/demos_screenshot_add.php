<?php
/********************************************************************************
 *                                demos_screenshots_add.php
 *                            ---------------------------------
 *   begin                : wednesday, november 10, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *	 actual update        : Creation of file
 *
 *   Id: demos_screenshots_add.php,v 0.10 2005/11/10 13:26 ST Gravegrinder
 *
 *********************************************************************************/

//****************************************************************************************
// This is the image selection/upload screen for the demos
//**************************************************************************************** 

include("../../includes/common.php");

//Get the screenshots for this demo, if they exist
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_demo
			   		  			LEFT JOIN screenshot_main ON (screenshot_demo.screenshot_id = screenshot_main.screenshot_id)
								WHERE screenshot_demo.demo_id = '$demo_id' ORDER BY screenshot_demo.screenshot_id")
				   or die ("Database error - selecting screenshots");

$count = 1;
$v_screenshots =1;
while ( $screenshots=$sql_screenshots->fetch_array(MYSQLI_BOTH)) 
{
	$demo_screenshot_image = $demo_screenshot_path;
	$demo_screenshot_image .= $screenshots['screenshot_id'];
	$demo_screenshot_image .= ".";
	$demo_screenshot_image .= $screenshots['imgext'];

	$smarty->append('screenshots',
	    	 array('count' => $count,
				   'demo_screenshot_image' => $demo_screenshot_image,
				   'id' => $screenshots['screenshot_id']));

	$count++;
	$v_screenshots++;
}

$smarty->assign("screenshots_nr",$v_screenshots);

//Get the demo data
$sql_demo = $mysqli->query("SELECT * FROM demo WHERE demo_id = '$demo_id'")
			   	   or die ("Database error - selecting demo");

while ( $demo=$sql_demo->fetch_array(MYSQLI_BOTH)) 
{
	$smarty->assign("demo_id",$demo['demo_id']);
	$smarty->assign("demo_name",$demo['demo_name']);
}

$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/demos_screenshot_add.html');

//close the connection
mysqli_close($mysqli);
