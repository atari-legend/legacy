<?php
/***************************************************************************
 *                                menus_disk_list.php
 *                            --------------------------
 *   begin                : June 05, 2015
 *   copyright            : (C) 2015 Atari Legend
 *   email                : admin@atarilegend.com
 *                         Created file - Silver Surfer
 *
 *  id : menus_disk_list.php ,v 0.10 2016/08/26 ST Graveyard 23:22
 *          - AL 2.0
 *
 ***************************************************************************/

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

/*
 ************************************************************************************************
 This is the menus disk search list page
 ************************************************************************************************
 */
$start1 = gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));

//In all cases we search we start searching through the menu_set table
//first
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
                        menu_disk_state.menu_state
                        FROM menu_disk
                        LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
                        LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
                        LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
                        LEFT JOIN ind_menu_prod ON (menu_set.menu_sets_id = ind_menu_prod.menu_sets_id)
                        LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
                        LEFT JOIN menu_disk_state ON ( menu_disk.state = menu_disk_state.state_id)
                        WHERE menu_disk.menu_sets_id = '$menu_sets_id' ORDER BY menu_disk_number, menu_disk_letter, menu_disk_part, menu_disk_version ASC";

$result_menus = $mysqli->query($sql_menus);

$rows = $result_menus->num_rows;
$i    = 0;
while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {
    $i++;

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

    $smarty->append('menus', array(
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
        'menu_state' => $row['menu_state']
    ));
}

$end1       = gettimeofday();
$totaltime1 = (float) ($end1['sec'] - $start1['sec']) + ((float) ($end1['usec'] - $start1['usec']) / 1000000);

$result_menu_set = $mysqli->query("SELECT * FROM menu_set WHERE menu_sets_id = '$menu_sets_id'");
$row             = $result_menu_set->fetch_array(MYSQLI_BOTH);

$smarty->assign('menu_set', array(
    'menu_sets_id' => $row['menu_sets_id'],
    'online' => $row['publish'],
    'menu_sets_name' => $row['menu_sets_name']
));

// Crew data for crew editor
$sql_crew = $mysqli->query("SELECT * FROM crew WHERE crew_name REGEXP '^[0-9].*' ORDER BY crew_name") or die("Couldn't query Crew database");

while ($crew_result = $sql_crew->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('crew', array(
        'crew_id' => $crew_result['crew_id'],
        'crew_name' => $crew_result['crew_name']
    ));
}

//Get data for crew editor box, what crews are connected to this menu_set
$sql_crew = $mysqli->query("SELECT
                        crew.crew_id,
                        crew.crew_name
                        FROM crew_menu_prod
                        LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
                        WHERE crew_menu_prod.menu_sets_id = '$menu_sets_id' ORDER BY crew.crew_name ASC") or die("Couldn't query Crew database");

while ($crew_result = $sql_crew->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('connected_crew', array(
        'crew_id' => $crew_result['crew_id'],
        'crew_name' => $crew_result['crew_name']
    ));
}

// ind data for ind editor
$sql_ind = $mysqli->query("SELECT * FROM individuals WHERE ind_name REGEXP '^[0-9].*' ORDER BY ind_name") or die("Couldn't query individuals database");

while ($ind_result = $sql_ind->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('ind', array(
        'ind_id' => $ind_result['ind_id'],
        'ind_name' => $ind_result['ind_name']
    ));
}

//Get data for individuals box, what individuals are connected to this menu_set
$sql_ind = $mysqli->query("SELECT
                            individuals.ind_id,
                            individuals.ind_name
                            FROM ind_menu_prod
                            LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
                            WHERE ind_menu_prod.menu_sets_id = '$menu_sets_id' ORDER BY individuals.ind_name ASC") or die("Couldn't query individuals database for ind connection");

while ($ind_result = $sql_ind->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('connected_ind', array(
        'ind_id' => $ind_result['ind_id'],
        'ind_name' => $ind_result['ind_name']
    ));
}

//get the menu types for the types dropdown
$sql_menu_types = $mysqli->query("SELECT * FROM menu_types_main") or die("Couldn't query menu types main database");

while ($menu_types_result = $sql_menu_types->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('menu_types', array(
        'menu_types_id' => $menu_types_result['menu_types_main_id'],
        'menu_types_text' => $menu_types_result['menu_types_text']
    ));
}

//the the connected menu type
$sql_menu_types_connection = $mysqli->query("SELECT
                        menu_types_main.menu_types_main_id,
                        menu_types_main.menu_types_text
                        FROM menu_types_main
                        LEFT JOIN menu_type ON ( menu_type.menu_types_main_id =  menu_types_main.menu_types_main_id)
                        WHERE menu_type.menu_sets_id = '$menu_sets_id'") or die("Couldn't query menu types database for type connection");

while ($menu_types_connection_result = $sql_menu_types_connection->fetch_array(MYSQLI_BOTH)) {

    $smarty->append('connected_menu_types', array(
        'menu_types_main_id' => $menu_types_connection_result['menu_types_main_id'],
        'menu_types_text' => $menu_types_connection_result['menu_types_text']
    ));
}

//get the menu sets for the quick changer
$result_menus = $mysqli->query("SELECT * FROM menu_set ORDER BY menu_sets_name ASC");

while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {

    $smarty->append('menu_set_list', array(
        'menu_sets_id' => $row['menu_sets_id'],
        'menu_sets_name' => $row['menu_sets_name']
    ));
}

// Create dropdown values a-z
$az_value  = az_dropdown_value(0);
$az_output = az_dropdown_output(0);

$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);

$smarty->assign('querytime', $totaltime1);
$smarty->assign('nr_of_entries', $i);

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "menus_disk_list.html");

//close the connection
mysqli_free_result($result_menus);
?>
