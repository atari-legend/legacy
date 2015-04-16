<?php
/***************************************************************************
*                                who_is_it_tile.php
*                            ----------------------------
*   begin                : Thurrsday, April 16, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id:   who_is_it_tile.php,v 0.1 2015/04/16 22:29 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the 'who is it' tile
//*********************************************************************************************

//Select a random interview record
$query_interview = mysql_query("SELECT  
								   interview_main.interview_id,
								   interview_text.interview_intro,	
								   individuals.ind_id,
								   individuals.ind_name,
								   individual_text.ind_imgext,
								   users.userid						   
						   FROM interview_main
						   LEFT JOIN interview_text ON (interview_main.interview_id = interview_text.interview_id) 
						   LEFT JOIN individuals ON (interview_main.ind_id = individuals.ind_id) 
						   LEFT JOIN individual_text ON (individuals.ind_id = individual_text.ind_id)
						   LEFT JOIN users ON (interview_main.member_id = users.user_id)
						   WHERE individual_text.ind_imgext <> ' '
						   ORDER BY RAND() LIMIT 1") or die("query error, who_is_it");  

$sql_interview = mysql_fetch_array($query_interview); 

//Get the dataElements we want to place on screen

$v_ind_image  = $individual_screenshot_path;
$v_ind_image .= $sql_interview['ind_id'];
$v_ind_image .= '.';
$v_ind_image .= $sql_interview['ind_imgext'];
	
$smarty->assign('who_is_it',
    	 array('ind_id' => $sql_interview['ind_id'],
		 	   'ind_name' => $sql_interview['ind_name'],
		 	   'ind_img' => $v_ind_image,
			   'int_id' => $sql_interview['interview_id'],
			   'int_text' => $sql_interview['interview_intro'],
			   'int_userid' => $sql_interview['userid']));
?>