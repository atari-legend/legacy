<?php
/***************************************************************************
*                                menus_type_edit.php
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
//Check if we seclected a menu type
if  ($menu_type_id == '-' or $menu_type_id == ' ')
{
    $_SESSION['edit_message'] = "Please select a menu type";
    header("Location: ../menus/menus_type.php");
}
else
{
    //get all the menu types for dropdown
    $result_menus_type= $mysqli->query("SELECT * FROM menu_types_main");

    $rows = $result_menus_type->num_rows;
    while ( $row=$result_menus_type->fetch_array(MYSQLI_BOTH) )
    {
        $smarty->append('menus_type',
         array('menu_types_main_id' => $row['menu_types_main_id'],
               'menu_type_text' => $row['menu_types_text']));
    }
    $smarty->assign("user_id",$_SESSION['user_id']);

    $result_menus_type_edit= $mysqli->query("SELECT * FROM menu_types_main WHERE menu_types_main_id = $menu_type_id") or die ("error getting menu type");

    while ( $row=$result_menus_type_edit->fetch_array(MYSQLI_BOTH) )
    {
        $smarty->assign('menus_type_edit',
        array('menu_types_main_id_edit' => $row['menu_types_main_id'],
              'menu_type_text_edit' => $row['menu_types_text']));
    }

    //Send all smarty variables to the templates
    $smarty->display("file:".$cpanel_template_folder."menus_type_edit.html");
}

//close the connection
mysqli_free_result($result_menus_type);
?>
