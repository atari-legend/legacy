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
//include("../../config/admin_rights.php");

if (isset($action) and $action == "did_you_know_insert") {
    //****************************************************************************************
    // Insert did you know quote!
    //****************************************************************************************
    include("../../config/admin_rights.php");
    
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
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        create_log_entry('Trivia', $trivia_id, 'DYK', $trivia_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM trivia WHERE trivia_id = '$trivia_id'") or die("Couldn't delete trivia text");
        
        //Let's get all the trivia
        $sql_trivia = $mysqli->query("SELECT * FROM trivia ORDER BY trivia_id");
        
        $osd_message = "Did you know quote has been deleted";
    }else{
        $osd_message = "You don't have permission to perform this task";        
    }
    
    $sql_trivia = $mysqli->query("SELECT * FROM trivia ORDER BY trivia_id");
    
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
    $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
}

//****************************************************************************************
// Delete trivia quote!
//****************************************************************************************
if (isset($action) and $action == "delete_trivia_quote") {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {   
        create_log_entry('Trivia', $trivia_quote_id, 'Quote', $trivia_quote_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM trivia_quotes WHERE trivia_quote_id = '$trivia_quote_id'") or die("couldn't delete trivia quote");

        $osd_message = "trivia quote has been deleted";
        
    }else{
        $osd_message = "You don't have permission to perform this task";        
    }
    
    //Get all the trivia quotes
    $sql_trivia = $mysqli->query("SELECT * FROM trivia_quotes ORDER BY trivia_quote_id") or die("error getting trivia");

    while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
        $trivia_text = nl2br($query_trivia['trivia_quote']);
        $trivia_text = stripslashes($trivia_text);
        
        $smarty->append('trivia', array(
            'trivia_quote_id' => $query_trivia['trivia_quote_id'],
            'trivia_quote' => $trivia_text
        ));
    }
    
    $smarty->assign('osd_message', $osd_message);

    $smarty->assign('smarty_action', 'delete_trivia_quote');
    
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
}

//****************************************************************************************
// Add trivia quote!
//****************************************************************************************
if (isset($action) and $action == "add_trivia") {
    if (isset($trivia_quote)) {
        include("../../config/admin_rights.php");
        
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
        if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
    
            $trivia_quote = $mysqli->real_escape_string($trivia_text);

            $mysqli->query("UPDATE trivia_quotes SET trivia_quote='$trivia_quote' WHERE trivia_quote_id = $trivia_quote_id") or die('Error: ' . mysqli_error($mysqli));

            create_log_entry('Trivia', $trivia_quote_id, 'Quote', $trivia_quote_id, 'Edit', $_SESSION['user_id']);
            
            $osd_message = "Trivia quote updated";      
        }else{
            $osd_message = "You don't have permission to perform this task";        
        }
        
        $smarty->assign('osd_message', $osd_message);
        
        $sql_trivia = $mysqli->query("SELECT * FROM trivia_quotes ORDER BY trivia_quote_id");

        while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
            $smarty->append('trivia', array(
                'trivia_quote_id' => $query_trivia['trivia_quote_id'],
                'trivia_quote' => $query_trivia['trivia_quote']
            ));
        }

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
        if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {    
            $trivia_text = $mysqli->real_escape_string($trivia_text);

            $mysqli->query("UPDATE trivia SET trivia_text='$trivia_text' WHERE trivia_id = $trivia_id") or die('Error: ' . mysqli_error($mysqli));

            create_log_entry('Trivia', $trivia_id, 'Quote', $trivia_id, 'Edit', $_SESSION['user_id']);
            $osd_message = "Trivia quote updated";
        }else{
            $osd_message = "You don't have permission to perform this task";        
        }
        
        $sql_trivia = $mysqli->query("SELECT * FROM trivia ORDER BY trivia_id");
    
        while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH)) {
            $trivia_text = nl2br($query_trivia['trivia_text']);
            $trivia_text = stripslashes($trivia_text);

            $smarty->append('trivia', array(
                'trivia_id' => $query_trivia['trivia_id'],
                'trivia_text' => $trivia_text
            ));
        }
        
        $smarty->assign('osd_message', $osd_message);

        $smarty->assign('smarty_action', 'did_you_know_update_returnview');
        //Send all smarty variables to the templates
        $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
    }
}

//****************************************************************************************
// This is the delete spotlight
//****************************************************************************************
if ($action == "spotlight_delete") {
    if (isset($spotlight_id)) {
        if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {    
            //Let's get the screenshot id
            $query_spotlight_screenshot = $mysqli->query("SELECT * FROM spotlight WHERE spotlight_id = " . $spotlight_id . "") or die("something is wrong with mysqli of spotlight screenshots");

            while ($sql_spotlight_screenshot = $query_spotlight_screenshot->fetch_array(MYSQLI_BOTH)) {
                $screenshot_id = $sql_spotlight_screenshot['screenshot_id'];

                //get the extension
                $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
                                          WHERE screenshot_id = '$screenshot_id'") or die("Database error - selecting screenshots");

                $screenshotrow  = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
                $screenshot_ext = $screenshotrow['imgext'];

                $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");

                $new_path = $spotlight_screenshot_save_path;
                $new_path .= $screenshot_id;
                $new_path .= ".";
                $new_path .= $screenshot_ext;

                unlink("$new_path");
            }

            create_log_entry('Trivia', $spotlight_id, 'Spotlight', $spotlight_id, 'Delete', $_SESSION['user_id']);

            $sql = $mysqli->query("DELETE FROM spotlight WHERE spotlight_id = '$spotlight_id'") or die("couldn't delete spotlight");
            
            $osd_message = "Spotlight deleted";
        }else{
            $osd_message = "You don't have permission to perform this task";        
        }
        
        
        //load the existing spotlight entries
        $query_spotlight = $mysqli->query("SELECT * from spotlight
                                                    LEFT JOIN screenshot_main ON (spotlight.screenshot_id = screenshot_main.screenshot_id)") or die("error in query spotlight");

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
        
        $smarty->assign('osd_message', $osd_message);

        $smarty->assign('smarty_action', 'delete_spotlight');
        
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
    }
}

//****************************************************************************************
// This is we add a new spotlight
//****************************************************************************************
if ($action == "spotlight_insert") {
    
    include("../../config/admin_rights.php");
    
    if ($spot_text == '') {
        $_SESSION['edit_message'] = "Please add an actual spotlight in the textfield";
        header("Location: ../trivia/spotlight.php");
    } else {
        if ($spot_screen != 'file(s) selected') {
            $_SESSION['edit_message'] = "Please select a screenshot in the textfield";
            header("Location: ../trivia/spotlight.php");
        } else {
            //Here we'll be looping on each of the inputs on the page that are filled in with an image!
            $image = $_FILES['image'];

            foreach ($image['tmp_name'] as $key => $tmp_name) {
                if ($tmp_name !== 'none') {
                    // Check what extention the file has and if it is allowed.

                    $ext        = "";
                    $type_image = $image['type'][$key];

                    // set extension
                    if ($type_image == 'image/png') {
                        $ext = 'png';
                    }

                    if ($type_image == 'image/x-png') {
                        $ext = 'png';
                    } elseif ($type_image == 'image/gif') {
                        $ext = 'gif';
                    } elseif ($type_image == 'image/jpeg') {
                        $ext = 'jpg';
                    }

                    if ($ext !== "") {
                        // First we insert the directory path of where the file will be stored... this also creates an autoinc number for us.
                        $sdbquery = $mysqli->query("INSERT INTO screenshot_main (screenshot_id,imgext) VALUES ('','$ext')") or die("Database error - inserting screenshots");

                        $new_screenshot_id = $mysqli->insert_id;

                        $spot_text = $mysqli->real_escape_string($spot_text);

                        $mysqli->query("INSERT INTO spotlight ( spotlight, screenshot_id, link ) VALUES ('$spot_text', $new_screenshot_id, '$link')") or die("Inserting the spotlight failed");

                        $new_spotlight_id = $mysqli->insert_id;
                        create_log_entry('Trivia', $new_spotlight_id, 'Spotlight', $new_spotlight_id, 'Insert', $_SESSION['user_id']);

                        //select the newly entered screenshot_id from the main table
                        $SCREENSHOT = $mysqli->query("SELECT screenshot_id FROM screenshot_main
                                               ORDER BY screenshot_id desc") or die("Database error - selecting screenshots");

                        $screenshotrow = $SCREENSHOT->fetch_row();
                        $screenshot_id = $screenshotrow[0];

                        // Rename the uploaded file to its autoincrement number and move it to its proper place.
                        $file_data = rename($image['tmp_name'][$key], "$spotlight_screenshot_save_path$screenshotrow[0].$ext");

                        chmod("$spotlight_screenshot_save_path$screenshotrow[0].$ext", 0777);
                        
                        $_SESSION['edit_message'] = "Spotlight added to the database";
                        header("Location: ../trivia/spotlight.php");
                    } else {
                        $_SESSION['edit_message'] = "Please select a screenshot in jpg, png or gif";
                        header("Location: ../trivia/spotlight.php");
                    }
                }
            }
        }
    }
}

//****************************************************************************************
// Edit spotlight!
//****************************************************************************************
if (isset($action) and $action == "update_spotlight") {
    if (isset($spot_text)) {
        if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {    
        
            $trivia_text = $mysqli->real_escape_string($spot_text);

            $mysqli->query("UPDATE spotlight SET spotlight='$trivia_text' WHERE spotlight_id = $spotlight_id") or die('Error: ' . mysqli_error($mysqli));

            create_log_entry('Trivia', $spotlight_id, 'Spotlight', $spotlight_id, 'Edit', $_SESSION['user_id']);
            
            $osd_message = "Spotlight has been updated";        
        }else{
            $osd_message = "You don't have permission to perform this task";        
        }

        //load the existing spotlight entries
        $query_spotlight = $mysqli->query("SELECT * from spotlight
                                                    LEFT JOIN screenshot_main ON (spotlight.screenshot_id = screenshot_main.screenshot_id)") or die("error in query spotlight");

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
        
        $smarty->assign('osd_message', $osd_message);
        
        $smarty->assign('smarty_action', 'spotlight_update_returnview');
        //Send all smarty variables to the templates
        $smarty->display("file:" . $cpanel_template_folder . "ajax_trivia_quotes_edit.html");
    }
}
