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

require_once __DIR__."/../../common/DAO/GameSeriesDAO.php";

$gameSeriesDao = new \AL\Common\DAO\GameSeriesDAO($mysqli);
$smarty->assign("game_series", $gameSeriesDao->getGameSeries($game_series_id));

// Check if there is a game linked to this series. For the list of games in a series
$sql_series_link = $mysqli->query("SELECT game.game_id,
               game.game_name,
               game_developer.dev_pub_id as 'developer_id',
               pd2.pub_dev_name as 'developer_name'
                FROM game
                LEFT JOIN game_series ON (game.game_series_id = game_series.id)
                LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
                LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
                WHERE game.game_series_id='$game_series_id' ORDER BY game.game_name") or die($mysqli->error);

while ($query_series_link = $sql_series_link->fetch_array(MYSQLI_BOTH)) {
    // This smarty is used for creating the list of games contained within a game series
    $smarty->append('games', array(
        'game_id' => $query_series_link['game_id'],
        'game_name' => $query_series_link['game_name'],
        'developer_name' => $query_series_link['developer_name'],
        'developer_id' => $query_series_link['developer_id']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_series_editor.html");
