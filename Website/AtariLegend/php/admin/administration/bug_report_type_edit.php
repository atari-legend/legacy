<?php
/***************************************************************************
 *                                bug_report_type_edit.php
 *                            --------------------------
 *   begin                : Monday, September 11, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: bug_report_type_edit.php,v 0.10 2017/09/11 23:22 Gatekeeper
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

/*
 ************************************************************************************************
 This is the types edit page
 ************************************************************************************************
 */
//Check if we selected a bug report type
if ($type_id == '-' or $type_id == ' ') {
    $_SESSION['edit_message'] = "Please select a type";
    header("Location: ../administration/bug_report_type.php");
} else {
    //get all the menu types for dropdown
    $result_type = $mysqli->query("SELECT * FROM bug_report_type");

    $rows = $result_type->num_rows;
    while ($row = $result_type->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('type', array(
            'type_id' => $row['bug_report_type_id'],
            'type' => $row['bug_report_type']
        ));
    }
    $smarty->assign("user_id", $_SESSION['user_id']);

    $result_bug_report_type_edit = $mysqli->query("SELECT * FROM bug_report_type WHERE bug_report_type_id = $type_id")
        or die("error getting type");

    while ($row = $result_bug_report_type_edit->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('type_edit', array(
            'type_id_edit' => $row['bug_report_type_id'],
            'type_edit' => $row['bug_report_type']
        ));
    }

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "bug_report_type_edit.html");
}

//close the connection
mysqli_free_result($result_type);
