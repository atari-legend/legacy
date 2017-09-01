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

//load the tiles
include("../../common/tiles/screenstar.php");


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

if (isset($_SESSION['user_id']))
{
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
}    

$smarty->assign("game_id", $game_id);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "games_reviews_add.html");

//close the connection
mysqli_close($mysqli);
