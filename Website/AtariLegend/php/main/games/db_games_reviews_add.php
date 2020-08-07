<?php
/***************************************************************************
 *                                db_games_reviews_add.php
 *                            -------------------------------
 *   begin                : Tuesday, August 29, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : created this page
 *
 *   Id: db_games_reviews_add.php,v 0.10 2017/08/29 Gatekeeper
 ***************************************************************************/

/*
 ***********************************************************************************
 *   Add a review submitted by a user
 ***********************************************************************************
 */

//load all common functions
require "../../config/common.php";
require "../../config/admin.php";

if (isset($action) and $action == 'add_review') {
    // first we have to convert the date vars into a time stamp to be inserted to review_date
    $date = date_to_timestamp($Date_Year, $Date_Month, $Date_Day);
    $textfield = $mysqli->real_escape_string($textfield);

    $sdbquery = $mysqli->query(
        "INSERT INTO review_main (user_id, review_text, review_date, review_edit) "
        ."VALUES ($members_add, '$textfield', '$date', '1')"
    ) or die("Couldn't insert into review_main");
    $new_review_main_id = $mysqli->insert_id;

    //Then, we'll be filling up the game review table
    $sdbquery = $mysqli->query("INSERT INTO review_game (review_id, game_id) VALUES ($new_review_main_id, $game_id)")
        or die("Couldn't insert into review_game");

    //Fill the score table
    $sdbquery = $mysqli->query(
        "INSERT INTO review_score "
        ."(review_id, review_graphics, review_sound, review_gameplay, review_overall) "
        ."VALUES ($new_review_main_id, $graphics, $sound, $gameplay, $conclusion)"
    )
        or die("Couldn't insert into review_score");

    //we're gonna add the screenhots into the screenshot_review table and fill up the review_comment table.
    //We need to loop on the screenshot table to check the shots used. If a comment field is filled,
    //the screenshot was used!
    $SCREEN = $mysqli->query("SELECT * FROM screenshot_game where game_id = '$game_id' ORDER BY screenshot_id ASC")
        or die("Database error - getting screenshots");

    $i = 0;

    while ($screenrow = $SCREEN->fetch_row()) {
        if ($inputfield[$i] != "") {
            //fill the review_screenshot table

            $screenid = $screenrow[2];
            $comment  = $inputfield[$i];

            $sdbquery = $mysqli->query(
                "INSERT INTO screenshot_review (review_id, screenshot_id) "
                ."VALUES ('$new_review_main_id', '$screenid')"
            ) or die("Couldn't insert into screenshot_review");

            $REVIEWSHOT = $mysqli->query(
                "SELECT * FROM screenshot_review
                                           ORDER BY screenshot_review_id desc"
            ) or die("Database error - selecting screenshots review");

            $reviewshotrow = $REVIEWSHOT->fetch_row();

            $reviewshotid = $reviewshotrow[0];

            //fill the screenshot comment table
            $sdbquery = $mysqli->query(
                "INSERT INTO review_comments (screenshot_review_id, comment_text) "
                ."VALUES ('$reviewshotid', '$comment')"
            ) or die("Couldn't insert into review_comments");
        }
        $i++;
    }

    create_log_entry('Games', $game_id, 'Review', $reviewid, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Review submitted - Awaiting approval by admin";

    header("Location: ../games/games_reviews_add.php?game_id=$game_id");
}
