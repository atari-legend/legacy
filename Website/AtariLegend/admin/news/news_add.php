<?php
/***************************************************************************
*                                news_add.php
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
				
$sql_newsimage = mysql_query("SELECT news_image_id,news_image_name FROM news_image ORDER BY news_image_name");
				
while ($newsimages = mysql_fetch_array($sql_newsimage))
{
	$smarty->append('news_images',
	    	 array('image_id' => $newsimages['news_image_id'],
				   'image_name' => $newsimages['news_image_name']));
}


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
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('news_add_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>
