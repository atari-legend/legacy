<?php
/***************************************************************************
*                                doc_category.php
*                            --------------------------
*   begin                : October 14, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : admin@atarilegend.com
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
This is the doc category search list page
************************************************************************************************
*/
//get all the menu types
$sql_doc_category = "SELECT * FROM doc_category";

$result_doc_category= $mysqli->query($sql_doc_category);

$rows = $result_doc_category->num_rows;
while ( $row=$result_doc_category->fetch_array(MYSQLI_BOTH) ) 
{  
	$smarty->append('doc_category',
	 array('doc_category_id' => $row['doc_category_id'],
		   'doc_category_name' => $row['doc_category_name']));	
}	
$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."doc_category.html");

//close the connection
mysqli_free_result($result_category_type);	
?>
