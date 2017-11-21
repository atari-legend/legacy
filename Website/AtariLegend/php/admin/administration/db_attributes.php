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

// Change name of category name
if (isset($attribute_category_id) and $action == "change_attribute_category_name") {

$mysqli->query("UPDATE attribute_category SET attribute_category_name = '$attribute_category_name' WHERE attribute_category_id = $attribute_category_id")
or die('Error: ' . mysqli_error($mysqli));

echo "Category name updated!";
}

// Insert New Attribute Category
if (isset($attribute_category_name) and $action == "add_new_attribute_category") {

    $mysqli->query("INSERT INTO attribute_category (attribute_category_name) VALUES ('$attribute_category_name')")
    or die('Error: ' . mysqli_error($mysqli));

$attribute_category_id = $mysqli->insert_id;

echo "New Attribute Category Added![BRK]$attribute_category_id";

}

// Insert new attribute type
if (isset($attribute_type_name) and $action == "add_new_attribute_type") {

    $mysqli->query("INSERT INTO attribute_type (attribute_type_name,attribute_category_id) VALUES ('$attribute_type_name','1')")
    or die('Error: ' . mysqli_error($mysqli));

    echo "New attribute type added!";
}

// Delete attribute Category
if (isset($attribute_category_id) and $action == "delete_attribute_category") {

if ($attribute_category_id!==1) {
    $mysqli->query("DELETE FROM attribute_category WHERE attribute_category_id = '$attribute_category_id'")
    or die('Error: ' . mysqli_error($mysqli));

    echo "Attribute Category Deleted!";
}
}
// Change name of attribute type name
if (isset($attribute_type_id) and $action == "change_attribute_type_name") {

$mysqli->query("UPDATE attribute_type SET attribute_type_name = '$attribute_type_name' WHERE attribute_type_id = $attribute_type_id")
or die('Error: ' . mysqli_error($mysqli));

echo "Attribute name updated!";
}
