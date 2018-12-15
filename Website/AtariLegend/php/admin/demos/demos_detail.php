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
// This is the detail page of a demo. Change all the specifics over here!
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//***********************************************************************************
//Let's get the general demo info first.
//***********************************************************************************

$sql_demo = $mysqli->query("SELECT
                           demo.demo_name,
                           demo.demo_id,
                           demo_ste_only.ste_only,
                           demo_ste_enhan.ste_enhanced,
                           demo_falcon_only.falcon_only,
                           demo_falcon_enhan.falcon_enhanced,
                           demo_mono_only.mono_only,
                           demo_year.demo_year
                           FROM demo
                           LEFT JOIN demo_ste_only ON (demo.demo_id = demo_ste_only.demo_id)
                           LEFT JOIN demo_ste_enhan ON (demo.demo_id = demo_ste_enhan.demo_id)
                           LEFT JOIN demo_falcon_only ON (demo.demo_id = demo_falcon_only.demo_id)
                           LEFT JOIN demo_falcon_enhan ON (demo.demo_id = demo_falcon_enhan.demo_id)
                           LEFT JOIN demo_mono_only ON (demo.demo_id = demo_mono_only.demo_id)
                           LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
                           WHERE demo.demo_id='$demo_id'") or die("Error getting demo info");

while ($demo_info = $sql_demo->fetch_array(MYSQLI_BOTH)) {
    $demo_year = $demo_info['demo_year'];
    $demo_year .= '01';
    $demo_year .= '01';
    $url_demo_name = rawurlencode($demo_info['demo_name']);

    $smarty->assign('demo_info', array(
        'demo_name' => $demo_info['demo_name'],
        'demo_year' => $demo_year,
        'url_demo_name' => $url_demo_name,
        'demo_id' => $demo_info['demo_id'],
        'demo_ste_only' => $demo_info['ste_only'],
        'demo_ste_enhan' => $demo_info['ste_enhanced'],
        'demo_falcon_only' => $demo_info['falcon_only'],
        'demo_falcon_enhan' => $demo_info['falcon_enhanced'],
        'demo_mono_only' => $demo_info['mono_only']
    ));
}

//***********************************************************************************
//get the game categories & the categories already selected for this game
//***********************************************************************************

$sql_categories = $mysqli->query("SELECT * FROM demo_cat ORDER BY demo_cat_name") or die("Error loading categories");

while ($categories = $sql_categories->fetch_array(MYSQLI_BOTH)) {
    $sql_demo_cat = $mysqli->query("SELECT * FROM demo_cat_cross WHERE demo_id='$demo_id'
        AND demo_cat_id=$categories[demo_cat_id]") or die("Error loading categorie cross table");

    $selected = $sql_demo_cat->num_rows;
    if ($selected == 1) {
        $selected = 'selected';
    } else {
        $selected = '';
    }

    $smarty->append('cat', array(
        'cat_id' => $categories['demo_cat_id'],
        'cat_name' => $categories['demo_cat_name'],
        'cat_selected' => $selected
    ));
}

//**********************************************************************************
//Get the author info
//**********************************************************************************

//Get the individuals
$sql_individuals     = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
$sql_individuals_aka = "SELECT ind_id,nick as ind_name FROM individual_nicks ORDER BY nick ASC";

//Create a temporary table to build an array with both names and nicknames
$mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
$mysqli->query("INSERT INTO temp $sql_individuals_aka") or die("failed to insert akas into temporary table");

$query_temporary = $mysqli->query("SELECT * FROM temp ORDER BY ind_name ASC") or die("Failed to query temporary table");
$mysqli->query("DROP TABLE temp");

while ($individuals = $query_temporary->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('individuals', array(
        'ind_id' => $individuals['ind_id'],
        'ind_name' => $individuals['ind_name']
    ));
}

// Get the author types
$sql_author = $mysqli->query("SELECT * FROM author_type ORDER BY author_type_info ASC")
    or die("Couldn't query author_types");

while ($author = $sql_author->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('author_types', array(
        'author_type' => $author['author_type_info'],
        'author_type_id' => $author['author_type_id']
    ));
}

//Starting off with displaying the authors that are linked to the game and having a delete option for them */
$sql_demoauthors = $mysqli->query("SELECT * FROM demo_author
    LEFT JOIN individuals ON (demo_author.ind_id = individuals.ind_id)
    LEFT JOIN author_type ON (demo_author.author_type_id = author_type.author_type_id)
    WHERE demo_author.demo_id='$demo_id' ORDER BY author_type.author_type_id, individuals.ind_name")
    or die("Error loading authors");

while ($demo_author = $sql_demoauthors->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('demo_author', array(
        'demo_author_id' => $demo_author['demo_author_id'],
        'ind_name' => $demo_author['ind_name'],
        'ind_id' => $demo_author['ind_id'],
        'auhthor_type_info' => $demo_author['author_type_info']
    ));

    $smarty->assign("demo_author_nr", '1');
}

//**********************************************************************************
//Get the crew info
//**********************************************************************************

//let's get all the crews in the DB
$sql_crew = $mysqli->query("SELECT * FROM crew ORDER BY crew_name ASC") or die("Couldn't query crew database");

while ($crew = $sql_crew->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('crew', array(
        'crew_id' => $crew['crew_id'],
        'crew_name' => $crew['crew_name']
    ));
}

//let's get the crew for this demo
$sql_crew = $mysqli->query("SELECT * FROM crew
    LEFT JOIN crew_demo_prod ON ( crew.crew_id = crew_demo_prod.crew_id )
    WHERE crew_demo_prod.demo_id = '$demo_id' ORDER BY crew_name ASC")or die("Couldn't query publishers");

while ($crew = $sql_crew->fetch_array(MYSQLI_BOTH)) {
    $url_crew_name = rawurlencode($crew['crew_name']);

    $smarty->append('demo_crew', array(
        'crew_id' => $crew['crew_id'],
        'crew_name' => $crew['crew_name'],
        'url_crew_name' => $url_crew_name
    ));

    $smarty->assign("demo_crew_nr", '1');
}

//***********************************************************************************
//AKA's
//***********************************************************************************

$sql_aka = $mysqli->query("SELECT * FROM demo_aka WHERE demo_id='$demo_id'") or die("Couldn't query aka demos");

$nr_aka = 0;

while ($aka = $sql_aka->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('aka', array(
        'demo_aka_name' => $aka['aka_name'],
        'demo_id' => $aka['demo_id'],
        'demo_aka_id' => $aka['demo_aka_id']
    ));
    $nr_aka++;
}

$smarty->assign("nr_aka", $nr_aka);

//***********************************************************************************
//The game statistics below on the page
//***********************************************************************************

//Get the number of screenshots!
$numberscreen = $mysqli->query("SELECT count(*) as count FROM screenshot_demo WHERE demo_id = '$demo_id'")
    or die("couldn't get number of screenshots");
$array = $numberscreen->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_screenshots", $array['count']);

//check how many music files this game has
$numbermusic = $mysqli->query("SELECT count(*) as count FROM demo_music WHERE demo_id = '$demo_id'")
    or die("couldn't get number of music files");
$array = $numbermusic->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_music", $array['count']);

//**********************************************************************************
//Send it all to the template
//**********************************************************************************

$smarty->assign("demo_id", $demo_id);
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "demos_detail.html");

//close the connection
mysqli_close($mysqli);
