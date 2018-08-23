<?php
/***************************************************************************
 *                                games_facts.php
 *                            -----------------------
 *   begin                : Saturday, September 09, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: games_facts.php,v 1.0  2017/09/09 ST Graveyard
 *   Id: games_facts.php,v 1.1  2017/11/24 ST Graveyard
 *          -Adding BBCODE enhancements and edit options
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

require_once __DIR__."/../../common/DAO/GameDAO.php";
$gameDao = new \AL\Common\DAO\GameDAO($mysqli);
$smarty->assign('game', $gameDao->getGame($game_id));

$i=0;

//load the fact for this games
$query_games_facts = $mysqli->query("SELECT * from game_fact
									 LEFT JOIN game ON (game.game_id = game_fact.game_id)
									 WHERE game_fact.game_id = $game_id") or die("error in query game facts");

while ($sql_games_facts = $query_games_facts->fetch_array(MYSQLI_BOTH)) {
    $i++;

    //check if there are screenshot added to the submission
    $query_screenshots_facts = $mysqli->query("SELECT * FROM screenshot_main
                                        LEFT JOIN screenshot_game_fact ON (screenshot_main.screenshot_id = screenshot_game_fact.screenshot_id)
                                        WHERE screenshot_game_fact.game_fact_id = '$sql_games_facts[game_fact_id]'") or die("Error - Couldn't query fact screenshots");

    while ($sql_screenshots_facts = $query_screenshots_facts->fetch_array(MYSQLI_BOTH)) {
        $new_path = $game_fact_screenshot_path;
        $new_path .= $sql_screenshots_facts['screenshot_id'];
        $new_path .= ".";
        $new_path .= $sql_screenshots_facts['imgext'];

        $smarty->append(

            'facts_screenshots',
            array('game_fact_id' => $sql_games_facts['game_fact_id'],
               'screenshot_id' => $sql_screenshots_facts['screenshot_id'],
               'game_fact_screenshot' => $new_path)
        );
    }

    $fact_text = nl2br($sql_games_facts['game_fact']);
    $fact_text = InsertALCode($fact_text);

    $smarty->append('facts', array(
        'game_id' => $sql_games_facts['game_id'],
        'game_name' => $sql_games_facts['game_name'],
        'game_fact_id' => $sql_games_facts['game_fact_id'],
        'game_fact_nr' => $i,
        'game_fact' => $fact_text
    ));

    if (isset($game_name)){
    }else{
        $smarty->assign('game_name', $sql_games_facts['game_name']);
    }
}

$smarty->assign('game_id', $game_id);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_facts.html");
