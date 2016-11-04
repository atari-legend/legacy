<?php
/***************************************************************************
 *                                demos_upload.php
 *                            ------------------------
 *   begin                : Saturday, november 12, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *   actual update        : Creation of file
 *
 *   Id: demos_upload.php,v 0.10 2005/11/12 17:15 ST Gravedigger
 *
 ***************************************************************************/

//****************************************************************************************
// This is the main page for the demo downloads.
//****************************************************************************************

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

//************************************************************************************************
//Let's get the demo info for the file name concatenation, and the download data for disks already
//uploaded
//************************************************************************************************
$SQL_DEMO_INFO = $mysqli->query("SELECT * FROM demo
                               LEFT JOIN crew_demo_prod ON (demo.demo_id = crew_demo_prod.demo_id)
                               LEFT JOIN crew ON (crew_demo_prod.crew_id = crew.crew_id)
                               LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
                               WHERE demo.demo_id='$demo_id'") or die("Error getting demo info");

$demo_info = $SQL_DEMO_INFO->fetch_array(MYSQLI_BOTH);

//get some basic demo info
$smarty->assign('demo', array(
    'demo_id' => $demo_id,
    'demo_name' => $demo_info['demo_name']
));

//get the existing downloads
$SQL_DOWNLOADS = $mysqli->query("SELECT * FROM demo_download WHERE demo_id='$demo_id'") or die("Error getting download info");

$nr_downloads = 1;

while ($downloads = $SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) {
    // first lets create the filenames
    $filename = "$demo_info[demo_name]";

    if ($demo_info['demo_year'] == '') {
        $filename .= " (19xx)";
    } else {
        $filename .= " ($demo_info[demo_year])";
    }
    if ($demo_info['crew_id'] !== '') {
        $filename .= "($demo_info[crew_name])";
    }
    if ($downloads['demo_ext'] == "stx") {
        $filename .= "[pasti]";
    }
    if ($downloads['demo_ext'] == "msa") {
        $filename .= "[MSA]";
    }
    if ($downloads['cracker'] !== "") {
        $filename .= "[cr $downloads[cracker]]";
    }
    if ($downloads['supplier'] !== "") {
        $filename .= "[su $downloads[supplier]]";
    }
    if ($downloads['screen'] !== "") {
        $filename .= "[$downloads[screen]]";
    }
    if ($downloads['language'] !== "") {
        $filename .= "[$downloads[language]]";
    }
    if ($downloads['trainer'] !== "") {
        $filename .= "[$downloads[trainer]]";
    }
    if ($downloads['legend'] == "1") {
        $filename .= "[AL]";
    }
    if ($downloads['disks'] !== "0" || $downloads['disks'] !== "") {
        $filename .= " Disk $downloads[disks]";
    }
    $filename .= ".zip";

    $filepath = $demo_file_path;
    $filepath .= $downloads['demo_download_id'];

    //convert the date
    $date = date("F j, Y", $downloads['date']);

    //start filling the smarty object
    $smarty->append('downloads', array(
        'demo_download_id' => $downloads['demo_download_id'],
        'cracker' => $downloads['cracker'],
        'supplier' => $downloads['supplier'],
        'intro' => $downloads['intro'],
        'harddrive' => $downloads['harddrive'],
        'pal_ntsc' => $downloads['screen'],
        'language' => $downloads['language'],
        'trainer' => $downloads['trainer'],
        'disks' => $downloads['disks'],
        'set_nr' => $downloads['set_nr'],
        'legend' => $downloads['legend'],
        'disable' => $downloads['disable'],
        'filename' => $filename,
        'filepath' => $filepath,
        'version' => $downloads['version'],
        'tos' => $downloads['tos'],
        'date' => $date
    ));
    $nr_downloads++;
}

$smarty->assign('nr_downloads', $nr_downloads);
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "demos_upload.html");

//close the connection
mysqli_close($mysqli);
