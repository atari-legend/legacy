<?php
/***************************************************************************
 *                                db_doc_type.php
 *                            -----------------------
 *   begin                : October 11, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : creation of file
 *
 ***************************************************************************/

// We are using the action var to separate all the queries.
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

//update the doc type
if (isset($doc_type_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE doc_type SET doc_type_name = '$doc_type_name' WHERE doc_type_id = $doc_type_id") or die("Couldn't Update the doc type");

    $_SESSION['edit_message'] = "Doc type succesfully updated";

    create_log_entry('Doc type', $doc_type_id, 'Doc type', $doc_type_id, 'Update', $_SESSION['user_id']);

    header("Location: ../docs/doc_type_edit.php?doc_type_id=$doc_type_id");
}

if (isset($doc_type_id) and isset($action) and $action == 'delete_doc_type') {
    // first see if this doc type is on a document
    $sql = $mysqli->query("SELECT * FROM doc
            LEFT JOIN doc_type ON (doc.doc_type_id = doc_type.doc_type_id)
            WHERE doc_type.doc_type_id = '$doc_type_id'") or die("error selecting doc");
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This doc type is linked to a document';
    } else {
        create_log_entry('Doc type', $doc_type_id, 'Doc type', $doc_type_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM doc_type WHERE doc_type_id = $doc_type_id") or die("Failed to delete doc type");

        $_SESSION['edit_message'] = "Doc type succesfully deleted";
    }
    header("Location: ../docs/doc_type.php");
}

if (isset($action) and $action == 'insert_type') {
    if ($type_name == '') {
        $_SESSION['edit_message'] = "Please fill in a doc type name";
        header("Location: ../docs/doc_type.php");
    } else {
        $sql_doctype = $mysqli->query("INSERT INTO doc_type (doc_type_name) VALUES ('$type_name')") or die("error inserting doc type");

        $new_doc_type_id = $mysqli->insert_id;

        create_log_entry('Doc type', $new_doc_type_id, 'Doc type', $new_doc_type_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "doc type succesfully inserted";
        header("Location: ../docs/doc_type.php");
    }
}
