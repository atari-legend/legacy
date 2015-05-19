<?php
/***************************************************************************
*                                interviews_delete.php
*                            --------------------------
*   begin                : friday, July 21, 2005
*   copyright            : (C) 2004 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: interviews_delete.php,v 0.10 2005/07/21 1647 ST Graveyard
*
***************************************************************************/

//*************************************************************************
// Delete the interview and return to the interview page
//*************************************************************************

//load all common functions
include("../includes/common.php"); 

$sql = $mysqli->query("DELETE FROM interview_main WHERE interview_id = '$interview_id' ");
$sql = $mysqli->query("DELETE FROM interview_text WHERE interview_id = '$interview_id' ");

//delete the comments at every screenshot for this review
	$SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_interview where interview_id = '$interview_id' ")
			      or die ("Database error - getting screenshots");
        
		while ($screenshotrow=$SCREENSHOT->fetch_row())
		{
			$sql = $mysqli->query("DELETE FROM interview_comments WHERE screenshot_interview_id = $screenshotrow[0] ");
		}

//delete the screenshots
	$SCREENSHOT2 = $mysqli->query("SELECT * FROM screenshot_interview where interview_id = '$interview_id' ")
			  	   or die ("Database error - getting screenshots");
        
		while ( $screenshotrow=$SCREENSHOT2->fetch_row() )
		{
			//get the extension 
			$SCREENSHOT_ext = $mysqli->query("SELECT * FROM screenshot_main
	   								   WHERE screenshot_id = $screenshotrow[2]")
			  			  	  or die ("Database error - selecting screenshots");
		
			$screenshotrow_ext = $SCREENSHOT_ext->fetch_array(MYSQLI_BOTH);
			$screenshot_ext_type = $screenshotrow_ext['imgext'];
						
			$sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = $screenshotrow[2] ");

			$new_path = $interview_screenshot_path;
			$new_path .= $screenshotrow[2];
			$new_path .= ".";
			$new_path .= $screenshot_ext_type;
			
			unlink ("$new_path");
		}
		
$sql = $mysqli->query("DELETE FROM screenshot_interview WHERE interview_id = '$interview_id' ");

	header("Location: ../interviews/interviews_main.php");

?>
