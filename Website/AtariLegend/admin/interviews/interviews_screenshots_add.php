<?php
/***************************************************************************
*                                interviews_screenshots_add.php
*                            -------------------------------------
*   begin                : Saturday, July 30 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id:  interviews_screenshots_add.php,v 0.10 2005/07/30 23:07 Gatekeeper
*
***************************************************************************/

//****************************************************************************************
// This is the image selection/upload screen for the interviews
//**************************************************************************************** 

include("../includes/common.php");

//If we are uploading new screenshots
if ( $action == 'add_screens' )
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
}

//If we pressed the delete screenshot link
if ( $action == 'delete_screen' )
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
}

//Get the screenshots for this interview, if they exist
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_interview
			   		  			LEFT JOIN screenshot_main ON (screenshot_interview.screenshot_id = screenshot_main.screenshot_id)
								WHERE screenshot_interview.interview_id = '$interview_id' ORDER BY screenshot_interview.screenshot_id")
				   or die ("Database error - selecting screenshots");

//get the number of screenshots in the archive
$v_screenshots = get_rows($sql_screenshots);
$smarty->assign("screenshots_nr",$v_screenshots);

$count = 1;

while ( $screenshots=$sql_screenshots->fetch_array(MYSQLI_BOTH)) 
{
	// Get the image dimensions for the pop up window
	$imginfo = getimagesize("$interview_screenshot_path$screenshots[screenshot_id].$screenshots[imgext]");
	$width = $imginfo[0]+20;
	$height = $imginfo[1]+25;
				
	$smarty->append('screenshots',
	    	 array('count' => $count,
			 	   'width' => $width,
				   'height' => $height,
				   'path' => $interview_screenshot_path,
				   'id' => $screenshots['screenshot_id']));

	$count++;
} 

//we need to get the data of the loaded interview
$sql_interview = $mysqli->query("SELECT * FROM interview_main
						   	  LEFT JOIN interview_text ON ( interview_main.interview_id = interview_text.interview_id ) 
						   	  LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
							  WHERE interview_main.interview_id = '$interview_id'")
				  or die ("Database error - selecting interview data");

while ($interview = $sql_interview->fetch_array(MYSQLI_BOTH))
{	
	$smarty->assign('interview',
	    	 array('interview_id' => $interview_id,
				   'interview_ind_name' => $interview['ind_name'],
				   'interview_author' => $interview['member_id'],
				   'interview_ind_id' => $interview['ind_id']));
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('interviews_screenshots_add_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysqli_close($mysqli);
