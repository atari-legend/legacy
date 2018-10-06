<?php
/***************************************************************************
 *                                download_lingo_edit.php
 *                            --------------------------
 *   begin                : March 15, 2017
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
 This is the lingo edit page
 ************************************************************************************************
 */
if ($lingo_id == '-' or $lingo_id == ' ') {
    $_SESSION['edit_message'] = "Please select a language";
    header("Location: ../downloads/download_lingo.php");
} else {
    //get all the languages for dropdown
    $result_lingo = $mysqli->query("SELECT * FROM lingo");

    $rows = $result_lingo->num_rows;
    while ($row = $result_lingo->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('lingo', array(
            'lingo_id' => $row['lingo_id'],
            'lingo_name' => $row['lingo_name'],
            'lingo_short' => $row['lingo_short']
        ));
    }
    $smarty->assign("user_id", $_SESSION['user_id']);

    $result_lingo_edit = $mysqli->query("SELECT * FROM lingo WHERE lingo_id = $lingo_id") or die("error getting lingo");

    while ($row = $result_lingo_edit->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('lingo_edit', array(
            'lingo_id_edit' => $row['lingo_id'],
            'lingo_name_edit' => $row['lingo_name'],
            'lingo_short_edit' => $row['lingo_short']
        ));
    }

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "download_lingo_edit.html");
}

//close the connection
mysqli_free_result($result_lingo);
