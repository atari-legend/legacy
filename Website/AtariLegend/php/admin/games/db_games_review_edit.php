<?php
/***************************************************************************
 *                                db_games_review_edit.php
 *                            ------------------------------
 *   begin                : saturday, December 4, 2004
 *   copyright            : (C) 2004 Atari Legend
 *   email                : maarten.martens@freebel.net
 *
 *   Id: db_games_review_edit.php,v 0.10 2004/12/04 23:34 ST Graveyard
 *   Id: db_games_review_edit.php,v 0.15 2016/07/23 23:56 ST Graveyard
 *         - AL 2.0
 *   Id: db_games_review_edit.php,v 0.16 2016/08/19 12:34 ST Graveyard
 *         - Added change log
 *   Id: db_games_review_edit.php,v 0.17 2017/09/01 10:20 ST Graveyard
 *                  - added some tweaks for review submissions
 ***************************************************************************/

//*********************************************************************************************
//This php file will get the info to generate the page of the review
//*********************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if (isset($action) and $action == 'delete_comment') {
    $REVIEWSHOT = $mysqli->query("SELECT * FROM screenshot_review
                     WHERE review_id = $reviewid
                 AND screenshot_id = $screenshot_id") or die("Database error - selecting screenshots review");

    $reviewshotrow = $REVIEWSHOT->fetch_row();
    $reviewshotid  = $reviewshotrow[0];

    //delete the screenshot comment from the DB table
    $sdbquery = $mysqli->query("DELETE FROM review_comments WHERE screenshot_review_id = $reviewshotid") or die("failed deleting review_comments");

    //delete the screenshot linked to the review
    $sdbquery = $mysqli->query("DELETE FROM screenshot_review WHERE review_id = $reviewid AND screenshot_id = $screenshot_id") or die("failed deleting screenshot_review");

    $_SESSION['edit_message'] = "Comment deleted";

    create_log_entry('Games', $game_id, 'Review comment', $reviewid, 'Delete', $_SESSION['user_id']);

    header("Location: ../games/games_review_edit.php?reviewid=$reviewid&game_id=$game_id");
}

if (isset($action) and ($action == 'delete_review' or $action == 'delete_submission')) {
    $sql = $mysqli->query("DELETE FROM review_main WHERE review_id = '$reviewid' ") or die("deletion review_main failed");
    $sql = $mysqli->query("DELETE FROM review_game WHERE review_id = '$reviewid' AND game_id = '$game_id' ") or die("deletion review_game failed");
    $sql = $mysqli->query("DELETE FROM review_score WHERE review_id = '$reviewid' ") or die("deletion review_score failed");

    //delete the comments at every screenshot for this review
    $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_review where review_id = '$reviewid' ") or die("Database error - getting screenshots");

    while ($screenshotrow = $SCREENSHOT->fetch_row()) {
        $sql = $mysqli->query("DELETE FROM review_comments WHERE screenshot_review_id = $screenshotrow[0] ") or die("deletion review_comments failed");
    }

    $sql = $mysqli->query("DELETE FROM screenshot_review WHERE review_id = '$reviewid' ") or die("deletion screenshot failed");

    $_SESSION['edit_message'] = "Review deleted";

    create_log_entry('Games', $game_id, 'Review', $reviewid, 'Delete', $_SESSION['user_id']);
    if ($action == 'delete_review') {
        header("Location: ../games/games_review_add.php?game_id=$game_id");
    } else {
        header("Location: ../games/games_review_submitted.php");
    }
}

if ($action == 'edit_review' or $action == 'submitted') {
    // first we have to convert the date vars into a time stamp to be inserted to review_date

    $date = date_to_timestamp($Date_Year, $Date_Month, $Date_Day);

    $textfield = $mysqli->real_escape_string($textfield);

    $sdbquery = $mysqli->query("UPDATE review_main set user_id = '$members', review_text = '$textfield', review_date = '$date', review_edit = '0'
               WHERE review_id = '$reviewid'") or die("Couldn't update review_main");

    //check if comment already exists for this shot
    $REVIEWSCORE = $mysqli->query("SELECT * FROM review_score where review_id = $reviewid") or die("Database error - selecting scores");

    $score = $REVIEWSCORE->num_rows;

    if ($score > 0) {
        $sdbquery = $mysqli->query("UPDATE review_score SET review_graphics = $graphics, review_sound = $sound, review_gameplay = $gameplay, review_overall = $conclusion
                 WHERE review_id = $reviewid") or die("Couldn't update review_score");
    } else {
        $sdbquery = $mysqli->query("INSERT INTO review_score (review_id, review_graphics, review_sound, review_gameplay, review_overall) VALUES ($reviewid, '$graphics', '$sound', '$gameplay', '$overall')") or die("Couldn't insert the update of the review_score");
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

            $REVIEWSCREEN = $mysqli->query("SELECT * FROM screenshot_review WHERE review_id = '$reviewid' AND
                       screenshot_id = '$screenid'") or die("Database error - getting review - screenshots");

            //check if shot exists
            $number = $REVIEWSCREEN->num_rows;

            if ($number > 0) {
            } else { //else insert it
                $sdbquery = $mysqli->query("INSERT INTO screenshot_review (review_id, screenshot_id) VALUES ('$reviewid', '$screenid')") or die("Couldn't insert into screenshot_review");
            }

            $REVIEWSHOT = $mysqli->query("SELECT * FROM screenshot_review where review_id = '$reviewid' AND
                       screenshot_id = '$screenid'") or die("Database error - selecting screenshots review");

            $reviewshotrow = $REVIEWSHOT->fetch_row();

            $reviewshotid = $reviewshotrow[0];

            //check if comment already exists for this shot
            $REVIEWCOMMENT = $mysqli->query("SELECT * FROM review_comments where screenshot_review_id = '$reviewshotid'") or die("Database error - selecting screenshot review comment");

            $number = $REVIEWCOMMENT->num_rows;

            if ($number > 0) {
                $comment = $mysqli->real_escape_string($comment);

                $sdbquery = $mysqli->query("UPDATE review_comments SET comment_text = '$comment'
                       WHERE screenshot_review_id = '$reviewshotid'") or die("Couldn't update review_comments");
            } else { //else insert it
                $comment = $mysqli->real_escape_string($comment);
                $sdbquery = $mysqli->query("INSERT INTO review_comments (screenshot_review_id, comment_text) VALUES ('$reviewshotid', '$comment')") or die("Couldn't insert into review_comments");
            }
        }
        $i++;
    }

    $_SESSION['edit_message'] = "Review updated";

    create_log_entry('Games', $game_id, 'Review', $reviewid, 'Update', $_SESSION['user_id']);
    
    if ($action == 'submitted') {
        header("Location: ../games/games_review_submitted.php");
    } else {
        header("Location: ../games/games_review_edit.php?reviewid=$reviewid&game_id=$game_id");
    }
}

if (isset($action) and $action == 'move_to_comment') {
    $sql_edit_REVIEW = $mysqli->query("SELECT * FROM review_main WHERE review_id = $reviewid") or die("Database error - selecting review data");

    $edit_review = $sql_edit_REVIEW->fetch_array(MYSQLI_BOTH);

    $review_text      = $mysqli->real_escape_string($edit_review['review_text']);
    $review_timestamp = $edit_review['review_date'];
    $review_user_id   = $edit_review['user_id'];

    $sql = $mysqli->query("INSERT INTO comments (comment,timestamp,user_id) VALUES ('$review_text','$review_timestamp','$review_user_id')") or die("something is wrong with INSERT mysql3");

    $new_comment_id = $mysqli->insert_id;

    $sql = $mysqli->query("INSERT INTO game_user_comments (game_id,comment_id) VALUES ('$game_id',LAST_INSERT_ID())") or die("something is wrong with INSERT mysql4");

    create_log_entry('Games', $new_comment_id, 'Comment', $new_comment_id, 'Insert', $_SESSION['user_id']);

    $sql = $mysqli->query("DELETE FROM review_main WHERE review_id = '$reviewid' ") or die("deletion review_main failed");
    $sql = $mysqli->query("DELETE FROM review_game WHERE review_id = '$reviewid' AND game_id = '$game_id' ") or die("deletion review_game failed");
    $sql = $mysqli->query("DELETE FROM review_score WHERE review_id = '$reviewid' ") or die("deletion review_score failed");

    //delete the comments at every screenshot for this review
    $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_review where review_id = '$reviewid' ") or die("Database error - getting screenshots");

    while ($screenshotrow = $SCREENSHOT->fetch_row()) {
        $sql = $mysqli->query("DELETE FROM review_comments WHERE screenshot_review_id = $screenshotrow[0] ") or die("deletion review_comments failed");
    }

    $sql = $mysqli->query("DELETE FROM screenshot_review WHERE review_id = '$reviewid' ") or die("deletion screenshot failed");

    $_SESSION['edit_message'] = "Review converted to comment";

    header("Location: ../games/games_review_add.php?game_id=$game_id");
}
