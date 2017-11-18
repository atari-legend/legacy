<?php
/***************************************************************************
 *                                ajax_attributes.php
 *                            ------------------------
 *   begin                : 2017-11-17
 *   copyright            : (C) 2017 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation of file

 *
 ***************************************************************************/

//****************************************************************************************
// Ajax Attributes GETs
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

if (isset($attribute_category_id) and $action == "switch_category") {


//***********************************************************************************
//get the attribute Category list
//***********************************************************************************

$sql_attribute_category = $mysqli->query("SELECT * FROM attribute_category WHERE attribute_category_id = $attribute_category_id") or die('Error: ' . mysqli_error($mysqli));

$attribute_category = $sql_attribute_category->fetch_array(MYSQLI_BOTH);

$smarty->assign("attribute_category_name", $attribute_category['attribute_category_name']);
$smarty->assign("attribute_category_id", $attribute_category['attribute_category_id']);

//***********************************************************************************
//get the attribute type list
//***********************************************************************************

$sql_attribute_type = $mysqli->query("SELECT * FROM attribute_type WHERE attribute_category_id = $attribute_category_id") or die('Error: ' . mysqli_error($mysqli));

while ($attribute_types = $sql_attribute_type->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('attribute_types', array(
        'attribute_type_id' => $attribute_types['attribute_type_id'],
        'attribute_type_name' => $attribute_types['attribute_type_name']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_attributes_return_switch_category.html");
}
