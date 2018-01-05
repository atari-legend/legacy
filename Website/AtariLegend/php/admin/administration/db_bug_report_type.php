<?php
/***************************************************************************
 *                                db_bug_report_type.php
 *                            ------------------------------
 *   begin                : September 11, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : creation of file
 *
 ***************************************************************************/

// We are using the action var to separate all the queries.
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

//update the download options
if (isset($type_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE bug_report_type SET bug_report_type = '$type_name' WHERE bug_report_type_id = $type_id") or die("Couldn't Update the bug report type table");

    $_SESSION['edit_message'] = "Type succesfully updated";

    create_log_entry('Bug type', $type_id, 'Bug type', $type_id, 'Update', $_SESSION['user_id']);

    header("Location: ../administration/bug_report_type_edit.php?type_id=$type_id");
}

if (isset($type_id) and isset($action) and $action == 'delete_type') {
    // first see if this option is used for a download
    $sql = $mysqli->query("SELECT * FROM bug_report
            WHERE bug_report_type_id = '$type_id'") or die("error selecting types");
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This type is still used for certain bug reports';
    } else {
        create_log_entry('Bug type', $type_id, 'Bug type', $type_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM bug_report_type WHERE bug_report_type_id = $type_id") or die("Failed to delete type");

        $_SESSION['edit_message'] = "Type succesfully deleted";
    }
    header("Location: ../administration/bug_report_type.php");
}

if (isset($action) and $action == 'insert_type') {
    if ($type_name == '') {
        $_SESSION['edit_message'] = "Please fill in a type name";
        header("Location: ../administration/bug_report_type.php");
    } else {
        $sdbquery = $mysqli->query("INSERT INTO bug_report_type (bug_report_type) VALUES ('$type_name')") or die("error inserting type");

        $new_type_id = $mysqli->insert_id;

        create_log_entry('Bug type', $new_type_id, 'Bug type', $new_type_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Bug report type succesfully inserted";
        header("Location: ../administration/bug_report_type.php");
    }
}
