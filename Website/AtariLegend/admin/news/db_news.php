<?php
/***************************************************************************
*                                db_news_add.php
*                            -----------------------
*   begin                : Sunday, may 1 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : creation of file
*							 
*							
*
*
***************************************************************************/

/*
***********************************************************************************
In this section we can add a news update to the DB
***********************************************************************************
*/

include("../includes/common.php");

if (isset($action) and $action=="add_news")
//****************************************************************************************
// This is where we add the actual news to the submission table
//**************************************************************************************** 
{
	$news_date = time();

	// Check if form is filled.
	if ($headline=='' or $descr=='')
	{
		$message = "Please fill in the necessary fields";
	}
	else
	{	
		// Insert the description and the image into the news_image table.
		$sdbquery = mysql_query("INSERT INTO news_submission 
							(news_headline,news_text,news_image_id,user_id,news_date)
							 VALUES ('$headline','$descr','$icon','$user_id','$news_date')")
							 or die ("Error inserting news update");
							 
		$message = "News added correctly";
					
		mysql_close();
	}
	
	$smarty->assign('message', $message);
	header("Location: ../news/news_add.php");
}

//****************************************************************************************
// This is where we will approve the news. Deleting it from the submission table and adding 
// it to the news page
//**************************************************************************************** 	

if (isset($action) and $action=="approve_submission")
{

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

	header("Location: ../news/news_edit_all.php");
}


//********************************************************************************************
// This is where we will delete unapproved news. It will be deleted from the submission table
//******************************************************************************************** 

if (isset($action) and $action=="delete_submission")
	
{
	mysql_query("delete from
	  			 news_submission 
				 WHERE news_submission_id='$news_submission_id'")
	or die("Deletion of the unapproved news update failed!");

	header("Location: ../news/news_approve.php");	
}

//Edit news posts
if (isset($action) and $action=="update_news")
{

		$news_text = addslashes($news_text);

		//Actual news thread change
		mysql_query("UPDATE 
					news SET 
					news_headline='$news_headline', 
					news_text='$news_text',
					news_image_id='$news_image_id'
					WHERE news_id='$news_id'")
		 	or die("The update failed news");
	
		$message = "News thread updated correctly";
		$smarty->assign('message', $message );

	header("Location: ../news/news_edit.php?news_id=$news_id");
}

//Edit news submissions
if (isset($action) and $action=="update_submission")
{

		$news_text = addslashes($news_text);

		//Its a submission
		mysql_query("UPDATE 
					news_submission SET 
					news_headline='$news_headline', 
					news_text='$news_text',
					news_image_id='$news_image_id'
					WHERE news_submission_id='$news_submission_id'")
		 	or die("The update failed submission");
	
		$message = "News submission updated correctly";
		$smarty->assign('message', $message );


	header("Location: ../news/news_edit.php?news_submission_id=$news_submission_id");
}


//close the connection
mysql_close();
?>
