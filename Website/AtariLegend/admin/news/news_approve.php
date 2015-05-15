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

if (isset($action) and $action=="approve")
{
//****************************************************************************************
// This is where we will approve the news. Deleting it from the submission table and adding 
// it to the news page
//**************************************************************************************** 	
	include("../includes/functions_search.php");

	$sql_submission = "SELECT
					  news_headline,
					  news_text,
					  news_image_id,
					  user_id,
					  news_date
					  FROM news_submission WHERE news_submission_id = '$news_submission_id'";
					  
	$query_submission = mysql_query($sql_submission) or die("Couldn't find the submitted news!");
	
	list($news_headline,$news_text,$news_image_id,$user_id,$news_date) = mysql_fetch_array($query_submission);
	
	$news_headline = addslashes($news_headline);
	$news_text = addslashes($news_text);
	
	// Insert the news story.
	mysql_query("INSERT INTO news (news_headline,news_text,news_image_id,user_id,news_date) VALUES ('$news_headline','$news_text','$news_image_id','$user_id','$news_date')")
		or die ("DOES NOT COMPUTE...DOES NOT COMPUTE...DOES NOT COMPUTE");

	mysql_query("DELETE FROM news_submission WHERE news_submission_id='$news_submission_id'")
		or die ("Couldn't kill news_submission!!!");
				
	$NEWS = mysql_query("SELECT news_id FROM news ORDER BY news_id desc")
		or die ("Database error - selecting news_id");
		
	$newsid = mysql_fetch_row($NEWS);				

	$mode="post";
		
	add_search_words($mode, $newsid[0], $news_text, $news_headline);
}



if (isset($action) and $action=="delete")
//********************************************************************************************
// This is where we will delete unapproved news. It will be deleted from the submission table
//******************************************************************************************** 	
{
	mysql_query("delete from
	  			 news_submission 
				 WHERE news_submission_id='$news_submission_id'")
	or die("Deletion of the unapproved news update failed!");	
}



//********************************************************************************************
// Get all the needed data to load the submission page!
//******************************************************************************************** 	
$sql_submissions = mysql_query("SELECT 
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
	while ($submission = mysql_fetch_array($sql_submissions))
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
mysql_close();
?>
