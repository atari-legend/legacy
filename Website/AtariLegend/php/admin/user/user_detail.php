<?php
/***************************************************************************
 *                                user_detail.php
 *                            -----------------------
 *   begin                : friday, November 11, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : file creation
 *
 *
 *   Id: user_detail.php,v 0.20 2015/08/22 ST Graveman
 *   Id: user_detail.php,v 0.30 2015/12/21 ST Graveman - Added right side
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the user detail page
 ***********************************************************************************
 */
// include common variables and functions
include("../../includes/common.php");
include("../../includes/quick_search_games.php");
include("../../includes/admin.php");

//Lets get all the data of the selected user
$sql_users = $mysqli->query("SELECT * FROM users
                              WHERE user_id = $user_id_selected") or die("Couldn't query users Database");

while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH)) {
    $email = trim($query_users['email']);

    if ($query_users['join_date'] !== '') {
        $join_date = date("F j, Y", $query_users['join_date']);
    }
    if ($query_users['last_visit'] !== '') {
        $last_visit = date("F j, Y", $query_users['last_visit']);
    }
    $smarty->assign('users', array(
        'user_id' => $query_users['user_id'],
        'user_name' => $query_users['userid'],
        'user_pwd' => $query_users['password'],
        'user_email' => $query_users['email'],
        'user_permission' => $query_users['permission'],
        'user_website' => $query_users['user_website'],
        'user_icq' => $query_users['user_icq'],
        'user_msnm' => $query_users['user_msnm'],
        'avatar_ext' => $query_users['avatar_ext'],
        'image' => "$user_avatar_path$query_users[user_id].$query_users[avatar_ext]",
        'inactive' => $query_users['inactive'],
        'user_aim' => $query_users['user_aim']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "user_detail.html");

//close the connection
mysqli_close($mysqli);
