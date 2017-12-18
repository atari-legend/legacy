<?php
/***************************************************************************
 *                                games_review_edit.php
 *                            --------------------------
 *   begin                : saturday, December 4, 2004
 *   copyright            : (C) 2004 Atari Legend
 *   email                : maarten.martens@freebel.net
 *
 *   Id: games_review_edit.php,v 0.10 2004/12/04 23:34 ST Graveyard
 *   Id: games_review_edit.php,v 0.20 2016/07/23 22:32 ST Graveyard
 *                          - AL 2.0
 *   Id: games_review_edit.php,v 0.21 2017/09/01 10:20 ST Graveyard
 *                          - added some tweaks for review submissions
 *
 ***************************************************************************/

//*********************************************************************************************
//This php file will get the info to generate the page of the review
//*********************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/games/quick_search_games.php");

if (isset($reviewid) and isset($game_id)) {
    //get the name of the game
    $sql_game = $mysqli->query("SELECT * FROM game WHERE game_id='$game_id'") or die("Database error - getting game name");

    while ($game = $sql_game->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('game', array(
            'game_id' => $game_id,
            'game_name' => $game['game_name']
        ));
    }

    //Get the authors
    $sql_author = $mysqli->query("SELECT user_id,userid FROM users") or die("Database error - getting members name");

    while ($authors = $sql_author->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('authors', array(
            'user_id' => $authors['user_id'],
            'user_name' => $authors['userid']
        ));
    }

    //get the reviews of the game
    $sql_review = $mysqli->query("SELECT * FROM review_game
                           LEFT JOIN review_main ON (review_game.review_id = review_main.review_id)
                           LEFT JOIN users ON (review_main.user_id = users.user_id)
                           WHERE review_game.game_id='$game_id' ORDER BY review_game.review_id") or die("Database error - selecting review");
    $i = 1;
    while ($review = $sql_review->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('review', array(
            'review_id' => $review['review_id'],
            'user_name' => $review['userid'],
            'review_nr' => $i
        ));
        $i++;
    }

    //get the actual edit review data
    $sql_edit_REVIEW = $mysqli->query("SELECT
                               user_id,
                               review_text,
                               review_date,
                               review_score_id,
                               review_graphics,
                               review_sound,
                               review_gameplay,
                               review_overall
                               FROM review_game
                               LEFT JOIN review_main ON ( review_game.review_id = review_main.review_id )
                               LEFT JOIN review_score ON ( review_main.review_id = review_score.review_id )
                               WHERE review_game.review_id = $reviewid
                               AND review_game.game_id='$game_id'
                               ORDER BY review_game.review_id") or die("Database error - selecting review data");

    while ($edit_review = $sql_edit_REVIEW->fetch_array(MYSQLI_BOTH)) {
        $review_text = stripslashes($edit_review['review_text']);

        $smarty->assign('edit_review', array(
            'member_id' => $edit_review['user_id'],
            'review_text' => $review_text,
            'review_date' => $edit_review['review_date'],
            'review_score_id' => $edit_review['review_score_id'],
            'review_graphics' => $edit_review['review_graphics'],
            'review_sound' => $edit_review['review_sound'],
            'review_gameplay' => $edit_review['review_gameplay'],
            'review_overall' => $edit_review['review_overall']
        ));
    }

    //get the screenshots
    $sql_screenshots = $mysqli->query("SELECT * FROM screenshot_game WHERE game_id = '$game_id' ORDER BY screenshot_id ASC") or die("Database error - getting screenshots");

    $i = 0;

    while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
        $i++;

        $v_screenshot = $game_screenshot_path;
        $v_screenshot .= $screenshots['screenshot_id'];
        $v_screenshot .= '.';
        $v_screenshot .= 'png';

        $sql_COMMENTS = $mysqli->query("SELECT review_comments.comment_text FROM screenshot_review
                                 LEFT JOIN review_comments on (screenshot_review.screenshot_review_id = review_comments.screenshot_review_id)
                                 WHERE screenshot_review.screenshot_id = '$screenshots[2]' AND screenshot_review.review_id = '$reviewid'") or die("Database error - getting screenshots comments");

        $screencomment = $sql_COMMENTS->fetch_array(MYSQLI_BOTH);

        $smarty->append('screenshots', array(
            'screenshot_id' => $screenshots['screenshot_id'],
            'screenshot_link' => $v_screenshot,
            'screenshot_comment' => htmlentities($screencomment['comment_text']),
            'screenshot_id' => $screenshots[2]
        ));
    }

    $smarty->assign("screenshots_nr", $i);
    $smarty->assign("reviewid", $reviewid);
    
    if (isset($action)) {
        $smarty->assign("action", $action);
    }
    
    $smarty->assign("user_id", $_SESSION['user_id']);

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "games_review_edit.html");
}
