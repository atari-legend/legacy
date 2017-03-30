<?php
/***************************************************************************
 *                                download_tos_edit.php
 *                            --------------------------
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
 This is the tos edit page
 ************************************************************************************************
 */
if ($tos_id == '-' or $tos_id == ' ') {
    $_SESSION['edit_message'] = "Please select a TOS version";
    header("Location: ../downloads/download_tos.php");
} else {
    //get all the languages for dropdown
    $result_tos = $mysqli->query("SELECT * FROM tos_version");

    $rows = $result_tos->num_rows;
    while ($row = $result_tos->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('tos', array(
            'tos_id' => $row['tos_version_id'],
            'tos_name' => $row['tos_version']
        ));
    }
    $smarty->assign("user_id", $_SESSION['user_id']);

    $result_tos_edit = $mysqli->query("SELECT * FROM tos_version WHERE tos_version_id = $tos_id") or die("error getting tos");

    while ($row = $result_tos_edit->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('tos_edit', array(
            'tos_id_edit' => $row['tos_version_id'],
            'tos_name_edit' => $row['tos_version']
        ));
    }

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "download_tos_edit.html");
}

//close the connection
mysqli_free_result($result_tos);
