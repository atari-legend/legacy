<?php
/***************************************************************************
 *                                db_menu_set.php
 *                            -----------------------
 *   begin                : june 06, 2015
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 ***************************************************************************/

// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/menus/db_menu_functions.php");
require_once __DIR__."/../../common/DAO/MenuSetDAO.php";
//include("../../config/admin_rights.php"); /*--> We can not use it like this because of the ajax. redirecting does not
// work correctly with the inheritance of Ajax.

//This is used for the AJAX parts when user rights do not suffice
$osd_message = 'You do not have the necessary authorizations to perform this action';

$menusetDao = new AL\Common\DAO\MenuSetDAO($mysqli);

//****************************************************************************************
// Add new menu set
//****************************************************************************************

if ($action == "menu_set_new") {
    include("../../config/admin_rights.php");
    if (isset($menu_sets_name)) {
        $new_menu_set_id = $menusetDao->addNewMenuSet($menu_sets_name);

        create_log_entry('Menu set', $new_menu_set_id, 'Menu set', $new_menu_set_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "New Menu Set added";
    }

    header("Location: ../menus/menus_list.php");
}

//****************************************************************************************
// Edit menu_set name
//****************************************************************************************
if ($action == "menu_set_name_update") {
    include("../../config/admin_rights.php");
    if (isset($menu_sets_id) and $menu_sets_name !== "") {
        $menusetDao = new AL\Common\DAO\MenusSetDAO($mysqli);
        $new_Menusetname = $menusetDao->updateMenuSetName($menu_sets_id, $menu_sets_name);

        create_log_entry('Menu set', $menu_sets_id, 'Menu set', $menu_sets_id, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Menu Set Name updated!";
    }
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// Connect crew to menu set
//****************************************************************************************
if ($action == "menu_set_crew_set") {
    include("../../config/admin_rights.php");
    if (isset($crew_id) and ($crew_id == !"") and isset($menu_sets_id)) {
        $menusetDao->addCrewToMenuSet($crew_id, $menu_sets_id);
        $_SESSION['edit_message'] = "Crew hooked to this Menu disk series";

        create_log_entry('Menu set', $menu_sets_id, 'Crew', $crew_id, 'Insert', $_SESSION['user_id']);
    }

    if ($crew_id == "") {
        $_SESSION['edit_message'] = "Please select a crew";
    }

    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// Connect individual to menu set
//****************************************************************************************
if ($action == "menu_set_ind_set") {
    include("../../config/admin_rights.php");
    if (isset($ind_id) and ($ind_id == !"") and isset($menu_sets_id)) {
        $menusetDao->addIndividualToMenuSet($ind_id, $menu_sets_id);
        $_SESSION['edit_message'] = "Individual hooked to this Menu disk series";

        create_log_entry('Menu set', $menu_sets_id, 'Individual', $ind_id, 'Insert', $_SESSION['user_id']);
    }

    if ($ind_id == "") {
        $_SESSION['edit_message'] = "Please select an individual";
    }

    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// Connect menu type to menu set
//****************************************************************************************
if ($action == "menu_set_type_set") {
    include("../../config/admin_rights.php");
    if (isset($menu_type_browse) and ($menu_type_browse == !"") and isset($menu_sets_id)) {
        $menusetDao->addMenuTypeToMenuSet($menu_types_main_id = $menu_type_browse, $menu_sets_id);

        $_SESSION['edit_message'] = "Menu set hooked to this Menu disk series";

        create_log_entry('Menu set', $menu_sets_id, 'Menu type', $menu_type_browse, 'Insert', $_SESSION['user_id']);
    }

    if ($menu_type_browse == "") {
        $_SESSION['edit_message'] = "Please select a menu set";
    }
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// This is delete crew from menu set
//****************************************************************************************
if ($action == "delete_crew_from_menu_set") {
    include("../../config/admin_rights.php");
    if (isset($crew_id) and isset($menu_sets_id)) {
        $menusetDao->removeCrewFromMenuSet($crew_id, $menu_sets_id);

        create_log_entry('Menu set', $menu_sets_id, 'Crew', $crew_id, 'Delete', $_SESSION['user_id']);
    }

    $_SESSION['edit_message'] = "Crew removed from Menu set";
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// This is the delete menu type from menu set
//****************************************************************************************
if ($action == "delete_menu_type_from_menu_set") {
    include("../../config/admin_rights.php");
    if (isset($menu_type_id) and isset($menu_sets_id)) {
        $menusetDao->removeMenuTypeFromMenuSet($menu_type_id, $menu_sets_id);
        create_log_entry('Menu set', $menu_sets_id, 'Menu type', $menu_type_id, 'Delete', $_SESSION['user_id']);
    }
    $_SESSION['edit_message'] = "Menu type removed from Menu set";
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// This is delete individuel from menu set
//****************************************************************************************
if ($action == "delete_ind_from_menu_set") {
    include("../../config/admin_rights.php");
    if (isset($ind_id) and isset($menu_sets_id)) {
        create_log_entry('Menu set', $menu_sets_id, 'Individual', $ind_id, 'Delete', $_SESSION['user_id']);
        $menusetDao->removeIndividualFromMenuSet($ind_id, $menu_sets_id);
    }

    $_SESSION['edit_message'] = "Individual removed from Menu set";
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// Delete menu set
//****************************************************************************************
if (isset($action) and ($action == "delete_set")) {
    include("../../config/admin_rights.php");
    //when deleting a set, we only check for menu disks
    $sql = $mysqli->query("SELECT * FROM menu_disk WHERE menu_sets_id='$menu_sets_id'")
        or die('Error: ' . mysqli_error($mysqli));
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = "This set still has menu disks linked to it. Delete them first.";
        header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
    } else {
        create_log_entry('Menu set', $menu_sets_id, 'Menu set', $menu_sets_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE from menu_set WHERE menu_sets_id='$menu_sets_id'")
            or die('Error: ' . mysqli_error($mysqli));
        $mysqli->query("DELETE from crew_menu_prod WHERE menu_sets_id='$menu_sets_id'")
            or die('Error: ' . mysqli_error($mysqli));
        $mysqli->query("DELETE from ind_menu_prod WHERE menu_sets_id='$menu_sets_id'")
            or die('Error: ' . mysqli_error($mysqli));
        $_SESSION['edit_message'] = "Menuset completely removed";

        //Send all smarty variables to the templates
        header("Location: ../menus/menus_list.php");
    }
}

//****************************************************************************************
// Publish menu set
//****************************************************************************************
if (isset($action) and ($action == "publish_set")) {
    include("../../config/admin_rights.php");
    if ($online == 'online') {
        $sql = $mysqli->query("UPDATE menu_set SET publish='1'
            WHERE menu_sets_id='$menu_sets_id'");

        $_SESSION['edit_message'] = "Menu set online";
        header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
    } else {
        $sql = $mysqli->query("UPDATE menu_set SET publish='0'
            WHERE menu_sets_id='$menu_sets_id'");

        $_SESSION['edit_message'] = "Menu set offline";
        header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
    }
}
