<?php
/***************************************************************************
 *                             ajax_menus.php
 *                            -----------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation from scratch for smarty usage
 *
 *
 *   Id: ajax_menus.php,v 0.2 2016/08/31 STG 19:55
 *           - Add logs
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */
include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/menus/db_menu_functions.php");
require_once __DIR__."/../../common/DAO/MenuDiskDetailDAO.php";
require_once __DIR__."/../../common/DAO/IndividualDAO.php";

$individualDao = new AL\Common\DAO\IndividualDAO($mysqli);

// EDIT BOX FOR A MENU DISK!!!
if (isset($action) and $action == "edit_disk_box" and $menu_disk_id !== '') {
    $menudetailDao = new AL\Common\DAO\MenuDiskDetailDAO($mysqli);

    $menu_detail = $menudetailDao->getMenuDiskDetail($menu_disk_id);

    $menu_disk_state  = $menu_detail->getMenuStateId();
    $menu_disk_year   = $menu_detail->getMenuDiskYearId();
    $menu_disk_parent = $menu_detail->getMenuParentId();

    $smarty->assign('menus', $menu_detail);

    //list of Software for the menu disk
    $temp_query = menu_disk_software_list($menu_disk_id);

    while ($query = $temp_query->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of games
        $smarty->append('game', array(
            'game_name' => $query['software_name'],
            'game_id' => $query['software_id'],
            'set_chain' => $query['menu_disk_title_set_chain'],
            'developer_name' => $query['developer_name'],
            'developer_id' => $query['developer_id'],
            'year' => $query['year'],
            'menu_disk_title_id' => $query['menu_disk_title_id'],
            'menu_disk_title_author_id' => $query['menu_disk_title_author_id'],
            'menu_types_text' => $query['menu_types_text']
        ));
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

    // Get the menudisk credits
    $menucreditDao = new AL\Common\DAO\MenuDiskDetailDAO($mysqli);
    $smarty->assign('individuals', $menucreditDao->getMenuDiskCredits($menu_disk_id));

    // Menu state dropdown
    $query_menu_state = $mysqli->query("SELECT * FROM menu_disk_state ORDER BY state_id ASC") or die('Error: ' . mysqli_error($mysqli));

    while ($query = $query_menu_state->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for for the menu_disk credits
        $smarty->append('state_id', $query['state_id']);
        $smarty->append('menu_state', $query['menu_state']);
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
    $SQL_DOWNLOADS = $mysqli->query("SELECT * FROM menu_disk_download WHERE menu_disk_id='$menu_disk_id'") or die('Error: ' . mysqli_error($mysqli));

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
    $sql_menus = "SELECT
            menu_disk.menu_sets_id,
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
    $smarty->assign('menu_state_id', $menu_disk_state);
    $smarty->assign('menu_year_id', $menu_disk_year);
    $smarty->assign('menu_parent_id', $menu_disk_parent);
    $smarty->assign('smarty_action', 'edit_disk_box');
    $smarty->assign('menu_disk_id', $menu_disk_id);
}

/**
 * Close Edit Box for menu disk
 * @param integer $menu_disk_id ID of the menu disk to close
 */

if (isset($action) and $action == "close_edit_disk_box" and $menu_disk_id !== '') {
    $menudetailDao = new AL\Common\DAO\MenuDiskDetailDAO($mysqli);

    $menu_detail = $menudetailDao->getMenuDiskDetail($menu_disk_id);

    $menu_disk_state  = $menu_detail->getMenuStateId();
    $menu_disk_year   = $menu_detail->getMenuDiskYearId();
    $menu_disk_parent = $menu_detail->getMenuParentId();

    $smarty->assign('menus', $menu_detail);

    $smarty->assign('smarty_action', 'close_edit_disk_box');
    $smarty->assign('menu_disk_id', $menu_disk_id);
}

// POP ADD INTRO CREDITS
if (isset($action) and $action == "add_intro_credit") {

    // Get individual data for the author search
    $smarty->assign('individuals', $individualDao->getIndividualsStartingWith("num"));
    $menu_disk_id = $query;

    // Get Author types for
    $sql_author_types = "SELECT * FROM author_type ORDER BY author_type_info ASC";
    $query_author = $mysqli->query($sql_author_types) or die('Error: ' . mysqli_error($mysqli));

    while ($author_ind = $query_author->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('author_type', array(
            'author_type_id' => $author_ind['author_type_id'],
            'author_type_info' => $author_ind['author_type_info']
        ));
    }

    // Create dropdown values a-z
    $az_value  = az_dropdown_value(0);
    $az_output = az_dropdown_output(0);

    $smarty->assign('az_value', $az_value);
    $smarty->assign('az_output', $az_output);

    $smarty->assign('smarty_action', 'add_intro_credit');
    $smarty->assign('menu_disk_id', $menu_disk_id);
}

//
// Individual browse section
//
if (isset($action) and $action == "ind_gen_browse") {
    if (isset($query)) {
        $smarty->assign('individuals', $individualDao->getIndividualsStartingWith($query));
    }
    $smarty->assign('smarty_action', 'ind_gen_browse');
}

//
// Individual search section
//
if (isset($action) and $action == "ind_gen_search") {
    if (isset($query) and $query !== "empty") {
        $query = $mysqli->real_escape_string($query);
        $query_temporary = $mysqli->query("SELECT ind_id,ind_name FROM individuals WHERE ind_name LIKE '%$query%' ORDER BY ind_name ASC") or die('Error: ' . mysqli_error($mysqli));
    } elseif ($query == "empty") {
        $query_temporary = $mysqli->query("SELECT ind_id,ind_name FROM individuals WHERE ind_name LIKE '%a%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
    }

    while ($genealogy_ind = $query_temporary->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('author_type', array(
            'ind_id' => $genealogy_ind['ind_id'],
            'ind_name' => $genealogy_ind['ind_name']
        ));
    }
    $smarty->assign('smarty_action', 'ind_gen_browse');
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_menus_detail.html");
