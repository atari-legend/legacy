<?php
/***************************************************************************
 *                                ajax_crew_search.php
 *                            --------------------------
 *   begin                : Sunday, August 28, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: ajax_crew_search.php,v 0.10 2005/10/29 Silver
 *   Id: ajax_crew_search.php,v 0.20 2016/10/04 STG
 *            - CPANEL 2.0
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the crew page contructor
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

if (isset($action) and $action == "crew_browse") {
    if ($query == "num") {
        $sql_crew = $mysqli->query("SELECT * FROM crew
                WHERE crew_name REGEXP '^[0-9].*'
                ORDER BY crew_name ASC") or die("Couldn't query Crew database");
    } else {
        $sql_crew = $mysqli->query("SELECT * FROM crew
                WHERE crew_name LIKE '$query%'
                ORDER BY crew_name ASC") or die("Couldn't query Crew database");
    }

    $smarty->assign('smarty_action', 'crew_list');
    $smarty->assign('crewbrowse', '$query');

    while ($query_crew = $sql_crew->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of crews
        $smarty->append('crew', array(
            'crew_id' => $query_crew['crew_id'],
            'crew_name' => $query_crew['crew_name']
        ));
    }
    $smarty->display("file:" . $cpanel_template_folder . "ajax_crew_editor.html");
}

if (isset($action) and $action == "crew_search") {
    $sql_crew = $mysqli->query("SELECT * FROM crew
                WHERE crew_name LIKE '%$query%'
                ORDER BY crew_name ASC") or die("Couldn't query Crew database");

    $smarty->assign('smarty_action', 'crew_list');
    $smarty->assign('crewsearch', '$query');

    while ($query_crew = $sql_crew->fetch_array(MYSQLI_BOTH)) {
        // This smarty is used for creating the list of crews
        $smarty->append('crew', array(
            'crew_id' => $query_crew['crew_id'],
            'crew_name' => $query_crew['crew_name']
        ));
    }

    $smarty->display("file:" . $cpanel_template_folder . "ajax_crew_editor.html");
}

if (isset($action) and $action == "crew_gen_browse") {
    if ($query == "num") {
        $sql_crew = $mysqli->query("SELECT * FROM crew
        WHERE crew_name REGEXP '^[0-9].*'
        ORDER BY crew_name ASC") or die("Couldn't query Crew database");
    } else {
        $sql_crew = $mysqli->query("SELECT * FROM crew
        WHERE crew_name LIKE '$query%'
        ORDER BY crew_name ASC") or die("Couldn't query Crew database");
    }

    echo '<select name="sub_crew[]" id="quick_search_pub_select">';
    echo '<option value="" SELECTED>-</option>';

    while ($crew = $sql_crew->fetch_array(MYSQLI_BOTH)) {
        $crew_id   = $crew['crew_id'];
        $crew_name = $crew['crew_name'];

        echo "<option value=\"$crew_id\">$crew_name</option>";
    }
    echo '</select>';
}

if (isset($action) and $action == "ind_gen_browse") {
    if (isset($query)) {

        $sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
        //$sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

        //Create a temporary table to build an array with both names and nicknames
        $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
        //$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");

        $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '$query%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
        $mysqli->query("DROP TABLE temp");
    }

    echo '<SELECT name="ind_id" id="quick_search_pub_select">';
    echo '<option value="" SELECTED>-</option>';

    while ($genealogy_ind = $query_temporary->fetch_array(MYSQLI_BOTH)) {
        $ind_id   = $genealogy_ind['ind_id'];
        $ind_name = $genealogy_ind['ind_name'];

        echo "<option value=\"$ind_id\">$ind_name</option>";
    }
    echo '</select>';
}

if (isset($action) and $action == "ind_gen_search") {
    if (isset($query) and $query !== "empty") {
        $sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
        //$sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

        //Create a temporary table to build an array with both names and nicknames
        $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
        //$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");

        $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '%$query%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
        $mysqli->query("DROP TABLE temp");
    } elseif ($query == "empty") {
        $sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
        //$sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

        //Create a temporary table to build an array with both names and nicknames
        $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
        //$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");

        $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '%a%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
        $mysqli->query("DROP TABLE temp");
    }

    echo '<SELECT name="ind_id" id="quick_search_pub_select">';
    echo '<option value="" SELECTED>-</option>';
    while ($genealogy_ind = $query_temporary->fetch_array(MYSQLI_BOTH)) {
        $ind_id   = $genealogy_ind['ind_id'];
        $ind_name = $genealogy_ind['ind_name'];

        echo "<option value=\"$ind_id\">$ind_name</option>";
    }
    echo '</select>';
}

//close the connection
mysqli_close($mysqli);
