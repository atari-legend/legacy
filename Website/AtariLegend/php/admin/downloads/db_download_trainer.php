<?php
/***************************************************************************
 *                                db_download_trainer.php
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
include("../../config/admin_rights.php");
//update the trainer options
if (isset($trainer_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE trainer_options SET trainer_options = '$trainer_name' WHERE trainer_options_id = $trainer_id") or die("Couldn't Update the trainer options table");

    $_SESSION['edit_message'] = "Trainer option succesfully updated";

    create_log_entry('Trainer', $trainer_id, 'Trainer', $trainer_id, 'Update', $_SESSION['user_id']);

    header("Location: ../downloads/download_trainer_edit.php?trainer_id=$trainer_id");
}

if (isset($trainer_id) and isset($action) and $action == 'delete_trainer') {
    // first see if this trainer is used for a download
    $sql = $mysqli->query("SELECT * FROM game_download_trainer
            WHERE trainer_options_id = '$trainer_id'") or die("error selecting downloads");
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This trainer option is still used for certain downloads';
    } else {
        create_log_entry('Trainer', $trainer_id, 'Trainer', $trainer_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM trainer_options WHERE trainer_options_id = $trainer_id") or die("Failed to delete trainer option");

        $_SESSION['edit_message'] = "Trainer option succesfully deleted";
    }
    header("Location: ../downloads/download_trainer.php");
}

if (isset($action) and $action == 'insert_trainer') {
    if ($trainer_name == '') {
        $_SESSION['edit_message'] = "Please fill in a trainer option name";
        header("Location: ../downloads/download_trainer.php");
    } else {
        $sql_download_trainer = $mysqli->query("INSERT INTO  trainer_options (trainer_options) VALUES ('$trainer_name')") or die("error inserting trainer option");

        $new_trainer_id = $mysqli->insert_id;

        create_log_entry('Trainer', $new_trainer_id, 'Trainer', $new_trainer_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "trainer option succesfully inserted";
        header("Location: ../downloads/download_trainer.php");
    }
}
