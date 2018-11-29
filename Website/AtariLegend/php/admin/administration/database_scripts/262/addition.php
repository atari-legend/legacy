<?php
// Clean up various tables

$result = $mysqli->query("DROP TABLE download_format")
                            or die("Unable to delete download_format: ".$mysqli->error);
                            
$result = $mysqli->query("DROP TABLE download_main")
                            or die("Unable to delete download_main: ".$mysqli->error);

$result = $mysqli->query("DROP TABLE download_options")
                            or die("Unable to delete download_options: ".$mysqli->error);

$result = $mysqli->query("DROP TABLE format")
                            or die("Unable to delete format: ".$mysqli->error);

$result = $mysqli->query("DROP TABLE game_diskscan")
                            or die("Unable to delete game_diskscan: ".$mysqli->error);

$result = $mysqli->query("DROP TABLE game_download")
                            or die("Unable to delete game_download: ".$mysqli->error);

$result = $mysqli->query("DROP TABLE game_download_crew")
                            or die("Unable to delete game_download_crew : ".$mysqli->error);

$result = $mysqli->query("DROP TABLE game_download_details")
                            or die("Unable to delete game_download_details : ".$mysqli->error);
                            
$result = $mysqli->query("DROP TABLE game_download_individual")
                            or die("Unable to delete game_download_individual : ".$mysqli->error);

$result = $mysqli->query("DROP TABLE game_download_info")
                            or die("Unable to delete game_download_info : ".$mysqli->error);
                            
$result = $mysqli->query("DROP TABLE game_download_intro")
                            or die("Unable to delete game_download_intro : ".$mysqli->error);
                            
$result = $mysqli->query("DROP TABLE game_download_lingo")
                            or die("Unable to delete game_download_lingo : ".$mysqli->error);
                            
$result = $mysqli->query("DROP TABLE game_download_menu")
                            or die("Unable to delete game_download_menu : ".$mysqli->error);
                            
$result = $mysqli->query("DROP TABLE game_download_options")
                            or die("Unable to delete game_download_options : ".$mysqli->error);
                            
$result = $mysqli->query("DROP TABLE game_download_set")
                            or die("Unable to delete game_download_set : ".$mysqli->error);

$result = $mysqli->query("DROP TABLE game_download_tos")
                            or die("Unable to delete game_download_tos : ".$mysqli->error);
                            
$result = $mysqli->query("DROP TABLE game_download_trainer")
                            or die("Unable to delete game_download_trainer : ".$mysqli->error);    

$result = $mysqli->query("DROP TABLE review_comments_cross")
                            or die("Unable to delete review_comments_cross : ".$mysqli->error);   

$result = $mysqli->query("DROP TABLE standalone_music")
                            or die("Unable to delete standalone_music : ".$mysqli->error);                             
