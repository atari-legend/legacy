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
//include("../../config/admin_rights.php");

if (isset($action) and $action == 'delete_comment') {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        $REVIEWSHOT = $mysqli->query("SELECT * FROM screenshot_review
                         WHERE review_id = $reviewid
                     AND screenshot_id = $screenshot_id") or die("Database error - selecting screenshots review");

        $reviewshotrow = $REVIEWSHOT->fetch_row();
        $reviewshotid  = $reviewshotrow[0];

        //delete the screenshot comment from the DB table
        $sdbquery = $mysqli->query("DELETE FROM review_comments WHERE screenshot_review_id = $reviewshotid") or die("failed deleting review_comments");

        //delete the screenshot linked to the review
        $sdbquery = $mysqli->query("DELETE FROM screenshot_review WHERE review_id = $reviewid AND screenshot_id = $screenshot_id") or die("failed deleting screenshot_review");

        create_log_entry('Games', $game_id, 'Review comment', $reviewid, 'Delete', $_SESSION['user_id']);

        $osd_message = 'Comment deleted';
    } else {
        $osd_message = "You don't have permission to perform this task";        
    }
        
    $smarty->assign('osd_message', $osd_message);
    
    
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
            'screenshot_id' => $screenshots[2],
            'review_screenshot_count' => $i,
        ));
    }

    $smarty->assign("screenshots_nr", $i);
    
    $smarty->assign('smarty_action', 'add_comment_to_review_return');
    $smarty->assign('reviewid', $reviewid);
    $smarty->assign('game_id', $game_id);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_review_add_comment.html");  
}

if (isset($action) and ($action == 'delete_review' or $action == 'delete_submission')) {
    include("../../config/admin_rights.php");
    
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
        header("Location: ../games/games_review.php");
    } else {
        header("Location: ../games/games_review_submitted.php");
    }
}

if ($action == 'edit_review' or $action == 'submitted') {
    include("../../config/admin_rights.php");
    
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
    include("../../config/admin_rights.php");
    
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

    header("Location: ../games/games_review.php");
}

if (isset($action) and $action == 'add_review') {
    include("../../config/admin_rights.php");
    
    // first we have to convert the date vars into a time stamp to be inserted to review_date
    $date_year = date("Y");
    $date_month = date("m");
    $date_day = date("d");
    
    $date = date_to_timestamp($date_year, $date_month, $date_day);
    
    $user_id_review = $_SESSION['user_id'];
    
    $sdbquery = $mysqli->query("INSERT INTO review_main (review_date, user_id) VALUES ('$date',$user_id_review)") or die("Couldn't insert into review_main");

    //get the id of the inserted review
    $REVIEW = $mysqli->query("SELECT review_id FROM review_main
                           ORDER BY review_id desc") or die("Database error - selecting reviews");

    $reviewrow = $REVIEW->fetch_row();

    $reviewid = $reviewrow[0];

    //Then, we'll be filling up the game review table
    $sdbquery = $mysqli->query("INSERT INTO review_game (review_id, game_id) VALUES ($reviewid, $game_create)") or die("Couldn't insert into review_game");

    create_log_entry('Games', $game_create, 'Review', $reviewid, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Review added to DB";

    header("Location: ../games/games_review_edit.php?game_id=$game_create&reviewid=$reviewid");
}
