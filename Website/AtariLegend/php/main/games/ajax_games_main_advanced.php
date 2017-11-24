<?php
/***************************************************************************
 *                                ajax_games_main_advanced.php
 *                            --------------------------
 *   begin                : 2017-11-14
 *   copyright            : (C) 2017 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the game browse page where you can navigate your way through the games db
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");

//***********************************************************************************
//get the attribute type liet
//***********************************************************************************

// get software devtools list
$sql_software_devtool = $mysqli->query("SELECT software_devtool_id,
                   software_devtool_name
                   FROM software_devtool
                   ORDER BY software_devtool_name ASC")
                or die("Problems retriving software_devtool.");

while ($software_devtool = $sql_software_devtool->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('software_devtool', array(
                    'software_devtool_id' => $software_devtool['software_devtool_id'],
                    'software_devtool_name' => $software_devtool['software_devtool_name']));
}
// software_origin
$sql_software_origin = $mysqli->query("SELECT software_origin_id,
                   software_origin_name
                   FROM software_origin
                   ORDER BY software_origin_name ASC")
                or die("Problems retriving software_origin.");

while ($software_origin = $sql_software_origin->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('software_origin', array(
                    'software_origin_id' => $software_origin['software_origin_id'],
                    'software_origin_name' => $software_origin['software_origin_name']));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder. "ajax_games_main_advanced.html");

//close the connection
mysqli_close($mysqli);
