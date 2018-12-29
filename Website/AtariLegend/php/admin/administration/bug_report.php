<?php
/***************************************************************************
*                              bug_report.html
*                            --------------------------
*   begin                : September 12, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: bug_report.html,v 0.10 2017/09/12 ST Graveyard
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 What bugs or remarks have been posted by users?
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../admin/games/quick_search_games.php");
include("../../config/admin.php");

$sql_bug_report = $mysqli->query("SELECT * FROM bug_report
    LEFT JOIN bug_report_type ON (bug_report.bug_report_type_id = bug_report_type.bug_report_type_id)
    LEFT JOIN users ON (bug_report.user_id = users.user_id)
    ORDER BY bug_report_date ASC");

while ($query_bug_report = $sql_bug_report->fetch_array(MYSQLI_BOTH)) {
    $bug_report_text = nl2br($query_bug_report['bug_report_text']);
    $bug_report_text = stripslashes($bug_report_text);

    $bug_report_date = date("F j, Y", $query_bug_report['bug_report_date']);

    $smarty->append('bug_report', array(
        'bug_report_id' => $query_bug_report['bug_report_id'],
        'bug_report_type' => $query_bug_report['bug_report_type'],
        'bug_report_text' => $bug_report_text,
        'bug_report_date' => $bug_report_date,
        'user_id' => $query_bug_report['user_id'],
        'userid' => $query_bug_report['userid']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "bug_report.html");
