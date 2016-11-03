<?php
/***************************************************************************
 *                                did_you_know.php
 *                            -----------------------
 *   begin                : Saturday, May 01, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : file creation
 *
 *
 *   Id: did_you_know.php,v 0.10 2005/05/01 Silver Surfer
 *   Id: did_you_know.php,v 0.20 2015/09/04 ST Graveyard
 *   Id: did_you_know.php,v 0.30 2015/12/21 ST Graveyard - right side 1920 width
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Manage our Did you know? quotes!
 ***********************************************************************************
 */

include("../../includes/common.php");
include("../../includes/quick_search_games.php");
include("../../includes/admin.php");

$sql_trivia = $mysqli->query("SELECT * FROM trivia ORDER BY trivia_id");


while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
    $trivia_text = nl2br($query_trivia['trivia_text']);
    $trivia_text = stripslashes($trivia_text);

    $smarty->append('trivia', array(
        'trivia_id' => $query_trivia['trivia_id'],
        'trivia_text' => $trivia_text
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "did_you_know.html");

?>
