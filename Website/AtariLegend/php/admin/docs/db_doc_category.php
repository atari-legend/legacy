<?php
/***************************************************************************
 *                                db_doc_category.php
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

//update the doc category
if (isset($doc_category_id) and isset($action) and $action == 'update') {
    $sdbquery = $mysqli->query("UPDATE doc_category SET doc_category_name = '$doc_category_name' WHERE doc_category_id = $doc_category_id") or die("Couldn't Update the doc category");

    $_SESSION['edit_message'] = "Doc category succesfully updated";

    create_log_entry('Doc category', $doc_category_id, 'Doc category', $doc_category_id, 'Update', $_SESSION['user_id']);

    header("Location: ../docs/doc_category_edit.php?doc_category_id=$doc_category_id");
}

if (isset($doc_category_id) and isset($action) and $action == 'delete_doc_category') {
    // first see if this doc category is on a document
    $sql = $mysqli->query("SELECT * FROM doc
            LEFT JOIN doc_category ON (doc.doc_category_id = doc_category.doc_category_id)
            WHERE doc_category.doc_category_id = '$doc_category_id'") or die("error selecting doc");
    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This doc type is linked to a document';
    } else {
        create_log_entry('Doc category', $doc_category_id, 'Doc category', $doc_category_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("DELETE FROM doc_category WHERE doc_category_id = $doc_category_id") or die("Failed to delete doc category");

        $_SESSION['edit_message'] = "Doc category succesfully deleted";
    }
    header("Location: ../docs/doc_category.php");
}

if (isset($action) and $action == 'insert_category') {
    if ($category_name == '') {
        $_SESSION['edit_message'] = "Please fill in a doc category name";
        header("Location: ../docs/doc_category.php");
    } else {
        $sql_doccategory = $mysqli->query("INSERT INTO doc_category (doc_category_name) VALUES ('$category_name')") or die("error inserting doc category");

        $new_doc_category_id = $mysqli->insert_id;

        create_log_entry('Doc category', $new_doc_category_id, 'Doc category', $new_doc_category_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Doc category succesfully inserted";
        header("Location: ../docs/doc_category.php");
    }
}
