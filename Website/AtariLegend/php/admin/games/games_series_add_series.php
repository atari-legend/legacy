<?php
/***************************************************************************
 *                             games_series_add_series.php
 *                            -------------------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation from scratch for smarty usage

 *
 *
 *   Id: games_series_add_series.php,v 0.2 2005/09/24 Silver Surfer
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

// SERIES LIST DROPDOWN
$sql_series = $mysqli->query("SELECT * FROM game_series ORDER BY game_series_name ASC")
    or die("Couldn't query Game Series Database1");

while ($query_series = $sql_series->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('game_series', array(
        'game_series_id' => $query_series['game_series_id'],
        'game_series_name' => $query_series['game_series_name']
    ));
}

$smarty->assign('series_info', array(
    'series_page' => $series_page
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_series_add_series.html");
