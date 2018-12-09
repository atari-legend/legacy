<?php
// Script to drop the tables game_development, game_unfinished and game_unreleased

//
// let's do game_unfinished
//

$result1 = $mysqli->query("DROP TABLE game_unfinished")
                            or die("Unable to drop game_unfinished".$mysqli->error);

//
// let's do game_development
//

$result2 = $mysqli->query("DROP TABLE game_development")
                            or die("Unable to drop game_development".$mysqli->error);

//
// let's do game_unreleased
//

$result3 = $mysqli->query("DROP TABLE game_unreleased")
                            or die("Unable to drop game_unreleased".$mysqli->error);
