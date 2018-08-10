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
include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/MenusSetDAO.php";
require_once __DIR__."/../../common/DAO/MenusDiskListDAO.php";

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$menusDao = new AL\Common\DAO\MenusDiskListDAO($mysqli);
$menusetDao = new AL\Common\DAO\MenusSetDAO($mysqli);

/*
 ************************************************************************************************
 This is the menus disk search list page
 ************************************************************************************************
 */
$start1 = gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));

//Get menu disk list array from db and push it to smarty
$smarty->assign('menus_list', $menusDao->getMenuDisksForSet($menu_sets_id));

$menu_disk_rows = count($menusDao->getMenuDisksForSet($menu_sets_id));

//Get menu set list array from db and push it to smarty
$smarty->assign('menuset_list', $menusDao->getMenuSetsBuild());

// Get menu set information on selected Set
$menuset_info = $menusetDao->getMenuSetInfo($menu_sets_id);
$smarty->assign('menuset_info', $menuset_info);

// Get Crew data for the crew search

$end1       = gettimeofday();
$totaltime1 = (float) ($end1['sec'] - $start1['sec']) + ((float) ($end1['usec'] - $start1['usec']) / 1000000);

// Crew data for crew editor
$sql_crew = $mysqli->query("SELECT * FROM crew WHERE crew_name REGEXP '^[0-9].*' ORDER BY crew_name") or die('Error: ' . mysqli_error($mysqli));

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
                        WHERE crew_menu_prod.menu_sets_id = '$menu_sets_id' ORDER BY crew.crew_name ASC") or die('Error: ' . mysqli_error($mysqli));

while ($crew_result = $sql_crew->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('connected_crew', array(
        'crew_id' => $crew_result['crew_id'],
        'crew_name' => $crew_result['crew_name'],
        'menu_sets_id' => $menu_sets_id
    ));
}

// ind data for ind editor
$sql_ind = $mysqli->query("SELECT * FROM individuals WHERE ind_name REGEXP '^[0-9].*' ORDER BY ind_name") or die('Error: ' . mysqli_error($mysqli));

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
                            WHERE ind_menu_prod.menu_sets_id = '$menu_sets_id' ORDER BY individuals.ind_name ASC") or die('Error: ' . mysqli_error($mysqli));

while ($ind_result = $sql_ind->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('connected_ind', array(
        'ind_id' => $ind_result['ind_id'],
        'ind_name' => $ind_result['ind_name'],
        'menu_sets_id' => $menu_sets_id
    ));
}

//get the menu types for the types dropdown
$sql_menu_types = $mysqli->query("SELECT * FROM menu_types_main") or die('Error: ' . mysqli_error($mysqli));

while ($menu_types_result = $sql_menu_types->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('menu_types', array(
        'menu_types_id' => $menu_types_result['menu_types_main_id'],
        'menu_types_text' => $menu_types_result['menu_types_text']
    ));
}

//the connected menu type
$sql_menu_types_connection = $mysqli->query("SELECT
                        menu_types_main.menu_types_main_id,
                        menu_types_main.menu_types_text
                        FROM menu_types_main
                        LEFT JOIN menu_type ON ( menu_type.menu_types_main_id =  menu_types_main.menu_types_main_id)
                        WHERE menu_type.menu_sets_id = '$menu_sets_id'") or die('Error: ' . mysqli_error($mysqli));

while ($menu_types_connection_result = $sql_menu_types_connection->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('connected_menu_types', array(
        'menu_types_main_id' => $menu_types_connection_result['menu_types_main_id'],
        'menu_types_text' => $menu_types_connection_result['menu_types_text'],
        'menu_sets_id' => $menu_sets_id
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
$smarty->assign('nr_of_entries', $menu_disk_rows);

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "menus_disk_list.html");

//close the connection
mysqli_free_result($result_menus);
