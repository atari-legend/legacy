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

    create_log_entry('Games', $game_id, 'Review', $reviewid, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Review added to DB";

    header("Location: ../games/games_review_edit.php?game_id=$game_create&reviewid=$reviewid");
}
