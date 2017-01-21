<?php
/***************************************************************************
 *                                statistics.php
 *                            -----------------------
 *   begin                : Friday, Oct 03, 2003
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        :     Website images added,
 *
 *
 *
 *   Id: statistics.php,v 0.10 2003/10/03 23:00 Silver Surfer
 *  Update: 2015/05/29 23:38 ST Graveyard
 *          - Added logged on user details
 *          2015/12/21 19:29 ST Graveyard
 *          - Added right side quicksearch for 1920 width
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

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "start_page.html");
