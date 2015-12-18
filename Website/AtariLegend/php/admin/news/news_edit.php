<?php
/***************************************************************************
*                                news_edit.php
*                            ---------------------------
*   begin                : Thursday, May 5, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*							 
*							
*
*   Id: news_edit.php,v 0.10 2004/05/05 ST Graveyard
*
***************************************************************************/
//****************************************************************************************
// This is where we can edit submitted news threads
//**************************************************************************************** 	

include("../../includes/common.php");

//This file deal with the editing of the still to approve news threads and the news threads online. 
//When we are dealing with the news_id var, we're talking about newsthreads online, the news_submission_id
//is used for the submitted news threads.

if (empty($news_id))
{
//We're dealing with a submission. Get the actual submission we wanna edit
$sql_news  =  $mysqli->query("SELECT
			  	news_headline,
				news_text,
			  	news_image_id,
			  	user_id,
			  	news_date
			  	FROM news_submission WHERE news_submission_id = '$news_submission_id'");

$news = $sql_news->fetch_array(MYSQLI_BOTH);

$user_name = get_username_from_id($news['user_id']);
$news_date = convert_timestamp($news['news_date']);
//$news_text = InsertALCode($news['news_text']);
//$news_text = InsertSmillies($news_text);
		

$smarty->assign('edit_submissions',
   		array('edit_userid' => $user_name,
			  'edit_submission_id' => $news_submission_id,
			  'edit_headline' => $news['news_headline'],
			  'edit_date' => $news_date,
			  'edit_text' => $news['news_text'],
			  'edit_image_id' => $news['news_image_id']));	



}
else
{
//we're dealing with a news post which has to be altered
$sql_news  =  $mysqli->query("SELECT
			  			   news_headline,
					   	   news_text,
			  			   news_image_id,
			  			   user_id,
			  			   news_date
			  			   FROM news WHERE news_id = '$news_id'");


$news = $sql_news->fetch_array(MYSQLI_BOTH);

$user_name = get_username_from_id($news['user_id']);
$news_date = convert_timestamp($news['news_date']);
//$news_text = InsertALCode($news['news_text']);
//$news_text = InsertSmillies($news_text);
		
$smarty->assign('edit_submissions',
   		array('edit_userid' => $user_name,
			  'edit_id' => $news_id,
			  'edit_headline' => $news['news_headline'],
			  'edit_date' => $news_date,
			  'edit_text' => $news['news_text'],
			  'edit_image_id' => $news['news_image_id']));	
}

//Get the news images
$sql_newsimage = $mysqli->query("SELECT news_image_id,news_image_name FROM news_image ORDER BY news_image_name");
				
while ($newsimages = $sql_newsimage->fetch_array(MYSQLI_BOTH))
{
	$smarty->append('news_images',
	    	 array('image_id' => $newsimages['news_image_id'],
				   'image_name' => $newsimages['news_image_name']));
}

$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/news_edit.html');

//close the connection
mysqli_close($mysqli);
?>
