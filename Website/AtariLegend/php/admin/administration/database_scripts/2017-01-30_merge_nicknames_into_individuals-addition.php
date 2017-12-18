<?php
/********************************************************************************************
*                                2017-01-30_merge_nicknames_into_individuals-addition.php
*                            ---------------------------------------------------------------
*   begin                : 2017-01-30
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2017-01-30_merge_nicknames_into_individuals-addition.php,v 0.10 2017-01-30 STG
*
********************************************************************************************/

//First clean up the individual nicks table. I have noticed that even on production this table has empty records. WHY? I'm removing these here.
$sdbquery = $mysqli->query("DELETE FROM individual_nicks WHERE nick = ''") or die("Couldn't clean individual nicks table");

//Create a new column in the individual_nicks table
$sdbquery = $mysqli->query("ALTER TABLE individual_nicks ADD nick_id INT(11) NOT NULL; ") or die("trouble adding nick_id column");

//Let's get all the nicknames
$nickname = $mysqli->query("SELECT * FROM individual_nicks order by individual_nicks_id desc") or die("error getting nicknames");
while ($name = mysqli_fetch_assoc($nickname)) {
    $nick = $name['nick'];
    
    //Insert the nickname as a new entry in the individuals table
    $insertquery = $mysqli->query("INSERT INTO individuals (ind_name) VALUES ('$nick')") or die("error inserting nickname into individuals table");
    
    //get the newly created id
    $new_nick_id = $mysqli->insert_id;

    //Insert the new id in the correct record of the individual nicks table thus creating a cross check table
    $nickidinsert = $mysqli->query("Update individual_nicks SET nick_id='$new_nick_id' WHERE nick='$nick'") or die("error inserting new id in idividual_nicks table");
}

//remove the abundant column in the individual_nicks table
$sdbquery = $mysqli->query("ALTER TABLE individual_nicks DROP COLUMN nick;") or die("trouble removing nick column");
