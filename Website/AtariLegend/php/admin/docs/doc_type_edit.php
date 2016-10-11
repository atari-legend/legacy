<?php
/***************************************************************************
*                                doc_type_edit.php
*                            --------------------------
*   begin                : October 11, 2016
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
This is the doc search list page
************************************************************************************************
*/
//Check if we seclected a menu type
if	($doc_type_id == '-' or $doc_type_id == ' ')
{
	$_SESSION['edit_message'] = "Please select a doc type";
	header("Location: ../docs/doc_type.php");
}
else
{
	//get all the doc types for dropdown
	$sql_doc_type = "SELECT * FROM doc_type";

	$result_doc_type= $mysqli->query($sql_doc_type);

	$rows = $result_doc_type->num_rows;
	while ( $row=$result_doc_type->fetch_array(MYSQLI_BOTH) ) 
	{  
		$smarty->append('doc_type',
		 array('doc_type_id' => $row['doc_type_id'],
			   'doc_type_name' => $row['doc_type_name']));	
	}	
	$smarty->assign("user_id",$_SESSION['user_id']);

	$sql_doc_type_edit = "SELECT * FROM doc_type WHERE doc_type_id = $doc_type_id";
	$result_doc_type_edit= $mysqli->query($sql_doc_type_edit) or die ("error getting doc type");

	while ( $row=$result_doc_type_edit->fetch_array(MYSQLI_BOTH) ) 
	{
		$smarty->assign('doc_type_edit',
		array('doc_type_id_edit' => $row['doc_type_id'],
			  'doc_type_name_edit' => $row['doc_type_name']));	
	}

	//Send all smarty variables to the templates
	$smarty->display("file:".$cpanel_template_folder."doc_type_edit.html");
}

//close the connection
mysqli_free_result($result_doc_type);	
?>
