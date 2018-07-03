<?php
/***************************************************************************
 *                                db_news.php
 *                            -----------------------
 *   begin                : Sunday, may 1 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : creation of file
 *
 * Id:  db_news.php,v 0.10 2016/07/29 ST Graveyard
 *     - AL 2.0 adding messages + bug fixes
 * Id:  db_news.php,v 0.11 2016/08/20 ST Graveyard
 *     - Added change log
 * Id:  db_news.php,v 0.12 2017/08/25 ST Graveyard
 *     - possibility to remove news icon from news article
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 In this section we can add a news update to the DB
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/NewsDAO.php";

//****************************************************************************************
// This is where we delete news posts
//****************************************************************************************
if (isset($action) and $action == "delete_news") {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        create_log_entry('News', $news_id, 'News item', $news_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("delete from
               news
             WHERE news_id='$news_id'") or die("Deletion of the news post failed!");

        $osd_message = "News post deleted";
    } else {
        $osd_message = "You don't have permission to perform this task";
    }

    echo $osd_message;
    mysqli_close($mysqli);
}

//****************************************************************************************
// This is where we add the actual news to the submission table
//****************************************************************************************
if (isset($action) and $action == "add_news") {
    include("../../config/admin_rights.php");

    // we have to convert the date vars into a time stamp to be inserted into the db
    $news_date = date_to_timestamp($Date_Year, $Date_Month, $Date_Day);

   // Check if form is filled.
    if ($headline == '' or $descr == '') {
        $_SESSION['edit_message'] = "Please fill in the necessary fields";
    } else {
        $descr = $mysqli->real_escape_string($descr);
        $headline = $mysqli->real_escape_string($headline);

        // Insert the description and the image into the news_image table.
        $sdbquery = $mysqli->query("INSERT INTO news_submission
              (news_headline,news_text,news_image_id,user_id,news_date)
               VALUES ('$headline','$descr','$icon','$members','$news_date')") or die("Error inserting news update");

        $_SESSION['edit_message'] = "News added correctly";

        $new_news_id = $mysqli->insert_id;

        create_log_entry('News', $new_news_id, 'News submit', $new_news_id, 'Insert', $_SESSION['user_id']);

        mysqli_close($mysqli);
    }

    header("Location: ../news/news_approve.php");
}

//****************************************************************************************
// This is where we will update a submission.
//****************************************************************************************
if (isset($action) and $action == "save_news_text") {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        if (isset($news_id)) {
            create_log_entry('News', $news_id, 'News submit', $news_id, 'Update', $_SESSION['user_id']);

            // we have to convert the date vars into a time stamp to be inserted into the db
            $date = date_to_timestamp($news_year, $news_month, $news_day);

            $stmt = $mysqli->prepare("UPDATE news_submission SET news_text = ?,
                                 news_headline = ?,
                                 user_id = ?,
                                 news_image_id = ?,
                                 news_date = ?
                                 WHERE news_submission_id = ?") or die($mysqli->error);
            $stmt->bind_param("ssiiis", $news_text, $news_headline, $news_userid, $news_image_id, $date, $news_id)
                or die($mysqli->error);
            $stmt->execute() or die($mysqli->error);
            $stmt->close();

            $osd = "News submission updated!";
        }
    } else {
        $osd = "You don't have permission to perform this task";
    }

    $smarty->assign('action', 'save_news_text');
    $smarty->assign('osd_message', $osd);

    require_once __DIR__."/../../lib/Db.php";
    require_once __DIR__."/../../common/DAO/NewsSubmissionDAO.php";

    $newsSubmissionDAO = new AL\Common\DAO\NewsSubmissionDAO($mysqli);

    $smarty->assign(
        'news_submissions',
        $newsSubmissionDAO->getAllSubmissions(isset($user_id) ? $user_id : null)
    );

    $smarty->assign("nr_submissions", $newsSubmissionDAO->getSubmissionCount());

    $smarty->assign("user_id", $_SESSION['user_id']);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_news_approve_edit.html");
}

//****************************************************************************************
// This is where we will approve the news. Deleting it from the submission table and adding
// it to the news page
//****************************************************************************************
if (isset($action) and $action == "approve_submission") {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        include("../../lib/functions_search.php");
        $sql_submission = "SELECT
                news_headline,
                news_text,
                news_image_id,
                user_id,
                news_date
                FROM news_submission WHERE news_submission_id = '$news_submission_id'";

        $query_submission = $mysqli->query($sql_submission) or die("Couldn't find the submitted news!");

        list($news_headline, $news_text, $news_image_id, $user_id, $news_date)
            = $query_submission->fetch_array(MYSQLI_BOTH);

        $news_headline = $mysqli->real_escape_string($news_headline);
        $news_text     = $mysqli->real_escape_string($news_text);

        // Insert the news story.
        $mysqli->query("INSERT INTO news (news_headline,news_text,news_image_id,user_id,news_date)"
            ." VALUES ('$news_headline','$news_text','$news_image_id','$user_id','$news_date')")
            or die("DOES NOT COMPUTE...DOES NOT COMPUTE...DOES NOT COMPUTE");

        $mysqli->query("DELETE FROM news_submission WHERE news_submission_id='$news_submission_id'")
            or die("Couldn't kill news_submission!!!");

        $NEWS = $mysqli->query("SELECT news_id FROM news ORDER BY news_id desc")
            or die("Database error - selecting news_id");

        $newsid = $NEWS->fetch_row();

        $mode = "post";

        add_search_words($mode, $newsid[0], $news_text, $news_headline);

        create_log_entry('News', $newsid[0], 'News item', $newsid[0], 'Insert', $_SESSION['user_id']);

        $osd_message = "Submission approved";
    } else {
        $osd_message = "You don't have permission to perform this task";
    }

    $smarty->assign('action', 'approve_submission');
    $smarty->assign('osd_message', $osd_message);

    // Get all the needed data to load the submission page!
    require_once __DIR__."/../../lib/Db.php";
    require_once __DIR__."/../../common/DAO/NewsSubmissionDAO.php";
    $NewsSubmissionDAO = new AL\Common\DAO\NewsSubmissionDAO($mysqli);

    $smarty->assign(
        'news_submissions',
        $NewsSubmissionDAO->getAllSubmissions(isset($user_id) ? $user_id : null)
    );

    $smarty->assign("nr_submissions", $NewsSubmissionDAO->getSubmissionCount());

    $smarty->assign("user_id", $_SESSION['user_id']);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_news_approve_edit.html");
}

//********************************************************************************************
// This is where we will delete unapproved news. It will be deleted from the submission table
//********************************************************************************************
if (isset($action) and $action == "delete_submission") {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        create_log_entry('News', $news_id, 'News submit', $news_id, 'Delete', $_SESSION['user_id']);

        $mysqli->query("delete from
               news_submission
             WHERE news_submission_id='$news_id'") or die("Deletion of the unapproved news update failed!");

        $osd_message = "Submission deleted";
    } else {
        $osd_message = "You don't have permission to perform this task";
    }

    $smarty->assign('action', 'delete_submission');
    $smarty->assign('osd_message', $osd_message);

    // Get all the needed data to load the submission page!
    require_once __DIR__."/../../lib/Db.php";
    require_once __DIR__."/../../common/DAO/NewsSubmissionDAO.php";
    $NewsSubmissionDAO = new AL\Common\DAO\NewsSubmissionDAO($mysqli);

    $smarty->assign(
        'news_submissions',
        $NewsSubmissionDAO->getAllSubmissions(isset($user_id) ? $user_id : null)
    );

    $smarty->assign("nr_submissions", $NewsSubmissionDAO->getSubmissionCount());

    $smarty->assign("user_id", $_SESSION['user_id']);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_news_approve_edit.html");
}

//****************************************************************************************
// This is where we will update a news post.
//****************************************************************************************e
if (isset($action) and $action == "save_news_post_text") {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        if (isset($news_id)) {
            create_log_entry('News', $news_id, 'News item', $news_id, 'Update', $_SESSION['user_id']);

            // we have to convert the date vars into a time stamp to be inserted into the db
            $date = date_to_timestamp($news_year, $news_month, $news_day);

            $stmt = $mysqli->prepare("UPDATE news SET news_text = ?,
                                 news_headline = ?,
                                 user_id = ?,
                                 news_image_id = ?,
                                 news_date = ?
                                 WHERE news_id = ?") or die($mysqli->error);
            $stmt->bind_param("ssiiis", $news_text, $news_headline, $news_userid, $news_image_id, $date, $news_id)
                or die($mysqli->error);
            $stmt->execute() or die($mysqli->error);
            $stmt->close();

            $osd = "News post updated!";
        }
    } else {
        $osd = "You don't have permission to perform this task";
    }

    $smarty->assign('action', 'save_news_text');
    $smarty->assign('osd_message', $osd);

    $newsDAO = new AL\Common\DAO\NewsDAO($mysqli);

    $smarty->assign(
        'article',
        $newsDAO->getNews($news_id)
    );

    $smarty->assign("user_id", $_SESSION['user_id']);

    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_news_post_edit.html");
}

if (isset($action) and $action == "image_upload") {
    include("../../config/admin_rights.php");
    //****************************************************************************************
    // This is where we handle the uploaded images and rename them and save them to db and hd
    //****************************************************************************************
    $news_image = $_FILES['news_image'];

    if (isset($news_image)) {
        $_SESSION['edit_message'] = "You forgot to add an image comment!";

        $file_ext = $_FILES['news_image']['type'];

        if ($file_ext == 'image/jpeg') {
            $ext = 'jpg';
        } elseif ($file_ext == 'image/gif') {
            $ext = 'gif';
        } elseif ($file_ext == 'image/x-png') {
            $ext = 'png';
        } elseif ($file_ext == 'image/png') {
            $ext = 'png';
        }

        if (isset($ext)) {
            if ($image_name == '') {
                $_SESSION['edit_message'] = "You forgot to add an image name!";
            } else {
                $file_name     = $_FILES['news_image']['name'];
                $file_name_tmp = $_FILES['news_image']['tmp_name'];
                // Debug
                //echo "$file_name";
                //print_r($news_image);
                //exit;

                // Insert the description and the image into the news_image table.
                $sdbquery = $mysqli->query("INSERT INTO news_image (news_image_name,news_image_ext)"
                    ." VALUES ('$image_name','$ext')") or die("Couldn't insert image!");

                //select the newly created news_image_id from the news_image table
                $NEWS = $mysqli->query("SELECT news_image_id FROM news_image
                     ORDER BY news_image_id desc") or die("Database error - selecting news_image_id");

                $newsimagerow = $NEWS->fetch_row();

                // Rename the uploaded file to its autoincrement number and move it to its proper place.
                $file_data = rename("$file_name_tmp", "$news_images_save_path$newsimagerow[0].$ext");

                $_SESSION['edit_message'] = "News image uploaded";

                create_log_entry('News', $newsimagerow[0], 'Image', $newsimagerow[0], 'Insert', $_SESSION['user_id']);

                chmod("$news_images_save_path$newsimagerow[0].$ext", 0777);
            }
        } else {
            $_SESSION['edit_message'] = "Filetype not supported";
        }

        mysqli_close($mysqli);
    }
    header("Location: ../news/news_add_images.php");
}

//****************************************************************************************
// This is where we delete a news image
//****************************************************************************************
if (isset($action) and $action == "delete_image") {
    include("../../config/admin_rights.php");
    if (isset($news_image_id)) {
        foreach ($news_image_id as $image) {
            $sql = $mysqli->query("SELECT news_image_ext FROM news_image WHERE news_image_id='$image'")
                or die("Couldn't query images");

            list($news_image_ext) = $sql->fetch_array(MYSQLI_BOTH);

            create_log_entry('News', $image, 'Image', $image, 'Delete', $_SESSION['user_id']);

            $mysqli->query("DELETE FROM news_image WHERE news_image_id='$image'")
                or die("Couldn't delete image$news_image_id");

            unlink("$news_images_save_path$image.$news_image_ext")
                or die("Couldn't delete image$news_image_id from server");

            $_SESSION['edit_message'] = "news image deleted";
        }
    } else {
        $_SESSION['edit_message'] = "something is wrong with the image id";
    }
    header("Location: ../news/news_edit_images.php");
}
