<?php
//
// This is the autocompletion script used on the search on the frontpage
//
include("../includes/connect.php"); 
$text = $mysqli->real_escape_string($_GET['term']);

//Set up queries
$game_name_query = "SELECT game_name FROM game";
$game_aka_name_query = "SELECT aka_name AS game_name FROM game_aka";
$demo_name_query = "SELECT demo_name AS game_name FROM demo";
$demo_aka_name_query = "SELECT aka_name AS game_name FROM demo_aka";

//Create a temporary table to get all the demos and aka's as well.
$mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $game_name_query");
$mysqli->query("INSERT INTO temp $game_aka_name_query");
$mysqli->query("INSERT INTO temp $demo_name_query");
$mysqli->query("INSERT INTO temp $demo_aka_name_query");

//Get the results
$query = "SELECT game_name FROM temp WHERE game_name LIKE '%$text%' ORDER BY game_name ASC LIMIT 10";
$result = $mysqli->query($query);
$json = '[';
$first = true;
while($row = $result->fetch_assoc())
{
    if (empty($first)) 
		{ 
			$json .=  ','; 
		} 
		else 
		{ 
			$first = false; 
		}
    $json .= '{"value":"'.$row['game_name'].'"}';
}
$json .= ']';
$mysqli->query("DROP TABLE temp");
echo $json;
?>
