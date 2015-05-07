<?
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
include("../includes/config.php"); 

$sql = mysql_query("DELETE FROM interview_main WHERE interview_id = '$interview_id' ");
$sql = mysql_query("DELETE FROM interview_text WHERE interview_id = '$interview_id' ");

//delete the comments at every screenshot for this review
	$SCREENSHOT = mysql_query("SELECT * FROM screenshot_interview where interview_id = '$interview_id' ")
			      or die ("Database error - getting screenshots");
        
		while ( $screenshotrow=mysql_fetch_row($SCREENSHOT) )
		{
			$sql = mysql_query("DELETE FROM interview_comments WHERE screenshot_interview_id = $screenshotrow[0] ");
		}

//delete the screenshots
	$SCREENSHOT2 = mysql_query("SELECT * FROM screenshot_interview where interview_id = '$interview_id' ")
			  	   or die ("Database error - getting screenshots");
        
		while ( $screenshotrow=mysql_fetch_row($SCREENSHOT2) )
		{
			//get the extension 
			$SCREENSHOT_ext = mysql_query("SELECT * FROM screenshot_main
	   								   WHERE screenshot_id = $screenshotrow[2]")
			  			  	  or die ("Database error - selecting screenshots");
		
			$screenshotrow_ext = mysql_fetch_array($SCREENSHOT_ext);
			$screenshot_ext_type = $screenshotrow_ext[imgext];
						
			$sql = mysql_query("DELETE FROM screenshot_main WHERE screenshot_id = $screenshotrow[2] ");

			$new_path = $interview_screenshot_path;
			$new_path .= $screenshotrow[2];
			$new_path .= ".";
			$new_path .= $screenshot_ext_type;
			
			unlink ("$new_path");
		}
		
$sql = mysql_query("DELETE FROM screenshot_interview WHERE interview_id = '$interview_id' ");

//Get the individuals when redirecting to main page
$sql_individuals = mysql_query("SELECT * FROM individuals ORDER BY ind_name ASC")
		  		   or die ("Couldn't query indiciduals database");
		
while ($individuals = mysql_fetch_array($sql_individuals))
{
	$smarty->append('individuals',
	    	 array('ind_id' => $individuals[ind_id],
				   'ind_name' => $individuals[ind_name]));
}

mysql_close(); 

$message = "Interview deleted succesfully";
$smarty->assign("message",$message);

$smarty->assign("user_id",$_SESSION[user_id]);
$smarty->assign('interviews_main_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');