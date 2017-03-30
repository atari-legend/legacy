<?php
/***************************************************************************
 *                                download_lingo.php
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
 This is the downloads language main page
 ************************************************************************************************
 */
//get all the menu types
$result_download_lingo = $mysqli->query("SELECT * FROM lingo") or die ("problem getting language");

$rows = $result_download_lingo->num_rows;
while ($row = $result_download_lingo->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('download_lingo', array(
        'lingo_id' => $row['lingo_id'],
        'lingo_name' => $row['lingo_name']
    ));
}
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "download_lingo.html");

//close the connection
mysqli_free_result($result_download_lingo);
