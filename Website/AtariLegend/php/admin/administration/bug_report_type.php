<?php
/***************************************************************************
 *                                bug_report_type.php
 *                            --------------------------
 *   begin                : Monday, September 11, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: bug_report_type.php,v 0.10 2017/09/11 23:22 Gatekeeper
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the bug report type page
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//get all the bug report types
$result_bug_report_type = $mysqli->query("SELECT * FROM bug_report_type") or die ("problem getting bug report types");

while ($row = $result_bug_report_type->fetch_array(MYSQLI_BOTH)) {

    $smarty->append('bug_report_types', array(
        'bug_report_type_id' => $row['bug_report_type_id'],
        'bug_report_type' => $row['bug_report_type']
    ));
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "bug_report_type.html");

//close the connection
mysqli_free_result($result_bug_report_type);
