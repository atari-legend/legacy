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

//****************************************************************************************
// This is the image selection/upload screen for the articles
//****************************************************************************************

//If we are uploading new screenshots
if (isset($action2) and $action2 == 'add_screens') {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
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
                    // First we insert the directory path of where the file will be stored...
                    // this also creates an autoinc number for us.

                    $sdbquery = $mysqli->query("INSERT INTO screenshot_main (imgext) VALUES ('$ext')")
                        or die('Error: ' . mysqli_error($mysqli));

                    //select the newly entered screenshot_id from the main table
                    $screenshot_id = $mysqli->insert_id;

                    $sdbquery = $mysqli->query("INSERT INTO screenshot_article (article_id, screenshot_id)
                        VALUES ($article_id, $screenshot_id)") or die("Database error - inserting screenshots2");

                    // Rename the uploaded file to its autoincrement number and move it to its proper place.
                    $file_data = rename($image['tmp_name'][$key], "$article_screenshot_save_path$screenshot_id.$ext");

                    $osd_message = 'Screenshots added';

                    create_log_entry(
                        'Articles',
                        $article_id,
                        'Screenshots',
                        $article_id,
                        'Insert',
                        $_SESSION['user_id']
                    );

                    chmod("$article_screenshot_save_path$screenshot_id.$ext", 0777);
                }
            }
        }
    } else {
        $osd_message = "You do not have the necessary authorizations to perform this action";
    }

    if (isset($osd_message)) {
    } else {
        $osd_message = "No screenshot uploaded";
    }

    //Let's get the screenshots for the article
    $sql_screenshots = $mysqli->query("SELECT * FROM screenshot_article
        LEFT JOIN screenshot_main on ( screenshot_article.screenshot_id = screenshot_main.screenshot_id )
        WHERE screenshot_article.article_id = '$article_id' ORDER BY screenshot_article.screenshot_id ASC")
        or die("Database error - getting screenshots & comments");

    //get the number of screenshots in the archive
    $v_screeshots = $sql_screenshots->num_rows;
    $smarty->assign("screenshots_nr", $v_screeshots);

    $count = 1;

    while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
        $v_int_image = $article_screenshot_path;
        $v_int_image .= $screenshots['screenshot_id'];
        $v_int_image .= '.';
        $v_int_image .= $screenshots['imgext'];

        //We need to get the comments with each screenshot
        $sql_comments = $mysqli->query("SELECT * FROM article_comments
            WHERE screenshot_article_id  = $screenshots[screenshot_article_id]")
            or die("Database error - getting screenshots comments");

        $comments = $sql_comments->fetch_array(MYSQLI_BOTH);

        $smarty->append('screenshots', array(
            'article_screenshot' => $v_int_image,
            'article_screenshot_id' => $screenshots['screenshot_id'],
            'article_screenshot_count' => $count,
            'article_screenshot_comment' => $comments['comment_text']
        ));

        $count = $count + 1;
    }

    $smarty->assign('osd_message', $osd_message);

    $smarty->assign('smarty_action', 'add_screen_to_article_return');
    $smarty->assign('article_id', $article_id);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "articles/ajax_article_add_screenshots.html");
}

//*************************************************************************
// Delete the interview and return to the interview page
//*************************************************************************
if (isset($action) and $action == "delete_article") {
    include("../../config/admin_rights.php");
    create_log_entry('Articles', $article_id, 'Article', $article_id, 'Delete', $_SESSION['user_id']);

    $sql = $mysqli->query("DELETE FROM article_main WHERE article_id = '$article_id' ");
    $sql = $mysqli->query("DELETE FROM article_text WHERE article_id = '$article_id' ");

    //delete the comments at every screenshot for this review
    $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_article where article_id = '$article_id' ")
        or die("Database error - getting screenshots");

    while ($screenshotrow = $SCREENSHOT->fetch_row()) {
        $sql = $mysqli->query("DELETE FROM article_comments WHERE screenshot_article_id = $screenshotrow[0] ");
    }

    //delete the screenshots
    $SCREENSHOT2 = $mysqli->query("SELECT * FROM screenshot_article where article_id = '$article_id' ")
        or die("Database error - getting screenshots");

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
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        $sql_articleshot = $mysqli->query("SELECT * FROM screenshot_article
                              WHERE article_id = $article_id
                        AND screenshot_id = $screenshot_id") or die("Database error - selecting screenshots article");

        $articleshot   = $sql_articleshot->fetch_row();
        $articleshotid = $articleshot[0];

        create_log_entry('Articles', $article_id, 'Screenshots', $article_id, 'Delete', $_SESSION['user_id']);

        //delete the screenshot comment from the DB table
        $sdbquery = $mysqli->query("DELETE FROM article_comments WHERE screenshot_article_id = $articleshotid")
            or die("Error deleting comment");

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

        $osd_message = "Screenshot and comment deleted successfully";
    } else {
        $osd_message = "You do not have the necessary authorizations to perform this action";
    }

    if (isset($osd_message)) {
    } else {
        $osd_message = "No screenshot uploaded";
    }

    //Let's get the screenshots for the article
    $sql_screenshots = $mysqli->query("SELECT * FROM screenshot_article
        LEFT JOIN screenshot_main on ( screenshot_article.screenshot_id = screenshot_main.screenshot_id )
        WHERE screenshot_article.article_id = '$article_id' ORDER BY screenshot_article.screenshot_id ASC")
        or die("Database error - getting screenshots & comments");

    //get the number of screenshots in the archive
    $v_screeshots = $sql_screenshots->num_rows;
    $smarty->assign("screenshots_nr", $v_screeshots);

    $count = 1;

    while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
        $v_int_image = $article_screenshot_path;
        $v_int_image .= $screenshots['screenshot_id'];
        $v_int_image .= '.';
        $v_int_image .= $screenshots['imgext'];

        //We need to get the comments with each screenshot
        $sql_comments = $mysqli->query("SELECT * FROM article_comments
            WHERE screenshot_article_id  = $screenshots[screenshot_article_id]")
            or die("Database error - getting screenshots comments");

        $comments = $sql_comments->fetch_array(MYSQLI_BOTH);

        $smarty->append('screenshots', array(
            'article_screenshot' => $v_int_image,
            'article_screenshot_id' => $screenshots['screenshot_id'],
            'article_screenshot_count' => $count,
            'article_screenshot_comment' => $comments['comment_text']
        ));

        $count = $count + 1;
    }

    $smarty->assign('osd_message', $osd_message);

    $smarty->assign('smarty_action', 'add_screen_to_article_return');
    $smarty->assign('article_id', $article_id);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "articles/ajax_article_add_screenshots.html");
}

//*************************************************************************
// UPDATE ARTICLE AND RETURN TO THE INTERVIEW EDIT PAGE
//*************************************************************************

//If the Update article has been triggered
if (isset($action) and $action == 'update_article' and (!isset($action2))) {
    include("../../config/admin_rights.php");
    //First, we'll be filling up the main article table
    $sdbquery = $mysqli->query("UPDATE article_main SET user_id = $members, article_type_id = $article_type
               WHERE article_id = $article_id") or die("Couldn't Update into article_main");

    // first we have to convert the date vars into a time stamp to be inserted to article_date
    $date = date_to_timestamp($Date_Year, $Date_Month, $Date_Day);

    $textfield = $mysqli->real_escape_string($textfield);
    $textintro = $mysqli->real_escape_string($textintro);

    $sdbquery = $mysqli->query("UPDATE article_text SET article_text = '$textfield', article_date = '$date',
        article_intro = '$textintro', article_title = '$article_title' WHERE article_id = $article_id")
        or die("Couldn't update into article_text");

    //we're gonna add the screenhots into the screenshot_article table and fill up the article_comment table.
    //We need to loop on the screenshot table to check the shots used. If a comment field is filled,
    //the screenshot was used!
    $SCREEN = $mysqli->query("SELECT * FROM screenshot_article where article_id = '$article_id'
        ORDER BY screenshot_id ASC") or die("Database error - getting screenshots");

    $i = 0;
    while ($screenrow = $SCREEN->fetch_row()) {
        if ($inputfield[$i] != "") {
            //fill the comments table
            $screenid = $screenrow[0];
            $comment  = $inputfield[$i];
            $comment  = $mysqli->real_escape_string($comment);

            $articleshotid = $screenrow[0];

            //check if comment already exists for this shot
            $articleCOMMENT = $mysqli->query("SELECT * FROM article_comments
                where screenshot_article_id = $articleshotid")
                or die("Database error - selecting screenshot article comment");

            $number = $articleCOMMENT->num_rows;

            if ($number > 0) {
                $sdbquery = $mysqli->query("UPDATE article_comments SET comment_text = '$comment'
                     WHERE screenshot_article_id = $articleshotid") or die("Couldn't update article_comments");
            } else {
                $sdbquery = $mysqli->query("INSERT INTO article_comments (screenshot_article_id, comment_text)
                    VALUES ($articleshotid, '$comment')") or die("Couldn't insert into article_comments");
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

    if ($article_title == " ") {
        $_SESSION['edit_message'] = 'Some required info is not filled in. Make sure the article title field is filled';

        header("Location: ../articles/articles_main.php");
    } else {
        include("../../config/admin_rights.php");

        $sdbquery = $mysqli->query("INSERT INTO article_main (user_id) VALUES ($user_id)")
            or die("Couldn't insert into article_main");

        //get the id of the inserted interview
        $id = $mysqli->insert_id;

        //insert the date of today
        $date = date_to_timestamp(date("Y"), date("m"), date("d"));

        $sdbquery = $mysqli->query("INSERT INTO article_text (article_id, article_date, article_title)
            VALUES ($id, '$date', '$article_title')") or die("Couldn't insert into article_text");

        create_log_entry('Articles', $id, 'Article', $id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = 'Article added succesfully';

        $smarty->assign("user_id", $_SESSION['user_id']);

        //Send all smarty variables to the templates
        header("Location: ../articles/articles_edit.php?article_id=$id");
    }
}
