<?php

// A file named 'connection_settings.php' must be created in the same directory
// This file should expose 4 variables:
// $db_host: Hostname of the database server
// $db_username: Username for the database
// $db_password: Password for the database
// $db_databasename: Name of the database
require('connection_settings.php');

$mysqli = new mysqli($db_host, $db_username, $db_password, $db_databasename);

// All tables are in UTF-8, so we need to make sure we talk to the
// database with the correct charset
mysqli_set_charset($mysqli, "utf8");
