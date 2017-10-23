<?php
/***************************************************************************
 *                                Individuals_main.php
 *                            --------------------------
 *   begin                : Saturday, August 6, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : Creation of file
 *   Id: Individuals_main.php,v 0.10 2005/08/06 15:04 Gatekeeper
 *   Id: Individuals_main.php,v 0.20 2016/08/01 23:04 Gatekeeper
 *        - AL 2.0
 *   Id: Individuals_main.php,v 0.30 2017/02/02 00:22 Gatekeeper
 *          - Converting to the new way of individual nicks storage
 *
 ***************************************************************************/

/*
 ************************************************************************************************
 The main individual page
 ************************************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//Get the individuals
$sql_individuals = $mysqli->query("SELECT * FROM individuals ORDER BY ind_name ASC");

while ($individuals = $sql_individuals->fetch_array(MYSQLI_BOTH)) {
    if ($individuals['ind_name'] != '') {
        $smarty->append('individuals', array(
            'ind_id' => $individuals['ind_id'],
            'ind_name' => $individuals['ind_name']
        ));
    }
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "individuals_main.html");

//close the connection
mysqli_close($mysqli);
