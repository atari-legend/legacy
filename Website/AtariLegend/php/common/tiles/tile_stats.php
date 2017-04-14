<?php
/***************************************************************************
*                               tile_stats.php
*                            -----------------------
*   begin                : Friday, april 15, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: tile_stats.phph,v 0.1 2017/04/15 00:46 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the stats tile
//*********************************************************************************************

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
?>
