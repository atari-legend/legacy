<?php
/***************************************************************************
 *                                download_tos.php
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
 This is the downloads tos main page
 ************************************************************************************************
 */
//get all the menu types
$result_download_tos = $mysqli->query("SELECT * FROM tos_version") or die ("problem getting tos version");

$rows = $result_download_tos->num_rows;
while ($row = $result_download_tos->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('download_tos', array(
        'tos_id' => $row['tos_version_id'],
        'tos_name' => $row['tos_version']
    ));
}
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "download_tos.html");

//close the connection
mysqli_free_result($result_download_tos);
