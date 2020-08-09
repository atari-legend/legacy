<?php

$mysqli->query("ALTER TABLE game CHANGE game_name game_name VARCHAR(255) COMMENT 'Main name of a game'")
    or die($mysqli->error);
