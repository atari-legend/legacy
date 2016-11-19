<?php
/***************************************************************************
 *                                games_upload.php
 *                            ------------------------
 *   begin                : Tuesday, november 9, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *   actual update        : Creation of file
 *
 *   Id: games_upload.php,v 0.10 2005/11/09 15:10 ST Gravedigger
 *
 ***************************************************************************/

//****************************************************************************************
// This is the main page for the game downloads.
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../includes/quick_search_games.php");

//************************************************************************************************
//Let's get the game info for the file name concatenation, and the download data for disks already
//uploaded
//************************************************************************************************
$SQL_GAME_INFO = $mysqli->query("SELECT * FROM game
                               LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
                               LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
                               LEFT JOIN game_year ON (game.game_id = game_year.game_id)
                               WHERE game.game_id='$game_id'") or die("Error getting game info");

$game_info = $SQL_GAME_INFO->fetch_array(MYSQLI_BOTH);

//get some basic game info
$smarty->assign('game', array(
    'game_id' => $game_id,
    'game_name' => $game_info['game_name']
));

//get the existing downloads
$SQL_DOWNLOADS = $mysqli->query("SELECT * FROM game_download WHERE game_id='$game_id'") or die("Error getting download info");

$nr_downloads = 1;
while ($downloads = $SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) {
    // first lets create the filenames
    $filename = "$game_info[game_name]";

    if ($game_info['game_year'] == '') {
        $filename .= " (19xx)";
    } else {
        $filename .= " ($game_info[game_year])";
    }
    if ($game_info['pub_dev_id'] !== '') {
        $filename .= "($game_info[pub_dev_name])";
    }
    if ($downloads['game_ext'] == "stx") {
        $filename .= "[pasti]";
    }
    if ($downloads['game_ext'] == "msa") {
        $filename .= "[MSA]";
    }
    if ($downloads['cracker'] !== "") {
        $filename .= "[cr $downloads[cracker]]";
    }
    if ($downloads['supplier'] !== "") {
        $filename .= "[su $downloads[supplier]]";
    }
    if ($downloads['screen'] !== "") {
        $filename .= "[$downloads[screen]]";
    }
    if ($downloads['language'] !== "") {
        $filename .= "[$downloads[language]]";
    }
    if ($downloads['trainer'] !== "") {
        $filename .= "[$downloads[trainer]]";
    }
    if ($downloads['legend'] == "1") {
        $filename .= "[AL]";
    }
    if ($downloads['disks'] !== "0" || $downloads['disks'] !== "") {
        $filename .= " Disk $downloads[disks]";
    }
    $filename .= ".zip";

    $filepath = $game_file_path;
    $filepath .= $downloads['game_download_id'];

    //convert the date
    $date = date("F j, Y", $downloads['date']);

    //start filling the smarty object
    $smarty->append('downloads', array(
        'game_download_id' => $downloads['game_download_id'],
        'cracker' => $downloads['cracker'],
        'supplier' => $downloads['supplier'],
        'intro' => $downloads['intro'],
        'harddrive' => $downloads['harddrive'],
        'pal_ntsc' => $downloads['screen'],
        'language' => $downloads['language'],
        'trainer' => $downloads['trainer'],
        'disks' => $downloads['disks'],
        'set_nr' => $downloads['set_nr'],
        'legend' => $downloads['legend'],
        'disable' => $downloads['disable'],
        'filename' => $filename,
        'filepath' => $filepath,
        'version' => $downloads['version'],
        'tos' => $downloads['tos'],
        'date' => $date
    ));

    $nr_downloads++;
}

$smarty->assign('nr_downloads', $nr_downloads);
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_upload.html");

//close the connection
mysqli_close($mysqli);
