<?php
/***************************************************************************
 *                                download_format.php
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
 This is the downloads format main page
 ************************************************************************************************
 */
//get all the menu types
$result_download_format = $mysqli->query("SELECT * FROM format");

$rows = $result_download_format->num_rows;
while ($row = $result_download_format->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('download_format', array(
        'format_id' => $row['format_id'],
        'format' => $row['format']
    ));
}
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "download_format.html");

//close the connection
mysqli_free_result($result_download_format);
