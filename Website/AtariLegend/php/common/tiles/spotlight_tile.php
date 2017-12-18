<?php
/***************************************************************************
*                                spotlight_tile.php
*                            ----------------------------
*   begin                : Wednesday 20 september, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id:  spotlight_tile.php,v 0.1 2017/09/20 22:31 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for spotlight tile
//*********************************************************************************************

//lets get a random spotlight entry
$query_spotlight = $mysqli->query("SELECT * from spotlight
                                            LEFT JOIN screenshot_main ON (spotlight.screenshot_id = screenshot_main.screenshot_id)
                                            ORDER BY RAND() LIMIT 1") or die("error in query spotlight");

$sql_spotlight = $query_spotlight->fetch_array(MYSQLI_BOTH);
$new_path = $spotlight_screenshot_path;
$new_path .= $sql_spotlight['screenshot_id'];
$new_path .= ".";
$new_path .= $sql_spotlight['imgext'];
    
$smarty->assign('spotlight', array(
    'spotlight_id' => $sql_spotlight['spotlight_id'],
    'spotlight_screenshot' => $new_path,
    'link' => $sql_spotlight['link'],
    'spotlight' => $sql_spotlight['spotlight']
));
