<?php
/***************************************************************************
 *                                site_admin.php
 *                            -----------------------
 *   begin                : 2016-02-13
 *   copyright            : (C) 2016 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *
 *
 *
 *   Id: site_admin.php,v 0.10 2016-02-13 Silver Surfer
 *
 *   We may use this again when I figure out what Mattias had in
 *  mind with the template and themes stuff
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

foreach (KarmaGood() as $key => $value) {
    $smarty->append('karma_good', array(
        'karma' => $value[0],
        'user_name' => $value[1],
        'user_id' => $value[2]
    ));
}

foreach (KarmaBad() as $key => $value) {
    $smarty->append('karma_bad', array(
        'karma' => $value[0],
        'user_name' => $value[1],
        'user_id' => $value[2]
    ));
}

$stack = statistics_stack();

// smack the stack into a smarty var and pray it works
foreach ($stack as $value) {
    $smarty->append('statistics', array(
        'value' => $value
    ));
}

//*******************************
// Get the user stats
//*******************************
//Lets get all the date of the selected user
$sql_users = $mysqli->query("SELECT * FROM users
                          WHERE user_id = '" . $_SESSION['user_id'] . "' ") or die("Couldn't query users Database");

while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('users', array(
        'user_id' => $query_users['user_id'],
        'user_name' => $query_users['userid'],
        'image' => "$user_avatar_path$query_users[user_id].$query_users[avatar_ext]"
    ));
}

//Create the id's for dynamic positioning of the tiles
$smarty->assign('left_nav', 'left_nav_position_front');
$smarty->assign('quick_search_games', 'quick_search_position_front');
$smarty->assign('main_stats', 'main_stats_position_front');

//Send all smarty variables to the templates

$smarty->display("file:" . $cpanel_template_folder . "site_admin.html");
