<?php
/***************************************************************************
 *                                manage_trivia_quotes.php
 *                            --------------------------------
 *   begin                : Saturday, May 01, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : file creation
 *
 *
 *   Id: manage_trivia_quotes.php,v 1.10 2005/08/12 Silver Surfer
 *   Id: manage_trivia_quotes.php,v 1.20 2015/09/04 ST Graveyard
 *   Id: manage_trivia_quotes.php,v 1.30 2015/12/21 ST Graveyard - add right side 1920 width
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Manage our trivia quotes!
 ***********************************************************************************
 */
include("../../config/common.php");
include("../../includes/quick_search_games.php");
include("../../config/admin.php");

$sql_trivia = $mysqli->query("SELECT * FROM trivia_quotes ORDER BY trivia_quote_id");

while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('trivia', array(
        'trivia_quote_id' => $query_trivia['trivia_quote_id'],
        'trivia_quote' => $query_trivia['trivia_quote']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "manage_trivia_quotes.html");
