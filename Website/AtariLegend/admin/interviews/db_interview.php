<?php
/***************************************************************************
*                                db_interview.php
*                            -----------------------
*   begin                : Saturday, Sept 24, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : New section.
*						  
*							
*
*   Id: db_crew.php,v 1.10 2005/10/29 Silver Surfer
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../includes/common.php"); 

if ($action=="stop")
{
echo "test";
exit;
}

//****************************************************************************************
// This is the image selection/upload screen for the interviews
//**************************************************************************************** 

//If we are uploading new screenshots
if (isset($action) and $action == 'add_screens')
{

//Here we'll be looping on each of the inputs on the page that are filled in with an image!
$image = $_FILES['image'];

foreach($image['tmp_name'] as $key=>$tmp_name)
{
	if ($tmp_name!=='none')
	
	{
	// Check what extention the file has and if it is allowed.
	
		$ext="";
		$type_image = $image['type'][$key];
		
		// set extension
		if ( $type_image=='image/png')
			{
				$ext='png';
			}
			
		if ( $type_image=='image/x-png')
			{
				$ext='png';
			}
		
		elseif ( $type_image=='image/gif')
			{
				$ext='gif';
			} 
		elseif ( $type_image=='image/pjpeg')
			{
				$ext='jpg';
			} 
		
		 if ($ext!=="")
		 	{
			
		// First we insert the directory path of where the file will be stored... this also creates an autoinc number for us.
		
		$sdbquery = $mysqli->query("INSERT INTO screenshot_main (screenshot_id,imgext) VALUES ('','$ext')")
					or die ("Database error - inserting screenshots");

		//select the newly entered screenshot_id from the main table
		$SCREENSHOT = $mysqli->query("SELECT screenshot_id FROM screenshot_main
	   					   		   ORDER BY screenshot_id desc")
					  or die ("Database error - selecting screenshots");
		
		$screenshotrow = $SCREENSHOT->fetch_row();
		$screenshot_id = $screenshotrow[0];
		
		$sdbquery = $mysqli->query("INSERT INTO screenshot_interview (interview_id, screenshot_id) VALUES ($interview_id, $screenshot_id)")
					or die ("Database error - inserting screenshots2");
		
		// Rename the uploaded file to its autoincrement number and move it to its proper place.
		$file_data = rename($image['tmp_name'][$key], "$interview_screenshot_path$screenshotrow[0].$ext");
		
		chmod("$interview_screenshot_path$screenshotrow[0].$ext", 0777);
		
		}
	}
}

header("Location: ../interviews/interviews_screenshots_add.php?interview_id=$interview_id");

}

//If we pressed the delete screenshot link
if (isset($action) and $action == 'delete_screen')
{
	$sql_interviewshot = $mysqli->query("SELECT * FROM screenshot_interview
	   					   			  WHERE interview_id = $interview_id 
									  AND screenshot_id = $screenshot_id")
	     		  or die ("Database error - selecting screenshots interview");
						
	$interviewshot = $sql_interviewshot->fetch_row();
	$interviewshotid = $interviewshot[0];
	
	//delete the screenshot comment from the DB table
	$sdbquery = $mysqli->query("DELETE FROM interview_comments WHERE screenshot_interview_id = $interviewshotid") 
				or die ("Error deleting comment");
				
	//get the extension 
	$SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
	   					  	  WHERE screenshot_id = '$screenshot_id'")
				  or die ("Database error - selecting screenshots");
		
	$screenshotrow = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
	$screenshot_ext = $screenshotrow['imgext'];

	$sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
	$sql = $mysqli->query("DELETE FROM screenshot_interview WHERE screenshot_id = '$screenshot_id' ");

	$new_path = $interview_screenshot_path;;
	$new_path .= $screenshot_id;
	$new_path .= ".";
	$new_path .= $screenshot_ext;

	unlink ("$new_path");
	
	$message = 'Screenshot (and comment) deleted succesfully';
	$smarty->assign("message",$message);
	
	header("Location: ../interviews/interviews_screenshots_add.php?interview_id=$interview_id");
}
?>

