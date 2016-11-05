<?php
/***************************************************************************
 *                             games_series_main.php
 *                            -----------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation from scratch for smarty usage
 *
 *   Id: games_series_main.php,v 0.2 2005/09/24 Silver Surfer
 *   Id: games_series_main.php,v 0.5 2016/07/24 ST Graveyard
 *                  -AL 2.0
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

// SERIES LIST DROPDOWN

$sql_series = $mysqli->query("SELECT * FROM game_series ORDER BY game_series_name ASC") or die("Couldn't query Game Series Database1");

while ($query_series = $sql_series->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('game_series', array(
        'game_series_id' => $query_series['game_series_id'],
        'game_series_name' => $query_series['game_series_name']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_series_main.html");
