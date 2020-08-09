<?php
/***************************************************************************
 *                                ajax_game_facts.php
 *                            -----------------------
 *   begin                : 2018-05-15
 *   copyright            : (C) 2018 Atari Legend
 *
 ***************************************************************************/

// This document contain all the code needed to operate the trivia database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
//include("../../config/admin_rights.php");

if (isset($fact_id) and $action == "game_fact_edit_view") {
    //load the fact
    $query_game_fact = $mysqli->query("SELECT * from game_fact
                                       WHERE game_fact_id = $fact_id") or die("error in query game facts");
    $query_fact = $query_game_fact->fetch_array(MYSQLI_BOTH);
    $smarty->assign('fact_id', $query_fact['game_fact_id']);
    $smarty->assign('fact_text', $query_fact['game_fact']);

    $smarty->assign('smarty_action', 'game_fact_edit_view');
    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "games/ajax_game_facts_edit.html");
}
