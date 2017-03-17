<?php
/***************************************************************************
 *                                download_options.php
 *                            --------------------------
 *   begin                : Thursday, March 16, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: download_options.php,v 0.10 2017/03/16 14:25 Gatekeeper
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the download options page 
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//get all the download options
$result_download_options = $mysqli->query("SELECT * FROM download_options") or die ("problem getting download options");

$rows = $result_download_options->num_rows;
while ($row = $result_download_options->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('download_options', array(
        'download_options_id' => $row['download_options_id'],
        'download_option' => $row['download_option']
    ));
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "download_options.html");

//close the connection
mysqli_free_result($result_download_options);
