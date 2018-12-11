<?php
/***************************************************************************
 *                                doc_category_edit.php
 *                            --------------------------
 *   begin                : October 14, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : admin@atarilegend.com
 *                           Created file
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

/*
 ************************************************************************************************
 This is the doc_category search list page
 ************************************************************************************************
 */
//Check if we seclected a doc category
if ($doc_category_id == '-' or $doc_category_id == ' ') {
    $_SESSION['edit_message'] = "Please select a doc_category";
    header("Location: ../docs/doc_category.php");
} else {
    //get all the doc types for dropdown
    $result_doc_category = $mysqli->query("SELECT * FROM doc_category");

    $rows = $result_doc_category->num_rows;
    while ($row = $result_doc_category->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('doc_category', array(
            'doc_category_id' => $row['doc_category_id'],
            'doc_category_name' => $row['doc_category_name']
        ));
    }
    $smarty->assign("user_id", $_SESSION['user_id']);

    $result_doc_category_edit = $mysqli->query("SELECT * FROM doc_category WHERE doc_category_id = $doc_category_id")
        or die("error getting doc category");

    while ($row = $result_doc_category_edit->fetch_array(MYSQLI_BOTH)) {
        $smarty->assign('doc_category_edit', array(
            'doc_category_id_edit' => $row['doc_category_id'],
            'doc_category_name_edit' => $row['doc_category_name']
        ));
    }

    //Send all smarty variables to the templates
    $smarty->display("file:" . $cpanel_template_folder . "doc_category_edit.html");
}

//close the connection
mysqli_free_result($result_doc_category);
