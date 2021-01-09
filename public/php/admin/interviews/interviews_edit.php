<?php
/***************************************************************************
 *                                interviews_edit.php
 *                            --------------------------
 *   begin                : Saturday, July 22 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : created this page
 *
 *   Id: interviews_edit.php,v 0.10 2005/07/22 13:40 Gatekeeper
 *   Id: interviews_edit.php,v 0.20 2016/08/02 23:01 Gatekeeper
 *   - AL 2.0
 *
 ***************************************************************************/

//****************************************************************************************
// This is the interview edit page. Overhere you can edit an existing interview
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//Get the individuals
$sql_individuals = $mysqli->query("SELECT * FROM individuals ORDER BY ind_name ASC")
    or die("Couldn't query indiciduals database");

while ($individuals = $sql_individuals->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('individuals', array(
        'ind_id' => $individuals['ind_id'],
        'ind_name' => $individuals['ind_name']
    ));
}

//Get the authors for the interview
$sql_author = $mysqli->query("SELECT user_id,userid FROM users ORDER BY userid ASC")
    or die("Database error - getting members name");

while ($authors = $sql_author->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('authors', array(
        'user_id' => $authors['user_id'],
        'user_name' => $authors['userid']
    ));
}

//we need to get the data of the loaded interview
$sql_interview = $mysqli->query("SELECT * FROM interview_main
    LEFT JOIN interview_text ON ( interview_main.interview_id = interview_text.interview_id )
    LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
    LEFT JOIN users on ( interview_main.user_id = users.user_id)
    WHERE interview_main.interview_id = '$interview_id'") or die("Database error - selecting interview data");

while ($interview = $sql_interview->fetch_array(MYSQLI_BOTH)) {
    if (!(isset($interview['user_id']))) {
        $author_id = $_SESSION['user_id'];
    } else {
        $author_id = $interview['user_id'];
    }

    $smarty->assign('interview', array(
        'interview_date' => $interview['interview_date'],
        'interview_id' => $interview_id,
        'interview_intro' => $interview['interview_intro'],
        'interview_chapters' => $interview['interview_chapters'],
        'interview_text' => $interview['interview_text'],
        'interview_ind_name' => $interview['ind_name'],
        'interview_author' => $author_id ,
        'interview_author_name' => $interview['userid'],
        'interview_ind_id' => $interview['ind_id'],
        'interview_draft' => $interview['draft'],
    ));
}

//Let's get the screenshots for the interview
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_interview
    LEFT JOIN screenshot_main on ( screenshot_interview.screenshot_id = screenshot_main.screenshot_id )
    WHERE screenshot_interview.interview_id = '$interview_id' ORDER BY screenshot_interview.screenshot_id ASC")
    or die("Database error - getting screenshots & comments");

//get the number of screenshots in the archive
$v_screeshots = $sql_screenshots->num_rows;
$smarty->assign("screenshots_nr", $v_screeshots);

$count = 1;

while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
    $v_int_image = $interview_screenshot_path;
    $v_int_image .= $screenshots['screenshot_id'];
    $v_int_image .= '.';
    $v_int_image .= $screenshots['imgext'];

    //We need to get the comments with each screenshot
    $sql_comments = $mysqli->query("SELECT * FROM interview_comments
        WHERE screenshot_interview_id  = $screenshots[screenshot_interview_id]")
        or die("Database error - getting screenshots comments");

    $comments = $sql_comments->fetch_array(MYSQLI_BOTH);

    $smarty->append('screenshots', array(
        'interview_screenshot' => $v_int_image,
        'interview_screenshot_id' => $screenshots['screenshot_id'],
        'interview_screenshot_count' => $count,
        'interview_screenshot_comment' => htmlentities($comments['comment_text'] ?? '')
    ));
    $count = $count + 1;
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "interviews/interviews_edit.html");

//close the connection
mysqli_close($mysqli);
