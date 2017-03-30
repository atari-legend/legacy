<?php
/***************************************************************************
 *                            downloads_game_detail.php
 *                            ---------------------------
 *   begin                : Sunday, March 12, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: downloads_game_detail.php.php,v 0.1 2017/03/12 STG 19:55
 *
 ***************************************************************************/
/*
 ***********************************************************************************
 Downloads detail
 ***********************************************************************************
 */
 
//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

include("../../admin/games/quick_search_games.php");

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
$sql_downloads = $mysqli->query("SELECT * FROM game_download 
                                          LEFT JOIN download_main ON (game_download.download_id = download_main.download_id)                                         
                                          WHERE game_download.game_id='$game_id'") or die("Error getting download info");

$nr_downloads = 0;
while ($downloads = $sql_downloads->fetch_array(MYSQLI_BOTH)) {
       
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
    
    //let's get the detail download table
    $sql_download_details = $mysqli->query("SELECT * FROM game_download 
                                             LEFT JOIN game_download_details ON (game_download.game_download_id = game_download_details.game_download_id)
                                             WHERE game_download.game_download_id='$downloads[game_download_id]'") or die("Error getting download details");
    while ($details = $sql_download_details->fetch_array(MYSQLI_BOTH)) {
        
        if ($details['version'] == '') {
            $filename .= "(v xx)";
        } else {
            $filename .= "($details[version])";
        }
    }
    
    //let's get the format
    $sql_format = $mysqli->query("SELECT * FROM game_download 
                                  LEFT JOIN download_main ON (game_download.download_id = download_main.download_id)
                                  LEFT JOIN download_format ON (download_main.download_id = download_format.download_id)
                                  LEFT JOIN format ON (download_format.format_id = format.format_id)
                                  WHERE game_download.game_download_id='$downloads[game_download_id]'") or die("Error getting download format");
    while ($format = $sql_format->fetch_array(MYSQLI_BOTH)) {                                 
    
        if ($format['format'] == '') {
            $filename .= "(format)";
        } else {
            $filename .= "($format[format])";
        }
    }
    
    // let's get the language
    $sql_lingo = $mysqli->query("SELECT * FROM game_download 
                                  LEFT JOIN game_download_lingo ON (game_download.game_download_id = game_download_lingo.game_download_id)
                                  LEFT JOIN lingo ON (game_download_lingo.lingo_id = lingo.lingo_id)
                                  WHERE game_download.game_download_id='$downloads[game_download_id]'") or die("Error getting download lingo");
    while ($lingo = $sql_lingo->fetch_array(MYSQLI_BOTH)) {                                 
    
        if ($lingo['lingo_name'] == '') {
            $filename .= "(lingo)";
        } else {
            $filename .= "($lingo[lingo_name])";
        }
    }
    
    
    if ($downloads['download_ext'] == "stx") {
        $filename .= "[pasti]";
    }
    if ($downloads['download_ext'] == "msa") {
        $filename .= "[MSA]";
    }
    
    $sql_set = $mysqli->query("SELECT * FROM game_download   
                               LEFT JOIN game_download_set ON (game_download.game_download_id = game_download_set.game_download_id)
                               WHERE game_download.game_download_id='$downloads[game_download_id]'") or die("Error getting download set");
    while ($set = $sql_set->fetch_array(MYSQLI_BOTH)) {                                 
                               
        if ($set['game_download_set_chain'] == '') {
           
        } else {
            $filename .= " - part $set[game_download_set_chain]";
        }
    }
     
    $filename .= ".zip";

    $filepath = $game_file_path;
    $filepath .= $downloads['game_download_id'];

    //convert the date
    $date = date("F j, Y", $downloads['date']);

    //start filling the smarty object
    $smarty->append('downloads', array(
        'game_download_id' => $downloads['game_download_id'],
        'disable' => $downloads['disable'],
        'filename' => $filename,
        'filepath' => $filepath,
        'date' => $date
    ));

    $nr_downloads++;
}

$smarty->assign('nr_downloads', $nr_downloads);
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "downloads_game_detail.html");

//close the connection
mysqli_close($mysqli);
