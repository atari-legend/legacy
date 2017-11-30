<?php
/***************************************************************************
*                                2017-10-29_convert_innodb-addition.php
*                            ----------------------------------------------
*   begin                : 2017-10-29
*   copyright            : (C) 2017 Atari Legend
*   email                : nicolas+github@guillaumin.me
*
*   Extra update script to convert all tables to the InnoDB storage engine
*
***************************************************************************/

$result = $mysqli->query("SELECT table_name
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND engine != 'InnoDB'")
    or die("Error selecting MyISAM tables: ".$mysqli->error);

while($row = mysqli_fetch_assoc($result)) {
    $table_name = $row["table_name"];

    $mysqli->query("ALTER TABLE $table_name ENGINE=InnoDB")
        or die("Error converting $table_name to InnoDB: ".$mysqli->error);
}
?>
