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

    $_SESSION['edit_message'] = "Did You Know quote added to the database";

    header("Location: ../trivia/did_you_know.php");

    mysqli_close($mysqli);
}

//****************************************************************************************
// Delete did you know quote!
//****************************************************************************************
if (isset($action) and $action == "did_you_know_delete") {
    create_log_entry('Trivia', $trivia_id, 'DYK', $trivia_id, 'Delete', $_SESSION['user_id']);

    $sql = $mysqli->query("DELETE FROM trivia WHERE trivia_id = '$trivia_id'") or die("Couldn't delete trivia text");
    
    //Let's get all the trivia
    $sql_trivia = $mysqli->query("SELECT * FROM trivia ORDER BY trivia_id");
    
    $osd_message = "Did you know quote has been deleted";
   
    while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
        $trivia_text = nl2br($query_trivia['trivia_text']);
        $trivia_text = stripslashes($trivia_text);

        $smarty->append('trivia', array(
            'trivia_id' => $query_trivia['trivia_id'],
            'trivia_text' => $trivia_text
        ));
    }
    
    $smarty->assign('osd_message', $osd_message);

    $smarty->assign('smarty_action', 'delete_did_you_know');
    
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_did_you_know.html");
}

//****************************************************************************************
// Delete trivia quote!
//****************************************************************************************
if (isset($action) and $action == "delete_trivia_quote") {
    if (isset($trivia_quote_id)) {
        create_log_entry('Trivia', $trivia_quote_id, 'Quote', $trivia_quote_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM trivia_quotes WHERE trivia_quote_id = '$trivia_quote_id'") or die("couldn't delete trivia quote");

        $osd_message = "trivia quote has been deleted";
        
        //Get all the trivia quotes
        $sql_trivia = $mysqli->query("SELECT * FROM trivia_quotes ORDER BY trivia_quote_id");

        while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
            $smarty->append('trivia', array(
                'trivia_quote_id' => $query_trivia['trivia_quote_id'],
                'trivia_quote' => $query_trivia['trivia_quote']
            ));
        }
        
        $smarty->assign('osd_message', $osd_message);

        $smarty->assign('smarty_action', 'delete_trivia_quote');
        
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
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
    if (isset($trivia_text)) {
        $trivia_quote = $mysqli->real_escape_string($trivia_text);

        $mysqli->query("UPDATE trivia_quotes SET trivia_quote='$trivia_quote' WHERE trivia_quote_id = $trivia_quote_id") or die('Error: ' . mysqli_error($mysqli));

        create_log_entry('Trivia', $trivia_quote_id, 'Quote', $trivia_quote_id, 'Edit', $_SESSION['user_id']);
        
        $trivia_text = stripslashes($trivia_quote);

        $smarty->assign('trivia_quote_id', $trivia_quote_id);
        $smarty->assign('trivia_text', $trivia_text);

        $smarty->assign('smarty_action', 'trivia_quote_update_returnview');
        //Send all smarty variables to the templates
        $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
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
