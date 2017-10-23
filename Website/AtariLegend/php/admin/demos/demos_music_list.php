<?php
/***************************************************************************
 *                                demos_music.php
 *                            --------------------------
 *   begin                : saturday, November 19, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *                         Created file
 *
 *   Id: demos_music.php,v 0.10 2005/11/19 ST Graveyard
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

/*
 ************************************************************************************************
 This is the demo music main page
 ************************************************************************************************
 */
$start1 = gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));

if (isset($action) and $action == 'search') {
    //check the $gamebrowse select
    if ($demobrowse == "") {
        $demobrowse_select = "";
    } elseif ($demobrowse == '-') {
        $demobrowse_select = "";
    } elseif ($demobrowse == 'num') {
        $demobrowse_select = "demo.demo_name REGEXP '^[0-9].*' AND ";
    } else {
        $demobrowse_select = "demo.demo_name LIKE '$demobrowse%' AND ";
    }

    //Before we start the build the query, we check if there is at least
    //one search field filled in or used!

    if ($demobrowse_select == "" and $demosearch == "") {
        $_SESSION['edit_message'] = "Please fill in one of the search fields!";

        //Send back to the demos_music.php if nothing have been searched
        header("Location: ../demos/demos_music.php");

        //close the connection
        mysqli_close($mysqli);
    } else {
        //In all cases we search we start searching through the demo table
        //first
        $RESULTDEMO = "SELECT
                    demo.demo_id,
                    demo.demo_name,
                    crew.crew_name,
                    crew.crew_id,
                    demo_year.demo_year
                    FROM demo
                    LEFT JOIN crew_demo_prod ON ( demo.demo_id = crew_demo_prod.demo_id )
                    LEFT JOIN crew ON ( crew_demo_prod.crew_id = crew.crew_id )
                    LEFT JOIN demo_year ON ( demo_year.demo_id = demo.demo_id ) WHERE ";

        $RESULTDEMO .= $demobrowse_select;
        $RESULTDEMO .= "demo.demo_name LIKE '%$demosearch%'";
        $RESULTDEMO .= ' ORDER BY demo.demo_name ASC';

        $demos = $mysqli->query($RESULTDEMO);

        if (!$demos) {
            echo "Couldn't query demos database for demos starting with a certain number";
        } else {
            $rows = $demos->num_rows;
            if ($rows > 0) {
                $i = 1;
                while ($row = $demos->fetch_array(MYSQLI_BOTH)) {
                    $i++;

                    //check how many muzaks there are for the game
                    $numberzaks = $mysqli->query("SELECT count(*) as count FROM demo_music WHERE demo_id='$row[demo_id]'") or die("couldn't get number of zaks");

                    $array = $numberzaks->fetch_array(MYSQLI_BOTH);

                    $smarty->append('music', array(
                        'demo_id' => $row['demo_id'],
                        'demo_name' => $row['demo_name'],
                        'demo_crew' => $row['crew_name'],
                        'demo_year' => $row['demo_year'],
                        'number_zaks' => $array['count']
                    ));
                }

                $end1       = gettimeofday();
                $totaltime1 = (float) ($end1['sec'] - $start1['sec']) + ((float) ($end1['usec'] - $start1['usec']) / 1000000);

                $smarty->assign('querytime', $totaltime1);
                $smarty->assign('nr_of_entries', $i);

                //Send all smarty variables to the templates
                $smarty->display("file:" . $cpanel_template_folder . "demos_music_list.html");

                //close the connection
                mysqli_close($mysqli);
            } else {
                $_SESSION['edit_message'] = "No result for your search!";
                //Send back to the demos_music.php if no results were generated
                header("Location: ../demos/demos_music.php");

                //close the connection
                mysqli_close($mysqli);
            }
        }
    }
}
