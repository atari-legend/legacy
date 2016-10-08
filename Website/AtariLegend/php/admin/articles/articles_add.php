<?php
/***************************************************************************
*                               articles_add.php
*                            ----------------------------
*   begin                : friday, October 8, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: articles_add.php,v 0.10 2016/10/08 22:52 ST Graveyard
*					- AL 2.0
*
***************************************************************************/

//****************************************************************************************
// This is the article add page. Overhere you can add a new article
//**************************************************************************************** 

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php"); 

//****************************************************************************************
//first we check if there is a title selected. This is done at the main page
//****************************************************************************************

if ( $article_title == '' )
{
	$_SESSION['edit_message'] = 'Please choose a title to the article';
	
	$smarty->assign("user_id",$_SESSION['user_id']);
	
	//Send all smarty variables to the templates
	header("Location: ../articles/articles_main.php");
}
//****************************************************************************************
//This piece of code is used to open up a blank article add canvas (before we actually 
//add it to the DB)
//****************************************************************************************
else
{
//get the types		
$sql_types = $mysqli->query("SELECT article_type_id,article_type FROM article_type")
			  or die ("Database error - getting the article types");
        
while ( $article_types=$sql_types->fetch_array(MYSQLI_BOTH) )
{
	$smarty->append('article_types',
	    	 array('article_type_id' => $article_types['article_type_id'],
				   'article_type' => $article_types['article_type']));
}		   

//Get the authors for the interview
$sql_author = $mysqli->query("SELECT user_id,userid FROM users")
			  or die ("Database error - getting members name");
        
while ( $authors=$sql_author->fetch_array(MYSQLI_BOTH) )
{
	$smarty->append('authors',
	    	 array('user_id' => $authors['user_id'],
				   'user_name' => $authors['userid']));
}	

$smarty->assign("article_title",$article_title);	   

$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."articles_add.html");
}

//close the connection
mysqli_close($mysqli);
