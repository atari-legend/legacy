<?php
/***************************************************************************
 *                                demos_detail.php
 *                            ------------------------
 *   begin                : Sunday, October 30, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: demos_detail.php,v 0.10 2005/10/30 14:30 Zombieman
 *
 ***************************************************************************/

//****************************************************************************************
// This is the db modification file for demos_detail.php, demos_main.php
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//***********************************************************************************
//If we are adding a new demo
//***********************************************************************************

if (isset($action) and $action == "insert_demo") {
    //Insert the demo in the demo table
    $sql_demo = $mysqli->query("INSERT INTO demo (demo_name) VALUES ('$newdemo')")
        or die("Couldn't insert demo into database");

    $message = "demo has been inserted into the database";
    $smarty->assign("message", $message);

    header("Location: ../demos/demos_main.php");
}

//***********************************************************************************
//If delete aka link has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_aka') {
    $sql_aka = $mysqli->query("DELETE FROM demo_aka WHERE demo_aka_id = '$demo_aka_id' and demo_id = '$demo_id'")
        or die("Couldn't delete aka");
    header("Location: ../demos/demos_detail.php?demo_id=$demo_id");
}

//***********************************************************************************
//If add aka button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'demo_aka') {
    $sql_aka = $mysqli->query("INSERT INTO demo_aka (demo_id, aka_name) VALUES ('$demo_id','$demo_aka')")
        or die("Couldn't insert aka demos");
    header("Location: ../demos/demos_detail.php?demo_id=$demo_id");
}

//***********************************************************************************
//If delete creator button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_author') {
    if (isset($demo_author_id)) {
        foreach ($demo_author_id as $author) {
            $mysqli->query("DELETE FROM demo_author WHERE demo_author_id = '$author' and demo_id = '$demo_id'");
        }
    }
    header("Location: ../demos/demos_detail.php?demo_id=$demo_id");
}

//***********************************************************************************
//If delete crew button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_crew') {
    if (isset($demo_crew_id)) {
        foreach ($demo_crew_id as $crew) {
            $mysqli->query("DELETE FROM crew_demo_prod WHERE crew_id = '$crew' and demo_id = '$demo_id'");
        }
    }

    header("Location: ../demos/demos_detail.php?demo_id=$demo_id");
}

//***********************************************************************************
//If add crew button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'add_crew') {
    $sql = $mysqli->query("INSERT INTO crew_demo_prod (demo_id,crew_id) VALUES ('$demo_id','$crew_id_select')")
        or die("crew insertion failed");

    header("Location: ../demos/demos_detail.php?demo_id=$demo_id");
}

//***********************************************************************************
//If the add creator button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'add_author') {
    $sql = $mysqli->query("INSERT INTO demo_author (demo_id,ind_id,author_type_id)
        VALUES ('$demo_id','$ind_id','$author_type_id')") or die("individual insertion failed");

    header("Location: ../demos/demos_detail.php?demo_id=$demo_id");
}

//***********************************************************************************
//If the modify button has been pressed, update the necesarry tables
//***********************************************************************************
if (isset($action) and $action == 'modify_demo') {
    // demo_table
    $sdbquery = $mysqli->query("UPDATE demo SET demo_name='$demo_name' WHERE demo_id=$demo_id")
        or die("trouble updating demo");

    // demo year
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM demo_year WHERE demo_id='$demo_id'");
    $sdbquery = $mysqli->query("INSERT INTO demo_year (demo_id,demo_year) VALUES ($demo_id,$Date_Year)");

    // DUMP TABLE UPDATE
    $sdbquery = $mysqli->query("UPDATE demo_search SET year='$Date_Year' WHERE demo_id='$demo_id'")
        or die("couldn't update dumptable - year");

    // Delete the category crosses currently in the database for this game
    $sdbquery = $mysqli->query("DELETE FROM demo_cat_cross WHERE demo_id=$demo_id");

    // Insert the values from the passed category array
    if (isset($category)) {
        foreach ($category as $cat) {
            $sdbquery = $mysqli->query("INSERT INTO demo_cat_cross (demo_id,demo_cat_id) VALUES ($demo_id,$cat)");
        }
    }

    // Update the STE ONLY tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM demo_ste_only WHERE demo_id='$demo_id'");

    // then insert the new value if it has been passed.
    if (isset($ste_only)) {
        $sdbquery = $mysqli->query("INSERT INTO demo_ste_only (demo_id,ste_only) VALUES ('$demo_id','$ste_only')");
    }

    // Update the STE ENHANCED tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM demo_ste_enhan WHERE demo_id='$demo_id'");

    // then insert the new value if it has been passed.
    if (isset($ste_enhanced)) {
        $sdbquery = $mysqli->query("INSERT INTO demo_ste_enhan (demo_id,ste_enhanced)
            VALUES ('$demo_id','$ste_enhanced')");
    }

    // Update the FALCON ONLY tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM demo_falcon_only WHERE demo_id='$demo_id'");

    // then insert the new value if it has been passed.
    if (isset($falcon_only)) {
        $sdbquery = $mysqli->query("INSERT INTO demo_falcon_only (demo_id,falcon_only)
            VALUES ('$demo_id','$falcon_only')");
    }

    // Update the FALCON ENHANCED tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM demo_falcon_enhan WHERE demo_id='$demo_id'");

    // then insert the new value if it has been passed.
    if (isset($falcon_enhanced)) {
        $sdbquery = $mysqli->query("INSERT INTO demo_falcon_enhan (demo_id,falcon_enhanced)
            VALUES ('$demo_id','$falcon_enhanced')");
    }

    // Update the MONO ONLY tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM demo_mono_only WHERE demo_id='$demo_id'");

    // then insert the new value if it has been passed.
    if (isset($mono_only)) {
        $sdbquery = $mysqli->query("INSERT INTO demo_mono_only (demo_id,mono_only)VALUES ('$demo_id','$mono_only')");
    }

    $smarty->assign("message", 'Demo has been modified correctly');
    header("Location: ../demos/demos_detail.php?demo_id=$demo_id");
}

//***********************************************************************************
//If the delete button has been pressed, delete the necesarry records from the tables
//***********************************************************************************
if (isset($action) and $action == 'delete_demo') {
    //First we need to do a hell of a lot checks before we can delete an actual game.
    $sdbquery = $mysqli->query("SELECT * FROM demo_download WHERE demo_id='$demo_id'")
        or die("Error getting download info");
    if ($sdbquery->num_rows > 0) {
        $smarty->assign(
            "message",
            'Deletion failed - This demo has downloads - Delete it in the appropriate section'
        );
    } else {
        $sdbquery = $mysqli->query("SELECT * FROM demo_user_comments WHERE demo_id='$demo_id'")
            or die("Error getting user comments");
        if ($sdbquery->num_rows > 0) {
            $smarty->assign(
                "message",
                'Deletion failed - This demo has user comments - Delete it in the appropriate section'
            );
        } else {
            $sdbquery = $mysqli->query("SELECT * FROM demo_submitinfo WHERE demo_id='$demo_id'")
                or die("Error getting submit info");
            if ($sdbquery->num_rows > 0) {
                $smarty->assign("message", 'Deletion failed - This demo has info submitted from visitors - '
                    .'Delete it in the appropriate section');
            } else {
                $sdbquery = $mysqli->query("SELECT * FROM screenshot_demo WHERE demo_id='$demo_id'")
                    or die("Error getting screenshot info");
                if ($sdbquery->num_rows > 0) {
                    $smarty->assign("message", 'Deletion failed - This demo has screenshots - '
                        .'Delete it in the appropriate section');
                } else {
                    $sdbquery = $mysqli->query("SELECT * FROM demo_music WHERE demo_id='$demo_id'")
                        or die("Error getting music info");
                    if ($sdbquery->num_rows > 0) {
                        $smarty->assign("message", 'Deletion failed - This demo has music files attached - '
                            .'Delete it in the appropriate section');
                    } else {
                        $sdbquery = $mysqli->query("DELETE FROM demo WHERE demo_id = '$demo_id' ")
                            or die("Error deleting demo");
                        $sdbquery = $mysqli->query("DELETE FROM crew_demo_prod WHERE demo_id = '$demo_id'")
                            or die("Error deleting crew_demo_prod");
                        $sdbquery = $mysqli->query("DELETE FROM ind_demo_prod WHERE demo_id = '$demo_id' ")
                            or die("Error deleting ind_demo_prod");
                        $sdbquery = $mysqli->query("DELETE FROM demo_year WHERE demo_id = '$demo_id' ")
                            or die("Error deleting demo_year");
                        $sdbquery = $mysqli->query("DELETE FROM demo_cat_cross WHERE demo_id = '$demo_id' ")
                            or die("Error deleting demo_cat_cross");
                        $sdbquery = $mysqli->query("DELETE FROM demo_falcon_only WHERE demo_id='$demo_id'")
                            or die("Error deleting demo_falcon_only");
                        $sdbquery = $mysqli->query("DELETE FROM demo_ste_enhan WHERE demo_id='$demo_id'")
                            or die("Error deleting demo_ste_enhan");
                        $sdbquery = $mysqli->query("DELETE FROM demo_ste_only WHERE demo_id='$demo_id'")
                            or die("Error deleting demo_ste_only");
                        $sdbquery = $mysqli->query("DELETE FROM demo_aka WHERE demo_id='$demo_id'")
                            or die("Error deleting demo_aka");
                        $sdbquery = $mysqli->query("DELETE FROM demo_info WHERE demo_id='$demo_id'")
                            or die("Error deleting demo_info");
                        $sdbquery = $mysqli->query("DELETE FROM demo_emulator WHERE demo_id='$demo_id'")
                            or die("Error deleting demo_emulator");
                        $sdbquery = $mysqli->query("DELETE FROM demo_author WHERE demo_id='$demo_id'")
                            or die("Error deleting demo_author");

                        // DUMP TABLE
                        $sdbquery = $mysqli->query("DELETE FROM demo_search WHERE game_id = '$demo_id' ");

                        //Get the crews to fill the search fields
                        $sql_crew = $mysqli->query("SELECT * FROM crew ORDER BY crew_name ASC")
                            or die("Couldn't query Crews database");

                        while ($crew = $sql_crew->fetch_array(MYSQLI_BOTH)) {
                            $smarty->append('crew', array(
                                'crew_id' => $crew['crew_id'],
                                'crew_name' => $crew['crew_name']
                            ));
                        }

                        $smarty->assign("message", 'Demo has been deleted succesfully');

                        header("Location: ../demos/demos_main.php");
                        //close the connection
                        mysqli_free_result();
                    }
                }
            }
        }
    }
}

//**********************************************************************************
//Send it all to the template
//**********************************************************************************

$smarty->assign("demo_id", $demo_id);
$smarty->assign("user_id", $_SESSION['user_id']);
$smarty->assign('demo_detail_tpl', '1');

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "index.html");

//close the connection
mysqli_close($mysqli);
