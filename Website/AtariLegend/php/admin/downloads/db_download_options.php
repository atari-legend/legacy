<?php
/***************************************************************************
 *                                db_download_options.php
 *                            ------------------------------
 *   begin                : March 16, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : creation of file
 *
 ***************************************************************************/

// We are using the action var to separate all the queries.
include("../../config/common.php");
include("../../config/admin.php");

//update the download options
if (isset($option_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE download_options SET download_option = '$option_name' WHERE download_options_id = $option_id") or die("Couldn't Update the download option table");

    $_SESSION['edit_message'] = "Option succesfully updated";

    create_log_entry('Option', $option_id, 'Option', $option_id, 'Update', $_SESSION['user_id']);

    header("Location: ../downloads/download_options_edit.php?option_id=$option_id");
}

if (isset($option_id) and isset($action) and $action == 'delete_option') {
    // first see if this option is used for a download
    $sql = $mysqli->query("SELECT * FROM game_download_options
            WHERE download_options_id = '$option_id'") or die("error selecting downloads");
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This option is still used for certain downloads';
    } else {
        create_log_entry('Option', $option_id, 'Option', $option_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM download_options WHERE download_options_id = $option_id") or die("Failed to delete option");

        $_SESSION['edit_message'] = "Option succesfully deleted";
    }
    header("Location: ../downloads/download_options.php");
}

if (isset($action) and $action == 'insert_option') {
    if ($option_name == '') {
        $_SESSION['edit_message'] = "Please fill in an option name";
        header("Location: ../downloads/download_options.php");
    } else {
        $sql_download_option = $mysqli->query("INSERT INTO download_options (download_option) VALUES ('$option_name')") or die("error inserting option");

        $new_option_id = $mysqli->insert_id;

        create_log_entry('Option', $new_option_id, 'Option', $new_option_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Download option succesfully inserted";
        header("Location: ../downloads/download_options.php");
    }
}
