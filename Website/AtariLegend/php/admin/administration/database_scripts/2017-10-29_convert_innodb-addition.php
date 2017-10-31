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

$result = $mysqli->query("DROP PROCEDURE IF EXISTS convertToInnodb;")
    or die("Error selecting MyISAM tables: ".$mysqli->error);


$result = $mysqli->query("
    CREATE PROCEDURE convertToInnodb()
    BEGIN
    mainloop: LOOP
      SELECT TABLE_NAME INTO @convertTable FROM information_schema.TABLES
      WHERE `TABLE_SCHEMA` LIKE DATABASE()
      AND `ENGINE` LIKE 'MyISAM' ORDER BY TABLE_NAME LIMIT 1;
      IF @convertTable IS NULL THEN
        LEAVE mainloop;
      END IF;
      SET @sqltext := CONCAT('ALTER TABLE `', DATABASE(), '`.`', @convertTable, '` ENGINE = INNODB');
      PREPARE convertTables FROM @sqltext;
      EXECUTE convertTables;
      DEALLOCATE PREPARE convertTables;
      SET @convertTable = NULL;
    END LOOP mainloop;

    END;")
        or die("Error selecting MyISAM tables: ".$mysqli->error);


$result = $mysqli->query("CALL convertToInnodb();")
    or die("Error selecting MyISAM tables: ".$mysqli->error);

$result = $mysqli->query("DROP PROCEDURE IF EXISTS convertToInnodb;")
    or die("Error selecting MyISAM tables: ".$mysqli->error);
