<?php
/***************************************************************************
 *                               db_articles.php
 *                            --------------------------
 *   begin                : friday, October 8, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id:  db_articles.php,v 0.10 2016/10/08 20:14 ST Graveyard
 *         - AL 2.0
 *   id:  db_articles.php,v 0.11 2017/02/26 22:19 STG
 *         - fix sql warnings stonish server
 *
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if ($action == "stop") {
    echo "test";
    exit;
}

//****************************************************************************************
// This is the image selection/upload screen for the articles
//****************************************************************************************

//If we are uploading new screenshots
if (isset($action) and $action == 'add_screens') {
    //Here we'll be looping on each of the inputs on the page that are filled in with an image!
    $image = $_FILES['image'];

    foreach ($image['tmp_name'] as $key => $tmp_name) {
        if ($tmp_name !== 'none') {
            // Check what extention the file has and if it is allowed.

            $ext        = "";
            $type_image = $image['type'][$key];

            // set extension
            if ($type_image == 'image/png') {
                $ext = 'png';
            }

            if ($type_image == 'image/x-png') {
                $ext = 'png';
            } elseif ($type_image == 'image/gif') {
                $ext = 'gif';
            } elseif ($type_image == 'image/jpeg') {
                $ext = 'jpg';
            }

            if ($ext !== "") {
                // First we insert the directory path of where the file will be stored... this also creates an autoinc number for us.

                $sdbquery = $mysqli->query("INSERT INTO screenshot_main (screenshot_id,imgext) VALUES ('','$ext')") or die("Database error - inserting screenshots");

                //select the newly entered screenshot_id from the main table
                $SCREENSHOT = $mysqli->query("SELECT screenshot_id FROM screenshot_main
                       ORDER BY screenshot_id desc") or die("Database error - selecting screenshots");

                $screenshotrow = $SCREENSHOT->fetch_row();
                $screenshot_id = $screenshotrow[0];

                $sdbquery = $mysqli->query("INSERT INTO screenshot_article (article_id, screenshot_id) VALUES ($article_id, $screenshot_id)") or die("Database error - inserting screenshots2");

                // Rename the uploaded file to its autoincrement number and move it to its proper place.
                $file_data = rename($image['tmp_name'][$key], "$article_screenshot_save_path$screenshotrow[0].$ext");

                $_SESSION['edit_message'] = 'Screenshots added';

                create_log_entry('Articles', $article_id, 'Screenshots', $article_id, 'Insert', $_SESSION['user_id']);

                chmod("$article_screenshot_save_path$screenshotrow[0].$ext", 0777);
            }
        }
    }

    header("Location: ../articles/articles_screenshots_add.php?article_id=$article_id");
}

//If we pressed the delete screenshot link
if (isset($action) and $action == 'delete_screen') {
    $sql_articleshot = $mysqli->query("SELECT * FROM screenshot_article
                        WHERE article_id = $article_id
                    AND screenshot_id = $screenshot_id") or die("Database error - selecting screenshots article");

    $articleshot   = $sql_articleshot->fetch_row();
    $articleshotid = $articleshot[0];

    create_log_entry('Articles', $article_id, 'Screenshots', $article_id, 'Delete', $_SESSION['user_id']);

    //delete the screenshot comment from the DB table
    $sdbquery = $mysqli->query("DELETE FROM article_comments WHERE screenshot_article_id = $articleshotid") or die("Error deleting comment");

    //get the extension
    $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
                    WHERE screenshot_id = '$screenshot_id'") or die("Database error - selecting screenshots");

    $screenshotrow  = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
    $screenshot_ext = $screenshotrow['imgext'];

    $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
    $sql = $mysqli->query("DELETE FROM screenshot_article WHERE screenshot_id = '$screenshot_id' ");

    $new_path = $article_screenshot_save_path;
    $new_path .= $screenshot_id;
    $new_path .= ".";
    $new_path .= $screenshot_ext;

    unlink("$new_path");

    $_SESSION['edit_message'] = 'Screenshot (and comment) deleted succesfully';

    header("Location: ../articles/articles_screenshots_add.php?article_id=$article_id");
}

//*************************************************************************
// Delete the interview and return to the interview page
//*************************************************************************
if (isset($action) and $action == "delete_article") {
    create_log_entry('Articles', $article_id, 'Article', $article_id, 'Delete', $_SESSION['user_id']);

    $sql = $mysqli->query("DELETE FROM article_main WHERE article_id = '$article_id' ");
    $sql = $mysqli->query("DELETE FROM article_text WHERE article_id = '$article_id' ");

    //delete the comments at every screenshot for this review
    $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_article where article_id = '$article_id' ") or die("Database error - getting screenshots");

    while ($screenshotrow = $SCREENSHOT->fetch_row()) {
        $sql = $mysqli->query("DELETE FROM article_comments WHERE screenshot_article_id = $screenshotrow[0] ");
    }

    //delete the screenshots
    $SCREENSHOT2 = $mysqli->query("SELECT * FROM screenshot_article where article_id = '$article_id' ") or die("Database error - getting screenshots");

    while ($screenshotrow = $SCREENSHOT2->fetch_row()) {
        //get the extension
        $SCREENSHOT_ext = $mysqli->query("SELECT * FROM screenshot_main
                       WHERE screenshot_id = $screenshotrow[2]") or die("Database error - selecting screenshots");

        $screenshotrow_ext   = $SCREENSHOT_ext->fetch_array(MYSQLI_BOTH);
        $screenshot_ext_type = $screenshotrow_ext['imgext'];

        $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = $screenshotrow[2] ");

        $new_path = $article_screenshot_save_path;
        $new_path .= $screenshotrow[2];
        $new_path .= ".";
        $new_path .= $screenshot_ext_type;

        unlink("$new_path");
    }

    $sql = $mysqli->query("DELETE FROM screenshot_article WHERE article_id = '$article_id' ");

    $_SESSION['edit_message'] = 'article deleted';

    header("Location: ../articles/articles_main.php");
}

//*************************************************************************
// Delete the interview screenshots and comments and return to the interview page
//*************************************************************************

//If the delete comment has been triggered
if (isset($action) and $action == 'delete_screenshot_comment') {
    $sql_articleshot = $mysqli->query("SELECT * FROM screenshot_article
                          WHERE article_id = $article_id
                    AND screenshot_id = $screenshot_id") or die("Database error - selecting screenshots article");

    $articleshot   = $sql_articleshot->fetch_row();
    $articleshotid = $articleshot[0];

    create_log_entry('Articles', $article_id, 'Screenshots', $article_id, 'Delete', $_SESSION['user_id']);

    //delete the screenshot comment from the DB table
    $sdbquery = $mysqli->query("DELETE FROM article_comments WHERE screenshot_article_id = $articleshotid") or die("Error deleting comment");

    //get the extension
    $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
                    WHERE screenshot_id = '$screenshot_id'") or die("Database error - selecting screenshots");

    $screenshotrow  = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
    $screenshot_ext = $screenshotrow['imgext'];

    $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
    $sql = $mysqli->query("DELETE FROM screenshot_article WHERE screenshot_id = '$screenshot_id' ");

    $new_path = $article_screenshot_save_path;
    $new_path .= $screenshot_id;
    $new_path .= ".";
    $new_path .= $screenshot_ext;

    unlink("$new_path");

    $_SESSION['edit_message'] = 'Screenshot and comment deleted succesfully';

    header("Location: ../articles/articles_edit.php?article_id=$article_id");
}

//*************************************************************************
// UPDATE ARTICLE AND RETURN TO THE INTERVIEW EDIT PAGE
//*************************************************************************

//If the Update article has been triggered
if (isset($action) and $action == 'update_article') {
    //First, we'll be filling up the main article table
    $sdbquery = $mysqli->query("UPDATE article_main SET user_id = $members, article_type_id = $article_type
               WHERE article_id = $article_id") or die("Couldn't Update into article_main");

    // first we have to convert the date vars into a time stamp to be inserted to article_date
    $date = date_to_timestamp($Date_Year, $Date_Month, $Date_Day);

    $textfield = $mysqli->real_escape_string($textfield);
    $textintro = $mysqli->real_escape_string($textintro);

    $sdbquery = $mysqli->query("UPDATE article_text SET article_text = '$textfield', article_date = '$date', article_intro = '$textintro', article_title = '$article_title' WHERE article_id = $article_id") or die("Couldn't update into article_text");

    //we're gonna add the screenhots into the screenshot_article table and fill up the article_comment table.
    //We need to loop on the screenshot table to check the shots used. If a comment field is filled,
    //the screenshot was used!
    $SCREEN = $mysqli->query("SELECT * FROM screenshot_article where article_id = '$article_id' ORDER BY screenshot_id ASC") or die("Database error - getting screenshots");

    $i = 0;
    while ($screenrow = $SCREEN->fetch_row()) {
        if ($inputfield[$i] != "") {
            //fill the comments table
            $screenid = $screenrow[0];
            $comment  = $inputfield[$i];
            $comment  = $mysqli->real_escape_string($comment);

            $articleshotid = $screenrow[0];

            //check if comment already exists for this shot
            $articleCOMMENT = $mysqli->query("SELECT * FROM article_comments where screenshot_article_id = $articleshotid") or die("Database error - selecting screenshot article comment");

            $number = $articleCOMMENT->num_rows;

            if ($number > 0) {
                $sdbquery = $mysqli->query("UPDATE article_comments SET comment_text = '$comment'
                     WHERE screenshot_article_id = $articleshotid") or die("Couldn't update article_comments");
            } else {
                $sdbquery = $mysqli->query("INSERT INTO article_comments (screenshot_article_id, comment_text) VALUES ($articleshotid, '$comment')") or die("Couldn't insert into article_comments");
            }
        }
        $i++;
    }

    create_log_entry('Articles', $article_id, 'Article', $article_id, 'Update', $_SESSION['user_id']);

    $_SESSION['edit_message'] = 'Article updated succesfully';

    header("Location: ../articles/articles_edit.php?article_id=$article_id");
} elseif (isset($action) and $action == 'add_article') {
    //****************************************************************************************
    //This is what happens when we press the create interview button in the interview creation
    //page
    //****************************************************************************************

    if ($members == '' or $members == '-' or $article_type == '' or $article_type == "-") {
        $_SESSION['edit_message'] = 'Some required info is not filled in. Make sure the -author- and -article_type- fields are completed';

        //Get the article types
        $sql_types = $mysqli->query("SELECT article_type_id,article_type FROM article_type") or die("Database error - getting the article types");

        while ($article_types = $sql_types->fetch_array(MYSQLI_BOTH)) {
            //Get the selected article types
            if ($article_types['article_type_id'] == $article_type) {
                $smarty->assign('selected_article_type', array(
                    'article_type_id' => $article_types['$article_type_id'],
                    'article_type' => $article_types['$article_type']
                ));
            } else {
                $smarty->append('article_types', array(
                    'article_type_id' => $article_types['article_type_id'],
                    'article_type' => $article_types['article_type']
                ));
            }
        }

        //Get the authors for the interview
        $sql_author = $mysqli->query("SELECT user_id,userid FROM users") or die("Database error - getting members name");

        while ($authors = $sql_author->fetch_array(MYSQLI_BOTH)) {
            $smarty->append('authors', array(
                'user_id' => $authors['user_id'],
                'user_name' => $authors['userid']
            ));
        }

        $smarty->assign("user_id", $_SESSION['user_id']);
        $smarty->assign("article_title", $article_title);

        //Send all smarty variables to the templates
        $smarty->display("file:" . $cpanel_template_folder . "articles_add.html");
    } else {
        $sdbquery = $mysqli->query("INSERT INTO article_main (user_id, article_type_id) VALUES ($members, $article_type)") or die("Couldn't insert into article_main");

        //get the id of the inserted interview
        $id = $mysqli->insert_id;

        // first we have to convert the date vars into a time stamp to be inserted to review_date
        $date = date_to_timestamp($Date_Year, $Date_Month, $Date_Day);

        $textfield = $mysqli->real_escape_string($textfield);
        $textintro = $mysqli->real_escape_string($textintro);

        $sdbquery = $mysqli->query("INSERT INTO article_text (article_id, article_text, article_date, article_intro, article_title) VALUES ($id, '$textfield', '$date', '$textintro', '$article_title')") or die("Couldn't insert into article_text");

        create_log_entry('Articles', $id, 'Article', $id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = 'Article added succesfully';

        $smarty->assign("user_id", $_SESSION['user_id']);

        //Send all smarty variables to the templates
        header("Location: ../articles/articles_edit.php?article_id=$id");
    }
}
