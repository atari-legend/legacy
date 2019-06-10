<?php
/***************************************************************************
 *                                games_reviews_main.php
 *                            ------------------------------
 *   begin                : Wednesday, August 23, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: games_reviews_main.php,v 0.1 2017/08/23 20:30 STG
 ****************************************************************************/

//****************************************************************************************
// This is the main page of the game reviews.
//****************************************************************************************

//load all common functions
require "../../config/common.php";

//load the tiles
require "../../common/tiles/who_is_it_tile.php";
require "../../common/tiles/did_you_know_tile.php";
require "../../common/tiles/latest_comments_tile.php";
require "../../common/tiles/tile_bug_report.php";

//***********************************************************************************
//Let's get all the interview and author data
//***********************************************************************************
$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

// count number of interviews
$query_number = $mysqli->query("SELECT * FROM review_main WHERE review_main.review_edit = '0'")
    or die("Couldn't get the number of interviews - count");
$total_rows = $query_number->num_rows;

if (isset($action) and $action == 'search') {
    if ($author_id == '-') {
        //Get reviews
        $query_recent_reviews = $mysqli->query(
            "SELECT
                                review_game.review_id,
                                review_game.game_id,
                                review_main.review_edit,
                                review_main.review_text,
                                review_main.review_date,
                                game.game_name,
                                users.user_id,
                                users.userid
                                FROM review_game
                                LEFT JOIN review_main on (review_game.review_id = review_main.review_id)
                                LEFT JOIN users on (review_main.user_id = users.user_id)
                                LEFT JOIN game on (review_game.game_id = game.game_id)
                                WHERE review_main.review_edit = '0'
                                ORDER BY review_main.review_date DESC LIMIT  " . $v_counter . ", 5"
        ) or die("couldn't get the reviews - search all");

        // count number of interviews
        $query_number = $mysqli->query("SELECT * FROM review_main WHERE review_main.review_edit = '0'")
            or die("Couldn't get the number of interviews - count");
        $v_rows = $query_number->num_rows;
    } else {
        //Get reviews
        $query_recent_reviews = $mysqli->query(
            "SELECT
                                review_game.review_id,
                                review_game.game_id,
                                review_main.review_edit,
                                review_main.review_text,
                                review_main.review_date,
                                game.game_name,
                                users.user_id,
                                users.userid
                                FROM review_game
                                LEFT JOIN review_main on (review_game.review_id = review_main.review_id)
                                LEFT JOIN users on (review_main.user_id = users.user_id)
                                LEFT JOIN game on (review_game.game_id = game.game_id)
                                WHERE review_main.review_edit = '0' AND review_main.user_id = '$author_id'
                                ORDER BY review_main.review_date DESC LIMIT  " . $v_counter . ", 5"
        ) or die("couldn't get the reviews  - search");

        // count number of interviews
        $query_number = $mysqli->query(
            "SELECT * FROM review_main WHERE review_main.review_edit = '0'
            AND review_main.user_id = '$author_id'"
        ) or die("Couldn't get the number of interviews - count");
        $v_rows = $query_number->num_rows;

        $smarty->assign('action', 'search');
        $smarty->assign('author_id', $author_id);
    }
} else {
    //Get reviews
    $query_recent_reviews = $mysqli->query(
        "SELECT
						review_game.review_id,
						review_game.game_id,
						review_main.review_edit,
						review_main.review_text,
                        review_main.review_date,
						game.game_name,
                        users.user_id,
                        users.userid
						FROM review_game
						LEFT JOIN review_main on (review_game.review_id = review_main.review_id)
                        LEFT JOIN users on (review_main.user_id = users.user_id)
						LEFT JOIN game on (review_game.game_id = game.game_id)
						WHERE review_main.review_edit = '0'
						ORDER BY review_main.review_date DESC LIMIT  " . $v_counter . ", 5"
    ) or die("couldn't get the reviews");

    // count number of interviews
    $query_number = $mysqli->query("SELECT * FROM review_main WHERE review_main.review_edit = '0'")
        or die("Couldn't get the number of interviews - count");
    $v_rows = $query_number->num_rows;
}

while ($sql_recent_reviews = $query_recent_reviews->fetch_array(MYSQLI_BOTH)) {
    //Structure and manipulate the review text
    $review_text = $sql_recent_reviews['review_text'];

    $pos_start = strpos($review_text, '[frontpage]');
    $pos_end = strpos($review_text, '[/frontpage]');
    $nr_char = $pos_end - $pos_start;

    $review_text  = substr($review_text, $pos_start, $nr_char);

    //$review_text = str_replace("[i][b]Comments[/b][/i]", "",$review_text);
    //$review_text = str_replace("[i][b]Intro[/b][/i]", "",$review_text);
    //$review_text = substr($review_text, 0,100);
    //$review_text = trim($review_text);
    //$review_text .= "...";

    $review_text = nl2br($review_text);
    $review_text = InsertALCode($review_text); // disabled this as it wrecked the design.
    $review_text = trim($review_text);
    $review_text = RemoveSmillies($review_text);

    //Get a screenshots of this review
    $query_screenshots_review = $mysqli->query(
        "SELECT * FROM review_main
        LEFT JOIN screenshot_review ON (review_main.review_id = screenshot_review.review_id)
        LEFT JOIN screenshot_main ON (screenshot_review.screenshot_id = screenshot_main.screenshot_id)
        WHERE review_main.review_id = '$sql_recent_reviews[review_id]' AND review_main.review_edit = '0'
        ORDER BY RAND() LIMIT 1"
    ) or die("Error - Couldn't query review screenshots");

    $sql_screenshots_review = $query_screenshots_review->fetch_array(MYSQLI_BOTH);

    $new_path = $game_screenshot_path;
    $new_path .= $sql_screenshots_review['screenshot_id'];
    $new_path .= ".";
    $new_path .= $sql_screenshots_review['imgext'];

    //convert the date to readible format
    $review_date = date("F j, Y", $sql_recent_reviews['review_date']);

    $smarty->append(
        'recent_reviews', array(
        'review_name' => $sql_recent_reviews['game_name'],
        'review_id' => $sql_recent_reviews['review_id'],
        'review_author' => $sql_recent_reviews['userid'],
        'review_author_id' => $sql_recent_reviews['user_id'],
        'review_date' => $review_date,
        'game_id' => $sql_recent_reviews['game_id'],
        'review_text' => $review_text,
        'review_img' => $new_path
        )
    );
}

//get all the authors
$query_authors = $mysqli->query(
    "SELECT * FROM review_main
                                    LEFT JOIN users ON (review_main.user_id = users.user_id)
                                    group by users.user_id ORDER BY userid"
);

while ($sql_author = $query_authors->fetch_array(MYSQLI_BOTH)) {
    $smarty->append(
        'authors', array(
        'author_id' => $sql_author['user_id'],
        'author_name' => $sql_author['userid']
        )
    );
}

$smarty->assign('nr_reviews', $total_rows);
$smarty->assign('author_reviews', $v_rows);

//Check if back arrow is needed
if ($v_counter > 0) {
    // Build the link
    $v_linkback = ('?v_counter=' . ($v_counter - 5));
    if (isset($action) and $action == 'search') {
        if ($author_id != '-') {
            $v_linkback .= '&author_id=' . $author_id . '&action=search';
        }
    }
}

//Check if we need to place a next arrow
if ($v_rows > ($v_counter + 5)) {
    //Build the link
    $v_linknext = ('?v_counter=' . ($v_counter + 5));
    if (isset($action) and $action == 'search') {
        if ($author_id != '-') {
            $v_linknext .= '&author_id=' . $author_id . '&action=search';
        }
    }
}

if (empty($c_counter)) {
    $c_counter = "";
}
if (empty($v_linkback)) {
    $v_linkback = "";
}
if (empty($v_linknext)) {
    $v_linknext = "";
}

$smarty->assign(
    'links', array(
    'linkback' => $v_linkback,
    'linknext' => $v_linknext,
    'v_counter' => $v_counter,
    'c_counter' => $c_counter
    )
);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "games/games_reviews_main.html");

//close the connection
mysqli_close($mysqli);
