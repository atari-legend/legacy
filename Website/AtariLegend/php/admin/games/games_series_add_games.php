<?php
/***************************************************************************
 *                             games_series_add_games.php
 *                            -------------------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation from scratch for smarty usage
 *
 *   Id: games_series_add_games.php,v 0.2 2005/09/24 Silver Surfer
 *   Id: games_series_add_games.php,v 0.3 2016/07/24 STG
 *              -AL 2.0
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
$gameSeries = $gameSeriesDao->getGameSeries($game_series_id);

$smarty->assign('game_series', $gameSeries);

if (isset($action) && $action == 'add_games_search') {
    //check the $gamesearch field
    if (isset($gamesearch)) {
    } else {
        $gamesearch = "";
    }

    //check the $gamebrowse select
    if (empty($gamebrowse) or $gamebrowse == '-') {
        $gamebrowse_select = "";
    } elseif ($gamebrowse == 'num') {
        $gamebrowse_select = "AND game.game_name REGEXP '^[0-9].*'";
    } else {
        $gamebrowse_select = "AND game.game_name LIKE '$gamebrowse%'";
    }

    if ($gamesearch == "" and $gamebrowse_select == "") {
        $_SESSION['edit_message'] = "Please fill in one of the fields";

        // Do a simple gamesearch... no aka's or the likes of that.
        $sql_build = "SELECT game.game_id,
                       game.game_name,
                       game_publisher.pub_dev_id as 'publisher_id',
                       pd1.pub_dev_name as 'publisher_name',
                       game_developer.dev_pub_id as 'developer_id',
                       pd2.pub_dev_name as 'developer_name',
                       YEAR(game_release.date) as 'year'";
        $sql_build .= " FROM game ";
        $sql_build .= " LEFT JOIN game_release on (game_release.game_id = game.game_id) ";
        $sql_build .= " LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)";
        $sql_build .= " LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)";
        $sql_build .= " LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)";
        $sql_build .= " LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)";

        $sql_build .= " WHERE game_name REGEXP '^[0-9].*'";
        $sql_build .= " AND game_series_id IS NULL";
        $sql_build .= " GROUP BY game.game_name";

        $sql_series_link = $mysqli->query($sql_build) or die("Couldn't query Game Series Database5 ($sql_build)");

        $smarty->assign('series_info', array(
            'game_series_id' => $query_series2['game_series_id'],
            'game_series_name' => $query_series2['game_series_name']
        ));

        while ($query_series_link = $sql_series_link->fetch_array(MYSQLI_BOTH)) {
            // This smarty is used for creating the list of games contained within a game series
            $smarty->append('series_link', array(
                'game_id' => $query_series_link['game_id'],
                'game_name' => $query_series_link['game_name'],
                'publisher_id' => $query_series_link['publisher_id'],
                'publisher_name' => $query_series_link['publisher_name'],
                'developer_id' => $query_series_link['developer_id'],
                'developer_name' => $query_series_link['developer_name'],
                'year' => $query_series_link['year']
            ));
        }
    } else {
        $sql_build = "SELECT game.game_id,
                       game.game_name,
                       game_developer.dev_pub_id as 'developer_id',
                       pd2.pub_dev_name as 'developer_name'";
        $sql_build .= " FROM game ";
        $sql_build .= " LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)";
        $sql_build .= " LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)";

        $sql_build .= " WHERE game.game_name LIKE '%$gamesearch%'";
        $sql_build .= " AND game_series_id IS NULL ";
        $sql_build .= $gamebrowse_select;

        $sql_build .= " GROUP BY game.game_name";

        $sql_series_link = $mysqli->query($sql_build) or die("Couldn't query Game Series Database ($sql_build)");

        while ($query_series_link = $sql_series_link->fetch_array(MYSQLI_BOTH)) {
            // This smarty is used for creating the list of games contained within a game series
            $smarty->append('series_link', array(
                'game_id' => $query_series_link['game_id'],
                'game_name' => $query_series_link['game_name'],
                'developer_id' => $query_series_link['developer_id'],
                'developer_name' => $query_series_link['developer_name']
            ));
        }
    }
} else {
    // Do a simple gamesearch... no aka's or the likes of that.
    $sql_build = "SELECT game.game_id,
                   game.game_name,
                   game_developer.dev_pub_id as 'developer_id',
                   pd2.pub_dev_name as 'developer_name'";
    $sql_build .= " FROM game ";
    $sql_build .= " LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)";
    $sql_build .= " LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)";

    $sql_build .= " WHERE game_name REGEXP '^[0-9].*'";
    $sql_build .= " GROUP BY game.game_name";

    $sql_series_link = $mysqli->query($sql_build) or die("Couldn't query Game Series Database5 ($sql_build)");

    while ($query_series_link = $sql_series_link->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of games contained within a game series
        $smarty->append('series_link', array(
            'game_id' => $query_series_link['game_id'],
            'game_name' => $query_series_link['game_name'],
            'developer_id' => $query_series_link['developer_id'],
            'developer_name' => $query_series_link['developer_name']
        ));
    }
}

// Create dropdown values a-z
$az_value  = az_dropdown_value(0);
$az_output = az_dropdown_output(0);

$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);
$smarty->assign('mySelect', 'num');
$smarty->assign('game_series_id', $game_series_id);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games/games_series_add_games.html");
