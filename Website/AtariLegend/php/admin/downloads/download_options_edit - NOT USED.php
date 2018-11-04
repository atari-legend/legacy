<?php
/***************************************************************************
 *                                download_options_edit.php
 *                            ---------------------------------
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
 This is the options edit page
 ************************************************************************************************
 */
//Check if we seclected a menu type
if ($option_id == '-' or $option_id == ' ') {
    $_SESSION['edit_message'] = "Please select an option";
    header("Location: ../downloads/download_options.php");
} else {
    //get all the menu types for dropdown
    $result_option = $mysqli->query("SELECT * FROM download_options");

    $rows = $result_option->num_rows;
    while ($row = $result_option->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('option', array(
            'option_id' => $row['download_options_id'],
            'option' => $row['download_option']
        ));
    }
    $smarty->assign("user_id", $_SESSION['user_id']);

    $result_option_edit = $mysqli->query("SELECT * FROM download_options WHERE download_options_id = $option_id") or die("error getting option");

    while ($row = $result_option_edit->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('option_edit', array(
            'option_id_edit' => $row['download_options_id'],
            'option_edit' => $row['download_option']
        ));
    }

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "download_options_edit.html");
}

//close the connection
mysqli_free_result($result_option);
