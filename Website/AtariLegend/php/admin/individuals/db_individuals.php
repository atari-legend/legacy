<?php
/***************************************************************************
 *                                Individuals_edit.php
 *                            --------------------------
 *   begin                : Saturday, August 6, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : Creation of file
 *
 *   Id: Individuals_edit.php,v 0.10 2005/08/06 15:25 Gatekeeper
 *   Id: Individuals_edit.php,v 0.20 2016/08/01 23:36 Gatekeeper
 *        - AL 2.0 - adding messages
 *   Id: Individuals_edit.php,v 0.21 2016/08/20 23:36 Gatekeeper
 *        - adding change log
 *   Id: Individuals_edit.php,v 0.22 2017/05/05 19:31 Gatekeeper
 *        - solved delete bug
 *
 ***************************************************************************/

/*
 ************************************************************************************************
 The individuals edit page
 ************************************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

// Here we delete the individual image
if (isset($ind_id) and isset($action) and $action == 'delete_pic') {
    $photo = $mysqli->query("SELECT ind_imgext FROM individual_text WHERE ind_id='$ind_id'");
    list($ind_imgext) = $photo->fetch_row();

    $mysqli->query("UPDATE individual_text SET ind_imgext='' WHERE ind_id='$ind_id'");
    unlink("$individual_screenshot_save_path$ind_id.$ind_imgext");

    $_SESSION['edit_message'] = "Individual picture deleted";

    create_log_entry('Individuals', $ind_id, 'Image', $ind_id, 'Delete', $_SESSION['user_id']);

    header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
}

//If we want to upload a photo
if (isset($ind_id) and isset($action) and $action == 'add_photo') {
    $image = $_FILES['individual_pic'];

    $tmp_name = $image['tmp_name'];

    if ($tmp_name !== 'none') {
        // Check what extention the file has and if it is allowed.

        $ext        = "";
        $type_image = $image['type'];

        // set extension
        if ($type_image == 'image/x-png') {
            $ext = 'png';
        } elseif ($type_image == 'image/png') {
            $ext = 'png';
        } elseif ($type_image == 'image/gif') {
            $ext = 'gif';
        } elseif ($type_image == 'image/jpeg') {
            $ext = 'jpg';
        }

        if ($ext !== "") {
            // Rename the uploaded file to its autoincrement number and move it to its proper place.
            $mysqli->query("UPDATE individual_text SET ind_imgext='$ext' WHERE ind_id='$ind_id'");
            $file_data = rename("$tmp_name", "$individual_screenshot_save_path$ind_id.$ext");

            chmod("$individual_screenshot_save_path$ind_id.$ext", 0777);

            $_SESSION['edit_message'] = "Individual picture uploaded";

            create_log_entry('Individuals', $ind_id, 'Image', $ind_id, 'Insert', $_SESSION['user_id']);

            header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
        }
    }
}

//update the info of the individual
if (isset($ind_id) and isset($action) and $action == 'update') {
    
    $ind_name = $mysqli->real_escape_string($ind_name);
    $sdbquery = $mysqli->query("UPDATE individuals SET ind_name = '$ind_name' WHERE ind_id = $ind_id") or die("Couldn't Update into individuals");

    $INDIVIDUALtext = $mysqli->query("SELECT ind_id FROM individual_text WHERE ind_id = $ind_id") or die("Database error - selecting individual_text");

    $indrowtext = $INDIVIDUALtext->num_rows;
    $textfield = $mysqli->real_escape_string($textfield);

    if ($indrowtext < 1) {
        $sdbquery = $mysqli->query("INSERT INTO individual_text (ind_id, ind_profile, ind_email) VALUES ($ind_id, '$textfield', '$ind_email')") or die("Couldn't insert into individual_text (profile,email)");
    } else {
        $sdbquery = $mysqli->query("UPDATE individual_text SET ind_profile = '$textfield', ind_email = '$ind_email' WHERE ind_id = '$ind_id'") or die("Couldn't Update into individual_text (profile,email)");
    }

    $_SESSION['edit_message'] = "Individual succesfully updated";

    create_log_entry('Individuals', $ind_id, 'Individual', $ind_id, 'Update', $_SESSION['user_id']);

    header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
}

// Add nicknames
if (isset($ind_id) and isset($action) and $action == "add_nick") {
    if ($ind_nick != '') {
        
        //First add an entry in the individuals table
        $stmt = $mysqli->prepare("INSERT INTO individuals (ind_name) VALUES (?)") or die($mysqli->error);
        $stmt->bind_param("s", $ind_nick) or die($mysqli->error);
        $stmt->execute() or die($mysqli->error);
        $stmt->close();
        $ind_nick_id = $mysqli->insert_id;

        //Now update the nick table       
        $sdbquery = $mysqli->query("INSERT INTO individual_nicks (ind_id, nick_id) VALUES ($ind_id, '$ind_nick_id')") or die("Couldn't insert into individual_nicks");

        $_SESSION['edit_message'] = "Individual nick added";

        create_log_entry('Individuals', $ind_id, 'Nickname', $ind_id, 'Insert', $_SESSION['user_id']);

        header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
    }
}

// Delete Nickname
if (isset($ind_id) and isset($action) and $action == "delete_nick") {
    if (isset($nick_id)) {
        create_log_entry('Individuals', $nick_id, 'Nickname', $nick_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM individual_nicks WHERE nick_id='$nick_id'") or die("Failed to delete nickname - indvidual_nicks table");
        $mysqli->query("DELETE FROM individuals WHERE ind_id='$nick_id'") or die("Failed to delete nickname - indviduals table");
        
        $_SESSION['edit_message'] = "Nickname succesfully deleted";

        header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
    }
}

//if we want to delete the individual (from the edit page)
if (isset($ind_id) and isset($action) and $action == 'delete_ind') {
   
    $sdbquery = $mysqli->query("SELECT * FROM interview_main WHERE ind_id='$ind_id'") or die("Error getting interview info");
    if ($sdbquery->num_rows > 0) {
        $_SESSION['edit_message'] = "Deletion failed - This individual is interviewed - Delete it in the appropriate section";
        header("Location: ../individuals/individuals_main.php");
    } else {
        $sdbquery = $mysqli->query("SELECT * FROM game_author WHERE ind_id='$ind_id'") or die("Error getting interview info");
        if ($sdbquery->num_rows > 0) {
            $_SESSION['edit_message'] = "Deletion failed - This individual is linked to a game - Delete it in the appropriate section";
            header("Location: ../individuals/individuals_main.php");
        } else {
            $sdbquery = $mysqli->query("SELECT * FROM menu_disk_credits WHERE ind_id='$ind_id'") or die("Error getting menu disk credits info");
            if ($sdbquery->num_rows > 0) {
                $_SESSION['edit_message'] = "Deletion failed - This individual is linked to a menudisk - delete in appropriate section";
                header("Location: ../individuals/individuals_main.php");
            } else {
                $sdbquery = $mysqli->query("SELECT * FROM menu_disk_title_author WHERE ind_id='$ind_id'") or die("Error getting menu_disk_title_author info");
                if ($sdbquery->num_rows > 0) {
                    $_SESSION['edit_message'] = "Deletion failed - This individual is linked to a menudisk - delete in appropriate section";
                    header("Location: ../individuals/individuals_main.php");
                } else {
                    $sdbquery = $mysqli->query("SELECT * FROM crew_individual WHERE ind_id='$ind_id'") or die("Error getting crew_individual info");
                    if ($sdbquery->num_rows > 0) {
                        $_SESSION['edit_message'] = "Deletion failed - This individual is linked to a crew - delete in appropriate section";
                        header("Location: ../individuals/individuals_main.php");
                    } else {
                         $sdbquery = $mysqli->query("SELECT * FROM game_download_individual WHERE ind_id='$ind_id'") or die("Error getting game_download_individual info");
                        if ($sdbquery->num_rows > 0) {
                            $_SESSION['edit_message'] = "Deletion failed - This individual is linked to a download - delete in appropriate section";
                            header("Location: ../individuals/individuals_main.php");
                        } else {              
                            create_log_entry('Individuals', $ind_id, 'Individual', $ind_id, 'Delete', $_SESSION['user_id']);
                            
                            //first delete picture
                            $photo = $mysqli->query("SELECT ind_imgext FROM individual_text WHERE ind_id='$ind_id'");
                            list($ind_imgext) = $photo->fetch_row();

                            if ($ind_imgext <> '') {
                                unlink("$individual_screenshot_save_path$ind_id.$ind_imgext");
                            }
                            
                            //Let's get all the nicknames
                            $nickname = $mysqli->query("SELECT * FROM individual_nicks where ind_id = '$ind_id'") or die ("error getting nicknames");

                            while ($name = mysqli_fetch_assoc($nickname)) 
                            {
                                $nick_id = $name['nick_id'];
                                $sql = $mysqli->query("DELETE FROM individuals WHERE ind_id = $nick_id") or die ("Failed to delete the nicks from this person");;
                            }
                            
                            //then delete the rest
                            $sql                      = $mysqli->query("DELETE FROM individuals WHERE ind_id = $ind_id") or die ("Failed to delete individual");;
                            $sql                      = $mysqli->query("DELETE FROM individual_text WHERE ind_id = $ind_id") or die ("Failed to delete ind text");;
                            $sql                      = $mysqli->query("DELETE FROM individual_nicks WHERE ind_id = $ind_id") or die ("Failed to delete nickname");
                            $_SESSION['edit_message'] = "individual succesfully deleted";
                            header("Location: ../individuals/individuals_main.php");
                        }
                    }
                }
            }
        }
    }
}

//Insert a new individual
if (isset($action) and $action == 'insert_ind') {
    if ($ind_name == '') {
        $_SESSION['edit_message'] = "Please fill in an individual name";
        header("Location: ../individuals/individuals_main.php");
    } else {
        $ind_name = $mysqli->real_escape_string($ind_name);
        $sql_individuals = $mysqli->query("INSERT INTO individuals (ind_name) VALUES ('$ind_name')");

        //get the id of the inserted individual
        $individuals = $mysqli->query("SELECT ind_id FROM individuals ORDER BY ind_id desc") or die("Database error - selecting individuals");

        $indrow = $individuals->fetch_row();

        $id = $indrow[0];
        if (isset($textfield))
        {
            $textfield = $mysqli->real_escape_string($textfield);

            $sdbquery = $mysqli->query("INSERT INTO individual_text (ind_id, ind_profile) VALUES ($id, '$textfield')") or die("Couldn't insert into individual_text");
        }

        create_log_entry('Individuals', $id, 'Individual', $id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "individual succesfully inserted";

        header("Location: ../individuals/individuals_edit.php?ind_id=$id");
    }
}

//close the connection
mysqli_close($mysqli);
