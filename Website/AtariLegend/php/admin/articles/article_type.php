<?php
/***************************************************************************
*                                article_type.php
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
//get all the menu types
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

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."article_type.html");

//close the connection
mysqli_free_result($result_menus_type);	
?>