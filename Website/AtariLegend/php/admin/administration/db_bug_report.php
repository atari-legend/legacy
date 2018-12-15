<?php
/***************************************************************************
*                              db_bug_report.php
*                            --------------------------
*   begin                : September 12, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: db_bug_report.php,v 0.10 2017/09/12 ST Graveyard
 *
 ***************************************************************************/

// This document contain all the code needed to operate the trivia database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

//****************************************************************************************
// Delete did you know quote!
//****************************************************************************************

if (isset($action) and $action == "delete") {
    create_log_entry('Bug', $bug_report_id, 'Bug', $bug_report_id, 'Delete', $_SESSION['user_id']);

    $sql = $mysqli->query("DELETE FROM bug_report WHERE bug_report_id = '$bug_report_id'")
        or die("Couldn't delete bug report text");
    $_SESSION['edit_message'] = "bug report has been deleted";

    header("Location: ../administration/bug_report.php");

    mysqli_close($mysqli);
}
