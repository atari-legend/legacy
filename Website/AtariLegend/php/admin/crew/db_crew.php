<?php
/***************************************************************************
 *                                db_crew.php
 *                            -----------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : New section.
 *
 *   Id: db_crew.php,v 1.10 2005/10/29 Silver Surfer
 *   Id: db_crew.php,v 1.20 2016/10/05 STG
 *       - AL 2.0 (logging)
 *   id : db_menu_disk.php, v 1.21 2017/02/26 STG
 *       - It seems mysqli_free_result is not used for insert or update statements
 *         from the manual : Returns FALSE on failure. For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query()
 *         will return a mysqli_result object. For other successful queries mysqli_query() will return TRUE.
 *       - Extra check before we delete a crew
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if ($action == "stop") {
    echo "test";
    exit;
}

//****************************************************************************************
// Adding a new crew
//****************************************************************************************
if ($action == "insert_crew") {
    if (isset($new_crew)) {
        $new_crew = $mysqli->real_escape_string($new_crew);

        $mysqli->query("INSERT INTO crew (crew_name) VALUES ('$new_crew')");

        $_SESSION['edit_message'] = "New crew has been added";

        $new_crew_id = $mysqli->insert_id;

        create_log_entry('Crew', $new_crew_id, 'Crew', $new_crew_id, 'Insert', $_SESSION['user_id']);

//      mysqli_free_result();
    }
    // we are sending the $new_crew value to the main page again to place that one
    // in the search field would the user want to edit the crew right away.
    header("Location: ../crew/crew_main.php?new_crew=$new_crew");
}

//****************************************************************************************
// Adding logo to crew
//****************************************************************************************
if ($action == "add_logo") {
    $image = $_FILES['crew_pic'];

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
            $mysqli->query("UPDATE crew SET crew_logo='$ext' WHERE crew_id='$crew_select'");

            $_SESSION['edit_message'] = "Crew logo added";
            create_log_entry('Crew', $crew_select, 'Logo', $crew_select, 'Insert', $_SESSION['user_id']);

            $file_data = rename("$tmp_name", "$crew_logo_save_path$crew_select.$ext");

            chmod("$crew_logo_save_path$crew_select.$ext", 0777);
        } else {
            $_SESSION['edit_message'] = "please use correct file extension";
        }
    }
    header("Location: ../crew/crew_editor.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse");
}

//****************************************************************************************
// Delete Logo
//****************************************************************************************
if ($action == "delete_logo") {
    $sql_crew = $mysqli->query("SELECT crew_logo FROM crew
      WHERE crew_id = '$crew_select'") or die("Couldn't query Crew database");

    $crew = $sql_crew->fetch_array(MYSQLI_BOTH);

    $mysqli->query("UPDATE crew SET crew_logo='' WHERE crew_id='$crew_select'") or die('Error: ' . mysqli_error($mysqli));

    unlink("$crew_logo_save_path$crew_select.$crew[crew_logo]");

    $_SESSION['edit_message'] = "Crew logo deleted";
    create_log_entry('Crew', $crew_select, 'Logo', $crew_select, 'Delete', $_SESSION['user_id']);

    $crew_search = '';

    header("Location: ../crew/crew_editor.php?crew_select=$crew_select&crewsearch=$crew_search&crewbrowse=$crewbrowse&action=main");
}

//****************************************************************************************
// Delete Crew... keep track of this one, it will need updating as often as we add functionality.
//****************************************************************************************
if ($action == "delete_crew") {
    if (isset($crew_select)) {
        //  First let's see if this crew is linked to a production
        $sql = $mysqli->query("SELECT * FROM crew_menu_prod
                               WHERE crew_id = '$crew_select'") or die("error selecting crew from crew_menu_prod");
        if ($sql->num_rows > 0) {
            $_SESSION['edit_message'] =  "This crew is still linked to a menu disk - remove that link first";
            header("Location: ../crew/crew_main.php");
        } else {
            $sql = $mysqli->query("SELECT * FROM crew_demo_prod
                                   WHERE crew_id = '$crew_select'") or die("error selecting crew from crew_demo_prod");
            if ($sql->num_rows > 0) {
                $_SESSION['edit_message'] = "This crew is still linked to a demo - remove that link first";
                header("Location: ../crew/crew_main.php");
            } else {
                $sql_crew = $mysqli->query("SELECT crew_logo FROM crew
                    WHERE crew_id = '$crew_select'") or die("Couldn't query Crew database");

                $crew = $sql_crew->fetch_array(MYSQLI_BOTH);

                $crew_logo = $crew['crew_logo'];
                if ($crew['crew_logo'] =! '') {
                    unlink("$crew_logo_save_path$crew_select.$crew_logo");
                }

                $_SESSION['edit_message'] = "Crew deleted";
                create_log_entry('Crew', $crew_select, 'Crew', $crew_select, 'Delete', $_SESSION['user_id']);

                $mysqli->query("DELETE FROM crew WHERE crew_id='$crew_select'") or die('Error: ' . mysqli_error($mysqli));
                ;
                $mysqli->query("DELETE FROM sub_crew WHERE crew_id='$crew_select'") or die('Error: ' . mysqli_error($mysqli));
                ;
                $mysqli->query("DELETE FROM sub_crew WHERE parent_id='$crew_select'") or die('Error: ' . mysqli_error($mysqli));
                ;
                $mysqli->query("DELETE FROM crew_individual WHERE crew_id='$crew_select'") or die('Error: ' . mysqli_error($mysqli));
                ;
                header("Location: ../crew/crew_main.php");
            }
        }
    }
}

//****************************************************************************************
// update main crew info
//****************************************************************************************
if ($action == "update_main_info") {
    $sql_crew = $mysqli->query("SELECT * FROM crew
      WHERE crew_id = '$crew_select'") or die("Couldn't query Crew database");

    $crew = $sql_crew->fetch_array(MYSQLI_BOTH);

    if ($crew_name != '') {
        $mysqli->query("UPDATE crew SET crew_name='$crew_name' WHERE crew_id='$crew_select'");
    }

    $textfield = trim($textfield);

    if ($textfield != '') {
        $textfield = $mysqli->real_escape_string($textfield);
        $mysqli->query("UPDATE crew SET crew_history='$textfield' WHERE crew_id='$crew_select'");
    }

    $_SESSION['edit_message'] = "Crew updated";
    create_log_entry('Crew', $crew_select, 'Crew', $crew_select, 'Update', $_SESSION['user_id']);

    header("Location: ../crew/crew_editor.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=main");
}

//****************************************************************************************
// add subcrews
//****************************************************************************************
if ($action == "parent_crew") {
    foreach ($sub_crew as $value) {
        $mysqli->query("INSERT INTO sub_crew (parent_id,crew_id) VALUES ('$crew_select','$value')");

        $_SESSION['edit_message'] = "Subcrew added";
        create_log_entry('Crew', $crew_select, 'Subcrew', $value, 'Insert', $_SESSION['user_id']);
    }

    header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}

//****************************************************************************************
// add individual members to crew
//****************************************************************************************
if ($action == "add_member") {
    if (isset($ind_id)) {
        $mysqli->query("INSERT INTO crew_individual (crew_id,ind_id) VALUES ('$crew_select','$ind_id')");

        $_SESSION['edit_message'] = "Individual member added";
        create_log_entry('Crew', $crew_select, 'Member', $ind_id, 'Insert', $_SESSION['user_id']);
    }

    header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}

//****************************************************************************************
// delete individual members
//****************************************************************************************
if ($action == "delete_crew_member") {
    if (isset($crew_individual_id)) {
        $_SESSION['edit_message'] = "Individual member deleted";
        create_log_entry('Crew', $crew_individual_id, 'Member', $crew_individual_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM crew_individual WHERE crew_individual_id='$crew_individual_id'");
    }

    header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}

//****************************************************************************************
// Delete Subcrew
//****************************************************************************************
if ($action == "delete_subcrew") {
    if (isset($sub_crew_id)) {
        $_SESSION['edit_message'] = "Subcrew deleted";
        create_log_entry('Crew', $sub_crew_id, 'Subcrew', $sub_crew_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM sub_crew WHERE sub_crew_id='$sub_crew_id'");
    }

    header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}

//****************************************************************************************
// Update nicknames for crew members
//****************************************************************************************
if ($action == "update_nick") {
    if (isset($individual_nicks_id) and isset($crew_individual_id)) {
        if ($individual_nicks_id == "-") {
            $mysqli->query("UPDATE crew_individual SET individual_nicks_id='' WHERE crew_individual_id='$crew_individual_id'") or die("Failed to remove nickname");

            $_SESSION['edit_message'] = "Nickname removed";
            create_log_entry('Crew', $crew_individual_id, 'Nickname', $crew_individual_id, 'Delete', $_SESSION['user_id']);
        } else {
            $mysqli->query("UPDATE crew_individual SET individual_nicks_id='$individual_nicks_id' WHERE crew_individual_id='$crew_individual_id'") or die("Failed to update nickname information");

            $_SESSION['edit_message'] = "Nickname added";
            create_log_entry('Crew', $crew_individual_id, 'Nickname', $crew_individual_id, 'Insert', $_SESSION['user_id']);
        }
    }

    header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}
