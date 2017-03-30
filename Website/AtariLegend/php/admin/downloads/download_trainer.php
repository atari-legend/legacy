<?php
/***************************************************************************
 *                                download_trainer.php
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
 This is the downloads language main page
 ************************************************************************************************
 */
//get all the menu types
$result_download_trainer = $mysqli->query("SELECT * FROM trainer_options") or die ("problem getting trainer options");

$rows = $result_download_trainer->num_rows;
while ($row = $result_download_trainer->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('download_trainer', array(
        'trainer_id' => $row['trainer_options_id'],
        'trainer_name' => $row['trainer_options']
    ));
}
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "download_trainer.html");

//close the connection
mysqli_free_result($result_download_trainer);
