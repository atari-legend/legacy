<?php
/***************************************************************************
 *                                submission_demos.php
 *                            -----------------------------
 *   begin                : Sunday, December 04, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : created this page
 *
 *
 *   Id: submission_demos.php,v 0.12 2005/04/28 Silver Surfer
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Display submissions
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

if (empty($list) or $list == '') {
    $list = "current";
}
// get the total nr of submissions in the DB
$query_total_number = $mysqli->query("SELECT * FROM demo_submitinfo")
    or die("Couldn't get the total number of submissions");
$v_rows_total = $query_total_number->num_rows;

$smarty->assign('total_nr_submissions', $v_rows_total);

$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

if ($list == "done") {
    $sql_submission = $mysqli->query("SELECT * FROM demo_submitinfo
                    LEFT JOIN demo ON (demo_submitinfo.demo_id = demo.demo_id)
                    LEFT JOIN users ON (demo_submitinfo.user_id = users.user_id)
                    WHERE demo_done = '1'
                    ORDER BY demo_submitinfo.demo_submitinfo_id
                    DESC LIMIT  " . $v_counter . ", 25");

    //check the number of comments
    $query_number = $mysqli->query("SELECT * FROM demo_submitinfo
                       WHERE demo_done = '1'
                       ORDER BY demo_submitinfo_id DESC") or die("Couldn't get the number of demo submissions");

    $v_rows = $query_number->num_rows;
} else {
    $sql_submission = $mysqli->query("SELECT * FROM demo_submitinfo
                    LEFT JOIN demo ON (demo_submitinfo.demo_id = demo.demo_id)
                    LEFT JOIN users ON (demo_submitinfo.user_id = users.user_id)
                    WHERE demo_done <> '1'
                    ORDER BY demo_submitinfo.demo_submitinfo_id
                    DESC LIMIT  " . $v_counter . ", 25");

    //check the number of comments
    $query_number = $mysqli->query("SELECT * FROM demo_submitinfo
                       WHERE demo_done <> '1'
                       ORDER BY demo_submitinfo_id DESC") or die("Couldn't get the number of demo submissions");

    $v_rows = $query_number->num_rows;
}
$number_sub = $sql_submission->num_rows;

while ($query_submission = $sql_submission->fetch_array(MYSQLI_BOTH)) {
    if (isset($query_submission['demo_id'])) {
        //Select a random screenshot record
        $query_demo = $mysqli->query("SELECT
                 screenshot_demo.demo_id,
                 screenshot_demo.screenshot_id,
                 screenshot_main.imgext
                   FROM screenshot_demo
                   LEFT JOIN screenshot_main ON (screenshot_demo.screenshot_id = screenshot_main.screenshot_id)
                 WHERE screenshot_demo.demo_id = $query_submission[demo_id]
                   ORDER BY RAND() LIMIT 1");

        $sql_demo = $query_demo->fetch_array(MYSQLI_BOTH);
    }

    // Retrive userstats from database
    $query_user         = $mysqli->query("SELECT *
                 FROM demo_user_comments
                 LEFT JOIN comments ON ( demo_user_comments.comments_id = comments.comments_id )
                 WHERE user_id = '$query_submission[user_id]'");
    $usercomment_number = $query_user->num_rows;

    $query_submitinfo = $mysqli->query("SELECT * FROM demo_submitinfo WHERE user_id = '$query_submission[user_id]'")
        or die("Could not count user submissions");
    $usersubmit_number = $query_submitinfo->num_rows;

    //Get the dataElements we want to place on screen
    $v_demo_image = $demo_screenshot_path;
    $v_demo_image .= $sql_demo['screenshot_id'];
    $v_demo_image .= '.';
    $v_demo_image .= $sql_demo['imgext'];

    $converted_date = date("F j, Y", $query_submission['timestamp']);
    $user_joindate  = date("F j, Y", $query_submission['join_date']);
    $comment        = InsertALCode($query_submission['submit_text']);
    $comment        = InsertSmillies($comment);
    $comment        = nl2br($comment);
    $comment        = stripslashes($comment);

    $smarty->append('submission', array(
        'demo_id' => $query_submission['demo_id'],
        'demo_name' => $query_submission['demo_name'],
        'date' => $converted_date,
        'image' => $v_demo_image,
        'comment' => $comment,
        'submit_id' => $query_submission['demo_submitinfo_id'],
        'user_name' => $query_submission['userid'],
        'user_id' => $query_submission['user_id'],
        'karma' => $query_submission['karma'],
        'user_joindate' => $user_joindate,
        'user_comment_nr' => $usercomment_number,
        'usersubmit_number' => $usersubmit_number,
        'email' => $query_submission['email']
    ));
}

//Check if back arrow is needed
if ($v_counter > 0) {
    $back_arrow = $v_counter - 25;
}

//Check if we need to place a next arrow
if ($v_rows > ($v_counter + 25)) {
    $forward_arrow = ($v_counter + 25);
}

if (empty($list) or $list == '') {
    $list = "current";
}
if (empty($back_arrow) or $back_arrow == '') {
    $back_arrow = "";
}
if (empty($forward_arrow) or $forward_arrow == '') {
    $forward_arrow = "";
}

$smarty->assign('structure', array(
    'list' => $list,
    'v_counter' => $v_counter,
    'back_arrow' => $back_arrow,
    'forward_arrow' => $forward_arrow,
    'num_sub' => $number_sub
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "demos/submission_demos.html");
