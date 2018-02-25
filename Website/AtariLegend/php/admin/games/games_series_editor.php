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
 *   Id: games_series_main.php,v 0.3 2016/07/24 STG
 *              - AL 2.0
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

// SERIES LIST DROPDOWN

$sql_series = $mysqli->query("SELECT * FROM game_series ORDER BY game_series_name ASC") or die("Couldn't query Game Series Database1");

while ($query_series = $sql_series->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('game_series', array(
        'game_series_id' => $query_series['game_series_id'],
        'game_series_name' => $query_series['game_series_name']
    ));
}

// Get the information of the selected gameseries
$sql_series2 = $mysqli->query("SELECT * FROM game_series WHERE game_series_id='$game_series_id'") or die("Couldn't query Game Series Database2");

$query_series2 = $sql_series2->fetch_array(MYSQLI_BOTH);

// Check if there is a game linked to this series. For the list of games in a series
$sql_series_link = $mysqli->query("SELECT game.game_id,
               game.game_name,
               game_publisher.pub_dev_id as 'publisher_id',
               pd1.pub_dev_name as 'publisher_name',
               game_developer.dev_pub_id as 'developer_id',
               pd2.pub_dev_name as 'developer_name',
               game_series_cross.game_series_cross_id,
               YEAR(game_release.date) as game_release_year
                FROM game_series_cross
                LEFT JOIN game ON (game_series_cross.game_id = game.game_id)
                LEFT JOIN game_series ON (game_series_cross.game_series_id = game_series.game_series_id)
                LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
                LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)
                LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
                LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
                LEFT JOIN game_release ON (game.game_id = game_release.game_id)
                WHERE game_series_cross.game_series_id='$game_series_id' GROUP BY game.game_name ORDER BY game.game_name") or die("Couldn't query Game Series Database3.1");
// check how many games is linked to a particular series
$sql_series_link_nr = $sql_series_link->num_rows;

$smarty->assign('series_info', array(
    'game_series_id' => $query_series2['game_series_id'],
    'game_series_name' => $query_series2['game_series_name'],
    'sql_series_link_nr' => $sql_series_link_nr,
    'series_page' => $series_page
));

while ($query_series_link = $sql_series_link->fetch_array(MYSQLI_BOTH)) { // This smarty is used for creating the list of games contained within a game series
    $smarty->append('series_link', array(
        'game_id' => $query_series_link['game_id'],
        'game_name' => $query_series_link['game_name'],
        'publisher_name' => $query_series_link['publisher_name'],
        'publisher_id' => $query_series_link['publisher_id'],
        'developer_name' => $query_series_link['developer_name'],
        'developer_id' => $query_series_link['developer_id'],
        'game_series_cross_id' => $query_series_link['game_series_cross_id'],
        'year' => $query_series_link['game_release_year']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_series_editor.html");
