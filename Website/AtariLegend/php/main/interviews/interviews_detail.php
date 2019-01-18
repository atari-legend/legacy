<?php
//***************************************************************************
//                                Interviews_detail.php
//                            ------------------------------
//   begin                : Sunday, August 20, 2017
//   copyright            : (C) 2017 Atari Legend
//   email                : martens_maarten@hotmail.com
//
//   Id: Interviews_detail.php,v 0.1 2017/08/20 13:02 STG
//****************************************************************************

//****************************************************************************
// This is the detail page of an interview.
//****************************************************************************

//load all common functions
require "../../config/common.php";

//load the tiles
require "../../common/tiles/latest_interviews_tile.php";

require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/Model/Breadcrumb.php";

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);

//***********************************************************************************
//Let's get all the interview and author data
//***********************************************************************************
$sql_interview = $mysqli->query(
    "SELECT *
    FROM interview_main
    LEFT JOIN interview_text on (interview_main.interview_id = interview_text.interview_id)
    LEFT JOIN users on (interview_main.user_id = users.user_id)
    LEFT JOIN individuals on (interview_main.ind_id = individuals.ind_id)
    WHERE interview_main.interview_id = '$selected_interview_id'"
) or die("Error - Couldn't query interview data");

$query_interview = $sql_interview->fetch_array(MYSQLI_BOTH);

$v_interview_date = date("F j, Y", $query_interview['interview_date']);
$v_interview_year = date("Y", $query_interview['interview_date']);

$interview_text = $query_interview['interview_text'];
$interview_text = nl2br($interview_text);
$interview_text = InsertALCode($interview_text);

$interview_intro = $query_interview['interview_intro'];
$interview_intro = nl2br($interview_intro);
$interview_intro = InsertALCode($interview_intro);

$interview_chapters = $query_interview['interview_chapters'];
$interview_chapters = nl2br($interview_chapters);
$interview_chapters = InsertALCode($interview_chapters);

//get the profile of the author
$sql_ind_text = $mysqli->query("SELECT * FROM individual_text WHERE ind_id = $query_interview[ind_id]")
    or die("problem getting individual data");

$query_ind_text = $sql_ind_text->fetch_array(MYSQLI_BOTH);

if (preg_match("/[a-z]/i", $query_ind_text['ind_profile'])) {
    $profile = $query_ind_text['ind_profile'];
} else {
    $profile = 'none';
}

//The interviewed person's picture
if ($query_ind_text['ind_imgext'] == 'png'
    or $query_ind_text['ind_imgext'] == 'jpg'
    or $query_ind_text['ind_imgext'] == 'gif'
) {
    $v_ind_image = $individual_screenshot_path;
    $v_ind_image .= $query_interview['ind_id'];
    $v_ind_image .= '.';
    $v_ind_image .= $query_ind_text['ind_imgext'];
} else {
    $v_ind_image = "none";
}

$smarty->assign(
    'interview', array(
    'individual_name' => $query_interview['ind_name'],
    'individual_id' => $query_interview['ind_id'],
    'individual_profile' => $profile,
    'interview_author' => $query_interview['userid'],
    'interview_author_id' => $query_interview['user_id'],
    'interview_email' => $query_interview['email'],
    'interview_id' => $selected_interview_id,
    'interview_date' => $v_interview_date,
    'interview_year' => $v_interview_year,
    'interview_img' => $v_ind_image,
    'interview_text' => $interview_text,
    'interview_intro' => $interview_intro,
    'interview_chapters' => $interview_chapters
    )
);

//Get the screenshots and the comments of this interview
$query_screenshots = $mysqli->query(
    "
SELECT * FROM interview_main
LEFT JOIN screenshot_interview ON (interview_main.interview_id = screenshot_interview.interview_id)
LEFT JOIN screenshot_main ON (screenshot_interview.screenshot_id = screenshot_main.screenshot_id)
LEFT JOIN interview_comments ON "
    ."(screenshot_interview.screenshot_interview_id = interview_comments.screenshot_interview_id)
WHERE interview_main.interview_id = '$selected_interview_id'
ORDER BY screenshot_main.screenshot_id"
);

$count = 1;

while ($sql_screenshots = $query_screenshots->fetch_array(MYSQLI_BOTH)) {
    if ($sql_screenshots['screenshot_id'] != '') {
        $new_path = $interview_screenshot_path;
        $new_path .= $sql_screenshots['screenshot_id'];
        $new_path .= ".";
        $new_path .= $sql_screenshots['imgext'];

        $smarty->append(
            'screenshots_interview', array(
            'screenshot' => $new_path,
            'count' => $count,
            'comment' => $sql_screenshots['comment_text']
            )
        );

        $count++;
    }
}

//get the games from this author
$sql_games = $mysqli->query(
    "
SELECT *
FROM game_individual
LEFT JOIN individual_role ON (game_individual.individual_role_id = individual_role.id)
LEFT JOIN game ON (game_individual.game_id = game.game_id)
WHERE game_individual.individual_id = '$query_interview[ind_id]'
GROUP BY game.game_id, game.game_name HAVING COUNT(DISTINCT game.game_id, game.game_name) = 1
ORDER BY game.game_name ASC"
)
or die("problem with query");

$count = 0;

while ($query_games = $sql_games->fetch_array(MYSQLI_BOTH)) {
    $count++;

    $releases = $gameReleaseDao->getReleasesForGame($query_games['game_id']);

    $smarty->append(
        'games', array(
        'game_id' => $query_games['game_id'],
        'game_name' => $query_games['game_name'],
        'game_releases' => $releases,
        'individual_role' => $query_games['name'],
        'count' => $count
        )
    );
}

//***********************************************************************************
//Get the comments
//***********************************************************************************
//Select the comments from the DB
$sql_comment = $mysqli->query(
    "SELECT *
    FROM interview_user_comments
    LEFT JOIN comments ON ( interview_user_comments.comment_id = comments.comments_id )
    LEFT JOIN users ON ( comments.user_id = users.user_id )
    WHERE interview_user_comments.interview_id = '$selected_interview_id'
    ORDER BY comments.timestamp desc"
) or die("Syntax Error! Couldn't not get the comments!");

while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {
    $oldcomment = $query_comment['comment'];
    $oldcomment = nl2br($oldcomment);
    $oldcomment = InsertALCode($oldcomment);
    $oldcomment = trim($oldcomment);
    $oldcomment = RemoveSmillies($oldcomment);
    $oldcomment = stripslashes($oldcomment);

    $comment = stripslashes($query_comment['comment']);
    $comment = trim($comment);
    $comment = RemoveSmillies($comment);

    // this is needed, because users can change their own comments on the website, however this is done with JS
    // (instead of a post with pure HTML)
    //The translation of the 'enter' breaks is different in JS, so in JS I do a conversion to a <br>.
    //However, when we edit a comment, this <br> should not be visible to the user, hence again,
    //now this conversion in php

    $breaks  = array(
        "<br />",
        "<br>",
        "<br/>"
    );
    $comment = str_ireplace($breaks, "\r\n", $comment);

    $date = date("d/m/y", $query_comment['timestamp']);

    $smarty->append(
        'comments', array(
        'comment' => $oldcomment,
        'comment_edit' => $comment,
        'comment_id' => $query_comment['comment_id'],
        'date' => $date,
        'user_name' => $query_comment['userid'],
        'user_id' => $query_comment['user_id'],
        'user_fb' => $query_comment['user_fb'],
        'user_website' => $query_comment['user_website'],
        'user_twitter' => $query_comment['user_twitter'],
        'user_af' => $query_comment['user_af'],
        'show_email' => $query_comment['show_email'],
        'email' => $query_comment['email']
        )
    );
}

$smarty->assign(
    'breadcrumb',
    array(
        new AL\Common\Model\Breadcrumb("/interviews/interviews_main.php", "Interviews"),
        new AL\Common\Model\Breadcrumb(
            "/interviews/interviews_detail.php?selected_interview_id=$selected_interview_id",
            $query_interview['ind_name']
        )
    )
);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "interviews_detail.html");

//close the connection
mysqli_close($mysqli);
