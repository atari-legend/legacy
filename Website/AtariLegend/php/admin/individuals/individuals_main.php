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
 *
 ***************************************************************************/

/*
 ************************************************************************************************
 The main individual page
 ************************************************************************************************
 */

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

//Get the individuals
$sql_individuals = "SELECT * FROM individuals ORDER BY ind_name ASC";
$sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

//Create a temporary table to build an array with both names and nicknames
$mysqli->query("CREATE TEMPORARY TABLE temp ENGINE = MEMORY $sql_individuals") or die("failed to create temporary table");
$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");

$query_temporary = $mysqli->query("SELECT * FROM temp ORDER BY ind_name ASC") or die("Failed to query temporary table");
$mysqli->query("DROP TABLE temp");

while ($individuals = $query_temporary->fetch_array(MYSQLI_BOTH)) {
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
?>
