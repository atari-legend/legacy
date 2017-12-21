<?php
/*******************************************************************************
 *                                who_is_online.php
 *                            -----------------------
 *   begin                : 2017-06-25
 *   copyright            : (C) 2017 Atari Legend
 *
 *   Id: who_is_online.php,v 0.10 2017-06-25 22:30 Grave
 *
 ********************************************************************************/

//We have the last logon time of each user in the user table. We need to compare this with the current time - 1 minute.
//So if the last log on time of the user is bigger than the current time - 1 minute, we can asume the user is online.
$five_minutes = time()-(60*1);
$nr_users = 0;
$nr_users_24 = 0;

//Lets get all the data of the user who are online
$sql_users = $mysqli->query("SELECT * FROM users
                              WHERE last_visit > '$five_minutes'") or die("Couldn't query users Database 1 min");

while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH)) {
    $nr_users = $nr_users + 1;

    $smarty->append('users_online', array(
        'user_id' => $query_users['user_id'],
        'user_name' => $query_users['userid']
    ));
}

$smarty->assign('nr_users', $nr_users);

//Now let's check who was online in the last 24 hours
$twentyfour_hours = time()-(60*1440);

//Lets get all the data of the user who were online
$sql_users = $mysqli->query("SELECT * FROM users
                              WHERE last_visit > '$twentyfour_hours'") or die("Couldn't query users Database 24h");

while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH)) {
    $nr_users_24 = $nr_users_24 + 1;

    $smarty->append('users_24h', array(
        'user_id' => $query_users['user_id'],
        'user_name' => $query_users['userid']
    ));
}

$smarty->assign('nr_users_24', $nr_users_24);
