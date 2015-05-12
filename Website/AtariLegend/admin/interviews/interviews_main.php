<?
/***************************************************************************
*                                interviews_main.php
*                            ------------------------------
*   begin                : Thursday, July 21, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Start of creation file
*
*   Id: interviews_main.php,v 0.10 21/07/2005 22:17 Gatekeeper
*
***************************************************************************/

//****************************************************************************************
// The main interview page
//**************************************************************************************** 

include("../includes/common.php");
include("../includes/config.php"); 

//Get list of all individuals
$sql_individuals = mysql_query("SELECT * FROM individuals ORDER BY ind_name ASC")
		  		   or die ("Couldn't query indiciduals database");
		
while ($individuals = mysql_fetch_array($sql_individuals))
{
	$smarty->append('individuals',
	    	 array('ind_id' => $individuals['ind_id'],
				   'ind_name' => $individuals['ind_name']));
}

//Get list of individuals who have been interviewed
$sql_individuals2 = mysql_query("SELECT * FROM interview_main
								LEFT JOIN individuals ON (interview_main.ind_id = individuals.ind_id)
								ORDER BY individuals.ind_name ASC")
		  		   or die ("Couldn't query indiciduals database");
		
while ($individuals2 = mysql_fetch_array($sql_individuals2))
{
	$smarty->append('individuals_interviewed',
	    	 array('ind_id' => $individuals2['ind_id'],
				   'ind_name' => $individuals2['ind_name']));
}


if ( isset($action) and $action == 'search' )
{
if ( $individual_search == " " or $individual_search == '-' )
{
	//show all
	$sql_interview = mysql_query("SELECT * FROM interview_main 
								  LEFT JOIN interview_text on (interview_main.interview_id = interview_text.interview_id)
								  LEFT JOIN users on ( interview_main.member_id = users.user_id )
								  LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
								  LEFT JOIN individual_text on (interview_main.ind_id = individual_text.ind_id)
								  ORDER BY individuals.ind_name ASC")
			  		   or die ("Couldn't query database for interviews");
	}
	else
	{
	$sql_interview = mysql_query("SELECT * FROM interview_main 
								  LEFT JOIN interview_text on (interview_main.interview_id = interview_text.interview_id)
								  LEFT JOIN users on ( interview_main.member_id = users.user_id )
								  LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
								  LEFT JOIN individual_text on (interview_main.ind_id = individual_text.ind_id)
								  WHERE individuals.ind_id = '$individual_search'
								  ORDER BY individuals.ind_name ASC")
			  		   or die ("Couldn't query database for interviews");
	}

	//get the number of interviews in the archive
	$v_interviews = get_rows($sql_interview);
	$message = 'Your search query resulted in ';
	$message .= $v_interviews;
	$message .= ' hits';
	$smarty->assign("message",$message);
	
	while ($interview = mysql_fetch_array($sql_interview))
	{
	
	//The interviewed person's picture
	if ( $interview['ind_imgext'] == 'png' or  
		 $interview['ind_imgext'] == 'jpg' or 
		 $interview['ind_imgext'] == 'gif')
	{
		$v_ind_image  = $individual_screenshot_path;
		$v_ind_image .= $interview['ind_id'];
		$v_ind_image .= '.';
		$v_ind_image .= $interview['ind_imgext'];
	}
	else
	{
		$v_ind_image = "none";
	}
	
	$interview_date = convert_timestamp($interview['interview_date']);
	
	$interview_text = $interview['interview_intro'];
	$interview_text = nl2br($interview_text);
	$interview_text = InsertALCode($interview_text);
	$interview_text = InsertSmillies($interview_text);
	
	$smarty->append('interview',
	    	 array('user_id' => $interview['userid'],
			 	   'user_email' => $interview['email'],
				   'interview_id' => $interview['interview_id'],
				   'ind_id' => $interview['ind_id'],
				   'ind_name' => $interview['ind_name'],
				   'ind_photo' => $v_ind_image,
				   'interview_date' => $interview_date,
				   'interview_text' => $interview_text));
}
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('interviews_main_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
