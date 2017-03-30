<?php
/***************************************************************************
 *                                db_download_tos.php
 *                            ----------------------------
 *   begin                : March 16, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : creation of file
 *
 ***************************************************************************/

// We are using the action var to separate all the queries.
include("../../config/common.php");
include("../../config/admin.php");

//update the download tos
if (isset($tos_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE tos_version SET tos_version = '$tos_name' WHERE tos_version_id = $tos_id") or die("Couldn't Update the TOS version table");

    $_SESSION['edit_message'] = "TOS version succesfully updated";

    create_log_entry('TOS', $tos_id, 'TOS', $tos_id, 'Update', $_SESSION['user_id']);

    header("Location: ../downloads/download_tos_edit.php?tos_id=$tos_id");
}

if (isset($tos_id) and isset($action) and $action == 'delete_tos') {
    // first see if this tos is used for a download
    $sql = $mysqli->query("SELECT * FROM game_download_tos
            WHERE tos_version_id = '$tos_id'") or die("error selecting downloads");
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This tos is still used for certain downloads';
    } else {
        create_log_entry('TOS', $tos_id, 'TOS', $tos_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM tos_version WHERE tos_version_id = $tos_id") or die("Failed to delete tos");

        $_SESSION['edit_message'] = "TOS version succesfully deleted";
    }
    header("Location: ../downloads/download_tos.php");
}

if (isset($action) and $action == 'insert_tos') {
    if ($tos_name == '') {
        $_SESSION['edit_message'] = "Please fill in a tos name";
        header("Location: ../downloads/download_tos.php");
    } else {
        $sql_download_tos = $mysqli->query("INSERT INTO  tos_version (tos_version) VALUES ('$tos_name')") or die("error inserting tos");

        $new_tos_id = $mysqli->insert_id;

        create_log_entry('TOS', $new_tos_id, 'TOS', $new_tos_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "TOS version succesfully inserted";
        header("Location: ../downloads/download_tos.php");
    }
}
