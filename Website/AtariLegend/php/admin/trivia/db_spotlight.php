<?php
/***************************************************************************
 *                                db_spotlight.php
 *                            -----------------------
 *   begin                : Wednesday, September 20, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: db_spotlight.php,v 1.0  2017/09/20 ST Graveyard
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if ($action == "spotlight_insert") {
    
    if ($spot_text == '')
    {
        $_SESSION['edit_message'] = "Please add an actual spotlight in the textfield";
        header("Location: ../trivia/spotlight.php");
    }
    else
    {
        if ($spot_screen != 'file(s) selected')
        {
            $_SESSION['edit_message'] = "Please select a screenshot in the textfield";
            header("Location: ../trivia/spotlight.php"); 
        }
        else
        {
             
                      
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

                        $mysqli->query("INSERT INTO spotlight ( spotlight, screenshot_id, link ) VALUES ('$spot_text', $new_screenshot_id, '$link')") or die ("Inserting the spotlight failed");
                            
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
                        
                        header("Location: ../trivia/spotlight.php");        
                    }  
                    else
                    {
                       $_SESSION['edit_message'] = "Please select a screenshot in jpg, png or gif";
                       header("Location: ../trivia/spotlight.php");  
                    }      
                }
            }
        }             
    }
}
    

if ($action == "spotlight_delete") {
    //****************************************************************************************
    // This is the delete spotlight
    //****************************************************************************************

    if (isset($spotlight_id)) {
        
        //Let's get the screenshot id
        $query_spotlight_screenshot = $mysqli->query("SELECT * FROM spotlight WHERE spotlight_id = " . $spotlight_id . "") or die("something is wrong with mysqli of spotlight screenshots");
        
        while ($sql_spotlight_screenshot = $query_spotlight_screenshot->fetch_array(MYSQLI_BOTH))
        {
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
   
        $_SESSION['edit_message'] = "Spotlight deleted";
        header("Location: ../trivia/spotlight.php");  
    }
}
