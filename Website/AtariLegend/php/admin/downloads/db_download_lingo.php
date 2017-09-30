<?php
/***************************************************************************
 *                                db_download_lingo.php
 *                            ----------------------------
 *   begin                : March 15, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : creation of file
 *
 ***************************************************************************/

// We are using the action var to separate all the queries.
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

//update the download lingo
if (isset($lingo_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE lingo SET lingo_name = '$lingo_name', lingo_short = '$lingo_short' WHERE lingo_id = $lingo_id") or die("Couldn't Update the download lingo");

    $_SESSION['edit_message'] = "Lingo succesfully updated";

    create_log_entry('Lingo', $lingo_id, 'Lingo', $lingo_id, 'Update', $_SESSION['user_id']);

    header("Location: ../downloads/download_lingo_edit.php?lingo_id=$lingo_id");
}

if (isset($lingo_id) and isset($action) and $action == 'delete_lingo') {
    // first see if this lingo is used for a download
    $sql = $mysqli->query("SELECT * FROM game_download_lingo
            WHERE lingo_id = '$lingo_id'") or die("error selecting downloads");
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This lingo is still used for certain downloads';
    } else {
        create_log_entry('Lingo', $lingo_id, 'Lingo', $lingo_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM lingo WHERE lingo_id = $lingo_id") or die("Failed to delete lingo");

        $_SESSION['edit_message'] = "Lingo succesfully deleted";
    }
    header("Location: ../downloads/download_lingo.php");
}

if (isset($action) and $action == 'insert_lingo') {
    if ($lingo_name == '') {
        $_SESSION['edit_message'] = "Please fill in a lingo name";
        header("Location: ../downloads/download_lingo.php");
    } else {
        $sql_download_lingo = $mysqli->query("INSERT INTO  lingo (lingo_name, lingo_short) VALUES ('$lingo_name', '$lingo_short')") or die("error inserting lingo");

        $new_lingo_id = $mysqli->insert_id;

        create_log_entry('Lingo', $new_lingo_id, 'Lingo', $new_lingo_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Download lingo succesfully inserted";
        header("Location: ../downloads/download_lingo.php");
    }
}
