<?php
/***************************************************************************
*                                doc_type.php
*                            --------------------------
*   begin                : October 11, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : admin@atarilegend.com
*                          Created file
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
//get all the menu types
$result_doc_type= $mysqli->query("SELECT * FROM doc_type");

$rows = $result_doc_type->num_rows;
while ( $row=$result_doc_type->fetch_array(MYSQLI_BOTH) )
{
    $smarty->append('doc_type',
     array('doc_type_id' => $row['doc_type_id'],
           'doc_type_name' => $row['doc_type_name']));
}
$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."doc_type.html");

//close the connection
mysqli_free_result($result_doc_type);
?>
