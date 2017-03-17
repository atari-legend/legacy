<?php
/***************************************************************************
 *                                download_format_edit.php
 *                            --------------------------
 *   begin                : March 13, 2017
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
 This is the format edit page
 ************************************************************************************************
 */
//Check if we seclected a menu type
if ($format_id == '-' or $format_id == ' ') {
    $_SESSION['edit_message'] = "Please select a format";
    header("Location: ../downloads/download_format.php");
} else {
    //get all the menu types for dropdown
    $result_format = $mysqli->query("SELECT * FROM format");

    $rows = $result_format->num_rows;
    while ($row = $result_format->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('format', array(
            'format_id' => $row['format_id'],
            'format' => $row['format']
        ));
    }
    $smarty->assign("user_id", $_SESSION['user_id']);

    $result_format_edit = $mysqli->query("SELECT * FROM format WHERE format_id = $format_id") or die("error getting format");

    while ($row = $result_format_edit->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('format_edit', array(
            'format_id_edit' => $row['format_id'],
            'format_edit' => $row['format']
        ));
    }

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "download_format_edit.html");
}

//close the connection
mysqli_free_result($result_format);
