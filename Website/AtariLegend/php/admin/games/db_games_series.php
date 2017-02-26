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

//****************************************************************************************
// This is delete from series place
//****************************************************************************************
if ($action == "delete_from_series") {
    if (isset($game_series_cross_id)) {
        foreach ($game_series_cross_id as $game_series_cross_id_sql) {
            create_log_entry('Game series', $game_series_cross_id_sql, 'Game', $game_series_cross_id_sql, 'Delete', $_SESSION['user_id']);

            $mysqli->query("DELETE FROM game_series_cross WHERE game_series_cross_id='$game_series_cross_id_sql'");
        }
//        mysqli_free_result();
    }

    $_SESSION['edit_message'] = "game removed to series";

    header("Location: ../games/games_series_editor.php?series_page=$series_page&game_series_id=$game_series_id");
}

//****************************************************************************************
// Add new series
//****************************************************************************************

if ($action == "addnew_series") {
    if (isset($new_series)) {
        $sql = $mysqli->query("INSERT INTO game_series (game_series_name) VALUES ('$new_series')");
//        mysqli_free_result();
    }

    $new_series_id = $mysqli->insert_id;

    create_log_entry('Game series', $new_series_id, 'Series', $new_series_id, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "new series added";

    header("Location: ../games/games_series_main.php");
}

//****************************************************************************************
// Edit series
//****************************************************************************************

if ($action == "edit_series") {
    if (isset($game_series_name)) {
        $sql = $mysqli->query("UPDATE game_series SET game_series_name='$game_series_name'
                        WHERE game_series_id='$game_series_id'");
//        mysqli_free_result();
    }

    $_SESSION['edit_message'] = "series updated";

    create_log_entry('Game series', $game_series_id, 'Series', $game_series_id, 'Update', $_SESSION['user_id']);

    header("Location: ../games/games_series_editor.php?series_page=series_editor&game_series_id=$game_series_id");
}

//****************************************************************************************
// delete serie
//****************************************************************************************

if ($action == "delete_gameseries") {
    if (isset($game_series_id)) {
        create_log_entry('Game series', $game_series_id, 'Series', $game_series_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM game_series WHERE game_series_id='$game_series_id'");
        $mysqli->query("DELETE FROM game_series_cross WHERE game_series_id='$game_series_id'");
//        mysqli_free_result();
    }

    $_SESSION['edit_message'] = "series deleted";

    header("Location: ../games/games_series_main.php");
}

//****************************************************************************************
// add_to_series
//****************************************************************************************

if ($action == "add_to_series") {
    if (isset($game_id)) {
        foreach ($game_id as $game) {
            create_log_entry('Game series', $game_series_id, 'Game', $game, 'Insert', $_SESSION['user_id']);

            $mysqli->query("INSERT INTO game_series_cross (game_id,game_series_id) VALUES ('$game','$game_series_id')");
            $_SESSION['edit_message'] = "game added to series";
        }
//        mysqli_free_result();
    }

    header("Location: ../games/games_series_editor.php?game_series_id=$game_series_id&series_page=$series_page");
}
