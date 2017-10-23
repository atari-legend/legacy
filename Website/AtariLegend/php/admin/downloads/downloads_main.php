<?php
/***************************************************************************
 *                                downloads_main.php
 *                            --------------------------
 *   begin                : Saturday, March 11, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: downloads_main.php,v 0.10 2017/03/11 22:23 Gatekeeper
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the download browse page where you can navigate your way through the downloads in the db
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

date_default_timezone_set('UTC');
$start = microtime(true);

$result   = $mysqli->query("SELECT * FROM download_main");
$download_nr = $result->num_rows;

$smarty->assign("user_id", $_SESSION['user_id']);

$smarty->assign("download_nr", $download_nr);

if (isset($_SESSION['edit_message'])) {
    $smarty->assign("message", $_SESSION['edit_message']);
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "downloads_main.html");

//close the connection
mysqli_close($mysqli);
