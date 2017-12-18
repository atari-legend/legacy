<?php
/***************************************************************************
 *                                db_trivia.php
 *                            -----------------------
 *   begin                : Saturday, May 1, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 *   Id: db_trivia.php,v 1.00 2005/05/01 Silver Surferµ
 *   Id: db_trivia.php,v 1.00 2015/12/21 ST Graveyard - Added messages
 *   Id: db_trivia.php,v 1.00 2016/08/19 ST Graveyard - Added change log
 *
 ***************************************************************************/

// This document contain all the code needed to operate the trivia database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if (isset($action) and $action == "did_you_know_insert") {
    //****************************************************************************************
    // Insert did you know quote!
    //****************************************************************************************
    $trivia_text = $mysqli->real_escape_string($trivia_text);

    $sql = $mysqli->query("INSERT INTO trivia (trivia_text) VALUES ('$trivia_text')") or die("Couldn't insert trivia text");

    $new_trivia_id = $mysqli->insert_id;

    create_log_entry('Trivia', $new_trivia_id, 'DYK', $new_trivia_id, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "trivia quote added to the database";

    header("Location: ../trivia/did_you_know.php");

    mysqli_close($mysqli);
}

//****************************************************************************************
// Delete did you know quote!
//****************************************************************************************

if (isset($action) and $action == "did_you_know_delete") {
    create_log_entry('Trivia', $trivia_id, 'DYK', $trivia_id, 'Delete', $_SESSION['user_id']);

    $sql = $mysqli->query("DELETE FROM trivia WHERE trivia_id = '$trivia_id'") or die("Couldn't delete trivia text");
    echo "trivia quote has been deleted";

    mysqli_close($mysqli);
}

//****************************************************************************************
// Delete trivia quote!
//****************************************************************************************

if (isset($action) and $action == "delete_trivia_quote") {
    if (isset($trivia_quote_id)) {
        create_log_entry('Trivia', $trivia_quote_id, 'Quote', $trivia_quote_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM trivia_quotes WHERE trivia_quote_id = '$trivia_quote_id'") or die("couldn't delete trivia quote");

        $_SESSION['edit_message'] = "trivia quote has been deleted";
        header("Location: ../trivia/manage_trivia_quotes.php");
    }
}

//****************************************************************************************
// Add trivia quote!
//****************************************************************************************

if (isset($action) and $action == "add_trivia") {
    if (isset($trivia_quote)) {
        $trivia_quote = $mysqli->real_escape_string($trivia_quote);

        $mysqli->query("INSERT INTO trivia_quotes (trivia_quote) VALUES ('$trivia_quote')") or die('Error: ' . mysqli_error($mysqli));

        $new_trivia_id = $mysqli->insert_id;
        create_log_entry('Trivia', $new_trivia_id, 'Quote', $new_trivia_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "trivia quote added to the database";

        header("Location: ../trivia/manage_trivia_quotes.php");
    }
}

//****************************************************************************************
// Edit trivia quote!
//****************************************************************************************

if (isset($action) and $action == "edit_trivia_quote") {
    if (isset($trivia_quote)) {
        $trivia_quote = $mysqli->real_escape_string($trivia_quote);
        $mysqli->query("UPDATE trivia_quotes SET trivia_quote='$trivia_quote' WHERE trivia_quote_id = $trivia_quote_id") or die('Error: ' . mysqli_error($mysqli));
        create_log_entry('Trivia', $trivia_quote_id, 'Quote', $trivia_quote_id, 'Edit', $_SESSION['user_id']);
        echo "Trivia Quote updated!";
    }
}

//****************************************************************************************
// Edit did you know quote!
//****************************************************************************************

if (isset($action) and $action == "update_trivia") {
    if (isset($trivia_text)) {
        $trivia_text = $mysqli->real_escape_string($trivia_text);
        $mysqli->query("UPDATE trivia SET trivia_text='$trivia_text' WHERE trivia_id = $trivia_id") or die('Error: ' . mysqli_error($mysqli));
        create_log_entry('Trivia', $trivia_id, 'Quote', $trivia_id, 'Edit', $_SESSION['user_id']);
        $trivia_text = stripslashes($trivia_text);
        $smarty->assign('trivia_id', $trivia_id);
        $smarty->assign('trivia_text', $trivia_text);
        $smarty->assign('smarty_action', 'did_you_know_update_returnview');
    //Send all smarty variables to the templates
        $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
    }
}
