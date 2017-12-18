<?php
/***************************************************************************
*                                screenstar.php
*                            -----------------------
*   begin                : Tuesday, April 16, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: screenstar.php,v 0.1 2015/04/16 22:54 Silver Surfer
*
***************************************************************************/

//*********************************************************************************************
// This is the php for the screenstar tile of AtariLegend
//*********************************************************************************************

//Select the screenstar info from the DB
$query_screenstar = $mysqli->query("SELECT 
					game.game_name,
					game.game_id,
					review_main.review_text,
                    review_main.review_date,
                    review_main.review_id,
                    users.user_id,
                    users.userid,
                    pub_dev.pub_dev_name,
                    game_year.game_year,
					screenshot_main.screenshot_id,
					screenshot_main.imgext
					FROM review_game
					LEFT JOIN review_main ON (review_game.review_id = review_main.review_id)
					LEFT JOIN game ON (review_game.game_id = game.game_id)
                    LEFT JOIN users ON (review_main.user_id = users.user_id)
					LEFT JOIN screenshot_game ON (game.game_id = screenshot_game.game_id)
					LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
                    LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
                    LEFT JOIN pub_dev ON (pub_dev.pub_dev_id = game_developer.dev_pub_id)
                    LEFT JOIN game_year ON (game_year.game_id = game.game_id)
					WHERE CHAR_LENGTH( game_name ) <15 ORDER BY RAND() LIMIT 1") or die("query error, screenstar");

$sql_screenstar = $query_screenstar->fetch_array(MYSQLI_BOTH);
    
    //Structure and manipulate the comment text
    $screenstar_review = $sql_screenstar['review_text'];
$pos_start = strpos($screenstar_review, '[screenstar]');
$pos_start = $pos_start;
$pos_end = strpos($screenstar_review, '[/screenstar]');
$pos_end = $pos_end;
$nr_char = $pos_end - $pos_start;
$screenstar_review = substr($screenstar_review, $pos_start, $nr_char);
      
    $screenstar_review = stripslashes($screenstar_review);
    $screenstar_review = InsertALCode($screenstar_review);
    $screenstar_review = trim($screenstar_review);
    $screenstar_review = RemoveSmillies($screenstar_review);
    
    //Ready screenshots path and filename
    $screenstar_image  = $game_screenshot_path;
    $screenstar_image .= $sql_screenstar['screenshot_id'];
    $screenstar_image .= '.';
    $screenstar_image .= $sql_screenstar['imgext'];
        
    $smarty->assign(
        'screenstar',
        array('screenstar_game_name' => $sql_screenstar['game_name'],
           'screenstar_review' => $screenstar_review,
           'screenstar_review_id' => $sql_screenstar['review_id'],
           'screenstar_user_id' => $sql_screenstar['user_id'],
           'screenstar_username' => $sql_screenstar['userid'],
           'screenstar_game_id' => $sql_screenstar['game_id'],
           'screenstar_date'  => date("d/m/Y", $sql_screenstar['review_date']),
           'screenstar_developer' => $sql_screenstar['pub_dev_name'],
           'screenstar_year' => $sql_screenstar['game_year'],
           'screenstar_img' => $screenstar_image)
    );
