<?php
$mysqli->query("ALTER TABLE game_developer CHANGE game_extra_info_id game_extra_info_id INTEGER NULL DEFAULT NULL")
    or die($mysqli->error);
$mysqli->query("UPDATE game_developer SET game_extra_info_id = NULL WHERE game_extra_info_id = 0")
    or die($mysqli->error);
