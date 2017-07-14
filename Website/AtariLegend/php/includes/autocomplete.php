<?php
/*******************************************************************************
 *                                autocomplete.php
 *                            -----------------------
 *   begin                : june 2015
 *   copyright            : (C) 2015 Atari Legend
 *   email                :
 *
 *   Id: autocomplete.php,v 0.10 2015 Brume
 *   Id: autocomplete.php,v 0.11 05/07/2017 ST Graveyard
 *          - Fixed the autocomplete scropt
 *
 ********************************************************************************

 *********************************************************************************
 * This is the autocompletion script used on the search on the frontpage
 *********************************************************************************/

include("../config/connect.php");
$text = $mysqli->real_escape_string($_GET['term']);

//Set up queries
$game_name_query     = "SELECT game_name FROM game";
$game_aka_name_query = "SELECT aka_name AS game_name FROM game_aka";
//$demo_name_query     = "SELECT demo_name AS game_name FROM demo";
//$demo_aka_name_query = "SELECT aka_name AS game_name FROM demo_aka";

//Create a temporary table to get all the demos and aka's as well.
$mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $game_name_query");
$mysqli->query("INSERT INTO temp $game_aka_name_query");
//$mysqli->query("INSERT INTO temp $demo_name_query");
//$mysqli->query("INSERT INTO temp $demo_aka_name_query");

$json = array();

//Get the results
$result = $mysqli->query("SELECT game_name FROM temp WHERE game_name LIKE '%$text%' ORDER BY game_name ASC LIMIT 10") or die ("error getting date for autocomplete");

while ($row = $result->fetch_assoc()) 
{  
    $json[] = $row['game_name'];
}

$mysqli->query("DROP TABLE temp");
echo json_encode($json);
?>
