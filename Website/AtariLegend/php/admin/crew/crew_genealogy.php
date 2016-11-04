<?php
/***************************************************************************
 *                                crew_genealogy.php
 *                            --------------------------
 *   begin                : Sunday, August 28, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: crew_genealogy.php,v 0.10 2005/10/29 Silver
 *   Id: crew_genealogy.php,v 0.20 2016/10/04 STG
 *            - CPANEL 2.0
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the crew page contructor
 ***********************************************************************************
 */

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");
include("../../includes/quick_search_games.php");

if (isset($new_crew)) {
    $smarty->assign('new_crew', $new_crew);
}

if ($crewsearch != '' and $crewbrowse == '') {
    $sql_crew = $mysqli->query("SELECT * FROM crew
                    WHERE crew_name LIKE '%$crewsearch%'
                    ORDER BY crew_name ASC") or die("Couldn't query Crew database");

    while ($crew = $sql_crew->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('crew', array(
            'crew_id' => $crew['crew_id'],
            'crew_name' => $crew['crew_name']
        ));
    }
} elseif ($crewbrowse != '' and $crewsearch == '') {
    $sql_crew = $mysqli->query("SELECT * FROM crew
                WHERE crew_name LIKE '$crewbrowse%'
                ORDER BY crew_name ASC") or die("Couldn't query Crew database");

    while ($crew = $sql_crew->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('crew', array(
            'crew_id' => $crew['crew_id'],
            'crew_name' => $crew['crew_name']
        ));
    }
}

if (isset($crew_select)) {
    // Do query for crew data
    $sql_crew = $mysqli->query("SELECT * FROM crew
                        WHERE crew_id = '$crew_select'") or die("Couldn't query Crew database");

    $crew = $sql_crew->fetch_array(MYSQLI_BOTH);

    $crew_history = stripslashes($crew['crew_history']);

    $smarty->assign('crew_select', array(
        'crew_id' => $crew_select,
        'crew_name' => $crew['crew_name'],
        'crew_logo' => $crew['crew_logo'],
        'crew_history' => $crew_history
    ));
}

// set values for genealogy edit of crew...
if (isset($action) and $action == "genealogy") {
    $smarty->assign('crew_action', array(
        'action' => $action
    ));

    $sql_crewgene = $mysqli->query("SELECT * FROM crew WHERE crew_name REGEXP '^[0-9].*'
                        ORDER BY crew_name") or die("Couldn't query Crew database");

    while ($genealogy = $sql_crewgene->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('crew_gene', array(
            'crew_id' => $genealogy['crew_id'],
            'crew_name' => $genealogy['crew_name']
        ));
    }

    $sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
    $sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

    //Create a temporary table to build an array with both names and nicknames
    $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
    $mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");

    $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE 'a%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
    $mysqli->query("DROP TABLE temp");


    while ($genealogy_ind = $query_temporary->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('ind_gene', array(
            'ind_id' => $genealogy_ind['ind_id'],
            'ind_name' => $genealogy_ind['ind_name']
        ));
    }

    // member of crew - subcrew query
    $sql_subcrew = $mysqli->query("SELECT * FROM sub_crew
                                LEFT JOIN crew ON (sub_crew.crew_id = crew.crew_id)
                                WHERE sub_crew.parent_id='$crew_select'
                                ORDER BY crew.crew_name") or die("Couldn't query Crew database");

    while ($fetch_subcrew = $sql_subcrew->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('subcrew', array(
            'sub_crew_id' => $fetch_subcrew['sub_crew_id'],
            'crew_id' => $fetch_subcrew['crew_id'],
            'crew_name' => $fetch_subcrew['crew_name']
        ));
    }

    $crew_individuals = array();
    // member of crew - individuals query
    $sql_crewind = $mysqli->query("SELECT * FROM crew_individual
                                LEFT JOIN individuals ON (crew_individual.ind_id = individuals.ind_id)
                                WHERE crew_individual.crew_id='$crew_select'
                                ORDER BY individuals.ind_name") or die("Couldn't query ind database");
    $crew_individual = array();

    while ($fetch_member = $sql_crewind->fetch_array(MYSQLI_BOTH)) {
        //$crew_individual = array();
        $crew_individual['crew_individual_id']  = $fetch_member['crew_individual_id'];
        $crew_individual['ind_id']              = $fetch_member['ind_id'];
        $crew_individual['ind_name']            = $fetch_member['ind_name'];
        $crew_individual['individual_nicks_id'] = $fetch_member['individual_nicks_id'];

        $crew_individuals[] = $crew_individual;
    }
    $smarty->assign('crew_individuals', $crew_individuals);


    //Build a list of known nicknames for the crew members
    $sql_ind_nicks = $mysqli->query("SELECT
                                  individual_nicks.individual_nicks_id,
                                  individual_nicks.ind_id,
                                  individual_nicks.nick
                                  FROM individual_nicks
                                  LEFT JOIN crew_individual ON (individual_nicks.ind_id = crew_individual.ind_id)
                                  WHERE crew_individual.crew_id = '$crew_select'") or die("Couldn't retrieve nick names");

    while ($fetch_ind_nicks = $sql_ind_nicks->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('nick_names', array(
            'individual_nicks_id' => $fetch_ind_nicks['individual_nicks_id'],
            'ind_id' => $fetch_ind_nicks['ind_id'],
            'nick' => $fetch_ind_nicks['nick']
        ));
    }
} else {
    if ($crewsearch == '' and $crewbrowse == '') {
        $_SESSION['edit_message'] = "Please select a crew";
        header("Location: ../crew/crew_main.php?message=$message");
    }
}

// If no choice has been made but a crew has been selected we should be brought to the crew main edit regardless
if (empty($action)) {
    $action = "main";
    $smarty->assign('crew_action', array(
        'action' => $action
    ));
}


// Search variables that got to be sent with the headers all through this module or else the code will dump the user back to the crew_main.php
$smarty->assign('tracking', array(
    'crewsearch' => $crewsearch,
    'crewbrowse' => $crewbrowse
));

// Create dropdown values a-z
$az_value  = az_dropdown_value(0);
$az_output = az_dropdown_output(0);

$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "crew_genealogy.html");

//close the connection
mysqli_close($mysqli);
