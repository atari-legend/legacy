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

$sql_attribute_type = $mysqli->query("SELECT * FROM attribute_type") or die('Error: ' . mysqli_error($mysqli));

while ($attribute_types = $sql_attribute_type->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('attribute_types', array(
        'attribute_type_id' => $attribute_types['attribute_type_id'],
        'attribute_type_name' => $attribute_types['attribute_type_name']
    ));
}

//***********************************************************************************
//get the game hardware attributes
//***********************************************************************************

$sql_attribute_hardware_type = $mysqli->query("SELECT * FROM attribute_hardware_type") or die('Error: ' . mysqli_error($mysqli));

while ($attribute_hardware_types = $sql_attribute_hardware_type->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('attribute_hardware_types', array(
        'attribute_hardware_type_id' => $attribute_hardware_types['attribute_hardware_type_id'],
        'attribute_hardware_type_name' => $attribute_hardware_types['attribute_hardware_type_name']
    ));
}



//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder. "ajax_games_main_advanced.html");

//close the connection
mysqli_close($mysqli);
