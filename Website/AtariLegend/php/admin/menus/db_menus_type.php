<?php
/***************************************************************************
 *                                db_menus_type.php
 *                            -----------------------
 *   begin                : September 04, 2016
 *   copyright            : (C) 2005 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : creation of file
 *
 ***************************************************************************/

// We are using the action var to separate all the queries.
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

//update the menu type
if (isset($menus_type_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE menu_types_main SET menu_types_text = '$menus_type_name' WHERE menu_types_main_id = $menus_type_id") or die('Error: ' . mysqli_error($mysqli));

    $_SESSION['edit_message'] = "Menu type succesfully updated";

    create_log_entry('Menu type', $menus_type_id, 'Menu type', $menus_type_id, 'Update', $_SESSION['user_id']);

    header("Location: ../menus/menus_type_edit.php?menu_type_id=$menus_type_id");
}

if (isset($menus_type_id) and isset($action) and $action == 'delete_menus_type') {
    // first see if this menu type is used for a menu set or menu disk
    $sql = $mysqli->query("SELECT * FROM menu_disk_title
            WHERE menu_types_main_id = '$menus_type_id'") or die('Error: ' . mysqli_error($mysqli));
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This menu type is linked to menu disks';
    } else {
        $sql = $mysqli->query("SELECT * FROM menu_type
              WHERE menu_types_main_id = '$menus_type_id'") or die('Error: ' . mysqli_error($mysqli));
        if ($sql->num_rows > 0) {
            $_SESSION['edit_message'] = 'Deletion failed - This menu type is linked to a menu set';
        } else {
            create_log_entry('Menu type', $menus_type_id, 'Menu type', $menus_type_id, 'Delete', $_SESSION['user_id']);

            $mysqli->query("DELETE FROM menu_types_main WHERE menu_types_main_id = $menus_type_id") or die('Error: ' . mysqli_error($mysqli));

            $_SESSION['edit_message'] = "Menu type succesfully deleted";
        }
    }
    header("Location: ../menus/menus_type.php");
}

if (isset($action) and $action == 'insert_type') {
    if ($type_name == '') {
        $_SESSION['edit_message'] = "Please fill in a menu type name";
        header("Location: ../menus/menus_type.php");
    } else {
        $sql_individuals = $mysqli->query("INSERT INTO  menu_types_main (menu_types_text) VALUES ('$type_name')") or die('Error: ' . mysqli_error($mysqli));

        $new_menu_type_id = $mysqli->insert_id;

        create_log_entry('Menu type', $new_menu_type_id, 'Menu type', $new_menu_type_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "menu type succesfully inserted";
        header("Location: ../menus/menus_type.php");
    }
}
