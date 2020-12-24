<?php
/***************************************************************************
 *                                games_review.php
 *                            --------------------------
 *   begin                : Sunday, November 27, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *                          Created file
 *
 *   Id: games_review.php,v 0.10 2005/11/27 ST Graveyard
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

/*
 ************************************************************************************************
 This is the game review main page
 ************************************************************************************************
 */
$start1 = gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));

//Get list of all games
$sql_games = $mysqli->query("SELECT * FROM game ORDER BY game_name ASC") or die("Couldn't query games database");

while ($games = $sql_games->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('games', array(
        'game_id' => $games['game_id'],
        'game_name' => $games['game_name']
    ));
}

//get the number of reviews in the archive
$query_number = $mysqli->query("SELECT * FROM review_main WHERE review_edit = '0'")
    or die("Couldn't get the number of reviews");
$v_reviews = $query_number->num_rows;

$query_reviewed = $mysqli->query("SELECT * FROM review_game GROUP BY game_id HAVING COUNT(DISTINCT game_id) = 1")
    or die("Couldn't get the number of reviewed games");
$v_review_games = $query_reviewed->num_rows;

$RESULTGAME = "SELECT
    game.game_id,
    game.game_name,
    pub_dev.pub_dev_name,
    pub_dev.pub_dev_id,
    users.userid,
    review_main.review_date,
    review_main.review_id,
    review_main.draft
    FROM game
    LEFT JOIN game_developer ON ( game.game_id = game_developer.game_id )
    LEFT JOIN pub_dev ON ( game_developer.dev_pub_id = pub_dev.pub_dev_id )
    LEFT JOIN review_game ON ( review_game.game_id = game.game_id )
    LEFT JOIN review_main ON ( review_main.review_id = review_game.review_id)
    LEFT JOIN users ON ( review_main.user_id = users.user_id)
    WHERE review_game.game_id IS NOT NULL
    GROUP BY game.game_id, game.game_name, userid, review_date
    HAVING COUNT(DISTINCT game.game_id, game.game_name, userid, review_date) = 1
    ORDER BY game_name ASC";

$games = $mysqli->query($RESULTGAME);

$rows = $games->num_rows;

if ($rows > 0) {
    if (empty($i)) {
        $i = 0;
    }
    while ($row = $games->fetch_array(MYSQLI_BOTH)) {
        $i++;
        $review_date = date("F j, Y", $row['review_date']);

        $smarty->append('review', array(
            'game_id' => $row['game_id'],
            'game_name' => $row['game_name'],
            'game_developer' => $row['pub_dev_name'],
            'review_date' => $review_date,
            'review_id' => $row['review_id'],
            'review_draft' => $row['draft'],
            'username' => $row['userid']
        ));
    }
}

// Create dropdown values a-z
$az_value  = az_dropdown_value(0);
$az_output = az_dropdown_output(0);

$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);

$smarty->assign('review_nr', $v_reviews);
$smarty->assign('game_review_nr', $v_review_games);
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games/games_review.html");

//close the connection
mysqli_close($mysqli);
