<?php
/***************************************************************************
 *                                db_games_review.php
 *                            --------------------------
 *   begin                : Sunday, November 27, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : created this page
 *
 *   Id: db_games_review.php,v 0.10 2005/11/27 Gatekeeper
 *   Id: db_games_review.php,v 0.15 2016/07/24 Gatekeeper
 *              - AL 2.0
 *   Id: db_games_review.php,v 0.16 2016/08/19 ST Graveyard
 *              - Added change log
 *   Id: db_games_review.php,v 0.17 2017/04/27 ST Graveyard
 *              - prevent crash when score is not filled
 *              - added real_excape_string
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the game review page where you add a review to the db
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if (isset($action) and $action == 'add_review') {
    // first we have to convert the date vars into a time stamp to be inserted to review_date
    $date = date_to_timestamp($Date_Year, $Date_Month, $Date_Day);
    $textfield = $mysqli->real_escape_string($textfield);
    
    $sdbquery = $mysqli->query("INSERT INTO review_main (user_id, review_text, review_date) VALUES ($members, '$textfield', '$date')") or die("Couldn't insert into review_main");

    //get the id of the inserted review
    $REVIEW = $mysqli->query("SELECT review_id FROM review_main
                           ORDER BY review_id desc") or die("Database error - selecting reviews");

    $reviewrow = $REVIEW->fetch_row();

    $reviewid = $reviewrow[0];

    //Then, we'll be filling up the game review table
    $sdbquery = $mysqli->query("INSERT INTO review_game (review_id, game_id) VALUES ($reviewid, $game_id)") or die("Couldn't insert into review_game");

    //Fill the score table
    if ( $graphics == '' or $sound == '' or $gameplay == '' or $conclusion == '' ) {}
    else
    {
        $sdbquery = $mysqli->query("INSERT INTO review_score (review_id, review_graphics, review_sound, review_gameplay, review_overall) VALUES ($reviewid, $graphics, $sound, $gameplay, $conclusion)") or die("Couldn't insert into review_score");
    }
    
    //we're gonna add the screenhots into the screenshot_review table and fill up the review_comment table.
    //We need to loop on the screenshot table to check the shots used. If a comment field is filled,
    //the screenshot was used!
    $SCREEN = $mysqli->query("SELECT * FROM screenshot_game where game_id = '$game_id' ORDER BY screenshot_id ASC") or die("Database error - getting screenshots");

    $i = 0;

    while ($screenrow = $SCREEN->fetch_row()) {
        if ($inputfield[$i] != "") {
            //fill the review_screenshot table

            $screenid = $screenrow[2];
            $comment  = $inputfield[$i];
            $comment = $mysqli->real_escape_string($comment);

            $sdbquery = $mysqli->query("INSERT INTO screenshot_review (review_id, screenshot_id) VALUES ('$reviewid', '$screenid')") or die("Couldn't insert into screenshot_review");

            $REVIEWSHOT = $mysqli->query("SELECT * FROM screenshot_review
                                           ORDER BY screenshot_review_id desc") or die("Database error - selecting screenshots review");

            $reviewshotrow = $REVIEWSHOT->fetch_row();

            $reviewshotid = $reviewshotrow[0];

            //fill the screenshot comment table
            $sdbquery = $mysqli->query("INSERT INTO review_comments (screenshot_review_id, comment_text) VALUES ('$reviewshotid', '$comment')") or die("Couldn't insert into review_comments");
        }
        $i++;
    }

    create_log_entry('Games', $game_id, 'Review', $reviewid, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Review added to DB";

    header("Location: ../games/games_review_add.php?game_id=$game_id");
}
