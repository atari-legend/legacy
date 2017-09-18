<?php
/***************************************************************************
*                              db_tile_bug_report.php
*                            --------------------------
*   begin                : September 12, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: db_tile_bug_report,v 0.10 2017/09/12 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code where we add a news submission
//*********************************************************************************************

include("../../config/common.php");

if (isset($textfield_bug) and $textfield_bug != 'Bug report' and $textfield_bug != '' and $bug_report_type != '-')
{
    $timestamp = time();
    $textfield = $mysqli->real_escape_string($textfield_bug);
    $mysqli->query("INSERT INTO bug_report (bug_report_type_id, bug_report_text, user_id, bug_report_date ) VALUES ('$bug_report_type', '$textfield', '$_SESSION[user_id]', '$timestamp')") or die ("Inserting the bug report failed");
    
    $new_bug_report_id = $mysqli->insert_id;
    create_log_entry('Bug', $new_bug_report_id, 'Bug', $new_bug_report_id, 'Insert', $_SESSION['user_id']);  
    
    $_SESSION['edit_message'] = "Bug report submitted correctly - Thank you";
}
else
{
    $_SESSION['edit_message'] = "Please fill in all required fields";
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
die('');
?>
