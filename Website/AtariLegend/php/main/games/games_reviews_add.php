<?php
/***************************************************************************
 *                                games_review_add.php
*                            ------------------------------
*   begin                : Tuesday, 29 August, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: games_review_add.php,v 0.10 29/08/2017 20:20 STG
****************************************************************************/

//****************************************************************************************
// This is the detail page of a game.
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the tiles
$type = 'user';
include("../../common/tiles/latest_comments_tile.php");

$user_id_contrib = $_SESSION['user_id'];
include("../../common/tiles/user_contribution.php");

include("../../common/tiles/latest_reviews_tile.php");
include("../../common/tiles/tile_bug_report.php");

//***********************************************************************************
//get the name of the game
//***********************************************************************************
$sql_game = $mysqli->query("SELECT * FROM game WHERE game.game_id='$game_id'")
                            or die("Error getting game info");

while ($game_info = $sql_game->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('game_info', array(
        'game_name' => $game_info['game_name'],
        'game_id' => $game_info['game_id']
    ));
}

if (isset($_SESSION['user_id'])) {
    //***********************************************************************************
    //Get the screenshots
    //***********************************************************************************
    //Get the screenshots for this game, if they exist
    $sql_screenshots = $mysqli->query("SELECT * FROM screenshot_game
                        LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
                        WHERE screenshot_game.game_id = '$game_id' ORDER BY screenshot_game.screenshot_id") or die("Database error - selecting screenshots");

    $count = 0;

    while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
        //Ready screenshots path and filename
        $screenshot_image = $game_screenshot_save_path;
        $screenshot_image .= $screenshots['screenshot_id'];
        $screenshot_image .= '.';
        $screenshot_image .= $screenshots['imgext'];

        $screenshot_image_pop = $game_screenshot_path;
        $screenshot_image_pop .= $screenshots['screenshot_id'];
        $screenshot_image_pop .= '.';
        $screenshot_image_pop .= $screenshots['imgext'];

        $smarty->append('screenshots', array(
            'count' => $count,
            'path' => $game_screenshot_path,
            'screenshot_image' => $screenshot_image,
            'screenshot_image_pop' => $screenshot_image_pop,
            'id' => $screenshots['screenshot_id']
        ));
        $count++;
    }

    $smarty->assign("nr_screenshots", $count);

    //Lets get all the reviews by this author
    $sql_reviews_author = $mysqli->query("SELECT * FROM review_main
                               LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
                               LEFT JOIN game ON (game.game_id = review_game.game_id)
                               LEFT JOIN users ON (review_main.user_id = users.user_id)
                               WHERE review_main.user_id = '$_SESSION[user_id]'
                               AND review_main.review_edit = '0' ORDER BY game.game_name") or die("problem with query");

    $count = 0;

    while ($query_reviews_author = $sql_reviews_author->fetch_array(MYSQLI_BOTH)) {
        $count++;

        $smarty->append('reviews_author', array(
                'review_id' => $query_reviews_author['review_id'],
                'game_name' => $query_reviews_author['game_name'],
                'game_id' => $query_reviews_author['game_id'],
                'user_name' => $query_reviews_author['userid'],
                'user_id' => $query_reviews_author['user_id']
            ));
    }

    $smarty->assign('nr_reviews_author', $count);
}

$smarty->assign("game_id", $game_id);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "games_reviews_add.html");

//close the connection
mysqli_close($mysqli);
