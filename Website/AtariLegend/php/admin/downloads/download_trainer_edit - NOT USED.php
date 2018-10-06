<?php
/***************************************************************************
 *                                download_trainer_edit.php
 *                            --------------------------------
 *   begin                : March 16, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : admin@atarilegend.com
 *                          Created file
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

/*
 ************************************************************************************************
 This is the trainer edit page
 ************************************************************************************************
 */
if ($trainer_id == '-' or $trainer_id == ' ') {
    $_SESSION['edit_message'] = "Please select a trainer option";
    header("Location: ../downloads/download_trainer.php");
} else {
    //get all the languages for dropdown
    $result_trainer = $mysqli->query("SELECT * FROM trainer_options");

    $rows = $result_trainer->num_rows;
    while ($row = $result_trainer->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('trainer', array(
            'trainer_id' => $row['trainer_options_id'],
            'trainer_name' => $row['trainer_options']
        ));
    }
    $smarty->assign("user_id", $_SESSION['user_id']);

    $result_trainer_edit = $mysqli->query("SELECT * FROM trainer_options WHERE trainer_options_id = $trainer_id") or die("error getting trainer");

    while ($row = $result_trainer_edit->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('trainer_edit', array(
            'trainer_id_edit' => $row['trainer_options_id'],
            'trainer_name_edit' => $row['trainer_options']
        ));
    }

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "download_trainer_edit.html");
}

//close the connection
mysqli_free_result($result_trainer);
