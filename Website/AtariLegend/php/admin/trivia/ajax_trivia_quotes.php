<?php
/***************************************************************************
 *                                ajax_trivia_quotes.php
 *                            -----------------------
 *   begin                : 2017-11-25
 *   copyright            : (C) 2017 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *
 *
 ***************************************************************************/

// This document contain all the code needed to operate the trivia database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if (isset($trivia_quote_id) and $action == "edit_trivia_quote") {
    $sql_trivia = $mysqli->query("SELECT * FROM trivia_quotes WHERE trivia_quote_id = $trivia_quote_id");

    if ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('trivia_quote_id', $query_trivia['trivia_quote_id']);
        $smarty->assign('trivia_quote', $query_trivia['trivia_quote']);
    }

    $smarty->assign('smarty_action', 'trivia_quote_edit');
    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
}

if (isset($trivia_quote_id) and $action == "display_trivia_quoute") {
    $sql_trivia = $mysqli->query("SELECT * FROM trivia_quotes WHERE trivia_quote_id = $trivia_quote_id");

    if ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('trivia_quote_id', $query_trivia['trivia_quote_id']);
        $smarty->assign('trivia_quote', $query_trivia['trivia_quote']);
    }

    $smarty->assign('smarty_action', 'display_trivia_quoute');
    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
}

if (isset($trivia_id) and $action == "did_you_know_edit_view") {
    $sql_trivia = $mysqli->query("SELECT * FROM trivia WHERE trivia_id = $trivia_id");
    $query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH);
    $smarty->assign('trivia_id', $query_trivia['trivia_id']);
    $smarty->assign('trivia_text', $query_trivia['trivia_text']);

    $smarty->assign('smarty_action', 'did_you_know_edit_view');
    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
}

if (isset($spotlight_id) and $action == "spotlight_edit_view") {
    //load the existing spotlight entries
    $query_spotlight = $mysqli->query("SELECT * from spotlight
                                            LEFT JOIN screenshot_main ON (spotlight.screenshot_id = screenshot_main.screenshot_id)
                                            WHERE spotlight_id = $spotlight_id") or die("error in query spotlight");

    if ($sql_spotlight = $query_spotlight->fetch_array(MYSQLI_BOTH)) {
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
    }

    $smarty->assign('smarty_action', 'spotlight_edit_view');
    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
}
