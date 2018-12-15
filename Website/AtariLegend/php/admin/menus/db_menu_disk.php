<?php
/***************************************************************************
 *                                db_menu_disk.php
 *                            -----------------------
 *   begin                : june 06, 2015
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 * id : db_menu_disk.php, v 1.10 2016/08/29 STG
 *       - adding the change log
 *
 * id : db_menu_disk.php, v 1.20 2017/02/07 STG
 *       - adding authors
 *
 * id : db_menu_disk.php, v 1.21 2017/02/26 STG
 *       - It seems mysqli_free_result is not used for insert or update statements
 *         from the manual : Returns FALSE on failure. For successful SELECT, SHOW, DESCRIBE or EXPLAIN
 *         queries mysqli_query()
 *         will return a mysqli_result object. For other successful queries mysqli_query() will return TRUE.
 *       - When deleting a menu set, also delete from crew_menu_prod table and ind_menu_prod
 *
 * id : db_menu_disk.php, v 1.22 2017/05/08 STG
 *       - Removed sort bug
 ***************************************************************************/

// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/menus/db_menu_functions.php");
require_once __DIR__."/../../common/DAO/MenuSetDAO.php";
require_once __DIR__."/../../common/DAO/CrewDAO.php";
require_once __DIR__."/../../common/DAO/IndividualDAO.php";
//include("../../config/admin_rights.php"); /*--> We can not use it like this because of the ajax. redirecting does
// not work correctly with the inheritance of Ajax.

//This is used for the AJAX parts when user rights do not suffice
$osd_message = 'You do not have the necessary authorizations to perform this action';

//****************************************************************************************
// Add new menu disk
//****************************************************************************************

if ($action == "add_new_menu_disk") {
    include("../../config/admin_rights.php");
    if ($menu_disk_number !== '' or $menu_disk_letter !== '') {
        //first we start with if this is numbered menu disk
        if ($menu_disk_number !== '' and $menu_disk_letter == '') {
            $sql = $mysqli->query("INSERT INTO menu_disk (menu_sets_id,menu_disk_number)
                VALUES ('$menu_sets_id','$menu_disk_number')") or die('Error: ' . mysqli_error($mysqli));
            $last_id = $mysqli->insert_id;

            if ($menu_disk_part !== '') {
                $sql = $mysqli->query("UPDATE menu_disk SET menu_disk_part='$menu_disk_part'
        WHERE menu_disk_id='$last_id'") or die('Error: ' . mysqli_error($mysqli));
            }
            if ($menu_disk_version !== '') {
                $sql = $mysqli->query("UPDATE menu_disk SET menu_disk_version='$menu_disk_version'
        WHERE menu_disk_id='$last_id'") or die('Error: ' . mysqli_error($mysqli));
            }
            $_SESSION['edit_message'] = "New Menu disk added";
            create_log_entry('Menu set', $menu_sets_id, 'Menu disk', $last_id, 'Insert', $_SESSION['user_id']);
        } elseif ($menu_disk_number == '' and $menu_disk_letter !== '') {
            //Ok, but if it is not a numbered disk but instead it is one of those horrible alphabetic disks
            $sql = $mysqli->query("INSERT INTO menu_disk (menu_sets_id,menu_disk_letter)
                VALUES ('$menu_sets_id','$menu_disk_letter')") or die('Error: ' . mysqli_error($mysqli));
            $last_id2 = $mysqli->insert_id;
            if ($menu_disk_part !== '') {
                $sql = $mysqli->query("UPDATE menu_disk SET menu_disk_part='$menu_disk_part'
        WHERE menu_disk_id='$last_id2'") or die('Error: ' . mysqli_error($mysqli));
            }
            if ($menu_disk_version !== '') {
                $sql = $mysqli->query("UPDATE menu_disk SET menu_disk_version='$menu_disk_version'
        WHERE menu_disk_id='$last_id2'") or die('Error: ' . mysqli_error($mysqli));
            }
            $_SESSION['edit_message'] = "New Menu disk added";
            create_log_entry('Menu set', $menu_sets_id, 'Menu disk', $last_id2, 'Insert', $_SESSION['user_id']);
        } else {
            $_SESSION['edit_message'] = "Please use a correct combination - numbered OR alphabetic";
        }
    }
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// MULTI Add new menu disk
//****************************************************************************************

if (isset($action) and $action == "multi_add_new_menu_disk") {
    include("../../config/admin_rights.php");
    if ($first_disk !== '' and $last_disk !== '') {
        //First disk must me a smaller number then last disk
        if ($first_disk < $last_disk) {
            $i = $first_disk;

            while ($i <= $last_disk) {
                $sql = $mysqli->query("INSERT INTO menu_disk (menu_sets_id,menu_disk_number)
                    VALUES ('$menu_sets_id','$i')") or die('Error: ' . mysqli_error($mysqli));
                $i++;
            }
        }
        create_log_entry(
            'Menu set',
            $menu_sets_id,
            'Menu disk (multiple)',
            $menu_sets_id,
            'Insert',
            $_SESSION['user_id']
        );

        $_SESSION['edit_message'] = "New Menu disks added";
    }
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// Quick add new crew
//****************************************************************************************
if ($action == "menu_set_crew_add") {
    include("../../config/admin_rights.php");
    if (isset($new_crew_name) and isset($menu_sets_id)) {
        $crewDao = new AL\Common\DAO\CrewDAO($mysqli);

        $new_crew_id = $crewDao->addCrew($new_crew_name);

        create_log_entry('Crew', $new_crew_id, 'Crew', $new_crew_id, 'Insert', $_SESSION['user_id']);
    }
    $_SESSION['edit_message'] = "$new_crew_name added to the crew database";
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// Quick add new Individual
//****************************************************************************************
if ($action == "menu_set_ind_add") {
    include("../../config/admin_rights.php");
    if (isset($new_ind_name) and isset($menu_sets_id)) {
        $individualDao = new AL\Common\DAO\IndividualDAO($mysqli);
        $new_ind_id = $individualDao->addIndividual($new_ind_name);

        create_log_entry('Individuals', $new_ind_id, 'Individual', $new_ind_id, 'Insert', $_SESSION['user_id']);
    }
    $_SESSION['edit_message'] = "$new_ind_name added to the individuals database";
    header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// Add game to menu disk AJAX DB job
//****************************************************************************************
if (isset($action) and ($action == "add_title_to_menu")) {
    if (isset($software_id) and isset($menu_disk_id)) {
        if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
            if (isset($software_type) and $software_type == "Game") {
                //Insert new title in menu_disk_title table
                $mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id)
                    VALUES ('$menu_disk_id','1')");
                $last_id = $mysqli->insert_id; // Get Last autoinc id
                // Specify title in menu_disk_title_game table
                $mysqli->query("INSERT INTO menu_disk_title_game (menu_disk_title_id,game_id)
                    VALUES ('$last_id','$software_id')");

                $sql           = $mysqli->query("SELECT game_name FROM game WHERE game_id = '$software_id'");
                $row           = $sql->fetch_array(MYSQLI_BOTH);
                $software_name = $row['game_name'];

                create_log_entry('Menu disk', $menu_disk_id, 'Game', $software_id, 'Insert', $_SESSION['user_id']);
                $osd_message = "$software_name added to menu disk!";
            }
            if (isset($software_type) and $software_type == "Demo") {
                $mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id)
                    VALUES ('$menu_disk_id','2')");
                $last_id = $mysqli->insert_id; // Get Last autoinc id
                // Specify title in menu_disk_title_game table
                $mysqli->query("INSERT INTO menu_disk_title_demo (menu_disk_title_id,demo_id)
                    VALUES ('$last_id','$software_id')");

                $sql           = $mysqli->query("SELECT demo_name FROM demo WHERE demo_id = '$software_id'");
                $row           = $sql->fetch_array(MYSQLI_BOTH);
                $software_name = $row['demo_name'];

                create_log_entry('Menu disk', $menu_disk_id, 'Demo', $software_id, 'Insert', $_SESSION['user_id']);
                $osd_message = "$software_name added to menu disk!";
            }
            if (isset($software_type) and $software_type == "Tool") {
                $mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id)
                    VALUES ('$menu_disk_id','3')");
                $last_id = $mysqli->insert_id; // Get Last autoinc id
                // Specify title in menu_disk_title_game table
                $mysqli->query("INSERT INTO menu_disk_title_tools (menu_disk_title_id,tools_id)
                    VALUES ('$last_id','$software_id')");

                $sql           = $mysqli->query("SELECT tools_name FROM tools WHERE tools_id = '$software_id'");
                $row           = $sql->fetch_array(MYSQLI_BOTH);
                $software_name = $row['tools_name'];

                create_log_entry('Menu disk', $menu_disk_id, 'Tool', $software_id, 'Insert', $_SESSION['user_id']);
                $osd_message = "$software_name added to menu disk!";
            }
        }

        // ok, insert done. Now this is a ajax job so we need a return value.
        //
        //list of games for the menu disk
        $temp_query = menu_disk_software_list($menu_disk_id);

        while ($query = $temp_query->fetch_array(MYSQLI_BOTH)) {
            // This smarty is used for creating the list of games
            $smarty->append('game', array(
                'game_id' => $query['software_id'],
                'game_name' => $query['software_name'],
                'developer_id' => $query['developer_id'],
                'developer_name' => $query['developer_name'],
                'set_chain' => $query['menu_disk_title_set_chain'],
                'year' => $query['year'],
                'menu_disk_title_id' => $query['menu_disk_title_id'],
                'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
                'menu_types_text' => $query['menu_types_text']
            ));
        }

        $smarty->assign('smarty_action', 'add_game_to_menu_return');
        $smarty->assign('osd_message', $osd_message);
        $smarty->assign('menu_disk_id', $menu_disk_id);

        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
    }
}

//****************************************************************************************
// Add doc to menu disk AJAX DB job
//****************************************************************************************
if (isset($action) and $action == "add_doc_to_menu") {
    if (isset($software_id) and isset($menu_disk_id)) {
        if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
            if (isset($software_type) and $software_type == "Game") {
                //Insert new title in menu_disk_title table
                $mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id)
                    VALUES ('$menu_disk_id','6')") or die('Error: ' . mysqli_error($mysqli));
                $title_id = $mysqli->insert_id; // Get Last autoinc id

                //insert the doc in the doc table first - category = doc_disk_game
                $mysqli->query("INSERT INTO doc (doc_category_id,doc_type_id) VALUES ('1','1')")
                    or die('Error: ' . mysqli_error($mysqli));
                $doc_id = $mysqli->insert_id; // Get Last autoinc id

                //insert in doc_disk_game
                $mysqli->query("INSERT INTO doc_disk_game (game_id, doc_id) VALUES ('$software_id','$doc_id')")
                    or die('Error: ' . mysqli_error($mysqli));
                $doc_disk_game_id = $mysqli->insert_id; // Get Last autoinc id

                //insert menu_disk_title_doc_games
                $mysqli->query("INSERT INTO menu_disk_title_doc_games (menu_disk_title_id, doc_games_id)
                    VALUES ('$title_id','$doc_disk_game_id')") or die('Error: ' . mysqli_error($mysqli));

                $sql           = $mysqli->query("SELECT game_name FROM game WHERE game_id = '$software_id'");
                $row           = $sql->fetch_array(MYSQLI_BOTH);
                $software_name = $row['game_name'];

                create_log_entry('Menu disk', $menu_disk_id, 'Game doc', $software_id, 'Insert', $_SESSION['user_id']);
                $osd_message = "$software_name added to menu disk!";
            }

            if (isset($software_type) and $software_type == "Tool") {
                //Insert new title in menu_disk_title table
                $mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id)
                    VALUES ('$menu_disk_id','6')") or die('Error: ' . mysqli_error($mysqli));
                $title_id = $mysqli->insert_id; // Get Last autoinc id

                //insert the doc in the doc table first - category = doc_disk_tool
                $mysqli->query("INSERT INTO doc (doc_category_id) VALUES ('2')")
                    or die('Error: ' . mysqli_error($mysqli));
                $doc_id = $mysqli->insert_id; // Get Last autoinc id

                //insert in doc_disk_tool
                $mysqli->query("INSERT INTO doc_disk_tool (tools_id, doc_id) VALUES ('$software_id','$doc_id')")
                    or die('Error: ' . mysqli_error($mysqli));

                $doc_disk_tool_id = $mysqli->insert_id; // Get Last autoinc id

                //insert menu_disk_title_doc_tools
                $mysqli->query("INSERT INTO menu_disk_title_doc_tools (menu_disk_title_id, doc_tools_id)
                    VALUES ('$title_id','$doc_disk_tool_id')") or die('Error: ' . mysqli_error($mysqli));

                $sql           = $mysqli->query("SELECT tools_name FROM tools WHERE tools_id = '$software_id'");
                $row           = $sql->fetch_array(MYSQLI_BOTH);
                $software_name = $row['tools_name'];

                create_log_entry('Menu disk', $menu_disk_id, 'Tool doc', $software_id, 'Insert', $_SESSION['user_id']);
                $osd_message = "$software_name added to menu disk!";
            }
        }

        // Get the doc disks
        //list of games for the menu disk
        $temp_query2 = menu_disk_doc_list($menu_disk_id);

        while ($query = $temp_query2->fetch_array(MYSQLI_BOTH)) {
            // This smarty is used for creating the list of games
            $smarty->append('doc_game', array(
                'game_name' => $query['software_name'],
                'game_id' => $query['software_id'],
                'year' => $query['year'],
                'developer_name' => $query['developer_name'],
                'developer_id' => $query['developer_id'],
                'doc_id' => $query['doc_id'],
                'doc_type_id' => $query['doc_type_id'],
                'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
                'menu_types_text' => $query['menu_types_text'],
                'menu_disk_title_id' => $query['menu_disk_title_id']
            ));
        }

        //get the doc types
        $sql_doc_type = "SELECT * from doc_type";
        $query_doc_type = $mysqli->query($sql_doc_type) or die('Error: ' . mysqli_error($mysqli));

        while ($query_type = $query_doc_type->fetch_array(MYSQLI_BOTH)) {
            $smarty->append('doc_type', array(
                'doc_type_id' => $query_type['doc_type_id'],
                'doc_type_name' => $query_type['doc_type_name']
            ));
        }

        $smarty->assign('smarty_action', 'add_doc_to_menu_return');
        $smarty->assign('osd_message', $osd_message);
        $smarty->assign('menu_disk_id', $menu_disk_id);

        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
    }
}

//****************************************************************************************
// DELETE TITLE FROM MENU DISK
//****************************************************************************************
if (isset($action) and $action == "delete_from_menu_disk") {
    /* let's check if the game is linked to a chain first */
    $sql = $mysqli->query("SELECT * FROM menu_disk_title_set
        WHERE menu_disk_title_id = '$menu_disk_title_id'") or die('Error: ' . mysqli_error($mysqli));
    if ($sql->num_rows > 0) {
        $osd_message = "This title is still chained to another title - remove the chain first";
    } else {
        /* let's see if the title contains authors */
        $sql = $mysqli->query("SELECT * FROM menu_disk_title_author WHERE menu_disk_title_id = '$menu_disk_title_id'")
            or die('Error: ' . mysqli_error($mysqli));
        if ($sql->num_rows > 0) {
            $osd_message = "This title still contains authors - remove them first";
        } else {
            if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
                create_log_entry(
                    'Menu disk',
                    $menu_disk_id,
                    'Software',
                    $menu_disk_title_id,
                    'Delete',
                    $_SESSION['user_id']
                );

                $mysqli->query("DELETE FROM menu_disk_title_various WHERE menu_disk_title_id='$menu_disk_title_id'");
                $mysqli->query("DELETE FROM menu_disk_title_tools WHERE menu_disk_title_id='$menu_disk_title_id'");
                $mysqli->query("DELETE FROM menu_disk_title_music WHERE menu_disk_title_id='$menu_disk_title_id'");
                $mysqli->query("DELETE FROM menu_disk_title_game WHERE menu_disk_title_id='$menu_disk_title_id'");
                $mysqli->query("DELETE FROM menu_disk_title_doc_tools WHERE menu_disk_title_id='$menu_disk_title_id'");
                $mysqli->query("DELETE FROM menu_disk_title_doc_games WHERE menu_disk_title_id='$menu_disk_title_id'");
                $mysqli->query("DELETE FROM menu_disk_title_demo WHERE menu_disk_title_id='$menu_disk_title_id'");
                $mysqli->query("DELETE FROM menu_disk_title WHERE menu_disk_title_id='$menu_disk_title_id'");

                $osd_message = "Title deleted from menu disk";
            }
        }
    }

    // ok, delete done. Now this is a ajax job so we need a return value.
    // list of games for the menu disk
    $temp_query = menu_disk_software_list($menu_disk_id);

    while ($query = $temp_query->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of games
        $smarty->append('game', array(
            'game_id' => $query['software_id'],
            'game_name' => $query['software_name'],
            'developer_id' => $query['developer_id'],
            'developer_name' => $query['developer_name'],
            'set_chain' => $query['menu_disk_title_set_chain'],
            'year' => $query['year'],
            'menu_disk_title_id' => $query['menu_disk_title_id'],
            'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
            'menu_types_text' => $query['menu_types_text']
        ));
    }

    $smarty->assign('smarty_action', 'add_game_to_menu_return');
    $smarty->assign('menu_disk_id', $menu_disk_id);

    $smarty->assign('osd_message', $osd_message);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}

//****************************************************************************************
// DELETE DOC FROM MENU DISK
//****************************************************************************************
if (isset($action) and $action == "delete_doc_from_menu_disk") {
    /* let's see if the title contains authors */
    $sql = $mysqli->query("SELECT * FROM menu_disk_title_author WHERE menu_disk_title_id = '$menu_disk_title_id'")
        or die('Error: ' . mysqli_error($mysqli));
    if ($sql->num_rows > 0) {
        $osd_message = "This title still contains authors - remove them first";
    } else {
        if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
            create_log_entry('Menu disk', $menu_disk_id, 'Doc', $menu_disk_title_id, 'Delete', $_SESSION['user_id']);

            //get the doc cross id
            $query_doc_game_id = "SELECT doc_games_id FROM menu_disk_title_doc_games
                WHERE menu_disk_title_id='$menu_disk_title_id'";
            $result = $mysqli->query($query_doc_game_id) or die('Error: ' . mysqli_error($mysqli));
            $query_data  = $result->fetch_array(MYSQLI_BOTH);
            $doc_game_id = $query_data['doc_games_id'];

            $query_doc_tool_id = "SELECT * FROM menu_disk_title_doc_tools
                WHERE menu_disk_title_id='$menu_disk_title_id'";
            $result = $mysqli->query($query_doc_tool_id) or die('Error: ' . mysqli_error($mysqli));
            $query_data  = $result->fetch_array(MYSQLI_BOTH);
            $doc_tool_id = $query_data['doc_tools_id'];

            //get the doc id
            $query_doc_id = "SELECT * FROM doc_disk_game WHERE doc_disk_game_id='$doc_game_id'";
            $result = $mysqli->query($query_doc_id) or die('Error: ' . mysqli_error($mysqli));
            $query_data = $result->fetch_array(MYSQLI_BOTH);
            $doc_id     = $query_data['doc_id'];

            if ($doc_id == '') {
                $query_doc_id = "SELECT * FROM doc_disk_tool WHERE doc_disk_tool_id='$doc_tool_id'";
                $result = $mysqli->query($query_doc_id) or die('Error: ' . mysqli_error($mysqli));
                $query_data = $result->fetch_array(MYSQLI_BOTH);
                $doc_id     = $query_data['doc_id'];
            }

            $mysqli->query("DELETE FROM menu_disk_title WHERE menu_disk_title_id='$menu_disk_title_id'")
                or die('Error: ' . mysqli_error($mysqli));
            $mysqli->query("DELETE FROM doc_disk_game WHERE doc_disk_game_id='$doc_game_id'")
                or die('Error: ' . mysqli_error($mysqli));
            $mysqli->query("DELETE FROM menu_disk_title_doc_games WHERE menu_disk_title_id='$menu_disk_title_id'")
                or die('Error: ' . mysqli_error($mysqli));
            $mysqli->query("DELETE FROM doc_disk_tool WHERE doc_disk_tool_id='$doc_tool_id'")
                or die('Error: ' . mysqli_error($mysqli));
            $mysqli->query("DELETE FROM menu_disk_title_doc_tools WHERE menu_disk_title_id='$menu_disk_title_id'")
                or die('Error: ' . mysqli_error($mysqli));
            $mysqli->query("DELETE FROM doc WHERE doc_id='$doc_id'") or die('Error: ' . mysqli_error($mysqli));

            $osd_message = "Game doc deleted from menu disk";
        }
    }

    // ok, delete done. Now this is a ajax job so we need a return value.
    // Get the doc disks
    //list of games for the menu disk

    $temp_query2 = menu_disk_doc_list($menu_disk_id);

    while ($query = $temp_query2->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of games
        $smarty->append('doc_game', array(
            'game_name' => $query['software_name'],
            'game_id' => $query['software_id'],
            'year' => $query['year'],
            'developer_name' => $query['developer_name'],
            'developer_id' => $query['developer_id'],
            'doc_id' => $query['doc_id'],
            'doc_type_id' => $query['doc_type_id'],
            'menu_types_text' => $query['menu_types_text'],
            'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
            'menu_disk_title_id' => $query['menu_disk_title_id']
        ));
    }

    //get the doc types
    $sql_doc_type = "SELECT * from doc_type";
    $query_doc_type = $mysqli->query($sql_doc_type) or die('Error: ' . mysqli_error($mysqli));

    while ($query_type = $query_doc_type->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('doc_type', array(
            'doc_type_id' => $query_type['doc_type_id'],
            'doc_type_name' => $query_type['doc_type_name']
        ));
    }

    $smarty->assign('smarty_action', 'add_doc_to_menu_return');
    $smarty->assign('menu_disk_id', $menu_disk_id);

    $smarty->assign('osd_message', $osd_message);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}

//****************************************************************************************
// add screenshots to menu disk
//****************************************************************************************
if (isset($action) and $action == "add_screens") {
    if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
        //Here we'll be looping on each of the inputs on the page that are filled in with an image!
        $image = $_FILES['image'];

        $osd_message = "";

        foreach ($image['tmp_name'] as $key => $tmp_name) {
            if ($tmp_name !== "") {
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
                    // First we insert the directory path of where the file will be stored... this also creates an
                    // autoinc number for us.
                    $sdbquery = $mysqli->query("INSERT INTO screenshot_main (imgext) VALUES ('$ext')")
                        or die('Error: ' . mysqli_error($mysqli));

                    //select the newly entered screenshot_id from the main table
                    $screenshot_id = $mysqli->insert_id;

                    $sdbquery = $mysqli->query("INSERT INTO screenshot_menu (menu_disk_id, screenshot_id)
                        VALUES ($menu_disk_id, $screenshot_id)") or die('Error: ' . mysqli_error($mysqli));

                    // Rename the uploaded file to its autoincrement number and move it to its proper place.
                    $file_data = rename($image['tmp_name'][$key], "$menu_screenshot_save_path$screenshot_id.$ext");

                    chmod("$menu_screenshot_save_path$screenshot_id.$ext", 0777);

                    $osd_message = "Screenshot uploaded";

                    create_log_entry(
                        'Menu disk',
                        $menu_disk_id,
                        'Screenshots',
                        $menu_disk_id,
                        'Insert',
                        $_SESSION['user_id']
                    );
                }
            }
        }

        if ($osd_message == '') {
            $osd_message = "No screenshot uploaded";
        }
    }

    //Get the screenshots for this menu if they exist
    $sql_screenshots = $mysqli->query("SELECT * FROM screenshot_menu
            LEFT JOIN screenshot_main ON (screenshot_menu.screenshot_id = screenshot_main.screenshot_id)
            WHERE screenshot_menu.menu_disk_id = '$menu_disk_id' ORDER BY screenshot_menu.screenshot_id")
            or die('Error: ' . mysqli_error($mysqli));

    $count         = 1;
    $v_screenshots = 0;
    while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
        //Ready screenshots path and filename
        $screenshot_image = $menu_screenshot_path;
        $screenshot_image .= $screenshots['screenshot_id'];
        $screenshot_image .= '.';
        $screenshot_image .= $screenshots['imgext'];

        $smarty->append('screenshots', array(
            'count' => $count,
            'path' => $menu_screenshot_path,
            'screenshot_image' => $screenshot_image,
            'id' => $screenshots['screenshot_id']
        ));

        $count++;
        $v_screenshots++;
    }

    $smarty->assign("screenshots_nr", $v_screenshots);
    $smarty->assign('osd_message', $osd_message);

    $smarty->assign('smarty_action', 'add_screen_to_menu_return');
    $smarty->assign('menu_disk_id', $menu_disk_id);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}

//****************************************************************************************
// delete screenshots from a menudisk
//****************************************************************************************
if (isset($action) and $action == "delete_screen_from_menu_disk") {
    if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
        $sql_menushot = $mysqli->query("SELECT * FROM screenshot_menu
                            WHERE menu_disk_id = $menu_disk_id
                        AND screenshot_id = $screenshot_id") or die('Error: ' . mysqli_error($mysqli));

        $menushot   = $sql_menushot->fetch_row();
        $menushotid = $menushot[0];

        //get the extension
        $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
                        WHERE screenshot_id = '$screenshot_id'") or die('Error: ' . mysqli_error($mysqli));

        $screenshotrow  = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
        $screenshot_ext = $screenshotrow['imgext'];

        $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ")
            or die('Error: ' . mysqli_error($mysqli));

        $new_path = $menu_screenshot_save_path;
        ;
        $new_path .= $screenshot_id;
        $new_path .= ".";
        $new_path .= $screenshot_ext;

        unlink("$new_path");

        create_log_entry('Menu disk', $menu_disk_id, 'Screenshots', $menu_disk_id, 'Delete', $_SESSION['user_id']);
        $osd_message = 'screenshot deleted';
    }

    //Get the screenshots for this menu if they exist
    $sql_screenshots = $mysqli->query("SELECT * FROM screenshot_menu
        LEFT JOIN screenshot_main ON (screenshot_menu.screenshot_id = screenshot_main.screenshot_id)
        WHERE screenshot_menu.menu_disk_id = '$menu_disk_id' ORDER BY screenshot_menu.screenshot_id")
        or die('Error: ' . mysqli_error($mysqli));

    $count         = 1;
    $v_screenshots = 0;
    while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
        //Ready screenshots path and filename
        $screenshot_image = $menu_screenshot_path;
        $screenshot_image .= $screenshots['screenshot_id'];
        $screenshot_image .= '.';
        $screenshot_image .= $screenshots['imgext'];

        $smarty->append('screenshots', array(
            'count' => $count,
            'path' => $menu_screenshot_path,
            'screenshot_image' => $screenshot_image,
            'id' => $screenshots['screenshot_id']
        ));

        $count++;
        $v_screenshots++;
    }

    $smarty->assign("screenshots_nr", $v_screenshots);
    $smarty->assign('osd_message', $osd_message);
    $smarty->assign('smarty_action', 'add_screen_to_menu_return');
    $smarty->assign('menu_disk_id', $menu_disk_id);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}

//****************************************************************************************
// delete download from a menudisk
//****************************************************************************************
if (isset($action) and $action == "delete_download_from_menu_disk") {
    if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
        create_log_entry('Menu disk', $menu_disk_id, 'File', $menu_disk_id, 'Delete', $_SESSION['user_id']);
        $osd_message = 'download deleted';

        $mysqli->query("DELETE from menu_disk_download WHERE menu_disk_download_id='$menu_disk_download_id'");
        unlink("$menu_file_path$menu_disk_download_id.zip");
    }

    //************************************************************************************************
    //Let's get the menu info for the file name concatenation, and the download data for disks already
    //uploaded
    //************************************************************************************************
    //get the existing downloads
    $SQL_DOWNLOADS = $mysqli->query("SELECT * FROM menu_disk_download WHERE menu_disk_id='$menu_disk_id'")
        or die('Error: ' . mysqli_error($mysqli));

    $nr_downloads = 0;
    while ($downloads = $SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) {
        $filepath = $menu_file_path;

        //start filling the smarty object
        $smarty->append('downloads', array(
            'menu_disk_download_id' => $downloads['menu_disk_download_id'],
            'filename' => $downloads['menu_disk_download_id'],
            'filepath' => $filepath
        ));

        $nr_downloads++;
    }

    //In all cases we search we start searching through the menu_set table
    //first
    $sql_menus = "SELECT menu_disk.menu_sets_id,
          menu_set.menu_sets_name,
          menu_disk.menu_disk_number,
          menu_disk.menu_disk_letter,
          menu_disk.menu_disk_version,
          menu_disk.menu_disk_part
          FROM menu_disk
          LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
          WHERE menu_disk.menu_disk_id = '$menu_disk_id'";

    $result_menus = $mysqli->query($sql_menus) or die('Error: ' . mysqli_error($mysqli));

    while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {
        // Create Menu disk name
        $menu_disk_name = "$row[menu_sets_name] ";
        if (isset($row['menu_disk_number'])) {
            $menu_disk_name .= "$row[menu_disk_number]";
        }
        if (isset($row['menu_disk_letter'])) {
            $menu_disk_name .= "$row[menu_disk_letter]";
        }
        if (isset($row['menu_disk_part'])) {
            if (is_numeric($row['menu_disk_part'])) {
                $menu_disk_name .= " part $row[menu_disk_part]";
            } else {
                $menu_disk_name .= "$row[menu_disk_part]";
            }
        }
    }

    $smarty->assign('osd_message', $osd_message);
    $smarty->assign('menu_disk_name', $menu_disk_name);
    $smarty->assign('download_nr', $nr_downloads);

    $smarty->assign('smarty_action', 'add_file_to_menu_return');
    $smarty->assign('menu_disk_id', $menu_disk_id);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}

//****************************************************************************************
// We wanna add a new download to a menu
//****************************************************************************************
if (isset($action) and $action == 'add_file') {
    if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
        require_once('../../vendor/pclzip/pclzip/pclzip.lib.php');

        $menu_download_name = $_FILES['menu_download_name'];

        if (isset($menu_download_name)) {
            $file_name = $_FILES['menu_download_name']['name'];

            $tempfilename = $_FILES['menu_download_name']['tmp_name'];

            // Time for zip magic
            $zip = new PclZip("$tempfilename");

            // Obtain the contentlist of the zip file.
            if (($list = $zip->listContent()) == 0) {
                die("Error : " . $zip->errorInfo(true));
            }

            // Get the filename from the returned array
            $filename = $list[0]['filename'];

            // Split the filename to get the extention
            $ext = strrchr($filename, ".");

            // Get rid of the . in the extention
            $ext = explode(".", $ext);

            // convert to lowercase just incase....
            $ext = strtolower($ext[1]);

            // check if the extention is valid.
            if ($ext == "stx" || $ext == "msa" || $ext == "st") {
            } else {
                exit("Try uploading a diskimage type that is allowed, like stx or msa not $ext");
            }

            // Insert the ext,timestamp and the menu id into the menu download table.
            $sdbquery = $mysqli->query("INSERT INTO menu_disk_download (menu_disk_id,fileext)
                VALUES ('$menu_disk_id','$ext')") or die('Error: ' . mysqli_error($mysqli));

            //select the newly created menu_download_id from the menu_download table
            $MENUDOWN = $mysqli->query("SELECT menu_disk_download_id FROM menu_disk_download
                         ORDER BY menu_disk_download_id desc") or die('Error: ' . mysqli_error($mysqli));

            $menudownrow = $MENUDOWN->fetch_row();

            // Time to unzip the file to the temporary directory
            $archive = new PclZip("$tempfilename");

            if ($archive->extract(PCLZIP_OPT_PATH, "$menu_file_temp_path") == 0) {
                die("Error : " . $archive->errorInfo(true));
            }

            // rename diskimage to increment number
            rename("$menu_file_temp_path$filename", "$menu_file_temp_path$menudownrow[0].$ext")
                or die('Error: ' . mysqli_error($mysqli));

            //Time to rezip file and place it in the proper location.
            $archive = new PclZip("$menu_file_path$menudownrow[0].zip");
            $v_list  = $archive->create("$menu_file_temp_path$menudownrow[0].$ext", PCLZIP_OPT_REMOVE_ALL_PATH);
            if ($v_list == 0) {
                die("Error : " . $archive->errorInfo(true));
            }

            // Time to do the safeties, here we do a sha512 file hash that we later enter into the database, this will
            // be used in the download function to check everytime the file is being downloaded... if the hashes don't
            // match, then datacorruption have changed the file.
            $crc = openssl_digest("$menu_file_path$menudownrow[0].zip", 'sha512');

            //$crc = md5_file ( "$game_file_path$gamedownrow[0].zip");

            $sdbquery = $mysqli->query("UPDATE menu_disk_download SET sha512 = '$crc'
                WHERE menu_disk_download_id = '$menudownrow[0]'") or die('Error: ' . mysqli_error($mysqli));

            // Chmod file so that we can backup/delete files through ftp.
            chmod("$menu_file_path$menudownrow[0].zip", 0777);

            // Delete the unzipped file in the temporary directory
            unlink("$menu_file_temp_path$menudownrow[0].$ext");

            $osd_message = "menu uploaded";

            create_log_entry('Menu disk', $menu_disk_id, 'File', $menu_disk_id, 'Insert', $_SESSION['user_id']);
        }
    }

    //************************************************************************************************
    //Let's get the menu info for the file name concatenation, and the download data for disks already
    //uploaded
    //************************************************************************************************
    //get the existing downloads
    $SQL_DOWNLOADS = $mysqli->query("SELECT * FROM menu_disk_download WHERE menu_disk_id='$menu_disk_id'")
        or die('Error: ' . mysqli_error($mysqli));

    $nr_downloads = 0;
    while ($downloads = $SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) {
        $filepath = $menu_file_path;

        //start filling the smarty object
        $smarty->append('downloads', array(
            'menu_disk_download_id' => $downloads['menu_disk_download_id'],
            'filename' => $downloads['menu_disk_download_id'],
            'filepath' => $filepath
        ));

        $nr_downloads++;
    }

    //In all cases we search we start searching through the menu_set table
    //first
    $sql_menus = "SELECT menu_disk.menu_sets_id,
        menu_set.menu_sets_name,
        menu_disk.menu_disk_number,
        menu_disk.menu_disk_letter,
        menu_disk.menu_disk_version,
        menu_disk.menu_disk_part
        FROM menu_disk
        LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
        WHERE menu_disk.menu_disk_id = '$menu_disk_id'";

    $result_menus = $mysqli->query($sql_menus) or die('Error: ' . mysqli_error($mysqli));

    while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {
        // Create Menu disk name
        $menu_disk_name = "$row[menu_sets_name] ";
        if (isset($row['menu_disk_number'])) {
            $menu_disk_name .= "$row[menu_disk_number]";
        }
        if (isset($row['menu_disk_letter'])) {
            $menu_disk_name .= "$row[menu_disk_letter]";
        }
        if (isset($row['menu_disk_part'])) {
            if (is_numeric($row['menu_disk_part'])) {
                $menu_disk_name .= " part $row[menu_disk_part]";
            } else {
                $menu_disk_name .= "$row[menu_disk_part]";
            }
        }
    }

    $smarty->assign('osd_message', $osd_message);
    $smarty->assign('menu_disk_name', $menu_disk_name);
    $smarty->assign('download_nr', $nr_downloads);
    $smarty->assign('smarty_action', 'add_file_to_menu_return');
    $smarty->assign('menu_disk_id', $menu_disk_id);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}

//****************************************************************************************
// ADD MENU CREDITS!
//****************************************************************************************

if (isset($action) and $action == "add_intro_credits") {
    if (isset($ind_id) and isset($author_type_id) and isset($menu_disk_id)) {
        if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
            //Insert individual into the menu_disk credits table
            $mysqli->query("INSERT INTO menu_disk_credits (menu_disk_id,ind_id,author_type_id)
                VALUES ('$menu_disk_id','$ind_id','$author_type_id')");

            create_log_entry('Menu disk', $menu_disk_id, 'Credits', $ind_id, 'Insert', $_SESSION['user_id']);
            $osd_message = 'credit added';
        }
        // Get the menudisk credits
        $sql_individuals = "SELECT
              individuals.ind_id,
              individuals.ind_name,
              menu_disk_credits.menu_disk_credits_id,
              author_type.author_type_info
              FROM individuals
              LEFT JOIN menu_disk_credits ON (individuals.ind_id = menu_disk_credits.ind_id)
              LEFT JOIN author_type ON (menu_disk_credits.author_type_id = author_type.author_type_id)
              WHERE menu_disk_credits.menu_disk_id = '$menu_disk_id'
              ORDER BY individuals.ind_name ASC";

        $query_individual = $mysqli->query($sql_individuals);

        $query_ind_id = "";

        while ($query = $query_individual->fetch_array(MYSQLI_BOTH)) {
            if ($query_ind_id != $query['ind_id']) {
                $sql_ind_nicks = $mysqli->query("SELECT nick_id FROM individual_nicks WHERE ind_id = '$query[ind_id]'");

                while ($fetch_ind_nicks = $sql_ind_nicks->fetch_array(MYSQLI_BOTH)) {
                    $nick_id = $fetch_ind_nicks['nick_id'];

                    $sql_nick_names = $mysqli->query("SELECT ind_name from individuals WHERE ind_id = '$nick_id'")
                        or die('Error: ' . mysqli_error($mysqli));

                    while ($fetch_nick_names = $sql_nick_names->fetch_array(MYSQLI_BOTH)) {
                        $smarty->append('ind_nick', array(
                            'ind_id' => $query['ind_id'],
                            'individual_nicks_id' => $nick_id,
                            'nick' => $fetch_nick_names['ind_name']
                        ));
                    }
                }
            }

            // This smarty is used for for the menu_disk credits
            $smarty->append('individuals', array(
                'menu_disk_credits_id' => $query['menu_disk_credits_id'],
                'ind_id' => $query['ind_id'],
                'ind_name' => $query['ind_name'],
                'menu_disk_id' => $menu_disk_id,
                'author_type_info' => $query['author_type_info']
            ));

            $query_ind_id = $query['ind_id'];
        }

        $smarty->assign('osd_message', $osd_message);
        $smarty->assign('smarty_action', 'update_menu_disk_credits');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
    }
}

//****************************************************************************************
// DELETE MENU CREDITS
//****************************************************************************************

if (isset($action) and $action == "delete_menu_disk_credits") {
    if (isset($menu_disk_credits_id)) {
        if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
            create_log_entry(
                'Menu disk',
                $menu_disk_id,
                'Credits',
                $menu_disk_credits_id,
                'Delete',
                $_SESSION['user_id']
            );

            //Insert individual into the menu_disk credits table
            $mysqli->query("DELETE FROM menu_disk_credits WHERE menu_disk_credits_id = '$menu_disk_credits_id'");
            $osd_message = 'Credits deleted';
        }

        // Get the menudisk credits
        $sql_individuals = "SELECT
              individuals.ind_id,
              individuals.ind_name,
              menu_disk_credits.menu_disk_credits_id,
              author_type.author_type_info
              FROM individuals
              LEFT JOIN menu_disk_credits ON (individuals.ind_id = menu_disk_credits.ind_id)
              LEFT JOIN author_type ON (menu_disk_credits.author_type_id = author_type.author_type_id)
              WHERE menu_disk_credits.menu_disk_id = '$menu_disk_id'
              ORDER BY individuals.ind_name ASC";

        $query_individual = $mysqli->query($sql_individuals);

        $query_ind_id = "";

        while ($query = $query_individual->fetch_array(MYSQLI_BOTH)) {
            if ($query_ind_id != $query['ind_id']) {
                $sql_ind_nicks = $mysqli->query("SELECT nick_id FROM individual_nicks WHERE ind_id = '$query[ind_id]'");

                while ($fetch_ind_nicks = $sql_ind_nicks->fetch_array(MYSQLI_BOTH)) {
                    $nick_id = $fetch_ind_nicks['nick_id'];

                    $sql_nick_names = $mysqli->query("SELECT ind_name from individuals WHERE ind_id = '$nick_id'")
                        or die('Error: ' . mysqli_error($mysqli));

                    while ($fetch_nick_names = $sql_nick_names->fetch_array(MYSQLI_BOTH)) {
                        $smarty->append('ind_nick', array(
                            'ind_id' => $query['ind_id'],
                            'individual_nicks_id' => $nick_id,
                            'nick' => $fetch_nick_names['ind_name']
                        ));
                    }
                }
            }

            // This smarty is used for for the menu_disk credits
            $smarty->append('individuals', array(
                'menu_disk_credits_id' => $query['menu_disk_credits_id'],
                'ind_id' => $query['ind_id'],
                'ind_name' => $query['ind_name'],
                'menu_disk_id' => $menu_disk_id,
                'author_type_info' => $query['author_type_info']
            ));

            $query_ind_id = $query['ind_id'];
        }

        $smarty->assign('osd_message', $osd_message);
        $smarty->assign('smarty_action', 'update_menu_disk_credits');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
    }
}

//****************************************************************************************
// DELETE MENU DISK
//****************************************************************************************

if (isset($action) and ($action == "delete_menu_disk")) {
    // first let's check if this menu disk has user comments
    $sql = $mysqli->query("SELECT * FROM menu_user_comments WHERE menu_disk_id = '$menu_disk_id'")
        or die('Error: ' . mysqli_error($mysqli));
    if ($sql->num_rows > 0) {
        $osd_message = "This menu still has user comments, please remove them first";
    } else {
        // check for downloads
        $sql = $mysqli->query("SELECT * FROM menu_disk_download WHERE menu_disk_id='$menu_disk_id'")
            or die('Error: ' . mysqli_error($mysqli));
        if ($sql->num_rows > 0) {
            $osd_message = "This menu still has downloads, please remove them first";
        } else {
            //check for screenshots
            $sql = $mysqli->query("SELECT * FROM screenshot_menu WHERE menu_disk_id='$menu_disk_id'")
                or die('Error: ' . mysqli_error($mysqli));
            if ($sql->num_rows > 0) {
                $osd_message = "This menu still has screenshots, please remove them first";
            } else {
                create_log_entry(
                    'Menu disk',
                    $menu_disk_id,
                    'Menu disk',
                    $menu_disk_id,
                    'Delete',
                    $_SESSION['user_id']
                );

                //get the menu set id
                $query_menu_sets_id = "SELECT menu_sets_id FROM menu_disk WHERE menu_disk_id = '$menu_disk_id'";
                $result = $mysqli->query($query_menu_sets_id) or die('Error: ' . mysqli_error($mysqli));
                $query_id     = $result->fetch_array(MYSQLI_BOTH);
                $menu_sets_id = $query_id['menu_sets_id'];

                //get the menu disk title id
                $sql_menu_disk_title_id = "SELECT menu_disk_title_id FROM menu_disk_title
                    WHERE menu_disk_id = '$menu_disk_id'";
                $result = $mysqli->query($sql_menu_disk_title_id) or die('Error: ' . mysqli_error($mysqli));

                while ($query_id = $result->fetch_array(MYSQLI_BOTH)) {
                    $menu_disk_title_id = $query_id['menu_disk_title_id'];

                    //get the doc cross id
                    $query_doc_game_id = "SELECT doc_games_id FROM menu_disk_title_doc_games
                        WHERE menu_disk_title_id='$menu_disk_title_id'";
                    $result_doc_game = $mysqli->query($query_doc_game_id) or die('Error: ' . mysqli_error($mysqli));
                    $query_data  = $result_doc_game->fetch_array(MYSQLI_BOTH);
                    $doc_game_id = $query_data['doc_games_id'];

                    $query_doc_tool_id = "SELECT * FROM menu_disk_title_doc_tools
                        WHERE menu_disk_title_id='$menu_disk_title_id'";
                    $result_doc_tool = $mysqli->query($query_doc_tool_id) or die('Error: ' . mysqli_error($mysqli));
                    $query_data  = $result_doc_tool->fetch_array(MYSQLI_BOTH);
                    $doc_tool_id = $query_data['doc_tools_id'];

                    //get the doc id
                    $query_doc_id = "SELECT * FROM doc_disk_game WHERE doc_disk_game_id='$doc_game_id'";
                    $result_doc_id = $mysqli->query($query_doc_id) or die('Error: ' . mysqli_error($mysqli));
                    $query_data = $result_doc_id->fetch_array(MYSQLI_BOTH);
                    $doc_id     = $query_data['doc_id'];

                    if ($doc_id == '') {
                        $query_doc_id = "SELECT * FROM doc_disk_tool WHERE doc_disk_tool_id='$doc_tool_id'";
                        $result_doc_id = $mysqli->query($query_doc_id) or die('Error: ' . mysqli_error($mysqli));
                        $query_data = $result_doc_id->fetch_array(MYSQLI_BOTH);
                        $doc_id     = $query_data['doc_id'];
                    }

                    //Lets do all the menu disk title stuff
                    $mysqli->query("DELETE from menu_disk_title WHERE menu_disk_title_id='$menu_disk_title_id'")
                        or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_game WHERE menu_disk_title_id='$menu_disk_title_id'")
                        or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_tools WHERE menu_disk_title_id='$menu_disk_title_id'")
                        or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_demo WHERE menu_disk_title_id='$menu_disk_title_id'")
                        or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_music WHERE menu_disk_title_id='$menu_disk_title_id'")
                        or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_various WHERE menu_disk_title_id='$menu_disk_title_id'")
                        or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_doc_games
                        WHERE menu_disk_title_id='$menu_disk_title_id'") or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_doc_tools
                        WHERE menu_disk_title_id='$menu_disk_title_id'") or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_set
                        WHERE menu_disk_title_id='$menu_disk_title_id'") or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE from menu_disk_title_author
                        WHERE menu_disk_title_id='$menu_disk_title_id'") or die('Error: ' . mysqli_error($mysqli));

                    //Lets do all the doc disk stuff
                    $mysqli->query("DELETE FROM doc_disk_game WHERE doc_disk_game_id='$doc_game_id'")
                         or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE FROM doc_disk_tool WHERE doc_disk_tool_id='$doc_tool_id'")
                         or die('Error: ' . mysqli_error($mysqli));
                    $mysqli->query("DELETE FROM doc WHERE doc_id='$doc_id'") or die('Error: ' . mysqli_error($mysqli));
                }

                // menu disk tables
                $mysqli->query("DELETE from menu_disk_year WHERE menu_disk_id='$menu_disk_id'")
                    or die('Error: ' . mysqli_error($mysqli));
                $mysqli->query("DELETE from menu_disk_submenu WHERE menu_disk_id='$menu_disk_id'")
                    or die('Error: ' . mysqli_error($mysqli));
                $mysqli->query("DELETE from menu_disk_credits WHERE menu_disk_id='$menu_disk_id'")
                    or die('Error: ' . mysqli_error($mysqli));
                $mysqli->query("DELETE from menu_disk WHERE menu_disk_id='$menu_disk_id'")
                    or die('Error: ' . mysqli_error($mysqli));

                $osd_message = "Menudisk completely removed";
                $smarty->assign('osd_message', $osd_message);
            }
        }
    }
    echo "$osd_message";
}

//****************************************************************************************
// UPDATE STATE/YEAR/PARENT/DELETE MENU DISK
//****************************************************************************************
if (isset($action) and ($action == "change_menu_disk_state" or $action == "change_menu_disk_year"
    or $action == "change_menu_disk_parent")) {
    if (isset($menu_disk_id)) {
        if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
            if ($action == "change_menu_disk_state") {
                //Update state
                $sql = $mysqli->query("UPDATE menu_disk SET state='$state_id'
                  WHERE menu_disk_id='$menu_disk_id'");

                create_log_entry('Menu disk', $menu_disk_id, 'State', $state_id, 'Update', $_SESSION['user_id']);
                $osd_message = 'State updated';
            // first check if the menu has already a parent entry
            } elseif ($action == "change_menu_disk_parent") {
                $sql = $mysqli->query("SELECT * FROM menu_disk_submenu
                WHERE menu_disk_id = '$menu_disk_id'") or die('Error: ' . mysqli_error($mysqli));
                if ($sql->num_rows > 0) {
                    //Update state
                    $sql = $mysqli->query("UPDATE menu_disk_submenu SET parent_id='$parent_id'
                  WHERE menu_disk_id='$menu_disk_id'");
                } else {
                    $sql_menu_parent = $mysqli->query("INSERT INTO menu_disk_submenu (parent_id, menu_disk_id)
                        VALUES ('$parent_id','$menu_disk_id')") or die('Error: ' . mysqli_error($mysqli));
                }
                create_log_entry('Menu disk', $menu_disk_id, 'Parent', $parent_id, 'Update', $_SESSION['user_id']);
                $osd_message = 'Parent updated';
            } else {
                // first check if the menu has already a year entry
                $sql = $mysqli->query("SELECT * FROM menu_disk_year
                WHERE menu_disk_id = '$menu_disk_id'") or die('Error: ' . mysqli_error($mysqli));
                if ($sql->num_rows > 0) {
                    //Update year
                    $sql = $mysqli->query("UPDATE menu_disk_year SET menu_year='$year_id'
                  WHERE menu_disk_id='$menu_disk_id'");
                } else {
                    $sql_menu_year = $mysqli->query("INSERT INTO menu_disk_year (menu_year, menu_disk_id)
                        VALUES ('$year_id','$menu_disk_id')") or die('Error: ' . mysqli_error($mysqli));
                }
                create_log_entry('Menu disk', $menu_disk_id, 'Year', $year_id, 'Update', $_SESSION['user_id']);
                $osd_message = 'Year updated';
            }
        }

        $sql_menus = "SELECT menu_disk.menu_sets_id,
        menu_set.menu_sets_name,
        menu_disk.menu_disk_id,
        menu_disk.menu_disk_number,
        menu_disk.menu_disk_letter,
        menu_disk.menu_disk_version,
        menu_disk.menu_disk_part,
        crew.crew_id,
        crew.crew_name,
        individuals.ind_id,
        individuals.ind_name,
        menu_disk_state.state_id,
        menu_disk_state.menu_state,
        menu_disk_year.menu_disk_year_id,
        menu_disk_year.menu_year,
        menu_disk_submenu.parent_id
        FROM menu_disk
        LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
        LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
        LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
        LEFT JOIN ind_menu_prod ON (menu_set.menu_sets_id = ind_menu_prod.menu_sets_id)
        LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
        LEFT JOIN menu_disk_state ON ( menu_disk.state = menu_disk_state.state_id)
        LEFT JOIN menu_disk_year ON ( menu_disk.menu_disk_id = menu_disk_year.menu_disk_id)
        LEFT JOIN menu_disk_submenu ON ( menu_disk.menu_disk_id = menu_disk_submenu.menu_disk_id)
        WHERE menu_disk.menu_disk_id = '$menu_disk_id'";

        $result_menus = $mysqli->query($sql_menus) or die('error in query');
        $row = $result_menus->fetch_array(MYSQLI_BOTH);

        $menu_disk_state  = $row['state_id'];
        $menu_disk_year   = $row['menu_disk_year_id'];
        $menu_disk_parent = $row['parent_id'];

        // Create Menu disk name
        $menu_disk_name = "$row[menu_sets_name] ";
        if (isset($row['menu_disk_number'])) {
            $menu_disk_name .= "$row[menu_disk_number]";
        }
        if (isset($row['menu_disk_letter'])) {
            $menu_disk_name .= "$row[menu_disk_letter]";
        }
        if (isset($row['menu_disk_part'])) {
            if (is_numeric($row['menu_disk_part'])) {
                $menu_disk_name .= " part $row[menu_disk_part]";
            } else {
                $menu_disk_name .= "$row[menu_disk_part]";
            }
        }
        if (isset($row['menu_disk_version']) and $row['menu_disk_version'] !== '') {
            $menu_disk_name .= " v$row[menu_disk_version]";
        }

        $smarty->assign('menus', array(
            'menu_sets_id' => $row['menu_sets_id'],
            'menu_sets_name' => $row['menu_sets_name'],
            'menu_disk_name' => $menu_disk_name,
            'menu_disk_id' => $row['menu_disk_id'],
            'menu_disk_number' => $row['menu_disk_number'],
            'menu_disk_letter' => $row['menu_disk_letter'],
            'menu_disk_version' => $row['menu_disk_version'],
            'menu_disk_part' => $row['menu_disk_part'],
            'crew_id' => $row['crew_id'],
            'crew_name' => $row['crew_name'],
            'ind_id' => $row['ind_id'],
            'ind_name' => $row['ind_name'],
            'menu_year' => $row['menu_year'],
            'menu_state' => $row['menu_state']
        ));

        //list of games for the menu disk
        $temp_query = menu_disk_software_list($menu_disk_id);

        while ($query = $temp_query->fetch_array(MYSQLI_BOTH)) {
            // This smarty is used for creating the list of games
            $smarty->append('game', array(
                'game_id' => $query['software_id'],
                'game_name' => $query['software_name'],
                'developer_id' => $query['developer_id'],
                'developer_name' => $query['developer_name'],
                'set_chain' => $query['menu_disk_title_set_chain'],
                'year' => $query['year'],
                'menu_disk_title_id' => $query['menu_disk_title_id'],
                'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
                'menu_types_text' => $query['menu_types_text']
            ));
        }

        // Get the doc disks
        $temp_query2 = menu_disk_doc_list($menu_disk_id);

        while ($query = $temp_query2->fetch_array(MYSQLI_BOTH)) {
            // This smarty is used for creating the list of games
            $smarty->append('doc_game', array(
                'game_name' => $query['software_name'],
                'game_id' => $query['software_id'],
                'year' => $query['year'],
                'developer_name' => $query['developer_name'],
                'developer_id' => $query['developer_id'],
                'doc_id' => $query['doc_id'],
                'doc_type_id' => $query['doc_type_id'],
                'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
                'menu_types_text' => $query['menu_types_text'],
                'menu_disk_title_id' => $query['menu_disk_title_id']
            ));
        }

        //get the doc types
        $sql_doc_type = "SELECT * from doc_type";
        $query_doc_type = $mysqli->query($sql_doc_type) or die('Error: ' . mysqli_error($mysqli));

        while ($query_type = $query_doc_type->fetch_array(MYSQLI_BOTH)) {
            $smarty->append('doc_type', array(
                'doc_type_id' => $query_type['doc_type_id'],
                'doc_type_name' => $query_type['doc_type_name']
            ));
        }

        // Get the menudisk credits
        $sql_individuals = "SELECT
              individuals.ind_id,
              individuals.ind_name,
              menu_disk_credits.menu_disk_credits_id,
              author_type.author_type_info
              FROM individuals
              LEFT JOIN menu_disk_credits ON (individuals.ind_id = menu_disk_credits.ind_id)
              LEFT JOIN author_type ON (menu_disk_credits.author_type_id = author_type.author_type_id)
              WHERE menu_disk_credits.menu_disk_id = '$menu_disk_id'
              ORDER BY individuals.ind_name ASC";

        $query_individual = $mysqli->query($sql_individuals) or die('Error: ' . mysqli_error($mysqli));
        ;

        $query_ind_id = "";

        while ($query = $query_individual->fetch_array(MYSQLI_BOTH)) {
            if ($query_ind_id != $query['ind_id']) {
                $sql_ind_nicks = $mysqli->query("SELECT nick_id FROM individual_nicks WHERE ind_id = '$query[ind_id]'")
                    or die('Error: ' . mysqli_error($mysqli));
                ;

                while ($fetch_ind_nicks = $sql_ind_nicks->fetch_array(MYSQLI_BOTH)) {
                    $nick_id = $fetch_ind_nicks['nick_id'];

                    $sql_nick_names = $mysqli->query("SELECT ind_name from individuals WHERE ind_id = '$nick_id'")
                        or die('Error: ' . mysqli_error($mysqli));

                    while ($fetch_nick_names = $sql_nick_names->fetch_array(MYSQLI_BOTH)) {
                        $smarty->append('ind_nick', array(
                            'ind_id' => $query['ind_id'],
                            'individual_nicks_id' => $nick_id,
                            'nick' => $fetch_nick_names['ind_name']
                        ));
                    }
                }
            }

            // This smarty is used for for the menu_disk credits
            $smarty->append('individuals', array(
                'menu_disk_credits_id' => $query['menu_disk_credits_id'],
                'ind_id' => $query['ind_id'],
                'ind_name' => $query['ind_name'],
                'menu_disk_id' => $menu_disk_id,
                'author_type_info' => $query['author_type_info']
            ));

            $query_ind_id = $query['ind_id'];
        }

        // Parent dropdown
        $sql_parent = "SELECT menu_disk.menu_sets_id,
            menu_set.menu_sets_name,
            menu_disk.menu_disk_id,
            menu_disk.menu_disk_number,
            menu_disk.menu_disk_letter,
            menu_disk.menu_disk_version,
            menu_disk.menu_disk_part
            FROM menu_disk
            LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)";

        $result_parent = $mysqli->query($sql_parent) or die('Error: ' . mysqli_error($mysqli));
        while ($row = $result_parent->fetch_array(MYSQLI_BOTH)) {
            // Create Menu disk name
            $menu_disk_name = "$row[menu_sets_name] ";
            if (isset($row['menu_disk_number'])) {
                $menu_disk_name .= "$row[menu_disk_number]";
            }
            if (isset($row['menu_disk_letter'])) {
                $menu_disk_name .= "$row[menu_disk_letter]";
            }
            if (isset($row['menu_disk_part'])) {
                if (is_numeric($row['menu_disk_part'])) {
                    $menu_disk_name .= " part $row[menu_disk_part]";
                } else {
                    $menu_disk_name .= "$row[menu_disk_part]";
                }
            }

            if (isset($row['menu_disk_version']) and $row['menu_disk_version'] !== '') {
                $menu_disk_name .= " v$row[menu_disk_version]";
            }

            $smarty->append('parent', array(
                'parent_id' => $row['menu_disk_id'],
                'parent_name' => $menu_disk_name
            ));
        }

        // Menu state dropdown
        $query_menu_state = $mysqli->query("SELECT * FROM menu_disk_state ORDER BY state_id ASC");

        while ($query = $query_menu_state->fetch_array(MYSQLI_BOTH)) {
            // This smarty is used for for the menu_disk credits
            $smarty->append('state_id', $query['state_id']);
            $smarty->append('menu_state', $query['menu_state']);
        }

        //Get the screenshots for this menu if they exist
        $sql_screenshots = $mysqli->query("SELECT * FROM screenshot_menu
              LEFT JOIN screenshot_main ON (screenshot_menu.screenshot_id = screenshot_main.screenshot_id)
              WHERE screenshot_menu.menu_disk_id = '$menu_disk_id' ORDER BY screenshot_menu.screenshot_id")
                or die('Error: ' . mysqli_error($mysqli));

        $count         = 1;
        $v_screenshots = 0;
        while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
            //Ready screenshots path and filename
            $screenshot_image = $menu_screenshot_path;
            $screenshot_image .= $screenshots['screenshot_id'];
            $screenshot_image .= '.';
            $screenshot_image .= $screenshots['imgext'];

            $smarty->append('screenshots', array(
                'count' => $count,
                'path' => $game_screenshot_path,
                'screenshot_image' => $screenshot_image,
                'id' => $screenshots['screenshot_id']
            ));

            $count++;
            $v_screenshots++;
        }

        $smarty->assign("screenshots_nr", $v_screenshots);

        //************************************************************************************************
        //Let's get the menu info for the file name concatenation, and the download data for disks already
        //uploaded
        //************************************************************************************************
        //get the existing downloads
        $SQL_DOWNLOADS = $mysqli->query("SELECT * FROM menu_disk_download WHERE menu_disk_id='$menu_disk_id'")
            or die('Error: ' . mysqli_error($mysqli));

        $nr_downloads = 0;
        while ($downloads = $SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) {
            $filepath = $menu_file_path;

            //start filling the smarty object
            $smarty->append('downloads', array(
                'menu_disk_download_id' => $downloads['menu_disk_download_id'],
                'filename' => $downloads['menu_disk_download_id'],
                'filepath' => $filepath
            ));

            $nr_downloads++;
        }

        //In all cases we search we start searching through the menu_set table
        //first
        $sql_menus = "SELECT menu_disk.menu_sets_id,
            menu_set.menu_sets_name,
            menu_disk.menu_disk_number,
            menu_disk.menu_disk_letter,
            menu_disk.menu_disk_version,
            menu_disk.menu_disk_part
            FROM menu_disk
            LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
            WHERE menu_disk.menu_disk_id = '$menu_disk_id'";

        $result_menus = $mysqli->query($sql_menus) or die('Error: ' . mysqli_error($mysqli));

        while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {
            // Create Menu disk name
            $menu_disk_name = "$row[menu_sets_name] ";
            if (isset($row['menu_disk_number'])) {
                $menu_disk_name .= "$row[menu_disk_number]";
            }
            if (isset($row['menu_disk_letter'])) {
                $menu_disk_name .= "$row[menu_disk_letter]";
            }
            if (isset($row['menu_disk_part'])) {
                if (is_numeric($row['menu_disk_part'])) {
                    $menu_disk_name .= " part $row[menu_disk_part]";
                } else {
                    $menu_disk_name .= "$row[menu_disk_part]";
                }
            }
        }

        $smarty->assign('menu_disk_name', $menu_disk_name);

        $smarty->assign('download_nr', $nr_downloads);

        if (isset($osd_message)) {
            $smarty->assign('osd_message', $osd_message);
        }
        $smarty->assign('menu_state_id', $menu_disk_state);
        $smarty->assign('menu_year_id', $menu_disk_year);
        $smarty->assign('menu_parent_id', $menu_disk_parent);

        $smarty->assign('smarty_action', 'edit_disk_box');
        $smarty->assign('menu_disk_id', $menu_disk_id);

        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
    }
}

//****************************************************************************************
// Update doctype
//****************************************************************************************
if (isset($action) and ($action == "change_doctype")) {
    if (isset($doc_type_id)) {
        if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
            //Update doc type
            $sql = $mysqli->query("UPDATE doc SET doc_type_id='$doc_type_id'
                WHERE doc_id='$doc_id'") or die('Error: ' . mysqli_error($mysqli));

            create_log_entry('Menu disk', $menu_disk_id, 'Doc type', $doc_type_id, 'Insert', $_SESSION['user_id']);
            $osd_message = 'doctype updated';
        }
    }

    // Get the doc disks
    //list of games for the menu disk
    $temp_query2 = menu_disk_doc_list($menu_disk_id);

    while ($query = $temp_query2->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of games
        $smarty->append('doc_game', array(
            'game_name' => $query['software_name'],
            'game_id' => $query['software_id'],
            'year' => $query['year'],
            'developer_name' => $query['developer_name'],
            'developer_id' => $query['developer_id'],
            'doc_id' => $query['doc_id'],
            'doc_type_id' => $query['doc_type_id'],
            'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
            'menu_types_text' => $query['menu_types_text'],
            'menu_disk_title_id' => $query['menu_disk_title_id']
        ));
    }

    //get the doc types
    $sql_doc_type = "SELECT * from doc_type";
    $query_doc_type = $mysqli->query($sql_doc_type) or die('Error: ' . mysqli_error($mysqli));

    while ($query_type = $query_doc_type->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('doc_type', array(
            'doc_type_id' => $query_type['doc_type_id'],
            'doc_type_name' => $query_type['doc_type_name']
        ));
    }

    $smarty->assign('osd_message', $osd_message);
    $smarty->assign('menu_disk_id', $menu_disk_id);
    $smarty->assign('smarty_action', 'add_doc_to_menu_return');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}

//****************************************************************************************
// Create set chain for game
//****************************************************************************************
if (isset($action) and ($action == "add_set_to_menu" or $action == "link_game_to_set"
    or $action == "delete_game_from_set")) {
    if (isset($menu_disk_title_id)) {
        if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
            if ($action == "add_set_to_menu") {
                /* first see if this title is already chained */
                $sql = $mysqli->query("SELECT * FROM menu_disk_title_set
                WHERE menu_disk_title_id = '$menu_disk_title_id'") or die('Error: ' . mysqli_error($mysqli));
                if ($sql->num_rows > 0) {
                    $osd_message = "This title is already chained - delete chain first";
                } else {
                    //check if the title is already linked
                    $sql_set_nr = "SELECT menu_disk_title_set_nr FROM menu_disk_title_set
                        WHERE menu_disk_title_id = '$menu_disk_title_id'";
                    $query_ser_nr = $mysqli->query($sql_set_nr) or die('Error: ' . mysqli_error($mysqli));
                    $query_data = $query_ser_nr->fetch_array(MYSQLI_BOTH);
                    $set_nr     = $query_data['menu_disk_title_set_nr'];

                    //if not linked
                    if ($set_nr == 0 or $set_nr = '') {
                        /*We need to get the highest set nr */
                        $sql_set_nr = "SELECT menu_disk_title_set_nr FROM menu_disk_title_set
                            order by menu_disk_title_set_nr DESC";
                        $query_set_nr = $mysqli->query($sql_set_nr) or die('Error: ' . mysqli_error($mysqli));
                        if ($query_set_nr->num_rows > 0) {
                            while ($row = $query_set_nr->fetch_array(MYSQLI_BOTH)) {
                                $set_nr = $row['menu_disk_title_set_nr'];
                                $set_nr++;
                                break;
                            }
                        } else {
                            $set_nr = 1;
                        }
                    }

                    $sql_menu_set = $mysqli->query("INSERT INTO menu_disk_title_set (menu_disk_title_set_nr,
                        menu_disk_title_set_chain, menu_disk_title_id) VALUES ('$set_nr','1', $menu_disk_title_id)")
                        or die('Error: ' . mysqli_error($mysqli));
                    $osd_message = "Chain created for this title";

                    create_log_entry(
                        'Menu disk',
                        $menu_disk_id,
                        'Chain',
                        $menu_disk_title_id,
                        'Insert',
                        $_SESSION['user_id']
                    );
                }
            } elseif ($action == "link_game_to_set") {
                if ($menu_disk_title_set_chain == 'Nr' or $menu_disk_title_set_chain == '') {
                    $osd_message = "Please add a correct part nr";
                } elseif ($chainbrowse == '' or $chainbrowse == '-') {
                    $osd_message = "Please select a set";
                } else {
                    //check if the title is already linked
                    $sql = $mysqli->query("SELECT * FROM menu_disk_title_set
                  WHERE menu_disk_title_id = '$menu_disk_title_id'") or die('Error: ' . mysqli_error($mysqli));
                    if ($sql->num_rows > 0) {
                        $osd_message = "This title is already chained - delete chain first";
                    } else {
                        $sql_menu_set = $mysqli->query("INSERT INTO menu_disk_title_set (menu_disk_title_set_nr,
                            menu_disk_title_set_chain, menu_disk_title_id)
                            VALUES ('$chainbrowse','$menu_disk_title_set_chain', $menu_disk_title_id)")
                            or die('Error: ' . mysqli_error($mysqli));
                        $osd_message = "Chain created for this title";

                        create_log_entry(
                            'Menu disk',
                            $menu_disk_id,
                            'Chain',
                            $menu_disk_title_id,
                            'Insert',
                            $_SESSION['user_id']
                        );
                    }
                }
            } elseif ($action == "delete_game_from_set") {
                create_log_entry(
                    'Menu disk',
                    $menu_disk_id,
                    'Chain',
                    $menu_disk_title_id,
                    'Delete',
                    $_SESSION['user_id']
                );

                $mysqli->query("DELETE from menu_disk_title_set WHERE menu_disk_title_id='$menu_disk_title_id'")
                    or die('Error: ' . mysqli_error($mysqli));
                $osd_message = "Title deleted from chain";
                $smarty->assign('title_name', $title_name);
            }
        }
    }

    $smarty->assign('osd_message', $osd_message);

    /* now do the regular stuff */
    $sql_games_chain = "SELECT game.game_id AS 'software_id',
        game.game_name AS 'software_name',
        menu_set.menu_sets_name,
        menu_disk.menu_disk_id,
        menu_disk.menu_disk_number,
        menu_disk.menu_disk_letter,
        menu_disk.menu_disk_part,
        menu_disk.menu_disk_version,
        menu_disk_title_set.menu_disk_title_set_id,
        menu_disk_title_set.menu_disk_title_set_nr,
        menu_disk_title_set.menu_disk_title_set_chain,
        menu_disk_title_set.menu_disk_title_id
        FROM menu_disk_title_set
        LEFT JOIN menu_disk_title_game
            ON (menu_disk_title_game.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
        LEFT JOIN game ON (game.game_id = menu_disk_title_game.game_id)
        LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
        LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
        LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
        WHERE menu_disk_title.menu_types_main_id = '1'";

    $sql_demos_chain = "SELECT demo.demo_id AS 'software_id',
        demo.demo_name AS 'software_name',
        menu_set.menu_sets_name,
        menu_disk.menu_disk_id,
        menu_disk.menu_disk_number,
        menu_disk.menu_disk_letter,
        menu_disk.menu_disk_part,
        menu_disk.menu_disk_version,
        menu_disk_title_set.menu_disk_title_set_id,
        menu_disk_title_set.menu_disk_title_set_nr,
        menu_disk_title_set.menu_disk_title_set_chain,
        menu_disk_title_set.menu_disk_title_id
        FROM menu_disk_title_set
        LEFT JOIN menu_disk_title_demo
            ON (menu_disk_title_demo.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
        LEFT JOIN demo ON (demo.demo_id = menu_disk_title_demo.demo_id)
        LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
        LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
        LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
        WHERE menu_disk_title.menu_types_main_id = '2'";

    $sql_tools_chain = "SELECT tools.tools_id AS 'software_id',
        tools.tools_name AS 'software_name',
        menu_set.menu_sets_name,
        menu_disk.menu_disk_id,
        menu_disk.menu_disk_number,
        menu_disk.menu_disk_letter,
        menu_disk.menu_disk_part,
        menu_disk.menu_disk_version,
        menu_disk_title_set.menu_disk_title_set_id,
        menu_disk_title_set.menu_disk_title_set_nr,
        menu_disk_title_set.menu_disk_title_set_chain,
        menu_disk_title_set.menu_disk_title_id
        FROM menu_disk_title_set
        LEFT JOIN menu_disk_title_tools
            ON (menu_disk_title_tools.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
        LEFT JOIN tools ON (tools.tools_id = menu_disk_title_tools.tools_id)
        LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
        LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
        LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
        WHERE menu_disk_title.menu_types_main_id = '3'";

    $temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_games_chain") or die(mysqli_error());
    $temp_query = $mysqli->query("INSERT INTO temp $sql_demos_chain") or die('Error: ' . mysqli_error($mysqli));
    $temp_query = $mysqli->query("INSERT INTO temp $sql_tools_chain") or die('Error: ' . mysqli_error($mysqli));

    $temp_query = $mysqli->query("SELECT * FROM temp ORDER BY menu_sets_name, menu_disk_title_id ASC")
        or die('Error: ' . mysqli_error($mysqli));

    $menu_disk_name_compare = "";

    while ($row = $temp_query->fetch_array(MYSQLI_BOTH)) {
        // Create Menu disk name
        if (isset($row['menu_sets_name'])) {
            if (isset($row['menu_sets_name'])) {
                $menu_disk_name = "$row[menu_sets_name]";
            }

            $menu_disk_name .= " - ";
            $menu_disk_name .= $row['software_name'];

            if ($menu_disk_name_compare == $menu_disk_name) {
                $menu_disk_name_compare = $menu_disk_name;
                if ($row['menu_disk_title_id'] == $menu_disk_title_id) {
                    $smarty->assign('select_chain_data', $row['menu_disk_title_set_nr']);
                    $smarty->assign('select_chain_nr', $row['menu_disk_title_set_chain']);
                    $smarty->assign('title_name', $row['software_name']);
                }
            } else {
                $smarty->append('chain_data', array(
                    'menu_disk_title_set_id' => $row['menu_disk_title_set_id'],
                    'menu_disk_title_set_nr' => $row['menu_disk_title_set_nr'],
                    'menu_disk_title_set_chain' => $row['menu_disk_title_set_chain'],
                    'menu_disk_title_id' => $menu_disk_title_id,
                    'menu_disk_name' => $menu_disk_name
                ));

                if ($row['menu_disk_title_id'] == $menu_disk_title_id) {
                    $smarty->assign('select_chain_data', $row['menu_disk_title_set_nr']);
                    $smarty->assign('select_chain_nr', $row['menu_disk_title_set_chain']);
                    $smarty->assign('title_name', $row['software_name']);
                }
                $menu_disk_name_compare = $menu_disk_name;
            }
        }
    }

    //get the titles from this set
    //First get the setnr
    $sql_set_nr = "SELECT menu_disk_title_set_nr FROM menu_disk_title_set
        WHERE menu_disk_title_id = '$menu_disk_title_id'";
    $query_ser_nr = $mysqli->query($sql_set_nr) or die('Error: ' . mysqli_error($mysqli));
    $query_data = $query_ser_nr->fetch_array(MYSQLI_BOTH);
    $set_nr     = $query_data['menu_disk_title_set_nr'];

    if ($set_nr != '') {
        $sql_games_chain = "SELECT game.game_id AS 'software_id',
            game.game_name AS 'software_name',
            menu_set.menu_sets_name,
            menu_disk.menu_disk_id,
            menu_disk.menu_disk_number,
            menu_disk.menu_disk_letter,
            menu_disk.menu_disk_part,
            menu_disk.menu_disk_version,
            menu_disk_title_set.menu_disk_title_set_id,
            menu_disk_title_set.menu_disk_title_set_nr,
            menu_disk_title_set.menu_disk_title_set_chain,
            menu_disk_title_set.menu_disk_title_id
            FROM menu_disk_title_set
            LEFT JOIN menu_disk_title_game
                ON (menu_disk_title_game.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
            LEFT JOIN game ON (game.game_id = menu_disk_title_game.game_id)
            LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
            LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
            LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
            WHERE menu_disk_title.menu_types_main_id = '1' AND menu_disk_title_set.menu_disk_title_set_nr = '$set_nr'
            ORDER BY menu_disk_title_set.menu_disk_title_set_chain ASC";

        $sql_demos_chain = "SELECT demo.demo_id AS 'software_id',
            demo.demo_name AS 'software_name',
            menu_set.menu_sets_name,
            menu_disk.menu_disk_id,
            menu_disk.menu_disk_number,
            menu_disk.menu_disk_letter,
            menu_disk.menu_disk_part,
            menu_disk.menu_disk_version,
            menu_disk_title_set.menu_disk_title_set_id,
            menu_disk_title_set.menu_disk_title_set_nr,
            menu_disk_title_set.menu_disk_title_set_chain,
            menu_disk_title_set.menu_disk_title_id
            FROM menu_disk_title_set
            LEFT JOIN menu_disk_title_demo
                ON (menu_disk_title_demo.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
            LEFT JOIN demo ON (demo.demo_id = menu_disk_title_demo.demo_id)
            LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
            LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
            LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
            WHERE menu_disk_title.menu_types_main_id = '2' AND menu_disk_title_set.menu_disk_title_set_nr = '$set_nr'
            ORDER BY menu_disk_title_set.menu_disk_title_set_chain ASC";

        $sql_tools_chain = "SELECT tools.tools_id AS 'software_id',
            tools.tools_name AS 'software_name',
            menu_set.menu_sets_name,
            menu_disk.menu_disk_id,
            menu_disk.menu_disk_number,
            menu_disk.menu_disk_letter,
            menu_disk.menu_disk_part,
            menu_disk.menu_disk_version,
            menu_disk_title_set.menu_disk_title_set_id,
            menu_disk_title_set.menu_disk_title_set_nr,
            menu_disk_title_set.menu_disk_title_set_chain,
            menu_disk_title_set.menu_disk_title_id
            FROM menu_disk_title_set
            LEFT JOIN menu_disk_title_tools
                ON (menu_disk_title_tools.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
            LEFT JOIN tools ON (tools.tools_id = menu_disk_title_tools.tools_id)
            LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
            LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
            LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
            WHERE menu_disk_title.menu_types_main_id = '3' AND menu_disk_title_set.menu_disk_title_set_nr = '$set_nr'
            ORDER BY menu_disk_title_set.menu_disk_title_set_chain ASC";

        $temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp3 ENGINE=MEMORY $sql_games_chain")
            or die(mysqli_error());
        $temp_query = $mysqli->query("INSERT INTO temp3 $sql_demos_chain") or die('Error: ' . mysqli_error($mysqli));
        $temp_query = $mysqli->query("INSERT INTO temp3 $sql_tools_chain") or die('Error: ' . mysqli_error($mysqli));

        $temp_query = $mysqli->query("SELECT * FROM temp3 ORDER BY menu_sets_name, menu_disk_title_id ASC")
            or die('Error: ' . mysqli_error($mysqli));

        while ($row = $temp_query->fetch_array(MYSQLI_BOTH)) {
            // Create Menu disk name
            if (isset($row['menu_sets_name'])) {
                $menu_disk_name = "$row[menu_sets_name] ";
                if (isset($row['menu_disk_number'])) {
                    $menu_disk_name .= "$row[menu_disk_number]";
                }
                if (isset($row['menu_disk_letter'])) {
                    $menu_disk_name .= "$row[menu_disk_letter]";
                }
                if (isset($row['menu_disk_part'])) {
                    if (is_numeric($row['menu_disk_part'])) {
                        $menu_disk_name .= " part $row[menu_disk_part]";
                    } else {
                        $menu_disk_name .= "$row[menu_disk_part]";
                    }
                }

                if (isset($row['menu_disk_version']) and $row['menu_disk_version'] !== '') {
                    $menu_disk_name .= " v$row[menu_disk_version]";
                }

                $menu_disk_name .= " - ";
                $menu_disk_name .= $row['software_name'];
                $menu_disk_name .= " - part ";
                $menu_disk_name .= $row['menu_disk_title_set_chain'];

                $smarty->append('selected_chain_data', array(
                    'menu_disk_title_set_id' => $row['menu_disk_title_set_id'],
                    'menu_disk_title_set_nr' => $row['menu_disk_title_set_nr'],
                    'menu_disk_title_set_chain' => $row['menu_disk_title_set_chain'],
                    'menu_disk_title_id' => $menu_disk_title_id,
                    'menu_disk_name' => $menu_disk_name
                ));
            }
        }
    }

    //list of games for the menu disk
    $temp_query = menu_disk_software_list($menu_disk_id);

    while ($query = $temp_query->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of games
        $smarty->append('game', array(
            'game_id' => $query['software_id'],
            'game_name' => $query['software_name'],
            'developer_id' => $query['developer_id'],
            'developer_name' => $query['developer_name'],
            'set_chain' => $query['menu_disk_title_set_chain'],
            'year' => $query['year'],
            'menu_disk_title_id' => $query['menu_disk_title_id'],
            'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
            'menu_types_text' => $query['menu_types_text']
        ));
    }

    $smarty->assign('smarty_action', 'add_chain_to_menu_return');
    $smarty->assign('menu_disk_id', $menu_disk_id);
    $smarty->assign('menu_disk_title_id', $menu_disk_title_id);

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}

//****************************************************************************************
// Add an author to a menu_disk_title
//****************************************************************************************
if ($action == 'add_author' or $action == 'delete_menu_disk_title_credits') {
    //Get the menu_disk_id
    $sql_menu_disk_id = $mysqli->query("SELECT menu_disk_id FROM menu_disk_title
        WHERE menu_disk_title_id ='$menu_disk_title_id'");

    while ($query = $sql_menu_disk_id->fetch_array(MYSQLI_BOTH)) {
        $menu_disk_id = $query['menu_disk_id'];
    }

    if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == '1') {
        if ($action == 'add_author') {
            //Insert author into the menu_disk_title_author table
            $mysqli->query("INSERT INTO menu_disk_title_author (menu_disk_title_id,ind_id,author_type_id)
                VALUES ('$menu_disk_title_id','$ind_id','$author_type_id')") or die('Error: ' . mysqli_error($mysqli));

            create_log_entry(
                'Menu disk',
                $menu_disk_id,
                'Authors',
                $menu_disk_title_id,
                'Insert',
                $_SESSION['user_id']
            );
            $osd_message = 'Author added';
        } else {
            //delete author from the menu_disk_title_author table
            $mysqli->query("DELETE FROM menu_disk_title_author WHERE menu_disk_title_id='$menu_disk_title_id'
                and ind_id ='$ind_id' and author_type_id ='$author_type_id'") or die('Error: ' . mysqli_error($mysqli));

            create_log_entry(
                'Menu disk',
                $menu_disk_id,
                'Authors',
                $menu_disk_title_id,
                'Delete',
                $_SESSION['user_id']
            );
            $osd_message = 'Author deleted';
        }
    }

    //Get the individuals
    $sql_individuals = $mysqli->query("SELECT * FROM individuals ORDER BY ind_name ASC");

    while ($individuals = $sql_individuals->fetch_array(MYSQLI_BOTH)) {
        if ($individuals['ind_name'] != '') {
            $smarty->append('ind_gene', array(
                'ind_id' => $individuals['ind_id'],
                'ind_name' => $individuals['ind_name']
            ));
        }
    }

    //load the authors for this title
    $sql_author_info = "SELECT  individuals.ind_id,
                        individuals.ind_name,
                        author_type.author_type_info,
                        author_type.author_type_id
                        FROM menu_disk_title_author
                        LEFT JOIN individuals ON (individuals.ind_id = menu_disk_title_author.ind_id)
                        LEFT JOIN author_type ON (menu_disk_title_author.author_type_id = author_type.author_type_id)
                        WHERE menu_disk_title_author.menu_disk_title_id = '$menu_disk_title_id'
                        ORDER BY individuals.ind_name ASC";

    $query_author_info = $mysqli->query($sql_author_info) or die("problem getting author info");

    while ($query = $query_author_info->fetch_array(MYSQLI_BOTH)) {
        $sql_ind_nicks = $mysqli->query("SELECT nick_id FROM individual_nicks WHERE ind_id = '$query[ind_id]'");

        while ($fetch_ind_nicks = $sql_ind_nicks->fetch_array(MYSQLI_BOTH)) {
            $nick_id = $fetch_ind_nicks['nick_id'];

            $sql_nick_names = $mysqli->query("SELECT ind_name from individuals WHERE ind_id = '$nick_id'")
                or die('Error: ' . mysqli_error($mysqli));

            while ($fetch_nick_names = $sql_nick_names->fetch_array(MYSQLI_BOTH)) {
                $smarty->append('ind_nick', array(
                    'ind_id' => $query['ind_id'],
                    'individual_nicks_id' => $nick_id,
                    'nick' => $fetch_nick_names['ind_name']
                ));
            }
        }

        // This smarty is used for for the menu_disk_title credits
        $smarty->append('title_credits', array(
            'ind_id' => $query['ind_id'],
            'ind_name' => $query['ind_name'],
            'author_type_id' => $query['author_type_id'],
            'author_type_info' => $query['author_type_info']
        ));
    }

    // Get Author types for
    $sql_author_types = "SELECT * FROM author_type ORDER BY author_type_info ASC";
    $query_author = $mysqli->query($sql_author_types) or die('Error: ' . mysqli_error($mysqli));

    while ($author_ind = $query_author->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('author_type', array(
            'author_type_id' => $author_ind['author_type_id'],
            'author_type_info' => $author_ind['author_type_info']
        ));
    }

    $smarty->assign('menu_disk_title_id', $menu_disk_title_id);

    // Create dropdown values a-z
    $az_value  = az_dropdown_value(0);
    $az_output = az_dropdown_output(0);

    $smarty->assign('smarty_action', 'title_credits_return');
    $smarty->assign('osd_message', $osd_message);
    $smarty->assign('az_value', $az_value);
    $smarty->assign('az_output', $az_output);

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
}
