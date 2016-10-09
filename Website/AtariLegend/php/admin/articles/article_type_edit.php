<?php
/***************************************************************************
*                                article_type_eit.php
*                            --------------------------
*   begin                : October 10, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*						   Created file
*  
***************************************************************************/

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php"); 

/*
************************************************************************************************
This is the article search list page
************************************************************************************************
*/

//Check if we seclected an article type
if	($article_type_id == '-' or $article_type_id == ' ')
{
	$_SESSION['edit_message'] = "Please select an article type";
	header("Location: ../articles/article_type.php");
}
else
{
	//get all  the article types for dropdown
	$sql_article_type = "SELECT * FROM article_type";

	$result_article_type= $mysqli->query($sql_article_type);

	$rows = $result_article_type->num_rows;
	while ( $row=$result_article_type->fetch_array(MYSQLI_BOTH) ) 
	{  
		$smarty->append('article_type',
		 array('article_type_id' => $row['article_type_id'],
			   'article_type' => $row['article_type']));	
	}	
	$smarty->assign("user_id",$_SESSION['user_id']);

	$sql_article_type_edit = "SELECT * FROM article_type WHERE article_type_id = $article_type_id";
	$result_article_type_edit= $mysqli->query($sql_article_type_edit) or die ("error getting article type");

	while ( $row=$result_article_type_edit->fetch_array(MYSQLI_BOTH) ) 
	{
		$smarty->assign('article_type_edit',
		array('article_type_id_edit' => $row['article_type_id'],
			  'article_type_edit' => $row['article_type']));	
	}

	//Send all smarty variables to the templates
	$smarty->display("file:".$cpanel_template_folder."article_type_edit.html");
}

//close the connection
mysqli_free_result($result_menus_type);	
?>
