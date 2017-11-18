<?php
/***************************************************************************
 *                                attributes_editor.php
 *                            ------------------------
 *   begin                : 2017-11-15
 *   copyright            : (C) 2017 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation of file

 *
 ***************************************************************************/

//****************************************************************************************
// attributes editor main file
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/games/quick_search_games.php");

//***********************************************************************************
//get the attribute Category list
//***********************************************************************************

$sql_attribute_category = $mysqli->query("SELECT * FROM attribute_category") or die('Error: ' . mysqli_error($mysqli));

while ($attribute_category = $sql_attribute_category->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('attribute_category', array(
        'attribute_category_id' => $attribute_category['attribute_category_id'],
        'attribute_category_name' => $attribute_category['attribute_category_name']
    ));
}

//***********************************************************************************
//get the attribute type list
//***********************************************************************************

$sql_attribute_type = $mysqli->query("SELECT * FROM attribute_type") or die('Error: ' . mysqli_error($mysqli));

while ($attribute_types = $sql_attribute_type->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('attribute_types', array(
        'attribute_type_id' => $attribute_types['attribute_type_id'],
        'attribute_type_name' => $attribute_types['attribute_type_name']
    ));
}


$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "attributes_editor_main.html");

//close the connection
mysqli_close($mysqli);
