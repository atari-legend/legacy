<?php
/***************************************************************************
*                                latest_reviews_tile.php
*                            -------------------------------
*   begin                : Tuesday, April 14, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: latest_reviews_tile.php,v 0.1 2015/04/14 22:56 ST Graveyard
*   Id: latest_reviews_tile.php,v 0.2 2017/05/24 08:38 ST Graveyard
*           - added the [frontpage] functionality
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the latest reviews/indepth reviews tile
//*********************************************************************************************

//Get the latest reviews
$query_recent_reviews = $mysqli->query("SELECT
						review_game.review_id,
						review_game.game_id,
						review_main.review_edit,
						review_main.review_text,
                        review_main.review_date,
						game.game_name,
                        users.user_id,
                        users.userid,
						screenshot_review.screenshot_id,
						screenshot_main.imgext
						FROM review_game
						LEFT JOIN review_main on (review_game.review_id = review_main.review_id)
                        LEFT JOIN users on (review_main.user_id = users.user_id)
						LEFT JOIN game on (review_game.game_id = game.game_id)
						LEFT JOIN screenshot_review on (review_game.review_id = screenshot_review.review_id)
						LEFT JOIN screenshot_main on (screenshot_review.screenshot_id = screenshot_main.screenshot_id)
						WHERE review_main.review_edit = '0'
						GROUP BY game_id
						ORDER BY review_main.review_date DESC LIMIT 3") or die("couldn't get 3 latest reviews");

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

    //Ready screenshots path and filename
    $v_review_image  = $game_screenshot_path;
    $v_review_image .= $sql_recent_reviews['screenshot_id'];
    $v_review_image .= '.';
    $v_review_image .= $sql_recent_reviews['imgext'];

    //convert the date to readible format
    $review_date = date("F j, Y", $sql_recent_reviews['review_date']);

    $smarty->append(

        'recent_reviews',
        array('review_name' => $sql_recent_reviews['game_name'],
           'review_id' => $sql_recent_reviews['review_id'],
           'review_date' => $review_date,
           'user_id' => $sql_recent_reviews['user_id'],
           'user_name' => $sql_recent_reviews['userid'],
           'game_id' => $sql_recent_reviews['game_id'],
           'review_text' => $review_text,
           'review_img' => $v_review_image)
    );
}
