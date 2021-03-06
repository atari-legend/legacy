<?php
/***************************************************************************
 *                                games_review_submitted.php
 *                            --------------------------
 *   begin                : Sunday, December 04, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : created this page
 *
 *   Id: games_review_submitted.php,v 0.10 2005/12/04 Gatekeeper
 *   Id: games_review_submitted.php,v 0.15 2016/07/24 Gatekeeper
 *                  - AL 2.0
 *   Id: games_review_submitted.php,,v 0.16 2017/09/01 10:20 ST Graveyard
 *                  - added some tweaks for review submissions
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the submitted review page
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//get the submitted reviews
$sql_submission = $mysqli->query("SELECT * FROM review_main
                                LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
                                LEFT JOIN game ON (review_game.game_id = game.game_id)
                                LEFT JOIN users ON (review_main.user_id = users.user_id)
                                WHERE review_main.review_edit = '1'");

$i = 0;

while ($review = $sql_submission->fetch_array(MYSQLI_BOTH)) {
    $i++;

    $smarty->append('review', array(
        'game_name' => $review['game_name'],
        'user_id' => $review['user_id'],
        'userid' => $review['userid'],
        'review_date' => $review['review_date'],
        'review_id' => $review['review_id'],
        'game_id' => $review['game_id']
    ));
}

$smarty->assign("submission_nr", $i);
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games/games_review_submitted.html");
