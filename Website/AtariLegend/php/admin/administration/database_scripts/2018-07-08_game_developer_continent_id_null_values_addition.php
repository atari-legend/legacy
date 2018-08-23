<?php
$mysqli->query("ALTER TABLE game_developer CHANGE continent_id continent_id INTEGER NULL DEFAULT NULL")
    or die($mysqli->error);
$mysqli->query("UPDATE game_developer SET continent_id = NULL WHERE continent_id = 0")
    or die($mysqli->error);
