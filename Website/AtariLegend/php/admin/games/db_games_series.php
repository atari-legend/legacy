<?php
/***************************************************************************
 *                                db_games_series.php
 *                            -----------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 *   Id: db_games_series.php,v 1.10 2005/09/24 Silver Surfer
 *   Id: db_games_series.php,v 1.15 2016/07/24 STG
 *          - AL 2.0 adding messages
 *   Id: db_games_series.php,v 1.16 2016/08/19 STG
 *          - add change log
 *   id: db_games_series.php,v 1.17 2017/02/26 22:19 STG
 *       - It seems mysqli_free_result is not used for insert or update statements
 *         from the manual : Returns FALSE on failure. For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query()
 *         will return a mysqli_result object. For other successful queries mysqli_query() will return TRUE.
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/GameSeriesDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$gameDao = new \AL\Common\DAO\GameDAO($mysqli);
$gameSeriesDao = new \AL\Common\DAO\GameSeriesDAO($mysqli);
$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

if (isset($game_series_id)) {
    $gameSeries = $gameSeriesDao->getGameSeries($game_series_id);
}

//****************************************************************************************
// This is delete from series place
//****************************************************************************************
if ($action == "delete_from_series") {
    if (isset($game_ids)) {
        foreach ($game_ids as $game_id) {
            $gameSeriesDao->removeGameFromSeries($game_id);

            $game = $gameDao->getGame($game_id);
            $changeLogDao->insertChangeLog(
                new \AL\Common\Model\Database\ChangeLog(
                    -1,
                    "Game series",
                    $gameSeries->getId(),
                    $gameSeries->getName(),
                    "Game",
                    $game->getId(),
                    $game->getName(),
                    $_SESSION["user_id"],
                    \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
                )
            );
        }

        $_SESSION['edit_message'] = "Game(s) removed from series";
    }

    header("Location: ../games/games_series_editor.php?game_series_id=$game_series_id");
}

//****************************************************************************************
// Add new series
//****************************************************************************************

if ($action == "addnew_series") {
    if (isset($new_series)) {
        $new_series_id = $gameSeriesDao->addGameSeries(new \AL\Common\Model\Game\GameSeries(-1, $new_series));

        $_SESSION['edit_message'] = "New series added";

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Game series",
                $new_series_id,
                $new_series,
                "Series",
                $new_series_id,
                $new_series,
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
            )
        );
    }

    header("Location: ../games/games_series_editor.php?game_series_id=$new_series_id");
}

//****************************************************************************************
// Edit series
//****************************************************************************************

if ($action == "edit_series") {
    if (isset($game_series_name)) {
        $gameSeriesDao->updateGameSeries($game_series_id, $game_series_name);

        $_SESSION['edit_message'] = "Series updated";

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Game series",
                $gameSeries->getId(),
                $gameSeries->getName(),
                "Series",
                $gameSeries->getId(),
                $game_series_name,
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
            )
        );
    }

    header("Location: ../games/games_series_editor.php?series_page=series_editor&game_series_id=$game_series_id");
}

//****************************************************************************************
// delete serie
//****************************************************************************************

if ($action == "delete_gameseries") {
    $gameSeriesDao->deleteGameSeries($game_series_id);

    $_SESSION['edit_message'] = "Series deleted";

    $changeLogDao->insertChangeLog(
        new \AL\Common\Model\Database\ChangeLog(
            -1,
            "Game series",
            $gameSeries->getId(),
            $gameSeries->getName(),
            "Series",
            $gameSeries->getId(),
            $gameSeries->getName(),
            $_SESSION["user_id"],
            \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
        )
    );

    header("Location: ../games/games_series_main.php");
}

//****************************************************************************************
// add_to_series
//****************************************************************************************

if ($action == "add_to_series") {
    if (isset($game_ids)) {
        foreach ($game_ids as $game_id) {
            $gameSeriesDao->addGameToSeries($game_series_id, $game_id);

            $_SESSION['edit_message'] = "Game added to series";

            $game = $gameDao->getGame($game_id);
            $changeLogDao->insertChangeLog(
                new \AL\Common\Model\Database\ChangeLog(
                    -1,
                    "Game series",
                    $gameSeries->getId(),
                    $gameSeries->getName(),
                    "Game",
                    $game->getId(),
                    $game->getName(),
                    $_SESSION["user_id"],
                    \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
                )
            );
        }
    }

    header("Location: ../games/games_series_editor.php?game_series_id=$game_series_id");
}
