<?php
/***************************************************************************
 *                                spotlight.php
 *                            -----------------------
 *   begin                : Wednesday, September 20, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: spotlight.php,v 1.0  2017/09/20 ST Graveyard
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//load the existing spotlight entries
$query_spotlight = $mysqli->query("SELECT * from spotlight
    LEFT JOIN screenshot_main ON (spotlight.screenshot_id = screenshot_main.screenshot_id)")
    or die("error in query spotlight");

while ($sql_spotlight = $query_spotlight->fetch_array(MYSQLI_BOTH)) {
    $new_path = $spotlight_screenshot_path;
    $new_path .= $sql_spotlight['screenshot_id'];
    $new_path .= ".";
    $new_path .= $sql_spotlight['imgext'];

    $smarty->append('spotlight', array(
        'spotlight_id' => $sql_spotlight['spotlight_id'],
        'spotlight_screenshot' => $new_path,
        'link' => $sql_spotlight['link'],
        'spotlight' => $sql_spotlight['spotlight']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "trivia/spotlight.html");
