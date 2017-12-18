<?php
/***************************************************************************
 *                                db_download_format.php
 *                            -----------------------
 *   begin                : March 13, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : creation of file
 *
 ***************************************************************************/

// We are using the action var to separate all the queries.
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

//update the download format
if (isset($format_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE format SET format = '$format_name' WHERE format_id = $format_id") or die("Couldn't Update the download format");

    $_SESSION['edit_message'] = "Format succesfully updated";

    create_log_entry('Format', $format_id, 'Format', $format_id, 'Update', $_SESSION['user_id']);

    header("Location: ../downloads/download_format_edit.php?format_id=$format_id");
}

if (isset($format_id) and isset($action) and $action == 'delete_format') {
    // first see if this format is used for a download
    $sql = $mysqli->query("SELECT * FROM download_format
            WHERE format_id = '$format_id'") or die("error selecting downloads");
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This format is still used for certain downloads';
    } else {
        create_log_entry('Format', $format_id, 'Format', $format_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM format WHERE format_id = $format_id") or die("Failed to delete format");

        $_SESSION['edit_message'] = "Format succesfully deleted";
    }
    header("Location: ../downloads/download_format.php");
}

if (isset($action) and $action == 'insert_format') {
    if ($format_name == '') {
        $_SESSION['edit_message'] = "Please fill in a format name";
        header("Location: ../downloads/download_format.php");
    } else {
        $sql_download_format = $mysqli->query("INSERT INTO  format (format) VALUES ('$format_name')") or die("error inserting format");

        $new_format_id = $mysqli->insert_id;

        create_log_entry('Format', $new_format_id, 'Format', $new_format_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Download format succesfully inserted";
        header("Location: ../downloads/download_format.php");
    }
}
