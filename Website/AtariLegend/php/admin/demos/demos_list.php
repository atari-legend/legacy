<?php
/***************************************************************************
 *                                demos_main.php
 *                            --------------------------
 *   begin                : Sunday, October 30, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: demos_main.php,v 0.10 2005/10/30 12.30 Gatekeeper
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the demo browse page where you can navigate your way through the demo db
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

$start1 = gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));

/*
 ***********************************************************************************
 Firstly , we are gonna check which parts of the search functions are used in the main
 screen and we're gonna fill some extra variables accordingly. These variables will be
 used to create the querystring later.
 ***********************************************************************************
 */

if (isset($action) and $action == "search") {
    //check the $gamebrowse select
    if (empty($demobrowse) or $demobrowse == '-') {
        $demobrowse_select = "";
        $akabrowse_select  = "";
    } elseif ($demobrowse == 'num') {
        $demobrowse_select = "demo_name REGEXP '^[0-9].*' AND ";
        $akabrowse_select  = "demo_aka.aka_name REGEXP '^[0-9].*' AND ";
    } else {
        $demobrowse_select = "demo_name LIKE '$demobrowse%' AND ";
        $akabrowse_select  = "demo_aka.aka_name LIKE '$demobrowse%' AND ";
    }

    //check the crew select
    if (empty($crew) or $crew == '-') {
        $crew_select = "";
    } elseif ($crew == "null") {
        $crew_select = " AND crew.crew_id IS NULL";
    } else {
        $crew_select = " AND crew.crew_id = $crew";
    }

    //check to see if the year has been clicked
    if (isset($year)) {
        $year_select = " AND demo_year LIKE '$year%'";
    } else {
        $year_select = "";
    }
    if (empty($demosearch)) {
        $demosearch = "";
    }

    //Before we start the build the query, we check if there is at least
    //one search field filled in or used!

    if (empty($crew_select) and empty($demobrowse_select) and empty($demosearch) and empty($year_select)) {
        $message = "Please fill in one of the fields";
        $smarty->assign("message", $message);

        header("Location: ../demos/demos_main.php");
    } else {
        /*
         ***********************************************************************************
         Now we're gonna start building the querystring. First we'll be checking of we are
         searching on a crew only, an individual only, or if we are using a combination
         of search features. If we are searching for a crew or ind only, we create a different
         querystring for faster output
         ***********************************************************************************
         */

        $RESULTDEMO = "SELECT  demo.demo_id,
                               demo.demo_name,
                               demo_year.demo_year,
                               screenshot_demo.screenshot_id,
                               demo_music.music_id,
                               demo_download.demo_download_id,
                               demo_falcon_only.falcon_only,
                               crew.crew_id,
                               crew.crew_name,
                               demo_ste_enhan.ste_enhanced
                       FROM demo
                       LEFT JOIN demo_year ON (demo_year.demo_id = demo.demo_id)
                       LEFT JOIN screenshot_demo ON (screenshot_demo.demo_id = demo.demo_id)
                       LEFT JOIN demo_music ON (demo_music.demo_id = demo.demo_id)
                       LEFT JOIN demo_download ON (demo_download.demo_id = demo.demo_id)
                       LEFT JOIN demo_falcon_only ON (demo_falcon_only.demo_id = demo.demo_id)
                       LEFT JOIN crew_demo_prod ON (crew_demo_prod.demo_id = demo.demo_id)
                       LEFT JOIN crew ON (crew.crew_id = crew_demo_prod.crew_id)
                       LEFT JOIN demo_ste_enhan ON (demo_ste_enhan.demo_id = demo.demo_id)
                       WHERE ";

        $RESULTDEMO .= $demobrowse_select;
        $RESULTDEMO .= "demo_name LIKE '%$demosearch%'";
        $RESULTDEMO .= $crew_select;
        $RESULTDEMO .= $year_select;
        $RESULTDEMO .= ' GROUP BY demo.demo_id, demo.demo_name
            HAVING COUNT(DISTINCT demo.demo_id, demo.demo_name ) = 1';
        $RESULTDEMO .= ' ORDER BY demo_name ASC';

        //echo $RESULTDEMO;
        //exit;

        $demos = $mysqli->query($RESULTDEMO) or die('problem with the demo query');

        if (!$demos) {
            $message = "There are problems with the demo querie, please try again";
            $smarty->assign("message", $message);

            header("Location: ../demos/demos_main.php");
        } else {
            $rows = $demos->num_rows;
            if ($rows > 0) {
                $RESULTAKA = "SELECT
                               demo_aka.demo_id,
                               demo_aka.aka_name,
                               demo_year.demo_year,
                               screenshot_demo.screenshot_id,
                               demo_music.music_id,
                               demo_download.demo_download_id,
                               demo_falcon_only.falcon_only,
                               crew.crew_id,
                               crew.crew_name,
                               demo_ste_enhan.ste_enhanced
                       FROM demo_aka
                       LEFT JOIN demo ON (demo_aka.demo_id = demo.demo_id)
                       LEFT JOIN screenshot_demo ON (screenshot_demo.demo_id = demo.demo_id)
                       LEFT JOIN demo_music ON (demo_music.demo_id = demo.demo_id)
                       LEFT JOIN demo_download ON (demo_download.demo_id = demo.demo_id)
                       LEFT JOIN demo_falcon_only ON (demo_falcon_only.demo_id = demo.demo_id)
                       LEFT JOIN demo_year ON (demo_year.demo_id = demo.demo_id)
                       LEFT JOIN crew_demo_prod ON (crew_demo_prod.demo_id = demo.demo_id)
                       LEFT JOIN crew ON (crew.crew_id = crew_demo_prod.crew_id)
                       LEFT JOIN demo_ste_enhan ON (demo_ste_enhan.demo_id = demo.demo_id)
                       WHERE ";

                $RESULTAKA .= $akabrowse_select;
                $RESULTAKA .= "demo_aka.aka_name LIKE '%$demosearch%'";
                $RESULTAKA .= $crew_select;
                $RESULTAKA .= $year_select;
                $RESULTAKA .= ' GROUP BY demo_aka.demo_id, demo_aka.aka_name
                    HAVING COUNT(DISTINCT demo_aka.demo_id, demo_aka.aka_name) = 1';
                $RESULTAKA .= ' ORDER BY demo_aka.aka_name ASC';

                $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $RESULTDEMO") or die("does not compute");
                $mysqli->query("INSERT INTO temp $RESULTAKA") or die("does not compute2");

                $temp_query = $mysqli->query("SELECT * FROM temp ORDER BY demo_name ASC") or die("does not compute3");

                $end1       = gettimeofday();
                $totaltime1 = (float) ($end1['sec'] - $start1['sec'])
                    + ((float) ($end1['usec'] - $start1['usec']) / 1000000);

                list($end2, $end3) = explode(":", exec('date +%N:%S'));
                $totaltime2 = (float) ($end3 - $start3) + ((float) ($end2 - $start2) / 1000000000);

                $i = 0;

                while ($sql_demo_search = $temp_query->fetch_array(MYSQLI_BOTH)) {
                    $i++;

                    $smarty->append('demo_search', array(
                        'demo_id' => $sql_demo_search['demo_id'],
                        'demo_name' => $sql_demo_search['demo_name'],
                        'crew_id' => $sql_demo_search['crew_id'],
                        'crew_name' => $sql_demo_search['crew_name'],
                        'year' => $sql_demo_search['demo_year'],
                        //'music' => $sql_demo_search['music'],
                        'download' => $sql_demo_search['demo_download_id'],
                        'ste_enhan' => $sql_demo_search['ste_enhanced'],
                        'screenshot' => $sql_demo_search['screenshot_id']
                    ));
                }

                $smarty->assign("nr_of_demos", $i);
                $smarty->assign("query_time", $totaltime1);

                $mysqli->query("DROP TABLE temp") or die("does not compute4");

                $smarty->assign("user_id", $_SESSION['user_id']);

                //Send all smarty variables to the templates
                $smarty->display("file:" . $cpanel_template_folder . "demos_list.html");
            } else {
                $message = "No entries found for your selection";
                $smarty->assign("message", $message);

                header("Location: ../demos/demos_main.php");
            }
        }
    }
}
//close the connection
mysqli_close($mysqli);
