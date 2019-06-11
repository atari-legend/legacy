<?php
/***************************************************************************
 *                                ajax_add_author_menutitle.php
 *                            ----------------------------------
 *   begin                : 05 February 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : admin@atarilegend.com
 *                         Created file - STG
 *
 *  id : ajax_add_author_menutitle.php ,v 0.10 2017/02/05 ST Graveyard 22:38
 *          - AL 2.0
 *
 ***************************************************************************

************************************************************************************************
On this page we link authors to a menu disk title
************************************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

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
    author_type.author_type_id,
    menu_disk_title_author.menu_disk_title_author_id
    FROM menu_disk_title_author
    LEFT JOIN individuals ON (individuals.ind_id = menu_disk_title_author.ind_id)
    LEFT JOIN author_type ON (menu_disk_title_author.author_type_id = author_type.author_type_id)
    WHERE menu_disk_title_author.menu_disk_title_id = '$menu_disk_title_id'
    ORDER BY individuals.ind_name ASC";

$query_author_info = $mysqli->query($sql_author_info) or die("problem getting author info");

while ($query = $query_author_info->fetch_array(MYSQLI_BOTH)) {
    // This smarty is used for for the menu_disk_title credits
    $smarty->append('title_credits', array(
        'ind_id' => $query['ind_id'],
        'ind_name' => $query['ind_name'],
        'author_type_id' => $query['author_type_id'],
        'author_type_info' => $query['author_type_info'],
        'menu_disk_title_author_id' => $query['menu_disk_title_author_id']
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

// Create dropdown values a-z
$az_value  = az_dropdown_value(0);
$az_output = az_dropdown_output(0);

$smarty->assign('menu_disk_title_id', $menu_disk_title_id);
$smarty->assign('title_name', $game_name);

$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "menus/ajax_menus_add_author_title.html");

//close the connection
mysqli_close($mysqli);
