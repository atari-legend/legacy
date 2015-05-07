<?
/***************************************************************************
*                                interviews_edit.php
*                            --------------------------
*   begin                : Saturday, July 22 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id: interviews_edit.php,v 0.10 2005/07/22 13:40 Gatekeeper
*
***************************************************************************/

//****************************************************************************************
// This is the interview edit page. Overhere you can edit an existing interview
//**************************************************************************************** 

include("../includes/common.php");

//If the delete comment has been triggered
if ( isset($action) and $action == 'delete_comment' )
{
	$sql_interviewshot = mysql_query("SELECT * FROM screenshot_interview
	   					   			  	WHERE interview_id = $interview_id 
										AND screenshot_id = $screenshot_id")
	     		  or die ("Database error - selecting screenshots interview");
						
	$interviewshot = mysql_fetch_row($sql_interviewshot);
	$interviewshotid = $interviewshot[0];
	
	//delete the screenshot comment from the DB table
	$sdbquery = mysql_query("DELETE FROM interview_comments WHERE screenshot_interview_id = $interviewshotid") 
				or die ("Error deleting comment");
				
	//get the extension 
	$SCREENSHOT = mysql_query("SELECT * FROM screenshot_main
	   					  	  WHERE screenshot_id = '$screenshot_id'")
				  or die ("Database error - selecting screenshots");
		
	$screenshotrow = mysql_fetch_array($SCREENSHOT);
	$screenshot_ext = $screenshotrow[imgext];

	$sql = mysql_query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
	$sql = mysql_query("DELETE FROM screenshot_interview WHERE screenshot_id = '$screenshot_id' ");

	$new_path = $interview_screenshot_path;;
	$new_path .= $screenshot_id;
	$new_path .= ".";
	$new_path .= $screenshot_ext;

	unlink ("$new_path");
	
	$message = 'Screenshot and comment deleted succesfully';
	$smarty->assign("message",$message);
}

//If the Update interview has been triggered
if ( isset($action) and $action == 'Update_Interview' )
{
	//First, we'll be filling up the main interview table
	$sdbquery = mysql_query("UPDATE interview_main SET member_id = $members, ind_id = $individual
							 WHERE interview_id = $interview_id")
				or die("Couldn't Update into interview_main");
	
	// first we have to convert the date vars into a time stamp to be inserted to review_date
	$date = date_to_timestamp($Date_Year,$Date_Month,$Date_Day);
	
	$sdbquery = mysql_query("UPDATE interview_text SET interview_text = '$textfield', interview_date = '$date', interview_intro = '$textintro', interview_chapters = '$textchapters' WHERE interview_id = $interview_id") 
				or die("Couldn't update into interview_text");

	//we're gonna add the screenhots into the screenshot_interview table and fill up the interview_comment table.
	//We need to loop on the screenshot table to check the shots used. If a comment field is filled,
	//the screenshot was used!
	$SCREEN = mysql_query("SELECT * FROM screenshot_interview where interview_id = '$interview_id' ORDER BY screenshot_id ASC")
	   		  or die ("Database error - getting screenshots");
				
    $i=0;
	while ( $screenrow=mysql_fetch_row($SCREEN) )
	{
		if($inputfield[$i] != "")
		{
			//fill the comments table
			$screenid = $screenrow[0];
			$comment = $inputfield[$i];
			
			$interviewshotid = $screenrow[0];
					
			//check if comment already exists for this shot
			$INTERVIEWCOMMENT = mysql_query("SELECT * FROM interview_comments where screenshot_interview_id = $interviewshotid")
						        or die ("Database error - selecting screenshot interview comment");
					
			$number = mysql_num_rows($INTERVIEWCOMMENT);
					
			if ($number > 0)
			{
				$sdbquery = mysql_query("UPDATE interview_comments SET comment_text = '$comment'
										 WHERE screenshot_interview_id = $interviewshotid")
							or die("Couldn't update interview_comments");
			}
			else
			{
				$sdbquery = mysql_query("INSERT INTO interview_comments (screenshot_interview_id, comment_text) VALUES ($interviewshotid, '$comment')")
							or die("Couldn't insert into interview_comments");
			}
		}
		$i++;
	}

	$message = "Interview updated succesfully";
	$smarty->assign("message",$message);
}


//Get the individuals
$sql_individuals = mysql_query("SELECT * FROM individuals ORDER BY ind_name ASC")
		  		   or die ("Couldn't query indiciduals database");
		
while ($individuals = mysql_fetch_array($sql_individuals))
{
	$smarty->append('individuals',
	    	 array('ind_id' => $individuals['ind_id'],
				   'ind_name' => $individuals['ind_name']));
}


//Get the authors for the interview
$sql_author = mysql_query("SELECT user_id,userid FROM users")
			  or die ("Database error - getting members name");
        
while ( $authors=mysql_fetch_array($sql_author) )
{
	$smarty->append('authors',
	    	 array('user_id' => $authors['user_id'],
				   'user_name' => $authors['userid']));
}				   


//we need to get the data of the loaded interview
$sql_interview = mysql_query("SELECT * FROM interview_main
						   	  LEFT JOIN interview_text ON ( interview_main.interview_id = interview_text.interview_id ) 
						   	  LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
							  WHERE interview_main.interview_id = '$interview_id'")
				  or die ("Database error - selecting interview data");

while ($interview = mysql_fetch_array($sql_interview))
{	
	$smarty->assign('interview',
	    	 array('interview_date' => $interview['interview_date'],
			 	   'interview_id' => $interview_id,
				   'interview_intro' => $interview['interview_intro'],
				   'interview_chapters' => $interview['interview_chapters'],
				   'interview_text' => $interview['interview_text'],
				   'interview_ind_name' => $interview['ind_name'],
				   'interview_author' => $interview['member_id'],
				   'interview_ind_id' => $interview['ind_id']));
}

//Let's get the screenshots for the interview
$sql_screenshots = mysql_query("SELECT * FROM screenshot_interview 
								LEFT JOIN screenshot_main on ( screenshot_interview.screenshot_id = screenshot_main.screenshot_id )
								WHERE screenshot_interview.interview_id = '$interview_id' ORDER BY screenshot_interview.screenshot_id ASC")
		 		   or die ("Database error - getting screenshots & comments");

//get the number of screenshots in the archive
$v_screeshots = get_rows($sql_screenshots);
$smarty->assign("screenshots_nr",$v_screeshots);

$count = 1;
					  
while ($screenshots = mysql_fetch_array($sql_screenshots))
{	
	
	$v_int_image  = $interview_screenshot_path;
	$v_int_image .= $screenshots['screenshot_id'];
	$v_int_image .= '.';
	$v_int_image .= $screenshots['imgext'];
	
	//We need to get the comments with each screenshot
	$sql_comments = mysql_query("SELECT * FROM interview_comments 
								 WHERE screenshot_interview_id	= $screenshots[screenshot_interview_id]")
					or die ("Database error - getting screenshots comments");
	
	$comments=mysql_fetch_array($sql_comments);
	
	$smarty->append('screenshots',
	    	 array('interview_screenshot' => $v_int_image,
			 	   'interview_screenshot_id' => $screenshots['screenshot_id'],
			 	   'interview_screenshot_count' => $count,
				   'interview_screenshot_comment' => $comments['comment_text']));
				   
	$count=$count+1;
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('interviews_edit_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
