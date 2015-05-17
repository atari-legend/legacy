<?php
/***************************************************************************
*                                news_approve.php
*                            ---------------------------
*   begin                : Thursday, May 5, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*							 
*							
*
*   Id: news_approve.php,v 0.10 2004/05/05 ST Graveyard
*
***************************************************************************/
/*
***********************************************************************************
In this section we can approve a news update.
***********************************************************************************
*/

include("../includes/common.php");

//********************************************************************************************
// Get all the needed data to load the submission page!
//******************************************************************************************** 	
$sql_submissions = $mysqli->query("SELECT 
				  			  news_submission_id,
				  			  news_headline,
				  			  news_text,
				    		  news_submission.news_image_id,
				  			  user_id,
				  			  news_date,
				  			  news_image_ext
				  			  FROM news_submission 
				  			  LEFT JOIN news_image ON (news_submission.news_image_id = news_image.news_image_id)
				  			  ORDER BY news_date");

$num_submissions = get_rows ($sql_submissions);

if ($num_submissions=='0')
{
	$smarty->assign("nr_submissions",'0');
}
else
{
	while ($submission = $sql_submissions->fetch_array(MYSQLI_BOTH))
	{
		$user_name = get_username_from_id($submission['user_id']);
		$news_date = convert_timestamp($submission['news_date']);
		$news_text = InsertALCode($submission['news_text']);
		$news_text = InsertSmillies($news_text);
		$news_text = nl2br($news_text);
		
		$v_image  = $news_images_path;
		$v_image .= $submission['news_image_id'];
		$v_image .= '.';
		$v_image .= $submission['news_image_ext'];
	
		$smarty->append('news_submissions',
    		 	array('news_userid' => $user_name,
					  'news_submission_id' => $submission['news_submission_id'],
					  'news_headline' => $submission['news_headline'],
				   	  'news_date' => $news_date,
					  'news_text' => $news_text,
				  	  'news_icon' => $v_image ));
	}
	
	$smarty->assign("nr_submissions",$num_submissions);
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('news_approve_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysqli_close($mysqli);
?>
