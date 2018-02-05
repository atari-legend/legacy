<?php
/***************************************************************************
 *                                demos_music_detail.php
 *                            ------------------------------
 *   begin                : saturday, November 19, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *                         Created file
 *
 *   Id: demos_music_detail.php,v 0.10 2005/11/19 ST Graveyard
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

/*
 ***********************************************************************************
 This is the demo music detail page.
 ***********************************************************************************
 */

if (isset($action) and $action == 'play_music') {
    $query_music = $mysqli->query("SELECT * FROM music
                            WHERE music.music_id='$music_id'");

    $sql_music = $query_music->fetch_array(MYSQLI_BOTH);

    $filename = "$music_demo_path$sql_music[music_id].$sql_music[imgext]";

    $fp = fopen($filename, "rb");

    header("Content-Type: $sql_music[mime_type]");
    header("Content-Length: " . filesize($filename));

    if ($sql_music[imgext] == 'mod') {
        header('Content-Disposition: attachment; filename="music.mod"');
    }
    if ($sql_music[imgext] == 'ym') {
        header('Content-Disposition: attachment; filename="music.ym"');
    }
    if ($sql_music[imgext] == 'snd') {
        header('Content-Disposition: attachment; filename="music.snd"');
    }
    if ($sql_music[imgext] == 'mp3') {
        header('Content-Disposition: attachment; filename="music.mp3"');
    }

    fpassthru($fp);
    exit;
}

if (isset($action) and $action == 'pick_composer') {
    if ($individuals == '-') {
        $smarty->assign('message', 'Please pick a composer or add one in the detail page');
    } else {
        $smarty->assign('action', 'pick_composer');

        //We need to get all the info of this game.
        $SQL_IND = $mysqli->query("SELECT *
                                 FROM individuals
                                 WHERE ind_id='$individuals'") or die("Error getting ind name");

        while ($IND = $SQL_IND->fetch_array(MYSQLI_BOTH)) {
            $smarty->assign('ind_selected', array(
                'ind_id' => $IND['ind_id'],
                'ind_name' => $IND['ind_name']
            ));
        }
    }
}

//We need to get all the info of this game.
$SQL_DEMO = $mysqli->query("SELECT demo.demo_name,
                           demo.demo_id
                           FROM demo
                           WHERE demo.demo_id='$demo_id'") or die("Error getting demo info");

while ($DEMO = $SQL_DEMO->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('demo', array(
        'demo_id' => $DEMO['demo_id'],
        'demo_name' => $DEMO['demo_name']
    ));
}

//get the music info
$sql_music = $mysqli->query("SELECT * FROM demo_music
                            LEFT JOIN music ON (demo_music.music_id = music.music_id)
                            LEFT JOIN music_author ON (music.music_id = music_author.music_id)
                            LEFT JOIN individuals ON (music_author.ind_id = individuals.ind_id)
                            LEFT JOIN music_types ON (music.music_id = music_types.music_id)
                            LEFT JOIN music_types_main ON (music_types.music_types_main_id = music_types_main.music_types_main_id)
                            WHERE demo_music.demo_id='$demo_id'");
$i         = 0;
while ($MUSIC = $sql_music->fetch_array(MYSQLI_BOTH)) {
    $i++;

    $smarty->append('music', array(
        'music_id' => $MUSIC['music_id'],
        'ind_name' => $MUSIC['ind_name'],
        'extention' => $MUSIC['extention']
    ));
}

$smarty->assign('nr_of_zaks', $i);

//get the individuals

$SQL_MUSICIAN = $mysqli->query("SELECT *
                           FROM demo_author
                           LEFT JOIN author_type ON ( demo_author.author_type_id = author_type.author_type_id )
                           LEFT JOIN demo ON ( demo_author.demo_id = demo.demo_id )
                           LEFT JOIN individuals ON ( demo_author.ind_id = individuals.ind_id )
                           WHERE demo.demo_id='$demo_id'
                           AND author_type.author_type_info = 'music'") or die("Error getting demo musician");
$i = 0;

while ($MUSICIAN = $SQL_MUSICIAN->fetch_array(MYSQLI_BOTH)) {
    $i++;

    $smarty->append('ind', array(
        'ind_id' => $MUSICIAN['ind_id'],
        'ind_name' => $MUSICIAN['ind_name']
    ));
}

if ($i == 0) {
    $message = "No musician attached to this demo, go to the detail pages to add a musician first";
    $smarty->assign("message", $message);
} elseif (empty($individuals) or $individuals !== '-') {
    $message = "To add more musicians, just click the demo name in the header to go to the detail pages of this demo";
    $smarty->assign("message", $message);
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "demos_music_detail.html");

//close the connection
mysqli_close($mysqli);
