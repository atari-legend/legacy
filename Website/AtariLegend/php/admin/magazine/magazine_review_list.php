<?php
/***************************************************************************
 *                            magazine_review_list.php
 *                            -----------------------
 *   begin                : Saturday, May 01, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : file creation
 *
 *
 *   Id: magazine_review_list.php,v 1.10 2005/09/11 Silver Surfer
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 List of games reviewed in a particular magazine issue!
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

$sql = $mysqli->query("SELECT * FROM magazine_game
    LEFT JOIN game ON (magazine_game.game_id = game.game_id)
    WHERE magazine_game.magazine_issue_id='$magazine_issue_id'") or die("Error retriving magazines reviews");

while ($fetch = $sql->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('magazine', array(
        'game' => $fetch['game_name'],
        'score' => $fetch['score']
    ));
}
$sql_magazine = $mysqli->query("SELECT * FROM magazine_issue WHERE magazine_issue_id='$magazine_issue_id'")
    or die("Error retriving magazines info");

$fetch_magazine = $sql_magazine->fetch_array(MYSQLI_BOTH);

$smarty->assign('magazine_info', array(
    'magazine_id' => $fetch_magazine['magazine_id']
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "magazine_review_list.html");
