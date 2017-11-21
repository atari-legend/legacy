<?php
/***************************************************************************
 *                                ajax_attributes_editor.php
 *                            ------------------------
 *   begin                : 2017-11-18
 *   copyright            : (C) 2017 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation of file

 *
 ***************************************************************************/

//****************************************************************************************
// Ajax Attribute Editor
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");



//
// OPEN ATTRIBUTES EDITOR
//
if (isset($attribute_type_id) and $action == "open_attributes_editor") {

//***********************************************************************************
//get the attribute type info
//***********************************************************************************

$sql_attribute_type = $mysqli->query("SELECT * FROM attribute_type WHERE attribute_type_id = $attribute_type_id")
    or die('Error: ' . mysqli_error($mysqli));

$attribute_type = $sql_attribute_type->fetch_array(MYSQLI_BOTH);

$smarty->assign("action", "open_attributes_editor");
$smarty->assign("attribute_type_name", $attribute_type['attribute_type_name']);
$smarty->assign("attribute_type_id", $attribute_type['attribute_type_id']);
/*
//***********************************************************************************
//get the attribute type list
//***********************************************************************************

$sql_attribute_type = $mysqli->query("SELECT * FROM attribute_type WHERE attribute_category_id = $attribute_category_id") or die('Error: ' . mysqli_error($mysqli));

while ($attribute_types = $sql_attribute_type->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('attribute_types', array(
        'attribute_type_id' => $attribute_types['attribute_type_id'],
        'attribute_type_name' => $attribute_types['attribute_type_name']
    ));
} */

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_attributes_editor.html");
}

//
// CLOSE ATTRIBUTES EDITOR
//

if ($action == "close_attributes_editor") {

$smarty->assign("action", "close_attributes_editor");
//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_attributes_editor.html");
}
