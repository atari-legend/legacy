<?php
/***************************************************************************
*                                menus_type.php
*                            --------------------------
*   begin                : September 04, 2016
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
This is the menus search list page
************************************************************************************************
*/
//get all the menu types
$result_menus_type= $mysqli->query("SELECT * FROM menu_types_main");

$rows = $result_menus_type->num_rows;
while ( $row=$result_menus_type->fetch_array(MYSQLI_BOTH) )
{
    $smarty->append('menus_type',
     array('menu_types_main_id' => $row['menu_types_main_id'],
           'menu_type_text' => $row['menu_types_text']));
}
$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."menus_type.html");

//close the connection
mysqli_free_result($result_menus_type);
?>
