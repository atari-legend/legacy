<?php
//
// This is the autocompletion script used on the search on the frontpage
//
include("../includes/connect.php"); 
$text = $mysqli->real_escape_string($_GET['term']);

$query = "SELECT * FROM game WHERE game_name LIKE '%$text%' ORDER BY game_name ASC LIMIT 10";
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
echo $json;
?>
