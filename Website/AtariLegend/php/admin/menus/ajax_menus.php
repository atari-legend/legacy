<?php
/***************************************************************************
 *                             ajax_menus.php
 *                            -----------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation from scratch for smarty usage
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */
include("../../includes/common.php");
include("../../includes/admin.php");

// Crew browse function
if (isset($action) and $action == "crew_browse") {
    // Do a simple gamesearch... no aka's or the likes of that.
    if (isset($query) and $query == "num") {
        $crewbrowse_select = " WHERE crew_name REGEXP '^[0-9].*'";
    } else {
        $crewbrowse_select = " WHERE crew_name LIKE '$query%'";
    }

    $sql_build = "SELECT * FROM crew ";

    $sql_build .= $crewbrowse_select;
    $sql_build .= " ORDER BY crew_name ASC";

    $query = $mysqli->query($sql_build) or die("Couldn't query crew Database ($sql_build)");

    $smarty->assign('smarty_action', 'crew_list');

    while ($query_crew = $query->fetch_array(MYSQLI_BOTH)) { // This smarty is used for creating the list of crews
        $smarty->append('crew', array(
            'crew_id' => $query_crew['crew_id'],
            'crew_name' => $query_crew['crew_name']
        ));
    }
}

// Individual browse function
if (isset($action) and $action == "ind_browse") {
    // Do a simple gamesearch... no aka's or the likes of that.
    if (isset($query) and $query == "num") {
        $indbrowse_select = " WHERE ind_name REGEXP '^[0-9].*'";
    } else {
        $indbrowse_select = " WHERE ind_name LIKE '$query%'";
    }

    $sql_build = "SELECT * FROM individuals ";

    $sql_build .= $indbrowse_select;
    $sql_build .= " ORDER BY ind_name ASC";

    $query = $mysqli->query($sql_build) or die("Couldn't query individual Database ($sql_build)");

    $smarty->assign('smarty_action', 'ind_list');

    while ($query_ind = $query->fetch_array(MYSQLI_BOTH)) { // This smarty is used for creating the list of crews
        $smarty->append('ind', array(
            'ind_id' => $query_ind['ind_id'],
            'ind_name' => $query_ind['ind_name']
        ));
    }
}

// Add new menu disk box
if (isset($action) and $action == "add_new_disk_box") {
    $smarty->assign('smarty_action', 'add_new_disk_box');
    $smarty->assign('menu_sets_id', $menu_sets_id);
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_menus.html");
